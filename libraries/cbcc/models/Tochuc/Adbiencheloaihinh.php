<?php
class Tochuc_Model_Adbiencheloaihinh{

	public function delete($node_id){
		$table = Core::table('Tochuc/Adbiencheloaihinh');
		return $table->delete($node_id);
	}

	public function save($formData){
		$table = Core::table('Tochuc/Adbiencheloaihinh');
		$table->bind( $formData );
		$table->check();
		$table->store();
		return $table->id;
	}

	public function read($id){
		$table = Core::table('Tochuc/Adbiencheloaihinh');
		$table->load($id);
		return $table;
	}
	public function getAll(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
		->from($db->quoteName('bc_loaihinh'));
		$db->setQuery($query);
		return $db->loadAssocList();
	}
}