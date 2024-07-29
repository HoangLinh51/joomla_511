<?php 
	class Danhmuchethong_Model_Ngachbac extends JModelLegacy{
		public function tree_quanly_ngachbac($id_parent, $option=array()){
			$db = JFactory::getDbo();
			// $exceptionUnits = Core::getUnManageDonvi(JFactory::getUser()->id, $option['component'], $option['view'], $option['task']);
			// $exception_condition = ($exceptionUnits)?' AND a.id NOT IN ('.$exceptionUnits.')':'';
			// $where = ($option['condition'])?' AND '.$option['condition']:'';
			$query = 'SELECT a.id,a.parentid,a.name,a.status
								FROM cb_nhomngach AS a
								WHERE  a.parentid = '.$db->quote($id_parent).$exception_condition.$where;
			$db->setQuery($query);
			// echo $query;die;
			$rows = $db->loadAssocList();
			// var_dump($rows);die;
			$arrTypes = array('file','folder','root');
			for ($i=0;$i<count($rows);$i++){
				$types = '';
				$result[] = array(
						"attr" => array("id" => "node_".$rows[$i]['id'], "rel" => 'folder', "showlist" => '3'),
						"data" => $rows[$i]['name'],
						"state" => "closed"
						);
			}
			// var_dump($result);die;
			return json_encode($result);
		}
		// public function findroot_id(){
		// 	$db = JFactory::getDbo();
		// 	$query = $db->getQuery(true);
		// 	$query->select('id as root_id');
		// 	$query->from('cb_goiluong');
		// 	$query->where('level = 0');
		// 	// $query->group('id');
		// 	// $query->setLimit('1');
		// 	$db->setQuery($query);
		// 	// echo $query;die;
		// 	// $id = $db->loadAssoc();
		// 	// return $id['root_id'];
		// 	return $db->loadResult();
		// }
		static public function getOneNodeJsTree(){
			// $db = JFactory::getDbo();
			// $query = $db->getQuery(true);
			// $query->select('id,name');
			// $query->from('cb_nhomngach');
			// $query->where('id='.$db->quote($dept_id));
			// // echo $query;
			// $db->setQuery($query);
			// $row = $db->loadAssoc();
			// // var_dump($row);die;
			$data = array(
				"attr"=> array(
				// "data-type" => $row['type'],
				"id" => "node_0",
				// "rel" => (($row['type']==1)?'folder':(($row['type']==2)?'root':'file'))
			),
			"data" => 'Danh sách nhóm ngạch',
			"state" => "closed"
			);
			return json_encode($data);
		}
		public function getall_bangluong(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('cb_bangluong');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function add_ngachbac($form,$idbac,$heso){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);		
			if(count($idbac)>0&&count($heso)>0){
				for($i=0;$i<count($heso);$i++){
					if($i==0){
						$bacdau = $idbac[$i];
						$hesodau = $heso[$i];
						$baccuoi = $idbac[$i];
						$hesocuoi = $heso[$i];
					}
					else{
						if($heso[$i]>$hesocuoi){
							$hesocuoi = $heso[$i];
							$baccuoi = $idbac[$i];
						}
						if($heso[$i]<$hesodau){
							$bacdau = $idbac[$i];
							$hesodau = $heso[$i];
						}
					}
				}
			}
			else{
				$bacdau = 0;
				$hesodau = 0;
				$baccuoi = 0;
				$hesocuoi = 0;
			}
			$name = self::check_sql_injection($form['name']);
			$code = self::check_sql_injection($form['code']);
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('idbangluong').'='.$db->quote($form['idbangluong']),
						$db->quotename('cap').'='.$db->quote($form['cap']),
						$db->quotename('bacdau').'='.$db->quote($bacdau),
						$db->quotename('hesodau').'='.$db->quote($hesodau),
						$db->quotename('baccuoi').'='.$db->quote($baccuoi),
						$db->quotename('hesocuoi').'='.$db->quote($hesocuoi),
						$db->quotename('sonamluong').'='.$db->quote($form['sonamluong']),
						$db->quotename('parentid').'='.$db->quote($form['parentid']),
						$db->quotename('code').'='.$db->quote($code),
						$db->quotename('status').'='.$db->quote($form['status']));
			$query->insert('cb_nhomngach');
			$query->set($field);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();
		}
		public function update_ngachbac($form,$idbac,$heso){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);		
			if(count($idbac)>0&&count($heso)>0){
				for($i=0;$i<count($heso);$i++){
					if($i==0){
						$bacdau = $idbac[$i];
						$hesodau = $heso[$i];
						$baccuoi = $idbac[$i];
						$hesocuoi = $heso[$i];
					}
					else{
						if($heso[$i]>$hesocuoi){
							$hesocuoi = $heso[$i];
							$baccuoi = $idbac[$i];
						}
						if($heso[$i]<$hesodau){
							$bacdau = $idbac[$i];
							$hesodau = $heso[$i];
						}
					}
				}
			}
			else{
				$bacdau = 0;
				$hesodau = 0;
				$baccuoi = 0;
				$hesocuoi = 0;
			}
			$name = self::check_sql_injection($form['name']);
			$code = self::check_sql_injection($form['code']);
			$field = array($db->quotename('name').'='.$db->quote($name),
						$db->quotename('idbangluong').'='.$db->quote($form['idbangluong']),
						$db->quotename('cap').'='.$db->quote($form['cap']),
						$db->quotename('bacdau').'='.$db->quote($bacdau),
						$db->quotename('hesodau').'='.$db->quote($hesodau),
						$db->quotename('baccuoi').'='.$db->quote($baccuoi),
						$db->quotename('hesocuoi').'='.$db->quote($hesocuoi),
						$db->quotename('sonamluong').'='.$db->quote($form['sonamluong']),
						$db->quotename('parentid').'='.$db->quote($form['parentid']),
						$db->quotename('code').'='.$db->quote($code),
						$db->quotename('status').'='.$db->quote($form['status']));
			$query->update('cb_nhomngach');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			$db->query();
			return $form['id'];
		}
		public function add_cb_nhomngach_heso($id_ngachbac,$idbac,$heso, $code){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('idbac').'='.$db->quote($idbac),
						$db->quotename('heso').'='.$db->quote($heso),
						$db->quotename('id_ngach').'='.$db->quote($id_ngachbac),
						$db->quotename('sta_code').'='.$db->quote($code));
			$query->insert('cb_nhomngach_heso');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function update_cb_nhomngach_heso($id_ngachbac,$idbac,$heso, $code){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('idbac').'='.$db->quote($idbac),
						$db->quotename('heso').'='.$db->quote($heso),
						$db->quotename('sta_code').'='.$db->quote($code));
			$query->update('cb_nhomngach_heso');
			$query->set($field);
			$query->where($db->quotename('id').'='.$db->quote($id_ngachbac));
			$db->setQuery($query);
			return $db->query();
		}
		public function find_nhomngach_by_id($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.id,a.name,a.idbangluong,a.cap,a.bacdau,a.hesodau,a.baccuoi,a.hesocuoi,a.sonamluong,a.parentid,a.code,a.status,b.name as bangluong_name');
			$query->from('cb_nhomngach a');
			$query->join('INNER','cb_bangluong b ON (b.id=a.idbangluong)');
			$query->where('a.id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
		public function find_nhomngach_heso_by_id_ngach($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,idbac,heso,id_ngach');
			$query->from('cb_nhomngach_heso');
			$query->where('id_ngach='.$db->quote($id));
			$query->order('id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function delete_cb_nhomngach_heso($id_ngachbac){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('cb_nhomngach_heso');
			$query->where('id_ngach='.$db->quote($id_ngachbac));
			$db->setQuery($query);
			return $db->query();
		}
		public function getall_nganh(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('function_code');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function find_parent_id_by_id_nhomngach($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('parentid');
			$query->from('cb_nhomngach');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadResult();
		}
		public function find_ngach_by_ma_nhom($id){
			$db = JFactory::getDbo();
			$parentid = self::find_parent_id_by_id_nhomngach($id);
			$query = $db->getQuery(true);
			$query->select('mangach,name');
			$query->from('cb_bac_heso');
			$query->where('manhom='.$db->quote($parentid));	
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function add_cb_bac_heso($manhom,$tenngach,$mangach,$idnganh,$mangachtiep,$is_vuotkhung){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$mangach = self::check_sql_injection($mangach);
			$tenngach = self::check_sql_injection($tenngach);
			if($is_vuotkhung=='1'){
				$is_vuotkhung = '1';
			}
			else{
				$is_vuotkhung = '0';
			}
			$field = array($db->quotename('manhom').'='.$db->quote($manhom),
						$db->quotename('mangach').'='.$db->quote($mangach),
						$db->quotename('name').'='.$db->quote($tenngach),
						$db->quotename('idnganh').'='.$db->quote($idnganh),
						$db->quotename('mangachtiep').'='.$db->quote($mangachtiep),
						$db->quotename('is_vuotkhung').'='.$db->quote($is_vuotkhung));
			$query->insert('cb_bac_heso');
			$query->set($field);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();
		}
		public function update_cb_bac_heso($id,$manhom,$tenngach,$mangach,$idnganh,$mangachtiep,$is_vuotkhung){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$mangach = self::check_sql_injection($mangach);
			$tenngach = self::check_sql_injection($tenngach);
			if($is_vuotkhung=='1'){
				$is_vuotkhung = '1';
			}
			else{
				$is_vuotkhung = '0';
			}
			$field = array($db->quotename('manhom').'='.$db->quote($manhom),
						$db->quotename('mangach').'='.$db->quote($mangach),
						$db->quotename('name').'='.$db->quote($tenngach),
						$db->quotename('idnganh').'='.$db->quote($idnganh),
						$db->quotename('mangachtiep').'='.$db->quote($mangachtiep),
						$db->quotename('is_vuotkhung').'='.$db->quote($is_vuotkhung));
			$query->update('cb_bac_heso');
			$query->set($field);
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			$db->query();
			return $id;
		}
		public function find_cb_bac_heso_by_manhom($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.id,a.mangach,a.name,a.idnganh,(SELECT name FROM cb_bac_heso WHERE mangach=a.mangachtiep) as mangachtiep_name,a.is_vuotkhung,b.name as nganh_name');
			$query->from('cb_bac_heso a');
			$query->join('INNER','function_code b ON (b.id=a.idnganh)');
			$query->where('manhom='.$db->quote($id));
			$query->order('id asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function delete_cb_nhomngach_heso_by_id($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('cb_nhomngach_heso');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function delete_cb_bac_heso($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('cb_bac_heso');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function add_thongtin_ngachbac($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$ds_cb_bac_heso = self::find_cb_bac_heso_by_manhom($form['manhom']);
			for($i=0;$i<count($ds_cb_bac_heso);$i++){
				if($ds_cb_bac_heso[$i]['mangach']==$form['mangach']){
					return 0;
				}
			}
			$mangach = self::check_sql_injection($form['mangach']);
			$name = self::check_sql_injection($form['name']);
			if(isset($form['is_vuotkhung'])&&$form['is_vuotkhung']==1){
				$is_vuotkhung = 1;
			}
			else{
				$is_vuotkhung = 0;
			}
			$field = array($db->quotename('manhom').'='.$db->quote($form['manhom']),
						$db->quotename('mangach').'='.$db->quote($mangach),
						$db->quotename('name').'='.$db->quote($name),
						$db->quotename('idnganh').'='.$db->quote($form['idnganh']),
						$db->quotename('mangachtiep').'='.$db->quote($form['mangachtiep']),
						$db->quotename('is_vuotkhung').'='.$db->quote($is_vuotkhung));
			$query->insert('cb_bac_heso');
			$query->set($field);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();
		}
		public function update_thongtin_ngachbac($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$ds_cb_bac_heso = self::find_cb_bac_heso_by_manhom($form['manhom']);
			for($i=0;$i<count($ds_cb_bac_heso);$i++){
				if($ds_cb_bac_heso[$i]['mangach']==$form['mangach']&&$ds_cb_bac_heso[$i]['id']!=$form['id']){
					return 0;
				}
			}
			$mangach = self::check_sql_injection($form['mangach']);
			$name = self::check_sql_injection($form['name']);
			if(isset($form['is_vuotkhung'])&&$form['is_vuotkhung']==1){
				$is_vuotkhung = 1;
			}
			else{
				$is_vuotkhung = 0;
			}
			$field = array($db->quotename('manhom').'='.$db->quote($form['manhom']),
						$db->quotename('mangach').'='.$db->quote($mangach),
						$db->quotename('name').'='.$db->quote($name),
						$db->quotename('idnganh').'='.$db->quote($form['idnganh']),
						$db->quotename('mangachtiep').'='.$db->quote($form['mangachtiep']),
						$db->quotename('is_vuotkhung').'='.$db->quote($is_vuotkhung));
			$query->update('cb_bac_heso');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			return $db->query();
		}
		public function find_thongtin_ngach_by_id($id_ngach){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,mangach,name,idnganh,mangachtiep,is_vuotkhung');
			$query->from('cb_bac_heso');
			$query->where('id='.$db->quote($id_ngach));
			$db->setQuery($query);
			return $db->loadAssoc();
		}
	}
?>