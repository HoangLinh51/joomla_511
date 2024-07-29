<?php 
	class Danhmuchethong_Model_goihinhthuchuongluong extends JModelLegacy{
		public function getall_goihinhthuchuongluong(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status');
			$query->from('cb_goihinhthuchuongluong');
			$query->order('id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function getall_hinhthucnangluong(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('whois_sal_mgr');
			$query->order('id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function luu_goihinhthuchuongluong($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name_goihinhthuchuongluong = $this->check_sql_injection($form['name']);
			if($form['status']==''){
				$status = '0';
			}
			else{
				$status = $form['status'];
			}
			$field = array($db->quotename('name').'='.$db->quote($name_goihinhthuchuongluong),
						$db->quotename('status').'='.$db->quote($status));
			$query->insert('cb_goihinhthuchuongluong');
			$query->set($field);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();
		}
		public function delete_goihinhthuchuongluong($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('cb_goihinhthuchuongluong');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function find_goihinhthuchuongluong($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status');
			$query->from('cb_goihinhthuchuongluong');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function update_goihinhthuchuongluong($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name_goihinhthuchuongluong = $this->check_sql_injection($form['name']);
			if($form['status']==''){
				$status = '0';
			}
			else{
				$status = $form['status'];
			}
			$field = array($db->quotename('name').'='.$db->quote($name_goihinhthuchuongluong),
						$db->quotename('status').'='.$db->quote($status));
			$query->update('cb_goihinhthuchuongluong');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			$db->query();
			return $form['id'];
		}
		public function luu_goihinhthuchuongluong_htnl($id_goihinhthuchuongluong,$hinhthucnangluong){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('goihinhthuchuongluong_id').'='.$db->quote($id_goihinhthuchuongluong),
						$db->quotename('whois_sal_mgr_id').'='.$db->quote($hinhthucnangluong));
			$query->insert('cb_goihinhthuchuongluong_hinhthucnangluong');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_goihinhthuchuongluong_htnl($goihinhthuchuongluong_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('goihinhthuchuongluong_id,whois_sal_mgr_id');
			$query->from('cb_goihinhthuchuongluong_hinhthucnangluong');
			$query->where('goihinhthuchuongluong_id='.$db->quote($goihinhthuchuongluong_id));
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function delete_goihinhthuchuongluong_htnl_byid($goihinhthuchuongluong_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('cb_goihinhthuchuongluong_hinhthucnangluong');
			$query->where('goihinhthuchuongluong_id='.$db->quote($goihinhthuchuongluong_id));
			$db->setQuery($query);
			return $db->query();
		}
	}
?>