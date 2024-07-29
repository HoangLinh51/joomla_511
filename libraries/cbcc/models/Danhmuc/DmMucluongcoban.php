<?php
class Danhmuc_Model_DmMucluongcoban extends JModelLegacy {
	function __construct() {
		parent::__construct ();
	}
	public function create($formData) {
		$table = Core::table('Danhmuc/DmMucluongcoban');
// 		$table = Core::table('Danhmuc/DmMucluongcoban');
		$src ['name'] = $formData ['name'];
		$src ['status'] = $formData ['status'] == "on" ? 1 : 0;
		$src ['order'] = $formData ['order']==""?99:$formData ['order'];
		$src ['value'] = $formData ['value']==""?0:$formData ['value'];
		$src ['validity_date'] = $this->convertInputToDb($formData ['validity_date']);
		return $table->save ( $src );
	}
	public function update($formData) {
		// $table = Core::table('Danhmuc/AbilityCode');
		$table = Core::table('Danhmuc/DmMucluongcoban');
		$src ['id'] = $formData ['id'];
		$src ['name'] = $formData ['name'];
		$src ['status'] = $formData ['status'] == "on" ? 1 : 0;
		$src ['order'] = $formData ['order']==""?99:$formData ['order'];
		$src ['value'] = $formData ['value']==""?0:$formData ['value'];
		$src ['validity_date'] = $this->convertInputToDb($formData ['validity_date']);
		return $table->save ( $src );
	}
	public function read($id) {
		// $table = Core::table('Danhmuc/AbilityCode');
		$table = Core::table('Danhmuc/DmMucluongcoban');
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
		$table = Core::table('Danhmuc/DmMucluongcoban');
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
		$table = Core::table('Danhmuc/DmMucluongcoban');
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
			$table = Core::table('Danhmuc/DmMucluongcoban');
			$src ['status'] = $publish;
			for($i = 0; $i < count ( $cid ); $i ++) {
				$src ['id'] = $cid [$i];
				$flag = $table->save ( $src );
			}
		}
		return $flag;
	}
	function convertInputToDb($dateInput){
		$date = explode('/', $dateInput);
		$dayDb = $date[2]."-".$date[1]."-".$date[0];
		return $dayDb;
	}
}