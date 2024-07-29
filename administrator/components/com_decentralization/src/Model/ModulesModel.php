<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_decentralization
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Decentralization\Administrator\Model;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Table\Table;
use Joomla\Database\ParameterType;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Report Model
 *
 * @since  3.7.0
 */
class ModulesModel extends ListModel
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
        if (empty($config['filter_modules'])) {
            $config['filter_modules'] = [
                'id', 'a.id',
                'name', 'a.name',
                'code', 'a.code',
                'status', 'a.status',
                'mfa'
            ];
        }

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
    protected function populateState($ordering = 'a.id', $direction = 'asc')
    {
        // Load the parameters.
        $params = ComponentHelper::getParams('com_decentralization');
        $this->setState('params', $params);

        // List state information.
        parent::populateState($ordering, $direction);
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

    public function getListQuery()
    {
        $db    = $this->getDatabase();
        $query = $db->getQuery(true);
        // Select the required fields from the table.
        $query->select(
            $this->getState(
                'list.select',
                'a.*'
            )
        );
        $query->from($db->quoteName('core_module') . ' AS a');
        // Add the level in the tree.
        $query->group('a.id, a.name, a.code, a.status');
        // Filter the items over the search string if set.
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            $search = '%' . trim($search) . '%';
            $query->where('a.name LIKE :name')
                    ->bind(':name', $search);
            
        }

        $query->group('a.id');
        // Add the list ordering clause.
        $query->order($db->escape($this->getState('list.ordering', 'a.id')) . ' ' . $db->escape($this->getState('list.direction', 'ASC')));
        // echo $query;
        return $query;

    }

}
