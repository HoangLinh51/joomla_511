<?php 
	class Danhmuchethong_Model_Loaidoituong extends JModelLegacy{
		public function timkiemloaidoituongbyname($loaidoituong_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,ten,trangthai');
			$query->from('danhmuc_loaidoituong');
			$query->where('ten LIKE '.$db->quote('%'.$loaidoituong_name.'%'));
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function luuloaidoituong($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['trangthai']==''){
				$status = 0;
			}
			else{
				$status = $form['trangthai'];
			}
			$field = array($db->quotename('ten').'='.$db->quote($form['ten']),
						$db->quotename('trangthai').'='.$db->quote($status));
			$query->insert('danhmuc_loaidoituong');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_loaidoituong($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('danhmuc_loaidoituong');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function findloaidoituong($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,ten,trangthai');
			$query->from('danhmuc_loaidoituong');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updateloaidoituong($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['trangthai']==''){
				$status = 0;
			}
			else{
				$status = $form['trangthai'];
			}
			$field = array($db->quotename('ten').'='.$db->quote($form['ten']),
						$db->quotename('trangthai').'='.$db->quote($status));
			$query->update('danhmuc_loaidoituong');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function xoanhieu_loaidoituong($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id);$i++){
				$query = $db->getQuery(true);
				$query->delete('danhmuc_loaidoituong');
				$query->where('id='.$id[$i]);
				$db->setQuery($query);
				$result[] = $db->query();
			}
			return $result;
		}
	}
?>