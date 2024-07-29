<?php
/**
 * Created by PhpStorm.
 * User: huuthanh3108
 * Date: 10/3/13
 * Time: 8:10 AM
 */
class Tochuc_Model_Caytochuc{
    //$nested = new Nested_Set(array('host'=>$JConfig->host,'user'=>$JConfig->user,'password'=>$JConfig->password,'db'=>$JConfig->db,'table'=>'tochuc_caydonvi'));
    private $_tableName = 'tochuc_caytochuc';
    public function create($formData,$option = array()){
        $data = array(
            'name'=>$formData['name'],
            'code'=>$formData['code'],
            'status'=>$formData['status'],
            'code_tochuc_hoso'=>$formData['code_tochuc_hoso']
        );
        foreach($data as $key=>$value){
            if($value == null || $value == ''){
                unset($data[$key]);
            }
        }
        //var_dump($formData['id_parent'],'aaa');exit;
        $JConfig = JFactory::getConfig();
        //$JConfig = $JConfig->get( 'sitename' );
        $config = array(
            'host'=>$JConfig->get('host'),
            'user'=>$JConfig->get('user'),
            'password'=>$JConfig->get('password'),
            'db'=>$JConfig->get('db'),
            'table'=>$this->_tableName,
			'str_id'=>'id',
			'str_id_parent'=>'id_parent'
        );
        //var_dump($config);
        $nested = Core::model('NestedSet',$config);
        //var_dump($formData);
        try{
            return $nested->insertNode($data,$formData['id_parent']);
        }catch (RuntimeException $ex){        	
            JLog::add($ex->__toString(), JLog::ERROR, 'Tochuc_Model_Caytochuc-create');
            return false;
        }

    }
    public function update($id,$formData,$option = array()){
    	$data = array(
    			'name'=>$formData['name'],
    			'code'=>$formData['code'],
    			'status'=>$formData['status'],
    			'code_tochuc_hoso'=>$formData['code_tochuc_hoso']
    	);
    	$JConfig = JFactory::getConfig();
        $config = array(
            'host'=>$JConfig->get('host'),
            'user'=>$JConfig->get('user'),
            'password'=>$JConfig->get('password'),
            'db'=>$JConfig->get('db'),
            'table'=>$this->_tableName,
			'str_id'=>'id',
			'str_id_parent'=>'id_parent'
        );
    	$nested = Core::model('NestedSet',$config);
        try{
            return $nested->updateNode($data,$formData['id'],$formData['id_parent']);
        }catch (RuntimeException $ex){
            JLog::add($ex->__toString(), JLog::ERROR, 'Tochuc_Model_Caytochuc-update');
            var_dump($ex->__toString());
            return false;
        }
    }
    public function read($id,$option = array()){
        $db = JFactory::getDbo();
        $query = 'SELECT * FROM '.$this->_tableName.' WHERE id = '.(int)$id;
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    public function remove($formData,$option = array()){
//     	var_dump($formData['id_parent']);exit;
    	$JConfig = JFactory::getConfig();
    	//$JConfig = $JConfig->get( 'sitename' );
    	$config = array(
    			'host'=>$JConfig->get('host'),
    			'user'=>$JConfig->get('user'),
    			'password'=>$JConfig->get('password'),
    			'db'=>$JConfig->get('db'),
    			'table'=>$this->_tableName,
    			'str_id'=>'id',
    			'str_id_parent'=>'id_parent'
    	);
    	//var_dump($config);
    	$nested = Core::model('NestedSet',$config);
    	//var_dump($formData);
    	try{
    		return $nested->removeNode($formData['id']);
    	}catch (RuntimeException $ex){
    		JLog::add($ex->__toString(), JLog::ERROR, 'Tochuc_Model_Caytochuc-remove');
    		return false;
    	}
    
    }
	public function copyCaytochuc($formData){
		$db = JFactory::getDbo();
		$query = "SELECT id,parent_id AS id_parent,level,lft,rgt FROM ins_dept WHERE id = ".$db->quote($formData['tochuc_saochep']);
		$db->setQuery($query);
		$nodeBranch = $db->loadAssoc();
		
		$query = "SELECT id,level,lft,rgt FROM tochuc_caytochuc WHERE id = ".$db->quote($formData['tochuc_cha']);//echo $query;exit;
		$db->setQuery($query);
		$nodeParent = $db->loadAssoc();

		$widthBranch = $nodeBranch['rgt'] - $nodeBranch['lft'] + 1;
		$deviation = $nodeParent['rgt'] - $nodeBranch['lft'];
		$widthLevel = $nodeBranch['level'] - $nodeParent['level'] + 1;
		
		$query = "UPDATE tochuc_caytochuc 
					SET lft = (lft + ".(int)$widthBranch.")
					WHERE lft > ".(int)$nodeParent['lft'];
		$db->setQuery($query);
		$db->query();

		$query = "UPDATE tochuc_caytochuc
					SET rgt = (rgt + ".(int)$widthBranch.")
					WHERE rgt > ".(int)$nodeParent['rgt'];
		$db->setQuery($query);
		$db->query();
		
		$query = "UPDATE tochuc_caytochuc
					SET rgt = (rgt + ".(int)$widthBranch.")
					WHERE id = ".$db->quote($nodeParent['id']);
		$db->setQuery($query);
		$db->query();
		
		$query = "INSERT INTO tochuc_caytochuc (name,status,code_tochuc_hoso,level,lft,rgt,id_parent)
					SELECT name,1 AS status,id AS code_tochuc_hoso,
							(level + ".(int)$widthLevel.") AS level,
							(lft + ".(int)$deviation.") AS lft,
							(rgt + ".(int)$deviation.") AS rgt,
							parent_id AS id_parent
						FROM ins_dept
						WHERE lft >= ".$db->quote($nodeBranch['lft'])."
							AND rgt <= ".$db->quote($nodeBranch['rgt'])."
						ORDER BY lft";
		$db->setQuery($query);
		$db->query();
		
		$query = "UPDATE tochuc_caytochuc AS a
					LEFT JOIN tochuc_caytochuc AS b ON a.id_parent = b.code_tochuc_hoso
					SET a.id_parent = b.id
					WHERE a.lft > ".(int)$nodeParent['lft']."
						AND a.rgt < ".($nodeParent['rgt'] + $widthBranch);
		$db->setQuery($query);
		$db->query();
		
		if($nodeBranch['id_parent'] == null){
			$str_where = " IS NULL";
		}else{
			$str_where = " = ".$db->quote($nodeBranch['id']);
		}
		$query = "UPDATE tochuc_caytochuc
					SET id_parent = ".$db->quote($nodeParent['id'])."
						WHERE id_parent IS NULL";//echo $query;exit;
		$db->setQuery($query);
		$db->query();
		
		return true;
	}
    public function moveNode($formData){
    	$db = JFactory::getDbo();
    	$ref = $formData['ref'];
    	$query = 'SELECT id,id_parent,level,lft,rgt FROM '.$this->_tableName.' WHERE id = '.(int)$ref;
    	$db->setQuery($query);
    	$node_parent = $db->loadAssoc();
    	$childrens = 0;
    	$query ='SELECT COUNT(*) FROM ' .$this->_tableName.' WHERE id_parent = '.$node_parent['id'];
    	$db->setQuery($query);
    	$childrens = $db->loadResult();
    	
    	$nodeBrother = array();    
    		$query = 'SELECT id,name,id_parent,level,lft,rgt FROM '.$this->_tableName.' WHERE id_parent = '.$node_parent['id'].' ORDER BY lft  LIMIT 1 OFFSET '.$formData['position'];
    		$db->setQuery($query);
    		$nodeBrother = $db->loadAssoc();
    	//var_dump($query,$nodes);
    	//var_dump($formData['id_parent'],'aaa');exit;
    	$JConfig = JFactory::getConfig();
    	//$JConfig = $JConfig->get( 'sitename' );
    	$config = array(
    			'host'=>$JConfig->get('host'),
    			'user'=>$JConfig->get('user'),
    			'password'=>$JConfig->get('password'),
    			'db'=>$JConfig->get('db'),
    			'table'=>$this->_tableName,
    			'str_id'=>'id',
    			'str_id_parent'=>'id_parent'
    	);
    	$nested = Core::model('NestedSet',$config);
    	try {
    		if ((int)$formData['position'] == 0) {
    			$nested->moveNode($formData['id'],$formData['ref'],array('position' => 'left'));
    			//var_dump('left');
    		}
    		elseif ((int)$formData['position'] > 0 && $nodeBrother != null) {
    			$nested->moveNode($formData['id'],$formData['ref'],array('position' => 'before','brother_id'=>$nodeBrother['id']));
    			//var_dump('before');
    		}
    		else{
    			$nested->moveNode($formData['id'],$formData['ref'],array('position' => 'right'));
    			//var_dump('right');
    		}
    		return true;	
    	} catch (Exception $e) {
    		return false;	
    	}   	
    	    	
    }
    public function getChildren($parent_id,$option = array()){
        $db = JFactory::getDbo();
        $query = 'SELECT * FROM '.$this->_tableName.' WHERE id_parent = '.(int)$parent_id .' ORDER BY lft';
        $db->setQuery($query);
        $rows = $db->loadAssocList();
        $arrTypes = array('file','folder','root');
        for ($i = 0, $n = count($rows); $i < $n; $i++){
        	$result[] = array(
        			"attr" => array("id" => "node_".$rows[$i]['id'], "rel" => $arrTypes[$rows[$i]['type']]),
        			"data" => $rows[$i]['name'],
        			"state" => ((int)$rows[$i]['rgt'] - (int)$rows[$i]['left'] > 1) ? "closed" : ""
        	);
        }
        return json_encode($result);
    }
    public function getCaytochucDefault($parent_id, $option = array()){
        $db = JFactory::getDbo();
        $query = 'SELECT * FROM '.$this->_tableName.' WHERE id_parent = '.(int)$parent_id .' ORDER BY lft';
        $db->setQuery($query);
        $rows = $db->loadAssocList();
        $arrTypes = array('file','folder','root');
        for ($i = 0, $n = count($rows); $i < $n; $i++){
        	$result[] = array(
        			"attr" => array("id" => "node_".$rows[$i]['id'], 
        							"rel" => $arrTypes[$rows[$i]['type']],
        							"idTochuc" => $rows[$i]['code_tochuc_hoso']
        						),
        			"data" => $rows[$i]['name'],
        			"state" => ((int)$rows[$i]['rgt'] - (int)$rows[$i]['left'] > 1) ? "closed" : ""
        	);
        }
        return json_encode($result);
    }
    public function getCaytochucHoso($parent_id, $option = array()){
        $db = JFactory::getDbo();
        $query = 'SELECT * 
        				FROM '.$this->_tableName.' AS a
						LEFT JOIN index_dept AS b ON a.code_tochuc_hoso = b.dept_id
        				WHERE a.id_parent = '.(int)$parent_id .' ORDER BY a.lft';
        $db->setQuery($query);
        $rows = $db->loadAssocList();
        $arrTypes = array('file','folder','root');
        for ($i = 0, $n = count($rows); $i < $n; $i++){
        	$result[] = array(
        			"attr" => array("id" => "node_".$rows[$i]['id'], 
        							"rel" => $arrTypes[$rows[$i]['type']],
        							"idTochuc" => $rows[$i]['code_tochuc_hoso']
        						),
        			"data" => $rows[$i]['name']."(".$rows[$i]['total_hoso'].")",
        			"state" => ((int)$rows[$i]['rgt'] - (int)$rows[$i]['left'] > 1) ? "closed" : ""
        	);
        }
        return json_encode($result);
    }
    public function getAllTochuc(){
        $db = JFactory::getDbo();
        $query = "SELECT id,CONCAT(name,' (ID:',id,')') AS name FROM ins_dept";
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getAllCaytochuc(){
    	$db = JFactory::getDbo();
    	$query = "SELECT id,name FROM ".$this->_tableName;
    	$db->setQuery($query);
    	return $db->loadAssocList();
    }
}