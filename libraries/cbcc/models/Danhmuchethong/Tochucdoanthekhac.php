<?php 
	class Danhmuchethong_Model_tochucdoanthekhac extends JModelLegacy{
		public function timkiem_tochucdoanthekhac_byname($tk_nametochucdoanthekhac){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status,orders');
			$query->from('ctd_tochucdoanthekhac');
			$query->where('name LIKE '.$db->quote('%'.$tk_nametochucdoanthekhac.'%'));
			$query->order('orders asc');
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssocList();
		}
		public function addtochucdoanthekhac($form){
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
			$query->insert('ctd_tochucdoanthekhac');
			$query->set($field);
			// echo $query;die;
			$db->setQuery($query);
			return $db->query();
		}
		public function deletetochucdoanthekhac($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('ctd_tochucdoanthekhac');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function findtochucdoanthekhac($id_tochucdoanthekhac){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,status');
			$query->from('ctd_tochucdoanthekhac');
			$query->where('id='.$db->quote($id_tochucdoanthekhac));
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssoc();
		}
		public function updatetochucdoanthekhac($form){
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
			$query->update('ctd_tochucdoanthekhac');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function deletealltochucdoanthekhac($tochucdoanthekhac_id){
			for($i=0;$i<count($tochucdoanthekhac_id);$i++){
				$result[] = $this->deletetochucdoanthekhac($tochucdoanthekhac_id[$i]);
			}
			return $result;
		}
	}
?>