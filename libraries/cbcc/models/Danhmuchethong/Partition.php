<?php 
	class Danhmuchethong_Model_Partition extends JModelLegacy{
		public function find_partitions_by_table($name_table){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,a.table,key_partition,a.status,key_table');
			$query->from('dgcbcc_partitions a');
			if($name_table!=''){
				$query->where('table LIKE '.$db->quote('%'.$name_table.'%'));
			}
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssocList();	
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
	    public function add_partition_for_table($form){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
			$query->select('a.id')->from($db->quoteName('dgcbcc_dotdanhgia','a'))->where('daxoa!=1');
			$db->setQuery($query);
			$rows = $db->loadAssocList();

			for($i = 0, $n = count($rows); $i < $n; $i++){
				$partitions[] = 'PARTITION p_'.$rows[$i]['id'].' VALUES IN ('.$rows[$i]['id'].') ENGINE = MyISAM';
			}
			
			$query = $db->getQuery(true);
			$query = 'ALTER TABLE '.$form['table'].' PARTITION BY LIST ('.$form['key_partition'].') ( '.implode(',', $partitions).' );';
			$db->setQuery($query);
			// echo $query;die;
			return $db->query();
	    }
		public function add_partition($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$table = self::check_sql_injection($form['table']);
			$key_partition = self::check_sql_injection($form['key_partition']);
			$key_table = self::check_sql_injection($form['key_table']);
			if($form['status']==1){
				$status = 1;
			}
			else{
				$status = 0;
			}
			$field = array($db->quotename('table').'='.$db->quote($table),
						$db->quotename('key_partition').'='.$db->quote($key_partition),
						$db->quotename('key_table').'='.$db->quote($key_table),
						$db->quotename('status').'='.$db->quote($status));
			$query->insert('dgcbcc_partitions');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function update_partition($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$table = self::check_sql_injection($form['table']);
			$key_partition = self::check_sql_injection($form['key_partition']);
			$key_table = self::check_sql_injection($form['key_table']);
			if($form['status']==1){
				$status = 1;
			}
			else{
				$status = 0;
			}
			$field = array($db->quotename('table').'='.$db->quote($table),
						$db->quotename('key_partition').'='.$db->quote($key_partition),
						$db->quotename('key_table').'='.$db->quote($key_table),
						$db->quotename('status').'='.$db->quote($status));
			$query->update('dgcbcc_partitions');
			$query->set($field);
			$query->where('id='.$form['id']);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_partition_by_id($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,a.table,key_partition,a.status,key_table');
			$query->from('dgcbcc_partitions a');
			$query->where('a.id='.$db->quote($id));
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssoc();	
		}
		public function delete_partition($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('dgcbcc_partitions');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
	}
?>