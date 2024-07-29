<?php
class Danhmuc_Model_Ajax extends JModelLegacy{
    public function getQuanHuyenByTinhThanh($tinhthanh_id, $trangthai = null){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*');
        $query->from('danhmuc_quanhuyen AS a');
        $query->where('a.daxoa = 0 AND a.tinhthanh_id = '.$db->quote($tinhthanh_id));
        if($trangthai != null){
            $query->where('a.trangthai = '.$db->quote($trangthai));
        }
        $query->order('a.sapxep,a.tenquanhuyen');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getPhuongXaByQuanHuyen($quanhuyen_id, $trangthai = null){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*');
        $query->from('danhmuc_phuongxa AS a');
        $query->where('a.daxoa = 0 AND a.quanhuyen_id = '.$db->quote($quanhuyen_id));
        if($trangthai != null){
            $query->where('a.trangthai = '.$db->quote($trangthai));
        }
        $query->order('a.sapxep,a.tenphuongxa');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
}