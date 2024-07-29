<?php
class Tochuc_Model_Adgoibienche{
	public function delete($id){
		$table = Core::table('Tochuc/Adgoibienche');
		return $table->delete($id);
	}
	public function read($id){
		$table = Core::table('Tochuc/Adgoibienche');
		$table->load($id);
		return $table;
	}
	
	public function getAll(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
				->from($db->quoteName('bc_goibienche'));	
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	public function save($formData){
		$table = Core::table('Tochuc/Adgoibienche');
		$data = array(
				'id'=>$formData['id'],
				'name'=>$formData['name'],
				'active'=>$formData['active']
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
	public function deleteGoibiencheHinhthuc($goibienche_id){
		$db = JFactory::getDbo();
		// delete
		$query = $db->getQuery(true);
		$conditions = array(
				$db->quoteName('goibienche_id').' = '.$db->quote($goibienche_id)				
		);
		$query->delete($db->quoteName('bc_goibienche_hinhthuc'))
		->where($conditions);
		$db->setQuery($query);
		return $db->query();
	}
	public function saveGoibiencheHinhthuc($formData){
		$db = JFactory::getDbo();
		// delete
		$query = $db->getQuery(true);
		$conditions = array(
				$db->quoteName('goibienche_id').' = '.$db->quote($formData['goibienche_id']),
				$db->quoteName('hinhthuc_id').' = '.$db->quote($formData['hinhthuc_id'])
		);
		$query->delete($db->quoteName('bc_goibienche_hinhthuc'))
				->where($conditions);
		$db->setQuery($query);		
		$db->query();
		// insert
		$query = $db->getQuery(true);	
		$columns = array('goibienche_id', 'hinhthuc_id', 'hinhthucdieudong_id');
		$values = array($db->quote($formData['goibienche_id']), $db->quote($formData['hinhthuc_id']), $db->quote($formData['hinhthucdieudong_id']));
		$query
			->insert($db->quoteName('bc_goibienche_hinhthuc'))
			->columns($db->quoteName($columns))
			->values(implode(',', $values));		
		// Set the query using our newly populated query object and execute it.
		$db->setQuery($query);
		return $db->query();				
	}
	public function getHinhThucBiencheById($goibienche_id = null){
		$db = JFactory::getDbo();		
		// kiem tra xem co con hay khong
		if ((int)$goibienche_id > 0 ) {
			$query = 'SELECT a.id,a.name,IF(b.goibienche_id > 0,1,0) AS checked,hinhthucdieudong_id FROM  bc_hinhthuc a LEFT JOIN bc_goibienche_hinhthuc b ON a.ID = b.hinhthuc_id AND  b.goibienche_id = '.$db->quote((int)$goibienche_id);
		}else {
			$query = 'SELECT a.id,a.name FROM  bc_hinhthuc a ';
		}
		//echo $query;		
		$db->setQuery($query);
		return $db->loadAssocList();
	}
}