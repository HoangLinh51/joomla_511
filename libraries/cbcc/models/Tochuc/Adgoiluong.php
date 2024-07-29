<?php
class Tochuc_Model_Adgoiluong{
	public function delete($id){
		$table = Core::table('Tochuc/Adgoiluong');
		$a = $this->deleteGoiLuongNgach($id);
		return $table->delete($id);		
	}
	public function rebuild(){
		$table = Core::table('Tochuc/Adgoiluong');
		return $table->rebuild();
	}
	public function read($id){
		$table = Core::table('Tochuc/Adgoiluong');
		$table->load($id);
		return $table;
	}
	public function save($formData){
		$table = Core::table('Tochuc/Adgoiluong');
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
	public function deleteGoiLuongNgach($goiluong_id){
		$db = JFactory::getDbo();
		// delete
		$query = $db->getQuery(true);
		$query->delete('cb_goiluong_ngach')->where('id_goi = '.$db->quote($goiluong_id));
		$db->setQuery($query);
		return $db->query();		
	}
	public function saveGoiLuongNgach($goiluong_id,$ngach){
		$this->deleteGoiLuongNgach($goiluong_id);
		$db = JFactory::getDbo();
		// insert		
		for ($i = 0; $i < count($ngach); $i++) {
			$values = array();
			$values[] = $db->q($goiluong_id);
			$values[] = $db->q($ngach[$i]);
			$query = $db->getQuery(true);
			$query->insert('cb_goiluong_ngach')
				->columns($db->quoteName(array('id_goi','ngach')))
				->values(implode(',', $values));
			$db->setQuery($query);
			$db->query();
		}
	}
	public function moveNode($id,$parent_id){
		$table = Core::table('Tochuc/Adgoiluong');
		$table->load($id);
		$table->parent_id = $parent_id;
		return $table->store();
	}
}