<?php 
defined('_JEXEC') or die('Restricted access');
class Services_Model_Dongbomotcua{
	function danhSachHoSo($id_dotdanhgia){
        // $this->getToken();
        $db = JFactory::getDbo();
		$hoso = Core::getHoso();
		$model = Core::model('Danhgia/Danhsach');
        $dotdanhgia = $model->getDotDanhGia($id_dotdanhgia);
        $token = Core::config('core/egov/token');
        if(JRequest::getVar('tinhtrang') == "5"){
            $ngayketthuc = '';
        }else{
            $ngayketthuc = '&tuNgayXuLyXongDonVi='.$dotdanhgia['ngaybatdau'].'&denNgayXuLyXongDonVi='.$dotdanhgia['ngaytudanhgia'];
        }
        // $hoso->email_tinhthanh = 'trangtth1@danang.gov.vn';
        // echo $hoso->email_tinhthanh;exit;
        // $hoso->egov_id = '73';
        $url = 'https://apiegov.danang.gov.vn/v1/motcua/hoso?coQuanTiepNhanId='.$hoso->egov_id.$ngayketthuc.'&size=300&emailCanBoXuLyChinh='.$hoso->email_tinhthanh.'&tinhTrangHoSo='.JRequest::getVar('tinhtrang').'&orderColumn=maLinhVuc,maTTHC&orderType=DESC,DESC';
        $headers = array();
        $headers[] = "X-Token: $token";
        $headers[] = 'Content-Type: application/json';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => $headers
        ));
		$response = curl_exec($curl);
        // echo $url;exit;
		$data = json_decode($response);
		// var_dump($data->content);die;
        curl_close($curl);
        return $data->content;
    }
    function getToken(){
        $url = 'https://apiegov.danang.gov.vn/v1/auth/uaa/token';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false
        ));
        $username = "test_client";
        $password = "TestClient2@19";
        curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);

		$response = curl_exec($curl);
		// var_dump($response);die;
        curl_close($curl);
        $db = JFactory::getDbo();
        $query = "update core_config_value set value = '$response' where path = 'core/egov/token' ";
        $db->setQuery($query);
        $db->query();
        return $response;        
    }
}
?>