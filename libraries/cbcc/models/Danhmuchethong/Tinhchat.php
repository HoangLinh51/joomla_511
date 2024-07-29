<?php 
	class Danhmuchethong_Model_Tinhchat extends JModelLegacy{
		public function timkiem_tinhchat_byname($tk_dgcbcc_tinhchat_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status');
			$query->from('dgcbcc_tinhchat');
			if($tk_dgcbcc_tinhchat_name!=null){
				$query->where('name LIKE '.$db->quote('%'.$tk_dgcbcc_tinhchat_name.'%'));
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
		public function add_tinhchat($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			if($form['status']==1){
				$status = 1;
			}
			else{
				$status = 0;
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('status').'='.$db->quote($status));
			$query->insert('dgcbcc_tinhchat');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_tinhchat($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status');
			$query->from('dgcbcc_tinhchat');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function update_tinhchat($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			if($form['status']==1){
				$status = 1;
			}
			else{
				$status = 0;
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('status').'='.$db->quote($status));
			$query->update('dgcbcc_tinhchat');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_tinhchat($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('dgcbcc_tinhchat');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();		
		}
	}
?>