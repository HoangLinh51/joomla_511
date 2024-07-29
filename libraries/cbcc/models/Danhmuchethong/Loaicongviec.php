<?php 
	class Danhmuchethong_Model_Loaicongviec extends JModelLegacy{
		public function timkiem_loaicongviec_byname($tk_loaicongviec_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,orders');
			$query->from('dgcbcc_loai_congviec');
			if($tk_loaicongviec_name!=null){
				$query->where('name LIKE '.$db->quote('%'.$tk_loaicongviec_name.'%'));
			}
			$query->order('orders asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function add_loaicongviec($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			if($form['status']==1){
				$status = 1;
			}
			else{
				$status = 0;
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('status').'='.$db->quote($status));
			$query->insert('dgcbcc_loai_congviec');
			$query->set($field);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();
		}
		public function find_loaicongviec($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,orders');
			$query->from('dgcbcc_loai_congviec');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function update_loaicongviec($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			if($form['status']==1){
				$status = 1;
			}
			else{
				$status = 0;
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('status').'='.$db->quote($status));
			$query->update('dgcbcc_loai_congviec');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			$db->query();
			return $form['id'];
		}
		public function delete_loaicongviec($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('dgcbcc_loai_congviec');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();		
		}
		public function find_dgcbcc_fk_loaicongviec_dotdanhgia($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id_dotdanhgia');
			$query->from('dgcbcc_fk_loaicongviec_dotdanhgia');
			$query->where('id_loai_congviec='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function add_dgcbcc_fk_loaicongviec_dotdanhgia($id_loaicongviec,$id_dotdanhgia){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('id_loai_congviec').'='.$db->quote($id_loaicongviec),
						$db->quotename('id_dotdanhgia').'='.$db->quote($id_dotdanhgia));
			$query->insert('dgcbcc_fk_loaicongviec_dotdanhgia');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_dgcbcc_fk_loaicongviec_dotdanhgia($id_loaicongviec){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('dgcbcc_fk_loaicongviec_dotdanhgia');
			$query->where('id_loai_congviec='.$db->quote($id_loaicongviec));
			$db->setQuery($query);
			return $db->query();
		}
	}
?>