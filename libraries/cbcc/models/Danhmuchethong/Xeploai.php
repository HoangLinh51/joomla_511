<?php 
	class Danhmuchethong_Model_Xeploai extends JModelLegacy{
		public function find_xeploai_by_id_dotdanhgia($id_dotdanhgia){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,code,diem_min,diem_max,published,id_dotdanhgia');
			$query->from('dgcbcc_xeploai');
			$query->where('id_dotdanhgia='.$db->quote($id_dotdanhgia));
			$query->order('id asc');
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function add_xeploai($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$code = $this->check_sql_injection($form['code']);
			if($form['published']==1){
				$published = '1';
			}
			else{
				$published = '0';
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
					$db->quotename('diem_min').'='.$db->quote($form['diem_min']),
					$db->quotename('diem_max').'='.$db->quote($form['diem_max']),
					$db->quotename('published').'='.$db->quote($published),
					$db->quotename('code').'='.$db->quote($code),
					$db->quotename('id_dotdanhgia').'='.$db->quote($form['id_dotdanhgia']));
			$query->insert('dgcbcc_xeploai');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_xeploai_byid($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,code,diem_min,diem_max,published,id_dotdanhgia');
			$query->from('dgcbcc_xeploai');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function update_xeploai($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$code = $this->check_sql_injection($form['code']);
			if($form['published']==1){
				$published = '1';
			}
			else{
				$published = '0';
			}
			$field = array($db->quotename('name').'='.$db->quote($name),
					$db->quotename('diem_min').'='.$db->quote($form['diem_min']),
					$db->quotename('diem_max').'='.$db->quote($form['diem_max']),
					$db->quotename('published').'='.$db->quote($published),
					$db->quotename('code').'='.$db->quote($code),
					$db->quotename('id_dotdanhgia').'='.$db->quote($form['id_dotdanhgia']));
			$query->update('dgcbcc_xeploai');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_xeploai($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete("dgcbcc_xeploai");
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
	}
?>