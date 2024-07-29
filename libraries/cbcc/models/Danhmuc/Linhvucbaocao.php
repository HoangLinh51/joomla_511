<?php 
	class Danhmuc_Model_Linhvucbaocao extends JModelLegacy{
		public function addLinhvucbaocao($form,$user_id,$today){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['trangthai']=='1'){
				$trangthai = '1';
			}
			else{
				$trangthai = '0';
			}
			$field = array($db->quotename('ten').'='.$db->quote($form['ten_linhvuc']),
						$db->quotename('ma').'='.$db->quote($form['ma_linhvuc']),
						$db->quotename('trangthai').'='.$db->quote($trangthai),
						$db->quotename('nguoitao_id').'='.$db->quote($user_id),
						$db->quotename('ngaytao').'='.$db->quote($today),
						$db->quotename('nguoicapnhat_id').'='.$db->quote($user_id),
						$db->quotename('ngaycapnhat').'='.$db->quote($today),'daxoa=0');
			$query->insert('baocaovps_linhvucbaocao');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function timkiemlinhvucbaocaobyname($tk_ten_lvbc,$tk_trangthai_lvbc){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,ten,ma,trangthai');
			$query->from('baocaovps_linhvucbaocao');
			$query->where('( ten LIKE '.$db->quote('%'.$tk_ten_lvbc.'%').' OR ma LIKE '.$db->quote('%'.$tk_ten_lvbc.'%').')');
			if($tk_trangthai_lvbc!=null){
				$query->where('trangthai='.$db->quote($tk_trangthai_lvbc));
			}
			$query->where('daxoa!=1');
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function findlinhvucbaocao($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,ten,ma,trangthai');
			$query->from('baocaovps_linhvucbaocao');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function updatelinhvucbaocao($form,$user_id,$today){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['trangthai']=='1'){
				$trangthai = '1';
			}
			else{
				$trangthai = '0';
			}
			$field = array($db->quotename('ten').'='.$db->quote($form['ten_linhvuc']),
						$db->quotename('ma').'='.$db->quote($form['ma_linhvuc']),
						$db->quotename('trangthai').'='.$db->quote($trangthai),
						$db->quotename('nguoicapnhat_id').'='.$db->quote($user_id),
						$db->quotename('ngaycapnhat').'='.$db->quote($today));
			$query->update('baocaovps_linhvucbaocao');
			$query->set($field);
			$query->where('id='.$db->quote($form['id_linhvuc']));
			$db->setQuery($query);
			return $db->query();
		}
		public function xoalinhvucbaocao($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->update('baocaovps_linhvucbaocao');
			$query->set('daxoa=1');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
	}
?>