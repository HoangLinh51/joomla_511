<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class QuanSu_Model_DkTuoi17 extends BaseDatabaseModel
{

  public function getTitle()
  {
    return "Tie";
  }

  //get list danh sách cơ sở dịch vụ nhạy cảm
  public function getListDktuoi17($filters)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select([
      'a.id',
      'a.n_hoten',
      'a.n_cccd',
      'a.n_dienthoai',
      'a.n_diachi',
      'ttqs.tentrangthai',
      'px.tenkhuvuc as phuongxa',
      'tt.tenkhuvuc as thonto',
      'gt.tengioitinh'
      ])
      ->from($db->quoteName('qs_dangkytuoi17', 'a'))
      ->leftJoin($db->quoteName('danhmuc_trangthaiquansu', 'ttqs') . ' ON a.trangthaiquansu_id = ttqs.id')
      ->leftJoin($db->quoteName('danhmuc_khuvuc', 'px') . ' ON a.n_phuongxa_id = px.id')
      ->leftJoin($db->quoteName('danhmuc_khuvuc', 'tt') . ' ON a.n_thonto_id = tt.id')
      ->leftJoin($db->quoteName('danhmuc_gioitinh', 'gt') . ' ON a.n_gioitinh_id = gt.id')
      ->where('a.daxoa = 0');



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
      $query->where('a.n_cccd COLLATE utf8mb4_unicode_ci LIKE ' . $db->quote('%' . $filters['cccd'] . '%'));
    }

    if (!empty($filters['trangthai_id'])) {
      $query->where('a.trangthaiquansu_id = ' . (int) $filters['trangthai_id']);
    }
    
    if (!empty($filters['gioitinh_id'])) {
      $query->where('a.n_gioitinh_id = ' . (int) $filters['gioitinh_id']);
    }

    if (!empty($filters['thonto_id'])) {
      $query->where('a.n_thonto_id = ' . (int) $filters['thonto_id']);
    }

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
  public function getDetailDichVuNhayCam($idcoso)
  {
    $db = Factory::getDbo();

    try {
      $query = $db->getQuery(true);
      $query->select([
        'cs.id',
        'cs.coso_ten',
        'cs.coso_diachi',
        'cs.ngaykhaosat',
        'cs.phuongxa_id',
        'cs.thonto_id',
        'cs.trangthaihoatdong_id',
        'tt.tentrangthaihoatdong',
        'cs.chucoso_ten',
        'cs.chucoso_cccd',
        'cs.chucoso_dienthoai'
      ])
        ->from($db->quoteName('vhxhytgd_cosonhaycam', 'cs'))
        ->leftJoin($db->quoteName('danhmuc_trangthaihoatdong', 'tt') . ' ON tt.id = cs.trangthaihoatdong_id')
        ->where('cs.id = ' . (int)$idcoso)
        ->where('cs.daxoa = 0');

      $db->setQuery($query);
      $coso = $db->loadObject();

      if (!$coso) {
        return null;
      }

      $queryNhanVien = $db->getQuery(true);
      $queryNhanVien->select([
        'nv.nhankhau_id',
        'nv.tennhanvien',
        'gt.tengioitinh',
        'nv.cccd',
        'nv.dienthoai',
        'nv.is_thuongtru',
        'nv.diachi',
        'nv.trangthai'
      ])
        ->from($db->quoteName('vhxhytgd_cosonhaycam2nhanvien', 'nv'))
        ->leftJoin($db->quoteName('danhmuc_gioitinh', 'gt') . ' ON gt.id = nv.gioitinh_id')
        ->where('nv.cosonhaycam_id = ' . (int)$idcoso)
        ->where('nv.daxoa = 0');

      $db->setQuery($queryNhanVien);
      $nhanviens = $db->loadObjectList();

      return (object)[
        'id' => $coso->id,
        'coso_ten' => $coso->coso_ten,
        'coso_diachi' => $coso->coso_diachi,
        'ngaykhaosat' => date('d/m/Y', strtotime($coso->ngaykhaosat)),
        'phuongxa_id' => $coso->phuongxa_id,
        'thonto_id' => $coso->thonto_id,
        'trangthaihoatdong_id' => $coso->trangthaihoatdong_id,
        'tentrangthaihoatdong' => $coso->tentrangthaihoatdong,
        'chucoso_ten' => $coso->chucoso_ten,
        'chucoso_cccd' => $coso->chucoso_cccd,
        'chucoso_dienthoai' => $coso->chucoso_dienthoai,
        'nhanvien' => $nhanviens
      ];
    } catch (Exception $e) {
      return $e->getMessage(); // hoặc throw lại nếu muốn controller xử lý
    }
  }

  //get thông tin nhân viên
  public function getDanhSachNhanKhau($formSearch, $phuongxa)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select([
        'nk.id',
        'nk.hoten',
        'hk.diachi',
        'dg.tengioitinh',
        'nk.cccd_so',
        'nk.dienthoai',
        'nk.is_tamtru'
      ])
      ->from($db->quoteName('vptk_hokhau2nhankhau', 'nk'))
      ->leftJoin($db->quoteName('vptk_hokhau', 'hk') . ' ON nk.hokhau_id = hk.id')
      ->leftJoin($db->quoteName('danhmuc_gioitinh', 'dg') . ' ON nk.gioitinh_id = dg.id')
      ->where('nk.daxoa = 0')
      ->where('hk.daxoa = 0')
      ->where('TIMESTAMPDIFF(YEAR, nk.ngaysinh, CURDATE()) >= 18')
      ->order('nk.hokhau_id DESC');

    $filterPhuongXaId = !empty($formSearch['modal_phuongxaid']) ? (int)$formSearch['modal_phuongxaid'] : null;

    // Phân quyền
    if (!empty($phuongxa) && is_array($phuongxa)) {
      $phuongxaIds = array_map('intval', array_column($phuongxa, 'id'));

      if (!empty($phuongxaIds)) {
        if ($filterPhuongXaId !== null) {
          if (in_array($filterPhuongXaId, $phuongxaIds)) {
            $query->where('hk.phuongxa_id = ' . $filterPhuongXaId);
          } else {
            $query->where('1 = 0'); // Không có quyền → trả về rỗng
          }
        } else {
          $query->where('hk.phuongxa_id IN (' . implode(',', $phuongxaIds) . ')');
        }
      }
    } elseif ($filterPhuongXaId !== null) {
      $query->where('hk.phuongxa_id = ' . $filterPhuongXaId);
    }

    // họ tên nhân khẩu
    if (!empty($formSearch['modal_tennhankhau'])) {
      $query->where('nk.hoten LIKE ' . $db->quote('%' . $formSearch['modal_tennhankhau'] . '%'));
    }

    // CCCD
    if (!empty($formSearch['modal_cccd'])) {
      $query->where('nk.cccd_so LIKE ' . $db->quote('%' . $formSearch['modal_cccd'] . '%'));
    }

    // thôn tổ
    if (!empty($formSearch['modal_thontoid'])) {
      $query->where('hk.thonto_id = ' . (int)$formSearch['modal_thontoid']);
    }

    // tổng bảng ghi
    $totalQuery = clone $query;
    $totalQuery->clear('select')->select('COUNT(DISTINCT nk.id)');
    $db->setQuery($totalQuery);
    $totalRecord = (int) $db->loadResult();

    // pagiation
    $take = max(1, (int)($formSearch['take'] ?? 20));
    $page = max(1, (int)($formSearch['page'] ?? 1));
    $offset = ($page - 1) * $take;

    $query->setLimit($take, $offset);

    $db->setQuery($query);
    $rows = $db->loadObjectList();

    return [
      'data' => $rows,
      'page' => $page,
      'take' => $take,
      'totalrecord' => $totalRecord,
    ];
  }

  //hàm lưu dịch vụ nhạy cảm
  public function saveDktuoi17($formdata, $idUser)
  {
    $db = Factory::getDbo();
    $now = Factory::getDate()->toSql();
    $id = $formdata['id'];
    // var_dump($formdata);
    // exit;
    $columns = [
      'nhankhau_id' => (int)$formdata['nhankhau_id'],
      'n_hoten' => $formdata['hoten'],
      'n_gioitinh_id' => (int)$formdata['gioitinh'],
      'n_cccd' => $formdata['cccd'],
      'n_dienthoai' => $formdata['dienthoai'],
      'n_dantoc_id' => (int)$formdata['dantoc_id'],
      'n_phuongxa_id' => (int)$formdata['phuongxa_id'],
      'n_thonto_id' => (int)$formdata['thonto_id'],
      'n_diachi' => $formdata['diachi'],
      'n_trinhdohocvan_id' => (int)$formdata['trinhdohocvan_id'],
      'noilamviec' => $formdata['noilamviec'],
      'chieucao' => $formdata['chieucao'],
      'cannang' => $formdata['cannang'],
      'trangthaiquansu_id' => $formdata['tinhtrangdangky'],
      'tiensubenhtat' => $formdata['thongtinsuckhoegiadinh'],
      'macbenh' => $formdata['thongtinsuckhoebanthan'],
      'daxoa' => 0
    ];

    // Các trường tùy chọn
    if (!empty($formdata['namsinh'])) {
      $columns['n_namsinh'] = (new \DateTime($formdata['namsinh']))->format('Y-m-d');
    }
    if (!empty($formdata['ngaydangky'])) {
      $columns['ngaydangky'] = (new \DateTime($formdata['ngaydangky']))->format('Y-m-d');
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
          ->update($db->quoteName('qs_dangkytuoi17'))
          ->set($this->buildQuerySet($db, $columns))
          ->where($db->quoteName('id') . ' = ' . (int)$id);
        $db->setQuery($query)->execute();
      } else {
        // Tạo mới
        $columns['nguoitao_id'] = (int)$idUser;
        $columns['ngaytao'] = $now;
        $query = $db->getQuery(true)
          ->insert($db->quoteName('qs_dangkytuoi17'))
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

  //sau khi hàm lưu dvnc chạy thì lưu user
  public function saveNhanVien($db, $nhanviens, $idUser, $coso_id, $now)
  {
    // Xoá tất cả nhân viên cũ của cơ sở
    $query = $db->getQuery(true)
      ->delete($db->quoteName('vhxhytgd_cosonhaycam2nhanvien'))
      ->where($db->quoteName('cosonhaycam_id') . ' = ' . (int) $coso_id);
    $db->setQuery($query)->execute();

    // Chèn lại danh sách nhân viên
    foreach ($nhanviens as $nv) {
      $idNhanVien = (int)($nv['id_nhanvien'] ?? 0);
      $hoten = trim($nv['hoten_nhanvien'] ?? '');
      $cccd = trim($nv['cccd_nhanvien'] ?? '');

      if ($idNhanVien === 0 && $hoten === '' && $cccd === '' ) {
        continue; // Bỏ qua bản ghi rỗng
      }

      $columns = [
        'cosonhaycam_id' => (int)$coso_id,
        'tennhanvien' => $hoten,
        'nhankhau_id' => $idNhanVien,
        'gioitinh_id' => (int)($nv['gioitinh_nhanvien'] ?? 0),
        'cccd' => $cccd,
        'dienthoai' => $nv['dienthoai_nhanvien'] ?? '',
        'diachi' => $nv['diachi_nhanvien'] ?? '',
        'is_thuongtru' => (int)($nv['tinhtrang_cutru_nhanvien'] ?? 0),
        'trangthai' => (int)($nv['trangthai_nhanvien'] ?? 0),
        'nguoitao_id' => (int)$idUser,
        'ngaytao' => $now,
        'daxoa' => 0,
      ];

      $query = $db->getQuery(true)
        ->insert($db->quoteName('vhxhytgd_cosonhaycam2nhanvien'))
        ->columns(array_keys($columns))
        ->values(implode(',', array_map([$db, 'quote'], array_values($columns))));
      $db->setQuery($query)->execute();
    }
  }
  
  //xóa cơ sở dịch vụ nhạy cảm
  public function deleteDichVuNhayCam($idUser, $idDichVuNhayCam)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->update('vhxhytgd_cosonhaycam')
      ->set('daxoa = 1')
      ->set('nguoixoa_id = ' . $db->quote($idUser))
      ->set('ngayxoa = NOW()')
      ->where('id =' . $db->quote($idDichVuNhayCam));

    $db->setQuery($query);
    return $db->execute();
  }

}
