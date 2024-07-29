<?php
class Tochuc_Model_Danhsachtochuc{
    //$nested = new Nested_Set(array('host'=>$JConfig->host,'user'=>$JConfig->user,'password'=>$JConfig->password,'db'=>$JConfig->db,'table'=>'tochuc_caydonvi'));
    private $_tableName = 'ins_dept';
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
        $data = new stdClass();
        $data->id = $formData['id'];
        $data->name = $formData['name'];
        $data->code = $formData['code'];
        $data->status = (int)$formData['status'];
        $data->code_tochuc_hoso = $formData['code_tochuc_hoso'];
        //var_dump($formData);
        try{
            $db = JFactory::getDbo();
            $db->updateObject($this->_tableName,$data,'id');
            return true;
        }catch (RuntimeException $ex){
            JLog::add($ex->__toString(), JLog::ERROR, 'Tochuc_Model_Caytochuc-update');
            var_dump($ex->__toString());
            return false;
        }
    }
    public function read($id,$option = array()){
        $db = JFactory::getDbo();
       /*  $sql = "SELECT a.id,a.name,a.s_name,a.code,a.parent_id,b.name AS parent_name,c.name AS ins_created_name,
						a.type,a.type_created,a.diachi,a.dienthoai,a.email,
						DATE_FORMAT(a.date_created,'%d/%m/%Y') date_created,
						a.number_created,a.ins_created,a.ins_lv,a.ins_lv1,a.ins_lv2,a.ins_lv3,a.active,a.ghichu,a.loaihinhbienche,a.ins_loaihinh,
						a.goiluong,a.ins_cap,a.captochuc,a.ins_loaihinh2,
						a.giao_bc,a.number_bc,a.year_bc,a.rep_hc_parent_id,a.rep_hc_exp_lev,a.rep_hc_name
					FROM ins_dept a
					LEFT JOIN ins_dept b ON a.parent_id = b.id
					LEFT OUTER JOIN ins_dept c ON a.ins_created = c.id
					WHERE a.id  = ".$db->quote($id); */
        $sql = "SELECT a.id,a.name,a.s_name,a.code,a.parent_id,b.name AS parent_name,c.name AS ins_created_name,
						a.type,a.type_created,a.diachi,a.dienthoai,a.email,
						DATE_FORMAT(a.date_created,'%d/%m/%Y') date_created,
						a.number_created,a.ins_created,a.ins_level,a.active,a.ghichu,a.ins_loaihinh, 
						a.goiluong,a.ins_cap, a.giao_bc,a.number_bc,a.year_bc,a.rep_hc_parent_id,a.rep_hc_exp_lev,a.rep_hc_name 
						FROM ins_dept a
					LEFT JOIN ins_dept b ON a.parent_id = b.id
					LEFT OUTER JOIN ins_dept c ON a.ins_created = c.id
					WHERE a.id  = ".$db->quote($id);
        
        $db->setQuery($sql);
        return $db->loadAssoc();
    }
    public function getChildren($parent_id,$option = array()){
        $db = JFactory::getDbo();
        $sql = "SELECT a.id,a.lft,a.rgt
        			FROM ins_dept AS a
        			WHERE a.id = ".$db->quote($parent_id);
        $db->setQuery($sql);
        $node = $db->loadAssoc();
        
        $sql = "SELECT node.id,node.parent_id,node.type,node.name,node.lft,node.rgt,node.level,
        				IF(((node.rep_hc_name IS NOT NULL) AND (node.rep_hc_name <> NULL)),node.rep_hc_name,node.name) AS name_hc,
        				(CASE node.loaihinhbienche WHEN ((IFNULL(node.loaihinhbienche,0) <> 3) AND (node.rep_hc_parent_id > 0)) THEN 1 ELSE 0 END) AS hanhchinh,
        				IF((node.rgt = (node.rgt + 1)),0,1) AS haschildrent,
        				node.loaihinhbienche AS loaihinh
        			FROM (ins_dept AS parent JOIN ins_dept AS node)
        			WHERE node.level = (parent.level + 1)
        				AND node.lft > parent.lft
        				AND node.rgt < parent.rgt
        				AND node.active = 1
        				AND parent.lft = ".$node['lft']." 
        			ORDER BY node.lft";
        $db->setQuery($sql);
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
    public function moveNode($formData){
    	$db = JFactory::getDbo();
    	$ref = $formData['ref'];
    	$sql = 'SELECT id,parent_id,level,lft,rgt FROM '.$this->_tableName.' WHERE id = '.(int)$ref;
    	$db->setQuery($sql);
    	$node_parent = $db->loadAssoc();
    	$childrens = 0;
    	$sql ='SELECT COUNT(*) FROM ' .$this->_tableName.' WHERE parent_id = '.$node_parent['id'];
    	$db->setQuery($sql);
    	$childrens = $db->loadResult();
    	
    	$nodeBrother = array();
		$sql = 'SELECT id,name,parent_id,level,lft,rgt FROM '.$this->_tableName.' WHERE parent_id = '.$node_parent['id'].' ORDER BY lft  LIMIT 1 OFFSET '.$formData['position'];
		$db->setQuery($sql);
		$nodeBrother = $db->loadAssoc();
    	//var_dump($sql,$nodes);
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
    			'str_id_parent'=>'parent_id'
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
    public function getAllTochuc(){
        $db = JFactory::getDbo();
        $sql = 'SELECT code,name,status FROM tochuc_hoso';
        $db->setQuery($sql);
        return $db->loadAssocList();
    }
}