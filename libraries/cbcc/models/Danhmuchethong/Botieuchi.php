<?php 
	class Danhmuchethong_Model_Botieuchi extends JModelLegacy{
		public function tree_botieuchi($parent_id,$nhiemvu_id, $option=array()){
			$db = JFactory::getDbo();
			// $exceptionUnits = Core::getUnManageDonvi(JFactory::getUser()->id, $option['component'], $option['view'], $option['task']);
			// $exception_condition = ($exceptionUnits)?' AND a.id NOT IN ('.$exceptionUnits.')':'';
			// $where = ($option['condition'])?' AND '.$option['condition']:'';
			if($nhiemvu_id>0){
				$where = 'AND c.id_theonhiemvu='.$db->quote($nhiemvu_id);
			}
			else{
				$where = '';
			}
			if($parent_id==1){
				$query = 'SELECT a.id,a.parent_id,a.name,a.level,a.lft,a.rgt,a.status
								FROM dgcbcc_botieuchi AS a LEFT JOIN dgcbcc_fk_theonhiemvu_botieuchi AS c ON (a.id=c.id_botieuchi)
								WHERE daxoa!=1 AND a.parent_id = '.$db->quote($parent_id).$where.' GROUP BY a.id
								ORDER BY a.lft';
			}
			else{
				$query = 'SELECT a.id,a.parent_id,a.name,a.level,a.lft,a.rgt,a.status
								FROM dgcbcc_botieuchi AS a LEFT JOIN dgcbcc_fk_theonhiemvu_botieuchi AS c ON (a.id=c.id_botieuchi)
								WHERE daxoa!=1 AND a.parent_id = '.$db->quote($parent_id).$where.' GROUP BY a.id
								ORDER BY a.lft';			
			}
			// echo $query;die;
			$db->setQuery($query);
			$rows = $db->loadAssocList();
			// var_dump($rows);die;
			$arrTypes = array('file','folder','root');
			for ($i=0;$i<count($rows);$i++){
				$types = '';
				$result[] = array(
						"attr" => array("id" => "node_".$rows[$i]['id'], "rel" => $arrTypes[$rows[$i]['type']], "showlist" => $rows[$i]['type']),
						"data" => $rows[$i]['name'],
						"state" => ((int)$rows[$i]['rgt'] - (int)$rows[$i]['left'] > 1) ? "closed" : ""
						);
			}
			return json_encode($result);
		}
		public function findroot_id(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id as root_id');
			$query->from('dgcbcc_botieuchi');
			$query->where('id = 1');
			// $query->group('id');
			// $query->setLimit('1');
			$db->setQuery($query);
			// echo $query;die;
			// $id = $db->loadAssoc();
			// return $id['root_id'];
			return $db->loadResult();
		}
		static public function getOneNodeJsTree($dept_id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select(array('id','name'))->from('dgcbcc_botieuchi')->where('id='.$db->quote($dept_id));
			$db->setQuery($query);
			$row = $db->loadAssoc();
			$data = array(
				"attr"=> array(
				"data-type" => $row['type'],
				"id" => "node_".$row['id'],
				// "rel" => (($row['type']==1)?'folder':(($row['type']==2)?'root':'file'))
			),
			"data" => $row['name'],
			"state" => "closed"
			);
			return json_encode($data);
		}
		public function getall_botieuchi(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,CONCAT(REPEAT(".--", level), name)AS name');
			$query->from('dgcbcc_botieuchi');
			$query->where('daxoa <> 1');
			$query->order('lft asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function check_sql_injection($string){
	        $filter = JFilterInput::getInstance();
	        return $filter->clean($string,'string');
	    }
		public function add_botieuchi($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$code = $this->check_sql_injection($form['code']);
			if($form['is_dexuat']==1){
				$is_dexuat = 1;
			}
			else{
				$is_dexuat = 0;
			}
			if($form['status']==1){
				$status = 1;
			}
			else{
				$status = 0;
			}
			if($form['published']==1){
				$published = 1;
			}
			else{
				$published = 0;
			}
			if($form['group']==1){
				$group = 1;
			}
			else{
				$group = 0;
			}
			$field = array($db->quotename('parent_id').'='.$db->quote($form['parent_id']),
						$db->quotename('id_loaicongviec').'='.$db->quote($form['id_loaicongviec']),
						$db->quotename('name').'='.$db->quote($name),
						$db->quotename('code').'='.$db->quote($code),
						$db->quotename('is_dexuat').'='.$db->quote($is_dexuat),
						$db->quotename('status').'='.$db->quote($status),
						$db->quotename('published').'='.$db->quote($published),
						$db->quotename('tk_diemchinh').'='.$db->quote($form['tk_diemchinh']),
						$db->quotename('tk_diemcong').'='.$db->quote($form['tk_diemcong']),
						$db->quotename('tk_diemtru').'='.$db->quote($form['tk_diemtru']),
						$db->quotename('group').'='.$db->quote($group),
						$db->quotename('lft').'='.$db->quote('999999'),
						$db->quotename('daxoa').'=0');
			$query->insert('dgcbcc_botieuchi');
			$query->set($field);
			$db->setQuery($query);
			$db->query();
			return $db->insertid();
		}
		public function delete_botieuchi($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->update('dgcbcc_botieuchi');
			$query->set('daxoa=1');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			return $db->query();
		}
		public function find_botieuchi_by_id($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name,parent_id,id_loaicongviec,code,is_dexuat,status,published,tk_diemchinh,tk_diemcong,tk_diemtru,a.group,a.lft,a.rgt');
			$query->from('dgcbcc_botieuchi a');
			$query->where('id='.$db->quote($id));
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssoc();
		}
		public function update_botieuchi($form){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$name = $this->check_sql_injection($form['name']);
			$code = $this->check_sql_injection($form['code']);
			if($form['is_dexuat']==1){
				$is_dexuat = 1;
			}
			else{
				$is_dexuat = 0;
			}
			if($form['status']==1){
				$status = 1;
			}
			else{
				$status = 0;
			}
			if($form['published']==1){
				$published = 1;
			}
			else{
				$published = 0;
			}
			if($form['group']==1){
				$group = 1;
			}
			else{
				$group = 0;
			}
			$field = array($db->quotename('parent_id').'='.$db->quote($form['parent_id']),
						$db->quotename('id_loaicongviec').'='.$db->quote($form['id_loaicongviec']),
						$db->quotename('name').'='.$db->quote($name),
						$db->quotename('code').'='.$db->quote($code),
						$db->quotename('is_dexuat').'='.$db->quote($is_dexuat),
						$db->quotename('status').'='.$db->quote($status),
						$db->quotename('published').'='.$db->quote($published),
						$db->quotename('tk_diemchinh').'='.$db->quote($form['tk_diemchinh']),
						$db->quotename('tk_diemcong').'='.$db->quote($form['tk_diemcong']),
						$db->quotename('tk_diemtru').'='.$db->quote($form['tk_diemtru']),
						$db->quotename('group').'='.$db->quote($group));
			$query->update('dgcbcc_botieuchi');
			$query->set($field);
			$query->where('id='.$db->quote($form['id']));
			$db->setQuery($query);
			$db->query();
			return $form['id'];
		}
		
		public function find_tieuchi_by_botieuchi($id_botieuchi){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.id_tieuchi,b.id_nhom,a.diem_min,a.diem_max,a.code_xeploai,a.id_tieuchi_phanloai');
			$query->from('dgcbcc_fk_botieuchi_tieuchi a');
			$query->join('INNER','dgcbcc_tieuchi b ON (a.id_tieuchi=b.id)');
			$query->where('id_botieuchi='.$db->quote($id_botieuchi));
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssocList();
		}
		public function add_dgcbcc_fk_botieuchi_tieuchi($id_dgcbcc_botieuchi,$tieuchi_id,$diem_min,$diem_max,$code_xeploai,$id_tieuchi_phanloai){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('id_botieuchi').'='.$db->quote($id_dgcbcc_botieuchi),
						$db->quotename('id_tieuchi').'='.$db->quote($tieuchi_id),
						$db->quotename('code_xeploai').'='.$db->quote($code_xeploai),
						$db->quotename('id_tieuchi_phanloai').'='.$db->quote($id_tieuchi_phanloai));
			$query->insert('dgcbcc_fk_botieuchi_tieuchi');
			$query->set($field);
			if($code_xeploai!=''){
				$query->set($db->quotename('diem_min').'='.$db->quote($diem_min));
				$query->set($db->quotename('diem_max').'='.$db->quote($diem_max));
			}
			$db->setQuery($query);
			// echo $query;die;
			return $db->query();
		}
		public function delete_dgcbcc_fk_botieuchi_tieuchi_by_botieuchi_id($id_botieuchi){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('dgcbcc_fk_botieuchi_tieuchi');
			$query->where('id_botieuchi='.$db->quote($id_botieuchi));
			$db->setQuery($query);
			return $db->query();
		}
		public function add_dgcbcc_fk_theonhiemvu_botieuchi($id_botieuchi,$id_theonhiemvu,$diem_min,$diem_max){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('id_botieuchi').'='.$db->quote($id_botieuchi),
						$db->quotename('id_theonhiemvu').'='.$db->quote($id_theonhiemvu),
						$db->quotename('diem_min').'='.$db->quote($diem_min),
						$db->quotename('diem_max').'='.$db->quote($diem_max));
			$query->insert('dgcbcc_fk_theonhiemvu_botieuchi');
			$query->set($field);
			// echo $query;die;
			$db->setQuery($query);
			return $db->query();
		}
		public function find_dgcbcc_fk_theonhiemvu_botieuchi_by_botieuchi($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id_theonhiemvu,id_botieuchi,diem_min,diem_max');
			$query->from('dgcbcc_fk_theonhiemvu_botieuchi');
			$query->where('id_botieuchi='.$db->quote($id));
			$db->setQuery($query);
			// echo $query;die;
			return $db->loadAssocList();
		}
		public function delete_dgcbcc_fk_theonhiemvu_botieuchi_by_id_botieuchi($id_botieuchi){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('dgcbcc_fk_theonhiemvu_botieuchi');
			$query->where('id_botieuchi='.$db->quote($id_botieuchi));
			$db->setQuery($query);
			return $db->query();
		}
		public function add_dgcbcc_fk_tieuchuan_dg_botieuchi($id_dgcbcc_botieuchi,$id_tieuchuan_dg){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$field = array($db->quotename('id_tieuchuan_dg').'='.$db->quote($id_tieuchuan_dg),
						$db->quotename('id_botieuchi').'='.$db->quote($id_dgcbcc_botieuchi));
			$query->insert('dgcbcc_fk_tieuchuan_dg_botieuchi');
			$query->set($field);
			$db->setQuery($query);
			return $db->query();
		}
		public function find_dgcbcc_fk_tieuchuan_dg_botieuchi($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id_tieuchuan_dg,id_botieuchi');
			$query->from('dgcbcc_fk_tieuchuan_dg_botieuchi');
			$query->where('id_botieuchi='.$db->quote($id));
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function delete_dgcbcc_fk_tieuchuan_dg_botieuchi_by_id_botieuchi($id_botieuchi){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->delete('dgcbcc_fk_tieuchuan_dg_botieuchi');
			$query->where('id_botieuchi='.$db->quote($id_botieuchi));
			$db->setQuery($query);
			return $db->query();
		}
		public function insert_botieuchi_node($botieuchicon,$botieuchicha,$hs_dgcbcc_botieuchi){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$id = $hs_dgcbcc_botieuchi+$botieuchicon['id'];
			$field = array($db->quotename('parent_id').'='.$db->quote($botieuchicha),
						$db->quotename('id').'='.$db->quote($id),
						$db->quotename('id_loaicongviec').'='.$db->quote($botieuchicon['id_loaicongviec']),
						$db->quotename('name').'='.$db->quote($botieuchicon['name']),
						$db->quotename('code').'='.$db->quote($botieuchicon['code']),
						$db->quotename('is_dexuat').'='.$db->quote($botieuchicon['is_dexuat']),
						$db->quotename('status').'='.$db->quote($botieuchicon['status']),
						$db->quotename('published').'='.$db->quote($botieuchicon['published']),
						$db->quotename('tk_diemchinh').'='.$db->quote($botieuchicon['tk_diemchinh']),
						$db->quotename('tk_diemcong').'='.$db->quote($botieuchicon['tk_diemcong']),
						$db->quotename('tk_diemtru').'='.$db->quote($botieuchicon['tk_diemtru']),
						$db->quotename('group').'='.$db->quote($botieuchicon['group']),
						$db->quotename('lft').'='.$db->quote($botieuchicon['lft']),
						$db->quotename('rgt').'='.$db->quote($botieuchicon['rgt']),
						$db->quotename('daxoa').'=0');
			$query->insert('dgcbcc_botieuchi');
			$query->set($field);
			// if($botieuchicon['name']=='A1.1 Các công việc đã hoàn thành'){
			// 	echo $query;die;
			// }
			$db->setQuery($query);
			$result = $db->query();
			$ds_tieuchi = $this->find_tieuchi_by_botieuchi($botieuchicon['id']);
			$ds_theonhiemvu = $this->find_dgcbcc_fk_theonhiemvu_botieuchi_by_botieuchi($botieuchicon['id']);
			$ds_tieuchuan = $this->find_dgcbcc_fk_tieuchuan_dg_botieuchi($botieuchicon['id']);
			for($i=0;$i<count($ds_tieuchi);$i++){
				$this->add_dgcbcc_fk_botieuchi_tieuchi($id,$ds_tieuchi[$i]['id_tieuchi'],$ds_tieuchi[$i]['diem_min'],$ds_tieuchi[$i]['diem_max'],$ds_tieuchi[$i]['code_xeploai'],$ds_tieuchi[$i]['id_tieuchi_phanloai']);
			}
			for($i=0;$i<count($ds_theonhiemvu);$i++){
				$this->add_dgcbcc_fk_theonhiemvu_botieuchi($id,$ds_theonhiemvu[$i]['id_theonhiemvu'],$ds_theonhiemvu[$i]['diem_min'],$ds_theonhiemvu[$i]['diem_max']);
			}
			for($i=0;$i<count($ds_tieuchuan);$i++){
				$this->add_dgcbcc_fk_tieuchuan_dg_botieuchi($id,$ds_tieuchuan[$i]['id_tieuchuan_dg']);
			}
			return $result;
		}
		public function find_botieuchi_by_parent_id($lft,$rgt){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,parent_id,id_loaicongviec,name,code,is_dexuat,status,published,tk_diemchinh,tk_diemcong,tk_diemtru,a.group,a.lft,a.rgt');
			$query->from('dgcbcc_botieuchi a');
			$query->where('a.lft BETWEEN '.$db->quote($lft).' AND '.$db->quote($rgt));
			$query->where('a.rgt BETWEEN '.$db->quote($lft).' AND '.$db->quote($rgt));
			$query->order('a.lft asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function get_max_id_botieuchi(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('MAX(id)');
			$query->from('dgcbcc_botieuchi');
			$db->setQuery($query);
			return $db->loadResult();
		}
		public function saochep_botieuchi($form){
			$botieuchicon = $this->find_botieuchi_by_id($form['botieuchicon']);
			// var_dump($botieuchicon);die;
			$botieuchicon_child = $this->find_botieuchi_by_parent_id($botieuchicon['lft'],$botieuchicon['rgt']);
			$max_id_dgcbcc_botieuchi = $this->get_max_id_botieuchi();
			$max_id_dgcbcc_botieuchi = $max_id_dgcbcc_botieuchi+1;
			$hs_dgcbcc_botieuchi = $max_id_dgcbcc_botieuchi-$botieuchicon['id'];
			$botieuchicon['lft'] = '99999';
			$result[] = $this->insert_botieuchi_node($botieuchicon,$form['botieuchicha'],$hs_dgcbcc_botieuchi);
			if(count($botieuchicon_child)>0){
				for($i=0;$i<count($botieuchicon_child);$i++){
					if($botieuchicon['id']!=$botieuchicon_child[$i]['id']){
						$node_parent_id = $botieuchicon_child[$i]['parent_id']+$hs_dgcbcc_botieuchi;
						$result[] = $this->insert_botieuchi_node($botieuchicon_child[$i],$node_parent_id,$hs_dgcbcc_botieuchi);
						// $max_id_dgcbcc_botieuchi = $max_id_dgcbcc_botieuchi+1;
					}
				}
			}
			return $result;
		}
		public function find_max_date_dot_dgcbcc_dotdanhgia(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('MAX(date_dot)');
			$query->from('dgcbcc_dotdanhgia');
			$query->where('daxoa!=1');
			$db->setQuery($query);
			return $db->loadResult();
		}
		public function getall_xeploai(){
			$date_dot = $this->find_max_date_dot_dgcbcc_dotdanhgia();
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.code');
			$query->from('dgcbcc_xeploai a');
			$query->join('INNER','dgcbcc_dotdanhgia b ON (b.id=a.id_dotdanhgia)');
			$query->where('b.date_dot='.$db->quote($date_dot));
			$query->group('a.code');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function getall_tieuchi_phanloai(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id,name');
			$query->from('dgcbcc_tieuchi_phanloai');
			$query->order('orders asc');
			$db->setQuery($query);
			return $db->loadAssocList();
		}
		public function find_tieuchuan_by_nhiemvu_id($checkbox_id_theonhiemvu){
			$checkbox_id_theonhiemvu = implode(',',$checkbox_id_theonhiemvu);
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.id_tieuchuan,b.name');
			$query->from('dgcbcc_fk_tieuchuan_nhiemvu_danhgiacho a');
			$query->join('INNER','dgcbcc_tieuchuan_dg b ON b.id=a.id_tieuchuan');
			$query->where('a.id_nhiemvu IN ('.$checkbox_id_theonhiemvu.')');
			// echo $query;die;
			$db->setQuery($query);
			return $db->loadAssocList();
		}
	}
?>