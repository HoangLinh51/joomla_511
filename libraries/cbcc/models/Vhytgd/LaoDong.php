<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class Vhytgd_Model_LaoDong extends BaseDatabaseModel
{

  public function getTitle()
  {
    return "Tie";
  }

  public function getThonTobyPhuongxaId($phuongxa_id)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tenkhuvuc');
    $query->from('danhmuc_khuvuc');
    $query->where('daxoa = 0 AND cha_id = ' . $db->quote($phuongxa_id));
    $query->order('tenkhuvuc ASC');
    $db->setQuery($query);
    return $db->loadAssocList();
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
  public function getDoiTuong()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tendoituong')
      ->from('danhmuc_doituong')
      ->where('daxoa = 0')
      ->where('phanloai = 3');
    $db->setQuery($query);
    return $db->loadAssocList();
  }

  public function getListViThe()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tenvithe')
      ->from('danhmuc_vithelamviec')
      ->where('daxoa = 0');
    $db->setQuery($query);
    return $db->loadAssocList();
  }

  public function getListDoiTuong()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tendoituong')
      ->from('danhmuc_doituong')
      ->where('daxoa = 0')
      ->where('phanloai = 3');
    $db->setQuery($query);
    return $db->loadAssocList();
  }

  public function getListDoiTuongUuTien()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tendoituong')
      ->from('danhmuc_doituong')
      ->where('daxoa = 0')
      ->where('phanloai = 10');
    $db->setQuery($query);
    return $db->loadAssocList();
  }

  public function getListNgheNghiep()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id, tennghenghiep')
      ->from('danhmuc_nghenghiep')
      ->where('daxoa = 0');
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

  public function checkNhankhauInDsLaoDong($nhankhau_id)
  {
    // Get database object
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('COUNT(*)')
      ->from($db->quoteName('vhxhytgd_laodong'))
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

  //get list danh sách cơ sở dịch vụ nhạy cảm
  public function getDanhSachLaoDong($filters, $phuongxa)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select([
        'a.id',
        'a.n_hoten',
        'a.n_cccd',
        'a.n_dienthoai',
        'a.n_diachi',
        'dt.tendoituong',
        'px.tenkhuvuc as phuongxa',
        'tt.tenkhuvuc as thonto',
        'gt.tengioitinh'
      ])
      ->from($db->quoteName('vhxhytgd_laodong', 'a'))
      ->leftJoin($db->quoteName('danhmuc_doituong', 'dt') . ' ON a.doituonglaodong_id = dt.id')
      ->leftJoin($db->quoteName('danhmuc_khuvuc', 'px') . ' ON a.n_phuongxa_id = px.id')
      ->leftJoin($db->quoteName('danhmuc_khuvuc', 'tt') . ' ON a.n_thonto_id = tt.id')
      ->leftJoin($db->quoteName('danhmuc_gioitinh', 'gt') . ' ON a.n_gioitinh_id = gt.id')
      ->where('a.daxoa = 0');
    // var_dump($filters);
    // exit;

    $filterPhuongXaId = !empty($filters['phuongxa_id']) ? (int)$filters['phuongxa_id'] : null;

    if (!empty($phuongxa) && is_array($phuongxa)) {
      $phuongxaIds = array_map('intval', array_column($phuongxa, 'id'));

      if (!empty($phuongxaIds)) {
        if ($filterPhuongXaId !== null) {
          // Nếu có cả phân quyền và lọc người dùng → lọc giao nhau
          if (in_array($filterPhuongXaId, $phuongxaIds)) {
            $query->where('a.n_phuongxa_id = ' . $filterPhuongXaId);
          } else {
            // Không có quyền với phường xã được chọn → trả về rỗng
            $query->where('1 = 0'); // luôn sai
          }
        } else {
          // Chỉ lọc theo danh sách phân quyền
          $query->where('a.n_phuongxa_id IN (' . implode(',', $phuongxaIds) . ')');
        }
      }
    } elseif ($filterPhuongXaId !== null) {
      $query->where('a.n_phuongxa_id = ' . $filterPhuongXaId);
    } else {
      $query->where('a.n_phuongxa_id IN (SELECT id FROM danhmuc_phuongxa WHERE daxoa = 0)');
    }

    if (!empty($filters['hoten'])) {
      $query->where('a.n_hoten COLLATE utf8mb4_unicode_ci LIKE ' . $db->quote('%' . $filters['hoten'] . '%'));
    }

    if (!empty($filters['cccd'])) {
      $query->where('a.n_cccd LIKE ' . $db->quote('%' . $filters['cccd'] . '%'));
    }

    if (!empty($filters['gioitinh_id'])) {
      $query->where('a.n_gioitinh_id = ' . (int) $filters['gioitinh_id']);
    }

    if (!empty($filters['doituong_id'])) {
      $query->where('a.doituonglaodong_id = ' . (int) $filters['doituong_id']);
    }

    if (!empty($filters['thonto_id'])) {
      $query->where('a.n_thonto_id = ' . (int) $filters['thonto_id']);
    }

    // Lọc theo ngày khảo sát

    // Đếm tổng bản ghi
    $totalQuery = clone $query;
    $totalQuery->clear('select')->select('COUNT(DISTINCT a.id)');
    $db->setQuery($totalQuery);
    $totalRecord = (int) $db->loadResult();

    // Phân trang
    $take = max(1, (int)($filters['take'] ?? 20));
    $page = max(1, (int)($filters['page'] ?? 1));
    $offset = ($page - 1) * $take;

    $query->order('a.ngaytao DESC');
    $query->setLimit($take, $offset);

    $db->setQuery($query);
    $rows = $db->loadObjectList();

    return [
      'data' => $rows,
      'page' => $page,
      'take' => $take,
      'totalrecord' => $totalRecord
    ];
  }

  //get detail cơ sở dịch vụ nhạy cảm
  public function getDetailLaoDong($idLaoDong)
  {
    $db = Factory::getDbo();

    try {
      $query = $db->getQuery(true);
      $query->select([
        'ld.id',
        'ld.is_ngoai',
        'ld.nhankhau_id',
        'ld.n_hoten',
        'ld.n_gioitinh_id',
        'ld.n_cccd',
        'ld.n_namsinh',
        'ld.n_dienthoai',
        'ld.n_dantoc_id',
        'ld.n_tongiao_id',
        'ld.n_phuongxa_id',
        'ld.n_thonto_id',
        'ld.n_diachi',
        'ld.doituonguutien',
        'ld.bhxh',
        'ld.doituonglaodong_id',
        'ld.vithelamviec as vithe',
        'ld.nghenghiep_id',
        'ld.diachinoilamviec',
        'ld.gioithieuvieclam_id',
        'ld.thoigian_lamviec',
        'ld.is_hopdonglaodong',
        'ld.is_hokinhdoanh',
        'ld.is_dalamviec',
        'ld.lydokhonglaodong',
      ])
        ->from($db->quoteName('vhxhytgd_laodong', 'ld'))
        ->where('ld.id = ' . (int)$idLaoDong)
        ->where('ld.daxoa = 0');

      $db->setQuery($query);
      return $db->loadObject();
    } catch (Exception $e) {
      return $e->getMessage(); // hoặc throw lại nếu muốn controller xử lý
    }
  }

  //hàm lưu dịch vụ nhạy cảm
  public function saveLaoDong($formdata, $idUser)
  {
    $db = Factory::getDbo();
    $now = Factory::getDate()->toSql();
    $id = $formdata['id'];
    $columns = [
      'nhankhau_id' => (int)$formdata['nhankhau_id'],
      'n_hoten' => $formdata['hoten'],
      'doituonglaodong_id' => (int)$formdata['doituong_id'],
      'n_cccd' => $formdata['cccd'],
      'n_dienthoai' => $formdata['dienthoai'],
      'n_gioitinh_id' => (int)$formdata['gioitinh_id'],
      'n_dantoc_id' => (int)$formdata['dantoc_id'],
      'n_tongiao_id' => (int)$formdata['tongiao_id'],
      'n_phuongxa_id' => (int)$formdata['phuongxa_id'],
      'n_thonto_id' => (int)$formdata['thonto_id'],
      'n_diachi' => $formdata['diachi'],
      'is_hopdonglaodong' => $formdata['hopdonglaodong'],
      'is_hokinhdoanh' => $formdata['kinhdoanhcathe'],
      'daxoa' => 0
    ];

    // Các trường tùy chọn
    if (!empty($formdata['namsinh'])) {
      $columns['n_namsinh'] = (new \DateTime($formdata['namsinh']))->format('Y-m-d');
    }
    if (isset($formdata['bhxh'])) {
      $columns['bhxh'] = (int)$formdata['bhxh'];
    }
    if (isset($formdata['doituonguutien_id'])) {
      $columns['doituonguutien'] = (int)$formdata['doituonguutien_id'];
    }
    if (!empty($formdata['bhxh'])) {
      $columns['bhxh'] = $formdata['bhxh'];
    }
    if (isset($formdata['vithe_id'])) {
      $columns['vithelamviec'] = (int)$formdata['vithe_id'];
    }
    if (!empty($formdata['nghenghiep_id'])) {
      $columns['nghenghiep_id'] = (int)$formdata['nghenghiep_id'];
    }
    if (!empty($formdata['diachilamviec'])) {
      $columns['diachinoilamviec'] = $formdata['diachilamviec'];
    }
    if (!empty($formdata['phuongxagioithieu_id'])) {
      $columns['gioithieuvieclam_id'] = (int)$formdata['phuongxagioithieu_id'];
    }
    if (isset($formdata['datunglamviec'])) {
      $columns['is_dalamviec'] = (int)$formdata['datunglamviec'];
    }
    if (isset($formdata['thoigianlamviec'])) {
      $columns['thoigian_lamviec'] = (int)$formdata['thoigianlamviec'];
    }
    if (!empty($formdata['lydokhonglam'])) {
      $columns['lydokhonglaodong'] = $formdata['lydokhonglam'];
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
        // Cập nhật
        $columns['nguoihieuchinh_id'] = (int)$idUser;
        $columns['ngayhieuchinh'] = $now;
        $query = $db->getQuery(true)
          ->update($db->quoteName('vhxhytgd_laodong'))
          ->set($this->buildQuerySet($db, $columns))
          ->where($db->quoteName('id') . ' = ' . (int)$id);
        $db->setQuery($query)->execute();
      } else {
        // Tạo mới
        $columns['nguoitao_id'] = (int)$idUser;
        $columns['ngaytao'] = $now;
        $query = $db->getQuery(true)
          ->insert($db->quoteName('vhxhytgd_laodong'))
          ->columns(array_keys($columns))
          ->values(implode(',', array_map([$db, 'quote'], array_values($columns))));
        $db->setQuery($query)->execute();
        $id = $db->insertid();
      }
      $db->transactionCommit();
      return $id;
    } catch (\RuntimeException $e) {
      $db->transactionRollback();
      throw new \RuntimeException('Lỗi lưu dữ liệu: ' . $e->getMessage(), 500);
    }
  }

  private function buildQuerySet($db, $data, $exclude = [])
  {
    $setParts = [];
    foreach ($data as $col => $val) {
      if (in_array($col, $exclude)) {
        continue;
      }
      $setParts[] = $db->quoteName($col) . ' = ' . $db->quote($val);
    }
    return implode(', ', $setParts);
  }


  //xóa cơ sở dịch vụ nhạy cảm
  public function deleteLaoDong($idUser, $idNguoiLaoDong)
  {
    try {
      $db = Factory::getDbo();
      $query = $db->getQuery(true)
        ->update('vhxhytgd_laodong')
        ->set('daxoa = 1')
        ->set('nguoixoa_id = ' . $db->quote($idUser))
        ->set('ngayxoa = NOW()')
        ->where('id =' . $db->quote($idNguoiLaoDong));

      $db->setQuery($query);
      return $db->execute();
    } catch (\Exception $e) {
      throw new \RuntimeException('Lỗi xóa dữ liệu: ' . $e->getMessage(), 500);
    }
  }
  public function getThongKeGiaLaoDong($params = array())
  {
    $db = Factory::getDbo();

    // 1. Subquery thống kê theo thôn
    $queryThon = $db->getQuery(true);
    $queryThon->select([
      'a.n_thonto_id AS khuvuc_id',
      'COUNT(DISTINCT a.id) AS tong_nhankhau',
      'SUM(a.doituonglaodong_id = 8) AS covieclam',
      'SUM(a.doituonglaodong_id = 9) AS chuacovieclam',
      'SUM(a.doituonglaodong_id = 10) AS khongthamgialaodong'
    ])
      ->from('vhxhytgd_laodong AS a')
      ->where('a.daxoa = 0')
      ->group('a.n_thonto_id'); // Thêm GROUP BY cho subquery thôn

    // 2. Subquery thống kê tổng hợp phường
    $queryPhuong = $db->getQuery(true);
    $queryPhuong->select([
      $db->quote($params['phuongxa_id']) . ' AS khuvuc_id',
      'COUNT(DISTINCT a.id) AS tong_nhankhau',
      'SUM(a.doituonglaodong_id = 8) AS covieclam',
      'SUM(a.doituonglaodong_id = 9) AS chuacovieclam',
      'SUM(a.doituonglaodong_id = 10) AS khongthamgialaodong'
    ])
      ->from('vhxhytgd_laodong AS a')
      ->where('a.daxoa = 0');

    // Áp dụng điều kiện chung
    if (!empty($params['phuongxa_id'])) {
      $phuongxaId = $db->quote($params['phuongxa_id']);
      $queryThon->where('a.n_phuongxa_id = ' . $phuongxaId);
      $queryPhuong->where('a.n_phuongxa_id = ' . $phuongxaId);
    }

    if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
      $thontoIds = array_map([$db, 'quote'], $params['thonto_id']);
      $queryThon->where('a.n_thonto_id IN (' . implode(',', $thontoIds) . ')');
      $queryPhuong->where('a.n_thonto_id IN (' . implode(',', $thontoIds) . ')');
    }

    if (!empty($params['doituong_id'])) {
      $doituongId = $db->quote($params['doituong_id']);
      $queryThon->where('a.doituonguutien = ' . $doituongId);
      $queryPhuong->where('a.doituonguutien = ' . $doituongId);
    }

    // Kết hợp 2 subquery bằng UNION ALL
    $unionQuery = $queryThon->union($queryPhuong);

    // Query chính
    $query = $db->getQuery(true);
    $query->select([
      'a.id',
      'a.cha_id',
      'a.tenkhuvuc',
      'a.level',
      'COALESCE(SUM(ab.tong_nhankhau), 0) AS tong_nhankhau',
      'COALESCE(SUM(ab.covieclam), 0) AS covieclam',
      'COALESCE(SUM(ab.chuacovieclam), 0) AS chuacovieclam',
      'COALESCE(SUM(ab.khongthamgialaodong), 0) AS khongthamgialaodong'
    ])
      ->from('danhmuc_khuvuc AS a')
      ->leftJoin('(' . $unionQuery . ') AS ab ON a.id = ab.khuvuc_id');

    // Điều kiện query chính
    $where = [];
    if (!empty($params['phuongxa_id'])) {
      $phuongxaId = $db->quote($params['phuongxa_id']);
      $where[] = '(a.id = ' . $phuongxaId . ' OR a.cha_id = ' . $phuongxaId . ')';

      $inIds = [$phuongxaId];
      if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
        $inIds = array_merge($inIds, array_map([$db, 'quote'], $params['thonto_id']));
      }
      $where[] = 'a.id IN (' . implode(',', $inIds) . ')';
    }

    if (!empty($where)) {
      $query->where(implode(' AND ', $where));
    }

    $query->group(['a.id', 'a.cha_id', 'a.tenkhuvuc', 'a.level'])
      ->order('a.level, a.id ASC');
    // echo $query;
    $db->setQuery($query);
    return $db->loadAssocList();
  }
}
