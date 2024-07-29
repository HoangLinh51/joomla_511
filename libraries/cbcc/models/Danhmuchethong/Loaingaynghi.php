<?php 
	class Danhmuchethong_Model_Loaingaynghi extends JModelLegacy{
		public function timkiem_loaingaynghi_byname($tk_dgcbcc_loaingaynghi_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,mota,titrong');
			$query->from('dgcbcc_loaingaynghi');
			if($tk_dgcbcc_loaingaynghi_name!=null){
				$query->where('name LIKE '.$db->quote('%'.$tk_dgcbcc_loaingaynghi_name.'%'));
			}
			$query->order('id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function add_loaingaynghi($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$mota = $this->check_sql_injection($form['mota']);
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('mota').'='.$db->quote($mota),
						$db->quotename('titrong').'='.$db->quote($form['titrong']));
			$query->insert('dgcbcc_loaingaynghi');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_loaingaynghi($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,mota,titrong');
			$query->from('dgcbcc_loaingaynghi');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function update_loaingaynghi($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$mota = $this->check_sql_injection($form['mota']);
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('mota').'='.$db->quote($mota),
						$db->quotename('titrong').'='.$db->quote($form['titrong']));
			$query->update('dgcbcc_loaingaynghi');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_loaingaynghi($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('dgcbcc_loaingaynghi');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();		
		}
	}
?>