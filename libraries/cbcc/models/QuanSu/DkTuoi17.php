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
        'a.trangthaiquansu_id',
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

    if (!empty($filters['tinhtrang_id'])) {
      $query->where('a.trangthaiquansu_id = ' . (int) $filters['tinhtrang_id']);
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

  public function getDetailDkTuoi17($idDkTuoi17)
  {
    $db = Factory::getDbo();

    try {
      $query = $db->getQuery(true);
      $query->select([
        'a.id',
        'a.nhankhau_id',
        'a.n_hoten',
        'a.n_gioitinh_id',
        'a.n_cccd',
        'a.n_dienthoai',
        'a.n_dantoc_id',
        'a.n_tongiao_id',
        'a.n_phuongxa_id',
        'a.n_thonto_id',
        'a.n_diachi',
        'a.n_trinhdohocvan_id',
        'a.n_namsinh',
        'a.ngaydangky',
        'a.trangthaiquansu_id',
        'a.chieucao',
        'a.cannang',
        'a.tiensubenhtat',
        'a.noilamviec',
        'a.macbenh',
        'a.is_ngoai'
      ])
        ->from($db->quoteName('qs_dangkytuoi17', 'a'))
        ->where('a.id = ' . (int)$idDkTuoi17)
        ->where('a.daxoa = 0');

      $db->setQuery($query);
      $row = $db->loadObject();

      // Nếu có bản ghi và tồn tại nhankhau_id
      if ($row && !empty($row->nhankhau_id)) {
        $row->thannhan = $this->getThanNhan($row->nhankhau_id);
      } else {
        // Nếu không có nhankhau_id, lấy thân nhân từ bảng qs_thannhantuoi17
        $query = $db->getQuery(true);
        $query->select([
          'tn.id',
          'tn.hoten',
          'tn.namsinh',
          'tn.quanhenhanthan_id',
          'tn.nghenghiep_id',
        ])
          ->from($db->quoteName('qs_thannhantuoi17', 'tn'))
          ->where('tn.dangkytuoi17_id = ' . (int)$idDkTuoi17)
          ->where('tn.daxoa = 0');

        $db->setQuery($query);
        $row->thannhan = $db->loadObjectList();
      }

      return $row;
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public function saveDktuoi17($formdata, $idUser)
  {
    $db = Factory::getDbo();
    $now = Factory::getDate()->toSql();
    $id = $formdata['id'];

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
      'tiensubenhtat' => $formdata['thongtinsuckhoegiadinh'],
      'macbenh' => $formdata['thongtinsuckhoebanthan'],
      'daxoa' => 0
    ];

    if (!empty($formdata['tinhtrangdangky'])) {
      $columns['trangthaiquansu_id'] = $formdata['tinhtrangdangky'];
    }

    if (!empty($formdata['namsinh'])) {
      $columns['n_namsinh'] = (new \DateTime($formdata['namsinh']))->format('Y-m-d');
    }

    if (!empty($formdata['ngaydangky'])) {
      $columns['ngaydangky'] = (new \DateTime($formdata['ngaydangky']))->format('Y-m-d');
    }

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
          ->update($db->quoteName('qs_dangkytuoi17'))
          ->set($this->buildQuerySet($db, $columns))
          ->where($db->quoteName('id') . ' = ' . (int)$id);
        $db->setQuery($query)->execute();
      } else {
        $columns['nguoitao_id'] = (int)$idUser;
        $columns['ngaytao'] = $now;

        $query = $db->getQuery(true)
          ->insert($db->quoteName('qs_dangkytuoi17'))
          ->columns(array_keys($columns))
          ->values(implode(',', array_map([$db, 'quote'], array_values($columns))));
        $db->setQuery($query)->execute();
        $id = $db->insertid();
      }

      if ((int)$columns['is_ngoai'] === 1) {
        // Nếu đang cập nhật bản ghi có sẵn
        if ((int)$id > 0) {
          // Xóa thân nhân cũ liên kết với bản ghi này
            $queryDeleteTN = $db->getQuery(true)
            ->delete($db->quoteName('qs_thannhantuoi17'))
            ->where($db->quoteName('dangkytuoi17_id') . ' = ' . (int)$id);
            $db->setQuery($queryDeleteTN)->execute();
        }

        // Chỉ lưu nếu có thân nhân mới
        if (!empty($formdata['thannhan']) && is_array($formdata['thannhan'])) {
          foreach ($formdata['thannhan'] as $tn) {
            // Bỏ qua nếu không có thông tin gì
            if (empty($tn['hoten']) && empty($tn['namsinh']) && empty($tn['quanhe_id']) && empty($tn['nghenghiep'])) {
              continue;
            }

            $columnsTN = [
              'dangkytuoi17_id' => (int)$id,
              'hoten' => $tn['hoten'] ?? null,
              'namsinh' => !empty($tn['namsinh']) ? $tn['namsinh'] : null,
              'nghenghiep_id' => isset($tn['nghenghiep']) ? (int)$tn['nghenghiep'] : null,
              'quanhenhanthan_id' => isset($tn['quanhe_id']) ? (int)$tn['quanhe_id'] : null,
              'nguoitao_id' => (int)$idUser,
              'ngaytao' => $now,
              'daxoa' => 0,
            ];

            if (!empty($tn['nghenghiep'])) {
              $columns['nghenghiep_id'] = $tn['nghenghiep'];
            }


            $queryTN = $db->getQuery(true)
              ->insert($db->quoteName('qs_thannhantuoi17'))
              ->columns(array_keys($columnsTN))
              ->values(implode(',', array_map([$db, 'quote'], array_values($columnsTN))));
            $db->setQuery($queryTN)->execute();
          }
        }
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
      ->where('hk.daxoa = 0')
      ->where('nk.ngaysinh IS NOT NULL')
      ->where('nk.ngaysinh <= DATE_SUB(CURDATE(), INTERVAL 17 YEAR)')
      ->where('nk.ngaysinh > DATE_SUB(CURDATE(), INTERVAL 18 YEAR)');

    if ($nhankhau_id > 0) {
      $query->where('nk.id = ' . (int)$nhankhau_id);
    } else {
      if (!empty($keyword)) {
        $search = $db->quote('%' . $db->escape($keyword, true) . '%');
        // Dùng biểu thức có ngoặc để kết hợp OR đúng cách
        $query->where('(' . implode(' OR ', [
          "nk.hoten LIKE $search",
          "nk.cccd_so LIKE $search"
        ]) . ')');
      }

      if (!empty($phuongxa) && is_array($phuongxa)) {
        $phuongxa = array_map('intval', $phuongxa);
        $query->where('hk.phuongxa_id IS NOT NULL')
          ->where('hk.phuongxa_id IN (' . implode(',', $phuongxa) . ')');
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


  public function getThanNhan($nhankhauId)
  {
    $db = Factory::getDbo();

    try {
      $query = $db->getQuery(true);
      $query->select([
        $db->quoteName('nk.id'),
        $db->quoteName('nk.hoten'),
        $db->quoteName('nk.ngaysinh'),
        $db->quoteName('nk.is_chuho'),
        $db->quoteName('qh.tenquanhenhanthan'),
        $db->quoteName('nn.tennghenghiep')
      ])
        ->from($db->quoteName('vptk_hokhau2nhankhau', 'nk'))
        ->innerJoin($db->quoteName('vptk_hokhau2nhankhau', 'sub') . ' ON ' . $db->quoteName('nk.hokhau_id') . ' = ' . $db->quoteName('sub.hokhau_id'))
        ->leftJoin($db->quoteName('danhmuc_quanhenhanthan', 'qh') . ' ON ' . $db->quoteName('nk.quanhenhanthan_id') . ' = ' . $db->quoteName('qh.id'))
        ->leftJoin($db->quoteName('danhmuc_nghenghiep', 'nn') . ' ON ' . $db->quoteName('nk.nghenghiep_id') . ' = ' . $db->quoteName('nn.id'))
        ->where($db->quoteName('sub.id') . ' = ' . (int)$nhankhauId)
        ->order($db->quoteName('qh.sapxep') . ' ASC');

      $db->setQuery($query);
      return $db->loadObjectList();;
    } catch (Exception $e) {
      return $e->getMessage(); // Trả về thông báo lỗi giống hàm mẫu
    }
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

      if ($idNhanVien === 0 && $hoten === '' && $cccd === '') {
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
  public function deleteDktuoi17($idUser, $iddktuoi17)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->update('qs_dangkytuoi17')
      ->set('daxoa = 1')
      ->set('nguoixoa_id = ' . $db->quote($idUser))
      ->set('ngayxoa = NOW()')
      ->where('id =' . $db->quote($iddktuoi17));

    $db->setQuery($query);
    return $db->execute();
  }
}
