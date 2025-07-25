<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class QuanSu_Model_Dknvqs extends BaseDatabaseModel
{

  public function getTitle()
  {
    return "Tie";
  }

  public function getListDknvqs($filters, $phuongxa)
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
      ->from($db->quoteName('qs_dangkyquansu', 'a'))
      ->leftJoin($db->quoteName('danhmuc_trangthaiquansu', 'ttqs') . ' ON a.trangthaiquansu_id = ttqs.id')
      ->leftJoin($db->quoteName('danhmuc_khuvuc', 'px') . ' ON a.n_phuongxa_id = px.id')
      ->leftJoin($db->quoteName('danhmuc_khuvuc', 'tt') . ' ON a.n_thonto_id = tt.id')
      ->leftJoin($db->quoteName('danhmuc_gioitinh', 'gt') . ' ON a.n_gioitinh_id = gt.id')
      ->where('a.daxoa = 0');

    $phuongxaIds = !empty($phuongxa) && is_array($phuongxa)
      ? array_map('intval', array_column($phuongxa, 'id'))
      : [];

    if (!empty($filters['phuongxa_id'])) {
      $query->where('a.n_phuongxa_id = ' . $filters['phuongxa_id']);
    } else {
      // Không có phường xã filter → dùng danh sách phân quyền
      if (!empty($phuongxaIds)) {
        $query->where('a.n_phuongxa_id IN (' . implode(',', $phuongxaIds) . ')');
      } else {
        // Nếu không có phân quyền nào thì có thể lấy tất cả hoặc 1=0 tùy yêu cầu
        $query->where('a.n_phuongxa_id IN (SELECT id FROM danhmuc_phuongxa WHERE daxoa = 0)');
      }
    }

    if (!empty($filters['hoten'])) {
      $query->where('a.n_hoten COLLATE utf8mb4_unicode_ci LIKE ' . $db->quote('%' . $filters['hoten'] . '%'));
    }

    if (!empty($filters['cccd'])) {
      $query->where('a.n_cccd COLLATE utf8mb4_unicode_ci LIKE ' . $db->quote('%' . $filters['cccd'] . '%'));
    }

    if (!empty($filters['doituong_id'])) {
      $query->where('a.trangthaiquansu_id = ' . (int) $filters['doituong_id']);
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

  public function getDetailDknvqs($idDknvqs)
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
        'a.n_phuongxa_id',
        'a.n_thonto_id',
        'a.n_diachi',
        'a.trinhdohocvan_id',
        'a.n_namsinh',
        'a.ngaydangky',
        'a.trangthaiquansu_id',
        'a.nghenghiep_id',
        'a.noilamviec',
        'a.ghichu',
        'a.is_ngoai'
      ])
        ->from($db->quoteName('qs_dangkyquansu', 'a'))
        ->where('a.id = ' . (int)$idDknvqs)
        ->where('a.daxoa = 0');

      $db->setQuery($query);
      $row = $db->loadObject();

      // nếu có bản ghi và tồn tại nhankhau_id
      if ($row && !empty($row->nhankhau_id)) {
        $row->thannhan = $this->getThanNhan($row->nhankhau_id);
      } else {
        $query = $db->getQuery(true);
        $query->select([
          'tn.id',
          'tn.hoten',
          'tn.namsinh',
          'tn.quanhenhanthan_id',
          'tn.nghenghiep_id',
        ])
          ->from($db->quoteName('qs_thannhanquansu', 'tn'))
          ->where('tn.dangkyquansu_id = ' . (int)$idDknvqs)
          ->where('tn.daxoa = 0');

        $db->setQuery($query);
        $row->thannhan = $db->loadObjectList();
      }

      return $row;
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public function saveDknvqs($formdata, $idUser)
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
      'noilamviec' => (int)$formdata['noilamviec'],
      'trinhdohocvan_id' => (int)$formdata['trinhdohocvan_id'],
      'trangthaiquansu_id' => $formdata['doituong_id'],
      'ghichu' => $formdata['ghichu'],
      'daxoa' => 0
    ];
    if (!empty($formdata['nghenghiep_id'])) {
      $columns['nghenghiep_id'] = $formdata['nghenghiep_id'];
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
          ->update($db->quoteName('qs_dangkyquansu'))
          ->set($this->buildQuerySet($db, $columns))
          ->where($db->quoteName('id') . ' = ' . (int)$id);
        $db->setQuery($query)->execute();
      } else {
        $columns['nguoitao_id'] = (int)$idUser;
        $columns['ngaytao'] = $now;

        $query = $db->getQuery(true)
          ->insert($db->quoteName('qs_dangkyquansu'))
          ->columns(array_keys($columns))
          ->values(implode(',', array_map([$db, 'quote'], array_values($columns))));
        $db->setQuery($query)->execute();
        $id = $db->insertid();
      }

      if ((int)$columns['is_ngoai'] === 1) {
        // nếu đang cập nhật bản ghi có sẵn
        if ((int)$id > 0) {
          // xóa thân nhân cũ liên kết với bản ghi này
            $queryDeleteTN = $db->getQuery(true)
            ->delete($db->quoteName('qs_thannhanquansu'))
            ->where($db->quoteName('dangkyquansu_id') . ' = ' . (int)$id);
            $db->setQuery($queryDeleteTN)->execute();
        }

        // chỉ lưu nếu có thân nhân mới
        if (!empty($formdata['thannhan']) && is_array($formdata['thannhan'])) {
          foreach ($formdata['thannhan'] as $tn) {
            // bỏ qua nếu không có thông tin gì
            if (empty($tn['hoten']) && empty($tn['namsinh']) && empty($tn['quanhe_id']) && empty($tn['nghenghiep'])) {
              continue;
            }

            $columnsTN = [
              'dangkyquansu_id' => (int)$id,
              'namsinh' => !empty($tn['namsinh']) ? $tn['namsinh'] : null,
              'nghenghiep_id' => isset($tn['nghenghiep']) ? (int)$tn['nghenghiep'] : null,
              'hoten' => $tn['hoten'] ?? null,
              'quanhenhanthan_id' => isset($tn['quanhe_id']) ? (int)$tn['quanhe_id'] : null,
              'nguoitao_id' => (int)$idUser,
              'ngaytao' => $now,
              'daxoa' => 0,
            ];

            $queryTN = $db->getQuery(true)
              ->insert($db->quoteName('qs_thannhanquansu'))
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
      ->where('nk.ngaysinh <= DATE_SUB(CURDATE(), INTERVAL 18 YEAR)')
      ->where('nk.ngaysinh > DATE_SUB(CURDATE(), INTERVAL 28 YEAR)');

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

  public function deleteDknvqs($idUser, $iddknvqs)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->update('qs_dangkyquansu')
      ->set('daxoa = 1')
      ->set('nguoixoa_id = ' . $db->quote($idUser))
      ->set('ngayxoa = NOW()')
      ->where('id =' . $db->quote($iddknvqs));

    $db->setQuery($query);
    return $db->execute();
  }
   public function getThongKeDknvqs($params = array())
  {
    $db = Factory::getDbo();

    // Subquery
    $query_left = $db->getQuery(true);
    $query_left->select('count(a.nhankhau_id) as nhankhau_id, a.n_phuongxa_id,d.tenkhuvuc AS tenphuongxa,a.n_thonto_id,c.tenkhuvuc AS tenthonto');
    $query_left->from('qs_dangkyquansu AS a');
    $query_left->innerJoin('danhmuc_khuvuc AS c ON a.n_thonto_id = c.id');
    $query_left->innerJoin('danhmuc_khuvuc AS d ON a.n_phuongxa_id = d.id');
    $query_left->where('a.daxoa = 0 ');
    // Điều kiện WHERE cho subquery
    if (!empty($params['phuongxa_id'])) {
      $query_left->where('a.n_phuongxa_id = ' . $db->quote($params['phuongxa_id']));
    }

    if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
      $query_left->where($db->quoteName('a.n_thonto_id') . ' IN (' . implode(',', array_map([$db, 'quote'], $params['thonto_id'])) . ')');
    }
    if (!empty($params['hinhthuc_id'])) {
      $query_left->where('b.is_hinhthuc = ' . $db->quote($params['hinhthuc_id']));
    }

    if (!empty($params['loaidoituong_id'])) {
      $query_left->where('a.trangthaiquansu_id = ' . $db->quote($params['loaidoituong_id']));
    }
    // Query chính
    $query = $db->getQuery(true);
    $query->select(['a.id,a.cha_id,a.tenkhuvuc,a.level, SUM(ab.nhankhau_id) as soluongdoanhoi'])
      ->from('danhmuc_khuvuc AS a')
      ->leftJoin('(' . $query_left . ') AS ab ON (a.id = ab.n_thonto_id OR a.id = ab.n_phuongxa_id)');

    // Điều kiện cho query chính
    if (!empty($params['phuongxa_id'])) {
      $query->where($db->quoteName('a.id') . ' = ' . $db->quote($params['phuongxa_id']) . ' OR ' . $db->quoteName('a.cha_id') . ' = ' . $db->quote($params['phuongxa_id']));
    }
    if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
      $query->where($db->quoteName('a.id') . ' IN (' . implode(',', array_map([$db, 'quote'], $params['thonto_id'])) . ')');
    }

    $query->group(['a.id', 'a.cha_id', 'a.tenkhuvuc', 'a.level']);
    $query->order('a.level, a.id ASC');
    // echo $query;
    $db->setQuery($query);
    $results = $db->loadAssocList();



    return $results;
  }
}
