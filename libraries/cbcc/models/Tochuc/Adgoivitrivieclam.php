<?php
class Tochuc_Model_Adgoivitrivieclam{
	public function delete($id){
		$table = Core::table('Tochuc/Adgoivitrivieclam');
		$this->delGoiVitrivieclamVitrivieclam($id);
		return $table->delete($id);		
	}
	public function rebuild(){
		$table = Core::table('Tochuc/Adgoivitrivieclam');
		return $table->rebuild();
	}
	public function read($id){
		$table = Core::table('Tochuc/Adgoivitrivieclam');
		$table->load($id);
		return $table;
	}
	public function save($formData){
		$table = Core::table('Tochuc/Adgoivitrivieclam');
		$reference_id = (int)$formData['parent_id'];
		$table->setLocation( $reference_id, 'last-child' );
		$data = array(
				'id'=>$formData['id'],
				'name'=>$formData['name'],
				'status'=>$formData['status']				
		);		
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
	public function delGoiVitrivieclamVitrivieclam($goivitrivieclam_id){
		$db = JFactory::getDbo();
		// delete
		$query = $db->getQuery(true);
		$query->delete('cb_goivitrivieclam_vitrivieclam')->where('goivitrivieclam_id = '.$db->quote($goivitrivieclam_id));
		$db->setQuery($query);
		return $db->query();		
	}
	public function saveGoivitrivieclamVitrivieclam($goivitrivieclam_id,$vitrivieclam_id){
// 		var_dump($vitrivieclam_id); exit;
		$this->delGoiVitrivieclamVitrivieclam($goivitrivieclam_id);
		$db = JFactory::getDbo();
		// insert		
		for ($i = 0; $i < count($vitrivieclam_id); $i++) {
			$values = array();
			$values[] = $db->q($goivitrivieclam_id);
			$values[] = $db->q($vitrivieclam_id[$i]);
			$query = $db->getQuery(true);
			$query->insert('cb_goivitrivieclam_vitrivieclam')
				->columns($db->quoteName(array('goivitrivieclam_id','vitrivieclam_id')))
				->values(implode(',', $values));
			$db->setQuery($query);
			$db->query();
		}
	}
	public function moveNode($id,$parent_id){
		$table = Core::table('Tochuc/Adgoivitrivieclam');
		$table->load($id);
		$table->parent_id = $parent_id;
		return $table->store();
	}
}