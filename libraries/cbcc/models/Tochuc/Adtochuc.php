<?php
class Tochuc_Model_Adtochuc{

	public function rebuild(){
		$table = Core::table('Tochuc/Adtochuc');
		return $table->rebuild();		
	}
	public function orderUp($id){
		$table = Core::table('Tochuc/Adtochuc');
		//var_dump($id);
		return $table->orderUp( $id );
	}
	public function orderDown($id){
		$table = Core::table('Tochuc/Adtochuc');
		//var_dump($id);
		return $table->orderDown( $id );
	}
	public function moveNode($formData){
		try {
    	// $db = JFactory::getDbo();
    	// $ref = $formData['ref'];
    	// $query = 'SELECT * FROM ins_dept WHERE id = '.(int)$ref;
		// $db->setQuery($query);
		$tmp = new stdClass();
		$tmp->id = $formData['id'];
		$tmp->parent_id = $formData['ref'];
		Core::update('ins_dept', $tmp, 'id');
    	// $node_parent = $db->loadAssoc();
    	// $childrens = 0;
    	// $query ='SELECT COUNT(*) FROM ins_dept WHERE parent_id = '.$node_parent['id'];
    	// $db->setQuery($query);
    	// $childrens = $db->loadResult();
    	
    	// $nodeBrother = array();    
    	// 	$query = 'SELECT id,name,parent_id,level,lft,rgt FROM ins_dept WHERE parent_id = '.$node_parent['id'].' ORDER BY lft  LIMIT 1 OFFSET '.$formData['position'];
    	// 	$db->setQuery($query);
    	// 	$nodeBrother = $db->loadAssoc();
    	// $JConfig = JFactory::getConfig();
    	// $config = array(
    	// 		'host'=>$JConfig->get('host'),
    	// 		'user'=>$JConfig->get('user'),
    	// 		'password'=>$JConfig->get('password'),
    	// 		'db'=>$JConfig->get('db'),
    	// 		'table'=>'ins_dept',
    	// 		'str_id'=>'id',
    	// 		'str_id_parent'=>'parent_id'
    	// );
    	// $nested = Core::model('NestedSet',$config);
    	// 	if ((int)$formData['position'] == 0) {
    	// 		$nested->moveNode($formData['id'],$formData['ref'],array('position' => 'left'));
    	// 		//var_dump('left');
    	// 	}
    	// 	elseif ((int)$formData['position'] > 0 && $nodeBrother != null) {
    	// 		$nested->moveNode($formData['id'],$formData['ref'],array('position' => 'before','brother_id'=>$nodeBrother['id']));
    	// 		//var_dump('before');
    	// 	}
    	// 	else{
    	// 		$nested->moveNode($formData['id'],$formData['ref'],array('position' => 'right'));
    	// 		//var_dump('right');
    	// 	}
    		return $formData['id'];	
    	} catch (Exception $e) {
    		return false;	
    	}   	
    }
    public function copyCaytochuc($formData){
		$db = JFactory::getDbo();
		$ref = $db->quote($formData['ref']);
		$id = $db->quote($formData['id']);
		$time = strtotime(date('hisv'));
		$db->getQuery(true);
		$query ="
			DROP TEMPORARY TABLE IF EXISTS tmptable_".$time.";
		";
		$db->setQuery($query);
		$db->query();
		$db->getQuery(true);
		$query ="
			CREATE TEMPORARY TABLE IF NOT EXISTS tmptable_".$time." SELECT * FROM ins_dept WHERE id = ".$id.";
		";
		$db->setQuery($query);
		$db->query();
		$db->getQuery(true);
		$query ="
			UPDATE tmptable_".$time." SET id = NULL, parent_id = ".$ref.";
		";
		$db->setQuery($query);
		$db->query();
		$db->getQuery(true);
		$query ="
			INSERT INTO ins_dept SELECT * FROM tmptable_".$time.";
		";
		$db->setQuery($query);
		$db->query();
		$id = $db->insertid();
		$db->getQuery(true);
		$query ="
			DROP TEMPORARY TABLE IF EXISTS tmptable_".$time.";
		";
		$db->setQuery($query);
		$db->query();
		return $id;
	}
}