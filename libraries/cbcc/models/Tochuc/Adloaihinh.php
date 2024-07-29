<?php
class Tochuc_Model_Adloaihinh {

	public function delete($node_id){
		$table = Core::table('Tochuc/Adloaihinh');
		return $table->delete($node_id);
	}
	public function moveNode($node_id,$reference_id){
		$table = Core::table('Tochuc/Adloaihinh');
		$table->load($node_id);
		$table->parent_id = $reference_id;
		$table->check();
		return $table->store();
	}
	public function save($formData){
		$table = Core::table('Tochuc/Adloaihinh');
		$reference_id = (int)$formData['parent_id'];
		if ($reference_id == 0 ) {
			$reference_id = $table->getRootId();
		}
		if ($reference_id === false) {
			$reference_id = $table->addRoot();
		}
		// Bind data to the table object.
		if (count($formData) > 0 ) {
			foreach ($formData as $key => $value) {
				if ($value == '') {
					unset($formData[$key]);
				}
			}
		}
		//var_dump($formData);exit;
		//check new or edit
		if ((int)$formData['id'] > 0 ) {
			$table->load($formData['id']);
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

	public function read($id){
		$table = Core::table('Tochuc/Adloaihinh');
		$table->load($id);
		return $table;
	}
}