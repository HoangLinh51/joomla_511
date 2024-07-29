<?php
class Tochuc_Model_Adlinhvuc{
	public function rebuild(){
		$table = Core::table('Tochuc/Adlinhvuc');
		return $table->rebuild();
	}
	public function delete($node_id){
		$table = Core::table('Tochuc/Adlinhvuc');
		return $table->delete($node_id);
	}
	public function moveNode($node_id,$reference_id){
		$table = Core::table('Tochuc/Adlinhvuc');
		$table->load($node_id);
		$table->parent_id = $reference_id;
		$table->check();
		return $table->store();
	}
	public function save($formData){

		$table = Core::table('Tochuc/Adlinhvuc');
		$reference_id = (int)$formData['parent_id'];
		if ($reference_id == 0 ) {
			$reference_id = $table->getRootId();
		}
		if ($reference_id === false) {
			$reference_id = $table->addRoot();
		}		
		//var_dump($formData);exit;
		//check new or edit
		if ((int)$formData['id'] > 0 ) {
			if($reference_id != Core::loadResult('cb_type_linhvuc', array('parent_id'), array('id = '=>$formData['id']))){				
				$table->setLocation( $reference_id, 'last-child' );
 			} 		
 			$table->bind($formData); 
 			$table->check();
 			$table->store();
 			//Core::update('cb_type_linhvuc', $formData, 'id',true);
		}else{
			//new
			$table->setLocation( $reference_id, 'last-child' );
			// Bind data to the table object.
			if (count($formData) > 0 ) {
				foreach ($formData as $key => $value) {
					if ($value == '') {
						unset($formData[$key]);
					}
				}
			}
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

	public function read($id){
		$table = Core::table('Tochuc/Adlinhvuc');
		$table->load($id);
		return $table;
	}
	public function update($formData){
		$table = Core::table('Tochuc/Adlinhvuc');
		$reference_id = (int)$formData['parent_id'];
		// Specify where to insert the new node.
		$table->setLocation( $reference_id, 'last-child' );
		// Bind data to the table object.
		if (count($formData) > 0 ) {
			foreach ($formData as $key => $value) {
				if ($value == '') {
					unset($formData[$key]);
				}
			}
		}
		$table->bind( $formData );
		// Check that the node data is valid.
		$table->check();
		// Store the node in the database table.
		$table->store(true);
		return $table->id;
	}

}