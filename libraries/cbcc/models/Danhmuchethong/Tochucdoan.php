<?php 
	class Danhmuchethong_Model_tochucdoan extends JModelLegacy{
		public function timkiem_tochucdoan_byname($tk_nametochucdoan){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,orders');
			$query->from('ctd_donvidoan');
			$query->where('name LIKE '.$db->quote('%'.$tk_nametochucdoan.'%'));
			$query->order('orders asc');
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssocList();
		}
		public function addtochucdoan($form){
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
			$query->insert('ctd_donvidoan');
			$query->set($field);
			// echo $query;die;
			$db->setQuery($query);
			return $db->query();
		}
		public function deletetochucdoan($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('ctd_donvidoan');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function findtochucdoan($id_tochucdoan){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status');
			$query->from('ctd_donvidoan');
			$query->where('id='.$db->quote($id_tochucdoan));
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssoc();
		}
		public function updatetochucdoan($form){
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
			$query->update('ctd_donvidoan');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function deletealltochucdoan($tochucdoan_id){
			for($i=0;$i<count($tochucdoan_id);$i++){
				$result[] = $this->deletetochucdoan($tochucdoan_id[$i]);
			}
			return $result;
		}
	}
?>