<?php
namespace Joomla\Component\Core\Administrator\Model;

use Exception;
use Jfcherng\Diff\Utility\Arr;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Table\Table;
use Joomla\Database\ParameterType;

defined('_JEXEC') or die;


class MenuModel extends ListModel
{

	public function getTable($type = 'Menu', $prefix = 'Joomla\\Component\\Core\\Administrator\\Table\\', $config = [])
	{
		$return = Table::getInstance($type, $prefix, $config);

		return $return;
	}


	public function __construct($config = [], MVCFactoryInterface $factory = null)
	{
		// Set the list ordering fields.
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = [
				'id',
				'a.id',
				'title',
				'a.name',
				'client_id',
				'a.client_id',

			];
		}
		parent::__construct($config, $factory);
	}

	public function getMsg()
	{
		if (!isset($this->message)) {
			$this->message = 'Hello Foo!';
		}
		return $this->message;
	}

	public function getMenuById()
	{
		$clientId = Factory::getApplication()->input->getInt('id');
		
		$table = $this->getTable();
		$table->load($clientId);
		return $table;
	}

	public function getGroupbyMenuId(){
		$clientId = Factory::getApplication()->input->getInt('id');
		$db       = Factory::getDbo();
		$query    = $db->getQuery(true)
			->select('usergroup_id')
			->from($db->quoteName('jos_core_menu_usergroup'))
			->where($db->quoteName('menu_id') . ' = ' . $clientId);
		$db->setQuery($query);
		return $db->loadObject();
	}

	public function getCoreMenuId()
	{
		//$clientId = Factory::getApplication()->input->getInt('id');
		$clientId = (int) $this->getState('filter.id');
		$db       = $this->getDatabase();
		$query    = $db->getQuery(true)
			->select('e.id, e.name, e.parent_id,e.menu_type, e.is_system,e.link, e.icon, e.component, e.controller, e.params, e.task, e.published')
			->from($db->quoteName('core_menu', 'e'))
			->where($db->quoteName('e.id') . ' = ' . $clientId);
		$db->setQuery($query);
		return $db->loadObject();
	}

	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDatabase();
		$query = $db->getQuery(true);
		// Select the required fields from the table.
		$query->select('*');

		$query->from($db->quoteName('core_menu'));
		//$id      = Factory::getApplication()->input->getInt('id');
		//$query->where($db->quoteName('a.id') . ' = '.$id);
		// Add the list ordering clause.
		//echo $query;exit;
		//$query->order($db->escape($this->getState('list.ordering', 'a.lft')) . ' ' . $db->escape($this->getState('list.direction', 'ASC')));
		return $query;
	}

	public function _buildTree($parent, $table)
	{
		$db = Factory::getDbo();
		$rows = array();
		$where = array();
		$data = array();
		if ($parent == 0) {
			$where[] = '(a.parent_id = ' . (int)$parent . ' OR a.parent_id IS NULL)';
		} else {
			$where[] = 'a.parent_id = ' . (int)$parent;
		}
		$order = ' ORDER BY a.name COLLATE utf8_unicode_ci';
		$query = 'SELECT a.id,a.parent_id AS parent,a.name AS text FROM ' . $db->quoteName($table, 'a') . $order;
		$db->setQuery($query);
		$rows = $db->loadAssocList();
		for ($i = 0; $i < count($rows); $i++) {
			$state[] = array('opened' => true);
			$data[] = array(
				"id" => $rows[$i]['id'],
				"parent" =>  $rows[$i]['parent'] == '0' ? "#" : $rows[$i]['parent'],
				"text" => $rows[$i]['text'],
				"state" => $rows[$i]['parent'] == '0' ? array('opened' => true, 'selected' => true) : ""
				//"state" => $rows[$i]['parent'] == '0' ? array('opened'=>true) : ""

			);
		}
		return $data;
	}

	public function save($data)
	{
		$table = $this->getTable();
		$reference_id = (int)$data['parent_id'];
		if ($reference_id == 0) {
			$reference_id = $table->getRootId();
		}

		if ($reference_id === false) {
			$reference_id = $table->addRoot();
		}

		if ((int)$data['id'] > 0) {
			$table->load($data['id']);
			if ($table->parent_id == $reference_id) {
				unset($data['parent_id']);
			}
		} else {
			$table->setLocation($reference_id, 'last-child');
		}
		// Ràng buộc dữ liệu vào bảng
		if (!$table->bind($data)) {
			throw new Exception($table->getError());
		}

		// Kiểm tra tính hợp lệ của dữ liệu
		if (!$table->check()) {
			throw new Exception($table->getError());
		}

		// Lưu dữ liệu vào bảng
		if (!$table->store()) {
			throw new Exception($table->getError());
		}
		$menuId = (int) $table->id;
		$usergroupId = isset($data['usergroup']) ? (int) $data['usergroup'] : 0;
		if ($menuId > 0 && $usergroupId > 0) {
			$db = Factory::getDbo();
			$query = $db->getQuery(true);

			// Kiểm tra xem đã tồn tại bản ghi với menu_id và usergroup_id chưa
			$query->clear()
				->select($db->quoteName('id')) // Giả sử bảng có cột id là khóa chính
				->from($db->quoteName('jos_core_menu_usergroup'))
				->where($db->quoteName('menu_id') . ' = ' . $db->quote($menuId));
			$db->setQuery($query);
			$existingId = $db->loadResult();

			if ($existingId) {
				// Đã tồn tại -> thực hiện cập nhật nếu cần (ở đây update ví dụ cột khác nếu có)
				$query->clear()
					->update($db->quoteName('jos_core_menu_usergroup'))
					->set($db->quoteName('usergroup_id') . ' = ' . $db->quote($usergroupId)) 
					->where($db->quoteName('id') . ' = ' . (int) $existingId);
				$db->setQuery($query);
				$db->execute();
			} else {
				// Chưa có -> thực hiện thêm mới
				$query->clear()
					->insert($db->quoteName('jos_core_menu_usergroup'))
					->columns([$db->quoteName('menu_id'), $db->quoteName('usergroup_id')])
					->values(implode(',', [$db->quote($menuId), $db->quote($usergroupId)]));
				$db->setQuery($query);
				$db->execute();
			}
		}
		return $table->id;
	}

	public function delete($node_id)
	{
		$table = $this->getTable();
		return $table->delete($node_id);
	}
}
