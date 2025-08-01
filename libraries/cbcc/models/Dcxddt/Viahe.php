<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class Dcxddt_Model_Viahe extends BaseDatabaseModel
{

  public function getTitle()
  {
    return "Tie";
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

  public function getDanhSachViaHe($formdata, $phuongxa)
  {
    $page = isset($filters['page']) ? (int)$filters['page'] : 1;
    $take = isset($filters['take']) ? (int)$filters['take'] : 20;
    $diachi = isset($formdata['diachi']) ? trim($formdata['diachi']) : '';
    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    $query->select([
      'a.id',
      'a.hoten',
      'a.dienthoai',
      'a.diachi',
      'gp.sogiayphep',
      'a.dientichtamthoi',
      'tthd.id as id_hopdong',
      'tthd.solan',
      'tthd.ngayhethan',
    ]);
    $query->from($db->quoteName('dcxddtmt_viahe_thongtinviahe', 'a'))
      ->leftJoin($db->quoteName('dcxddtmt_viahe_giayphep', 'gp') . ' ON gp.thongtinviahe_id = a.id')
      ->leftJoin($db->quoteName('dcxddtmt_viahe_thongtinhopdong', 'tthd') . ' ON tthd.giayphep_id = gp.id')
      ->where('a.daxoa = 0')
      ->where('tthd.daxoa = 0');

    $phuongxaIds = !empty($phuongxa) && is_array($phuongxa)
      ? array_map('intval', array_column($phuongxa, 'id'))
      : [];

    if (!empty($phuongxaIds)) {
      $query->where('a.phuongxa_id IN (' . implode(',', $phuongxaIds) . ')');
    } else {
      // Nếu không có phân quyền nào thì có thể lấy tất cả hoặc 1=0 tùy yêu cầu
      $query->where('a.phuongxa_id IN (SELECT id FROM danhmuc_phuongxa WHERE daxoa = 0)');
    }

    if (!empty($diachi)) {
      $query->where($db->quoteName('a.diachi') . ' LIKE ' . $db->quote('%' . $db->escape($diachi) . '%'));
    }

    $countQuery = clone $query;
    $countQuery->clear('select')->select('COUNT(DISTINCT a.id)');
    $db->setQuery($countQuery);
    $totalRecord = $db->loadResult();

    $offset = ($page - 1) * $take;
    $query->setLimit($take, $offset);

    $query->order($db->quoteName('tthd.giayphep_id') . ' ASC');
    $query->order($db->quoteName('tthd.id') . ' ASC');
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

  public function getThongtinViahe($id)
  {
    $infoData = $this->getThongtinViaheChung($id);
    if (!$infoData) return null;

    $hopDongData = $this->getHopDongViahe($id);

    return [
      'thongtin' => $infoData['thongtin'],
      'filedinhkem' => $infoData['filedinhkem'],
      'giayphep' => $hopDongData
    ];
  }

  public function getThongtinViaheChung($id)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query
      ->select([
        'ttv.id AS thongtinviahe_id',
        'ttv.hoten',
        'ttv.dienthoai',
        'ttv.diachi',
        'ttv.dientichtamthoi',
        'ttv.chieudai',
        'ttv.chieurong',
        'ttv.mucdichsudung',
        'ttv.diachithuongtru',
        'DATE_FORMAT(ttv.ngaysinh, "%d/%m/%Y") AS ngaysinh',
        'ttv.cccd',
        'DATE_FORMAT(ttv.ngaycap_cccd, "%d/%m/%Y") AS ngaycap_cccd',
        'ttv.noicap_cccd',
        'ttv.phuongxa_id',
      ])
      ->from('dcxddtmt_viahe_thongtinviahe AS ttv')
      ->where('ttv.id = ' . (int)$id)
      ->where('ttv.daxoa = 0');

    $db->setQuery($query);
    $info = $db->loadAssoc();

    if (!$info) return null;

    // File đính kèm
    $query2 = $db->getQuery(true);
    $query2
      ->select([
        'fd.filedinhkem_id AS id',
        'att.filename',
        'att.code',
        'att.folder',
        'att.mime'
      ])
      ->from('dcxddtmt_viahe_filedinhkem AS fd')
      ->leftJoin('core_attachment AS att ON att.id = fd.filedinhkem_id')
      ->where('fd.thongtinviahe_id = ' . (int)$id)
      ->where('fd.daxoa = 0');

    $db->setQuery($query2);
    $attachments = $db->loadAssocList();

    return [
      'thongtin' => $info,
      'filedinhkem' => $attachments
    ];
  }

  public function getHopDongViahe($id)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query
      ->select([
        'gp.id AS giayphep_id',
        'gp.sogiayphep',
        'hd.id AS hopdong_id',
        'DATE_FORMAT(hd.ngayky, "%d/%m/%Y") AS ngayky',
        'DATE_FORMAT(hd.ngayhethan, "%d/%m/%Y") AS ngayhethan',
        'hd.sotien',
        'hd.tinhtrang',
        'hd.ghichu'
      ])
      ->from('dcxddtmt_viahe_giayphep AS gp')
      ->leftJoin('dcxddtmt_viahe_thongtinhopdong AS hd ON hd.giayphep_id = gp.id AND hd.daxoa = 0')
      ->where('gp.thongtinviahe_id = ' . (int)$id)
      ->where('gp.daxoa = 0')
      ->order('hd.id ASC');

    $db->setQuery($query);
    $rows = $db->loadAssocList();

    $giayphep = [];

    foreach ($rows as $row) {
      if (!empty($row['giayphep_id'])) {
        $sogiayphep = $row['sogiayphep'];
        if (!isset($giayphep[$sogiayphep])) {
          $giayphep[$sogiayphep] = [];
        }

        if (!empty($row['hopdong_id'])) {
          $giayphep[$sogiayphep][] = [
            'id_hopdong' => $row['hopdong_id'],
            'ngayky' => $row['ngayky'],
            'ngayhethan' => $row['ngayhethan'],
            'sotien' => $row['sotien'],
            'tinhtrang' => $row['tinhtrang'],
            'ghichu' => $row['ghichu'],
          ];
        }
      }
    }
    return $giayphep;
  }

  public function saveThongtinViahe($formdata, $phuongxa)
  {
    $db = Factory::getDbo();
    $userId = Factory::getUser()->id;
    $now = Factory::getDate()->toSql();
    $id = (int)($formdata['id'] ?? 0);
    $columns = [
      'hoten' => $formdata['hoten'],
      'dienthoai' => $formdata['sodienthoai'],
      'diachi' => $formdata['diachiviahe'],
      'dientichtamthoi' => $formdata['dientichtamthoi'],
      'chieudai' => $formdata['chieudai'],
      'chieurong' => $formdata['chieurong'],
      'mucdichsudung' => $formdata['mucdichsudung'],
      'diachithuongtru' => $formdata['diachi'],
      'cccd' => $formdata['cccd'],
      'noicap_cccd' => $formdata['cccd_noicap'],
      'phuongxa_id' => (int)$phuongxa,
      'daxoa' => 0
    ];

    if (!empty($formdata['select_namsinh'])) {
      $columns['ngaysinh'] = $this->convertToDate($formdata['select_namsinh']);
    }
    if (!empty($formdata['cccd_ngaycap'])) {
      $columns['ngaycap_cccd'] = $this->convertToDate($formdata['cccd_ngaycap']);
    }

    $db->transactionStart();

    try {
      // 🔸 INSERT or UPDATE bảng thongtinviahe
      if ($id > 0) {
        $columns['nguoihieuchinh_id'] = (int)$userId;
        $columns['ngayhieuchinh'] = $now;

        $query = $db->getQuery(true)
          ->update($db->quoteName('dcxddtmt_viahe_thongtinviahe'))
          ->set($this->buildQuerySet($db, $columns))
          ->where($db->quoteName('id') . ' = ' . $db->quote($id));
        $db->setQuery($query)->execute();
      } else {
        $columns['nguoitao_id'] = (int)$userId;
        $columns['ngaytao'] = $now;

        $query = $db->getQuery(true)
          ->insert($db->quoteName('dcxddtmt_viahe_thongtinviahe'))
          ->columns(array_keys($columns))
          ->values(implode(',', array_map([$db, 'quote'], array_values($columns))));
        $db->setQuery($query)->execute();
        $id = $db->insertid();
      }

      $query = $db->getQuery(true)
        ->delete($db->quoteName('dcxddtmt_viahe_filedinhkem'))
        ->where($db->quoteName('thongtinviahe_id') . ' = ' . (int)$id);
      $db->setQuery($query)->execute();

      if (!empty($formdata['idFile-uploadImageHopDong'])) {
        foreach ($formdata['idFile-uploadImageHopDong'] as $fileId) {
          $query = $db->getQuery(true)
            ->insert($db->quoteName('dcxddtmt_viahe_filedinhkem'))
            ->columns([
              $db->quoteName('thongtinviahe_id'),
              $db->quoteName('filedinhkem_id'),
              $db->quoteName('daxoa')
            ])
            ->values(implode(',', [(int)$id, (int)$fileId ,0]));
          $db->setQuery($query)->execute();
        }
      }
      if (!empty($formdata['giayphep'])) {
        foreach ($formdata['giayphep'] as $soGiayPhep => $hopdongs) {
          // 1. Kiểm tra giấy phép đã tồn tại chưa
          $query = $db->getQuery(true)
            ->select('id')
            ->from($db->quoteName('dcxddtmt_viahe_giayphep'))
            ->where($db->quoteName('thongtinviahe_id') . ' = ' . (int)$id)
            ->where($db->quoteName('sogiayphep') . ' = ' . $db->quote($soGiayPhep))
            ->where($db->quoteName('daxoa') . ' = 0');
          $db->setQuery($query);
          $giayphep_id = (int)$db->loadResult();

          // 2. Nếu chưa có thì thêm mới
          if ($giayphep_id <= 0) {
            $columnsGP = [
              'thongtinviahe_id' => $id,
              'sogiayphep' => $soGiayPhep,
              'daxoa' => 0,
              'nguoitao_id' => (int)$userId,
              'ngaytao' => $now
            ];
            $query = $db->getQuery(true)
              ->insert($db->quoteName('dcxddtmt_viahe_giayphep'))
              ->columns(array_keys($columnsGP))
              ->values(implode(',', array_map([$db, 'quote'], array_values($columnsGP))));
            $db->setQuery($query)->execute();
            $giayphep_id = $db->insertid();
          }

          // 3. Xử lý từng hợp đồng trong giấy phép này
          foreach ($hopdongs as $hd) {
            $hopdongId = (int)($hd['id_hopdong'] ?? 0);
            $ngayky = $this->convertToDate($hd['ngayKyStr']);
            $ngayhethan = $this->convertToDate($hd['ngayHetHanStr']);

            // Tính tình trạng
            $today = date('Y-m-d');
            $tinhtrang = 1;
            if ($ngayhethan < $today) {
              $tinhtrang = 3;
            } elseif ((strtotime($ngayhethan) - strtotime($today)) < 604800) {
              $tinhtrang = 2;
            }

            $columnsHD = [
              'giayphep_id' => $giayphep_id,
              'solan' => $hd['solan'],
              'ngayky' => $ngayky,
              'ngayhethan' => $ngayhethan,
              'sotien' => (int)($hd['sotien'] ?? 0),
              'tinhtrang' => $tinhtrang,
              'ghichu' => $hd['ghichu'] ?? '',
              'daxoa' => 0,
              'nguoitao_id' => (int)$userId,
              'ngaytao' => $now
            ];

            // Nếu có ID hợp đồng → Cập nhật
            if ($hopdongId > 0) {
              $columnsHD['nguoihieuchinh_id'] = (int)$userId;
              $columnsHD['ngayhieuchinh'] = $now;

              $query = $db->getQuery(true)
                ->update($db->quoteName('dcxddtmt_viahe_thongtinhopdong'))
                ->set($this->buildQuerySet($db, $columnsHD))
                ->where($db->quoteName('id') . ' = ' . (int)$hopdongId);
              $db->setQuery($query)->execute();
            } else {
              // Thêm mới
              $query = $db->getQuery(true)
                ->insert($db->quoteName('dcxddtmt_viahe_thongtinhopdong'))
                ->columns(array_keys($columnsHD))
                ->values(implode(',', array_map([$db, 'quote'], array_values($columnsHD))));
              $db->setQuery($query)->execute();
            }
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

  // 👉 Hàm chuyển đổi định dạng dd/mm/yyyy → yyyy-mm-dd
  protected function convertToDate($str)
  {
    if (!$str) return null;
    $parts = explode('/', $str);
    if (count($parts) === 3) {
      return "{$parts[2]}-{$parts[1]}-{$parts[0]}";
    }
    return null;
  }

  public function buildQuerySet($db, $columns)
  {
    $set = [];
    foreach ($columns as $key => $value) {
      $set[] = $db->quoteName($key) . ' = ' . (is_null($value) ? 'NULL' : $db->quote($value));
    }
    return $set;
  }

  public function checkDiaChi($diachi, $phuongxa_id)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    $query
      ->select(['id'])
      ->from($db->quoteName('dcxddtmt_viahe_thongtinviahe'))
      ->where($db->quoteName('diachi') . ' COLLATE utf8mb4_unicode_ci = ' . $db->quote(trim($diachi)))
      ->where($db->quoteName('phuongxa_id') . ' = ' . (int)$phuongxa_id)
      ->where($db->quoteName('daxoa') . ' = 0');

    $db->setQuery($query);
    return $db->loadAssoc();
  }

  public function xoatepdinhkem($viaheId, $fileId)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    try {
      $query = $db->getQuery(true)
        ->update($db->quoteName('dcxddtmt_viahe_filedinhkem'))
        ->set($db->quoteName('daxoa') . ' = 1')
        ->where($db->quoteName('thongtinviahe_id') . ' = ' . $db->quote($viaheId))
        ->where($db->quoteName('filedinhkem_id') . ' = ' . $db->quote($fileId));
        
      return $db->setQuery($query)->execute();
    } catch (\RuntimeException $e) {
      return false ;
    }
  }

  public function xoaHopDong($idhopdong)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    try {
      $query = $db->getQuery(true)
        ->update($db->quoteName('dcxddtmt_viahe_thongtinhopdong'))
        ->set($db->quoteName('daxoa') . ' = 1')
        ->where($db->quoteName('id') . ' = ' . $db->quote($idhopdong));
      return $db->setQuery($query)->execute();
    } catch (\RuntimeException $e) {
      return false;
    }
  }
  

  // public function getThongKeViahe($params = array())
  // {
  //   $db = Factory::getDbo();

  //   // Subquery
  //   $query_left = $db->getQuery(true);
  //   $query_left->select([
  //     'a.n_phuongxa_id',
  //     'px.tenkhuvuc AS phuongxa',
  //     'a.n_thonto_id',
  //     'f.tenkhuvuc AS thonto',
  //     'SUM(CASE WHEN a.id THEN 1 ELSE 0 END) AS soluong'

  //   ]);
  //   $query_left->from('dcxddtmt_viahe AS a')
  //     ->leftJoin('danhmuc_khuvuc AS f ON a.n_thonto_id = f.id')
  //     ->innerJoin('danhmuc_khuvuc AS px ON a.n_phuongxa_id = px.id')
  //     ->where('a.daxoa = 0 ');

  //   // Điều kiện WHERE cho subquery
  //   if (!empty($params['phuongxa_id'])) {
  //     $query_left->where('a.n_phuongxa_id = ' . $db->quote($params['phuongxa_id']));
  //   }

  //   if (!empty($params['thonto_id'])) {
  //     $thonto_ids = is_array($params['thonto_id']) ?
  //       $params['thonto_id'] :
  //       explode(',', $params['thonto_id']);
  //     $query_left->where('a.n_thonto_id IN (' . implode(',', array_map([$db, 'quote'], $thonto_ids)) . ')');
  //   }


  //   // Query chính
  //   $query = $db->getQuery(true);
  //   $query->select([
  //     'a.id',
  //     'a.cha_id',
  //     'a.tenkhuvuc',
  //     'a.level',
  //     'IFNULL(SUM(ab.soluong), 0) AS soluong'

  //   ])
  //     ->from('danhmuc_khuvuc AS a')
  //     ->leftJoin('(' . $query_left . ') AS ab ON (a.id = ab.n_thonto_id OR a.id = ab.n_phuongxa_id)');

  //   // Điều kiện cho query chính
  //   if (!empty($params['phuongxa_id'])) {
  //     $query->where($db->quoteName('a.id') . ' = ' . $db->quote($params['phuongxa_id']) . ' OR ' . $db->quoteName('a.cha_id') . ' = ' . $db->quote($params['phuongxa_id']));
  //   }
  //   if (!empty($params['thonto_id']) && is_array($params['thonto_id'])) {
  //     $query->where($db->quoteName('a.id') . ' IN (' . implode(',', array_map([$db, 'quote'], $params['thonto_id'])) . ')');
  //   }

  //   $query->group(['a.id', 'a.cha_id', 'a.tenkhuvuc', 'a.level']);
  //   $query->order('a.level, a.id ASC');
  //   // echo $query;
  //   $db->setQuery($query);
  //   $results = $db->loadAssocList();
  //   return $results;
  // }

  // public function getDanhSachXuatExcel($filters, $phuongxa)
  // {
  //   $hoten = isset($filters['hoten']) ? trim($filters['hoten']) : '';
  //   $cccd = isset($filters['cccd']) ? trim($filters['cccd']) : '';
  //   $gioitinh_id = isset($filters['gioitinh_id']) ? (int)$filters['gioitinh_id'] : 0;
  //   $phuongxa_id = isset($filters['phuongxa_id']) ? (int)$filters['phuongxa_id'] : 0;
  //   $thonto_id = isset($filters['thonto_id']) ? (int)$filters['thonto_id'] : 0;

  //   $db = Factory::getDbo();
  //   $query = $db->getQuery(true);
  //   // Select fields
  //   $query->select([
  //     'a.n_hoten',
  //     'DATE_FORMAT(a.n_namsinh, "%d/%m/%Y") AS namsinh',
  //     'gt.tengioitinh',
  //     'a.n_cccd',
  //     'DATE_FORMAT(hk.cccd_ngaycap, "%d/%m/%Y") AS cccd_ngaycap',
  //     'hk.cccd_coquancap',
  //     'a.n_diachi',
  //     'tt.tenkhuvuc as thonto',
  //     'px.tenkhuvuc as phuongxa',
  //     'lx.tenloaixe',
  //     'a.biensoxe',
  //     'a.thehanhnghe_so',
  //     'a.sogiaypheplaixe',
  //     'ttt.tentinhtrang',
  //   ]);


  //   $query->from('dcxddtmt_viahe as a')
  //     ->leftJoin('danhmuc_gioitinh AS gt ON a.n_gioitinh_id = gt.id')
  //     ->leftJoin($db->quoteName('vptk_hokhau2nhankhau', 'hk') . ' ON hk.id = a.nhankhau_id AND a.is_ngoai = 0 AND hk.daxoa = 0')
  //     ->leftJoin($db->quoteName('danhmuc_khuvuc', 'tt') . ' ON tt.id = a.n_thonto_id AND tt.daxoa = 0')
  //     ->leftJoin($db->quoteName('danhmuc_khuvuc', 'px') . ' ON px.id = a.n_phuongxa_id AND px.daxoa = 0')
  //     ->leftJoin($db->quoteName('danhmuc_loaixe', 'lx') . ' ON lx.id = a.loaixe_id')
  //     ->leftJoin($db->quoteName('danhmuc_tinhtrangthe', 'ttt') . ' ON ttt.id = a.tinhtrangthe_id')
  //     ->where('a.daxoa = 0');

  //   // Apply filters
  //   if (!empty($hoten)) {
  //     $query->where($db->quoteName('a.n_hoten') . ' LIKE ' . $db->quote('%' . $db->escape($hoten) . '%'));
  //   }

  //   if (!empty($cccd)) {
  //     $query->where($db->quoteName('a.n_cccd') . ' LIKE ' . $db->quote('%' . $db->escape($cccd) . '%'));
  //   }

  //   $phuongxaIds = !empty($phuongxa) && is_array($phuongxa)
  //     ? array_map('intval', array_column($phuongxa, 'id'))
  //     : [];

  //   if (!empty($phuongxa_id)) {
  //     $query->where('a.n_phuongxa_id = ' . $phuongxa_id);
  //   } else {
  //     // Không có phường xã filter → dùng danh sách phân quyền
  //     if (!empty($phuongxaIds)) {
  //       $query->where('a.n_phuongxa_id IN (' . implode(',', $phuongxaIds) . ')');
  //     } else {
  //       // Nếu không có phân quyền nào thì có thể lấy tất cả hoặc 1=0 tùy yêu cầu
  //       $query->where('a.n_phuongxa_id IN (SELECT id FROM danhmuc_phuongxa WHERE daxoa = 0)');
  //     }
  //   }

  //   if ($thonto_id > 0) {
  //     $query->where($db->quoteName('a.n_thonto_id') . ' = ' . (int)$thonto_id);
  //   }

  //   if ($gioitinh_id > 0) {
  //     $query->where($db->quoteName('a.n_gioitinh_id') . ' = ' . (int)$gioitinh_id);
  //   }

  //   $query->order($db->quoteName('a.id') . ' DESC');
  //   $db->setQuery($query);
  //   return $db->loadAssocList();
  // }
}
