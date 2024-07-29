<?php 
	class Danhmuchethong_Model_Nghiepvuthaydoi extends JModelLegacy{
		public function find_nghiepvuthaydoi_by_name($nghiepvuthaydoi_name){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,ten,ma,trangthai');
			$query->from('tcbc_dmnghiepvuthaydoi');
			$query->where($db->quotename('daxoa').'!=1');
			if(isset($nghiepvuthaydoi_name)&&$nghiepvuthaydoi_name!=''){
				$query->where('ten LIKE '.$db->quote('%'.$nghiepvuthaydoi_name.'%'));
			}
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function add_nghiepvuthaydoi($form,$user_id,$today){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if(isset($form['trangthai'])&&$form['trangthai']==1){
				$trangthai = 1;
			}
			else{
				$trangthai = 0;
			}
			$ten = self::check_sql_injection($form['ten']);
			$ma = self::check_sql_injection($form['ma']);
			$field = array($db->quotename('ten').'='.$db->quote($ten),
						$db->quotename('ma').'='.$db->quote($ma),
						$db->quotename('trangthai').'='.$db->quote($trangthai),
						$db->quotename('nguoitao_id').'='.$db->quote($user_id),
						$db->quotename('ngaytao').'='.$db->quote($today),
						$db->quotename('nguoicapnhat_id').'='.$db->quote($user_id),
						$db->quotename('ngaycapnhat').'='.$db->quote($today),
						$db->quotename('daxoa').'=0');
			$query->insert('tcbc_dmnghiepvuthaydoi');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function update_nghiepvuthaydoi($form,$user_id,$today){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			if(isset($form['trangthai'])&&$form['trangthai']==1){
				$trangthai = 1;
			}
			else{
				$trangthai = 0;
			}
			$ten = self::check_sql_injection($form['ten']);
			$ma = self::check_sql_injection($form['ma']);
			$field = array($db->quotename('ten').'='.$db->quote($ten),
						$db->quotename('ma').'='.$db->quote($ma),
						$db->quotename('trangthai').'='.$db->quote($trangthai),
						$db->quotename('nguoicapnhat_id').'='.$db->quote($user_id),
						$db->quotename('ngaycapnhat').'='.$db->quote($today));
			$query->update('tcbc_dmnghiepvuthaydoi');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function find_nghiepvuthaydoi_by_id($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,ten,ma,trangthai');
			$query->from('tcbc_dmnghiepvuthaydoi');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function delete_nghiepvuthaydoi($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->update('tcbc_dmnghiepvuthaydoi');
			$query->set('daxoa=1');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
	}
?>