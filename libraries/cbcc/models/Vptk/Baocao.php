<?php
class Covid_Model_Baocao extends JModelLegacy{
    public function getTonghopXuly(){
        $model = Core::model('Covid/Covid');
        $phanquyen = $model->getPhanquyen();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('SUM(IF(DATE(a.ngaydangky) = CURRENT_DATE AND a.trangthai = 1 AND a.daxoa = 0,1,0)) AS soluongdkmoi,SUM(IF(a.trangthai = 1 AND a.daxoa = 0,1,0)) AS soluongdk,SUM(IF(DATE(a.ngaytonghop) = CURRENT_DATE AND a.trangthai = 2 AND a.ngayxuatfile IS NULL AND a.daxoa = 0,1,0)) AS soluongthmoi,SUM(IF(a.trangthai = 2 AND a.ngayxuatfile IS NULL AND a.daxoa = 0,1,0)) AS soluongth,SUM(IF(DATE(a.ngaytonghop) = CURRENT_DATE AND a.trangthai = 2 AND a.ngayxuatfile IS NOT NULL AND a.daxoa = 0,1,0)) AS soluongxpmoi,SUM(IF(a.trangthai = 2 AND a.ngayxuatfile IS NOT NULL AND a.daxoa = 0,1,0)) AS soluongxp,SUM(IF(a.ngaycungung = CURRENT_DATE AND a.trangthai = 3,1,0)) AS soluongcumoi,SUM(IF(a.trangthai = 3,1,0)) AS soluongcu,SUM(IF(a.ngaycungung = CURRENT_DATE AND a.trangthai = 4,1,0)) AS soluongkcumoi,SUM(IF(a.trangthai = 4,1,0)) AS soluongkcu,SUM(IF(a.ngayxoa = CURRENT_DATE AND a.daxoa = 1,1,0)) AS soluonghuymoi,SUM(IF(a.daxoa = 1,1,0)) AS soluonghuy,COUNT(a.id) AS tongso');
        $query->from('dmh_thongtindonhang AS a');
        $query->innerJoin('dmh_thongtinnguoidangky AS b ON a.nguoidangky_id = b.id');
        if($phanquyen['thonto_id'] != '-1'){
            $query->where('b.thonto_id IN ('.$phanquyen['thonto_id'].')');
        }
        $db->setQuery($query);
        return $db->loadAssoc();
    }
    public function getTonghopKhuvucApdung(){
        $model = Core::model('Covid/Covid');
        $phanquyen = $model->getPhanquyen();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('c.id AS quanhuyen_id,c.ten AS quanhuyen,a.id AS phuongxa_id,a.ten AS phuongxa,COUNT(b.id) AS soluong');
        $query->from('danhmuc_khuvuc AS a');
        $query->innerJoin('danhmuc_khuvuc AS b ON a.id = b.cha_id AND b.sudung = 1');
        $query->innerJoin('danhmuc_khuvuc AS c ON a.cha_id = c.id');
        $query->where('a.sudung = 1 AND a.level = 2');
        $query->group('a.id');
        $query->order('c.ten,a.ten');
        $db->setQuery($query);
        $rows = $db->loadAssocList();
        $result['tongso'] = 0;
        for($i = 0, $n = count($rows); $i < $n; $i++){
            $result['quanhuyen'][$rows[$i]['quanhuyen_id']][] = $rows[$i];
            $result['tongso']+= $rows[$i]['soluong'];
        }
        return $result;
    }
}