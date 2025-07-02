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


  public function getDanhSachNhanKhau($phuongxa = [], $keyword = '', $limit = 10, $offset = 0, $nhankhau_id = 0)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select([
        'nk.id',
        'nk.hoten',
        'nk.cccd_so',
        'nk.ngaysinh',
        'nk.dienthoai',
        'hk.diachi',
        'nk.gioitinh_id',
        'nk.dantoc_id',
        'nk.tongiao_id',
        'hk.phuongxa_id',
        'hk.thonto_id',
        'hk.diachi',
      ])
      ->from($db->quoteName('vptk_hokhau2nhankhau', 'nk'))
      ->leftJoin($db->quoteName('vptk_hokhau', 'hk') . ' ON nk.hokhau_id = hk.id')
      ->where('nk.daxoa = 0')
      ->where('hk.daxoa = 0');

    if ($nhankhau_id > 0) {
      $query->where('nk.id = ' . (int)$nhankhau_id);
    } else {
      if (!empty($keyword)) {
        $search = $db->quote('%' . $db->escape($keyword, true) . '%');
        $query->where("nk.hoten LIKE $search OR nk.cccd_so LIKE $search");
      }
      if (!empty($phuongxa) && is_array($phuongxa)) {
        $phuongxa = array_map('intval', $phuongxa);
        // Chỉ lấy những bản ghi có phường xã nằm trong danh sách, loại bỏ các bản ghi phường xã null hoặc không thuộc danh sách
        $query->where('hk.phuongxa_id IS NOT NULL AND hk.phuongxa_id IN (' . implode(',', $phuongxa) . ')');
      }
    }
    $query->order('nk.hokhau_id DESC');

    // Clone query để đếm tổng số
    $countQuery = clone $query;
    $countQuery->clear('select')->select('COUNT(*)');

    $db->setQuery($countQuery);
    $total = (int) $db->loadResult();

    // Lấy dữ liệu trang hiện tại
    $query->setLimit($limit, $offset);
    $db->setQuery($query);
    $items = $db->loadObjectList();

    return [
      'items' => $items,
      'has_more' => ($offset + count($items)) < $total
    ];
  }

  public function checkNhankhauInDSDkTuoi17($nhankhau_id)
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