<?php
class Tochuc_Model_Adgoihinhthuchuongluong{
	public function delete($id){
		$table = Core::table('Tochuc/Adcbgoihinhthuchuongluong');
		return $table->delete($id);
	}
	public function read($id){
		$table = Core::table('Tochuc/Adcbgoihinhthuchuongluong');
		$table->load($id);
		return $table;
	}
	
	public function getAll(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
				->from($db->quoteName('cb_goihinhthuchuongluong'));	
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	public function save($formData){
		$table = Core::table('Tochuc/Adcbgoihinhthuchuongluong');
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
		$table->bind( $data );
		$table->check();
		$table->store();
		return $table->id;
	}
	public function deleteGoihinhthuchuongluongNangluong($id){
		$db = JFactory::getDbo();
		// delete
		$query = $db->getQuery(true);
		$conditions = array(
				$db->quoteName('goihinhthuchuongluong_id').' = '.$db->quote($id)				
		);
		$query->delete($db->quoteName('cb_goihinhthuchuongluong_hinhthucnangluong'))
		->where($conditions);
		$db->setQuery($query);
		return $db->query();
	}
	public function saveGoihinhthuchuongluongNangluong($formData){
		$db = JFactory::getDbo();
		// insert
		$query = $db->getQuery(true);	
		$columns = array('goihinhthuchuongluong_id', 'whois_sal_mgr_id');
		$values = array($db->quote($formData['goihinhthuchuongluong_id']), $db->quote($formData['whois_sal_mgr_id']));
		$query
			->insert($db->quoteName('cb_goihinhthuchuongluong_hinhthucnangluong'))
			->columns($db->quoteName($columns))
			->values(implode(',', $values));		
		// Set the query using our newly populated query object and execute it.
		$db->setQuery($query);
		return $db->query();				
	}
	public function getGoihinhthuchuongluongById($goihinhthuchuongluong_id = null){
		$db = JFactory::getDbo();		
		// kiem tra xem co con hay khong
		if ((int)$goihinhthuchuongluong_id > 0) {
			$query = 'select wsm.id, wsm.name, IF(fk.whois_sal_mgr_id > 0,1,0) as checked from whois_sal_mgr as wsm
			LEFT JOIN cb_goihinhthuchuongluong_hinhthucnangluong as fk ON fk.whois_sal_mgr_id = wsm.id
			and fk.goihinhthuchuongluong_id = '.$db->quote((int)$goihinhthuchuongluong_id);
		}else {
			$query = 'select wsm.id, wsm.name from whois_sal_mgr as wsm';
		}
		
		$db->setQuery($query);
		return $db->loadAssocList();
	}
}