<?php
class Tochuc_Model_Adgoichucvu{

	public function delete($node_id){
		$table = Core::table('Tochuc/Adgoichucvu');
		return $table->delete($node_id);
	}
	public function rebuild(){
		$table = Core::table('Tochuc/Adgoichucvu');	
		if (!$table->rebuild()) {
			JFactory::getApplication()->enqueueMessage($table->getError(),'error');
			return false;
		}
		return true;
	}
	
	public function save($formData){
		$table = Core::table('Tochuc/Adgoichucvu');
		$reference_id = (int)$formData['parent_id'];
		if ($reference_id == 0 ) {
			$reference_id = $table->getRootId();
		}
		if ($reference_id === false) {
			//$reference_id = $table->addRoot();
			return false;
		}
		//var_dump($formData);exit;
		//check new or edit
		if ((int)$formData['id'] > 0 ) {
			//$table->load($formData['id']);
			if ($table->parent_id == $reference_id) {
				unset($formData['parent_id']);
				$table->bind( $formData );
				$table->store();
			}else{
				$table->setLocation( $reference_id, 'last-child' );
				$table->bind( $formData );
				$table->check();
				$table->store();
			}
		}else{
			//new
			// Bind data to the table object.
			if (count($formData) > 0 ) {
				foreach ($formData as $key => $value) {
					if ($value == '') {
						unset($formData[$key]);
					}
				}
			}
			$table->setLocation( $reference_id, 'last-child' );
			$table->bind( $formData );
			// Force a new node to be created.
			$table->id = 0;			
			// Check that the node data is valid.
			$table->check();			
			// Store the node in the database table.
			$table->store(true);			
		}
		return $table->id;
	}
	public function saveGoichucvuChucvu($goichucvu_id,$formData){
		Core::delete('cb_goichucvu_chucvu', array('goichucvu_id = '=>$goichucvu_id));		
		for ($i = 0; $i < count($formData['pos_system']); $i++) {
			Core::insert('cb_goichucvu_chucvu', array('goichucvu_id'=>$goichucvu_id,'pos_system_id'=>$formData['pos_system'][$i],'name'=>$formData['pos_name'][$i],'thoihanbonhiem'=>$formData['thoihanbonhiem'][$i],'capbonhiem'=>$formData['capbonhiem'][$i],'sapxep'=>$formData['sapxep'][$i]));
		}
	}
	public function deleteGoichucvuChucvu($goichucvu_id){
		Core::delete('cb_goichucvu_chucvu', array('goichucvu_id = '=>$goichucvu_id));	
	}
	public function read($id){
		$table = Core::table('Tochuc/Adgoichucvu');
		$table->load($id);
		return $table;
	}
	public function getChucvuByIdGoichucvu($goichucvu_id){
		$db = JFactory::getDbo();
		$query = 'SELECT a.*,b.name as pos_name, b.coef, b.muctuongduong FROM cb_goichucvu_chucvu a LEFT JOIN pos_system b ON a.pos_system_id = b.id WHERE a.goichucvu_id = '.$db->quote((int)$goichucvu_id);
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	public function getChucvuByIdGoichucvu_cv($goichucvu_id){
		$db = JFactory::getDbo();
		$query = 'SELECT a.*,b.name as pos_name, b.coef, c.`level` as muctuongduong, c.position
			FROM cb_goichucvu_chucvu a 
			LEFT JOIN pos_system b ON a.pos_system_id = b.id 
			LEFT JOIN pos_level AS c ON b.muctuongduong = c.`level` WHERE a.goichucvu_id = '.$db->quote((int)$goichucvu_id);
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	public function getHesoById($id){
		$db = JFactory::getDbo();
// 		$query = 'SELECT a.coef, b.`level` as muctuongduong, b.position 
// 			FROM  pos_system as a
// 			LEFT JOIN pos_level AS b ON a.muctuongduong = b.`level`  WHERE a.id = '.$db->quote((int)$id);
		$query = 'SELECT a.coef, a.muctuongduong, a.capbonhiem, a.thoihanbonhiem
			FROM  pos_system as a
			  WHERE a.id = '.$db->quote((int)$id);
		$db->setQuery($query);
		return $db->loadAssoc();
	}
	public function moveNode($id,$parent_id){
		$table = Core::table('Tochuc/Adgoichucvu');
		$table->load($id);
		$table->parent_id = $parent_id;
		return $table->store();
	}
}