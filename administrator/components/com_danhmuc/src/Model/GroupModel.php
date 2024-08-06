<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

 namespace Joomla\Component\Danhmuc\Administrator\Model;

use Exception;
use Joomla\CMS\Access\Access;
use Joomla\CMS\Event\User\UserGroupAfterDeleteEvent;
use Joomla\CMS\Event\User\UserGroupBeforeDeleteEvent;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Table\Table;
use stdClass;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Group model.
 *
 * @since  1.6
 */
class ChucvuModel extends AdminModel
{
    /**
     * An item.
     *
     * @var    array
     */
    protected $_item = null;

    /**
     * Override parent constructor.
     *
     * @param   array                $config   An optional associative array of configuration settings.
     * @param   MVCFactoryInterface  $factory  The factory.
     *
     * @see     \Joomla\CMS\MVC\Model\BaseDatabaseModel
     * @since   3.2
     */
    public function __construct($config = [], MVCFactoryInterface $factory = null)
    {
        $config = array_merge(
            [
                'event_after_delete'  => 'onUserAfterDeleteGroup',
                'event_after_save'    => 'onUserAfterSaveGroup',
                'event_before_delete' => 'onUserBeforeDeleteGroup',
                'event_before_save'   => 'onUserBeforeSaveGroup',
                'events_map'          => ['delete' => 'user', 'save' => 'user'],
            ],
            $config
        );

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
    public function getTable($type = 'DMChucvu', $prefix = 'Joomla\\Component\\Danhmuc\\Administrator\\Table\\', $config = [])
    {
        $return = Table::getInstance($type, $prefix, $config);

        return $return;
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
        $form = $this->loadForm('com_danhmuc.group', 'chucvu', ['control' => 'jform', 'load_data' => $loadData]);

        if (empty($form)) {
            return false;
        }

        return $form;
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
        $data  = $app->getUserState('com_danhmuc.edit.chucvu.data', []);
        
        if (empty($data)) {
            $data = $this->getItem();
          
            if (!$data->id) {
                $filters = (array) $app->getUserState('com_danhmuc.chucvus.filter');

            }
        }

        $this->preprocessData('com_danhmuc.chucvu', $data);
        return $data;
    }

    public function getItem($pk = null)
    {
        $pk = (!empty($pk)) ? $pk : (int) $this->getState('chucvu.id');
        
        if ($this->_item === null) {
            $this->_item = [];
        }

        if (!isset($this->_item[$pk])) {
            $this->_item[$pk] = parent::getItem($pk);
        }

        return $this->_item[$pk];
    }

    /**
	 * Delete all group in core_user_action
	 * @param number $group_id
	 * @return mixed
	 */
	public function deleteAc_Us_Dv($group_id = 0){
		$db		=	Factory::getDbo();
        $sql_fk = $db->getQuery();
		$sql_fk =	'DELETE FROM core_user_action_donvi WHERE group_id = '.(int)$group_id;
		$db->setQuery($sql_fk);
		return 	$db->execute();
	}
    
	/**
	 * Delete ralation group and action in core_group_action
	 * @param integer $id
	 * @return mixed
	 */
	private function deleteGroup_fk($id){
		$db		=	Factory::getDBO();
        $sql_fk = $db->getQuery();
		$sql_fk =	'DELETE FROM core_group_action WHERE group_id IN ('.$id.')';
		$db->setQuery($sql_fk);
		return 	$db->execute();
	}
    /**
	 * delete table theo cid
	 * @param string $table
	 * @param aray $cid
	 * @return boolean
	 */
    public function remove($table, $cid){
		$db = Factory::getDbo();
		if(!is_array($cid)||count($cid)==0){
			return false;
		}
		$ids = implode(",", $cid);
		$this->deleteGroup_fk($ids);
		$sql="DELETE FROM ".$table." WHERE id IN ($ids)"; echo $sql;exit;
		$db->setQuery($sql);
		if (! $db->query()){
			return false;
		}
		return true;
	}

    /**
	 * 
	 * @param number $group_id
	 * @return array('user_id'=>'id_donvi')
	 */
	public function getUserDonviGroup ($group_id = 0){
		$db		=	Factory::getDbo();
		$sql	= 'SELECT user_id, id_donvi, iddonvi_quanly FROM jos_user_usergroup_map as a
				LEFT JOIN core_user_donvi AS b ON a.user_id = b.id_user
				WHERE group_id = '.(int)$group_id;
		$db->setQuery($sql);
		$row	=	$db->loadAssocList();
		return $row;
	}

    /**
	 * Lưu nhóm người dùng
	 * @return boolean
	 */
	public function storeData(){
		$flag				=	true;
		$data  = Factory::getApplication()->getInput()->get('jform', [], 'array'); 
		$db					=	Factory::getDbo();
        if(isset($data['acname0'])){
            $acname[0]			=	$data['acname0']; 
        }
        if (isset($data['acname1'])) {
            $acname[1]			=	$data['acname1']; 
        }
        if (isset($data['acname2'])) {       
            $acname[2]			=	$data['acname2'];
        }
        
        
		// Lấy ra array('user_id'=>'id_donvi') theo group
		$arr_user_id		= $this->getUserDonviGroup((int)$data['id']);

        // Xóa quan hệ giữa group và action trong bảng Core_group_action
 		$this->deleteGroup_fk($data['id']);
		// Xóa quan hệ giữa action và user và đơn vị khi thay đổi quan hệ giữa group và action
 		$this->deleteAc_Us_Dv($data['id']);

        /** @var \Joomla\Component\Danhmuc\Administrator\Model\UsersModel $model_user */

         $model_user = Factory::getApplication()->bootComponent('com_Danhmuc')->getMVCFactory()
         ->createModel('Users', 'Administrator', ['ignore_request' => true]);
		// Insert quan hệ group _ action
		foreach ($acname as $key=>$value){
			$object_fk_group			=	new stdClass();
			$object_fk_group->group_id	=	$data['id'];
			$object_fk_group->type		=	$key;
            
			if (count($value) > 0) {	
               
				for ($j = 0; $j < count($value); $j++) {
                    
					$object_fk_group->action_id = $value[$j];
                    // var_dump($object_fk_group->action_id);exit;
					$flag = $flag&&$db->insertObject('core_group_action', $object_fk_group);
                    // Lưu cập nhật nhóm, action, user, donvi vào bảng core_user_action_donvi
                    if ($flag && count($arr_user_id) > 0 ) {
                        
                        foreach ($arr_user_id as $value1){
                            // Lấy id_donvi theo type of group
                            // var_dump($value1['iddonvi_quanly']);exit;
                          
                            $id_donvi		=	$model_user->getChirl_Donvi($value1['id_donvi'], $key, $value1['iddonvi_quanly']);
                            // var_dump($id_donvi);exit;
                            if ((int)$id_donvi >= 0) {
                                //for ($k = 0; $k < count($arr_id_donvi); $k++) {
                                    $object_ac_us_dv			= new stdClass();
                                    $object_ac_us_dv->action_id	=	$value[$j];
                                    $object_ac_us_dv->group_id	=	$data['id'];
                                    $object_ac_us_dv->user_id	=	(int)$value1['user_id'];
                                    $object_ac_us_dv->iddonvi	=	$id_donvi;//[$k];
                                    $db->insertObject('core_user_action_donvi', $object_ac_us_dv);
                                    
                                //}
                                
                            }
                            
                        }
                    }
				}
			}
		}
		return $flag;
	}

    /**
     * Method to save the form data.
     *
     * @param   array  $data  The form data.
     *
     * @return  boolean  True on success.
     *
     * @since   1.6
     */
    public function save($data)
    {
        // Include the user plugins for events.
        PluginHelper::importPlugin($this->events_map['save']);

        /**
         * Check the super admin permissions for group
         * We get the parent group permissions and then check the group permissions manually
         * We have to calculate the group permissions manually because we haven't saved the group yet
         */
        $parentSuperAdmin = Access::checkGroup($data['parent_id'], 'core.admin');

        // Get core.admin rules from the root asset
        $rules = Access::getAssetRules('root.1')->getData('core.admin');

        // Get the value for the current group (will be true (allowed), false (denied), or null (inherit)
        $groupSuperAdmin = $rules['core.admin']->allow($data['id']);

        // We only need to change the $groupSuperAdmin if the parent is true or false. Otherwise, the value set in the rule takes effect.
        if ($parentSuperAdmin === false) {
            // If parent is false (Denied), effective value will always be false
            $groupSuperAdmin = false;
        } elseif ($parentSuperAdmin === true) {
            // If parent is true (allowed), group is true unless explicitly set to false
            $groupSuperAdmin = ($groupSuperAdmin === false) ? false : true;
        }

        // Check for non-super admin trying to save with super admin group
        $iAmSuperAdmin = $this->getCurrentUser()->authorise('core.admin');

        if (!$iAmSuperAdmin && $groupSuperAdmin) {
            $this->setError(Text::_('JLIB_USER_ERROR_NOT_SUPERADMIN'));

            return false;
        }

        /**
         * Check for super-admin changing self to be non-super-admin
         * First, are we a super admin
         */
        if ($iAmSuperAdmin) {
            // Next, are we a member of the current group?
            $myGroups = Access::getGroupsByUser($this->getCurrentUser()->get('id'), false);

            if (in_array($data['id'], $myGroups)) {
                // Now, would we have super admin permissions without the current group?
                $otherGroups     = array_diff($myGroups, [$data['id']]);
                $otherSuperAdmin = false;

                foreach ($otherGroups as $otherGroup) {
                    $otherSuperAdmin = $otherSuperAdmin ?: Access::checkGroup($otherGroup, 'core.admin');
                }

                /**
                 * If we would not otherwise have super admin permissions
                 * and the current group does not have super admin permissions, throw an exception
                 */
                if ((!$otherSuperAdmin) && (!$groupSuperAdmin)) {
                    $this->setError(Text::_('JLIB_USER_ERROR_CANNOT_DEMOTE_SELF'));

                    return false;
                }
            }
        }
        // Proceed with the save
        return parent::save($data);
    }

    /**
     * Method to delete rows.
     *
     * @param   array  &$pks  An array of item ids.
     *
     * @return  boolean  Returns true on success, false on failure.
     *
     * @since   1.6
     * @throws  \Exception
     */
    public function delete(&$pks)
    {
        // Typecast variable.
        $pks        = (array) $pks;
        $user       = $this->getCurrentUser();
        $groups     = Access::getGroupsByUser($user->get('id'));
        $context    = $this->option . '.' . $this->name;
        $dispatcher = $this->getDispatcher();

        // Get a row instance.
        $table = $this->getTable();

        // Load plugins.
        PluginHelper::importPlugin($this->events_map['delete'], null, true, $dispatcher);

        // Check if I am a Super Admin
        $iAmSuperAdmin = $user->authorise('core.admin');

        foreach ($pks as $pk) {
            // Do not allow to delete groups to which the current user belongs
            if (\in_array($pk, $groups)) {
                Factory::getApplication()->enqueueMessage(Text::_('COM_USERS_DELETE_ERROR_INVALID_GROUP'), 'error');

                return false;
            }

            if (!$table->load($pk)) {
                // Item is not in the table.
                $this->setError($table->getError());

                return false;
            }
        }

        // Iterate the items to delete each one.
        foreach ($pks as $i => $pk) {
            if ($table->load($pk)) {
                // Access checks.
                $allow = $user->authorise('core.edit.state', 'com_users');

                // Don't allow non-super-admin to delete a super admin
                $allow = (!$iAmSuperAdmin && Access::checkGroup($pk, 'core.admin')) ? false : $allow;

                if ($allow) {
                    // Fire the before delete event.
                    $beforeDeleteEvent = new UserGroupBeforeDeleteEvent($this->event_before_delete, [
                        'data'    => $table->getProperties(), // @TODO: Remove data argument in Joomla 6, see UserGroupBeforeDeleteEvent
                        'context' => $context,
                        'subject' => $table,
                    ]);
                    $result = $dispatcher->dispatch($this->event_before_delete, $beforeDeleteEvent)->getArgument('result', []);

                    if (\in_array(false, $result, true)) {
                        $this->setError($table->getError());

                        return false;
                    }

                    if (!$table->delete($pk)) {
                        $this->setError($table->getError());

                        return false;
                    }

                    // Trigger the after delete event.
                    $dispatcher->dispatch($this->event_after_delete, new UserGroupAfterDeleteEvent($this->event_after_delete, [
                        'data'           => $table->getProperties(), // @TODO: Remove data argument in Joomla 6, see UserGroupAfterDeleteEvent
                        'deletingResult' => true, // @TODO: Remove deletingResult argument in Joomla 6, see UserGroupAfterDeleteEvent
                        'errorMessage'   => $this->getError(), // @TODO: Remove errorMessage argument in Joomla 6, see UserGroupAfterDeleteEvent
                        'context'        => $context,
                        'subject'        => $table,
                    ]));
                } else {
                    // Prune items that you can't change.
                    unset($pks[$i]);
                    Factory::getApplication()->enqueueMessage(Text::_('JERROR_CORE_DELETE_NOT_PERMITTED'), 'error');
                }
            }
        }

        return true;
    }
}