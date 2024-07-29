<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_decentralization
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Decentralization\Administrator\Model;

use Core;
use Joomla\CMS\Categories\CategoryServiceInterface;
use Joomla\CMS\Categories\SectionNotFoundException;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;
use Joomla\Database\ParameterType;
use Joomla\Registry\Registry;
use Joomla\String\StringHelper;
use Joomla\Utilities\ArrayHelper;
use Laminas\Diactoros\Request;
use phpseclib3\Common\Functions\Strings;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Report Model
 *
 * @since  3.7.0
 */
class UsersModel extends ListModel
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
                'username', 'a.username',
                'email', 'a.email',
                'block', 'a.block',
                'sendEmail', 'a.sendEmail',
                'registerDate', 'a.registerDate',
                'lastvisitDate', 'a.lastvisitDate',
                'activation', 'a.activation',
                'active',
                'group_id',
                'range',
                'lastvisitrange',
                'state',
                'mfa',
            ];
        }

        parent::__construct($config, $factory);
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

        $context = $this->getUserStateFromRequest($this->context . '.context', 'context', 'com_decentralization.users', 'CMD');
        $this->setState('filter.context', $context);

        // Split context into component and optional section
        $parts = FieldsHelper::extract($context);

        if ($parts) {
            $this->setState('filter.component', $parts[0]);
            $this->setState('filter.section', $parts[1]);
            $this->setState('filter.table', 'jos_users');
        }
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
        $id .= ':' . $this->getState('filter.context');
        $id .= ':' . serialize($this->getState('filter.assigned_cat_ids'));
        $id .= ':' . $this->getState('filter.state');
        $id .= ':' . $this->getState('filter.group_id');
        $id .= ':' . serialize($this->getState('filter.language'));
        $id .= ':' . $this->getState('filter.only_use_in_subform');

        return parent::getStoreId($id);
    }

    public function _buildContentWhere(){
        $search = $this->getState('filter.search');
        $block = $this->getState('filter.block');
        $group_id = $this->getState('list.group_id');
        // if (strpos($search, '"') !== false) {
		// 	$search = str_replace(array('=', '<'), '', $search);
		// }
        
		// $search = StringHelper::strtolower($search);

		$where = array();
        
		if ($search) {
			$where[] = '(LOWER(u.name) LIKE '.$this->_db->quote( '%'.$search.'%').' or LOWER(u.username) LIKE '.$this->_db->quote( '%'.$search.'%').')';
		}
		if ($group_id != '') {
			$where[] = 'ug.group_id = '.(int) $group_id;
		}
		if($block != ''){
			$where[] = 'u.block = '.(int) $block;
		}
        $config_user =  Core::config('core/admin/phanquyenuser')['core/admin/phanquyenuser'];
        $config_group = Core::config('core/admin/phanquyengroup')['core/admin/phanquyengroup'];
		if ($config_user != null || $config_user != '') {
			$where[] = 'u.id NOT IN ('.$config_user.')';
		}
		if ($config_group != null || $config_group != '') {
			$where[] = 'ug.group_id NOT IN ('.$config_group.')';
		}

		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
	    // echo $where;exit;
		return $where;
	}
	
	public function _buildContentOrderBy(){
		$this->mainframe = Factory::getApplication();
		$this->option = $this->mainframe->getInput()->get('option');
	
		$filter_order		= $this->mainframe->getUserStateFromRequest( $this->option.'filter_order','filter_order',	'name','cmd' );
		$filter_order_Dir	= $this->mainframe->getUserStateFromRequest( $this->option.'filter_order_Dir','filter_order_Dir',	'',	'word' );
	
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


    public function _buildQuery($table){
		$where		= $this->_buildContentWhere();
		$orderby	= $this->_buildContentOrderBy();
			
		$query = 'SELECT u.id, u.name, u.username, u.email, u.lastvisitDate as lantruycaptruoc, u.block, ug.group_id, ind.`name` as donvithuocve, 
				idt.`name` as donviquanly, u.requireReset  FROM '.$table.' as u
				INNER join jos_user_usergroup_map as ug On ug.user_id = u.id
				LEFT JOIN core_user_donvi as cu ON cu.id_user = u.id
				LEFT join ins_dept as ind on ind.id = cu.id_donvi
				LEFT join ins_dept as idt on idt.id = cu.iddonvi_quanly'
				.$where
				.' group by u.id '
				.$orderby
				;
                // echo $query;exit;
		return $query;
	}

    /**
     * Method to get a DatabaseQuery object for retrieving the data set from a database.
     *
     * @return  \Joomla\Database\DatabaseQuery   A DatabaseQuery object to retrieve the data set.
     *
     * @since   3.7.0
     */
    protected function getListQuery()
    {
        $table = $this->getState('filter.table');
        $db    = $this->getDatabase();
        $query = $db->getQuery(true);
        if (empty($this->_data)){
			$query = $this->_buildQuery($table);//echo $query;exit;
			//$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
        
		return $query;
    }


    /**
     * Get the filter form
     *
     * @param   array    $data      data
     * @param   boolean  $loadData  load current data
     *
     * @return  Form|null  The \JForm object or null if the form can't be found
     *
     * @since   4.2.0
     */
    public function getFilterForm($data = [], $loadData = true)
    {
        $form = parent::getFilterForm($data, $loadData);

        if ($form && !PluginHelper::isEnabled('multifactorauth')) {
            $form->removeField('mfa', 'filter');
        }

        return $form;
    }

    /**
     * Get the filter form
     *
     * @param   array    $data      data
     * @param   boolean  $loadData  load current data
     *
     * @return  \Joomla\CMS\Form\Form|bool  the Form object or false
     *
     * @since   3.7.0
     */
    public function getFilterForm_old($data = [], $loadData = true)
    {
        $form = parent::getFilterForm($data, $loadData);

        if ($form) {
            $form->setValue('context', null, $this->getState('filter.context'));
            $form->setFieldAttribute('group_id', 'context', $this->getState('filter.context'), 'filter');
            $form->setFieldAttribute('assigned_cat_ids', 'extension', $this->state->get('filter.component'), 'filter');
        }

        return $form;
    }

    /**
     * Get the groups for the batch method
     *
     * @return  array  An array of groups
     *
     * @since   3.7.0
     */
    public function getGroups()
    {
        $user       = $this->getCurrentUser();
        $viewlevels = ArrayHelper::toInteger($user->getAuthorisedViewLevels());
        $context    = $this->state->get('filter.context');

        $db    = $this->getDatabase();
        $query = $db->getQuery(true);
        $query->select(
            [
                $db->quoteName('title', 'text'),
                $db->quoteName('id', 'value'),
                $db->quoteName('state'),
            ]
        );
        $query->from($db->quoteName('#__fields_groups'));
        $query->whereIn($db->quoteName('state'), [0, 1]);
        $query->where($db->quoteName('context') . ' = :context');
        $query->whereIn($db->quoteName('access'), $viewlevels);
        $query->bind(':context', $context);

        $db->setQuery($query);

        return $db->loadObjectList();
    }

    /**
	 * Lấy đơn vị con
	 * @param unknown $id
	 * @param number $type
	 * @param unknown $iddonvi_quanly
	 * @return $node_donvi theo type (0, 1, 2) <=> (id_donvi, node_cha, node_tpdn) 
	 */
	public function getChirl_Donvi($id, $iddonvi_quanly, $type = 0){
		
		$result = null;
		if ((int)$id > 0) {
			if ((int)$type == 0) {
				$result	=	$id;
			}elseif ((int)$type == 1) {
			
				$result = $iddonvi_quanly;
			}elseif ((int)$type == 2){
				$db		=	Factory::getDbo();
				$query	=	'SELECT id FROM ins_dept where lft = 0';
				$db->setQuery($query);      
				$result	=	$db->loadResult();
			}
		}
		return (int)$result;
	}
}
