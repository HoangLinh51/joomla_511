<?php

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseModel;
use Joomla\CMS\Table\Table;

class Baocao_Model_Caybaocao extends BaseModel{

	public function delete($node_id){
		$table = Core::table('Baocao/Caybaocao');
		return $table->delete($node_id);
	}
	public function rebuild(){
		$table = Core::table('Baocao/Caybaocao');
		return $table->rebuild();		
	}
	public function insertNode($parent_id = 0, $id = 0, $data=array(), $level = 0) {
		$db = Factory::getDbo();
		$table = Core::table('Baocao/Caybaocao');
		$query = $db->getQuery(true)
		->select(array('id','name','parent_id', 'type', 'ins_loaihinh'))
		->from('ins_dept')
 		->where(' id = '.$parent_id)
		->where(' level <= '.(int)$level)
 		->where(' active = 1 ')
		;
		$db->setQuery($query);
		$row = $db->loadAssoc();
		$reference_id = (int)$id;
		
		$table->setLocation( $reference_id, 'last-child' );
		$table->bind( array('name'=> $row['name'], 'ins_dept'=>$row['id'], 'type'=> $row['type'], 'ins_loaihinh'=> $row['ins_loaihinh'], 'report_group_code'=>$data['report_group_code'], 'report_group_name'=>$data['report_group_name']) ); 

		$table->check();
		$table->store();
		$id = $table->id;
	
		$query = $db->getQuery(true)
		->select(array('id','name','parent_id','type', 'ins_loaihinh'))
		->from('ins_dept')
		->where('parent_id = '.$parent_id)
 		->where(' level <= '.(int)$level)
  		->where(' active = 1 ')
		;
		$db->setQuery($query);
		$rows = $db->loadAssocList();
		for ($i = 0; $i < count($rows); $i++) {
			$row = $rows[$i];
			$this->insertNode($row['id'],$id, $data, $level);
		}
		return $id;
	}
	public function save($formData){
		$table = Core::table('Baocao/Caybaocao');
		$reference_id = (int)$formData['parent_id'];
		$all_child = (int)$formData['all_child'];
		$ins_dept = (int)$formData['ins_dept'];
		if ($reference_id == 0 ) {
			$reference_id = $table->getRootId();
		}
		if ($reference_id === false) {
			return false;
		}
		//check new or edit
		if ((int)$formData['id'] > 0 ) { // Tree Report edit
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
			// Tree report new
			if (count($formData) > 0 ) {
				foreach ($formData as $key => $value) {
					if ($value == '') {
						unset($formData[$key]);
					}
				}
			}
			if ($all_child > 0) {
				// get level of ins_dept
				$db = Factory::getDbo();
				$table = Table::getInstance( 'Caybaocao', 'BaocaohosoTable' );
				$query = $db->getQuery(true)
				->select(array('level'))
				->from('ins_dept')
				->where('id = '.$ins_dept)
				;
				$db->setQuery($query);
				// level extension of tree report
				$level =$all_child + (int)$db->loadResult();
				$data = array();
				$data['report_group_code'] = $formData['report_group_code'];
				$data['report_group_name'] = $formData['report_group_name'];
				
				$id = $this->insertNode($ins_dept, $reference_id, $data, $level );
				if ($id) {
					return $id;
				}
			}else {
				$table->setLocation( $reference_id, 'last-child' );
				$table->bind( $formData );
				// Force a new node to be created.
				$table->id = 0;
				// Check that the node data is valid.
				$table->check();
				// Store the node in the database table.
				$table->store(true);
			}
		}
		return $table->id;
	}
	public function read($id){
		$table = Core::table('Baocao/Caybaocao');
		$table->load($id);
		return $table;
	}
	public function moveNode($id,$parent_id){
		$table = Core::table('Baocao/Caybaocao');
		$table->load($id);
		$table->parent_id = $parent_id;
		return $table->store();
	}
	// Chuyển đổi tử API
	public function _buildTree($parent,$table){
	    $db = Factory::getDbo();
	    $rows = array();
	    $where = array();
	    $data = array();
	
	    if ($parent == 0) {
	        $where[] = '(a.parent_id = '.(int)$parent.' OR a.parent_id IS NULL)';
	    }else{
	        $where[] = 'a.parent_id = '.(int)$parent;
	    }
	
	    $result = array();
	    $where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
	    $order = ' ORDER BY a.name COLLATE utf8_unicode_ci';
	    $query = 'SELECT a.id,a.parent_id AS parent,a.name AS text, (SELECT COUNT(id) FROM '.$db->quoteName($table).' WHERE parent_id = a.id) AS children  FROM '.$db->quoteName($table,'a').$where.$order;
	    $db->setQuery($query);
	    $rows = $db->loadAssocList();
	    for ($i = 0; $i < count($rows); $i++) {
	        $row = $rows[$i];
	        $children = (($row['children'] > 0 )?true:false);
	        $data[] = array(
	            "attr" => array("id" => "node_".$rows[$i]['id'],"rel" => (($children)?'folder':'file')),
	            "data" => $rows[$i]['text'],
	            "state" => ($children) ? "closed" : ""
	        );
	    }
	    return $data;
	}
}