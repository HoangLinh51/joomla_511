<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class Vhytgd_Model_DoanHoi extends BaseDatabaseModel
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

  public function getPhanQuyenDoanHoi($userId)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('is_doanvien')
      ->from('jos_users')
      ->where('id = ' . $db->quote($userId));
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

  //get list Đoàn hội 
  public function getListDanhMucDoanHoi()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id,tendoanhoi')
      ->from('danhmuc_doanhoi')
      ->where('daxoa = 0 AND trangthai = 1');
    $db->setQuery($query);
    return $db->loadAssocList();
  }

  //get list chức danh
  public function getChucDanhTheoDoanHoi($idDoanHoi)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id,tenchucdanh')
      ->from('danhmuc_chucdanh ')
      ->where('daxoa = 0 AND module_id = 2')
      ->where('is_dung = ' . $idDoanHoi)
      ->order('sapxep ASC');
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
  public function getListDoanHoi($filters)
  {
    // Extract filter parameters
    $page = isset($filters['page']) ? (int)$filters['page'] : 1;
    $take = isset($filters['take']) ? (int)$filters['take'] : 20;
    $hoten = isset($filters['hoten']) ? trim($filters['hoten']) : '';
    $cccd = isset($filters['cccd']) ? trim($filters['cccd']) : '';
    $phuongxa_id = isset($filters['phuongxa_id']) ? (int)$filters['phuongxa_id'] : 0;
    $thonto_id = isset($filters['thonto_id']) ? (int)$filters['thonto_id'] : 0;
    $gioitinh_id = isset($filters['gioitinh_id']) ? (int)$filters['gioitinh_id'] : 0;
    $doanhoi_id = isset($filters['doanhoi']) ? (int)$filters['doanhoi'] : 0;

    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    // Select fields
    $query->select([
      'tvd.id',
      'tv.n_hoten',
      'tv.n_cccd',
      'tv.n_dienthoai',
      'tv.n_diachi',
      'tv.n_gioitinh_id',
      'tv.n_namsinh',
      'tvd.thoidiem_batdau',
      'tvd.thoidiem_ketthuc',
      'px.tenkhuvuc AS phuongxa_tenkhuvuc',
      'tt.tenkhuvuc AS thonto_tenkhuvuc',
      'cd.tenchucdanh',
      'tvd.chucvu_id',
      'gt.tengioitinh'
    ]);
    $query->from($db->quoteName('vhxhytgd_thanhviendoanhoi', 'tv'))
      ->leftJoin($db->quoteName('vhxhytgd_thanhvien2doanhoithamgia', 'tvd') . ' ON tvd.thanhviendoanhoi_id = tv.id')
      ->leftJoin($db->quoteName('danhmuc_khuvuc', 'px') . ' ON px.id = tv.n_phuongxa_id AND px.daxoa = 0')
      ->leftJoin($db->quoteName('danhmuc_khuvuc', 'tt') . ' ON tt.id = tv.n_thonto_id AND tt.daxoa = 0')
      ->leftJoin($db->quoteName('danhmuc_chucdanh', 'cd') . ' ON cd.id = tvd.chucvu_id AND cd.daxoa = 0 AND cd.module_id = 2')
      ->leftJoin($db->quoteName('danhmuc_gioitinh', 'gt') . ' ON gt.id = tv.n_gioitinh_id AND gt.daxoa = 0')
      ->where($db->quoteName('tvd.doanhoi_id') . ' = ' . (int)$doanhoi_id)
      ->where($db->quoteName('tvd.daxoa') . " = '0'");
    // Apply filters
    if (!empty($hoten)) {
      $query->where($db->quoteName('tv.n_hoten') . ' LIKE ' . $db->quote('%' . $db->escape($hoten) . '%'));
    }

    if (!empty($cccd)) {
      $query->where($db->quoteName('tv.n_cccd') . ' LIKE ' . $db->quote('%' . $db->escape($cccd) . '%'));
    }

    if ($phuongxa_id > 0) {
      $query->where($db->quoteName('tv.n_phuongxa_id') . ' = ' . (int)$phuongxa_id);
    }

    if ($thonto_id > 0) {
      $query->where($db->quoteName('tv.n_thonto_id') . ' = ' . (int)$thonto_id);
    }

    if ($gioitinh_id > 0) {
      $query->where($db->quoteName('tv.n_gioitinh_id') . ' = ' . (int)$gioitinh_id);
    }


    // Count total records
    $countQuery = clone $query;
    $countQuery->clear('select')->select('COUNT(DISTINCT tv.id)');
    $db->setQuery($countQuery);
    $totalRecord = $db->loadResult();

    // Apply pagination
    $offset = ($page - 1) * $take;
    $query->setLimit($take, $offset);

    // Order by
    $query->order($db->quoteName('tv.id') . ' DESC');

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
  public function getDetailDoanHoi($id)
  {
    if ($id <= 0) {
      throw new Exception('Invalid ID', 400);
    }

    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    // Select fields
    $query->select([
      'tvd.id',
      'tvd.thanhviendoanhoi_id',
      'tvd.doanhoi_id',
      'tvd.chucvu_id',
      'tvd.thoidiem_batdau',
      'tvd.thoidiem_ketthuc',
      'tvd.lydobiendong',
      'tvd.ghichu',
      'tv.nhankhau_id',
      'tv.n_hoten',
      'tv.n_gioitinh_id',
      'tv.n_cccd',
      'tv.n_namsinh',
      'tv.n_dienthoai',
      'tv.n_dantoc_id',
      'tv.n_tongiao_id',
      'tv.n_phuongxa_id',
      'tv.n_thonto_id',
      'tv.n_diachi',
      'tv.is_ngoai',
    ])
      ->from($db->quoteName('vhxhytgd_thanhvien2doanhoithamgia', 'tvd'))
      ->innerJoin($db->quoteName('vhxhytgd_thanhviendoanhoi', 'tv') . ' ON tv.id = tvd.thanhviendoanhoi_id')
      ->where($db->quoteName('tvd.id') . ' = ' . (int)$id)
      ->where($db->quoteName('tvd.daxoa') . ' = 0')
      ->where($db->quoteName('tv.daxoa') . ' = 0');

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

  public function checkNhankhauInDoanhoi($nhankhau_id, $doanhoi_id)
  {
    // Get database object
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    // Build query to check if nhankhau_id exists in doanhoi_id
    $query->select('COUNT(*)')
      ->from($db->quoteName('vhxhytgd_thanhviendoanhoi', 'tv'))
      ->leftJoin($db->quoteName('vhxhytgd_thanhvien2doanhoithamgia', 'tvd') . ' ON tvd.thanhviendoanhoi_id = tv.id')
      ->where($db->quoteName('tv.nhankhau_id') . ' = ' . (int)$nhankhau_id)
      ->where($db->quoteName('tvd.doanhoi_id') . ' = ' . (int)$doanhoi_id);

    // Execute query
    $db->setQuery($query);

    try {
      $count = $db->loadResult();
      return $count > 0;
    } catch (Exception $e) {
      throw new Exception('Lỗi truy vấn cơ sở dữ liệu: ' . $e->getMessage());
    }
  }

  public function saveThanhVienDoanHoi($formdata, $idUser)
  {
    $db = Factory::getDbo();
    $now = Factory::getDate()->toSql();
    $thamgiaId = (int)($formdata['id'] ?? 0); // ID bảng liên kết

    // Chuẩn bị dữ liệu lưu vào bảng thanhviendoanhoi
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
      'daxoa' => 0
    ];

    if (!empty($formdata['namsinh'])) {
      $columns['n_namsinh'] = (new \DateTime($formdata['namsinh']))->format('Y-m-d');
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
      $thanhvienId = 0;

      // Nếu truyền lên thamgiaId (id bảng liên kết), thì cần tìm thanhviendoanhoi_id trước
      if ($thamgiaId > 0) {
        $query = $db->getQuery(true)
          ->select($db->quoteName('thanhviendoanhoi_id'))
          ->from($db->quoteName('vhxhytgd_thanhvien2doanhoithamgia'))
          ->where($db->quoteName('id') . ' = ' . $thamgiaId)
          ->where($db->quoteName('daxoa') . ' = 0')
          ->setLimit(1);
        $db->setQuery($query);
        $thanhvienId = (int)$db->loadResult();

        if ($thanhvienId > 0) {
          // Cập nhật bảng thanhviendoanhoi
          $columns['nguoihieuchinh_id'] = (int)$idUser;
          $columns['ngayhieuchinh'] = $now;

          $query = $db->getQuery(true)
            ->update($db->quoteName('vhxhytgd_thanhviendoanhoi'))
            ->set($this->buildQuerySet($db, $columns))
            ->where($db->quoteName('id') . ' = ' . $thanhvienId);
          $db->setQuery($query)->execute();
        } else {
          throw new \RuntimeException('Không tìm thấy bản ghi đoàn hội để hiệu chỉnh.', 404);
        }
      } else {
        // Tạo mới
        $columns['nguoitao_id'] = (int)$idUser;
        $columns['ngaytao'] = $now;

        $query = $db->getQuery(true)
          ->insert($db->quoteName('vhxhytgd_thanhviendoanhoi'))
          ->columns(array_keys($columns))
          ->values(implode(',', array_map([$db, 'quote'], array_values($columns))));
        $db->setQuery($query)->execute();

        $thanhvienId = $db->insertid();
      }

      // Lưu bảng liên kết
      $this->saveDoanHoiThamGia($db, $formdata, $idUser, $thanhvienId, $now);

      $db->transactionCommit();
      return $thamgiaId ?: $thanhvienId; // có thể trả về id liên kết nếu cần
    } catch (\RuntimeException $e) {
      $db->transactionRollback();
      throw new \RuntimeException('Lỗi lưu dữ liệu: ' . $e->getMessage(), 500);
    }
  }
  public function saveDoanHoiThamGia($db, $formdata, $idUser, $thanhviendoanhoi_id, $now)
  {
    $thamgiaId = (int)($formdata['id'] ?? 0); // ID bảng liên kết

    $columns = [
      'thanhviendoanhoi_id' => (int)$thanhviendoanhoi_id,
      'doanhoi_id' => (int)$formdata['doanhoi_id'],
      'chucvu_id' => (int)$formdata['chucvu_id'],
      'lydobiendong' => $formdata['lydobiendong'],
      'ghichu' => $formdata['ghichu'],
    ];

    if (!empty($formdata['thoidiem_batdau'])) {
      $columns['thoidiem_batdau'] = $formdata['thoidiem_batdau'];
    }
    if (!empty($formdata['thoidiem_ketthuc'])) {
      $columns['thoidiem_ketthuc'] = $formdata['thoidiem_ketthuc'];
    }

    if ($thamgiaId > 0) {
      $columns['nguoihieuchinh_id'] = (int)$idUser;
      $columns['ngayhieuchinh'] = $now;

      $query = $db->getQuery(true)
        ->update($db->quoteName('vhxhytgd_thanhvien2doanhoithamgia'))
        ->set($this->buildQuerySet($db, $columns))
        ->where('id = ' . $thamgiaId);
      $db->setQuery($query)->execute();
    } else {
      $columns['nguoitao_id'] = (int)$idUser;
      $columns['ngaytao'] = $now;
      $columns['daxoa'] = 0;

      $query = $db->getQuery(true)
        ->insert($db->quoteName('vhxhytgd_thanhvien2doanhoithamgia'))
        ->columns(array_keys($columns))
        ->values(implode(',', array_map([$db, 'quote'], array_values($columns))));
      $db->setQuery($query)->execute();
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

  //xóa cơ sở dịch vụ nhạy cảm
  public function deleteDoanHoi($idUser, $idDoanHoi)
  {
    // var_dump($idDoanHoi);
    // exit;
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->update($db->quoteName('vhxhytgd_thanhvien2doanhoithamgia'))
      ->set('daxoa = 1')
      ->set('nguoixoa_id = ' . $db->quote($idUser))
      ->set('ngayxoa = NOW()')
      ->where('id = ' . $db->quote($idDoanHoi));
    // echo $query;
    // exit;
    $db->setQuery($query);
    $db->execute();
    return true;
  }
}
