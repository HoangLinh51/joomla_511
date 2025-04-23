<?php
/* HueNN
 *
 * Created on Wed Jul 12 2023
 *
 * Copyright (c) 2023 (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Danhmuc\Administrator\Model;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\UserGroupsHelper;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Table\Table;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Groups Model
 *
 * @since  3.7.0
 */
class QuanhegdModel extends ListModel
{
    protected $_data = null;
    /**
     * Constructor
     *
     * @param   array                $config   An array of configuration options (name, state, dbo, table_path, ignore_request).
     * @param   MVCFactoryInterface  $factory  The factory.
     *
     * @since   3.7.0
     * @throws  \Exception
     */
    public function __construct($config = [], MVCFactoryInterface $factory = null)
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = [
                'code',
                'a.code',
                'name',
                'a.name'
            ];
        }

        parent::__construct($config, $factory);
    }

    /**
     * Method to get a table object, load it if necessary.
     *
     * @param   string  $name     The table name. Optional.
     * @param   string  $prefix   The class prefix. Optional.
     * @param   array   $options  Configuration array for model. Optional.
     *
     * @return  Table  A Table object
     *
     * @since   3.7.0
     * @throws  \Exception
     */
    public function getTable($type = 'Quanhegd', $prefix = 'Joomla\\Component\\Danhmuc\\Administrator\\Table\\', $config = [])
    {
        $return = Table::getInstance($type, $prefix, $config);

        return $return;
    }


    /**
     * Method to get a store id based on the model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param   string  $id  An identifier string to generate the store id.
     *
     * @return  string  A store id.
     *
     * @since   3.7.0
     */
    protected function getStoreId($id = '')
    {
        // Compile the store id.
        $id .= ':' . $this->getState('filter.search');

        return parent::getStoreId($id);
    }

    /**
     * Method to auto-populate the model state.
     *
     * This method should only be called once per instantiation and is designed
     * to be called on the first call to the getState() method unless the model
     * configuration flag to ignore the request is set.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @param   string  $ordering   An optional ordering field.
     * @param   string  $direction  An optional direction (asc|desc).
     *
     * @return  void
     *
     * @since   3.7.0
     */
    protected function populateState($ordering = 'a.code', $direction = 'asc')
    {
        // Load the parameters.
        $params = ComponentHelper::getParams('com_danhmuc');
        $this->setState('params', $params);

        // List state information.
        parent::populateState($ordering, $direction);
    }


    /**
     * Build an SQL query to load the list data.
     *
     * @return  \Joomla\Database\DatabaseQuery
     *
     * @since   2.5
     */
    protected function getListQuery()
    {
        // Create a new query object.
        $db    = $this->getDatabase();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
            $this->getState(
                'list.select',
                'a.*'
            )
        );
        $query->from($db->quoteName('danhmuc_quanhegiadinh') . ' AS a');
        $query->where('a.daxoa = 0');
        // Filter the comments over the search string if set.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'code:') === 0) {
                $query->where('a.code = ' . (int) substr($search, 3));
            } else {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('a.name LIKE ' . $search);
            }
        }
        $query->order($db->escape($this->getState('list.ordering', 'a.code')) . ' ' . $db->escape($this->getState('list.direction', 'ASC')));
        return $query;
    }

    /**
     * Method to get the record form.
     *
     * @param   array    $data      An optional array of data for the form to interrogate.
     * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
     *
     * @return  Form|bool  A Form object on success, false on failure
     *
     * @since   1.6
     */
    public function getForm($data = [], $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_danhmuc.quanhegd', 'quanhegd', ['control' => 'jform', 'load_data' => $loadData]);

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    /**
     * save
     *
     * @param  mixed $data
     * @return void
     */


     
    public function save($data, $pk = null)
    {
        $table      = $this->getTable();
        $input      = Factory::getApplication()->getInput();
        $pk         = (!empty($data['code'])) ? $data['code'] : (int) $this->getState($this->getName() . '.code');
        $isNew      = true;
        $context    = $this->option . '.' . $this->name;

        // Include the plugins for the save events.
        PluginHelper::importPlugin($this->events_map['save']);

        // Load the row if saving an existing category.
        if ($pk > 0) {
            $table->load($pk);
            $isNew = false;
        }

        // Check the data.
        if (!$table->check()) {
            $this->setError($table->getError());

            return false;
        }

        // Cách 1

        // Bind the data.
        if (!$table->bind($data)) {
            $this->setError($table->getError());

            return false;
        }
        // Store the data.
        if (!$table->store()) {
            $this->setError($table->getError());

            return false;
        }


    }

    public function getItem($pk = null)
    {
        $pk = (!empty($pk)) ? $pk : (int) Factory::getApplication()->input->getInt('code');
        $db = Factory::getDbo();

        $query = $db->getQuery(true);
        $query->select('code, name, level, status')->from('danhmuc_quanhegiadinh')->where('code = ' . $pk);
        $db->setQuery($query);
        return $db->loadObject();
    }

    public function loadFormData()
    {
        $app = Factory::getApplication();
        $pk = (int) $app->input->getInt('code', 0); // 'id' is usually used for primary key
        if ($pk > 0) {
            $data = $this->getItem($pk);
            if (!$data || !$data->code) {
                $filters = (array) $app->getUserState('com_danhmuc.quanhegd.filter');
                $data = (object) array_merge((array) $filters, (array) $data);
            }
            $this->preprocessData('com_danhmuc.quanhegd', $data);
        } else {
            $data = (array) $app->getUserState('com_danhmuc.quanhegd.filter', array());
        }
        return $data;
    }
}
