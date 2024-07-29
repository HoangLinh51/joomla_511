<?php
/**
 * Author: Phucnh
 * Date created: May 12, 2015
 * Company: DNICT
 */
class Tochuc_Model_Bienche{
	function savebienche(){
		try{
		$formData = JRequest::getVar('bienche');
		// B1: save 
		$id = $this->luuGiaoBienChe($formData);
		// B2: lưu fk
		if($id>0)
			for($i=0;$i<count($formData['hinhthuc']); $i++){
				$this->luuGiaoBienCheChiTiet($id, $formData['hinhthuc'][$i], $formData['bienche'][$i]);
			}
		 return true;
		}catch(Exception $e){
			return false;
		}
	}
	function luuGiaoBienChe($formData){
 		$db =  JFactory::getDbo();
		$query = $db->getQuery(true);
			$fields = array(
				$db->quoteName('quyetdinh_so').'='.$db->quote($formData['quyetdinh_so']),
				$db->quoteName('nam').'='.$db->quote($formData['nam']),
				$db->quoteName('quyetdinh_ngay').'='.$db->quote(date('d/m/Y', strtotime($formData['quyetdinh_ngay']))),
				$db->quoteName('hieuluc_ngay').'='.$db->quote($formData['hieuluc_ngay']),
				$db->quoteName('user_id').'='.JFactory::getUser()->id,
				$db->quoteName('dept_id').'='.$db->quote($formData['donvi_id']),
				$db->quoteName('nghiepvu_id').'= 1',
				$db->quoteName('ngay_tao').'= now()',
			);
		if (isset($formData['id']) && $formData['id']>0){
			$conditions = array(
				$db->quoteName('id').'='.$db->quote($formData['id'])
			);
			// array_push($fields, $db->quoteName('ngayhieuchinh') . ' = now()');
			// array_push($fields, $db->quoteName('nguoihieuchinh') . ' = '.JFactory::getUser()->id);
			$query->update($db->quoteName('ins_dept_quatrinh_bienche'))->set($fields)->where($conditions);
			$id = $formData['id'];
			$db->setQuery($query);
			$db->query();
		}else{
			// array_push($fields, $db->quoteName('ngaytao') . ' = now()');
			// array_push($fields, $db->quoteName('nguoitao') . ' = '.JFactory::getUser()->id);
			$query->insert($db->quoteName('ins_dept_quatrinh_bienche'));
			$query->set($fields);
			$db->setQuery($query);
			// echo $query;die;
			$db->query();
			$id = $db->insertId();
		}

		return $id;
    }
    function luuGiaoBienCheChiTiet($quatrinh_id, $hinhthuc_id, $bienche){
 		$db =  JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
			$db->quoteName('quatrinh_id').'='.$db->quote($quatrinh_id),
			$db->quoteName('hinhthuc_id').'='.$db->quote($hinhthuc_id),
			$db->quoteName('bienche').'='.$db->quote($bienche),
		);
		$query->insert($db->quoteName('ins_dept_quatrinh_bienche_chitiet'));
		$query->set($fields);
		$db->setQuery($query);
		// echo $query;
		$db->query();
		$id = $db->insertId();
		return $id;
    }
}