<?php 
	class Danhmuchethong_Model_Goichucvu extends JModelLegacy{
		public function tree_goichucvu($id_parent, $option=array()){
			$db = JFactory::getDbo();
			// $exceptionUnits = Core::getUnManageDonvi(JFactory::getUser()->id, $option['component'], $option['view'], $option['task']);
			// $exception_condition = ($exceptionUnits)?' AND a.id NOT IN ('.$exceptionUnits.')':'';
			// $where = ($option['condition'])?' AND '.$option['condition']:'';
			$query = 'SELECT a.id,a.parent_id,a.name,a.level,a.lft,a.rgt,a.status
								FROM cb_goichucvu AS a
								WHERE a.status = 1  AND a.parent_id = '.$db->quote($id_parent).$exception_condition.$where.'
								ORDER BY a.lft';
			$db->setQuery($query);
			// echo $query;die;
			$rows = $db->loadAssocList();
			$arrTypes = array('file','folder','root');
			for ($i=0;$i<count($rows);$i++){
				$types = '';
				$result[] = array(
						"attr" => array("id" => "node_".$rows[$i]['id'], "rel" => $arrTypes[$rows[$i]['type']], "showlist" => $rows[$i]['type']),
						"data" => $rows[$i]['name'],
						"state" => ((int)$rows[$i]['rgt'] - (int)$rows[$i]['left'] > 1) ? "closed" : ""
						);
			}
			return json_encode($result);
		}
		public function tree_chucvu($id_parent, $option=array()){
			$db = JFactory::getDbo();
			// $exceptionUnits = Core::getUnManageDonvi(JFactory::getUser()->id, $option['component'], $option['view'], $option['task']);
			// $exception_condition = ($exceptionUnits)?' AND a.id NOT IN ('.$exceptionUnits.')':'';
			// $where = ($option['condition'])?' AND '.$option['condition']:'';
			$query = 'SELECT a.id,a.parent_id,a.name,a.level,a.lft,a.rgt,a.status,a.coef,a.chucvu
								FROM pos_system AS a
								WHERE a.status = 1  AND a.parent_id = '.$db->quote($id_parent).$exception_condition.$where.'
								ORDER BY a.lft';
			$db->setQuery($query);
			// echo $query;die;
			$rows = $db->loadAssocList();
			$arrTypes = array('file','folder','root');
			for ($i=0;$i<count($rows);$i++){
				$types = '';
				if($rows[$i]['chucvu']==1&&$rows[$i]['coef']!=null){
					$name = $rows[$i]['name'].' ('.$rows[$i]['coef'].')';
				}
				else{
					$name = $rows[$i]['name'];
				}
				// if((int)$rows[$i]['rgt'] - (int)$rows[$i]['left'] > 1){
				// 	$state = ;
				// }
				// else{
				// 	$state = '';
				// }
				$result[] = array(
						"attr" => array("id" => "node_".$rows[$i]['id'], "rel" => $arrTypes[$rows[$i]['type']], "showlist" => $rows[$i]['type']),
						"data" => $name,
						"state" => ((int)$rows[$i]['rgt'] - (int)$rows[$i]['left'] > 1) ?"closed": ""
						);
			}
			return json_encode($result);
		}
		public function findroot_id(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id as root_id');
			$query->from('cb_goichucvu');
			$query->where('level = 0');
			// $query->group('id');
			// $query->setLimit('1');
			$db->setQuery($query);
			// echo $query;die;
			// $id = $db->loadAssoc();
			// return $id['root_id'];
			return $db->loadResult();
		}
		public function findroot_id_chucvu(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id as root_id');
			$query->from('pos_system');
			$query->where('level = 0');
			// $query->group('id');
			// $query->setLimit('1');
			$db->setQuery($query);
			// echo $query;die;
			// $id = $db->loadAssoc();
			// return $id['root_id'];
			return $db->loadResult();
		}
		static public function getOneNodeJsTree($dept_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select(array('id','name'))->from('cb_goichucvu')->where('id='.$db->quote($dept_id));
			$db->setQuery($query);
			$row = $db->loadAssoc();
			$data = array(
				"attr"=> array(
				"data-type" => $row['type'],
				"id" => "node_".$row['id'],
				// "rel" => (($row['type']==1)?'folder':(($row['type']==2)?'root':'file'))
			),
			"data" => $row['name'],
			"state" => "closed"
			);
			return json_encode($data);
		}
		public function getOneNodeJsTree_chucvu($root_id_chucvu){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select(array('id','name'))->from('pos_system')->where('id='.$db->quote($root_id_chucvu));
			$db->setQuery($query);
			$row = $db->loadAssoc();
			$data = array(
				"attr"=> array(
				"data-type" => $row['type'],
				"id" => "node_".$row['id'],
				// "rel" => (($row['type']==1)?'folder':(($row['type']==2)?'root':'file'))
			),
			"data" => $row['name'],
			"state" => "closed"
			);
			return json_encode($data);
		}
		public function find_goichucvu_byid($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.id,a.name,a.status,(select name from cb_goichucvu where id=a.parent_id) as parent_name,(select name from ins_level where id=a.ins_level_id) as level_name');
			$query->from('cb_goichucvu a');
			$query->where('a.id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function find_chucvu_by_idgoichucvu($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.goichucvu_id,a.pos_system_id,a.name as chucvu_tenkhac,a.capbonhiem,a.thoihanbonhiem,b.name as chucvu_ten,b.coef,b.muctuongduong');
			$query->from('cb_goichucvu_chucvu a');
			$query->join('INNER','pos_system b ON (a.pos_system_id=b.id)');
			$query->where('goichucvu_id='.$db->quote($id));
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssocList();
		}
		public function getall_capbonhiem(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,position');
			$query->from('pos_level');
			$query->where('daxoa!=1');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function add_goichucvu($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']&&$form['status']==1){
				$status = '1';
			}
			else{
				$status = '0';
			}
			$name = $this->check_sql_injection($form['name']);
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('parent_id').'='.$db->quote($form['parent_id']),
						$db->quotename('status').'='.$db->quote($status));
			$query->insert('cb_goichucvu');
			$query->set($field);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function find_chucvu_by_id($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.id,a.name as chucvu_name,a.coef,a.muctuongduong');
			$query->from('pos_system a');
			$query->where('a.id='.$db->quote($id));
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function delete_goichucvu_chucvu($id_goichucvu,$id_chucvu,$tenchucvu){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$tenchucvu = $this->check_sql_injection($tenchucvu);
			$query->delete('cb_goichucvu_chucvu');
			$query->where('goichucvu_id='.$db->quote($id_goichucvu));
			$query->where('pos_system_id='.$db->quote($id_chucvu));
			$query->where('name='.$db->quote($tenchucvu));
			$db->setQuery($query);
			return $db->query();
		}
		public function add_goichucvu_chucvu($goichucvu_id,$chucvu_id,$name_chucvu,$thoihanbonhiem,$capbonhiem){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$goichucvu_id = $this->check_sql_injection($goichucvu_id);
			$chucvu_id = $this->check_sql_injection($chucvu_id);
			$name_chucvu = $this->check_sql_injection($name_chucvu);
			$thoihanbonhiem = $this->check_sql_injection($thoihanbonhiem);
			$capbonhiem = $this->check_sql_injection($capbonhiem);
			$field = array($db->quotename('goichucvu_id').'='.$db->quote($goichucvu_id),
						$db->quotename('pos_system_id').'='.$db->quote($chucvu_id),
						$db->quotename('name').'='.$db->quote($name_chucvu),
						$db->quotename('capbonhiem').'='.$db->quote($capbonhiem),
						$db->quotename('thoihanbonhiem').'='.$db->quote($thoihanbonhiem));
			$query->insert('cb_goichucvu_chucvu');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_goichucvu_chucvu_bygoichucvu($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$id = $this->check_sql_injection($id);
			$query->delete('cb_goichucvu_chucvu');
			$query->where('goichucvu_id='.$db->quote($id));
			// echo $query;die;
			$db->setQuery($query);
			return $db->query();
		}
		public function update_goichucvu($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']&&$form['status']==1){
				$status = '1';
			}
			else{
				$status = '0';
			}
			$name = $this->check_sql_injection($form['name']);
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('status').'='.$db->quote($status));
			$query->update('cb_goichucvu');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);			
			return $db->query();
		}
		public function delete_goichucvu($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('cb_goichucvu');
			$query->where('id='.$db->quote($id));
			// echo $query;die;
			$db->setQuery($query);
			return $db->query();
		}
	}
?>