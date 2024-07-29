<?php

use GCore\Libs\Arr;
class Vhytgd_Model_Danhmuc extends JModelLegacy{
    
    public function getDanhSachNguonVon($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('danhmuc_nguonvon AS a');
        $query->where('a.daxoa = 0');
        if($id != null){
            $query->where('id = '.$id);
        }
        $db->setQuery($query);
        return $db->loadAssocList();
        
    }
    public function saveNguonVon($formData){
        $db = JFactory::getDbo();
        $user_id = JFactory::getUser()->id;
        $query = $db->getQuery(true);
        if ((int)$formData['id'] == 0) {
            $value_insert[] = $db->quote($formData['tennguonvon']).','.$db->quote($formData['sapxep']).','.$db->quote($formData['trangthai']).','.$db->quote($user_id).',NOW()';
        }else{
            $query->update('danhmuc_nguonvon');
            $query->set('tennguonvon = '.$db->quote($formData['tennguonvon']));
            $query->set('sapxep = '.$db->quote($formData['sapxep']));
            $query->set('trangthai = '.$db->quote($formData['trangthai']));
            $query->set('nguoihieuchinh_id = '.$db->quote($user_id));
            $query->set('ngayhieuchinh = NOW()');
            $query->where('id = '.$db->quote($formData['id']));
            $db->setQuery($query);
            if(!$db->execute()){
                return false;
            }
        }
        
        if(count($value_insert) > 0){
            $query = $db->getQuery(true);
            $query->insert('danhmuc_nguonvon');
            $query->columns('tennguonvon,sapxep,trangthai,nguoitao_id,ngaytao');
            
            $query->values($value_insert);
            //echo($query);exit;
            $db->setQuery($query);
            if(!$db->execute()){
                return false;
            }
        }
        
        return true;
    }
    public function removeNguonvon($id){
        $user_id = JFactory::getUser()->id;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update('danhmuc_nguonvon');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = '.$db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id = '.$db->quote($id));
        $db->setQuery($query);
        if(!$db->execute()){
            return false;
        }
        
    }


    //Danh mục Chương trình vay vốn
    public function getChuongtrinh($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('danhmuc_chuongtrinhvay AS a');
        $query->where('a.daxoa = 0');
        if($id != null){
            $query->where('id = '.$id);
        }
        $db->setQuery($query);
        return $db->loadAssocList();
        
    }
    public function saveChuongtrinh($formData){
        $db = JFactory::getDbo();
        $user_id = JFactory::getUser()->id;
        $query = $db->getQuery(true);
        if ((int)$formData['id'] == 0) {
            $value_insert[] = $db->quote($formData['tenchuongtrinhvay']).','.$db->quote($formData['sapxep']).','.$db->quote($formData['trangthai']).','.$db->quote($user_id).',NOW()';
        }else{
            $query->update('danhmuc_chuongtrinhvay');
            $query->set('tenchuongtrinhvay = '.$db->quote($formData['tenchuongtrinhvay']));
            $query->set('sapxep = '.$db->quote($formData['sapxep']));
            $query->set('trangthai = '.$db->quote($formData['trangthai']));
            $query->set('nguoihieuchinh_id = '.$db->quote($user_id));
            $query->set('ngayhieuchinh = NOW()');
            $query->where('id = '.$db->quote($formData['id']));
            $db->setQuery($query);
            if(!$db->execute()){
                return false;
            }
        }
        
        if(count($value_insert) > 0){
            $query = $db->getQuery(true);
            $query->insert('danhmuc_chuongtrinhvay');
            $query->columns('tenchuongtrinhvay,sapxep,trangthai,nguoitao_id,ngaytao');
            $query->values($value_insert);
            $db->setQuery($query);
            if(!$db->execute()){
                return false;
            }
        }
        
        return true;
    }
    public function removeChuongtrinh($id){
        $user_id = JFactory::getUser()->id;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update('danhmuc_chuongtrinhvay');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = '.$db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id = '.$db->quote($id));
        $db->setQuery($query);
        if(!$db->execute()){
            return false;
        }
        
    }


    //Danh mục Trạng thái vay vốn
    public function getTrangthaivay($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('danhmuc_trangthaivay AS a');
        $query->where('a.daxoa = 0');
        if($id != null){
            $query->where('id = '.$id);
        }
        $query->order('a.sapxep ASC');
        $db->setQuery($query);
        
        return $db->loadAssocList();
        
    }
    public function saveTrangthaivay($formData){
        $db = JFactory::getDbo();
        $user_id = JFactory::getUser()->id;
        $query = $db->getQuery(true);
        if ((int)$formData['id'] == 0) {
            $value_insert[] = $db->quote($formData['tentrangthaivay']).','.$db->quote($formData['sapxep']).','.$db->quote($formData['trangthai']).','.$db->quote($user_id).',NOW()';
        }else{
            $query->update('danhmuc_trangthaivay');
            $query->set('tentrangthaivay = '.$db->quote($formData['tentrangthaivay']));
            $query->set('sapxep = '.$db->quote($formData['sapxep']));
            $query->set('trangthai = '.$db->quote($formData['trangthai']));
            $query->set('nguoihieuchinh_id = '.$db->quote($user_id));
            $query->set('ngayhieuchinh = NOW()');
            $query->where('id = '.$db->quote($formData['id']));
            $db->setQuery($query);
            if(!$db->execute()){
                return false;
            }
        }
        
        if(count($value_insert) > 0){
            $query = $db->getQuery(true);
            $query->insert('danhmuc_trangthaivay');
            $query->columns('tentrangthaivay,sapxep,trangthai,nguoitao_id,ngaytao');
            $query->values($value_insert);
            $db->setQuery($query);
            if(!$db->execute()){
                return false;
            }
        }
        
        return true;
    }
    public function removeTrangthaivay($id){
        $user_id = JFactory::getUser()->id;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update('danhmuc_trangthaivay');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = '.$db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id = '.$db->quote($id));
        $db->setQuery($query);
        if(!$db->execute()){
            return false;
        }
        
    }

    //Danh mục Nhóm đối tượng BTXH
    public function getDoiTuongHuongChinhSach($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('danhmuc_nhomdoituongbtxh AS a');
        $query->where('a.daxoa = 0');
        if($id != null){
            $query->where('id = '.$id);
        }
        $query->order('a.sapxep ASC');
        $db->setQuery($query);
        
        return $db->loadAssocList();
        
    }
    public function saveDoiTuongHuongChinhSach($formData){
        $db = JFactory::getDbo();
        $user_id = JFactory::getUser()->id;
        $query = $db->getQuery(true);
        if ((int)$formData['id'] == 0) {
            $value_insert[] = $db->quote($formData['tennhomdoituongbtxh']).','.$db->quote($formData['sapxep']).','.$db->quote($formData['trangthai']).','.$db->quote($user_id).',NOW()';
        }else{
            $query->update('danhmuc_nhomdoituongbtxh');
            $query->set('tennhomdoituongbtxh = '.$db->quote($formData['tennhomdoituongbtxh']));
            $query->set('sapxep = '.$db->quote($formData['sapxep']));
            $query->set('trangthai = '.$db->quote($formData['trangthai']));
            $query->set('nguoihieuchinh_id = '.$db->quote($user_id));
            $query->set('ngayhieuchinh = NOW()');
            $query->where('id = '.$db->quote($formData['id']));
            $db->setQuery($query);
            if(!$db->execute()){
                return false;
            }
        }
        
        if(count($value_insert) > 0){
            $query = $db->getQuery(true);
            $query->insert('danhmuc_nhomdoituongbtxh');
            $query->columns('tennhomdoituongbtxh,sapxep,trangthai,nguoitao_id,ngaytao');
            $query->values($value_insert);
            $db->setQuery($query);
            if(!$db->execute()){
                return false;
            }
        }
        //echo $query;exit;
        return true;
    }
    public function removeDoiTuongHuongChinhSach($id){
        $user_id = JFactory::getUser()->id;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update('danhmuc_nhomdoituongbtxh');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = '.$db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id = '.$db->quote($id));
        $db->setQuery($query);
        if(!$db->execute()){
            return false;
        }
        
    }
}