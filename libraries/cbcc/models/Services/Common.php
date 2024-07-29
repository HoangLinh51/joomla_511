<?php
defined('_JEXEC') or die('Restricted access');
class Services_Model_Common
{
	function wsCommon()
	{
		// index.php?option=com_services&controller=common&task=wsCommon&ws=getDanhSachDonViCbcc&format=raw&username=3gb75680&pass=123123&type=2&from=2019-10-01
		$jinput = JFactory::getApplication()->input;
		$ws = $jinput->getString('ws', null);
		$username = $jinput->getString('username', null);
		$pass = $jinput->getString('pass', null);
		$un = Core::config('common/sync/username');
		$ps = Core::config('common/sync/pass');
		$debug = 1;
		// if ($debug == 0) {
			if ($username != $un || $pass != $ps || strlen($username) == 0 || strlen($pass) == 0) {
				$return['returnCode'] = '001';
				$return['noidungloi'] = 'Sai hoặc không đủ thông tin';
				$return['data'] = [];
				return $return;
			// }
		} else {
			$return['returnCode'] = '003';
			$return['data'] = [];
			switch ($ws) {
				case 'getDanhSachDonViCbcc':
					$return['data'] = $this->dongboDonvi();
					break;
				case 'dongboKeHoachCchc':
					$return['data'] = $this->dongboKeHoachCchc();
					break;
				default:
					break;
			}
			return $return;
		}
	}
	function dongboDonvi()
	{
		$jinput = JFactory::getApplication()->input;
		$type = $jinput->getInt('type', 0);
		$from = $jinput->getString('from', null);
		$to = $jinput->getString('to', null);
		$db = Core::db();
		// type: 1 get tất cả tổ chức
		// type: 2 get from(required) to(non-required) ngayhieuchinh(yyyy-mm-dd)
		if ($type == 1)
			$where = '';
		else 
		if ($type == 2 && strlen($from) > 0 && (bool) preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $from)) {
			$where = 'ngayhieuchinh >= ' . $db->quote($from);
			if (strlen($to) > 0 && (bool) preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to)) {
				$where .= ' AND ngayhieuchinh <= ' . $db->quote($to);
			}
		} else {
			$data = [];
			return $data;
		}
		$data = Core::loadAssocList('ins_dept', 'id, name, parent_id, type, ngayhieuchinh, ins_created as coquanchuquan_id', $where);
		return $data;
	}
	/**
	 * Đồng bộ kế hoạch cải cách hành chính
	 * input: 
	 * 	donvi_id: optional - null: tất cả đơn vị, !null: theo id đơn vị
	 * 	type: required - 1:mục I, 2: mục II, 3: tất cả các mục
	 *  nam: required - năm báo cáo
	 */
	function dongboKeHoachCchc()
	{
		// index.php?option=com_services&controller=common&task=wsCommon&ws=dongboKeHoachCchc&format=raw&username=x723v89vf234&pass=3gb75680&type=1&nam=2019&capdonvi=4
		$jinput = JFactory::getApplication()->input;
		$donvi_id = $jinput->getString('donvi_id', null);
		$capdonvi = $jinput->getString('capdonvi', null);
		$db = JFactory::getDbo();
		// 1 sở ngành
		// 2 quận huyện
		// 3 phường xã
		// 4 cơ quan tw
		$cap['sn'] = Core::config('cchc/dongboKeHoachCchc/capSo'); //27
		$cap['qh'] = Core::config('cchc/dongboKeHoachCchc/capQh'); //8
		$cap['px'] = Core::config('cchc/dongboKeHoachCchc/capPx'); //9
		$cap['tw'] = Core::config('cchc/dongboKeHoachCchc/capTw'); //26
		// $cap['sn'] = 27;
		// $cap['qh'] = 8;
		// $cap['px'] = 9;
		// $cap['tw'] = 26;

		$type = $jinput->getString('type', null);
		$nam = $jinput->getString('nam', null);
		if ($type == 1) $parent_tmp = ' AND id = ' . (int) Core::config('cchc/dongboKeHoachCchc/idtype1');
		else if ($type == 2) $parent_tmp = ' AND id = ' . (int) Core::config('cchc/dongboKeHoachCchc/idtype2');
		else if ($type == 3) $parent_tmp = ' AND parent_id !=0';
		if ($type > 0 && $nam > 0 && ($capdonvi > 0 || $donvi_id >0)) {
			if($donvi_id>0){
				$donvi = Core::loadAssocList('cchc_tochuc', '*', 'active=1 AND type IN(1,3) AND id='.$db->quote($donvi_id), 'lft asc');
			}else{
				if ($capdonvi == 1) $capdonvi = $cap['sn'];
				else if ($capdonvi == 2) $capdonvi = $cap['qh'];
				else if ($capdonvi == 3) $capdonvi = $cap['px'];
				else if ($capdonvi == 4) $capdonvi = $cap['tw'];
				else $capdonvi = 0;
				if ($capdonvi > 0) {
					$capdonvi_id = Core::loadAssoc('cchc_tochuc_loai', '*', 'id=' . $capdonvi);
					// $capdonvis = Core::loadAssocList('cchc_tochuc_loai','*','status = 1 AND lft>='.$capdonvi_id['lft'].' AND rgt<='.$capdonvi_id['rgt'],'lft asc');
					$donvi = Core::loadAssocList('cchc_tochuc', '*', 'active=1 AND type IN(1,3) AND ins_cap IN (select id from cchc_tochuc_loai where status = 1 AND lft>=' . $capdonvi_id['lft'] . ' AND rgt<=' . $capdonvi_id['rgt'] . ')', 'lft asc');
				} else return [];
			}
			if (count($donvi) > 0) {
				$kehoach_nhomcongviec = Core::loadAssoc('cchc_kehoach_nhomcongviec', '*', 'trangthai = 1' . $parent_tmp, 'lft asc');
				$kehoach = Core::loadAssocList('cchc_kehoach_nhomcongviec', 'id, ten,parent_id', 'trangthai = 1 AND lft>=' . $kehoach_nhomcongviec['lft'] . ' AND rgt<=' . $kehoach_nhomcongviec['rgt'], 'lft asc');
				$return = [];
				for ($ii = 0; $nn = count($donvi), $ii < $nn; $ii++) {
					$return[$ii]['donvi_id'] = $donvi[$ii]['id'];
					$return[$ii]['donvi_ten'] = $donvi[$ii]['ten'];
					$return[$ii]['nam'] = $nam;
					// $return[$ii]['kehoach_id'] = $nam;
					$return[$ii]['listNhiemVu'] = $kehoach;
					for ($i = 0; $n = count($kehoach), $i < $n; $i++) {
						$child = Core::loadAssocList(
							'cchc_kehoach_congviec',
							'
								id, 
								nhomcongviec_id as loaiNhiemVu_id, 
								ten as tenNhiemVu, 
								ketqua tienDoThucHien, 
								hoatdong  as noiDungChiTiet,
								phoihop as donViPhoiHop,
								chutri as donViThucHien,
								DATE_FORMAT(ngaybatdau, "%d/%m/%Y") as thoiGianTuNgay,
								DATE_FORMAT(ngayketthuc, "%d/%m/%Y") as thoiGianDenNgay,
								kinhphi as kinhPhi, 
								ghichu as ghiChu',
							'nhomcongviec_id = ' . $kehoach[$i]['id'] . ' AND donvi_id =' . $donvi[$ii]['id'] . ' AND year(ngaybatdau)=' . $nam,
							' ngaybatdau asc'
						);
						if (count($child) > 0)
							$return[$ii]['listNhiemVu'][$i]['nhiemVuTuNhap']  = $child;
						else $return[$ii]['listNhiemVu'][$i]['nhiemVuTuNhap']  = [];
					}
				}
			}
		}
		return $return;
	}
}
