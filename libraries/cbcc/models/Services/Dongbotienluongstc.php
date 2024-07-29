<?php 
defined('_JEXEC') or die('Restricted access');
class Services_Model_Dongbotienluongstc{
###################### SERVER SIDE 	- CBCC #############
// 	"Mã trả về, xác định các trường hợp xảy ra:
//  - 001: sai username, mật khẩu
//  - 002: hệ thống gặp lỗi
//  - 003: lấy dữ liệu thành công
// "
	function capNhatTrangThai(){
		// echo 123123;die;
		$jinput = JFactory::getApplication()->input;
		$doituong = $jinput->getInt('doituong',0);
        $username = $jinput->getString('username','');
        $pass = $jinput->getString('pass','');
        $idDaDongBo = $jinput->getString('idDaDongBo', '');
        // var_dump($doituong);
        // var_dump($username);
        // var_dump($pass);
        // var_dump($idDaDongBo);
        // die;
        $un = Core::config('tienluong/sync/username');
        $ps = Core::config('tienluong/sync/pass');
        // update is_dongbo vào db
        if(!$doituong>0 || ($username != $un && $pass != $ps)){
			$return['returnCode'] = '001';
			$return['noidungloi'] = 'Sai hoặc không đủ thông tin';
			$return['data'] = [];
			return $return;
		}else{
			switch($doituong){
            	case '1':
               	 	$rs = $this->updateTrangThaiDongBoToChuc($idDaDongBo);
                	break;
            	case '2':
               	 	$rs = $this->updateTrangThaiDongBoHoSo($idDaDongBo);
                	break;
                case '7':
               	 	$rs = $this->updateTrangThaiDongBoDanhMucLoaiPhuCap($idDaDongBo);
                	break;
                case '8':
               	 	$rs = $this->updateTrangThaiDongBoBienChe($idDaDongBo);
                	break;
                default: 
                	break;
            }
            return $rs;
		}
	}
	function updateTrangThaiDongBoBienChe($ids){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
            $db->quoteName('is_dongbo') . ' = 1',
        );
        $conditions = array(
				$db->quoteName('id').' IN ('.$ids.')'
		);
		$query->update($db->quoteName('bc_hinhthuc'))->set($fields)->where($conditions);
		$db->setQuery($query);
		return $db->query();
	}
	function updateTrangThaiDongBoDanhMucLoaiPhuCap($ids){
		// $db = JFactory::getDbo();
		// $query = $db->getQuery(true);
		// $fields = array(
  //           $db->quoteName('is_dongbo') . ' = 1',
  //       );
  //       $conditions = array(
		// 		$db->quoteName('id').' IN ('.$ids.')'
		// );
		// $query->update($db->quoteName('danhmuc_loaiphucap'))->set($fields)->where($conditions);
		// // echo $query;die;
		// $db->setQuery($query);
		// return $db->query();
		return true;
	}
	function updateTrangThaiDongBoHoSo($ids){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
            $db->quoteName('is_dongbo') . ' = 1',
        );
        $conditions = array(
				$db->quoteName('hosochinh_id').' IN ('.$ids.')'
		);
		$query->update($db->quoteName('hosochinh_quatrinhhientai'))->set($fields)->where($conditions);
		// echo $query;die;
		$db->setQuery($query);
		return $db->query();
	}
	function updateTrangThaiDongBoToChuc($ids){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
            $db->quoteName('is_dongbo') . ' = 1',
        );
        $conditions = array(
				$db->quoteName('id').' IN ('.$ids.')'
		);
		$query->update($db->quoteName('ins_dept'))->set($fields)->where($conditions);
		$db->setQuery($query);
		return $db->query();
	}
	function dongboTienLuong(){
		$jinput = JFactory::getApplication()->input;
        $type = $jinput->getInt('type',0);
        $doituong = $jinput->getInt('doituong',0);
        $id = $jinput->getString('id','');
        $username = $jinput->getString('username','');
        $pass = $jinput->getString('pass','');
        $donvi_id = $jinput->get('donvi_id',0,'int');
        $un = Core::config('tienluong/sync/username');
        $ps = Core::config('tienluong/sync/pass');
        // var_dump($doituong);
        // var_dump($type);
        // var_dump($id);
        // var_dump($username);
        // var_dump($pass);
        // die;
		if(!$doituong>0 || $username != $un || $pass != $ps){
			$return['returnCode'] = '001';
			$return['noidungloi'] = 'Sai hoặc không đủ thông tin';
			$return['data'] = [];
			return $return;
		}else{
			// $dongbo
			// 1:ins_dept
			// 2:hosochinh, hosochinh_quatrinhhientai
			// 3:quatrinhphucap
			// 4:quatrinhluong
			// 5:quatrinhcongtac
			// 6:quatrinhkiemnhiem
			// 7:danhmuc_loaiphucap
			// 8:bc_hinhthuc, bc_goibienche, bc_goibienche_hinhthuc
			// 9: cb_goichucvu_chucvu

			// $type
			// 1: all
			// 2: is_dongbo=0
			// 3: id = $id
			// 4: donvi_id
			$return['returnCode'] = '003';
			$return['data'] = [];
			switch($doituong){
            	case '1':
               	 	$return['data'] = $this->dongboDonvi($type); // 1,2
                	break;
            	case '2':
               	 	$return['data'] = $this->dongboHoso($type, $id, $donvi_id); // 1,2,3,4
                	break;
            	// case '3':
             //   	 	$return['data'] = $this->dongboQuatrinhPhucap($type, $id); // 1,2,3
             //    	break;
            	// case '4':
             //   	 	$return['data'] = $this->dongboQuatrinhLuong($type, $id); // 1,2,3
             //    	break;
            	// case '5':
             //   	 	$return['data'] = $this->dongboQuatrinhCongtac($type, $id, $donvi_id); // 1,2,3
             //    	break;
            	// case '6':
             //   	 	$return['data'] = $this->dongboQuatrinhKiemnhiem($type, $id); // 1,2,3
             //    	break;
            	case '7':
               	 	$return['data'] = $this->dongboDmloaiphucap($type); //1,2
                	break;
                case '8':
               	 	$return['data'] = $this->dongboBienche($type); // 1,2
                	break;
                case '9':
               	 	$return['data'] = $this->dongboGoiChucVu($type, $id); // 1,2
                	break;
            	default:
                	break;
			}	
            return $return; 
		}
	}
	function dongboDonvi($type){
		if($type ==1) 
			$where =''; 
		else if($type==2) 
			$where ='is_dongbo=0 or is_dongbo is null';
		else{
			$data['ins_dept']=[]; 
			return $data;
		}
		$data['ins_dept'] = Core::loadAssocList('ins_dept','*', $where);
		$data['ins_cap'] = Core::loadAssocList('ins_cap','*');
		return $data;
	}
	function dongboGoiChucVu($type, $id=null){
		if(strlen($id)>0) $where ='goichucvu_id in ('.$id.')';
		$data['cb_goichucvu_chucvu'] = Core::loadAssocList('cb_goichucvu_chucvu','*',$where);
		return $data;
	}
	function dongboHoso($type, $id=null, $donvi_id=null){
		$where =''; 
		$where_ht =''; 
		if($type ==1){ 
			// đồng bộ all
			$where =''; 
			$where_ht =''; 
		}else if($type==2) {
			// đồng bộ có thay đổi
			$where_ht ='is_dongbo=0 or is_dongbo is null';
			$where = 'id IN (select hosochinh_id from hosochinh_quatrinhhientai where '.$where_ht.')';
		}else if($type==3 && $id>0){
			// đồng bộ theo hồ sơ id 
			$where ='id = '.(int)$id;
			$where_ht ='hosochinh_id = '.(int)$id;
		}else if($type==4 && $donvi_id>0){
			// đồng bộ cả đơn vị
			$where_ht = '(';
			$where_ht .= '(congtac_donvi_id = '.(int)$donvi_id.' or congtac_phong_id = '.(int)$donvi_id.')';
			if(strlen($id)>0 && count(explode(',', $id))>0)
				$where_ht .=' OR hosochinh_id IN (0'.$id.')';
			$where_ht .= ')';
			$where = 'id IN (select hosochinh_id from hosochinh_quatrinhhientai where '.$where_ht.')';
		}
		else{
			$data['hosochinh'] = [];
			$data['hosochinh_quatrinhhientai'] = [];
			return $data;
		}
		$data['hosochinh'] = Core::loadAssocList('hosochinh','*',$where);
		$data['hosochinh_quatrinhhientai'] = Core::loadAssocList('hosochinh_quatrinhhientai','*',$where_ht);
		return $data;
	}
	function dongboBienche($type){
		if($type==1) 
			$where =''; 
		else if($type==2) 
			$where ='is_dongbo=0 or is_dongbo is null';
		else{
			$data['bc_hinhthuc']=[]; 
			return $data;
		}
		$data['bc_hinhthuc'] = Core::loadAssocList('bc_hinhthuc','*',$where);
		// $data['bc_goibienche_hinhthuc'] = Core::loadAssocList('bc_goibienche_hinhthuc','*',$where);
		// $data['bc_goibienche'] = Core::loadAssocList('bc_goibienche','*',$where);
		return $data;
	}
	function dongboDmloaiphucap($type){
		$data['danhmuc_loaiphucap'] = Core::loadAssocList('danhmuc_loaiphucap','*');
		return $data;
	}

###################### dùng chung #############
	public function strDateVntoMySql($dateVN){
		if (empty($dateVN)) {
			return '';
		}
		$dateVN = explode('/', $dateVN);
		return $dateVN[2].'-'.$dateVN[1].'-'.$dateVN[0];
	}
}
?>