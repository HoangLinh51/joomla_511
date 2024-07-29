<?php 
class Tochuc_Model_Liennganh{
	function luuliennganh(){
		$formData = JRequest::getVar('liennganh');
		$liennganh_id = $this->luutochucliennganh($formData);
		$n = count($formData['hosochinh_id']);
		for($i=0; $i<$n; $i++){
			$donvi_id = Core::loadResult('hosochinh_quatrinhhientai','congtac_donvi_id','hosochinh_id ='.$formData['hosochinh_id'][$i]);
			$this->luuFkLienNganh($liennganh_id, $donvi_id, $formData['hosochinh_id'][$i]);
		}
		return $liennganh_id;
	}
	function luutochucliennganh($formData){
 		$db =  JFactory::getDbo();
		$query = $db->getQuery(true);
			$fields = array(
				$db->quoteName('ten').'='.$db->quote($formData['ten']),
				$db->quoteName('soquyetdinh').'='.$db->quote($formData['soquyetdinh']),
				$db->quoteName('ngayquyetdinh').'='.$db->quote($formData['ngayquyetdinh']),
				$db->quoteName('coquanquyetdinh').'='.$db->quote($formData['coquanquyetdinh'])
			);
		if (isset($formData['id']) && $formData['id']>0){
			$conditions = array(
				$db->quoteName('id').'='.$db->quote($formData['id'])
			);
			array_push($fields, $db->quoteName('ngayhieuchinh') . ' = now()');
			array_push($fields, $db->quoteName('nguoihieuchinh') . ' = '.JFactory::getUser()->id);
			$query->update($db->quoteName('tochucliennganh'))->set($fields)->where($conditions);
			$id = $formData['id'];
			$db->setQuery($query);
			$db->query();
		}else{
			array_push($fields, $db->quoteName('ngaytao') . ' = now()');
			array_push($fields, $db->quoteName('nguoitao') . ' = '.JFactory::getUser()->id);
			$query->insert($db->quoteName('tochucliennganh'));
			$query->set($fields);
			$db->setQuery($query);
			$db->query();
			$id = $db->insertId();
		}
		return $id;
    }
    function luuFkLienNganh($liennganh_id, $donvi_id, $hosochinh_id){
 		$db =  JFactory::getDbo();
		$query = $db->getQuery(true);
			$fields = array(
				$db->quoteName('tochucliennganh_id').'='.$db->quote($liennganh_id),
				$db->quoteName('donvi_id').'='.$db->quote($donvi_id),
				$db->quoteName('hosochinh_id').'='.$db->quote($hosochinh_id),
			);
		if (isset($formData['id']) && $formData['id']>0){
			$conditions = array(
				$db->quoteName('id').'='.$db->quote($formData['id'])
			);
			$query->update($db->quoteName('tochucliennganh_fk_hosochinh'))->set($fields)->where($conditions);
			$id = $formData['id'];
			$db->setQuery($query);
			$db->query();
		}else{
			$query->insert($db->quoteName('tochucliennganh_fk_hosochinh'));
			$query->set($fields);
			$db->setQuery($query);
			$db->query();
			$id = $db->insertId();
		}
		return $id;
    }
}