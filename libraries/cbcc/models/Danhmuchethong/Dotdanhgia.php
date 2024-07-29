<?php 
	class Danhmuchethong_Model_Dotdanhgia extends JModelLegacy{
		public function getall_dotdanhgia(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,date_dot');
			$query->from('dgcbcc_dotdanhgia');
			$query->where('daxoa!=1');
			$query->group('date_dot');
			$query->order('date_dot desc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function timkiem_dotdanhgia_by_datedot($date_dot){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,date_dot,time_dot,ngaybatdau,ngayketthuc,ngaytudanhgia,is_danhgianam,is_lock,ghichu');
			$query->from('dgcbcc_dotdanhgia');
			$query->where('date_dot='.$db->quote($date_dot));
			$query->where('daxoa!=1');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function ConvertFormatDateFromDb($date){
			$day = substr($date,8,2);
			$month = substr($date,5,2);
			$year = substr($date,0,4);
			return $day.'/'.$month.'/'.$year;
		}
		public function ConvertFormatDateToDb($date){
			$day = substr($date,0,2);
			$month = substr($date,3,2);
			$year = substr($date,6,4);
			return $year.'-'.$month.'-'.$day;
		}
		public function add_dotdanhgia($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$ghichu = $this->check_sql_injection($form['ghichu']);
			$date_dot = $this->ConvertFormatDateToDb($form['date_dot']);
			$ngaybatdau = $this->ConvertFormatDateToDb($form['ngaybatdau']);
			$ngaytudanhgia = $this->ConvertFormatDateToDb($form['ngaytudanhgia']);
			$ngayketthuc = $this->ConvertFormatDateToDb($form['ngayketthuc']);
			if($form['is_danhgianam']==1){
				$is_danhgianam = 1;
			}
			else{
				$is_danhgianam = 0;
			}
			if($form['is_lock']==1){
				$is_lock = 1;
			}
			else{
				$is_lock = 0;
			}
			$field = array($db->quotename('id_botieuchi').'='.$db->quote($form['id_botieuchi']),
					$db->quotename('name').'='.$db->quote($name),
					$db->quotename('date_dot').'='.$db->quote($date_dot),
					$db->quotename('ngaybatdau').'='.$db->quote($ngaybatdau),
					$db->quotename('ngayketthuc').'='.$db->quote($ngayketthuc),
					$db->quotename('time_dot').'='.$db->quote($form['time_dot']),
					$db->quotename('is_danhgianam').'='.$db->quote($is_danhgianam),
					$db->quotename('is_lock').'='.$db->quote($is_lock),
					$db->quotename('ghichu').'='.$db->quote($ghichu),
					$db->quotename('ngaytudanhgia').'='.$db->quote($ngaytudanhgia));
			$query->insert('dgcbcc_dotdanhgia');
			$query->set($field);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();
		}
		public function add_partition_id_dotdanhgia($id_dotdanhgia){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.table,a.key_partition');
			$query->from('dgcbcc_partitions a');
			$query->where('a.key_table='.$db->quote('dgcbcc_dotdanhgia'));
			$db->setQuery($query);
			$rows = $db->loadAssocList();
			// var_dump($rows);die;
			for($i = 0;$i<count($rows); $i++){
				$query = $db->getQuery(true);
				$query = 'ALTER TABLE '.$rows[$i]['table'].' ADD PARTITION(PARTITION p_'.$id_dotdanhgia.' VALUES IN ('.$id_dotdanhgia.') ENGINE = MYISAM)';
				$db->setQuery($query);
				// echo $query;die;
				$result[] = $db->query();
			}
			return $result;
		}
		// public function add_partition_dotdanhgia_thang($id_dotdanhgia){
		// 	$db = JFactory::getDbo();
		// 	$query = $db->getQuery(true);
		// 	$query = 'ALTER TABLE dgcbcc_dotdanhgia_thang ADD PARTITION(PARTITION p_'.$id_dotdanhgia.' VALUES IN ('.$id_dotdanhgia.') ENGINE = MYISAM)';
		// 	$db->setQuery($query);
		// 	return $db->query();
		// }
		public function add_dotdanhgia_thang($form,$id_dotdanhgia,$max_date_dot){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('inst_code');
			$query->from('dgcbcc_dotdanhgia_thang');
			$query->where('date_dot='.$db->quote($max_date_dot));
			$db->setQuery($query);
			$rows_inst_code = $db->loadAssocList();
			for($i=0;$i<count($rows_inst_code);$i++){
				$query = $db->getQuery(true);
				$name = $this->check_sql_injection($form['name']);
				$ghichu = $this->check_sql_injection($form['ghichu']);
				$date_dot = $this->ConvertFormatDateToDb($form['date_dot']);
				$ngaybatdau = $this->ConvertFormatDateToDb($form['ngaybatdau']);
				$ngaytudanhgia = $this->ConvertFormatDateToDb($form['ngaytudanhgia']);
				$ngayketthuc = $this->ConvertFormatDateToDb($form['ngayketthuc']);
				$inst_code = $rows_inst_code[$i]['inst_code'];
				if($form['is_danhgianam']==1){
					$is_danhgianam = 1;
				}
				else{
					$is_danhgianam = 0;
				}
				if($form['is_lock']==1){
					$is_lock = 1;
				}
				else{
					$is_lock = 0;
				}
				$field = array($db->quotename('id_dotdanhgia').'='.$db->quote($id_dotdanhgia),
						$db->quotename('inst_code').'='.$db->quote($inst_code),
						$db->quotename('id_botieuchi').'='.$db->quote($form['id_botieuchi']),
						$db->quotename('name').'='.$db->quote($name),
						$db->quotename('date_dot').'='.$db->quote($date_dot),
						$db->quotename('ngaybatdau').'='.$db->quote($ngaybatdau),
						$db->quotename('ngayketthuc').'='.$db->quote($ngayketthuc),
						$db->quotename('time_dot').'='.$db->quote($form['time_dot']),
						$db->quotename('is_danhgianam').'='.$db->quote($is_danhgianam),
						$db->quotename('is_lock').'='.$db->quote($is_lock),
						$db->quotename('ghichu').'='.$db->quote($ghichu),
						$db->quotename('ngaytudanhgia').'='.$db->quote($ngaytudanhgia));
				$query->insert('dgcbcc_dotdanhgia_thang');
				$query->set($field);
				$db->setQuery($query);			
				$result[] = $db->query();
			}
			return $result;
		}
		public function add_dgcbcc_user_nhiemvu($id_dotdanhgia,$max_id_dotdanhgia){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('user_id,id_hosochinh,e_name,birth_date,position,pos_td,inst_code,dept_code,id_theonhiemvu,id_dotdanhgia,is_lock,is_tongket');
			$query->from('dgcbcc_user_nhiemvu');
			$query->where('id_dotdanhgia='.$db->quote($max_id_dotdanhgia));
			$db->setQuery($query);
			$ds_dgcbcc_user_nhiemvu = $db->loadAssocList();
			for($i=0;$i<count($ds_dgcbcc_user_nhiemvu);$i++){
				$query = $db->getQuery(true);
				$field = array($db->quotename('user_id').'='.$db->quote($ds_dgcbcc_user_nhiemvu[$i]['user_id']),
					$db->quotename('id_hosochinh').'='.$db->quote($ds_dgcbcc_user_nhiemvu[$i]['id_hosochinh']),
					$db->quotename('e_name').'='.$db->quote($ds_dgcbcc_user_nhiemvu[$i]['e_name']),
					$db->quotename('birth_date').'='.$db->quote($ds_dgcbcc_user_nhiemvu[$i]['birth_date']),
					$db->quotename('position').'='.$db->quote($ds_dgcbcc_user_nhiemvu[$i]['position']),
					$db->quotename('pos_td').'='.$db->quote($ds_dgcbcc_user_nhiemvu[$i]['pos_td']),
					$db->quotename('inst_code').'='.$db->quote($ds_dgcbcc_user_nhiemvu[$i]['inst_code']),
					$db->quotename('dept_code').'='.$db->quote($ds_dgcbcc_user_nhiemvu[$i]['dept_code']),
					$db->quotename('id_theonhiemvu').'='.$db->quote($ds_dgcbcc_user_nhiemvu[$i]['id_theonhiemvu']),
					$db->quotename('id_dotdanhgia').'='.$db->quote($id_dotdanhgia),
					$db->quotename('is_lock').'='.$db->quote($ds_dgcbcc_user_nhiemvu[$i]['is_lock']),
					$db->quotename('is_tongket').'='.$db->quote($ds_dgcbcc_user_nhiemvu[$i]['is_tongket']));
				$query->insert('dgcbcc_user_nhiemvu');
				$query->set($field);
				$db->setQuery($query);
				$result[] = $db->query();
			}
			return $result;
		}
		public function add_dgcbcc_user_quyen($id_dotdanhgia,$max_id_dotdanhgia){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id_u_dg,id_u_ddg,id_tieuchuan_dg');
			$query->from('dgcbcc_user_quyen');
			$query->where('id_dotdanhgia='.$db->quote($max_id_dotdanhgia));
			$db->setQuery($query);
			$ds_dgcbcc_user_quyen= $db->loadAssocList();
			for($i=0;$i<count($ds_dgcbcc_user_quyen);$i++){
				$query = $db->getQuery(true);
				$field = array($db->quotename('id_u_dg').'='.$db->quote($ds_dgcbcc_user_quyen[$i]['id_u_dg']),
					$db->quotename('id_u_ddg').'='.$db->quote($ds_dgcbcc_user_quyen[$i]['id_u_ddg']),
					$db->quotename('id_tieuchuan_dg').'='.$db->quote($ds_dgcbcc_user_quyen[$i]['id_tieuchuan_dg']),
					$db->quotename('id_dotdanhgia').'='.$db->quote($id_dotdanhgia));
				$query->insert("dgcbcc_user_quyen");
				$query->set($field);
				$db->setQuery($query);
				$result[] = $db->query();
			}
			return $result;
		}
		public function add_dgcbcc_xeploai($id_dotdanhgia,$max_id_dotdanhgia){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('name,code,diem_min,diem_max,id_dotdanhgia,published');
			$query->from('dgcbcc_xeploai');
			$query->where('id_dotdanhgia='.$db->quote($max_id_dotdanhgia));
			$db->setQuery($query);
			$ds_dgcbcc_xeploai= $db->loadAssocList();
			for($i=0;$i<count($ds_dgcbcc_xeploai);$i++){
				$query = $db->getQuery(true);
				$field = array($db->quotename('name').'='.$db->quote($ds_dgcbcc_xeploai[$i]['name']),
						$db->quotename('code').'='.$db->quote($ds_dgcbcc_xeploai[$i]['code']),
						$db->quotename('diem_min').'='.$db->quote($ds_dgcbcc_xeploai[$i]['diem_min']),
						$db->quotename('diem_max').'='.$db->quote($ds_dgcbcc_xeploai[$i]['diem_max']),
						$db->quotename('id_dotdanhgia').'='.$db->quote($id_dotdanhgia),
						$db->quotename('published').'='.$db->quote($ds_dgcbcc_xeploai[$i]['published']));
				$query->insert('dgcbcc_xeploai');
				$query->set($field);
				$db->setQuery($query);
				$result[] = $db->query();
			}
			return $result;
		}
		public function add_dgcbcc_fk_loaicongviec_dotdanhgia($id_dotdanhgia,$max_id_dotdanhgia){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id_loai_congviec');
			$query->from('dgcbcc_fk_loaicongviec_dotdanhgia');
			$query->where('id_dotdanhgia='.$db->quote($max_id_dotdanhgia));
			$db->setQuery($query);
			$ds_dgcbcc_fk_loaicongviec_dotdanhgia= $db->loadAssocList();
			for($i=0;$i<count($ds_dgcbcc_fk_loaicongviec_dotdanhgia);$i++){
				$query = $db->getQuery(true);
				$field = array($db->quotename('id_loai_congviec').'='.$db->quote($ds_dgcbcc_fk_loaicongviec_dotdanhgia[$i]['id_loai_congviec']),
						$db->quotename('id_dotdanhgia').'='.$db->quote($id_dotdanhgia));
				$query->insert('dgcbcc_fk_loaicongviec_dotdanhgia');
				$query->set($field);
				$db->setQuery($query);
				$result[] = $db->query();
			}
			return $result;
		}
		public function get_max_id_dotdanhgia(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('MAX(id)');
			$query->from('dgcbcc_dotdanhgia');
			$query->where('daxoa!=1');
			$db->setQuery($query);
			return $db->loadResult();
		}
		public function get_max_date_dot(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('MAX(date_dot) as max_date_dot');
			$query->from('dgcbcc_dotdanhgia');
			$query->where('daxoa!=1');
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
	    public function find_dotdanhgia_by_id($id){
	    	$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,id_botieuchi,name,date_dot,time_dot,ngaybatdau,ngayketthuc,ngaytudanhgia,is_danhgianam,is_lock,ghichu');
			$query->from('dgcbcc_dotdanhgia');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
	    }
	    public function update_dotdanhgia($form){
	    	$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$ghichu = $this->check_sql_injection($form['ghichu']);
			$date_dot = $this->ConvertFormatDateToDb($form['date_dot']);
			$ngaybatdau = $this->ConvertFormatDateToDb($form['ngaybatdau']);
			$ngaytudanhgia = $this->ConvertFormatDateToDb($form['ngaytudanhgia']);
			$ngayketthuc = $this->ConvertFormatDateToDb($form['ngayketthuc']);
			if($form['is_danhgianam']==1){
				$is_danhgianam = 1;
			}
			else{
				$is_danhgianam = 0;
			}
			if($form['is_lock']==1){
				$is_lock = 1;
			}
			else{
				$is_lock = 0;
			}
			$field = array($db->quotename('id_botieuchi').'='.$db->quote($form['id_botieuchi']),
					$db->quotename('name').'='.$db->quote($name),
					$db->quotename('date_dot').'='.$db->quote($date_dot),
					$db->quotename('ngaybatdau').'='.$db->quote($ngaybatdau),
					$db->quotename('ngayketthuc').'='.$db->quote($ngayketthuc),
					$db->quotename('time_dot').'='.$db->quote($form['time_dot']),
					$db->quotename('is_danhgianam').'='.$db->quote($is_danhgianam),
					$db->quotename('is_lock').'='.$db->quote($is_lock),
					$db->quotename('ghichu').'='.$db->quote($ghichu),
					$db->quotename('ngaytudanhgia').'='.$db->quote($ngaytudanhgia));
			$query->update('dgcbcc_dotdanhgia');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			$db->query();
			return $form['id'];
	    }
	    public function update_dotdanhgia_thang($form){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$ghichu = $this->check_sql_injection($form['ghichu']);
			$date_dot = $this->ConvertFormatDateToDb($form['date_dot']);
			$ngaybatdau = $this->ConvertFormatDateToDb($form['ngaybatdau']);
			$ngaytudanhgia = $this->ConvertFormatDateToDb($form['ngaytudanhgia']);
			$ngayketthuc = $this->ConvertFormatDateToDb($form['ngayketthuc']);
			if($form['is_danhgianam']==1){
				$is_danhgianam = 1;
			}
			else{
				$is_danhgianam = 0;
			}
			if($form['is_lock']==1){
				$is_lock = 1;
			}
			else{
				$is_lock = 0;
			}
			$field = array($db->quotename('id_botieuchi').'='.$db->quote($form['id_botieuchi']),
					$db->quotename('name').'='.$db->quote($name),
					$db->quotename('date_dot').'='.$db->quote($date_dot),
					$db->quotename('ngaybatdau').'='.$db->quote($ngaybatdau),
					$db->quotename('ngayketthuc').'='.$db->quote($ngayketthuc),
					$db->quotename('time_dot').'='.$db->quote($form['time_dot']),
					$db->quotename('is_danhgianam').'='.$db->quote($is_danhgianam),
					$db->quotename('is_lock').'='.$db->quote($is_lock),
					$db->quotename('ghichu').'='.$db->quote($ghichu),
					$db->quotename('ngaytudanhgia').'='.$db->quote($ngaytudanhgia));
			$query->update('dgcbcc_dotdanhgia_thang');
			$query->set($field);
			$query->where('id_dotdanhgia='.$db->quote($form['id']));
			$db->setQuery($query);			
			return $db->query();
	    }
	    public function delete_dotdanhgia($id){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$query->update('dgcbcc_dotdanhgia');
	    	$query->set('daxoa=1');
	    	$query->where('id='.$db->quote($id));
	    	$db->setQuery($query);
	    	return $db->query();
	    }
	    public function delete_dotdanhgia_thang($id){
	    	$db = JFactory::getDbo();
	    	$query = $db->getQuery(true);
	    	$query->update('dgcbcc_dotdanhgia_thang');
	    	$query->set('daxoa=1');
	    	$query->where('id_dotdanhgia='.$db->quote($id));
	    	$db->setQuery($query);
	    	return $db->query();
	    }
	}
?>