<?php
class Danhmuc_Model_DmLinhvucnckh extends JModelLegacy {
	function __construct() {
		parent::__construct ();
	}
	public function create($formData) {
		$table = Core::table('Danhmuc/DmLinhvucnckh');
// 		$table = JTable::getInstance ( 'DmLinhvucnckh', 'Table' );
		$src ['name'] = $formData ['name'];
		$src ['status'] = $formData ['status'] == "on" ? 1 : 0;
		$src ['order'] = $formData ['order'];
		return $table->save ( $src );
	}
	public function update($formData) {
		// $table = Core::table('Danhmuc/AbilityCode');
		$table = Core::table('Danhmuc/DmLinhvucnckh');
		// var_dump($formData);exit;
		$src ['id'] = $formData ['id'];
		$src ['name'] = $formData ['name'];
		$src ['status'] = $formData ['status'] == "on" ? 1 : 0;
		$src ['order'] = $formData ['order'];
		return $table->save ( $src );
	}
	public function checkTrungten($name, $id = null) {
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->select ( 'count(name)' );
		$query->from ( 'dm_linhvucnckh' );
		$where = 'name like "' . $name . '"';
		if ($id > 0)
			$where = 'id !=' . $id; // dùng cho trường hợp edit
		$query->where ( $where );
		
		$db->setQuery ( $query );
		// $this->number = $db->loadResult();
		return $db->loadResult ();
	}
	public function read($id) {
		// $table = Core::table('Danhmuc/AbilityCode');
		$table = Core::table('Danhmuc/DmLinhvucnckh');
		if (! $table->load ( $id )) {
			return null;
		}
		$fields = array_keys ( $table->getFields () );
		$data = array ();
		for($i = 0; $i < count ( $fields ); $i ++) {
			$data [$fields [$i]] = $table->$fields [$i];
		}
		return $data;
	}
	public function delete($cid) {
		// $table = Core::table('Danhmuc/AbilityCode');
		$table = Core::table('Danhmuc/DmLinhvucnckh');
		if (! is_array ( $cid ) || count ( $cid ) == 0) {
			$flag = false;
		} else {
			for($i = 0; $i < count ( $cid ); $i ++) {
				$flag = $table->delete ( $cid [$i] );
			}
		}
		return $flag;
	}
	public function findAll($params = null, $order = null, $offset = null, $limit = null) {
		// $table = Core::table('Danhmuc/AbilityCode');
		$table = Core::table('Danhmuc/DmLinhvucnckh');
		// var_dump($table); exit;
		$db = $table->getDbo ();
		$query = $db->getQuery ( true );
		$query->select ( array (
				'*' 
		) )->from ( $table->getTableName () );
		
		if (isset ( $params ['name'] ) && ! empty ( $params ['name'] )) {
			$query->where ( 'name LIKE (' . $db->quote ( '%' . $params ['name'] . '%' ) . ')' );
		}
		if ($order == null) {
			$query->order ( 'id' );
		} else {
			$query->order ( $order );
		}
		
		if ($offset != null && $limit != null) {
			$db->setQuery ( $query, $offset, $limit );
		} else {
			$db->setQuery ( $query );
		}
		return $db->loadObjectList ();
	}
	function publish($cid = array(), $publish = 1) {
		$flag = false;
		if (count ( $cid )) {
			JArrayHelper::toInteger ( $cid );
			// $table = Core::table('Danhmuc/AbilityCode');
			$table = Core::table('Danhmuc/DmLinhvucnckh');
			$src ['status'] = $publish;
			for($i = 0; $i < count ( $cid ); $i ++) {
				$src ['id'] = $cid [$i];
				$flag = $table->save ( $src );
			}
		}
		return $flag;
	}
}