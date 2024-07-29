<?php 
	class Danhmuchethong_Model_Goibienche extends JModelLegacy{
		public function getall_goibienche(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,active');
			$query->from('bc_goibienche');
			$query->order('id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function getall_bienche_hinhthuc(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('bc_hinhthuc');
			$query->order('id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function luu_goibienche($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name_goibienche = $this->check_sql_injection($form['name']);
			if($form['active']==''){
				$active = '0';
			}
			else{
				$active = $form['active'];
			}
			$field = array($db->quotename('name').'='.$db->quote($name_goibienche),
						$db->quotename('active').'='.$db->quote($active));
			$query->insert('bc_goibienche');
			$query->set($field);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();
		}
		public function delete_goibienche($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('bc_goibienche');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function find_goibienche($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,active');
			$query->from('bc_goibienche');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function update_goibienche($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name_goibienche = $this->check_sql_injection($form['name']);
			if($form['active']==''){
				$active = '0';
			}
			else{
				$active = $form['active'];
			}
			$field = array($db->quotename('name').'='.$db->quote($name_goibienche),
						$db->quotename('active').'='.$db->quote($active));
			$query->update('bc_goibienche');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			$db->query();
			return $form['id'];
		}
		public function luu_goibienche_hinhthuc($id_goibienche,$hinhthuc,$dieudong){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('goibienche_id').'='.$db->quote($id_goibienche),
						$db->quotename('hinhthuc_id').'='.$db->quote($hinhthuc),
						$db->quotename('hinhthucdieudong_id').'='.$db->quote($dieudong));
			$query->insert('bc_goibienche_hinhthuc');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_goibienche_hinhthuc($goibienche_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('goibienche_id,hinhthuc_id,hinhthucdieudong_id');
			$query->from('bc_goibienche_hinhthuc');
			$query->where('goibienche_id='.$db->quote($goibienche_id));
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function delete_goibienche_hinhthuc_byid($goibienche_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('bc_goibienche_hinhthuc');
			$query->where('goibienche_id='.$db->quote($goibienche_id));
			$db->setQuery($query);
			return $db->query();
		}
	}
?>