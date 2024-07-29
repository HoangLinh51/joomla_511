<?php 
	class Danhmuchethong_Model_Thoihanbienchehopdong extends JModelLegacy{
		public function timkiemthoihanbienchehopdongbyname($thoihanbienchehopdong_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,month,deadline');
			$query->from('bc_thoihanbienchehopdong');
			$query->where('name LIKE '.$db->quote('%'.$thoihanbienchehopdong_name.'%'));
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function luuthoihanbienchehopdong($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']==''){
				$status = 0;
			}
			else{
				$status = $form['status'];
			}
			if($form['deadline']==''){
				$form['deadline'] = 0;
			}
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
						$db->quotename('month').'='.$db->quote($form['month']),
						$db->quotename('deadline').'='.$db->quote($form['deadline']),
						$db->quotename('status').'='.$db->quote($status));
			$query->insert('bc_thoihanbienchehopdong');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_thoihanbienchehopdong($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('bc_thoihanbienchehopdong');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function findthoihanbienchehopdong($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,month,deadline');
			$query->from('bc_thoihanbienchehopdong');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updatethoihanbienchehopdong($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']==''){
				$status = 0;
			}
			else{
				$status = $form['status'];
			}
			if($form['deadline']==''){
				$form['deadline'] = 0;
			}
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
						$db->quotename('month').'='.$db->quote($form['month']),
						$db->quotename('deadline').'='.$db->quote($form['deadline']),
						$db->quotename('status').'='.$db->quote($status));
			$query->update('bc_thoihanbienchehopdong');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function xoanhieu_thoihanbienchehopdong($id){
			$db = JFactory::getDbo();
			for($i=0;$i<count($id);$i++){
				$query = $db->getQuery(true);
				$query->delete('bc_thoihanbienchehopdong');
				$query->where('id='.$id[$i]);
				$db->setQuery($query);
				$result[] = $db->query();
			}
			return $result;
		}
	}
?>