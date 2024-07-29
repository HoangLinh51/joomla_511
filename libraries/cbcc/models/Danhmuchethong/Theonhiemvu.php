<?php 
	class Danhmuchethong_Model_Theonhiemvu extends JModelLegacy{
		public function find_theonhiemvu_byname($tk_dgcbcc_theonhiemvu_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,code,orders,template,daxoa');
			$query->from('dgcbcc_dg_theonhiemvu');
			$query->where('daxoa!=1');
			if($tk_dgcbcc_theonhiemvu_name!=null){
				$tk_dgcbcc_theonhiemvu_name = $this->check_sql_injection($tk_dgcbcc_theonhiemvu_name);
				$query->where('name LIKE '.$db->quote('%'.$tk_dgcbcc_theonhiemvu_name.'%'));
			}
			$query->order('orders asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
	    public function getall_dgcbcc_tieuchuan(){
	    	$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('dgcbcc_tieuchuan_dg');
			$query->where('daxoa!=1');
			$query->order('orders asc');
			$db->setQuery($query);
			return $db->loadAssocList();
	    }
	    public function add_theonhiemvu($form){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$name = $this->check_sql_injection($form['name']);
	    	$code = $this->check_sql_injection($form['code']);
	    	$template = $this->check_sql_injection($form['template']);
	    	$field = array($db->quotename('name').'='.$db->quote($name),
	    				$db->quotename('code').'='.$db->quote($code),
	    				$db->quotename('template').'='.$db->quote($template),'daxoa=0','orders=99');
	    	$query->insert('dgcbcc_dg_theonhiemvu');
	    	$query->set($field);
	    	$db->setQuery($query);
	    	$db->query();
	    	return $db->insertid();
	    }
	    public function add_dgcbcc_fk_nhiemvu_tieuchuan($id_nhiemvu,$fk_tieuchuan_nhiemvu){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$field = array($db->quotename('id_tieuchuan').'='.$db->quote($fk_tieuchuan_nhiemvu),
	    				$db->quotename('id_nhiemvu').'='.$db->quote($id_nhiemvu));
	    	$query->insert('dgcbcc_fk_tieuchuan_nhiemvu');
	    	$query->set($field);
	    	$db->setQuery($query);
	    	return $db->query();
	    }
	    public function find_dgcbcc_nhiemvu_byid($id){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$query->select('id,name,code,template');
	    	$query->from('dgcbcc_dg_theonhiemvu');
	    	$query->where('daxoa!=1');
	    	$query->where('id='.$db->quote($id));
	    	$db->setQuery($query);
	    	return $db->loadAssoc();
	    }
	    public function find_dgcbcc_fk_nhiemvu_tieuchuan_byidnhiemvu($id){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$query->select('id_tieuchuan,id_nhiemvu');
	    	$query->from('dgcbcc_fk_tieuchuan_nhiemvu');
	    	$query->where('id_nhiemvu='.$db->quote($id));
	    	$db->setQuery($query);
	    	return $db->loadAssocList();
	    }
	    public function delete_dgcbcc_fk_nhiemvu_tieuchuan_byidnhiemvu($id_nhiemvu){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$query->delete('dgcbcc_fk_tieuchuan_nhiemvu');
	    	$query->where('id_nhiemvu='.$db->quote($id_nhiemvu));
	    	$db->setQuery($query);
	    	return $db->query();
	    }
	    public function update_theonhiemvu($form){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$name = $this->check_sql_injection($form['name']);
	    	$code = $this->check_sql_injection($form['code']);
	    	$template = $this->check_sql_injection($form['template']);
	    	$field = array($db->quotename('name').'='.$db->quote($name),
	    				$db->quotename('code').'='.$db->quote($code),
	    				$db->quotename('template').'='.$db->quote($template),'daxoa=0','orders=99');
	    	$query->update('dgcbcc_dg_theonhiemvu');
	    	$query->set($field);
	    	$query->where('id='.$db->quote($form['id']));
	    	$db->setQuery($query);
	    	$check = $db->query();
	    	if($check==true){
	    		return $form['id'];
	    	}
	    	else{
	    		return false;
	    	}
	    }
	    public function delete_theonhiemvu($id){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$query->update('dgcbcc_dg_theonhiemvu');
	    	$query->set('daxoa=1');
	    	$query->where('id='.$db->quote($id));
	    	$db->setQuery($query);
	    	return $db->query();
	    }
	}
?>