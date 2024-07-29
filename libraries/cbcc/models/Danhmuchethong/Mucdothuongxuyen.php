<?php 
	class Danhmuchethong_Model_Mucdothuongxuyen extends JModelLegacy{
		public function timkiem_mucdothuongxuyen_byname($tk_dgcbcc_mucdothuongxuyen_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('dgcbcc_mucdothuongxuyen');
			if($tk_dgcbcc_mucdothuongxuyen_name!=null){
				$query->where('name LIKE '.$db->quote('%'.$tk_dgcbcc_mucdothuongxuyen_name.'%'));
			}
			$query->order('id asc');
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function add_mucdothuongxuyen($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$field = array($db->quotename('name').'='.$db->quote($name));
			$query->insert('dgcbcc_mucdothuongxuyen');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_mucdothuongxuyen($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('dgcbcc_mucdothuongxuyen');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function update_mucdothuongxuyen($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			if($form['status']==1){
				$status = $form['status'];
			}
			else{
				$status = 0;
			}
			$field = array($db->quotename('name').'='.$db->quote($name));
			$query->update('dgcbcc_mucdothuongxuyen');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_mucdothuongxuyen($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('dgcbcc_mucdothuongxuyen');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();		
		}
	}
?>