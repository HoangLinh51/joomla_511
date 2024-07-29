<?php
defined('_JEXEC') or die('Restricted access');
class Services_Model_Haugiang
{
	function wsHoso()
	{
		$jinput = JFactory::getApplication()->input;
		$hosochinh_id = $jinput->get('hosochinh_id', 0, 'int');
		return $this->getHoso((int)$hosochinh_id);
	}
	function getHoso($hosochinh_id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('
		hsc.id as hosochinh_id,
		hsc.e_name as hoten,
		(select name from sex_code where id = hsc.sex limit 1)  as  gioitinh_text,
		hsc.sex as gioitinh_id,
		hsc.birth_date as ngaysinh,
		hsc.id_card as cmnd,
		(select name from nat_code where hsc.nat_code = id limit 1)  as dantoc_text,
		hsc.nat_code as dantoc,
		hsc.per_address as diachi,
		hsc.phone as dienthoai,
		hsc.email as email,
		(select name from city_code where code = hsc.city_peraddress limit 1) as tinhthanh_text,
		hsc.city_peraddress as tinhthanh_id,
		(select name from dist_code where code = hsc.dist_peraddress limit 1) as quanhuyen_text,
		hsc.dist_peraddress as quanhuyen_id,
		(select name from comm_code where code = hsc.comm_peraddress limit 1) as phuongxa_text,
		hsc.comm_peraddress as phuongxa_id,
		hsc.is_only_year as ngaysinh_isyear
		')
		->from('hosochinh hsc')
		->where('hsc.id >'.$db->quote($hosochinh_id))
		->order('hsc.id asc');
		$db->setQuery($query, 0, 1000);
		return $db->loadAssocList();
	}
}
