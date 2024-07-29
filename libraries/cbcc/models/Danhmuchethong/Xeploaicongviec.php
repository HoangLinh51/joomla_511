<?php 
	class Danhmuchethong_Model_Xeploaicongviec extends JModelLegacy{
		public function timkiem_xeploaicongviec_byname($tk_dgcbcc_xeploaicongviec_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,data');
			$query->from('dgcbcc_congviec_xeploai');
			if($tk_dgcbcc_xeploaicongviec_name!=null){
				$query->where('name LIKE '.$db->quote('%'.$tk_dgcbcc_xeploaicongviec_name.'%'));
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
		public function add_xeploaicongviec($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$data = $this->check_sql_injection($form['data']);
			if($form['status']==1){
				$status = 1;
			}
			else{
				$status = 0;
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('data').'='.$db->quote($data),
						$db->quotename('status').'='.$db->quote($status));
			$query->insert('dgcbcc_congviec_xeploai');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_xeploaicongviec($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,data');
			$query->from('dgcbcc_congviec_xeploai');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function update_xeploaicongviec($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$data = $this->check_sql_injection($form['data']);
			if($form['status']==1){
				$status = 1;
			}
			else{
				$status = 0;
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('data').'='.$db->quote($data),
						$db->quotename('status').'='.$db->quote($status));
			$query->update('dgcbcc_congviec_xeploai');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_xeploaicongviec($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('dgcbcc_congviec_xeploai');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();		
		}
	}
?>