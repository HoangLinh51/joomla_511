<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class QuanSu_Model_Base extends BaseDatabaseModel
{

  public function getTitle()
  {
    return "Tie";
  }

  //get phân quyền
  public function getPhanquyen()
  {
    $user_id = Factory::getUser()->id;
    $db = Factory::getContainer()->get('DatabaseDriver');
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
  public function getThonTobyPhuongxaId($phuongxa_id)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id,tenkhuvuc');
    $query->from('danhmuc_khuvuc');
    $query->where('daxoa = 0 AND cha_id = ' . $db->quote($phuongxa_id));
    $query->order('tenkhuvuc ASC');
    $db->setQuery($query);
    return $db->loadAssocList();
  }

  //get phường xã theo quyền user 
  public function getPhuongXaById($id)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('a.id,a.tenkhuvuc,a.cha_id AS quanhuyen_id,b.cha_id AS tinhthanh_id,a.level');
    $query->from('danhmuc_khuvuc AS a');
    $query->innerJoin('danhmuc_khuvuc AS b ON a.cha_id = b.id');
    if ($id == '-1') {
      $query->where('a.level = 2 AND a.daxoa = 0');
    } else {
      $query->where('a.level = 2 AND a.daxoa = 0 AND a.id IN (' . $id . ')');
    }
    $query->order('tenkhuvuc ASC');
    $db->setQuery($query);
    return $db->loadAssocList();
  }
 
  //get trạng thái hoạt động
  public function getDanhMucGioiTinh()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tengioitinh')
      ->from('danhmuc_gioitinh')
      ->where('daxoa = 0');
    $db->setQuery($query);
    return $db->loadAssocList();
  }

  public function getDanhMucTrangThai()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tentrangthai')
      ->from('danhmuc_trangthaiquansu')
      ->where('type = 1')
      ->where('daxoa = 0');
    $db->setQuery($query);
    return $db->loadAssocList();
  }
  public function getDanhMucDoiTuong()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tentrangthai')
      ->from('danhmuc_trangthaiquansu')
      ->where('type = 2')
      ->where('daxoa = 0');
    $db->setQuery($query);
    return $db->loadAssocList();
  }


  public function getDanhMucDanToc()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tendantoc')
      ->from('danhmuc_dantoc')
      ->where('daxoa = 0');
    $db->setQuery($query);
    return $db->loadAssocList();
  }
  public function getDanhMucQuanHeThanNhan()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tenquanhenhanthan')
      ->from('danhmuc_quanhenhanthan')
      ->where('daxoa = 0')
      ->where('sapxep IS NOT NULL')
      ->order('sapxep ASC');
    $db->setQuery($query);
    return $db->loadAssocList();
  }

  public function getDanhMucNgheNghiep()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tennghenghiep')
      ->from('danhmuc_nghenghiep')
      ->where('daxoa = 0')
      ->order('id ASC');
    $db->setQuery($query);
    return $db->loadAssocList();
  }
  
  public function getDanhMucTrinhDoHocVan()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tentrinhdohocvan')
      ->from('danhmuc_trinhdohocvan')
      ->where('daxoa = 0')
      ->where('sapxep IS NOT NULL')
      ->order('sapxep ASC');
    $db->setQuery($query);
    return $db->loadAssocList();
  }

  public function checkNhankhauInDanhSachQuanSu($nhankhau_id, $table)
  {
    // Get database object
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('COUNT(*)')
      ->from($db->quoteName('qs_dangkytuoi17'))
      ->where($db->quoteName('nhankhau_id') . ' = ' . (int)$nhankhau_id)
      ->where('daxoa = 0');

    // Execute query
    $db->setQuery($query);

    try {
      $count = $db->loadResult();
      return $count > 0;
    } catch (Exception $e) {
      throw new Exception('Lỗi truy vấn cơ sở dữ liệu: ' . $e->getMessage());
    }
  }
}