<?php
class Dcxddtmt_Model_Dcxddtmt extends JModelLegacy{
    public function getPhanquyen(){
        $user_id = JFactory::getUser()->id;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('quanhuyen_id,phuongxa_id');
        $query->from('phanquyen_user2khuvuc AS a');
        $query->where('a.user_id = '.$db->quote($user_id));
        $db->setQuery($query);
        $result = $db->loadAssoc();
        if($result['phuongxa_id'] == ''){
            echo '<div class="alert alert-error"><strong>Bạn không được phân quyền sử dụng chức năng này. Vui lòng liên hệ quản trị viên!!!</strong></div>';exit;
        }else{
            return $result;
        }
    }
    public function getKhuvucByIdCha($cha_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,tenkhuvuc,cha_id,level');
        $query->from('danhmuc_khuvuc');
        $query->where('daxoa = 0 AND cha_id = '.$db->quote($cha_id));
        $query->order('tenkhuvuc ASC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getNhankhauByThonTo($thonto_id, $nhiemky_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.hoten,c.tinhtrang_id');
        $query->from('vptk_hokhau2nhankhau AS a');
        $query->innerJoin('vptk_hokhau AS b ON a.hokhau_id = b.id AND b.thonto_id = '.$db->quote($thonto_id));
        $query->leftJoin('vptk_bandieuhanh AS c ON a.id = c.nhankhau_id AND b.thonto_id = c.thonto_id AND c.nhiemky_id = '.$db->quote($nhiemky_id));
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDanhsachNhanHoKhau($params = array()){
        $phanquyen = $this->getPhanquyen();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.hokhau_so,DATE_FORMAT(a.hokhau_ngaycap,"%d/%m/%Y") AS hokhau_ngaycap,b.hoten AS hotenchuho,c.tengioitinh,YEAR(b.ngaysinh) AS namsinh,a.diachi,b.dienthoai');
        $query->from('vptk_hokhau AS a');
        $query->innerJoin('vptk_hokhau2nhankhau AS b ON b.quanhenhanthan_id = -1 AND b.daxoa = 0 AND a.id = b.hokhau_id');
        $query->innerJoin('danhmuc_gioitinh AS c ON b.gioitinh_id = c.id AND c.daxoa = 0');
        if($params['daxoa'] == '1'){
            $query->where('a.daxoa = 1');
        }else{
            $query->where('a.daxoa = 0');
        }
        if($params['hokhau_so'] != ''){$query->where('a.hokhau_so = '.$db->quote($params['hokhau_so']));}
        if($params['hoten'] != ''){$query->where('b.hoten = '.$db->quote($params['hoten']));}
        if($params['gioitinh_id'] != ''){$query->where('b.gioitinh_id = '.$db->quote($params['gioitinh_id']));}
        if($params['is_tamtru'] != ''){$query->where('b.is_tamtru = '.$db->quote($params['is_tamtru']));}
        if($params['thonto_id'] != ''){
            $query->where('a.thonto_id = '.$db->quote($params['thonto_id']));
        }else if($params['phuongxa_id'] != ''){
            $query->where('a.phuongxa_id = '.$db->quote($params['phuongxa_id']));
        }
        if($params['phuongxa_id'] == '' && $phanquyen['phuongxa_id'] != '-1'){
            $query->where('a.phuongxa_id = '.$db->quote($phanquyen['phuongxa_id']));
        }
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getNhanKhauByThonToId($thonto_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.hoten,b.tengioitinh,a.cccd_so,a.dienthoai');
        $query->from('vptk_hokhau2nhankhau AS a');
        $query->innerJoin('danhmuc_gioitinh AS b ON a.gioitinh_id = b.id');
        $query->innerJoin('vptk_hokhau AS c ON a.hokhau_id = c.id AND c.thonto_id = '.$db->quote($thonto_id));
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getThanhVienBanDieuHanh($thonto_id, $nhiemky_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.hoten,b.tengioitinh,a.cccd_so,a.dienthoai');
        $query->from('vptk_hokhau2nhankhau AS a');
        $query->innerJoin('danhmuc_gioitinh AS b ON a.gioitinh_id = b.id');
        $query->innerJoin('vptk_hokhau AS c ON a.hokhau_id = c.id AND c.thonto_id = '.$db->quote($thonto_id));
        $db->setQuery($query);
        $result = $db->loadAssocList();
        $query = $db->getQuery(true);
        $query->select('a.id,a.nhankhau_id,a.phuongxa_id,a.thonto_id,a.nhiemky_id,a.chucdanh_id,DATE_FORMAT(a.ngaybatdau,"%d/%m/%Y") AS ngaybatdau,DATE_FORMAT(a.ngayketthuc,"%d/%m/%Y") AS ngayketthuc,a.tinhtrang_id,a.lydoketthuc');
        $query->from('vptk_bandieuhanh AS a');
        $query->where('a.daxoa = 0 AND a.thonto_id = '.$db->quote($thonto_id).' AND a.nhiemky_id = '.$db->quote($nhiemky_id));
        $query->order('a.ngaybatdau DESC');
        $db->setQuery($query);
        $bandieuhanh = $db->loadAssocList();
        for($i = 0, $n = count($result); $i < $n; $i++){
            for($j = 0, $m = count($bandieuhanh); $j < $m; $j++){
                if($result[$i]['id'] == $bandieuhanh[$j]['nhankhau_id']){
                    if($bandieuhanh[$j]['lydoketthuc'] == null){
                        $bandieuhanh[$j]['lydoketthuc'] = '';
                    }
                    $result[$i]['bandieuhanh'][] = $bandieuhanh[$j];
                }
            }
            if(count($result[$i]['bandieuhanh']) == 0){
                $result[$i]['bandieuhanh'][0]['id'] = '';
                $result[$i]['bandieuhanh'][0]['chucdanh_id'] = '';
                $result[$i]['bandieuhanh'][0]['ngaybatdau'] = '';
                $result[$i]['bandieuhanh'][0]['ngayketthuc'] = '';
                $result[$i]['bandieuhanh'][0]['tinhtrang_id'] = '';
                $result[$i]['bandieuhanh'][0]['lydoketthuc'] = '';
            }
        }
        return $result;
    }
    public function getXeOmById($xeom_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.phuongxa_id,a.thonto_id,a.nhankhau_id,a.biensoxe,a.loaixe_id,a.sogiaypheplaixe,a.thehanhnghe_so,DATE_FORMAT(a.thehanhnghe_ngayhethan,"%d/%m/%Y") AS thehanhnghe_ngayhethan,a.tinhtrangthe_id,b.hoten,DATE_FORMAT(b.ngaysinh,"%d/%m/%Y") AS ngaysinh,b.cccd_so,b.dienthoai,c.tengioitinh,d.tendantoc,e.tentongiao,CONCAT(h.diachi," - ",g.tenkhuvuc," - ",f.tenkhuvuc) AS diachi');
        $query->from('dcxddtmt_xeom AS a');
        $query->innerJoin('vptk_hokhau2nhankhau AS b ON a.nhankhau_id = b.id');
        $query->innerJoin('danhmuc_gioitinh AS c ON b.gioitinh_id = c.id');
        $query->innerJoin('danhmuc_dantoc AS d ON b.dantoc_id = d.id');
        $query->innerJoin('danhmuc_tongiao AS e ON b.tongiao_id = e.id');
        $query->innerJoin('vptk_hokhau AS h ON b.hokhau_id = h.id');
        $query->innerJoin('danhmuc_khuvuc AS f ON h.phuongxa_id = f.id');
        $query->innerJoin('danhmuc_khuvuc AS g ON h.thonto_id = g.id');
        $query->where('a.id = '.$db->quote($xeom_id));
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    public function getDanhSachXeOm($params = array()){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.thonto_id,c.tenkhuvuc AS thonto,b.hoten,f.tengioitinh,b.cccd_so,b.dienthoai,a.thehanhnghe_so,a.biensoxe');
        $query->from('dcxddtmt_xeom AS a');
        $query->innerJoin('vptk_hokhau2nhankhau AS b ON a.nhankhau_id = b.id AND b.daxoa = 0');
        $query->innerJoin('danhmuc_khuvuc AS c ON a.thonto_id = c.id');
        $query->innerJoin('danhmuc_loaixe AS d ON a.loaixe_id = d.id');
        $query->innerJoin('danhmuc_tinhtrangthe AS e ON a.tinhtrangthe_id = e.id');
        $query->innerJoin('danhmuc_gioitinh AS f ON b.gioitinh_id = f.id');
        if($params['daxoa'] == '1'){
            $query->where('a.daxoa = 1');
        }else{
            $query->where('a.daxoa = 0');
        }
        if($params['hoten'] != ''){$query->where('b.hoten LIKE '.$db->quote('%'.$params['hoten'].'%'));}
        if($params['cccd_so'] != ''){$query->where('b.cccd_so = '.$db->quote($params['cccd_so']));}
        if($params['thehanhnghe_so'] != ''){$query->where('a.thehanhnghe_so = '.$db->quote($params['thehanhnghe_so']));}
        if($params['biensoxe'] != ''){$query->where('a.biensoxe = '.$db->quote($params['biensoxe']));}
        if($params['thonto_id'] != ''){
            $query->where('a.thonto_id = '.$db->quote($params['thonto_id']));
        }else if($params['phuongxa_id'] != ''){
            $query->where('a.phuongxa_id = '.$db->quote($params['phuongxa_id']));
        }
        $phanquyen = $this->getPhanquyen();
        if($params['phuongxa_id'] == '' && $phanquyen['phuongxa_id'] != '-1'){
            $query->where('a.phuongxa_id = '.$db->quote($phanquyen['phuongxa_id']));
        }
        $query->order('c.tenkhuvuc ASC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function saveNhanhokhau($formData){
        $db = JFactory::getDbo();
        $user_id = JFactory::getUser()->id;
        $data = array(
            'id' => $formData['id'],
            'hokhau_so' => $formData['hokhau_so'],
            'hokhau_ngaycap' => $formData['hokhau_ngaycap'],
            'hokhau_coquancap' => $formData['hokhau_coquancap'],
            'tinhthanh_id' => trim($formData['tinhthanh_id']),
            'quanhuyen_id' => trim($formData['quanhuyen_id']),
            'phuongxa_id' => trim($formData['phuongxa_id']),
            'thonto_id' => $formData['thonto_id'],
            'diachi' => $formData['diachi']
        );
        if ((int) $data['id'] == 0) {
            $data['nguoitao_id'] = $user_id;
            $data['ngaytao'] = 'NOW()';
        }else{
            $data['nguoihieuchinh_id'] = $user_id;
            $data['ngayhieuchinh'] = 'NOW()';
        }
        foreach ($data as $key => $value) {
            if($value == '' || $value == null){
                $data_update[] = $key . " = NULL";
                unset($data[$key]);
            }else{
                $data_insert_key[] = $key;
                if($key == 'hokhau_ngaycap'){
                    $data_insert_val[] = "STR_TO_DATE('" . $value . "','%d/%m/%Y')";
                    $data_update[] = $key . " = " . "STR_TO_DATE('" . $value . "','%d/%m/%Y')";
                }else if($value == 'NOW()'){
                    $data_insert_val[] = $value;
                    $data_update[] = $key . " = " . $value;
                }else{
                    $data_insert_val[] = $db->quote($value);
                    $data_update[] = $key . " = " . $db->quote($value);
                }
            }
        }
        $query = $db->getQuery(true);
        if ((int) $data['id'] == 0) {
            $query->insert($db->quoteName('vptk_hokhau'))->columns($data_insert_key)->values(implode(',', $data_insert_val));
        }else{
            $query->update($db->quoteName('vptk_hokhau'));
            $query->set(implode(',', $data_update));
            $query->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }
        $db->setQuery($query);
        if(!$db->execute()){
            return false;
        }
        if ((int) $data['id'] == 0) { $hokhau_id = $db->insertid(); }else{ $hokhau_id = $data['id']; }
        for($i = 0, $n = count($formData['nhankhau_id']); $i < $n; $i++){
            if($formData['nhankhau_id'][$i] == ''){
                $value_insert[] = $db->quote($hokhau_id).','.$db->quote(trim($formData['hoten'][$i])).',STR_TO_DATE('.$db->quote($formData['ngaysinh'][$i]).',"%d/%m/%Y"),'.$db->quote($formData['gioitinh_id'][$i]).','.$db->quote($formData['cccd_so'][$i]).',STR_TO_DATE('.$db->quote($formData['cccd_ngaycap'][$i]).',"%d/%m/%Y"),'.$db->quote(trim($formData['cccd_coquancap'][$i])).','.$db->quote($formData['quanhenhanthan_id'][$i]).','.(($formData['dienthoai'][$i]!='')?$db->quote($formData['dienthoai'][$i]):'NULL').','.(($formData['dantoc_id'][$i]!='')?$db->quote($formData['dantoc_id'][$i]):'NULL').','.(($formData['tongiao_id'][$i]!='')?$db->quote($formData['tongiao_id'][$i]):'NULL').','.(($formData['trinhdohocvan_id'][$i]!='')?$db->quote($formData['trinhdohocvan_id'][$i]):'NULL').','.(($formData['nghenghiep_id'][$i]!='')?$db->quote($formData['nghenghiep_id'][$i]):'NULL').','.(($formData['thuongtrucu_tinhthanh_id'][$i]!='')?$db->quote($formData['thuongtrucu_tinhthanh_id'][$i]):'NULL').','.(($formData['thuongtrucu_quanhuyen_id'][$i]!='')?$db->quote($formData['thuongtrucu_quanhuyen_id'][$i]):'NULL').','.(($formData['thuongtrucu_phuongxa_id'][$i]!='')?$db->quote($formData['thuongtrucu_phuongxa_id'][$i]):'NULL').','.(($formData['thuongtrucu_thonto_id'][$i]!='')?$db->quote($formData['thuongtrucu_thonto_id'][$i]):'NULL').','.(($formData['thuongtrucu_diachi'][$i]!='')?$db->quote(trim($formData['thuongtrucu_diachi'][$i])):'NULL').','.$db->quote($formData['is_tamtru'][$i]).','.(($formData['lydoxoathuongtru_id'][$i]!='')?$db->quote($formData['lydoxoathuongtru_id'][$i]):'NULL').','.$db->quote($user_id).',NOW(),'.$db->quote($user_id).',NOW()';
            }else{
                $query = $db->getQuery(true);
                $query->update('vptk_hokhau2nhankhau');
                $query->set('hoten = '.$db->quote(trim($formData['hoten'][$i])));
                $query->set('ngaysinh = STR_TO_DATE('.$db->quote($formData['ngaysinh'][$i]).',"%d/%m/%Y")');
                $query->set('gioitinh_id = '.$db->quote($formData['gioitinh_id'][$i]));
                $query->set('cccd_so = '.$db->quote($formData['cccd_so'][$i]));
                $query->set('cccd_ngaycap = STR_TO_DATE('.$db->quote($formData['cccd_ngaycap'][$i]).',"%d/%m/%Y")');
                $query->set('cccd_coquancap = '.$db->quote(trim($formData['cccd_coquancap'][$i])));
                $query->set('quanhenhanthan_id = '.$db->quote($formData['quanhenhanthan_id'][$i]));
                $query->set('dienthoai = '.$db->quote($formData['dienthoai'][$i]));
                $query->set('dantoc_id = '.$db->quote($formData['dantoc_id'][$i]));
                $query->set('tongiao_id = '.$db->quote($formData['tongiao_id'][$i]));
                $query->set('trinhdohocvan_id = '.$db->quote($formData['trinhdohocvan_id'][$i]));
                $query->set('nghenghiep_id = '.$db->quote($formData['nghenghiep_id'][$i]));
                $query->set('thuongtrucu_tinhthanh_id = '.$db->quote($formData['thuongtrucu_tinhthanh_id'][$i]));
                $query->set('thuongtrucu_quanhuyen_id = '.$db->quote($formData['thuongtrucu_quanhuyen_id'][$i]));
                $query->set('thuongtrucu_phuongxa_id = '.$db->quote($formData['thuongtrucu_phuongxa_id'][$i]));
                $query->set('thuongtrucu_thonto_id = '.$db->quote($formData['thuongtrucu_thonto_id'][$i]));
                $query->set('thuongtrucu_diachi = '.$db->quote(trim($formData['thuongtrucu_diachi'][$i])));
                $query->set('is_tamtru = '.$db->quote($formData['is_tamtru'][$i]));
                $query->set('lydoxoathuongtru_id = '.$db->quote($formData['lydoxoathuongtru_id'][$i]));
                $query->set('nguoihieuchinh_id = '.$db->quote($user_id));
                $query->set('ngayhieuchinh = NOW()');
                $query->where('id = '.$db->quote($formData['nhankhau_id'][$i]));
                $db->setQuery($query);
                if(!$db->execute()){
                    return false;
                }
            }
        }
        if(count($value_insert) > 0){
            $query = $db->getQuery(true);
            $query->insert('vptk_hokhau2nhankhau');
            $query->columns('hokhau_id,hoten,ngaysinh,gioitinh_id,cccd_so,cccd_ngaycap,cccd_coquancap,quanhenhanthan_id,dienthoai,dantoc_id,tongiao_id,trinhdohocvan_id,nghenghiep_id,thuongtrucu_tinhthanh_id,thuongtrucu_quanhuyen_id,thuongtrucu_phuongxa_id,thuongtrucu_thonto_id,thuongtrucu_diachi,is_tamtru,lydoxoathuongtru_id,nguoitao_id,ngaytao,nguoihieuchinh_id,ngayhieuchinh');
            $query->values($value_insert);
            $db->setQuery($query);
            if(!$db->execute()){
                return false;
            }
        }
        return true;
    }
    public function saveXeOm($formData){
        $db = JFactory::getDbo();
        $user_id = JFactory::getUser()->id;
        // echo '<pre>';var_dump($formData);echo '</pre>';exit;
        $data = array(
            'id' => $formData['id'],
            'nhankhau_id' => trim($formData['nhankhau_id']),
            'phuongxa_id' => trim($formData['phuongxa_id']),
            'thonto_id' => trim($formData['thonto_id']),
            'biensoxe' => trim($formData['biensoxe']),
            'loaixe_id' => trim($formData['loaixe_id']),
            'sogiaypheplaixe' => trim($formData['sogiaypheplaixe']),
            'thehanhnghe_so' => trim($formData['thehanhnghe_so']),
            'thehanhnghe_ngayhethan' => $formData['thehanhnghe_ngayhethan'],
            'tinhtrangthe_id' => trim($formData['tinhtrangthe_id'])
        );
        if ((int) $data['id'] == 0) {
            $data['nguoitao_id'] = $user_id;
            $data['ngaytao'] = 'NOW()';
        }else{
            $data['nguoihieuchinh_id'] = $user_id;
            $data['ngayhieuchinh'] = 'NOW()';
        }
        foreach ($data as $key => $value) {
            if($value == '' || $value == null){
                $data_update[] = $key . " = NULL";
                unset($data[$key]);
            }else{
                $data_insert_key[] = $key;
                if($key == 'thehanhnghe_ngayhethan'){
                    $data_insert_val[] = "STR_TO_DATE('" . $value . "','%d/%m/%Y')";
                    $data_update[] = $key . " = " . "STR_TO_DATE('" . $value . "','%d/%m/%Y')";
                }else if($value == 'NOW()'){
                    $data_insert_val[] = $value;
                    $data_update[] = $key . " = " . $value;
                }else{
                    $data_insert_val[] = $db->quote($value);
                    $data_update[] = $key . " = " . $db->quote($value);
                }
            }
        }
        $query = $db->getQuery(true);
        if ((int) $data['id'] == 0) {
            $query->insert($db->quoteName('dcxddtmt_xeom'))->columns($data_insert_key)->values(implode(',', $data_insert_val));
        }else{
            $query->update($db->quoteName('dcxddtmt_xeom'));
            $query->set(implode(',', $data_update));
            $query->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }
        // echo $query;exit;
        $db->setQuery($query);
        if(!$db->execute()){
            return false;
        }
        return true;
    }
    public function getHokhauById($hokhau_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.hokhau_so,DATE_FORMAT(a.hokhau_ngaycap,"%d/%m/%Y") AS hokhau_ngaycap,a.hokhau_coquancap,a.tinhthanh_id,a.quanhuyen_id,a.phuongxa_id,a.thonto_id,a.diachi');
        $query->from('vptk_hokhau AS a');
        $query->where('a.id = '.$db->quote($hokhau_id).' AND a.daxoa = 0');
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    public function getNhankhauByHokhauId($hokhau_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.hokhau_id,a.hoten,DATE_FORMAT(a.ngaysinh,"%d/%m/%Y") AS ngaysinh,a.gioitinh_id,a.cccd_so,DATE_FORMAT(a.cccd_ngaycap,"%d/%m/%Y") AS cccd_ngaycap,a.cccd_coquancap,a.quanhenhanthan_id,a.dienthoai,a.dantoc_id,a.tongiao_id,a.trinhdohocvan_id,a.nghenghiep_id,a.thuongtrucu_tinhthanh_id,a.thuongtrucu_quanhuyen_id,a.thuongtrucu_phuongxa_id,a.thuongtrucu_thonto_id,a.thuongtrucu_diachi,a.is_tamtru,a.lydoxoathuongtru_id');
        $query->from('vptk_hokhau2nhankhau AS a');
        $query->where('a.hokhau_id = '.$db->quote($hokhau_id).' AND a.daxoa = 0');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getBanDieuHanhByThonToNhiemKy($thonto_id, $nhiemky_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id,a.phuongxa_id,a.thonto_id,a.nhiemky_id');
        $query->from('vptk_bandieuhanh AS a');
        $query->where('a.thonto_id = '.$db->quote($thonto_id).' AND a.nhiemky_id = '.$db->quote($nhiemky_id).' AND a.daxoa = 0');
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    public function removeNhanhokhau($hokhau_id, $user_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vptk_hokhau');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = '.$db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id ='.$db->quote($hokhau_id));
        $db->setQuery($query);
        return $db->execute();
    }
    public function removeThanhvien($bandieuhanh_id, $user_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vptk_bandieuhanh');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = '.$db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id ='.$db->quote($bandieuhanh_id));
        $db->setQuery($query);
        return $db->execute();
    }
    public function getThongKeNhanHoKhau($params = array()){
        $db = JFactory::getDbo();
        $query_left = $db->getQuery(true);
        $query_left->select('b.phuongxa_id,d.tenkhuvuc AS phuongxa,b.thonto_id,c.tenkhuvuc AS thonto,COUNT(IF(a.gioitinh_id = 1,1,NULL)) AS nam,COUNT(IF(a.gioitinh_id = 2,1,NULL)) AS nu,COUNT(IF(a.is_tamtru = 0,1,NULL)) AS thuongtru,COUNT(IF(a.is_tamtru = 1,1,NULL)) AS tamtru,COUNT(IF(DATE_ADD(a.ngaysinh, INTERVAL 18 YEAR) < CURDATE(),1,NULL)) AS tren18');
        $query_left->from('vptk_hokhau2nhankhau AS a');
        $query_left->innerJoin('vptk_hokhau AS b ON a.hokhau_id = b.id');
        $query_left->innerJoin('danhmuc_khuvuc AS c ON b.thonto_id = c.id');
        $query_left->innerJoin('danhmuc_khuvuc AS d ON b.phuongxa_id = d.id');
        $query_left->group('b.thonto_id');
        if($params['phuongxa_id'] != ''){$query_left->where('b.phuongxa_id = '.$db->quote($params['phuongxa_id']));}
        if($params['thonto_id'] != ''){$query_left->where('b.thonto_id IN ('.implode(',',$params['thonto_id']).')');}
        $query = $db->getQuery(true);
        $query->select('a.id,a.cha_id,a.tenkhuvuc,a.level,SUM(ab.nam) AS nam,SUM(ab.nu) AS nu,SUM(ab.thuongtru) AS thuongtru,SUM(ab.tamtru) AS tamtru,SUM(ab.tren18) AS tren18');
        $query->from('danhmuc_khuvuc AS a');
        $query->leftJoin('('.$query_left.') AS ab ON a.id = ab.thonto_id OR a.id = ab.phuongxa_id');
        if($params['phuongxa_id'] != ''){$query->where('a.id = '.$db->quote($params['phuongxa_id']).' OR a.cha_id = '.$db->quote($params['phuongxa_id']));}
        if($params['thonto_id'] != ''){$query->where('a.id IN ('.implode(',',$params['thonto_id']).')');}
        $query->group('a.id');
        // echo $query;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getThongKeBanDieuHanh($params = array()){
        $db = JFactory::getDbo();
        $query_left = $db->getQuery(true);
        $query_left->select('a.phuongxa_id,d.tenkhuvuc AS phuongxa,a.thonto_id,c.tenkhuvuc AS thonto,COUNT(IF(b.gioitinh_id = 1 AND a.chucdanh_id IN (1,3),1,NULL)) AS totruongnam,COUNT(IF(b.gioitinh_id = 2 AND a.chucdanh_id IN (1,3),1,NULL)) AS totruongnu,COUNT(IF(b.gioitinh_id = 1 AND a.chucdanh_id IN (2,4),1,NULL)) AS tophonam,COUNT(IF(b.gioitinh_id = 2 AND a.chucdanh_id IN (2,4),1,NULL)) AS tophonu');
        $query_left->from('vptk_bandieuhanh AS a');
        $query_left->innerJoin('vptk_hokhau2nhankhau AS b ON a.nhankhau_id = b.id');
        $query_left->innerJoin('danhmuc_khuvuc AS c ON a.thonto_id = c.id');
        $query_left->innerJoin('danhmuc_khuvuc AS d ON a.phuongxa_id = d.id');
        $query_left->group('a.thonto_id');
        if($params['phuongxa_id'] != ''){$query_left->where('a.phuongxa_id = '.$db->quote($params['phuongxa_id']));}
        if($params['thonto_id'] != ''){$query_left->where('a.thonto_id IN ('.implode(',',$params['thonto_id']).')');}
        if($params['nhiemky_id'] != ''){$query_left->where('a.nhiemky_id IN ('.implode(',',$params['nhiemky_id']).')');}
        if($params['chucdanh_id'] != ''){$query_left->where('a.chucdanh_id IN ('.implode(',',$params['chucdanh_id']).')');}
        $query = $db->getQuery(true);
        $query->select('a.id,a.cha_id,a.tenkhuvuc,a.level,SUM(ab.totruongnam) AS totruongnam,SUM(ab.totruongnu) AS totruongnu,SUM(ab.tophonam) AS tophonam,SUM(ab.tophonu) AS tophonu');
        $query->from('danhmuc_khuvuc AS a');
        $query->leftJoin('('.$query_left.') AS ab ON a.id = ab.thonto_id OR a.id = ab.phuongxa_id');
        if($params['phuongxa_id'] != ''){$query->where('a.id = '.$db->quote($params['phuongxa_id']).' OR a.cha_id = '.$db->quote($params['phuongxa_id']));}
        if($params['thonto_id'] != ''){$query->where('a.id IN ('.implode(',',$params['thonto_id']).')');}
        $query->group('a.id');
        // echo $query;
        $db->setQuery($query);
        return $db->loadAssocList();
    }
}