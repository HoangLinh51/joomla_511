<?php 
	class Danhmuchethong_Model_Loaitrinhdo extends JModelLegacy{
		public function timkiem_loaitrinhdo_byname($tk_loaitrinhdo_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$tk_loaitrinhdo_name = $this->check_sql_injection($tk_loaitrinhdo_name);
			$query->select('a.code,a.name,a.iscn,a.status,a.is_nghiepvu,a.key,a.lim_code');
			$query->from('type_sca_code a');
			if($tk_loaitrinhdo_name!=null){
				$query->where('name LIKE '.$db->quote('%'.$tk_loaitrinhdo_name.'%'));
			}
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
	    public function add_loaitrinhdo($form){
	    	$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('iscn').'='.$db->quote($form['iscn']),
						$db->quotename('status').'='.$db->quote($form['status']),
						$db->quotename('is_nghiepvu').'='.$db->quote($form['is_nghiepvu']),
						$db->quotename('key').'='.$db->quote($form['key']));
			$query->insert('type_sca_code');
			$query->set($field);
			if($form['iscn']==1){
				$query->set($db->quotename('lim_code').'='.$db->quote($form['lim_code']));
			}
			$db->setQuery($query);
			return $db->query();
	    }
	    public function find_loaitrinhdo_byid($id){
	    	$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.code,a.name,a.iscn,a.status,a.is_nghiepvu,a.key,a.lim_code');
			$query->from('type_sca_code a');
			$query->where('a.code='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
	    }
	    public function update_loaitrinhdo($form){
	    	$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('iscn').'='.$db->quote($form['iscn']),
						$db->quotename('status').'='.$db->quote($form['status']),
						$db->quotename('is_nghiepvu').'='.$db->quote($form['is_nghiepvu']),
						$db->quotename('key').'='.$db->quote($form['key']));
			$query->update('type_sca_code');
			$query->set($field);
			if($form['iscn']==1){
				$query->set($db->quotename('lim_code').'='.$db->quote($form['lim_code']));
			}
			else{
				$query->set($db->quotename('lim_code').'=null');
			}
			$query->where('code='.$db->quote($form['code']));
			$db->setQuery($query);
			return $db->query();
	    }
	    public function delete_loaitrinhdo($id){
	    	$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('type_sca_code');
			$query->where('code='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
	    }
	}
?>