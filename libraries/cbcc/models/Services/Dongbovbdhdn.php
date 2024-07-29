<?php 
defined('_JEXEC') or die('Restricted access');
class Services_Model_Dongbovbdhdn{
    function dongBoVbdh(){
		// $username = Core::config('tienluong/sync/username');
		// $pass = Core::config('tienluong/sync/pass');
		$jinput = JFactory::getApplication()->input;

		$username = '73';
		$pass = 'Master@123QLVBDH';
		// $type = $jinput->get('type', null, 'string');
		$fromday = $jinput->get('fromday', null, 'string');
		$today = $jinput->get('today', null, 'string');
		// $donvi_id = $jinput->get('donvi_id', null, 'string');
		$email = $jinput->get('email', null, 'string');
		$type = '003';
		$donvi_id = '73';
		$dotdanhgia = Core::loadAssoc('dgcbcc_dotdanhgia','*', 'is_lock=0','ngaybatdau desc');
		if(strlen($fromday)==0) $fromday = date('d/m/Y', strtotime($dotdanhgia['ngaybatdau']));
		if(strlen($today)==0) $today = date('d/m/Y', strtotime($dotdanhgia['ngaytudanhgia']));
		$url = 'https://egov.danang.gov.vn/widget/ttqlvbdh?p_p_id=thongtinvanbanchitietmanagement_WAR_qlvbdhappportlet&p_p_lifecycle=1&p_p_state=exclusive&p_p_mode=view&p_p_col_id=column-1&p_p_col_count=1&_thongtinvanbanchitietmanagement_WAR_qlvbdhappportlet_javax.portlet.action=getDanhSachVanBanDiEx&userName='.$username.'&password='.$pass.'&type='.$type.'&fromDate='.$fromday.'&toDate='.$today.'&soDi=&id=&soKyHieu=&idDonVi='.$donvi_id.'&nguoiXuLyEmail='.$email;
		// echo $url;die;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
        ));
        $response = curl_exec($curl);
        // var_dump($response);die;
		$data = json_decode($response, true);
		// echo '<pre>';
		// var_dump($data['listVanBan']);die;
		if(count($data['listVanBan'])>0){
			$this->luuCongViecDongBo($data['listVanBan'], $email);
		}
        curl_close($curl);
        return true;
	}
	function listVanBanChuaXuly($id_dotdanhgia){
		$hoso = Core::getHoso();
		$model = Core::model('Danhgia/Danhsach');
		$dotdanhgia = $model->getDotDanhGia($id_dotdanhgia);
		$url = 'https://egov.danang.gov.vn/widget/ttqlvbdh?p_p_id=thongtinvanbanchitietmanagement_WAR_qlvbdhappportlet&p_p_lifecycle=1&p_p_state=exclusive&p_p_mode=view&p_p_col_id=column-1&p_p_col_count=1&_thongtinvanbanchitietmanagement_WAR_qlvbdhappportlet_javax.portlet.action=getDanhSachVanBanDangXuLyByEmail&email='.$hoso->email_tinhthanh.'&userName='.$hoso->egov_id.'&password=Master@123QLVBDH&type=004&isCoHanXuLy=1&hanXuLyTu='.$dotdanhgia['ngaybatdau_nam'].'&hanXuLyDen='.$dotdanhgia['ngaytudanhgia_truocmot'].'&isXuLyChinh=1&isLuuKetThuc=0';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_SSL_VERIFYPEER => false
		));
		$response = curl_exec($curl);
        // var_dump($url);die;
		$data = json_decode($response);
		// var_dump($data->listVanBan);die;
        curl_close($curl);
        return $data->listVanBan;

	}
	function lichCongTac($id_dotdanhgia){
		$hoso = Core::getHoso();
		$model = Core::model('Danhgia/Danhsach');
		$dotdanhgia = $model->getDotDanhGia($id_dotdanhgia);
		$url = 'https://egov.danang.gov.vn/widget/ttqlvbdh?p_p_id=thongtinvanbanchitietmanagement_WAR_qlvbdhappportlet&p_p_lifecycle=1&p_p_state=exclusive&p_p_mode=view&p_p_col_id=column-1&p_p_col_count=1&_thongtinvanbanchitietmanagement_WAR_qlvbdhappportlet_javax.portlet.action=getDanhSachLichCongTacCoQuan&tuNgay='.$dotdanhgia['ngaybatdau'].'&denNgay='.$dotdanhgia['ngaytudanhgia'].'&email='.$hoso->email_tinhthanh;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_SSL_VERIFYPEER => false
		));
		$response = curl_exec($curl);
        // var_dump($url);die;
		$data = json_decode($response);
		// var_dump($data);die;
        curl_close($curl);
        return $data->dsLichCoQuan;	
	}
	function luuCongViecDongBo($arr, $email = null){
		for($i=0; $n=count($arr), $i<$n; $i++){
			$row = $arr[$i];
			$tmp_arr = $row;
			unset($tmp_arr['id']);
			$tmp_arr['id_vanbandi'] = $row['id'];
			$tmp_arr['email'] = $email;
			$this->saveCongViec($tmp_arr);
		}
	}
	function saveCongViec($formData){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
			$db->quoteName('id_vanbandi') . ' = ' . $db->quote($formData['id_vanbandi']),
			$db->quoteName('nguoiTaoVanBanDiId') . ' = ' . $db->quote($formData['nguoiTaoVanBanDiId']),
			$db->quoteName('soTo') . ' = ' . $db->quote($formData['soTo']),
			$db->quoteName('noiDen') . ' = ' . $db->quote($formData['noiDen']),
			$db->quoteName('doKhan') . ' = ' . $db->quote($formData['doKhan']),
			$db->quoteName('doMat') . ' = ' . $db->quote($formData['doMat']),
			$db->quoteName('nguoiSoanId') . ' = ' . $db->quote($formData['nguoiSoanId']),
			$db->quoteName('loaiVanBanId') . ' = ' . $db->quote($formData['loaiVanBanId']),
			$db->quoteName('soDi') . ' = ' . $db->quote($formData['soDi']),
			$db->quoteName('coQuanBanHanh') . ' = ' . $db->quote($formData['coQuanBanHanh']),
			$db->quoteName('daXoa') . ' = ' . $db->quote($formData['daXoa']),
			$db->quoteName('soBan') . ' = ' . $db->quote($formData['soBan']),
			$db->quoteName('soKyHieuSo') . ' = ' . $db->quote($formData['soKyHieuSo']),
			$db->quoteName('nguoiKyVanBanDiId') . ' = ' . $db->quote($formData['nguoiKyVanBanDiId']),
			$db->quoteName('soVanBanId') . ' = ' . $db->quote($formData['soVanBanId']),
			$db->quoteName('trichYeu') . ' = ' . $db->quote($formData['trichYeu']),
			$db->quoteName('ngayBanHanh') . ' = ' . $db->quote($formData['ngayBanHanh']),
			$db->quoteName('soKyHieu') . ' = ' . $db->quote($formData['soKyHieu']),
			$db->quoteName('nguoiTrinhVanBanDiId') . ' = ' . $db->quote($formData['nguoiTrinhVanBanDiId']),
			$db->quoteName('soDiSo') . ' = ' . $db->quote($formData['soDiSo']),
			// $db->quoteName('modified_date') . ' = ' . $db->quote($formData['modified_date']),
			// $db->quoteName('id_vanbanden') . ' = ' . $db->quote($formData['id_vanbanden']),
			$db->quoteName('year') . ' = ' . $db->quote(date('Y', strtotime($formData['ngayBanHanh']))),
		);
        if (Core::loadResult('qlvbdh_vanbandi','id_vanbandi','id_vanbandi='.$db->quote($formData['id_vanbandi']))>0){
			// $conditions = array(
			// 		$db->quoteName('id_vanbandi').'='.$db->quote($formData['id_vanbandi'])
			// );
			// $query->update($db->quoteName('qlvbdh_vanbandi'))->set($fields)->where($conditions);
			return true;
		}
		else{
			$query->insert($db->quoteName('qlvbdh_vanbandi'));
			$query->set($fields);
		}
		$db->setQuery($query);
		return $db->query();
	}
	public function getTongVanbanByEmail($id_u_ddg, $id_dotdanhgia){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('d.id_user,b.ngaybatdau,b.ngaytudanhgia');
		$query->from($db->quoteName('dgcbcc_user_nhiemvu','a'));
		$query->innerJoin('dgcbcc_dotdanhgia_thang AS b ON a.id_dotdanhgia = b.id_dotdanhgia AND a.inst_code = b.inst_code');
		$query->innerJoin('jos_users AS c ON a.user_id = c.id');
		$query->innerJoin('qlvbdh_users AS d ON c.username = d.email');
		$query->where('a.user_id = '.$db->quote($id_u_ddg));
		$query->where('a.id_dotdanhgia = '.$db->quote($id_dotdanhgia));
		// echo $query->__toString();exit;
		$db->setQuery($query);
		$info = $db->loadAssoc();
		if($info['id_user'] != ''){
			$query = $db->getQuery(true);
			$query->select('COUNT(*)');
			$query->from('qlvbdh_vanbandi');
			$query->where('(nguoiSoanId = '.$db->quote($info['id_user']).' OR (nguoiSoanId = 0 AND nguoiTrinhVanBanDiId = '.$db->quote($info['id_user']).'))');
			$query->where('ngayBanHanh >= '.$db->quote($info['ngaybatdau']));
			$query->where('ngayBanHanh <= '.$db->quote($info['ngaytudanhgia']));
			// echo $query->__toString();exit;
			$db->setQuery($query);
			return $db->loadResult();
		}else{
			return 0;
		}
	}
	public function getCongViecCbdhdn($email, $id_u_ddg, $id_dotdanhgia, $option = array()){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('b.*');
		$query->from($db->quoteName('dgcbcc_user_nhiemvu','a'));
		$query->innerJoin('dgcbcc_dotdanhgia_thang AS b ON a.inst_code = b.inst_code AND a.id_dotdanhgia = b.id_dotdanhgia');
		$query->where('a.user_id = '.$db->quote($id_u_ddg));
		$query->where('a.id_dotdanhgia = '.$db->quote($id_dotdanhgia));
		$db->setQuery($query);
		$dotdanhgia = $db->loadAssoc();
		$query = $db->getQuery(true);
		$query->select('a.id,a.id_vanbandi,a.soKyHieu,DATE_FORMAT(a.ngayBanHanh,"%d/%m/%Y") AS ngayBanHanh,a.trichYeu');
		if($option['id_congviec'] != null){
			$query->select('IF(a.id IN('.$option['id_congviec'].'),1,0) AS selected');
		}else{
			$query->select('0 AS selected');
		}
		$query->from('qlvbdh_vanbandi a');
		$query->innerJoin('qlvbdh_users b ON b.id_user = a.nguoiSoanId  OR b.id_user = a.nguoiTrinhVanBanDiId');
		$query->where('b.username = '.$db->quote($email));
		if($dotdanhgia['ngaybatdau'] != null){
			$query->where('a.ngayBanHanh >='.$db->quote($dotdanhgia['ngaybatdau']));
		}
		if($dotdanhgia['ngayketthuc'] != null){
			$query->where('a.ngayBanHanh <='.$db->quote($dotdanhgia['ngaytudanhgia']));
		}
		if($option['id_congviec_loaitru'] != null){
			$query->where('a.id NOT IN ('.$option['id_congviec_loaitru'].')');
		}
		if(isset($option['ids_vbdh']) && $option['ids_vbdh'] != null){
			$idsVBDH = explode(',',$option['ids_vbdh']);
			$query->where('a.id NOT IN ('.implode(',',$db->quote($idsVBDH)).')');
		}
		$query->order('a.ngayBanHanh desc');
		// echo $query->__toString();exit;
		// bổ sung thêm loại trừ các công việc đã chọn
		$db->setQuery($query);
		if($option['key'] != null){
			return $db->loadAssocList($option['key']);
		}else{
			return $db->loadAssocList();
		}
	}
}
?>