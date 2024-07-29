<?php 
	class Danhmuchethong_Model_Hinhthuctuyendung extends JModelLegacy{
		public function timkiemhinhthuctuyendungbyname($hinhthuctuyendung_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,code');
			$query->from('bc_hinhthuctuyendung');
			$query->where('name LIKE '.$db->quote('%'.$hinhthuctuyendung_name.'%'));
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function luuhinhthuctuyendung($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']==''){
				$status = 0;
			}
			else{
				$status = $form['status'];
			}
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
						$db->quotename('code').'='.$db->quote($form['code']),
						$db->quotename('status').'='.$db->quote($status));
			$query->insert('bc_hinhthuctuyendung');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_hinhthuctuyendung($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('bc_hinhthuctuyendung');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function findhinhthuctuyendung($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,code');
			$query->from('bc_hinhthuctuyendung');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updatehinhthuctuyendung($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']==''){
				$status = 0;
			}
			else{
				$status = $form['status'];
			}
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
						$db->quotename('code').'='.$db->quote($form['code']),
						$db->quotename('status').'='.$db->quote($status));
			$query->update('bc_hinhthuctuyendung');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function xoanhieu_hinhthuctuyendung($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id);$i++){
				$query = $db->getQuery(true);
				$query->delete('bc_hinhthuctuyendung');
				$query->where('id='.$id[$i]);
				$db->setQuery($query);
				$result[] = $db->query();
			}
			return $result;
		}
	}
?>