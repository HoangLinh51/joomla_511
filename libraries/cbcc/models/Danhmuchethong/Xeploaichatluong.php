<?php 
	class Danhmuchethong_Model_Xeploaichatluong extends JModelLegacy{
		public function timkiem_xeploaichatluong_byname($tk_dgcbcc_xeploaichatluong_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.id,a.name,a.status,a.heso,a.heso_tu_dg,a.id_dotdanhgia,b.name as name_dotdanhgia');
			$query->from('dgcbcc_chatluong_xeploai a');
			$query->join('INNER','dgcbcc_dotdanhgia b ON (a.id_dotdanhgia=b.id)');
			if($tk_dgcbcc_xeploaichatluong_name!=null){
				$query->where('name LIKE '.$db->quote('%'.$tk_dgcbcc_xeploaichatluong_name.'%'));
			}
			$query->order('b.date_dot desc');
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function add_xeploaichatluong($form){
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
						$db->quotename('heso').'='.$db->quote($form['heso']),
						$db->quotename('heso_tu_dg').'='.$db->quote($form['heso_tu_dg']),
						$db->quotename('id_dotdanhgia').'='.$db->quote($form['id_dotdanhgia']),
						$db->quotename('status').'='.$db->quote($status));
			$query->insert('dgcbcc_chatluong_xeploai');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_xeploaichatluong($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,heso,heso_tu_dg,id_dotdanhgia');
			$query->from('dgcbcc_chatluong_xeploai');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function update_xeploaichatluong($form){
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
						$db->quotename('heso').'='.$db->quote($form['heso']),
						$db->quotename('heso_tu_dg').'='.$db->quote($form['heso_tu_dg']),
						$db->quotename('id_dotdanhgia').'='.$db->quote($form['id_dotdanhgia']),
						$db->quotename('status').'='.$db->quote($status));
			$query->update('dgcbcc_chatluong_xeploai');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_xeploaichatluong($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('dgcbcc_chatluong_xeploai');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();		
		}
		public function getall_dgcbcc_dotdanhgia(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('dgcbcc_dotdanhgia');
			$query->where('daxoa!=1');
			$query->order('date_dot desc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
	}
?>