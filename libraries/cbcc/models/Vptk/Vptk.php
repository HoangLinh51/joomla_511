<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Vptk_Model_Vptk extends JModelLegacy
{

    public function getTitle()
    {
        return "Tie";
    }
    public function getKhuvucByIdCha($cha_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id,tenkhuvuc,cha_id,level');
        $query->from('danhmuc_khuvuc');
        $query->where('daxoa = 0 AND cha_id = ' . $db->quote($cha_id));
        $query->order('tenkhuvuc ASC');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getPhanquyen()
    {
        $user_id = Factory::getUser()->id;
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('quanhuyen_id,phuongxa_id');
        $query->from('phanquyen_user2khuvuc AS a');
        $query->where('a.user_id = ' . $db->quote($user_id));
        $db->setQuery($query);
        $result = $db->loadAssoc();

        if ($result['phuongxa_id'] == '') {
            echo '<div class="alert alert-error"><strong>Bạn không được phân quyền sử dụng chức năng này. Vui lòng liên hệ quản trị viên!!!</strong></div>';
            exit;
        } else {
            return $result;
        }
    }
    public function getDanhsachNhanHoKhau($params = array(), $startFrom, $perPage = 100)
    {
        $phanquyen = $this->getPhanquyen();
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.id,
        a.hokhau_so,
        DATE_FORMAT(a.hokhau_ngaycap,"%d/%m/%Y") AS hokhau_ngaycap,
        b.hoten AS hotenchuho,
        IF(b.gioitinh_id = 1, "Nam", IF(b.gioitinh_id = 2, "Nữ", "Không xác định")) as tengioitinh,
        CONCAT(a.diachi, ", ", d.tenkhuvuc, ", ", c.tenkhuvuc) AS diachi, 
        b.dienthoai,
        DATE_FORMAT(b.ngaysinh,"%d/%m/%Y") AS namsinh');
        $query->from('vptk_hokhau AS a');
        $query->innerJoin('vptk_hokhau2nhankhau AS b ON b.quanhenhanthan_id = -1 AND b.daxoa = 0 AND a.id = b.hokhau_id');
        $query->innerJoin('danhmuc_khuvuc AS c ON c.id = a.phuongxa_id');
        $query->innerJoin('danhmuc_khuvuc AS d ON d.id = a.thonto_id');


        if (!empty($params['hokhau_so'])) {
            $query->where('a.hokhau_so = ' . $db->quote($params['hokhau_so']));
        }
        if (!empty($params['hoten'])) {
            $hoten = $db->quote('%' . $params['hoten'] . '%');
            $query->where('b.hoten LIKE ' . $hoten);
        }
        if (!empty($params['gioitinh_id'])) {
            $query->where('b.gioitinh_id = ' . $db->quote($params['gioitinh_id']));
        }
        if (!empty($params['is_tamtru'])) {
            $query->where('b.is_tamtru = ' . $db->quote($params['is_tamtru']));
        }
        if (!empty($params['thonto_id'])) {
            $query->where('a.thonto_id = ' . $db->quote($params['thonto_id']));
        }
        if (!empty($params['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($params['phuongxa_id']));
        } elseif ($phanquyen['phuongxa_id'] != '-1') {
            $query->where('a.phuongxa_id = ' . $db->quote($phanquyen['phuongxa_id']));
        }
        if (isset($params['daxoa']) && $params['daxoa'] == '1') {
            $query->where('a.daxoa = 1');
        } else {
            $query->where('a.daxoa = 0');
        }
        if (!empty($params['cccd_so'])) {
            $query->where('b.cccd_so = ' . $db->quote($params['cccd_so']));
        }
       
        if (!empty($params['diachi'])) {
            $diachi = $db->quote('%' . $params['diachi'] . '%');
            $query->where('a.diachi LIKE ' . $diachi);
        }
        if ($startFrom !== null) {
            $query->order('id ASC')->setLimit($perPage, $startFrom);
        } else {
            $query->order('id ASC')->setLimit($perPage, 0);
        }

        // Debug query
        // echo $query->dump();
        // exit;

        $db->setQuery($query);
        try {
            return $db->loadAssocList();
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage('SQL Error: ' . $e->getMessage(), 'error');
            return [];
        }
    }
    public function countitems($params = array())
    {
        $phanquyen = $this->getPhanquyen();
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('COUNT(*) AS tongnhankhau');
        $query->from('vptk_hokhau AS a');

        if (isset($phanquyen['phuongxa_id']) && (string)$phanquyen['phuongxa_id'] !== '-1') {
            $query->where('a.phuongxa_id = ' . $db->quote($phanquyen['phuongxa_id']));
        }
        $query->where('a.daxoa = 0');
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    public function getDetailNhanHoKhau($hokhauId)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query->select('a.id, a.hoten, DATE_FORMAT(a.ngaysinh, "%d/%m/%Y") AS ngaysinh, DATE_FORMAT(a.cccd_ngaycap, "%d/%m/%Y") AS cccd_ngaycap,a.cccd_coquancap,a.is_tamtru, b.tengioitinh, a.cccd_so, a.dienthoai, 
            d.tendantoc, e.tentongiao, CONCAT(c.diachi, " - ", g.tenkhuvuc, " - ", f.tenkhuvuc) AS diachi, k.tennghenghiep,c.hokhau_coquancap,CONCAT(a.thuongtrucu_diachi, " - ", tt.tenkhuvuc, " - ", px.tenkhuvuc, " - ", qh.tenkhuvuc) AS diachi_cu,
            c.phuongxa_id, c.thonto_id, a.gioitinh_id, g.tenkhuvuc as tenthonto, a.quanhenhanthan_id, h.tenquanhenhanthan, c.hokhau_so, DATE_FORMAT(c.hokhau_ngaycap, "%d/%m/%Y") AS hokhau_ngaycap, j.tentrinhdohocvan,qt.tenquoctich, qt.icon,a.trangthaihoso ');
        $query->from('vptk_hokhau2nhankhau AS a');
        $query->innerJoin('danhmuc_gioitinh AS b ON a.gioitinh_id = b.id');
        $query->innerJoin('vptk_hokhau AS c ON a.hokhau_id = c.id');
        $query->innerJoin('danhmuc_dantoc AS d ON a.dantoc_id = d.id');
        $query->innerJoin('danhmuc_tongiao AS e ON a.tongiao_id = e.id');
        $query->innerJoin('danhmuc_khuvuc AS f ON c.phuongxa_id = f.id');
        $query->innerJoin('danhmuc_khuvuc AS g ON c.thonto_id = g.id');
        $query->innerJoin('danhmuc_quanhenhanthan AS h ON h.id = a.quanhenhanthan_id');
        $query->leftJoin('danhmuc_trinhdohocvan AS j ON j.id = a.trinhdohocvan_id');
        $query->leftJoin('danhmuc_nghenghiep AS k ON k.id = a.nghenghiep_id');
        $query->leftJoin('danhmuc_quoctich AS qt ON qt.id = a.quoctich_id');
        $query->leftJoin('danhmuc_khuvuc AS px ON a.thuongtrucu_phuongxa_id = px.id');
        $query->leftJoin('danhmuc_khuvuc AS tt ON a.thuongtrucu_thonto_id = tt.id');
        $query->leftJoin('danhmuc_khuvuc AS qh ON a.thuongtrucu_quanhuyen_id = qh.id');

        $query->where('a.hokhau_id = ' . $db->quote($hokhauId));
        $query->where('a.daxoa = 0');
        $query->order('a.id ASC');
        // echo $query;
        $db->setQuery($query);
        try {
            $results = $db->loadAssocList();
            return is_array($results) ? $results : []; // Đảm bảo luôn trả về mảng
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage('SQL Error: ' . $e->getMessage(), 'error');
            return [];
        }
    }
    public function removeNhanhokhau($hokhau_id, $user_id){
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->update('vptk_hokhau');
        $query->set('daxoa = 1');
        $query->set('nguoixoa_id = '.$db->quote($user_id));
        $query->set('ngayxoa = NOW()');
        $query->where('id ='.$db->quote($hokhau_id));
        // echo $query;exit;
        $db->setQuery($query);
        return $db->execute();
    }
    public function getItems($filters)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
        $phanquyen = $this->getPhanquyen();

        $query->select('a.id,
        a.hokhau_so,
        DATE_FORMAT(a.hokhau_ngaycap,"%d/%m/%Y") AS hokhau_ngaycap,
        b.hoten AS hotenchuho,
        IF(b.gioitinh_id = 1, "Nam", IF(b.gioitinh_id = 2, "Nữ", "Không xác định")) as tengioitinh,
        CONCAT(a.diachi, ", ", d.tenkhuvuc, ", ", c.tenkhuvuc) AS diachi, 
        b.dienthoai,
        DATE_FORMAT(b.ngaysinh,"%d/%m/%Y") AS namsinh');
        $query->from('vptk_hokhau AS a');
        $query->innerJoin('vptk_hokhau2nhankhau AS b ON b.quanhenhanthan_id = -1 AND b.daxoa = 0 AND a.id = b.hokhau_id');
        $query->innerJoin('danhmuc_khuvuc AS c ON c.id = a.phuongxa_id');
        $query->innerJoin('danhmuc_khuvuc AS d ON d.id = a.thonto_id');

        if (!empty($filters['phuongxa_id'])) {
            $query->where('a.phuongxa_id = ' . $db->quote($filters['phuongxa_id']));
        } elseif ($phanquyen['phuongxa_id'] != '-1') {
            $query->where('a.phuongxa_id = ' . $db->quote($phanquyen['phuongxa_id']));
        }
		
		if (!empty($filters['hoten'])) {
			$query->where($db->quoteName('b.hoten') . ' LIKE ' . $db->quote('%' . $filters['hoten'] . '%'));
		}
		if (!empty($filters['gioitinh_id'])) {
			$query->where($db->quoteName('b.gioitinh_id') . ' = ' . $db->quote($filters['gioitinh_id']));
		}
		if ($filters['is_tamtru'] !== '') {
			$query->where($db->quoteName('b.is_tamtru') . ' = ' . $db->quote($filters['is_tamtru']));
		}
		if (!empty($filters['thonto_id'])) {
			$query->where($db->quoteName('a.thonto_id') . ' = ' . $db->quote($filters['thonto_id']));
		}
		if (!empty($filters['hokhau_so'])) {
			$query->where($db->quoteName('a.hokhau_so') . ' LIKE ' . $db->quote('%' . $filters['hokhau_so'] . '%'));
		}
		if (!empty($filters['cccd_so'])) {
			$query->where($db->quoteName('b.cccd_so') . ' LIKE ' . $db->quote('%' . $filters['cccd_so'] . '%'));
		}
		if (!empty($filters['diachi'])) {
			$query->where($db->quoteName('a.diachi') . ' LIKE ' . $db->quote('%' . $filters['diachi'] . '%'));
		}
        $query->order('id ASC');
        $query->where('a.daxoa = 0');
        // echo $query;exit;
        // $query->setLimit(1000);
		$db->setQuery($query);
		return $db->loadAssocList();
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
}
