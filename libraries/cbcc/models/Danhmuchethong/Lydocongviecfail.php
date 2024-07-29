<?php 
	class Danhmuchethong_Model_Lydocongviecfail extends JModelLegacy{
		public function timkiem_lydocongviecfail_byname($tk_dgcbcc_lydocongviecfail_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,heso');
			$query->from('dgcbcc_lydo_congviec_fail');
			if($tk_dgcbcc_lydocongviecfail_name!=null){
				$query->where('name LIKE '.$db->quote('%'.$tk_dgcbcc_lydocongviecfail_name.'%'));
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
		public function add_lydocongviecfail($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			if($form['status']==1){
				$status = $form['status'];
			}
			else{
				$status = 0;
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('heso').'='.$db->quote($form['heso']),
						$db->quotename('status').'='.$db->quote($status));
			$query->insert('dgcbcc_lydo_congviec_fail');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_lydocongviecfail($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,heso');
			$query->from('dgcbcc_lydo_congviec_fail');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function update_lydocongviecfail($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			if($form['status']==1){
				$status = $form['status'];
			}
			else{
				$status = 0;
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('heso').'='.$db->quote($form['heso']),
						$db->quotename('status').'='.$db->quote($status));
			$query->update('dgcbcc_lydo_congviec_fail');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_lydocongviecfail($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('dgcbcc_lydo_congviec_fail');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();		
		}
	}
?>