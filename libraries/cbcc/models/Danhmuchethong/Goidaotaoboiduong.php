<?php 
	class Danhmuchethong_Model_Goidaotaoboiduong extends JModelLegacy{
		public function getall_goidaotaoboiduong(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status');
			$query->from('cb_goidaotaoboiduong');
			$query->order('id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function getall_goidaotaoboiduong_ltd(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('code,name');
			$query->from('type_sca_code');
			$query->order('code asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function luu_goidaotaoboiduong($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name_goidaotaoboiduong = $this->check_sql_injection($form['name']);
			if($form['status']==''){
				$status = '0';
			}
			else{
				$status = $form['status'];
			}
			$field = array($db->quotename('name').'='.$db->quote($name_goidaotaoboiduong),
						$db->quotename('status').'='.$db->quote($status));
			$query->insert('cb_goidaotaoboiduong');
			$query->set($field);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();
		}
		public function delete_goidaotaoboiduong($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('cb_goidaotaoboiduong');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function find_goidaotaoboiduong($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status');
			$query->from('cb_goidaotaoboiduong');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function update_goidaotaoboiduong($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name_goidaotaoboiduong = $this->check_sql_injection($form['name']);
			if($form['status']==''){
				$status = '0';
			}
			else{
				$status = $form['status'];
			}
			$field = array($db->quotename('name').'='.$db->quote($name_goidaotaoboiduong),
						$db->quotename('status').'='.$db->quote($status));
			$query->update('cb_goidaotaoboiduong');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			$db->query();
			return $form['id'];
		}
		public function luu_goidaotaoboiduong_ltd($id_goidaotaoboiduong,$loaitrinhdo){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('goidaotaoboiduong_id').'='.$db->quote($id_goidaotaoboiduong),
						$db->quotename('type_sca_code_id').'='.$db->quote($loaitrinhdo));
			$query->insert('cb_goidaotaoboiduong_loaitrinhdo');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_goidaotaoboiduong_ltd($goidaotaoboiduong_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('goidaotaoboiduong_id,type_sca_code_id');
			$query->from('cb_goidaotaoboiduong_loaitrinhdo');
			$query->where('goidaotaoboiduong_id='.$db->quote($goidaotaoboiduong_id));
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function delete_goidaotaoboiduong_ltd_byid($goidaotaoboiduong_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('cb_goidaotaoboiduong_loaitrinhdo');
			$query->where('goidaotaoboiduong_id='.$db->quote($goidaotaoboiduong_id));
			$db->setQuery($query);
			return $db->query();
		}
	}
?>