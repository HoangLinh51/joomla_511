<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class Dcxddt_Model_XeOm extends BaseDatabaseModel
{

  public function getTitle()
  {
    return "Tie";
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

  //get phân quyền
  public function getPhanQuyen()
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

  public function getListDanhMucLoaiXe()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tenloaixe')
      ->from('danhmuc_loaixe')
      ->where('daxoa =  0');
    $db->setQuery($query);
    return $db->loadAssocList();
  }

  public function getDanhMucTinhTrangThe(){
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tentinhtrang')
      ->from('danhmuc_tinhtrangthe')
      ->where('daxoa = 0 AND trangthai = 1');
    $db->setQuery($query);
    return $db->loadAssocList();
  }

  //get list phường xã theo quyền user 
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

  public function getDanhMucGioiTinh()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tengioitinh')
      ->from('danhmuc_gioitinh')
      ->where('daxoa = 0 AND trangthai = 1');
    $db->setQuery($query);
    return $db->loadAssocList();
  }

  //get list dân tộc 
  public function getDanToc()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id,tendantoc')
      ->from('danhmuc_dantoc ')
      ->where('daxoa = 0 AND trangthai = 1');
    $db->setQuery($query);
    return $db->loadAssocList();
  }

  //get list tôn giáo
  public function getTonGiao()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id,tentongiao')
      ->from('danhmuc_tongiao ')
      ->where('daxoa = 0 AND trangthai = 1');
    $db->setQuery($query);
    return $db->loadAssocList();
  }

  //get list danh sách các thành viên đoàn hội đang được phân quyền 
  public function getListXeOm($filters)
  {
    // Extract filter parameters
    $page = isset($filters['page']) ? (int)$filters['page'] : 1;
    $take = isset($filters['take']) ? (int)$filters['take'] : 20;
    $hoten = isset($filters['hoten']) ? trim($filters['hoten']) : '';
    $cccd = isset($filters['cccd']) ? trim($filters['cccd']) : '';
    $phuongxa_id = isset($filters['phuongxa_id']) ? (int)$filters['phuongxa_id'] : 0;
    $thonto_id = isset($filters['thonto_id']) ? (int)$filters['thonto_id'] : 0;
    $gioitinh_id = isset($filters['gioitinh_id']) ? (int)$filters['gioitinh_id'] : 0;

    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    // Select fields
    $query->select([
      'a.id',
      'a.n_hoten',
      'a.n_cccd',
      'a.n_dienthoai',
      'a.n_diachi',
      'gt.tengioitinh',
      'a.tinhtrangthe_id',
      'ttt.tentinhtrang'
    ]);
    $query->from($db->quoteName('dcxddtmt_xeom', 'a'))
      ->leftJoin($db->quoteName('danhmuc_tinhtrangthe', 'ttt') . ' ON ttt.id = a.tinhtrangthe_id')
      ->leftJoin($db->quoteName('danhmuc_gioitinh', 'gt') . ' ON gt.id = a.n_gioitinh_id AND gt.daxoa = 0')
      ->where('a.daxoa = 0');
    // Apply filters
    if (!empty($hoten)) {
      $query->where($db->quoteName('a.n_hoten') . ' LIKE ' . $db->quote('%' . $db->escape($hoten) . '%'));
    }

    if (!empty($cccd)) {
      $query->where($db->quoteName('a.n_cccd') . ' LIKE ' . $db->quote('%' . $db->escape($cccd) . '%'));
    }

    if ($phuongxa_id > 0) {
      $query->where($db->quoteName('a.n_phuongxa_id') . ' = ' . (int)$phuongxa_id);
    }

    if ($thonto_id > 0) {
      $query->where($db->quoteName('a.n_thonto_id') . ' = ' . (int)$thonto_id);
    }

    if ($gioitinh_id > 0) {
      $query->where($db->quoteName('a.n_gioitinh_id') . ' = ' . (int)$gioitinh_id);
    }

    // Count total records
    $countQuery = clone $query;
    $countQuery->clear('select')->select('COUNT(DISTINCT a.id)');
    $db->setQuery($countQuery);
    $totalRecord = $db->loadResult();

    // Apply pagination
    $offset = ($page - 1) * $take;
    $query->setLimit($take, $offset);

    // Order by
    $query->order($db->quoteName('a.id') . ' DESC');

    // Execute query
    $db->setQuery($query);
    $rows = $db->loadObjectList();

    // Prepare response
    return [
      'data' => $rows,
      'page' => $page,
      'take' => $take,
      'totalrecord' => $totalRecord
    ];
  }

  //get detail đoàn hội
  public function getDetailXeOm($id)
  {
    if ($id <= 0) {
      throw new Exception('Invalid ID', 400);
    }

    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    // Select fields
    $query->select([
      'id',
      'nhankhau_id',
      'biensoxe',
      'loaixe_id',
      'sogiaypheplaixe',
      'thehanhnghe_so',
      'thehanhnghe_ngayhethan',
      'tinhtrangthe_id',
      'n_hoten',
      'n_namsinh',
      'n_cccd',
      'n_gioitinh_id',
      'n_diachi',
      'n_dienthoai',
      'n_dantoc_id',
      'n_tongiao_id',
      'n_phuongxa_id',
      'n_thonto_id',
      'is_ngoai',
    ])
      ->from($db->quoteName('dcxddtmt_xeom'))
      ->where($db->quoteName('id') . ' = ' . (int)$id)
      ->where('daxoa = 0');

    try {
      $db->setQuery($query);
      $row = $db->loadObject();
    } catch (Exception $e) {
      throw new Exception('Database error: ' . $e->getMessage(), 500);
    }

    if (!$row) {
      throw new Exception('Record not found', 404);
    }

    // Prepare response
    return [
      'data' => $row
    ];
  }

  //get thông tin nhân viên
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

  public function checkNhankhauInXeOm($nhankhau_id)
  {
    // Get database object
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('COUNT(*)')
      ->from($db->quoteName('dcxddtmt_xeom'))
      ->where($db->quoteName('nhankhau_id') . ' = ' . (int)$nhankhau_id);

    // Execute query
    $db->setQuery($query);

    try {
      $count = $db->loadResult();
      return $count > 0;
    } catch (Exception $e) {
      throw new Exception('Lỗi truy vấn cơ sở dữ liệu: ' . $e->getMessage());
    }
  }

  public function saveXeOm($formdata, $idUser)
  {
    $db = Factory::getDbo();
    $now = Factory::getDate()->toSql();
    $id = $formdata['id'];

    $columns = [
      'n_hoten' => $formdata['modal_hoten'],
      'n_cccd' => $formdata['modal_cccd'],
      'n_dienthoai' => $formdata['modal_dienthoai'],
      'n_gioitinh_id' => (int)$formdata['gioitinh_id'],
      'n_dantoc_id' => (int)$formdata['dantoc_id'],
      'n_tongiao_id' => (int)$formdata['tongiao_id'],
      'n_phuongxa_id' => (int)$formdata['phuongxa_id'],
      'n_thonto_id' => (int)$formdata['thonto_id'],
      'n_diachi' => $formdata['modal_diachi'],
      'biensoxe' => $formdata['modal_biensoxe'],
      'thehanhnghe_so' => $formdata['modal_sothehanhnghe'],
      'sogiaypheplaixe' => $formdata['giayphep'],
      'daxoa' => 0
    ];

    if (!empty($formdata['loaixe_id'])) {
      $columns['loaixe_id'] = $formdata['loaixe_id'];
    }
    if (!empty($formdata['modal_namsinh'])) {
      $columns['n_namsinh'] = (new \DateTime($formdata['modal_namsinh']))->format('Y-m-d');
    }
    if (!empty($formdata['modal_ngayhethan_thehanhnghe'])){
      $columns['thehanhnghe_ngayhethan'] =  (new \DateTime($formdata['modal_ngayhethan_thehanhnghe']))->format('Y-m-d');
    }
    if (!empty($formdata['tinhtrang_id'])) {
      $columns['tinhtrangthe_id'] = $formdata['tinhtrang_id'];
    }

    // Xác định là người ngoài hay có nhân khẩu
    if (empty($formdata['nhankhau_id']) || $formdata['nhankhau_id'] == '0') {
      $columns['is_ngoai'] = 1;
      $columns['nhankhau_id'] = 0;
    } else {
      $columns['is_ngoai'] = 0;
      $columns['nhankhau_id'] = (int)$formdata['nhankhau_id'];
    }
    $db->transactionStart();
    try {
      if ($id > 0) {
        $columns['nguoihieuchinh_id'] = (int)$idUser;
        $columns['ngayhieuchinh'] = $now;

        $query = $db->getQuery(true)
          ->update($db->quoteName('dcxddtmt_xeom'))
          ->set($this->buildQuerySet($db, $columns))
          ->where($db->quoteName('id') . ' = ' . $formdata['id']);
        $db->setQuery($query)->execute();
      } else {
        // Tạo mới
        $columns['nguoitao_id'] = (int)$idUser;
        $columns['ngaytao'] = $now;

        $query = $db->getQuery(true)
          ->insert($db->quoteName('dcxddtmt_xeom'))
          ->columns(array_keys($columns))
          ->values(implode(',', array_map([$db, 'quote'], array_values($columns))));
        $db->setQuery($query)->execute();

        $id =  $db->insertid();
      }

      $db->transactionCommit();
      return $id;
    } catch (\RuntimeException $e) {
      $db->transactionRollback();
      throw new \RuntimeException('Lỗi lưu dữ liệu: ' . $e->getMessage(), 500);
    }
  }

  public function buildQuerySet($db, $columns)
  {
    $set = [];
    foreach ($columns as $key => $value) {
      $set[] = $db->quoteName($key) . ' = ' . (is_null($value) ? 'NULL' : $db->quote($value));
    }
    return $set;
  }

  //xóa tài xế xe ôm 
  public function deleteXeOm($idUser, $idTaixe)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->update($db->quoteName('dcxddtmt_xeom'))
      ->set('daxoa = 1')
      ->set('nguoixoa_id = ' . $db->quote($idUser))
      ->set('ngayxoa = NOW()')
      ->where('id = ' . $db->quote($idTaixe));
    $db->setQuery($query);
    $db->execute();
    return true;
  }
}
