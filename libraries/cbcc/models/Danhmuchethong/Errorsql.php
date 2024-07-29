<?php 
	class Danhmuchethong_Model_Errorsql extends JModelLegacy{
		public function load_danhsach_errorsql(){
			$jinput = JFactory::getApplication()->input;
			$array['tk_errorsql_name'] = $jinput->getString('tk_errorsql_name','');
			$db = JFactory::getDbo();
			$db->sql("SET character_set_client=utf8");
			$db->sql("SET character_set_connection=utf8");
			$db->sql("SET character_set_results=utf8");
			$columns = array(
				array('db' => 'a.id' ,'dt' => 0),
				array('db' => 'a.action',	'dt' => 1),
				array('db' => 'a.sql_error',	'dt' => 2),
				array('db' => 'a.time_error','dt' => 3)
				);
			$table = 'dgcbcc_error_sql AS a';
			$primaryKey = 'a.id';
			if(isset($array['tk_errorsql_name']) && $array['tk_errorsql_name'] != null) 
			$where[] = 'a.action like'.$db->quote("%".$array['tk_errorsql_name']."%") ;			
			$where = implode(' AND ', $where);
			// echo $where;die;
			$datatables = Core::model('Core/Datatables');
			return $datatables->simple( $_POST, $table, $primaryKey, $columns ,$join, $where);
		}
	}
?>