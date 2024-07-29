<?php 
	class Danhmuchethong_Model_Tieuchiliet extends JModelLegacy{
		public function find_tieuchi_phanloai_byname($tk_tieuchi_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,orders,published');
			$query->from('dgcbcc_tieuchi_phanloai');
			if($tk_tieuchi_name&&$tk_tieuchi_name!=''){
				$query->where('name LIKE '.$db->quote('%'.$tk_tieuchi_name.'%'));
			}
			$query->order('orders asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function getall_dgcbcc_dg_theonhiemvu(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('dgcbcc_dg_theonhiemvu');
			$query->where('daxoa!=1');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function find_xeploai_by_id_dotdanhgia($id_dotdanhgia){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,code');
			$query->from('dgcbcc_xeploai');
			$query->where('id_dotdanhgia='.$db->quote($id_dotdanhgia));
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function add_tieuchi_phanloai($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = self::check_sql_injection($form['name']);
			if($form['published']==1){
				$published = 1;
			}
			else{
				$published = 0;
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('published').'='.$db->quote($published),
						$db->quotename('orders').'=99');
			$query->insert('dgcbcc_tieuchi_phanloai');
			$query->set($field);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();
		}
		public function update_tieuchi_phanloai($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = self::check_sql_injection($form['name']);
			if($form['published']==1){
				$published = 1;
			}
			else{
				$published = 0;
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('published').'='.$db->quote($published));
			$query->update('dgcbcc_tieuchi_phanloai');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			$db->query();
			return $form['id'];
		}
		public function delete_tieuchi_liet($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('dgcbcc_tieuchi_phanloai');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function add_dgcbcc_fk_theonhiemvu_tieuchi_phanloai($id_tieuchi_phanloai,$id_theonhiemvu,$id_dotdanhgia,$id_xeploai){
			if($id_theonhiemvu!=''&&$id_dotdanhgia!=''&&$id_xeploai!=''){
				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				$field =array($db->quotename('id_tieuchi_phanloai').'='.$db->quote($id_tieuchi_phanloai),
							$db->quotename('id_theonhiemvu').'='.$db->quote($id_theonhiemvu),
							$db->quotename('id_dotdanhgia').'='.$db->quote($id_dotdanhgia),
							$db->quotename('id_xeploai').'='.$db->quote($id_xeploai));
				$query->insert('dgcbcc_fk_theonhiemvu_tieuchi_phanloai');
				$query->set($field);
				$db->setQuery($query);
				return $db->query();
			}
		}
		public function delete_dgcbcc_fk_theonhiemvu_tieuchi_phanloai($id_tieuchi_phanloai){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('dgcbcc_fk_theonhiemvu_tieuchi_phanloai');
			$query->where('id_tieuchi_phanloai='.$db->quote($id_tieuchi_phanloai));
			$db->setQuery($query);
			return $db->query();
		}
		public function find_tieuchi_phanloai_byid($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,published');
			$query->from('dgcbcc_tieuchi_phanloai');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function find_dgcbcc_fk_theonhiemvu_tieuchi_phanloai_by_idtieuchi($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id_tieuchi_phanloai,id_theonhiemvu,id_dotdanhgia,id_xeploai');
			$query->from('dgcbcc_fk_theonhiemvu_tieuchi_phanloai');
			$query->where('id_tieuchi_phanloai='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssocList();
		}
	}
?>