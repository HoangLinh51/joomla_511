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
      ->leftJoin(
        '(SELECT MAX(hd.id) AS id
        FROM dcxddtmt_viahe_thongtinviahe a1
        LEFT JOIN dcxddtmt_viahe_giayphep gp1 ON gp1.thongtinviahe_id = a1.id
        LEFT JOIN dcxddtmt_viahe_thongtinhopdong hd ON hd.giayphep_id = gp1.id
        WHERE hd.daxoa = 0
        GROUP BY a1.id) AS last_hd
      ON tthd.id = last_hd.id'
      )
      ->where('a.daxoa = 0')
      ->where('tthd.daxoa = 0')
      ->where('tthd.id = last_hd.id'); 

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

      if (!empty($formdata['idFile-uploadImageHopDong'])) {
        foreach ($formdata['idFile-uploadImageHopDong'] as $fileId) {
          $checkQuery = $db->getQuery(true)
            ->select('COUNT(*)')
            ->from($db->quoteName('dcxddtmt_viahe_filedinhkem'))
            ->where($db->quoteName('thongtinviahe_id') . ' = ' . (int)$id)
            ->where($db->quoteName('filedinhkem_id') . ' = ' . (int)$fileId)
            ->where($db->quoteName('daxoa') . ' = 0');

          $db->setQuery($checkQuery);
          $exists = (int)$db->loadResult();

          if ($exists === 0) {
            // Chưa tồn tại, tiến hành insert
            $insertQuery = $db->getQuery(true)
              ->insert($db->quoteName('dcxddtmt_viahe_filedinhkem'))
              ->columns([
                $db->quoteName('thongtinviahe_id'),
                $db->quoteName('filedinhkem_id'),
                $db->quoteName('daxoa')
              ])
              ->values(implode(',', [(int)$id, (int)$fileId, 0]));

            $db->setQuery($insertQuery)->execute();
          }
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
      return false;
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

  public function xoaViahe($idviahe)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    try {
      $query = $db->getQuery(true)
        ->update($db->quoteName('dcxddtmt_viahe_thongtinviahe'))
        ->set($db->quoteName('daxoa') . ' = 1')
        ->where($db->quoteName('id') . ' = ' . $db->quote($idviahe));
      return $db->setQuery($query)->execute();
    } catch (\RuntimeException $e) {
      return false;
    }
  }

  public function getDanhSachXuatExcel($filters, $phuongxa)
  {
    $diachi = isset($filters['diachi']) ? trim($filters['diachi']) : '';

    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    // Select fields
    $query->select([
      'a.hoten',
      'a.dienthoai',
      'a.diachi',
      'a.dientichtamthoi',
      'a.chieudai',
      'a.chieurong',
      'a.mucdichsudung',
      'gp.sogiayphep',
      'tthd.solan',
      'tthd.ngayky',
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
    $query->order($db->quoteName('a.id') . ' DESC');
    $db->setQuery($query);
    return $db->loadAssocList();
  }
}
