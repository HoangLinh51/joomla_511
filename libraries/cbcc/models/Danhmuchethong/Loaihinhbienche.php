<?php 
	class Danhmuchethong_Model_Loaihinhbienche extends JModelLegacy{
		public function timkiemloaihinhbienchebyname($loaihinhbienche_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,s_name');
			$query->from('bc_loaihinh');
			$query->where('name LIKE '.$db->quote('%'.$loaihinhbienche_name.'%'));
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function luuloaihinhbienche($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']==''){
				$status = 0;
			}
			else{
				$status = $form['status'];
			}
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
						$db->quotename('s_name').'='.$db->quote($form['s_name']),
						$db->quotename('status').'='.$db->quote($status));
			$query->insert('bc_loaihinh');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_loaihinhbienche($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('bc_loaihinh');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function findloaihinhbienche($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,s_name');
			$query->from('bc_loaihinh');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updateloaihinhbienche($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']==''){
				$status = 0;
			}
			else{
				$status = $form['status'];
			}
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
						$db->quotename('s_name').'='.$db->quote($form['s_name']),
						$db->quotename('status').'='.$db->quote($status));
			$query->update('bc_loaihinh');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function xoanhieu_loaihinhbienche($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id);$i++){
				$query = $db->getQuery(true);
				$query->delete('bc_loaihinh');
				$query->where('id='.$id[$i]);
				$db->setQuery($query);
				$result[] = $db->query();
			}
			return $result;
		}
	}
?>