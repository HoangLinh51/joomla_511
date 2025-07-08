<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class Vhytgd_Model_DichVuNhayCam extends BaseDatabaseModel
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
  public function getTrangThaiHoatDong()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select('a.id,a.tentrangthaihoatdong')
      ->from('danhmuc_trangthaihoatdong AS a')
      ->where('a.daxoa = 0');
    $db->setQuery($query);
    return $db->loadAssocList();
  }

  //get list danh sách cơ sở dịch vụ nhạy cảm
  public function getListDichVuNhayCam($filters, $phuongxa)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select([
        'a.id',
        'a.coso_ten',
        'a.coso_diachi',
        'a.chucoso_ten',
        'a.chucoso_cccd',
        'a.chucoso_dienthoai',
        'tt.tentrangthaihoatdong'
      ])
      ->from($db->quoteName('vhxhytgd_cosonhaycam', 'a'))
      ->leftJoin($db->quoteName('danhmuc_trangthaihoatdong', 'tt') . ' ON a.trangthaihoatdong_id = tt.id')
      ->leftJoin($db->quoteName('danhmuc_phuongxa', 'px') . ' ON a.phuongxa_id = px.id')
      ->leftJoin($db->quoteName('danhmuc_khuvuc', 'kv') . ' ON a.thonto_id = kv.id')
      ->where('a.daxoa = 0');


    $filterPhuongXaId = !empty($filters['phuongxa_id']) ? (int)$filters['phuongxa_id'] : null;

    if (!empty($phuongxa) && is_array($phuongxa)) {
      $phuongxaIds = array_map('intval', array_column($phuongxa, 'id'));

      if (!empty($phuongxaIds)) {
        if ($filterPhuongXaId !== null) {
          // Nếu có cả phân quyền và lọc người dùng → lọc giao nhau
          if (in_array($filterPhuongXaId, $phuongxaIds)) {
            $query->where('a.phuongxa_id = ' . $filterPhuongXaId);
          } else {
            // Không có quyền với phường xã được chọn → trả về rỗng
            $query->where('1 = 0'); // luôn sai
          }
        } else {
          // Chỉ lọc theo danh sách phân quyền
          $query->where('a.phuongxa_id IN (' . implode(',', $phuongxaIds) . ')');
        }
      }
    } elseif ($filterPhuongXaId !== null) {
      $query->where('a.phuongxa_id = ' . $filterPhuongXaId);
    } else {
      $query->where('a.phuongxa_id IN (SELECT id FROM danhmuc_phuongxa WHERE daxoa = 0)');
    }

    if (!empty($filters['tencoso'])) {
      $query->where('a.coso_ten COLLATE utf8mb4_unicode_ci LIKE ' . $db->quote('%' . $filters['tencoso'] . '%'));
    }

    if (!empty($filters['tenchucoso'])) {
      $query->where('a.chucoso_ten COLLATE utf8mb4_unicode_ci LIKE ' . $db->quote('%' . $filters['tenchucoso'] . '%'));
    }

    if (!empty($filters['thonto_id'])) {
      $query->where('a.thonto_id = ' . (int) $filters['thonto_id']);
    }

    if (!empty($filters['trangthai_id'])) {
      $query->where('a.trangthaihoatdong_id = ' . (int) $filters['trangthai_id']);
    }

    // Lọc theo ngày khảo sát
    if (!empty($filters['batdau']) && !empty($filters['ketthuc'])) {
      $batdau = $db->quote($filters['batdau']);
      $ketthuc = $db->quote($filters['ketthuc']);
      $query->where("a.ngaykhaosat BETWEEN $batdau AND $ketthuc");
    } elseif (!empty($filters['batdau'])) {
      $query->where('a.ngaykhaosat >= ' . $db->quote($filters['batdau']));
    } elseif (!empty($filters['ketthuc'])) {
      $query->where('a.ngaykhaosat <= ' . $db->quote($filters['ketthuc']));
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
  public function saveDichVuNhayCam($formdata, $idUser)
  {
    $db = Factory::getDbo();
    $id = (int) ($formdata['id'] ?? 0);
    $now = Factory::getDate()->toSql();

    $columns = [
      'coso_ten' => $formdata['tencoso'] ?? '',
      'phuongxa_id' => (int) ($formdata['phuongxa_id'] ?? 0),
      'thonto_id' => (int) ($formdata['thonto_id'] ?? 0),
      'coso_diachi' => $formdata['diachi'] ?? '',
      'ngaykhaosat' => !empty($formdata['ngaykhaosat'])
        ? (new \DateTime(str_replace('/', '-', $formdata['ngaykhaosat'])))->format('Y-m-d')
        : null,
      'trangthaihoatdong_id' => (int) ($formdata['trangthai_id'] ?? 0),
      'chucoso_ten' => $formdata['hoten_chucoso'] ?? '',
      'chucoso_cccd' => $formdata['cccd_chucoso'] ?? '',
      'chucoso_dienthoai' => $formdata['sodienthoai_chucoso'] ?? '',
      'ngaytao' => $now,
      'nguoitao_id' => $idUser,
      'daxoa' => 0,
    ];

    $db->transactionStart();
    try {
      if ($id > 0) {
        $query = $db->getQuery(true)
          ->update($db->quoteName('vhxhytgd_cosonhaycam'))
          ->set($this->buildQuerySet($db, $columns))
          ->where('id = ' . $db->quote($id));
      } else {
        $query = $db->getQuery(true)
          ->insert($db->quoteName('vhxhytgd_cosonhaycam'))
          ->columns(array_keys($columns))
          ->values(implode(',', array_map([$db, 'quote'], array_values($columns))));
      }
      $db->setQuery($query)->execute();
      if ($id == 0) {
        $id = $db->insertid();
      }

      $this->saveNhanVien($db, $formdata['nhanvien'] ?? [], $idUser, $id, $now);

      $db->transactionCommit();
      return $id;
    } catch (\RuntimeException $e) {
      $db->transactionRollback();
      throw new \RuntimeException($e->getMessage(), 500);
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

  //get danh sách cơ sở dv nhạy cảm để xuất excel
  public function getDataExportExcel($filters)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select([
        'a.id',
        'a.coso_ten',
        'a.coso_diachi',
        'a.chucoso_ten',
        'a.chucoso_cccd',
        'a.chucoso_dienthoai',
        'tt.tentrangthaihoatdong',
      ])
      ->from($db->quoteName('vhxhytgd_cosonhaycam', 'a'))
      ->leftJoin($db->quoteName('danhmuc_trangthaihoatdong', 'tt') . ' ON a.trangthaihoatdong_id = tt.id')
      ->leftJoin($db->quoteName('danhmuc_phuongxa', 'px') . ' ON a.phuongxa_id = px.id')
      ->leftJoin($db->quoteName('danhmuc_khuvuc', 'kv') . ' ON a.thonto_id = kv.id')
      ->where('a.daxoa = 0');

    $filterPhuongXaId = !empty($filters['phuongxa_id']) ? (int)$filters['phuongxa_id'] : null;

    if (!empty($phuongxa) && is_array($phuongxa)) {
      $phuongxaIds = array_map('intval', array_column($phuongxa, 'id'));

      if (!empty($phuongxaIds)) {
        if ($filterPhuongXaId !== null) {
          // Nếu có cả phân quyền và lọc người dùng → lọc giao nhau
          if (in_array($filterPhuongXaId, $phuongxaIds)) {
            $query->where('a.phuongxa_id = ' . $filterPhuongXaId);
          } else {
            // Không có quyền với phường xã được chọn → trả về rỗng
            $query->where('1 = 0'); // luôn sai
          }
        } else {
          // Chỉ lọc theo danh sách phân quyền
          $query->where('a.phuongxa_id IN (' . implode(',', $phuongxaIds) . ')');
        }
      }
    } elseif ($filterPhuongXaId !== null) {
      $query->where('a.phuongxa_id = ' . $filterPhuongXaId);
    } else {
      $query->where('a.phuongxa_id IN (SELECT id FROM danhmuc_phuongxa WHERE daxoa = 0)');
    }

    if (!empty($filters['tencoso'])) {
      $query->where('a.coso_ten COLLATE utf8_general_ci LIKE ' . $db->quote('%' . $filters['tencoso'] . '%'));
    }

    if (!empty($filters['tenchucoso'])) {
      $query->where('a.chucoso_ten COLLATE utf8mb4_unicode_ci LIKE ' . $db->quote('%' . $filters['tenchucoso'] . '%'));
    }

    if (!empty($filters['thonto_id'])) {
      $query->where('a.thonto_id = ' . (int) $filters['thonto_id']);
    }

    if (!empty($filters['trangthai_id'])) {
      $query->where('a.trangthaihoatdong_id = ' . (int) $filters['trangthai_id']);
    }

    // Lọc theo ngày khảo sát
    if (!empty($filters['ngaybatdau']) && !empty($filters['ngayketthuc'])) {
      $batdau = $db->quote($filters['ngaybatdau']);
      $ketthuc = $db->quote($filters['ngayketthuc']);
      $query->where("a.ngaykhaosat BETWEEN $batdau AND $ketthuc");
    } elseif (!empty($filters['batdau'])) {
      $query->where('a.ngaykhaosat >= ' . $db->quote($filters['batdau']));
    } elseif (!empty($filters['ngayketthuc'])) {
      $query->where('a.ngaykhaosat <= ' . $db->quote($filters['ngayketthuc']));
    }

    $query->order('a.ngaytao DESC');
    $db->setQuery($query);
    return $db->loadObjectList();
  }
}
