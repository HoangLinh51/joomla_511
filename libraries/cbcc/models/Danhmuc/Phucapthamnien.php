<?php
class Danhmuc_Model_Phucapthamnien extends JModelLegacy {
	function __construct() {
		parent::__construct ();
	}
	public function save($formData) {
		$table = Core::table('Danhmuc/Phucapthamnien');
		$src ['name'] = $formData ['name'];
		$src ['status'] = $formData ['status'] == "on" ? 1 : 0;
		$src ['sonambatdau'] = $formData ['sonambatdau'];
		$src ['phucaplandau'] = $formData ['phucaplandau'];
		$src ['sonamtangphucap'] = $formData ['sonamtangphucap'];
		$src ['phantramtangphucap'] = $formData ['phantramtangphucap'];
		if (isset($formData ['id'])) $src ['id'] = $formData ['id'];
		return $table->save ( $src );
	}
	public function read($id) {
		$table = Core::table('Danhmuc/Phucapthamnien');
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
		$table = Core::table('Danhmuc/Phucapthamnien');
		if (! is_array ( $cid ) || count ( $cid ) == 0) {
			$flag = false;
		} else {
			for($i = 0; $i < count ( $cid ); $i ++) {
				$flag = $table->delete ( $cid [$i] );
			}
		}
		return $flag;
	}
	public function findAll() {
		$db = JFactory::getDbo (); 
		$query = $db->getQuery ( true );
		$query->select ( array ('*' ) )->from ( 'phucapthamnien' );
			$db->setQuery ( $query );
		return $db->loadObjectList ();
	}
	function publish($cid = array(), $publish = 1) {
		$flag = false;
		if (count ( $cid )) {
			JArrayHelper::toInteger ( $cid );
			$table = Core::table('Danhmuc/Phucapthamnien');
			$src ['status'] = $publish;
			for($i = 0; $i < count ( $cid ); $i ++) {
				$src ['id'] = $cid [$i];
				$flag = $table->save ( $src );
			}
		}
		return $flag;
	}
}