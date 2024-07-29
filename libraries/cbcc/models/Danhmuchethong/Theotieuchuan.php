<?php 
	class Danhmuchethong_Model_Theotieuchuan extends JModelLegacy{
		public function find_theotieuchuan_byname($tk_dgcbcc_theotieuchuan_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,code,heso,is_canhan,published,ids_loaicongviec');
			$query->from('dgcbcc_tieuchuan_dg');
			$query->where('daxoa!=1');
			if($tk_dgcbcc_theotieuchuan_name!=null){
				$tk_dgcbcc_theotieuchuan_name = $this->check_sql_injection($tk_dgcbcc_theotieuchuan_name);
				$query->where('name LIKE '.$db->quote('%'.$tk_dgcbcc_theotieuchuan_name.'%'));
			}
			$query->order('orders asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
	    public function getall_loaicongviec(){
	    	$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('dgcbcc_loai_congviec');
			$query->order('orders asc');
			$db->setQuery($query);
			return $db->loadAssocList();
	    }
	    public function getall_dgcbcc_nhiemvu(){
	    	$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('dgcbcc_dg_theonhiemvu');
			$query->where('daxoa!=1');
			$query->order('orders asc');
			$db->setQuery($query);
			return $db->loadAssocList();
	    }
	    public function add_theotieuchuan($form,$ids_loaicongviec){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$name = $this->check_sql_injection($form['name']);
	    	$code = $this->check_sql_injection($form['code']);
	    	$loaicongviec = implode(',',$ids_loaicongviec);
	    	$field = array($db->quotename('name').'='.$db->quote($name),
	    				$db->quotename('code').'='.$db->quote($code),
	    				$db->quotename('heso').'='.$db->quote($form['heso']),
	    				$db->quotename('is_canhan').'='.$db->quote($form['is_canhan']),
	    				$db->quotename('published').'='.$db->quote($form['published']),
	    				$db->quotename('ids_loaicongviec').'='.$db->quote($loaicongviec),
	    				'daxoa=0','orders=99');
	    	$query->insert('dgcbcc_tieuchuan_dg');
	    	$query->set($field);
	    	$db->setQuery($query);
	    	$db->query();
	    	return $db->insertid();
	    }
	    public function add_dgcbcc_fk_nhiemvu_tieuchuan($id_tieuchuan,$fk_tieuchuan_nhiemvu){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$field = array($db->quotename('id_tieuchuan').'='.$db->quote($id_tieuchuan),
	    				$db->quotename('id_nhiemvu').'='.$db->quote($fk_tieuchuan_nhiemvu));
	    	$query->insert('dgcbcc_fk_tieuchuan_nhiemvu');
	    	$query->set($field);
	    	$db->setQuery($query);
	    	return $db->query();
	    }
	    public function add_dgcbcc_fk_nhiemvu_tieuchuan_danhgiacho($id_tieuchuan,$fk_tieuchuan_nhiemvu){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$field = array($db->quotename('id_tieuchuan').'='.$db->quote($id_tieuchuan),
	    				$db->quotename('id_nhiemvu').'='.$db->quote($fk_tieuchuan_nhiemvu));
	    	$query->insert('dgcbcc_fk_tieuchuan_nhiemvu_danhgiacho');
	    	$query->set($field);
	    	$db->setQuery($query);
	    	return $db->query();
	    }
	    public function find_dgcbcc_tieuchuan_byid($id){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$query->select('id,name,code,heso,is_canhan,published,ids_loaicongviec');
	    	$query->from('dgcbcc_tieuchuan_dg');
	    	$query->where('daxoa!=1');
	    	$query->where('id='.$db->quote($id));
	    	$db->setQuery($query);
	    	return $db->loadAssoc();
	    }
	    public function find_dgcbcc_fk_nhiemvu_tieuchuan_byidtieuchuan($id){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$query->select('id_tieuchuan,id_nhiemvu');
	    	$query->from('dgcbcc_fk_tieuchuan_nhiemvu');
	    	$query->where('id_tieuchuan='.$db->quote($id));
	    	$db->setQuery($query);
	    	return $db->loadAssocList();
	    }
	    public function find_dgcbcc_fk_nhiemvu_tieuchuan_danhgiacho_byidtieuchuan($id){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$query->select('id_tieuchuan,id_nhiemvu');
	    	$query->from('dgcbcc_fk_tieuchuan_nhiemvu_danhgiacho');
	    	$query->where('id_tieuchuan='.$db->quote($id));
	    	$db->setQuery($query);
	    	return $db->loadAssocList();
	    }
	    public function delete_dgcbcc_fk_nhiemvu_tieuchuan_byidtieuchuan($id_tieuchuan){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$query->delete('dgcbcc_fk_tieuchuan_nhiemvu');
	    	$query->where('id_tieuchuan='.$db->quote($id_tieuchuan));
	    	$db->setQuery($query);
	    	return $db->query();
	    }
	    public function delete_dgcbcc_fk_nhiemvu_tieuchuan_danhgiacho_byidtieuchuan($id_tieuchuan){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$query->delete('dgcbcc_fk_tieuchuan_nhiemvu_danhgiacho');
	    	$query->where('id_tieuchuan='.$db->quote($id_tieuchuan));
	    	$db->setQuery($query);
	    	return $db->query();
	    }
	    public function update_theotieuchuan($form,$ids_loaicongviec){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$name = $this->check_sql_injection($form['name']);
	    	$code = $this->check_sql_injection($form['code']);
	    	$loaicongviec = implode(',',$ids_loaicongviec);
	    	$field = array($db->quotename('name').'='.$db->quote($name),
	    				$db->quotename('code').'='.$db->quote($code),
	    				$db->quotename('heso').'='.$db->quote($form['heso']),
	    				$db->quotename('is_canhan').'='.$db->quote($form['is_canhan']),
	    				$db->quotename('published').'='.$db->quote($form['published']),'daxoa=0',
	    				$db->quotename('ids_loaicongviec').'='.$db->quote($loaicongviec),'orders=99');
	    	$query->update('dgcbcc_tieuchuan_dg');
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
	    public function delete_theotieuchuan($id){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$query->update('dgcbcc_tieuchuan_dg');
	    	$query->set('daxoa=1');
	    	$query->where('id='.$db->quote($id));
	    	$db->setQuery($query);
	    	return $db->query();
	    }
	}
?>