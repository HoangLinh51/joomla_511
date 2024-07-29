<?php 
	class Danhmuchethong_Model_Hangdonvisunghiep extends JModelLegacy{
		public function findhdvsnbyname($tk_tenhdvsn){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,ten,trangthai');
			$query->from('danhmuc_hangdonvisunghiep');
			$query->where('ten LIKE '.$db->quote('%'.$tk_tenhdvsn.'%'));
			$query->where('daxoa!=1');
			$query->order('sapxep asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function addhdvsn($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['trangthai']==null){
				$trangthai = 0;
			}
			else{
				$trangthai = $form['trangthai'];
			}
			$field = array($db->quotename('ten').'='.$db->quote($form['ten']),
						$db->quotename('sapxep').'='.$db->quote(1),
						$db->quotename('trangthai').'='.$db->quote($trangthai),
						$db->quotename('daxoa').'='.$db->quote(0));
			$query->insert('danhmuc_hangdonvisunghiep');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function deletehdvsn($hdvsn_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->update('danhmuc_hangdonvisunghiep');
			$query->set('daxoa=1');
			$query->where('id='.$db->quote($hdvsn_id));
			$db->setQuery($query);
			return $db->query();
		}
		public function findhdvsn($id_hdvsn){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,ten,trangthai');
			$query->from('danhmuc_hangdonvisunghiep');
			$query->where('id='.$db->quote($id_hdvsn));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updatehdvsn($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['trangthai']==null){
				$trangthai = '0';
			}
			else{
				$trangthai = '1';
			}
			$field = array($db->quotename('ten').'='.$db->quote($form['ten']),
						$db->quotename('trangthai').'='.$db->quote($trangthai));
			$query->update('danhmuc_hangdonvisunghiep');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function deleteallhdvsn($hdvsn_id){
			for($i=0;$i<count($hdvsn_id);$i++){
				$result[] = $this->deletehdvsn($hdvsn_id[$i]);
			}
			return $result;
		}
	}
?>