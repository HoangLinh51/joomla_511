<?php 
	class Danhmuchethong_Model_Mucdophuctap extends JModelLegacy{
		public function find_mucdophuctap_by_id_dotdanhgia($id_dotdanhgia){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,heso,heso_tu_dg,status,id_dotdanhgia');
			$query->from('dgcbcc_mucdophuctap_xeploai');
			$query->where('id_dotdanhgia='.$db->quote($id_dotdanhgia));
			$query->order('id');
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function add_mucdophuctap($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			if($form['status']==1){
				$status = '1';
			}
			else{
				$status = '0';
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
					$db->quotename('heso').'='.$db->quote($form['heso']),
					$db->quotename('heso_tu_dg').'='.$db->quote($form['heso_tu_dg']),
					$db->quotename('status').'='.$db->quote($status),
					$db->quotename('id_dotdanhgia').'='.$db->quote($form['id_dotdanhgia']));
			$query->insert('dgcbcc_mucdophuctap_xeploai');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_mucdophuctap_byid($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,heso,heso_tu_dg,status,id_dotdanhgia');
			$query->from('dgcbcc_mucdophuctap_xeploai');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function update_mucdophuctap($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			if($form['status']==1){
				$status = '1';
			}
			else{
				$status = '0';
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
					$db->quotename('heso').'='.$db->quote($form['heso']),
					$db->quotename('heso_tu_dg').'='.$db->quote($form['heso_tu_dg']),
					$db->quotename('status').'='.$db->quote($status),
					$db->quotename('id_dotdanhgia').'='.$db->quote($form['id_dotdanhgia']));
			$query->update('dgcbcc_mucdophuctap_xeploai');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_mucdophuctap($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete("dgcbcc_mucdophuctap_xeploai");
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
	}
?>