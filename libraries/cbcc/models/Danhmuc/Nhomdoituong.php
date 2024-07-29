<?php
class Danhmuc_Model_Nhomdoituong{
	/**	
	 * @param mixed $formData
	 * @return boolean True on success
	 */
	public function create($formData){
		$table = Core::table('Danhmuc/Nhomdoituong');
		$src['name'] = $formData['name'];
		$src['captochuc_id'] = $formData['captochuc_id'];
		$src['active'] = $formData['active'];
		$src['ghinhantrinhdo'] = $formData['ghinhantrinhdo'];
		return $table->save($src);
	}
	public function update($formData){
		$table = Core::table('Danhmuc/Nhomdoituong');
		$src['id'] = $formData['id'];
		$src['name'] = $formData['name'];
		$src['captochuc_id'] = $formData['captochuc_id'];
		$src['active'] = $formData['active'];
		$src['ghinhantrinhdo'] = $formData['ghinhantrinhdo'];
		return $table->save($src);
	}
	public function read($id){
		$table = Core::table('Danhmuc/Nhomdoituong');		
		//$table->load($id);
		if (!$table->load($id)) {
			return null;
		}	
		$fields = array_keys($table->getFields());
		$data = array();
		$count = count($fields);
		for ($i = 0; $i < $count ; $i++) {
			$tmp = $fields[$i];
			$data[$fields[$i]] = $table->$tmp;
		}
		return $data;
	}
	public function delete($id){
		$table = Core::table('Danhmuc/Nhomdoituong');
		return $table->delete($id);
	}
}