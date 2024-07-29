<?php 
	class Danhmuchethong_Model_Mucdothamgia extends JModelLegacy{
		public function timkiem_mucdothamgia_byname($tk_ten){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status');
			$query->from('dgcbcc_mucdothamgia');
			if($tk_ten&&$tk_ten!=''){
				$query->where('name LIKE '.$db->quote('%'.$tk_ten.'%'));
			}
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function add_mucdothamgia($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']==1){
				$status = '1';
			}
			else{
				$status = '0';
			}
			$name = $this->check_sql_injection($form['name']);
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('status').'='.$db->quote($status));
			$query->insert('dgcbcc_mucdothamgia');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_mucdothamgia_byid($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status');
			$query->from('dgcbcc_mucdothamgia');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function update_mucdothamgia($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']==1){
				$status = '1';
			}
			else{
				$status = '0';
			}
			$name = $this->check_sql_injection($form['name']);
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('status').'='.$db->quote($status));
			$query->update('dgcbcc_mucdothamgia');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_mucdothamgia($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('dgcbcc_mucdothamgia');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
	}
?>