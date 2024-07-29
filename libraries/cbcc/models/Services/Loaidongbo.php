<?php 
defined('_JEXEC') or die('Restricted access');
class Services_Model_Loaidongbo{
	public function save(){
		$formData = JRequest::get('post');
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
		    $db->quoteName('name') . ' = ' . $db->quote($formData['name']),
		    $db->quoteName('orders') . ' = ' . $db->quote($formData['orders']),
		    $db->quoteName('status') . ' = ' . $db->quote($formData['status']),
		);
		if (isset($formData['id']) && $formData['id']>0){
			$conditions = array(
					$db->quoteName('id').'='.$db->quote($formData['id'])
			);
			$query->update($db->quoteName('danhmuc_loaidongbo'))->set($fields)->where($conditions);
		}
		else{
			$query->insert($db->quoteName('danhmuc_loaidongbo'));
			$query->set($fields);
		}
		$db->setQuery($query);
		return $db->query();
	}
	
	public function strDateVntoMySql($dateVN){
		if (empty($dateVN)) {
			return '';
		}
		$dateVN = explode('/', $dateVN);
		return $dateVN[2].'-'.$dateVN[1].'-'.$dateVN[0];
	}
	// public function getDanhsach($array= array()){
	// 	$db = JFactory::getDbo();
	// 	$db->sql("SET character_set_client=utf8");
	// 	$db->sql("SET character_set_connection=utf8");
	// 	$db->sql("SET character_set_results=utf8");
	// 	$columns = array(
	// 			array('db' => 'a.id',								'dt' => 0),
	// 			array('db' => 'a.name',								'dt' => 1),
	// 			// array('db' => 'b.ten', 'alias'=>'maubaocao',		'dt' => 2),
	// 			// array('db' => 'a.thoigianbanhanh', 					'dt' => 3),
	// 			// array('db' => 'c.name',	'alias'=>'nguoibanhanh',	'dt' => 4),
	// 			array('db' => 'a.orders',							'dt' => 3),
	// 			array('db' => 'a.status',							'dt' => 4),
	// 			// array('db' => 'a.trangthai',						'dt' => 7),
	// 			// array('db' => 'a.loaicongviec_id',					'dt' => 8),
	// 	);
	// 	$table = 'danhmuc_loaidongbo AS a';
	// 	$primaryKey = 'a.id';
	// 	// $join = ' INNER JOIN cchc_bc_maubaocao b ON b.id= a.maubaocao_id';
	// 	// $join .= ' INNER JOIN jos_users c ON c.id= a.nguoibanhanh';
	// 	// if(isset($array['loaicongviec_id'])) 
	// 	// 	$where[] = 'a.loaicongviec_id = '.$db->quote($array['loaicongviec_id']);
	// 	// if(isset($array['flt_ngaybatdau'])) 
	// 	// 	$where[] = 'a.batdau >= '.$db->quote($this->strDateVntoMySql($array['flt_ngaybatdau']).' 00:00:01');
	// 	// if(isset($array['flt_ngayketthuc'])) 
	// 	// 	$where[] = 'a.ketthuc <= '.$db->quote($this->strDateVntoMySql($array['flt_ngaybatdau']).' 23:59:59');
	// 	// $where = implode(' AND ', $where);
	// 	$datatables = Core::model('Core/Datatables');
	// 	return $datatables->simple( $_POST, $table, $primaryKey, $columns ,$join, $where);
	// }
	function getThongtin($field, $table, $arrJoin=null, $where=null, $order=null){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($field)
		->from($table);
		if (count($arrJoin)>0)
		foreach ($arrJoin AS $key=>$val){
			$query->join($key, $val);
		}
		for($i=0;$i<count($where);$i++)
		if ($where[$i]!='')
		$query->where($where);
		if($order!=null)$query->order($order);
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	// function luuCauhinhdonvi($donvi_id_chonthem, $dotbaocao_id, $guibaocao_batdau, $guibaocao_ketthuc, $duyetbaocao_batdau, $duyetbaocao_ketthuc, $is_kiemtra_baocaomotcua){
	// 	for($i=0; $i<count($donvi_id_chonthem); $i++){
	// 		$is_kiemtra = 0;
	// 		if(in_array($donvi_id_chonthem[$i], $is_kiemtra_baocaomotcua)){
	// 			$is_kiemtra = 1;
	// 		}
	// 		$this->saveCauhinh($donvi_id_chonthem[$i], $dotbaocao_id, $guibaocao_batdau, $guibaocao_ketthuc, $duyetbaocao_batdau, $duyetbaocao_ketthuc, $is_kiemtra);
	// 	}
	// 	return true;
	// }
	// function saveCauhinh($donvi_id, $dotbaocao_id, $gui_batdau, $gui_ketthuc, $duyet_batdau, $duyet_ketthuc, $is_kiemtra){
	// 	$db = JFactory::getDbo();
	// 	$query = $db->getQuery(true);
	// 	$fields = array(
	// 	    $db->quoteName('donvi_id') . ' = ' . $db->quote($donvi_id),
	// 	    $db->quoteName('dotbaocao_id') . ' = ' . $db->quote($dotbaocao_id),
	// 	    $db->quoteName('is_kiemtra_baocaomotcua') . ' = ' . $db->quote($is_kiemtra),
	// 	    $db->quoteName('guibaocao_batdau') . ' = ' . $db->quote($this->strDateVntoMySql($gui_batdau)),
	// 	    $db->quoteName('guibaocao_ketthuc') . ' = ' . $db->quote($this->strDateVntoMySql($gui_ketthuc)),
	// 	    $db->quoteName('duyetbaocao_batdau') . ' = ' . $db->quote($this->strDateVntoMySql($duyet_batdau)),
	// 	    $db->quoteName('duyetbaocao_ketthuc') . ' = ' . $db->quote($this->strDateVntoMySql($duyet_ketthuc)),
	// 	);
	// 	if (isset($formData['id']) && $formData['id']>0){
	// 		$conditions = array(
	// 				$db->quoteName('id').'='.$db->quote($formData['id'])
	// 		);
	// 		$query->update($db->quoteName('cchc_bc_cauhinhdonvi'))->set($fields)->where($conditions);
	// 	}
	// 	else{
	// 		$query->insert($db->quoteName('cchc_bc_cauhinhdonvi'));
	// 		$query->set($fields);
	// 	}
	// 	$db->setQuery($query);
	// 	$db->query();
	// }
}
?>