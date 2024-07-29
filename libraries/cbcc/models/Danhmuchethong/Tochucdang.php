<?php 
	class Danhmuchethong_Model_Tochucdang extends JModelLegacy{
		public function timkiem_tochucdang_byname($tk_nametochucdang){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,orders');
			$query->from('ctd_donvidang');
			$query->where('name LIKE '.$db->quote('%'.$tk_nametochucdang.'%'));
			$query->order('orders asc');
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssocList();
		}
		public function addtochucdang($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']==null){
				$status = 0;
			}
			else{
				$status = $form['status'];
			}
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
						$db->quotename('orders').'='.$db->quote(1),
						$db->quotename('status').'='.$db->quote($status));
			$query->insert('ctd_donvidang');
			$query->set($field);
			// echo $query;die;
			$db->setQuery($query);
			return $db->query();
		}
		public function deletetochucdang($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('ctd_donvidang');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function findtochucdang($id_tochucdang){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status');
			$query->from('ctd_donvidang');
			$query->where('id='.$db->quote($id_tochucdang));
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssoc();
		}
		public function updatetochucdang($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']==null){
				$status = '0';
			}
			else{
				$status = '1';
			}
			$field = array($db->quotename('name').'='.$db->quote($form['name']),
						$db->quotename('orders').'='.$db->quote(1),
						$db->quotename('status').'='.$db->quote($status));
			$query->update('ctd_donvidang');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function deletealltochucdang($tochucdang_id){
			for($i=0;$i<count($tochucdang_id);$i++){
				$result[] = $this->deletetochucdang($tochucdang_id[$i]);
			}
			return $result;
		}
	}
?>