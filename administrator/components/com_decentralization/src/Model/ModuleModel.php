<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Decentralization\Administrator\Model;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Table\Table;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * User model.
 *
 * @since  1.6
 */
class ModuleModel extends AdminModel
{
    /**
     * An item.
     *
     * @var    array
     */
    protected $_item = null;

    /**
     * Constructor.
     *
     * @param   array                $config   An optional associative array of configuration settings.
     * @param   MVCFactoryInterface  $factory  The factory.
     *
     * @see     \Joomla\CMS\MVC\Model\BaseDatabaseModel
     * @since   3.2
     */
    public function __construct($config = [], MVCFactoryInterface $factory = null)
    {

        parent::__construct($config, $factory);
    }

    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param   string  $type    The table type to instantiate
     * @param   string  $prefix  A prefix for the table class name. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  Table  A database object
     *
     * @since   1.6
     */
    public function getTable($type = 'Module', $prefix = 'Joomla\\Component\\Decentralization\\Administrator\\Table\\', $config = [])
    {
        $table = Table::getInstance($type, $prefix, $config);
        return $table;
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
        $form = $this->loadForm('com_decentralization.module', 'module', ['control' => 'jform', 'load_data' => $loadData]);

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    public function getItem($pk = null)
    {
        $pk = (!empty($pk)) ? $pk : (int) $this->getState('module.id');

        if ($this->_item === null) {
            $this->_item = [];
        }

        if (!isset($this->_item[$pk])) {
            $this->_item[$pk] = parent::getItem($pk);
        }

        return $this->_item[$pk];
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  array  The default data is an empty array.
     *
     * @since   3.7.0
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $app   = Factory::getApplication();
        $data  = $app->getUserState('com_decentralization.edit.module.data', []);
        
        if (empty($data)) {
            $data = $this->getItem();
          
            if (!$data->id) {
                $filters = (array) $app->getUserState('com_decentralization.modules.filter');
                
                $data->set(
                    'published',
                    $app->getInput()->getInt(
                        'published',
                        ((isset($filters['published']) && $filters['published'] !== '') ? $filters['published'] : null)
                    )
                );
    
            }
        }

        $this->preprocessData('com_decentralization.module', $data);
        return $data;
    }

    public function save($data)
    { 
        $table      = $this->getTable();
        $input      = Factory::getApplication()->getInput();
        $pk         = (!empty($data['id'])) ? $data['id'] : (int) $this->getState($this->getName() . '.id');
        $isNew      = true;
        $context    = $this->option . '.' . $this->name;

        // Include the plugins for the save events.
        PluginHelper::importPlugin($this->events_map['save']);

        // Load the row if saving an existing category.
        if ($pk > 0) {
            $table->load($pk);
            $isNew = false;
        }

        // Bind the data.
        if (!$table->bind($data)) {
            $this->setError($table->getError());

            return false;
        }

        // Check the data.
        if (!$table->check()) {
            $this->setError($table->getError());

            return false;
        }

        // Trigger the before save event.
        $result = Factory::getApplication()->triggerEvent($this->event_before_save, [$context, &$table, $isNew, $data]);

        if (\in_array(false, $result, true)) {
            $this->setError($table->getError());

            return false;
        }

        // Store the data.
        if (!$table->store()) {
            $this->setError($table->getError());

            return false;
        }
      
    }
    
}
