<?php
/* HueNN
 *
 * Created on Wed Jul 12 2023
 *
 * Copyright (c) 2023 (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Joomla\Component\Decentralization\Administrator\Model;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\UserGroupsHelper;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\ListModel;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Groups Model
 *
 * @since  3.7.0
 */
class ActionsModel extends ListModel
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
                'id', 'a.id',
                'name', 'a.name',
                'module_id'
            ];
        }

        parent::__construct($config, $factory);
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
        $id .= ':' . $this->getState('filter.group_id');
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
    protected function populateState($ordering = null, $direction = null)
    {
        // List state information.
        parent::populateState('a.id', 'asc');
        // Load the parameters.
        $params = ComponentHelper::getParams('com_decentralization');
        $this->setState('params', $params);

        // List state information.
        parent::populateState($ordering, $direction);
    }

    /**
	 * Gets the list of groups and adds expensive joins to the result set.
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 *
	 * @since   1.6
	 */
	public function getItems()
	{
		// Get a storage key.
		$store = $this->getStoreId();

		// Try to load the data from internal storage.
		if (empty($this->cache[$store]))
		{
			$items = parent::getItems();

			// Bail out on an error or empty list.
			if (empty($items))
			{
				$this->cache[$store] = $items;

				return $items;
			}
            
			// Add the items to the internal cache.
			$this->cache[$store] = $items;
		}

		return $this->cache[$store];
	}

    public function _OrderBy(){
		$this->mainframe = Factory::getApplication();
		$this->option = $this->mainframe->getInput()->get('option');
	
		$filter_order		= $this->mainframe->getUserStateFromRequest( $this->option.'filter_order','filter_order',	'name','cmd' );
		$filter_order_Dir	= $this->mainframe->getUserStateFromRequest( $this->option.'filter_order_Dir','filter_order_Dir',	'',	'word' );
	    // var_dump($filter_order);
		if (!in_array($filter_order, array('id', 'name', 'username', 'email', 'lantruycaptruoc',  'block'))){
			$filter_order = 'name';
		}
	
		if (!in_array(strtoupper($filter_order_Dir), array('ASC', 'DESC'))) {
			$filter_order_Dir = '';
		}
		if ($filter_order != 'orders'){
			$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir.', name ';
		}
	
		return $orderby;
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
		$query->select('a.*, b.name as module_name');
		$query->from($db->quoteName('core_action') . ' AS a');
        $query->join('LEFT', $db->quoteName('core_module') . ' AS b', 'a.id_module = b.id');
		// Filter the comments over the search string if set.
		$search = $this->getState('filter.search');
        $params = $this->getState('filter.params');
        $group_id = $this->getState('list.group_id');


		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
				$query->where('a.name LIKE ' . $search);
			}
		}
        if($group_id > 0){
            $query->where('b.id = ' . $group_id);
        }

		// Add the list ordering clause.
        $query->order(
            $db->quoteName($db->escape($this->getState('list.ordering', 'a.name'))) . ' ' . $db->escape($this->getState('list.direction', 'ASC'))
        );       
		return $query;
	}
}