<?php
class Tochuc_Model_Adchucvu{

	public function delete($node_id){
		$table = Core::table('Tochuc/Adchucvu');
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		// kiem tra xem co con hay khong
		$query->select('COUNT(id)')->from('cb_captochuc')->where('parent_id = '.(int)$node_id);
		$db->setQuery($query);
		$count = $db->loadResult();
		//var_dump($node_id);exit;
		if ($count > 0 ) {
			$query = $db->getQuery(true);
			$query->update('pos_system')
			->columns($db->quoteName('parent'))
			->values(5)
			->where('parent = '.(int)$node_id);
			$db->setQuery($query);
			$db->query();
		}

		// 		$query = $db->getQuery(true);
		// 		$query->delete('pos_system_copy')->where('ID = '.(int)$node_id);
		// 		$db->setQuery($query);
		// 		return $db->query();

		return $table->delete($node_id);

	}
	public function save($data){
		$table = Core::table('Tochuc/Adchucvu');
		foreach ($data as $key => $value) {
			if ($value == '') {
				unset($data[$key]);
			}
		}
		//var_dump($data);exit;
		$table->bind( $data );
		$table->check();
		$table->store();
		return $table->id;
	}
	public function savePos($formData){
		$db = JFactory::getDbo();
		$data = array(
			'idchucvu'=>(int)$formData['idchucvu'],
			'idcap'=>$formData['idcap'],
			'mangach'=>$formData['mangach'],
			'tencap'=>$formData['tencap'],
			'heso'=>$formData['heso']
		);
		foreach ($data as $key => $value) {
			if ($value == '') {
				unset($data[$key]);
			}			
		}
		//var_dump($data);exit;
		$table = Core::table('Tochuc/Adchucvu');
		$table->bind( $data );
		$table->check();
		$table->store();
		return $table->idchucvu;
	
	}
	public function read($id){
		$table = Core::table('Tochuc/Adchucvu');
		$table->load($id);
		return $table;
	}
	public function readPos($id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		// kiem tra xem co con hay khong
		$query->select('*')->from('cb_captochuc_chucvu')->where('idchucvu = '.(int)$id);
		$db->setQuery($query);
		return $db->loadObject();
	}
	public function moveNode($id,$parent_id){
		$table = Core::table('Tochuc/Adchucvu');
		$table->load($id);
		$table->parent = $parent_id;
		return $table->store();
	}
}