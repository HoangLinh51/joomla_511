<?php 
	class Danhmuchethong_Model_Hinhthuckhenthuongkyluatkyluatdang extends JModelLegacy{
		public function timkiem_hinhthuc_ktklkld_byten($htktklkld_name,$htktklkld_type){
			// echo 'aa';die;
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,type,name,lev,months_nangluongtruoc,status,solantoidatrongnam,months_nangluong');
			$query->from('rew_fin_code');
			if($htktklkld_name&&$htktklkld_name!=null){
				$query->where('name LIKE '.$db->quote('%'.$htktklkld_name.'%'));
			}
			if($htktklkld_type&&$htktklkld_type!=null){
				$query->where('type='.$db->quote($htktklkld_type));
			}
			$query->order('type asc');
			$query->order('ordering asc');
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssocList();
		}
		public function add_htktklkld($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']==1){
				$status = 1;
			}
			else{
				$status = 0;
			}
			if($form['ordering']==null){
				$ordering = 99;
			}
			else{
				$ordering = $form['ordering'];
			}
			$field = array($db->quotename('type').'='.$db->quote($form['type']),
						$db->quotename('name').'='.$db->quote($form['name']),
						$db->quotename('lev').'='.$db->quote($form['lev']),
						$db->quotename('months_nangluongtruoc').'='.$db->quote($form['months_nangluongtruoc']),
						$db->quotename('months_nangluong').'='.$db->quote($form['months_nangluong']),
						$db->quotename('solantoidatrongnam').'='.$db->quote($form['solantoidatrongnam']),
						$db->quotename('status').'='.$db->quote($status),
						$db->quotename('ordering').'='.$db->quote($ordering));
			$query->insert('rew_fin_code');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_hinhthuc_ktklkld($id_ktklkld){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,type,name,lev,months_nangluongtruoc,status,solantoidatrongnam,months_nangluong,ordering');
			$query->from('rew_fin_code');
			$query->where('id='.$db->quote($id_ktklkld));
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssoc();
		}
		public function update_htktklkld($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if($form['status']==1){
				$status = 1;
			}
			else{
				$status = 0;
			}
			if($form['ordering']==null){
				$ordering = 99;
			}
			else{
				$ordering = $form['ordering'];
			}
			$field = array($db->quotename('type').'='.$db->quote($form['type']),
						$db->quotename('name').'='.$db->quote($form['name']),
						$db->quotename('lev').'='.$db->quote($form['lev']),
						$db->quotename('months_nangluongtruoc').'='.$db->quote($form['months_nangluongtruoc']),
						$db->quotename('months_nangluong').'='.$db->quote($form['months_nangluong']),
						$db->quotename('solantoidatrongnam').'='.$db->quote($form['solantoidatrongnam']),
						$db->quotename('status').'='.$db->quote($status),
						$db->quotename('ordering').'='.$db->quote($ordering));
			$query->update('rew_fin_code');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_htktklkld($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('rew_fin_code');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function deleteall_htktklkld($id){
			for($i=0;$i<count($id);$i++){	
				$result[] = $this->delete_htktklkld($id[$i]);
			}
			return $result;
		}
	}
?>