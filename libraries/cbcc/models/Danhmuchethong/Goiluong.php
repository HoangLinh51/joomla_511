<?php 
	class Danhmuchethong_Model_Goiluong extends JModelLegacy{
		public function tree_goiluong($id_parent, $option=array()){
			$db = JFactory::getDbo();
			// $exceptionUnits = Core::getUnManageDonvi(JFactory::getUser()->id, $option['component'], $option['view'], $option['task']);
			// $exception_condition = ($exceptionUnits)?' AND a.id NOT IN ('.$exceptionUnits.')':'';
			// $where = ($option['condition'])?' AND '.$option['condition']:'';
			$query = 'SELECT a.id,a.parent_id,a.name,a.level,a.lft,a.rgt,a.status
						FROM cb_goiluong AS a
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
		public function findroot_id(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id as root_id');
			$query->from('cb_goiluong');
			$query->where('level = 0');
			// $query->group('id');
			// $query->setLimit('1');
			$db->setQuery($query);
			// echo $query;die;
			// $id = $db->loadAssoc();
			// return $id['root_id'];
			return $db->loadResult();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		static public function getOneNodeJsTree($dept_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select(array('id','name'))->from('cb_goiluong')->where('id='.$db->quote($dept_id));
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
		public function find_luongbyid($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.id,a.name,a.status,(select name from cb_goiluong where a.parent_id=id) as parent_name');
			$query->from('cb_goiluong a');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function add_goiluong($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			if($form['status']&&$form['status']==1){
				$status = '1';
			}
			else{
				$status = '0';
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
					$db->quotename('parent_id').'='.$db->quote($form['parent_id']),
					$db->quotename('status').'='.$db->quote($status));
			$query->insert('cb_goiluong');
			$query->set($field);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();		
		}
		public function update_goiluong($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			if($form['status']&&$form['status']==1){
				$status = '1';
			}
			else{
				$status = '0';
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
					$db->quotename('status').'='.$db->quote($status));
			$query->update('cb_goiluong');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			$db->query();
			return $form['id'];
		}
		public function getall_function_code(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('function_code');
			$query->where('daxoa!=1');
			$query->where('status=1');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function find_ngach_by_function_code($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,mangach,idnganh');
			$query->from('cb_bac_heso');
			$query->where('idnganh='.$db->quote($id));
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssocList();
		}
		public function add_goiluong_ngach($id_goiluong,$id_ngach,$mangach){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('id_goi').'='.$db->quote($id_goiluong),
					$db->quotename('ngach').'='.$db->quote($mangach),
					$db->quotename('id_ngach').'='.$db->quote($id_ngach));
			$query->insert('cb_goiluong_ngach');
			// echo '123';die;
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_luong_by_goiluong($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id_goi,id_ngach,ngach');
			$query->from('cb_goiluong_ngach');
			$query->where('id_goi='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function delete_goiluong_ngach_by_goiluong($id_goiluong){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('cb_goiluong_ngach');
			$query->where('id_goi='.$db->quote($id_goiluong));
			$db->setQuery($query);
			return $db->query();
		}
		public function find_mangach_by_idngach($id_ngach){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('mangach');
			$query->from('cb_bac_heso');
			$query->where('id='.$db->quote($id_ngach));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function delete_goiluong($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('cb_goiluong');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
	}
?>