<?php

use GCore\Libs\Arr;
class Vhytgd_Model_Vhytgd extends JModelLegacy {
    
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
    public function getGioitinh(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,tengioitinh,trangthai');
        $query->from('danhmuc_gioitinh');
        $query->where('trangthai = 1');
        $query->order('sapxep ASC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDoituong(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,tendoituong,trangthai');
        $query->from('danhmuc_doituong');
        $query->where('trangthai = 1 AND phanloai = 2 ');
        $query->order('sapxep ASC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getChinhSachByID($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,tenchinhsach,trangthai');
        $query->from('danhmuc_chinhsach');
        $query->where('trangthai = 1 AND phanloai = 2 ');
        if($id != null){
            $query->where('id = '.$id);
        }
        $query->order('sapxep ASC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDanhSachNguoiCoCong($params = array()){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*, a.id as ncc_id');
        $query->from('vhxhytgd_nguoicocong AS a');
        $query->leftJoin('vhxhytgd_nguoicocong2doituong AS b ON a.id = b.nguoicocong_id AND b.daxoa = 0');
        $query->innerJoin('vptk_hokhau2nhankhau AS c ON a.nhankhau_id = c.id AND c.is_tamtru = 0');
        $query->leftJoin('danhmuc_doituong AS d ON b.doituongncc_id = d.id');
        $query->innerJoin('danhmuc_gioitinh AS e ON c.gioitinh_id = e.id');
        $query->innerJoin('vptk_hokhau AS f ON c.hokhau_id = f.id AND a.phuongxa_id = f.phuongxa_id  AND a.tinhthanh_id = f.tinhthanh_id AND a.quanhuyen_id = f.quanhuyen_id');
        $query->innerJoin('danhmuc_khuvuc AS g ON f.thonto_id = g.id AND g.sudung = 1 and g.daxoa = 0');
        if($params['thonto_id'] != ''){
            $query->where('f.thonto_id = '.$db->quote($params['thonto_id']));
        }elseif($params['phuongxa_id'] != ''){
            $query->where('a.phuongxa_id = '.$db->quote($params['phuongxa_id']));
        }
        $phanquyen = $this->getPhanquyen();
        if($params['phuongxa_id'] == '' && $phanquyen['phuongxa_id'] != '-1'){
            $query->where('a.phuongxa_id '. ' IN (' . str_replace("'", '',$db->quote($phanquyen['phuongxa_id'])) . ')' );
        }           
        if($params['hoten'] != ''){$query->where('c.hoten LIKE '.$db->quote('%'.$params['hoten'].'%'));}
        if($params['cmnd'] != ''){$query->where('c.cccd_so = '.$db->quote($params['cmnd']));}
        if($params['gioitinh_id'] != ''){$query->where('c.gioitinh_id = '.$db->quote($params['gioitinh_id']));}
        if($params['doituong_id'] != ''){$query->where('b.doituongncc_id = '.$db->quote($params['doituong_id']));}
        $db->setQuery($query);
        return $db->loadAssocList();
    }

    public function getDanhSachCongDan($keyWord){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
            $query->select('a.*, a.id as nk_id, nt.tenquanhenhanthan, c.tinhthanh_id,c.quanhuyen_id, c.diachi, b.tengioitinh, b.id as gioitinh_id, g.tendantoc, g.id as dantoc_id, h.tentongiao, h.id as tongiao_id, l.id as phuongxa_id, l.tenkhuvuc as phuongxa, s.id as thonto_id, s.tenkhuvuc as thonto');
            $query->from('vptk_hokhau2nhankhau as a');
            $query->innerJoin('danhmuc_gioitinh as b ON a.gioitinh_id = b.id' );
            $query->innerJoin('vptk_hokhau as c ON a.hokhau_id = c.id');
            $query->innerJoin('danhmuc_khuvuc as s ON s.id = c.thonto_id');
            $query->innerJoin('danhmuc_khuvuc as f ON f.id = c.tinhthanh_id');
            $query->innerJoin('danhmuc_khuvuc as d ON d.id = c.quanhuyen_id');
            $query->innerJoin('danhmuc_khuvuc as l ON l.id = c.phuongxa_id');
            $query->innerJoin('danhmuc_dantoc as g ON g.id = a.dantoc_id');
            $query->innerJoin('danhmuc_tongiao as h ON h.id = a.tongiao_id');
            $query->leftJoin('danhmuc_quanhenhanthan as nt ON nt.id = a.quanhenhanthan_id');
            $query->where('a.is_tamtru = 0 and a.daxoa = 0 ');
        if($keyWord != ''){
            $query->where('a.hoten LIKE '.$db->quote('%'.$keyWord .'%'));
            $query->orwhere('a.cccd_so = '.$db->quote($keyWord));
        }
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;
    }

    public function getDanhSachCongDanByID($nhankhau_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*, a.id as nk_id, a.id as nhankhau_id, c.tinhthanh_id,c.quanhuyen_id, c.diachi, b.tengioitinh, b.id as gioitinh_id, g.tendantoc, g.id as dantoc_id, h.tentongiao, h.id as tongiao_id, l.id as phuongxa_id, l.tenkhuvuc as phuongxa, s.id as thonto_id, s.tenkhuvuc as thonto');
        $query->from('vptk_hokhau2nhankhau as a');
        $query->leftJoin('danhmuc_gioitinh as b ON a.gioitinh_id = b.id' );
        $query->leftJoin('vptk_hokhau as c ON a.hokhau_id = c.id');
        $query->leftJoin('danhmuc_khuvuc as s ON s.id = c.thonto_id');
        $query->leftJoin('danhmuc_khuvuc as f ON f.id = c.tinhthanh_id');
        $query->leftJoin('danhmuc_khuvuc as d ON d.id = c.quanhuyen_id');
        $query->leftJoin('danhmuc_khuvuc as l ON l.id = c.phuongxa_id');
        $query->leftJoin('danhmuc_dantoc as g ON g.id = a.dantoc_id');
        $query->leftJoin('danhmuc_tongiao as h ON h.id = a.tongiao_id');
        $query->where('a.is_tamtru = 0 and a.daxoa = 0 and a.id = '.$db->quote($nhankhau_id));    
        $db->setQuery($query);    
        return $db->loadAssocList();
    }

    public function validCongDanByNhanKhauID($nhankhau_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('nhankhau_id');
        $query->from('vhxhytgd_nguoicocong as a');
        $query->where('a.nhankhau_id = '.$db->quote($nhankhau_id));    
        $db->setQuery($query);    
        return $db->loadAssocList();
    }

    public function saveNguoiCoCong($formData){
        $db = JFactory::getDbo();
        $user_id = JFactory::getUser()->id;

        $data = array(
            'id' => $formData['id_nguoicocong'],
            'nhankhau_id' => $formData['keyWord'],
            'tinhthanh_id' => trim($formData['tinhthanh_id']),
            'quanhuyen_id' => trim($formData['quanhuyen_id']),
            'phuongxa_id' => trim($formData['phuongxa_id']),
            'daxoa' => '0',
        );
        if ((int) $data['id'] == 0) {
            $data['nguoitao_id'] = $user_id;
            $data['ngaytao'] = 'NOW()';
        }else{
            $data['nguoixoa_id'] = $user_id;
            $data['nguoihieuchinh_id'] = $user_id;
            $data['ngayhieuchinh'] = 'NOW()';
        }
        foreach ($data as $key => $value) {               
            if($value == '' || $value == null){
                $data_update[] = $key . " = NULL";                   
                unset($data[$key]);
            }else{
                $data_insert_key[] = $key;
            if($value == 'NOW()'){
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
            $query->insert($db->quoteName('vhxhytgd_nguoicocong'))->columns($data_insert_key)->values(implode(',', $data_insert_val));
        }else{
            $query->update($db->quoteName('vhxhytgd_nguoicocong'));
            $query->set(implode(',', $data_update));
            $query->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }
        $db->setQuery($query);
        $db->execute();
        if ((int) $data['id'] == 0) { $nguoicong_id = $db->insertid(); }else{ $nguoicong_id = $data['id']; } 
        for($dt = 0, $n = count($formData['doituong']); $dt < $n; $dt++){    
            $dbs = JFactory::getDbo();
            $querys = $dbs->getQuery(true);       
            $data_chuyennganh[$dt] = array(
                'id' => $formData['ncc2doituong_id'][$dt],
                'nguoicocong_id' => $nguoicong_id,
                'doituongncc_id' => $formData['doituong_id'][$dt],
                'tyle' => $formData['tyle'][$dt],
                'muctrocap' => $formData['muctrocap'][$dt], 
                'daxoa' => "0",     
            );
            if ((int) $data_chuyennganh[$dt]['id'] == 0) {
                $data_chuyennganh[$dt]['nguoitao_id'] = $user_id;
                $data_chuyennganh[$dt]['ngaytao'] = 'NOW()';
            }else{
                $data_chuyennganh[$dt]['nguoixoa_id'] = $user_id;
                $data_chuyennganh[$dt]['nguoihieuchinh_id'] = $user_id;
                $data_chuyennganh[$dt]['ngayhieuchinh'] = 'NOW()';
            }
            
            foreach ($data_chuyennganh[$dt] as $key => $value) {                     
                if($value == '' || $value == null){               
                    $data_chuyennganh_update[$dt][] = $key . " = NULL";                   
                    unset($data_chuyennganh[$dt][$key]);
                }else{
                    $data_chuyennganh_insert_key[$dt][] = $key;                           
                    if($value == 'NOW()'){
                        $data_chuyennganh_insert_val[$dt][] = $value;                     
                        $data_chuyennganh_update[$dt][] = $key . " = " . $value;
                    }else{
                        $data_chuyennganh_insert_val[$dt][] = $dbs->quote($value);
                        $data_chuyennganh_update[$dt][] = $key . " = " . $dbs->quote($value);
                    }
                }          
            }
            
            if ((int) $data_chuyennganh[$dt]['id'] == 0 ) {           
                $querys->insert($dbs->quoteName('vhxhytgd_nguoicocong2doituong'))->columns($data_chuyennganh_insert_key[$dt])->values(implode(',',$data_chuyennganh_insert_val[$dt]));                  
            } else {
                $querys->update($dbs->quoteName('vhxhytgd_nguoicocong2doituong'));
                $querys->set(implode(',', $data_chuyennganh_update[$dt]));
                $querys->where(array($dbs->quoteName('id') . '=' . $dbs->quote($data_chuyennganh[$dt]['id'])));                            
            }
            $dbs->setQuery($querys);
            $dbs->execute();
            if ((int)$data_chuyennganh[$dt]['id_chinhsach2ncc'] == 0) { $doituong_id[] = $dbs->insertid(); }else{ $doituong_id[] = $data_chuyennganh[$dt]['id']; } 
        }
        //Final Đối tượng//
        for ($cs=0; $cs < count($formData['nam_hidden']); $cs++) { 
            $doituongncc_id = explode(",",$formData['nam_hidden'][$cs])[0];
            $level = $formData['level'][$cs];
            $dbsss = JFactory::getDbo();
            $querysss = $dbsss->getQuery(true);  
            $querysss->select('id');
            $querysss->from('vhxhytgd_nguoicocong2doituong')  ;
            $querysss->where('nguoicocong_id = '.$nguoicong_id. ' AND doituongncc_id = '.$doituongncc_id );
            $dbsss->setQuery($querysss);     
            $results = $dbsss->loadResult(); 
            if ((int)$formData['idchinhsach'][$cs] == 0) {
                $valuechinhsach_insert[] = $dbsss->quote($results).','.$dbsss->quote($formData['nam_chinhsach'][$cs]).','.$dbsss->quote($formData['chinhsach_id'][$cs]).','.$dbsss->quote($formData['noidung'][$cs]).','.$dbsss->quote($formData['kinhphi'][$cs]).','.$dbsss->quote($formData['ghichu'][$cs]).',0,'.$dbsss->quote($user_id).',NOW(),'.$dbsss->quote($level);
            }else{
                $querysss = $dbsss->getQuery(true);
                $querysss->update('vhxhytgd_nguoicocong2chinhsach');
                $querysss->set('nam = '.$dbsss->quote($formData['nam_chinhsach'][$cs]));
                $querysss->set('chinhsachncc_id = '.$dbsss->quote($formData['chinhsach_id'][$cs]));
                $querysss->set('noidung = '.$dbsss->quote($formData['noidung'][$cs]));
                $querysss->set('kinhphi = '.$dbsss->quote($formData['kinhphi'][$cs]));
                $querysss->set('ghichu =  '.$dbsss->quote($formData['ghichu'][$cs]));
                $querysss->set('nguoihieuchinh_id = '.$dbsss->quote($user_id));
                $querysss->set('ngayhieuchinh = NOW()');
                $querysss->where('id = '.$dbsss->quote($formData['idchinhsach'][$cs]));
                $dbsss->setQuery($querysss);
                if(!$dbsss->execute()){
                    return false;
                }
            }
              
        }
        if(count($valuechinhsach_insert) > 0){
            $querysss = $dbsss->getQuery(true);
            $querysss->insert('vhxhytgd_nguoicocong2chinhsach');
            $querysss->columns('ncc2doituong_id,nam,chinhsachncc_id,noidung,kinhphi,ghichu,daxoa,nguoitao_id,ngaytao,level');
            $querysss->values($valuechinhsach_insert);
            $dbsss->setQuery($querysss);
            if(!$dbsss->execute()){
                return false;
            }
        }
        return true;
    }

    public function getDoiTuongNCCByID($doituong_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('danhmuc_doituong as a');
        $query->where('a.trangthai = 1 AND a.daxoa =0 AND a.id = '.$db->quote($doituong_id));    
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;
    }

    public function getNCCByID($nhankhau_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('vhxhytgd_nguoicocong as a');
        $query->where('a.daxoa =0 AND a.nhankhau_id = '.$db->quote($nhankhau_id));    
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;
    }

    public function getChuyenNganhNCCByID($nguoicocong_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*, b.id as doituong_id, b.tendoituong as tendoituong');
        $query->from('vhxhytgd_nguoicocong2doituong as a');
        $query->innerJoin('danhmuc_doituong as b ON a.doituongncc_id = b.id' );
        $query->where('a.daxoa =0 AND a.nguoicocong_id = '.$db->quote($nguoicocong_id));
        $query->order('a.id')  ;  
        $db->setQuery($query);
        $rows = $db->loadAssocList();
        return $rows;
    }
    public function getChuyenNganhChinhSachNCCByDoiTuongNCCID($ncc2doituong_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*, b.id as chinhsach_id, b.tenchinhsach as tenchinhsach');
        $query->from('vhxhytgd_nguoicocong2chinhsach as a');
        $query->innerJoin('danhmuc_chinhsach as b ON a.chinhsachncc_id = b.id' );
        $query->where('a.daxoa = 0 AND a.ncc2doituong_id = '.$db->quote($ncc2doituong_id));
        $query->order('a.id ASC' )  ;  
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;
    }


    public function getDoiTuong2NCCByID($nguoicocong_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*');
        $query->from('vhxhytgd_nguoicocong2doituong as a');
        $query->where('a.daxoa =0 AND a.nguoicocong_id = '.$db->quote($nguoicocong_id));
        $query->order('a.id')  ;  
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;
    }
    public function getDanhMucDoiTuongByID($doituong_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('danhmuc_doituong as a');
        $query->where('a.daxoa =0 AND id IN ('.$db->quote($doituong_id).')');    
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;
    }
    public function removeChinhSachNCC($chinhsach_id, $user_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vhxhytgd_nguoicocong2chinhsach');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = '.$db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id ='.$db->quote($chinhsach_id));
        $db->setQuery($query);
        return $db->execute();
    }
    public function removeDoiTuongNCC($doituong_id, $user_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vhxhytgd_nguoicocong2doituong as a, vhxhytgd_nguoicocong2chinhsach as b');
        $query->set('a.daxoa = 1, b.daxoa=1');
        $query->set('a.nguoixoa_id = '.$db->quote($user_id));
        $query->set('b.nguoixoa_id = '.$db->quote($user_id));
        $query->set('a.ngayxoa = NOW()');
        $query->set('b.ngayxoa = NOW()');
        $query->where('a.id = b.ncc2doituong_id');
        $query->where('a.id ='.$db->quote($doituong_id));
        $db->setQuery($query);
        return $db->execute();
    }

    public function removeDoituongIds($formData, $user_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $idsRemove = implode(',', $formData['doituongncc_id']);
        $query->update('vhxhytgd_nguoicocong2doituong as a, vhxhytgd_nguoicocong2chinhsach as b');
        $query->set('a.daxoa = 1, b.daxoa=1');
        $query->set('a.nguoixoa_id = '.$db->quote($user_id));
        $query->set('b.nguoixoa_id = '.$db->quote($user_id));
        $query->set('a.ngayxoa = NOW()');
        $query->set('b.ngayxoa = NOW()');
        $query->where('a.id = b.ncc2doituong_id');
        $query->where('a.id in ('.$idsRemove.')');
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }
    public function removeNguoiCoCong($nguoicocong_id, $user_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vhxhytgd_nguoicocong as c, vhxhytgd_nguoicocong2doituong as a, vhxhytgd_nguoicocong2chinhsach as b');
        $query->set('a.daxoa = 1, b.daxoa=1');
        $query->set('c.daxoa = 1');
        $query->set('a.nguoixoa_id = '.$db->quote($user_id));
        $query->set('b.nguoixoa_id = '.$db->quote($user_id));
        $query->set('c.nguoixoa_id = '.$db->quote($user_id));
        $query->set('a.ngayxoa = NOW()');
        $query->set('b.ngayxoa = NOW()');
        $query->set('c.ngayxoa = NOW()');
        $query->where('c.id = a.nguoicocong_id');
        $query->where('a.id = b.ncc2doituong_id');
        $query->where('c.id ='.$db->quote($nguoicocong_id));
        $db->setQuery($query);
        return $db->execute();
    }

    public function getThongtinChuyenNganh($nguoicocong_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id, b.id as id_doituong, b.doituongncc_id,c.id as idchinhsach, c.ncc2doituong_id, b.tyle,b.muctrocap,d.tendoituong,c.id as id_chinhsach2ncc,c.noidung,c.kinhphi,c.ghichu, c.level, c.chinhsachncc_id,c.nam,e.tenchinhsach');
        $query->from('vhxhytgd_nguoicocong as a');
        $query->leftJoin('vhxhytgd_nguoicocong2doituong as b ON a.id = b.nguoicocong_id');
        $query->leftJoin('vhxhytgd_nguoicocong2chinhsach as c ON b.id = c.ncc2doituong_id');
        $query->leftJoin('danhmuc_doituong as d ON d.id = b.doituongncc_id');
        $query->leftJoin('danhmuc_chinhsach as e ON e.id = c.chinhsachncc_id');
        $query->where('c.daxoa = 0 AND b.daxoa = 0 AND a.daxoa =0 AND a.nhankhau_id = '.$db->quote($nguoicocong_id));  
        $query->order('a.id ASC, b.doituongncc_id DESC, c.id ASC ');  
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;
    }
    public function getThongtinChuyenNganhDoiTuongByID($nguoicocong_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('vhxhytgd_nguoicocong as a');
        $query->leftJoin('vhxhytgd_nguoicocong2doituong as b ON a.id = b.nguoicocong_id');
        $query->leftJoin('danhmuc_doituong as d ON d.id = b.doituongncc_id');
        $query->where('a.nhankhau_id = '.$db->quote($nguoicocong_id));  
        $query->order('b.doituongncc_id ASC');  
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;
    }

    public function getThongtinChuyenNganhChinhSachByID($doituongncc_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('vhxhytgd_nguoicocong2chinhsach as a');
        $query->leftJoin('vhxhytgd_nguoicocong2doituong as b ON b.id = a.ncc2doituong_id');
        $query->leftJoin('danhmuc_chinhsach as d ON d.id = a.chinhsachncc_id');
        $query->where('a.ncc2doituong_id = '.$db->quote($doituongncc_id));  
        $query->order('a.ncc2doituong_id ASC');  
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;
    }
    

    public function getIDDoiTuongByNCCID($doituong_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id');
        $query->from('vhxhytgd_nguoicocong2doituong as a');
        $query->where('a.doituongncc_id = '.$db->quote($doituong_id));    
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;  
    }
    public function saveDoiTuong2NCC($formData){     
        $db = JFactory::getDbo();
        $nguoicocong_id =  JRequest::getVar('nguoicocong_id');
        $doituong_id =  JRequest::getVar('doituong_id');
        $user_id = JFactory::getUser()->id;
        $data_value[] = $nguoicocong_id.','.$doituong_id.','.$user_id;
        $query = $db->getQuery(true);
        if ((int) $formData['id'] == 0) {
            $query->insert('vhxhytgd_nguoicocong2doituong');
            $query->columns('nguoicocong_id, doituongncc_id, nguoitao_id');
            $query->values($data_value);
            $db->setQuery($query);
            $db->execute();
            $id_nguoicocong = $db->insertid();
            $dbs = JFactory::getDbo();
            $querys = $dbs->getQuery(true);
            $datachinhsach_value[] = $id_nguoicocong;
            $querys->insert('vhxhytgd_nguoicocong2chinhsach');
            $querys->columns('ncc2doituong_id');
            $querys->values($datachinhsach_value);
            $dbs->setQuery($querys);
            $dbs->execute();
        }
        
    }
    public function saveChinhSach2NCC($formData){     
        $db = JFactory::getDbo();
        $ncc2doituong_id =  JRequest::getInt('nam_hidden');
        $user_id = JFactory::getUser()->id;
        $data_value[] = $ncc2doituong_id.','.$user_id;
        $query = $db->getQuery(true);
        $query->insert('vhxhytgd_nguoicocong2chinhsach');
        $query->columns('ncc2doituong_id, nguoitao_id');
        $query->values($data_value);
        $db->setQuery($query);
        $db->execute();
        return true;
    }

    public function getThongKe($params = array()){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.nhankhau_id, d.hoten,c.chinhsachncc_id,b.muctrocap,b.tyle,e.tendoituong,f.tenkhuvuc,gt.tengioitinh,d.cccd_so,c.nam');
        $query->from('vhxhytgd_nguoicocong AS a, vhxhytgd_nguoicocong2doituong AS b, vhxhytgd_nguoicocong2chinhsach AS c, vptk_hokhau2nhankhau AS d, danhmuc_doituong AS e, danhmuc_khuvuc AS f, danhmuc_phuongxa AS px, danhmuc_quanhuyen AS qh, vptk_hokhau AS h, danhmuc_gioitinh AS gt');
        $query->where('a.nhankhau_id = d.id AND a.id = b.nguoicocong_id AND c.ncc2doituong_id = b.id AND a.daxoa = 0 AND b.daxoa = 0 AND c.daxoa = 0 AND e.id = b.doituongncc_id AND h.thonto_id = f.id AND px.id = h.phuongxa_id AND qh.id = h.quanhuyen_id AND d.hokhau_id = h.id AND gt.id = d.gioitinh_id');
        if($params['start_year'] != '' && $params['end_year'] == ''){
            $query->where('c.nam >= '.$db->quote($params['start_year']) .' AND c.nam <= '.$db->quote(date('Y')));
        }elseif($params['start_year'] != '' && $params['end_year'] != ''){
            $query->where('c.nam >= '.$db->quote($params['start_year']) .' AND c.nam <= '.$db->quote($params['end_year']));
        }
        if($params['thonto_id'] != ''){
            $query->where('h.thonto_id = '.$db->quote($params['thonto_id']));
        }elseif($params['phuongxa_id'] != ''){
            $query->where('h.phuongxa_id = '.$db->quote($params['phuongxa_id']));
        }
        $phanquyen = $this->getPhanquyen();
        if($params['phuongxa_id'] != ''){
            $query->where('h.phuongxa_id '. ' IN (' . str_replace("'", '',$db->quote($phanquyen['phuongxa_id'])) . ')' );
        }           
        if($params['cmnd'] != ''){$query->where('d.cccd_so = '.$db->quote($params['cmnd']));}
        if($params['gioitinh_id'] != ''){$query->where('d.gioitinh_id = '.$db->quote($params['gioitinh_id']));}
        if($params['doituong_id'] != ''){$query->where('b.doituongncc_id = '.$db->quote($params['doituong_id']));}
        
        $query->order("c.nam");
        $db->setQuery($query);
        $rows = $db->loadAssocList();
        return $rows;
    }

    /*--------- Thông tin Lao động ----------- */

    public function validThongTinCongDanByNhanKhauID($nhankhau_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('nhankhau_id');
        $query->from('vhxhytgd_laodong as a');
        $query->where('a.nhankhau_id = '.$db->quote($nhankhau_id));    
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;
    }

    public function getDoiTuongViecLam(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true); 
        $query->select('*');
        $query->from('danhmuc_doituong as a');
        $query->where('a.phanloai = 3 AND a.daxoa = 0 AND a.trangthai = 1');
        $id = null;
        if($id != ''){
            $query->where('a.id = '.$db->quote($id)); 
        }         
        $db->setQuery($query);       
        return  $db->loadAssocList();
    }

    public function getDanhMucNgheNghiep(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true); 
        $query->select('*');
        $query->from('danhmuc_nghenghiep as a');
        $query->where('a.daxoa = 0 AND a.trangthai = 1');
        $id = null;
        if($id != ''){
            $query->where('a.id = '.$db->quote($id)); 
        }         
        $db->setQuery($query);       
        return  $db->loadAssocList();
    }

    public function getDanhSachLaoDong($nhankhau_id, $params = array()){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true); 
        $phanquyen = $this->getPhanquyen();
        $query->select('*, a.id as laodong_id, a.nhankhau_id, a.nghenghiep_id, a.is_hopdonglaodong, a.diachinoilamviec');
        $query->from('vhxhytgd_laodong as a');
        $query->leftJoin('vptk_hokhau2nhankhau as b on a.nhankhau_id = b.id');
        $query->leftJoin('vptk_hokhau AS c ON b.hokhau_id = c.id'); 
        $query->leftJoin('danhmuc_doituong AS d ON a.doituonglaodong_id = d.id');
        $query->leftJoin('danhmuc_tinhthanh AS tt ON c.tinhthanh_id = tt.id');
        $query->leftJoin('danhmuc_quanhuyen AS e ON c.quanhuyen_id = e.id');
        $query->leftJoin('danhmuc_phuongxa AS f ON c.phuongxa_id = f.id');
        $query->leftJoin('danhmuc_khuvuc AS g ON c.thonto_id = g.id');
        $query->leftJoin('danhmuc_gioitinh AS h ON b.gioitinh_id = h.id');
        $query->leftJoin('danhmuc_dantoc AS i ON b.dantoc_id = i.id');
        $query->leftJoin('danhmuc_tongiao AS l ON b.tongiao_id = l.id');
        $query->leftJoin('danhmuc_nghenghiep AS nn ON a.nghenghiep_id = nn.id');
        $query->where('a.daxoa = 0');
        if($params['phuongxa_id'] == '' && $phanquyen['phuongxa_id'] != '-1'){
            $query->where('a.phuongxa_id '. ' IN (' . str_replace("'", '',$db->quote($phanquyen['phuongxa_id'])) . ')' );
        }
        if($nhankhau_id != null){$query->where('a.nhankhau_id = '.$db->quote($nhankhau_id));}
        if($params['keyWord'] != ''){$query->where('b.hoten LIKE '.$db->quote('%'.$params['keyWord'].'%'));}
        if($params['hoten'] != ''){$query->where('b.hoten LIKE '.$db->quote('%'.$params['hoten'].'%'));}
        if($params['cmnd'] != ''){$query->where('b.cccd_so = '.$db->quote($params['cmnd']));}
        if($params['gioitinh_id'] != ''){$query->where('b.gioitinh_id = '.$db->quote($params['gioitinh_id']));}
        if($params['doituong_id'] != ''){$query->where('a.doituonglaodong_id = '.$db->quote($params['doituong_id']));}
        if($params['phuongxa_id'] != ''){$query->where('c.phuongxa_id = '.$db->quote($params['phuongxa_id']));}
        if($params['thonto_id'] != ''){$query->where('c.thonto_id = '.$db->quote($params['thonto_id']));}
        if($params['doituongvieclam_id'] != ''){$query->where('a.doituonglaodong = '.$db->quote($params['doituongvieclam_id']));} 
        $db->setQuery($query);       
        return  $db->loadAssocList();
    }

    public function saveThongTinLaoDong($formData){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true); 
        $user_id = JFactory::getUser()->id;

        $data = array(
            'id' => $formData['thongtinlaodong_id'],
            'nhankhau_id' => $formData['keyWord'],
            'phuongxa_id' => $formData['phuongxa_id'],
            'thonto_id' => $formData['thonto_id'],
            'doituonglaodong_id' => $formData['doituongvieclam_id'],
            'nghenghiep_id' => $formData['congviechientai_id'],
            'is_hopdonglaodong' => $formData['hdld'],
            'is_hokinhdoanh' => $formData['kdhct'],
            'diachinoilamviec' => $formData['diachilamviec'],
            'gioithieuvieclam_id' => $formData['phuongxagioithieu_id'],
            'daxoa' => '0',
        );

        if((int)$data['id'] == 0){
            $data['nguoitao_id'] = $user_id;
            $data['ngaytao'] = 'NOW()';
        }else{
            $data['nguoixoa_id'] = $user_id;
            $data['nguoihieuchinh_id'] = $user_id;
            $data['ngayhieuchinh'] = 'NOW()';
        }

        foreach($data as $key => $value){
            if($value == '' || $value == null){
                $data_update[] = $key . " = NULL";                   
                unset($data[$key]);
            }else{
                $data_insert_key[] = $key;
                if($value == 'NOW()'){
                    $data_insert_val[] = $value;
                    $data_update[] = $key . " = " . $value;
                }else{
                    $data_insert_val[] = $db->quote($value);
                    $data_update[] = $key . " = " . $db->quote($value);
                }
            }
        }

        if((int)$data['id'] == 0){
            $query->insert($db->quoteName('vhxhytgd_laodong'))->columns($data_insert_key)->values(implode(",",$data_insert_val));
        }else{
            $query->update($db->quoteName('vhxhytgd_laodong'));
            $query->set(implode(',', $data_update));
            $query->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }
        $db->setQuery($query);
        $db->execute();
        return true;
    }

    

    public function delThongTinLaoDong($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $user_id = JFactory::getUser()->id;
        $query->update('vhxhytgd_laodong as a');
        $query->set('a.daxoa = 1');
        $query->set('a.nguoixoa_id = '.$db->quote($user_id));
        $query->set('a.ngayxoa = NOW()');
        $query->where('a.id ='.$db->quote($id));
        $db->setQuery($query);
        return $db->execute();
    }
    public function thongKeLaoDong($params = array()){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true); 
        $query->select('*,px.tenkhuvuc as tenphuongxa, a.id as laodong_id, a.nhankhau_id, a.nghenghiep_id, a.is_hopdonglaodong, a.diachinoilamviec, COUNT(IF(a.doituonglaodong_id = 8,1,NULL)) AS covieclam, COUNT(IF(a.doituonglaodong_id = 9,1,NULL)) AS chuacovieclam, COUNT(IF(a.is_hokinhdoanh = 1,1,NULL)) AS khongkinhdoanh');
        $query->from('vhxhytgd_laodong as a');
        $query->leftJoin('vptk_hokhau2nhankhau as b on a.nhankhau_id = b.id');
        $query->leftJoin('vptk_hokhau AS c ON b.hokhau_id = c.id AND c.phuongxa_id = a.phuongxa_id'); 
        $query->leftJoin('danhmuc_doituong AS d ON a.doituonglaodong_id = d.id');
        $query->leftJoin('danhmuc_tinhthanh AS tt ON c.tinhthanh_id = tt.id');
        $query->leftJoin('danhmuc_khuvuc AS px ON px.id = a.phuongxa_id');
        $query->leftJoin('danhmuc_khuvuc AS g ON c.thonto_id = g.id');
        
        $query->leftJoin('danhmuc_gioitinh AS h ON b.gioitinh_id = h.id');
        $query->leftJoin('danhmuc_dantoc AS i ON b.dantoc_id = i.id');
        $query->leftJoin('danhmuc_tongiao AS l ON b.tongiao_id = l.id');
        $query->leftJoin('danhmuc_nghenghiep AS nn ON a.nghenghiep_id = nn.id');
        
        $query->where('a.daxoa = 0');
        if($params['doituong_id'] != ''){$query->where('a.doituonglaodong_id = '.$db->quote($params['doituong_id']));}
        if($params['phuongxa_id'] != ''){$query->where('c.phuongxa_id = '.$db->quote($params['phuongxa_id']));}
        if($params['thonto_id'] != ''){$query->where('c.thonto_id = '.$db->quote($params['thonto_id']));}
        if($params['doituongvieclam_id'] != ''){$query->where('a.doituonglaodong = '.$db->quote($params['doituongvieclam_id']));}
        if($params['phuongxagioithieu_id'] != ''){$query->where('a.gioithieuvieclam_id = '.$db->quote($params['phuongxagioithieu_id']));}  
        if($params['hopdonglaodong_id'] != '-1'){$query->where('a.is_hopdonglaodong = '.$db->quote($params['hopdonglaodong_id']));}       
        $db->setQuery($query);       
        return  $db->loadAssocList();
    }

    ////////////////// Module vay vốn /////////////////

    public function validThongTinVayVonByNhanKhauID($nhankhau_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('nhankhau_id');
        $query->from('vhxhytgd_nguoivayvon as a');
        $query->where('a.nhankhau_id = '.$db->quote($nhankhau_id));    
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;
    }

    public function getChuongtrinhvay(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true); 
        $query->select('*');
        $query->from('danhmuc_chuongtrinhvay as a');
        $query->where('a.daxoa = 0 AND a.trangthai = 1');
        $id = null;
        if($id != ''){
            $query->where('a.id = '.$db->quote($id)); 
        }         
        $db->setQuery($query);       
        return  $db->loadAssocList();
    }

    public function getNguonvonvay(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true); 
        $query->select('*');
        $query->from('danhmuc_nguonvon as a');
        $query->where('a.daxoa = 0 AND a.trangthai = 1');
        $id = null;
        if($id != ''){
            $query->where('a.id = '.$db->quote($id)); 
        }         
        $db->setQuery($query);       
        return  $db->loadAssocList();
    }
    public function getTrangthaivay(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true); 
        $query->select('*');
        $query->from('danhmuc_trangthaivay as a');
        $query->where('a.daxoa = 0 AND a.trangthai = 1');
        $id = null;
        if($id != ''){
            $query->where('a.id = '.$db->quote($id)); 
        }         
        $db->setQuery($query);       
        return  $db->loadAssocList();
    }

    public function getDanhSachVayVon($nhankhau_id, $params = array()){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true); 
        $phanquyen = $this->getPhanquyen();
        $query->select('*, a.id as vayvon_id, a.nhankhau_id, b.hoten, i.tendantoc, l.tentongiao');
        $query->from('vhxhytgd_nguoivayvon as a');
        $query->leftJoin('vptk_hokhau2nhankhau as b on a.nhankhau_id = b.id');
        $query->leftJoin('vptk_hokhau AS c ON b.hokhau_id = c.id'); 
        $query->leftJoin('danhmuc_tinhthanh AS tt ON c.tinhthanh_id = tt.id');
        $query->leftJoin('danhmuc_quanhuyen AS e ON c.quanhuyen_id = e.id');
        $query->leftJoin('danhmuc_phuongxa AS f ON c.phuongxa_id = f.id');
        $query->leftJoin('danhmuc_khuvuc AS g ON c.thonto_id = g.id');
        $query->leftJoin('danhmuc_gioitinh AS h ON b.gioitinh_id = h.id');
        $query->leftJoin('danhmuc_dantoc AS i ON b.dantoc_id = i.id');
        $query->leftJoin('danhmuc_tongiao AS l ON b.tongiao_id = l.id');
        $query->where('a.daxoa = 0');
        if($params['phuongxa_id'] == '' && $phanquyen['phuongxa_id'] != '-1'){
            $query->where('a.phuongxa_id '. ' IN (' . str_replace("'", '',$db->quote($phanquyen['phuongxa_id'])) . ')' );
        }
        if($nhankhau_id != null){$query->where('a.nhankhau_id = '.$db->quote($nhankhau_id));}
        if($params['keyWord'] != ''){$query->where('b.hoten LIKE '.$db->quote('%'.$params['keyWord'].'%'));}
        if($params['hoten'] != ''){$query->where('b.hoten LIKE '.$db->quote('%'.$params['hoten'].'%'));}
        if($params['cmnd'] != ''){$query->where('b.cccd_so = '.$db->quote($params['cmnd']));}
        if($params['gioitinh_id'] != ''){$query->where('b.gioitinh_id = '.$db->quote($params['gioitinh_id']));}
        if($params['doituong_id'] != ''){$query->where('a.doituonglaodong_id = '.$db->quote($params['doituong_id']));}
        if($params['phuongxa_id'] != ''){$query->where('c.phuongxa_id = '.$db->quote($params['phuongxa_id']));}
        if($params['thonto_id'] != ''){$query->where('c.thonto_id = '.$db->quote($params['thonto_id']));}
        if($params['doituongvieclam_id'] != ''){$query->where('a.doituonglaodong = '.$db->quote($params['doituongvieclam_id']));}        
        $db->setQuery($query);       
        return  $db->loadAssocList();
    }

    public function getDanhSachChuongTrinh2VayVon($nhankhau_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true); 
        $query->select('*, a.id as id_chuongtrinhvay');
        $query->from('vhxhytgd_nguoivayvon2chuongtrinh as a');
        $query->leftJoin('danhmuc_chuongtrinhvay AS d ON a.chuongtrinhvay_id = d.id');
        if($nhankhau_id != null){
            $query->where('a.daxoa = 0 AND a.nguoivayvon_id in (select id from vhxhytgd_nguoivayvon where nhankhau_id = '.$nhankhau_id.')');
        }
        $query->order('a.id');
        $db->setQuery($query);
               
        return  $db->loadAssocList();
    }

    public function saveThongTinVonVay($formData){
        $db = JFactory::getDbo();
        $user_id = JFactory::getUser()->id;

        $data = array(
            'id' => $formData['id_vayvon'],
            'nhankhau_id' => $formData['keyWord'],
            'phuongxa_id' => $formData['phuongxa_id'],
            'thonto_id' => $formData['thonto_id'],
            'daxoa' => '0',
        );
        if ((int) $data['id'] == 0) {
            $data['nguoitao_id'] = $user_id;
            $data['ngaytao'] = 'NOW()';
        }else{
            $data['nguoixoa_id'] = $user_id;
            $data['nguoihieuchinh_id'] = $user_id;
            $data['ngayhieuchinh'] = 'NOW()';
        }
        foreach ($data as $key => $value) {               
            if($value == '' || $value == null){
                $data_update[] = $key . " = NULL";                   
                unset($data[$key]);
            }else{
                $data_insert_key[] = $key;
                if($value == 'NOW()'){
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
            $query->insert($db->quoteName('vhxhytgd_nguoivayvon'))->columns($data_insert_key)->values(implode(',', $data_insert_val));
        }else{
            $query->update($db->quoteName('vhxhytgd_nguoivayvon'));
            $query->set(implode(',', $data_update));
            $query->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }
        $db->setQuery($query);
        $db->execute();
        if ((int) $data['id'] == 0) { $id = $db->insertid(); }else{ $id = $data['id']; } 
        for($dt = 0, $n = count($formData['chuongtrinhvay_id']); $dt < $n; $dt++){    
            $dbs = JFactory::getDbo();
            $querys = $dbs->getQuery(true);       
            $data_chuyennganh[$dt] = array(
                'id' => $formData['id_chuongtrinhvay'][$dt],
                'nguoivayvon_id' => $id,
                'chuongtrinhvay_id' => $formData['chuongtrinhvay_id'][$dt],
                'nguonvon_id' => $formData['nguonvon_id'][$dt],
                'ngaygiaingan' => $formData['ngaygiaingan'][$dt],
                'ngaydenhan' => $formData['ngaydenhancuoi'][$dt], 
                'tiengiaingan' => str_replace(",","",$formData['giaingan'][$dt]),
                'laisuatvay' => $formData['laisuat'][$dt], 
                'tongduno' => str_replace(",","",$formData['tongduno'][$dt]),
                'laiton' => str_replace(",","",$formData['laiconton'][$dt]) ,
                'sodu' => str_replace(",","",$formData['sodu105'][$dt])    ,
                'trangthaivay_id' => $formData['trangthaivay_id'][$dt],
                'daxoa' => '0'
            );
            if ((int) $data_chuyennganh[$dt]['id'] == 0) {
                $data_chuyennganh[$dt]['nguoitao_id'] = $user_id;
                $data_chuyennganh[$dt]['ngaytao'] = 'NOW()';
            }else{
                $data_chuyennganh[$dt]['nguoixoa_id'] = $user_id;
                $data_chuyennganh[$dt]['nguoihieuchinh_id'] = $user_id;
                $data_chuyennganh[$dt]['ngayhieuchinh'] = 'NOW()';
            }
            
            foreach ($data_chuyennganh[$dt] as $key => $value) {                     
                if($value == '' || $value == null){               
                    $data_chuyennganh_update[$dt][] = $key . " = NULL";                   
                    unset($data_chuyennganh[$dt][$key]);
                }else{
                    $data_chuyennganh_insert_key[$dt][] = $key;
                    if($key == 'ngaygiaingan' || $key == 'ngaydenhan'){
                        $data_chuyennganh_insert_val[$dt][] = "STR_TO_DATE('" . $value . "','%d/%m/%Y')";
                        $data_chuyennganh_update[$dt][] = $key . " = " . "STR_TO_DATE('" . $value . "','%d/%m/%Y')";
                    }elseif($value == 'NOW()'){
                        $data_chuyennganh_insert_val[$dt][] = $value;                     
                        $data_chuyennganh_update[$dt][] = $key . " = " . $value;
                    }else{
                        $data_chuyennganh_insert_val[$dt][] = $dbs->quote($value);
                        $data_chuyennganh_update[$dt][] = $key . " = " . $dbs->quote($value);
                    }
                }          
            }
            
            if ((int) $data_chuyennganh[$dt]['id'] == 0 ) {           
                $querys->insert($dbs->quoteName('vhxhytgd_nguoivayvon2chuongtrinh'))->columns($data_chuyennganh_insert_key[$dt])->values(implode(',',$data_chuyennganh_insert_val[$dt]));                  
            } else {
                $querys->update($dbs->quoteName('vhxhytgd_nguoivayvon2chuongtrinh'));
                $querys->set(implode(',', $data_chuyennganh_update[$dt]));
                $querys->where(array($dbs->quoteName('id') . '=' . $dbs->quote($data_chuyennganh[$dt]['id'])));                            
            }
            $dbs->setQuery($querys);
            $dbs->execute();
        }
       return true;
    }
    public function removeChuongtrinhvay($id_chuongtrinhvay){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $user_id = JFactory::getUser()->id;
        $query->update('vhxhytgd_nguoivayvon2chuongtrinh');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = '.$db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id ='.$db->quote($id_chuongtrinhvay));
        $db->setQuery($query);
        return $db->execute();
    }
    public function removeDoituongvay($id_vayvon){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $user_id = JFactory::getUser()->id;
        $query->update('vhxhytgd_nguoivayvon as a, vhxhytgd_nguoivayvon2chuongtrinh as b');
        $query->set('a.daxoa = 1, b.daxoa=1');
        $query->set('a.nguoixoa_id = '.$db->quote($user_id));
        $query->set('b.nguoixoa_id = '.$db->quote($user_id));
        $query->set('a.ngayxoa = NOW()');
        $query->set('b.ngayxoa = NOW()');
        $query->where('a.id = b.nguoivayvon_id');
        $query->where('a.id ='.$db->quote($id_vayvon));
        $db->setQuery($query);
        return $db->execute();
    }

    /// Module Chính sách BTXH ////
    public function getNhomDoiTuongBTXH(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('danhmuc_nhomdoituongbtxh as a');
        $query->where('a.daxoa = 0 AND a.trangthai = 1'); 
        $query->order('id');
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;
    }

    public function getNhomDoiTuongBTXHOutID($nhomdoituongbtxh_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('danhmuc_nhomdoituongbtxh as a');
        $query->where('a.daxoa = 0 AND a.trangthai = 1 AND id <> '.$nhomdoituongbtxh_id.''); 
        $query->order('id');
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;
    }

    public function getDoiTuongBTXH(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('danhmuc_doituong as a');
        $query->where('a.daxoa = 0 AND a.trangthai = 1 AND a.phanloai = 1'); 
        $query->order('id');
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;
    }

    public function getChinhSachBTXH(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('danhmuc_chinhsach as a');
        $query->where('a.daxoa = 0 AND a.trangthai = 1 AND a.phanloai = 1'); 
        $db->setQuery($query);    
        $rows = $db->loadAssocList();
        return $rows;
    }

    public function getCongDanByHoKhauID($hokhau_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*, a.id as nhankhau_id');
        $query->from('vptk_hokhau2nhankhau as a');
        $query->leftJoin('danhmuc_quanhenhanthan as b ON b.id = a.quanhenhanthan_id');
        $query->where('a.is_tamtru = 0 and a.daxoa = 0 ');
        $query->where('a.hokhau_id = (SELECT hokhau_id FROM vptk_hokhau2nhankhau WHERE id ='.$hokhau_id.')');
        $query->where('a.id <> '.$hokhau_id);
        $db->setQuery($query);    
        return $db->loadAssocList();
    }

    /* Lấy danh sách all người hưởng chính sách bảo trợ xã hội */
    public function getDanhSachDoiTuongHBTXH(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*, a.id as id_doituonghbtxh');
        $query->from('vhxhytgd_doituonghbtxh as a, vhxhytgd_doituonghbtxh2doituong as b, vhxhytgd_doituonghbtxh2chinhsach as c, vptk_hokhau2nhankhau as d, danhmuc_nhomdoituongbtxh as f, danhmuc_doituong as g, danhmuc_khuvuc as h, danhmuc_gioitinh as gt');
        $query->where('a.id = b.doituonghbtxh_id AND b.id = c.dthbtxh2doituong_id AND a.nhankhau_id = d.id AND f.id =  b.nhomdoituongbtxh_id AND g.id = b.doituongbtxh_id AND g.phanloai = 1 AND h.id = a.thonto_id AND gt.id = d.gioitinh_id');  
        $db->setQuery($query);
        return $db->loadAssocList();
    }

    /* Lấy thông tin người hưởng chính sách bảo trợ xã hội theo id*/
    public function getDoiTuongHBTXHByID($nhankhau_id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*, a.id as id_doituonghbtxh');
        $query->from('vhxhytgd_doituonghbtxh as a, vhxhytgd_doituonghbtxh2doituong as b, vhxhytgd_doituonghbtxh2chinhsach as c, vptk_hokhau2nhankhau as d, danhmuc_nhomdoituongbtxh as f, danhmuc_doituong as g, danhmuc_khuvuc as h, danhmuc_gioitinh as gt, danhmuc_dantoc as dt, danhmuc_tongiao as tg, vptk_hokhau as hk');
        $query->where('a.id = b.doituonghbtxh_id AND b.id = c.dthbtxh2doituong_id AND a.nhankhau_id = d.id AND f.id =  b.nhomdoituongbtxh_id AND g.id = b.doituongbtxh_id AND g.phanloai = 1 AND h.id = a.thonto_id AND gt.id = d.gioitinh_id AND dt.id = d.dantoc_id AND tg.id = d.tongiao_id AND a.phuongxa_id = hk.phuongxa_id AND d.hokhau_id = hk.id');  
        $query->where('a.id = '.$nhankhau_id);
        $db->setQuery($query);
        return $db->loadAssocList();
    }

    public function saveDoituongBHXH($formData){
        $db = JFactory::getDbo();
        $user_id = JFactory::getUser()->id;
        $data = array(
            'id' => $formData['id_doituongbhxh'],        
            'phuongxa_id' => $formData['phuongxa_id'],
            'thonto_id' => $formData['thonto_id'],
            'nhankhau_id' => $formData['keyWord'],
            'lienhe_nhankhau_id' => $formData['lienhe_nhankhau_id'],
            'quanhevoidoituong' => $formData['quanhevoidoituong'],
            'daxoa' => '0',
        );
        if ((int) $data['id'] == 0) {
            $data['nguoitao_id'] = $user_id;
            $data['ngaytao'] = 'NOW()';
        }else{
            $data['nguoixoa_id'] = $user_id;
            $data['nguoihieuchinh_id'] = $user_id;
            $data['ngayhieuchinh'] = 'NOW()';
        }
        foreach ($data as $key => $value) {               
            if($value == '' || $value == null){
                $data_update[] = $key . " = NULL";                   
                unset($data[$key]);
            }else{
                $data_insert_key[] = $key;
                if($value == 'NOW()'){
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
            $query->insert($db->quoteName('vhxhytgd_doituonghbtxh'))->columns($data_insert_key)->values(implode(',', $data_insert_val));
        }else{
            $query->update($db->quoteName('vhxhytgd_doituonghbtxh'));
            $query->set(implode(',', $data_update));
            $query->where(array($db->quoteName('id') . '=' . $db->quote($data['id'])));
        }
       
        $db->setQuery($query);
        $db->execute();
        if ((int) $data['id'] == 0) { $nhankhau_id = $db->insertid(); }else{ $nhankhau_id = $data['id']; } 
        for($dt = 0, $n = count($formData['doituongbtxh_id']); $dt < $n; $dt++){    
            $dbs = JFactory::getDbo();
            $querys = $dbs->getQuery(true);       
            $data_chuyennganh[$dt] = array(
                'id' => $formData['doituonghbtxh_id'][$dt],
                'doituonghbtxh_id' => $nhankhau_id,
                'nhomdoituongbtxh_id' =>  $formData['nhomdoituongbtxh_id'][$dt],
                'doituongbtxh_id' => $formData['doituongbtxh_id'][$dt],
                'muctrocap' => $formData['muctrocap'][$dt], 
                'daxoa' => "0",     
            );
            if ((int) $data_chuyennganh[$dt]['id'] == 0) {
                $data_chuyennganh[$dt]['nguoitao_id'] = $user_id;
                $data_chuyennganh[$dt]['ngaytao'] = 'NOW()';
            }else{
                $data_chuyennganh[$dt]['nguoixoa_id'] = $user_id;
                $data_chuyennganh[$dt]['nguoihieuchinh_id'] = $user_id;
                $data_chuyennganh[$dt]['ngayhieuchinh'] = 'NOW()';
            }
            
            foreach ($data_chuyennganh[$dt] as $key => $value) {                     
                if($value == '' || $value == null){               
                    $data_chuyennganh_update[$dt][] = $key . " = NULL";                   
                    unset($data_chuyennganh[$dt][$key]);
                }else{
                    $data_chuyennganh_insert_key[$dt][] = $key;                           
                    if($value == 'NOW()'){
                        $data_chuyennganh_insert_val[$dt][] = $value;                     
                        $data_chuyennganh_update[$dt][] = $key . " = " . $value;
                    }else{
                        $data_chuyennganh_insert_val[$dt][] = $dbs->quote($value);
                        $data_chuyennganh_update[$dt][] = $key . " = " . $dbs->quote($value);
                    }
                }          
            }
            
            if ((int) $data_chuyennganh[$dt]['id'] == 0 ) {           
                $querys->insert($dbs->quoteName('vhxhytgd_doituonghbtxh2doituong'))->columns($data_chuyennganh_insert_key[$dt])->values(implode(',',$data_chuyennganh_insert_val[$dt]));                  
            } else {
                $querys->update($dbs->quoteName('vhxhytgd_doituonghbtxh2doituong'));
                $querys->set(implode(',', $data_chuyennganh_update[$dt]));
                $querys->where(array($dbs->quoteName('id') . '=' . $dbs->quote($data_chuyennganh[$dt]['id'])));                            
            }
            $dbs->setQuery($querys);
            $dbs->execute();
            if ((int)$data_chuyennganh[$dt]['id'] == 0) { $doituonghbtxh_id[] = $dbs->insertid(); }else{ $doituong_id[] = $data_chuyennganh[$dt]['id']; } 
        }
        //Final Đối tượng//
        for ($cs=0; $cs < count($formData['chinhsach_id']); $cs++) { 
            $value_sp = explode("_",$formData['nam_chinhsach_hidden'][$cs]);
            $dbsss = JFactory::getDbo();
            $querysss = $dbsss->getQuery(true);  
            $querysss->select('id');
            $querysss->from('vhxhytgd_doituonghbtxh2doituong')  ;
            $querysss->where('doituonghbtxh_id = '.$nhankhau_id. ' AND doituongbtxh_id = '.$value_sp[1].' AND nhomdoituongbtxh_id = '.$value_sp[0] );
            $dbsss->setQuery($querysss);    
            $dthbtxh2doituong_id = $dbsss->loadResult(); 
            if ((int)$formData['chinhsachbtxh_id'][$cs] == 0) {
                $valuechinhsach_insert[] = $dbsss->quote($dthbtxh2doituong_id).','.$dbsss->quote($formData['nam_chinhsach'][$cs]).','.$dbsss->quote($formData['chinhsach_id'][$cs]).','.$dbsss->quote($formData['noidung'][$cs]).','.$dbsss->quote($formData['kinhphi'][$cs]).','.$dbsss->quote($formData['ghichu'][$cs]).',0,'.$dbsss->quote($user_id).',NOW()';
            }else{
                $querysss = $dbsss->getQuery(true);
                $querysss->update('vhxhytgd_doituonghbtxh2chinhsach');
                $querysss->set('nam = '.$dbsss->quote($formData['nam_chinhsach'][$cs]));
                $querysss->set('chinhsachbtxh_id = '.$dbsss->quote($formData['chinhsach_id'][$cs]));
                $querysss->set('noidung = '.$dbsss->quote($formData['noidung'][$cs]));
                $querysss->set('kinhphi = '.$dbsss->quote($formData['kinhphi'][$cs]));
                $querysss->set('ghichu =  '.$dbsss->quote($formData['ghichu'][$cs]));
                $querysss->set('nguoihieuchinh_id = '.$dbsss->quote($user_id));
                $querysss->set('ngayhieuchinh = NOW()');
                $querysss->where('id = '.$dbsss->quote($formData['idchinhsach'][$cs]));
                $dbsss->setQuery($querysss);
                if(!$dbsss->execute()){
                    return false;
                }
            }
        }
        if(count($valuechinhsach_insert) > 0){
            $querysss = $dbsss->getQuery(true);
            $querysss->insert('vhxhytgd_doituonghbtxh2chinhsach');
            $querysss->columns('dthbtxh2doituong_id,nam,chinhsachbtxh_id,noidung,kinhphi,ghichu,daxoa,nguoitao_id,ngaytao');
            $querysss->values($valuechinhsach_insert);
            $dbsss->setQuery($querysss);
            if(!$dbsss->execute()){
                return false;
            }
        }
        return true;
    }

}