<?php 
	class Danhmuchethong_Model_Chuyennganhdaotao extends JModelLegacy{
		public function getall_nhomchuyennganhdaotao(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('code,name');
			$query->from('ls_code');
			$query->where('lim_code IS NULL');
			$query->order('code asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function find_chuyennganhdaotao_bynhomcndt($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.code,a.name,a.status,(select name from ls_code where code=a.lim_code) as parent_name');
			$query->from('ls_code a');
			$query->where('a.lim_code='.$db->quote($id));
			$query->order('a.code asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function add_chuyennganhdaotao($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$code = substr($form['lim_code'],0,2);
			$name = $this->check_sql_injection($form['name']);
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('lim_code').'='.$db->quote($form['lim_code']),
						$db->quotename('status').'='.$db->quote($form['status']));
			$query->insert('ls_code');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_chuyennganhdaotao_byid($id_cndt){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.code,a.name,a.status,a.lim_code');
			$query->from('ls_code a');
			$query->where('a.code='.$db->quote($id_cndt));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function update_chuyennganhdaotao($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('status').'='.$db->quote($form['status']));
			$query->update('ls_code');
			$query->set($field);
			$query->where('code='.$db->quote($form['code']));
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_chuyennganhdaotao($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('ls_code');
			$query->where('code='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
	}
?>