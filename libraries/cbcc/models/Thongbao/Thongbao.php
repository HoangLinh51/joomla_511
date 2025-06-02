<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class Thongbao_Model_Thongbao extends BaseDatabaseModel
{

  public function getTitle()
  {
    return "Tie";
  }

  public function getListThongBao($mode = 'all', $keyword = '', $page = 1, $take = 20)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select([
        'a.id',
        'a.tieude',
      'a.noidung',
        'DATE_FORMAT(a.created_at, "%d/%m/%Y") AS ngay_tao',
        'a.created_by'
    ])
      ->from($db->quoteName('thongbao', 'a'))
      ->where('a.daxoa = 0');

    // Filter by today if mode is 'today'
    if ($mode === 'today') {
      $query->where('DATE(a.created_at) = ' . $db->quote(date('Y-m-d')));
    }

    // Filter by keyword
    if (!empty($keyword)) {
      $quotedKeyword = $db->quote('%' . $keyword . '%');
      $query->where('(a.tieude LIKE ' . $quotedKeyword . ' OR a.noidung LIKE ' . $quotedKeyword . ')');
    }

    // Count total records
    $totalQuery = clone $query;
    $totalQuery->clear('select')->select('COUNT(DISTINCT a.id)');
    $db->setQuery($totalQuery);
    $totalRecord = $db->loadResult();

    // Pagination
    $take = (int) $take > 0 ? (int) $take : 20;
    $skip = ($page - 1) * $take;
    $query->order('a.created_at DESC');
    $query->setLimit($take, $skip);

    $db->setQuery($query);
    $rows = $db->loadObjectList();

    // Lấy toàn bộ ID thông báo để truy vấn file
    $ids = array_map(function ($item) {
      return (int) $item->id;
    }, $rows);

    $vanbanMap = [];

    if (!empty($ids)) {
      $query = $db->getQuery(true)
        ->select([
          'tv.thongbao_id',
          'ca.id ',
          'ca.code',
          'ca.filename',
          'ca.mime',
          'YEAR(ca.created_at) AS year'
        ])
        ->from($db->quoteName('thongbao_vanban', 'tv'))
        ->innerJoin($db->quoteName('core_attachment', 'ca') . ' ON ca.id = tv.vanban_id')
        ->where('tv.thongbao_id IN (' . implode(',', $ids) . ')');

      $db->setQuery($query);
      $attachments = $db->loadObjectList();

      // Nhóm file theo ID thông báo
      foreach ($attachments as $file) {
        $vanbanMap[$file->thongbao_id][] = [
          'id' => $file->id,
          'filename' => $file->filename,
          'code' => $file->code,
          'type' => $file->mime,
          'year' => $file->year
        ];
      }
    }

    // Gán danh sách văn bản vào mỗi thông báo
    $result = array_map(function ($row) use ($vanbanMap) {
      return (object)[
            'id' => $row->id,
            'tieude' => $row->tieude,
        'noidung' => $row->noidung,
            'ngay_tao' => $row->ngay_tao,
            'created_by' => $row->created_by,
        'vanban' => $vanbanMap[$row->id] ?? []
      ];
    }, $rows);

    return [
      'data' => $result,
      'page' => (int) $page,
      'take' => (int) $take,
      'totalrecord' => (int) $totalRecord
    ];
  }

  // public function getListThongBao($mode = 'all', $keyword = '', $page = 1, $take = 20)
  // {
  //   $db = Factory::getDbo();
  //   $query = $db->getQuery(true)
  //     ->select([
  //       'a.id',
  //       'a.tieude',
  //     'a.noidung',
  //     'DATE_FORMAT(a.created_at, "%d/%m/%Y") AS ngay_tao',
  //       'a.created_by'
  //   ])
  //     ->from($db->quoteName('thongbao', 'a'))
  //     ->where('a.daxoa = 0');

  //   // Filter by today if mode is 'today'
  //   if ($mode === 'today') {
  //     $query->where('DATE(a.created_at) = ' . $db->quote(date('Y-m-d')));
  //   }

  //   // Filter by keyword in title or content
  //   if (!empty($keyword)) {
  //     $quotedKeyword = $db->quote('%' . $keyword . '%');
  //     $query->where('(a.tieude LIKE ' . $quotedKeyword . ' OR a.noidung LIKE ' . $quotedKeyword . ')');
  //   }

  //   // Order by creation date descending
  //   $query->order('a.created_at DESC');

  //   // Pagination
  //   $totalQuery = clone $query;
  //   $totalQuery->clear('select')->select('COUNT(DISTINCT a.id)');
  //   $db->setQuery($totalQuery);
  //   $totalRecord = $db->loadResult();

  //   // Áp dụng phân trang
  //   $take = (int) $take > 0 ? (int) $take : 20;
  //   $skip = ($page - 1) * $take;
  //   $query->setLimit($take, $skip);

  //   $db->setQuery($query);
  //   $rows = $db->loadObjectList();

  //   // Process results
  //   $result = array_map(function ($row) {
  //     $vanban = [];

  //     return (object)[
  //           'id' => $row->id,
  //           'tieude' => $row->tieude,
  //       'noidung' => $row->noidung,
  //       'ngay_tao' => $row->ngay_tao,
  //           'created_by' => $row->created_by,
  //       'vanban' => $vanban
  //     ];
  //   }, $rows);

  //   return [
  //     'data' => $result,
  //     'page' => (int) $page,
  //     'take' => (int) $take,
  //     'totalrecord' => (int) $totalRecord
  //   ];
  // }

  public function getTrangThaiThongBao($userId, $thongbaoId)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select('is_seen')
      ->from($db->quoteName('trangthaithongbao'))
      ->where($db->quoteName('user_id') . ' = ' . $db->quote($userId))
      ->where($db->quoteName('thongbao_id') . ' = ' . $db->quote($thongbaoId))
      ->setLimit(1);

    $db->setQuery($query);
    $isRead = $db->loadResult();

    if ($isRead) {
      return true; // Thông báo đã được đọc
    } else {
      return false; // Thông báo chưa được đọc
    }
  }

  public function countThongBao($userId, $mode = 'all')
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select('COUNT(*) AS tongthongbao')
      ->from($db->quoteName('thongbao', 't'))
      ->leftJoin(
        $db->quoteName('trangthaithongbao', 'tt') . ' ON ' .
          $db->quoteName('t.id') . ' = ' . $db->quoteName('tt.thongbao_id') . ' AND ' .
          $db->quoteName('tt.user_id') . ' = ' . $db->quote($userId)
      )
      ->where('t.status = 1')
      ->where('t.daxoa = 0');

    // Nếu là unread: chỉ đếm những thông báo chưa đọc trong ngày hôm nay
    if ($mode === 'unread') {
      $currentDate = date('Y-m-d');
      $query->where('DATE(t.created_at) = ' . $db->quote($currentDate));
      $query->where('(tt.id IS NULL OR tt.is_seen = 0)');
    }
    $db->setQuery($query);
    return (int) $db->loadResult();
  }

  public function getDetailThongbao($thongbaoId)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    $query->select([
      'tb.id',
      'tb.tieude',
      'tb.noidung',
      'DATE_FORMAT(tb.created_at, "%d/%m/%Y") AS ngay_tao',
      'tb.created_by',
      'u.name',
      'u.username',
      'u.email'
    ])
      ->from($db->quoteName('thongbao', 'tb'))
      ->leftJoin($db->quoteName('jos_users', 'u') . ' ON u.id = tb.created_by')
      ->where('tb.id = ' . (int)$thongbaoId)
      ->where('tb.daxoa = 0');

    try {
      $db->setQuery($query);
      $row = $db->loadObject();

      if (!$row) {
        return null;
      }

      // Truy vấn lấy các file đính kèm
      $query = $db->getQuery(true)
        ->select([
          'ca.id ',
          'ca.code',
          'ca.filename',
          'ca.mime',
          'YEAR(ca.created_at) AS year'
        ])
        ->from($db->quoteName('thongbao_vanban', 'tv'))
        ->innerJoin($db->quoteName('core_attachment', 'ca') . ' ON ca.id = tv.vanban_id')
        ->where('tv.thongbao_id = ' . (int)$thongbaoId);

      $db->setQuery($query);
      $attachments = $db->loadObjectList();

      $vanban = array_map(function ($item) {
        return [
          'id' => $item->id,
          'filename' => $item->filename,
          'code' => $item->code,
          'type' => $item->mime,
          'year' => $item->year
        ];
      }, $attachments);

      return (object)[
        'id' => $row->id,
        'tieude' => $row->tieude,
        'noidung' => $row->noidung,
        'ngay_tao' => $row->ngay_tao,
        'created_by' => $row->created_by,
        'name' => $row->name,
        'username' => $row->username,
        'email' => $row->email,
        'vanban' => $vanban
      ];
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }


  public function submitTrangThaiThongBao()
	{
		$db = Factory::getDbo();
		$input = Factory::getApplication()->input;
		$user_id = $input->getInt('user_id', 0);
		$thongbao_id = $input->getInt('thongbao_id', 0);

		// Kiểm tra dữ liệu đầu vào
		if (!$user_id || !$thongbao_id) {
			return false;
		}

		try {
			// Kiểm tra bản ghi đã tồn tại chưa
			$query = $db->getQuery(true)
				->select('id')
				->from($db->quoteName('trangthaithongbao'))
				->where($db->quoteName('user_id') . ' = ' . $db->quote($user_id))
				->where($db->quoteName('thongbao_id') . ' = ' . $db->quote($thongbao_id));
			$db->setQuery($query);
			$exists = $db->loadResult();

			if ($exists) {
				// Nếu đã có, cập nhật is_seen = 1
				$query = $db->getQuery(true)
					->update($db->quoteName('trangthaithongbao'))
					->set($db->quoteName('is_seen') . ' = 1')
					->where($db->quoteName('id') . ' = ' . $db->quote($exists));
			} else {
				// Nếu chưa có, thêm mới
				$columns = ['thongbao_id', 'user_id', 'is_seen', 'created_at'];
				$values = [
					$db->quote($thongbao_id),
					$db->quote($user_id),
					1,
					$db->quote(date('Y-m-d H:i:s'))
				];

				$query = $db->getQuery(true)
					->insert($db->quoteName('trangthaithongbao'))
					->columns($db->quoteName($columns))
					->values(implode(',', $values));
			}

			$db->setQuery($query);
			$db->execute();

			return true;
		} catch (Exception $e) {
			// Ghi log nếu cần: Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
			return false;
		}
	}

  public function saveThongBao($formdata, $idUser)
  {
    $db = Factory::getDbo();
    $id_vanban = $formdata['fileupload_id'] ?? [];
    $result = [];

    $columns = [
      'tieude' => $formdata["tieude"] ?? '',
      'noidung' => $formdata["noidung"] ?? '',
    ];

    $id = (int) ($formdata["id"] ?? 0);
    $now = Factory::getDate()->toSql();

    try {
      if ($id > 0) {
        // ✅ Cập nhật
        $columns['status'] = 1;
        $columns['created_by'] = $idUser;
        $columns['created_at'] = $now;

        $query = $db->getQuery(true)
          ->update($db->quoteName('thongbao'));

        $setParts = [];
        foreach ($columns as $col => $val) {
          $setParts[] = $db->quoteName($col) . ' = ' . $db->quote($val);
        }

        $query->set($setParts)
          ->where('id = ' . $db->quote($id));

        $db->setQuery($query);
        $db->execute();

        $idThongbao = $id;
      } else {
        // ✅ Tạo mới
        $columns['status'] = 1;
        $columns['created_by'] = $idUser;
        $columns['created_at'] = $now;

        $query = $db->getQuery(true)
          ->insert($db->quoteName('thongbao'))
          ->columns(array_keys($columns))
          ->values(implode(',', array_map([$db, 'quote'], array_values($columns))));

        $db->setQuery($query);
        $db->execute();

        $idThongbao = $db->insertid();
      }

      // ✅ Thêm các bản ghi liên kết mới
      if (!empty($idThongbao) && !empty($id_vanban)) {
        foreach ($id_vanban as $idVanBan) {
          if (!is_numeric($idVanBan)) {
            continue;
          }

          $query = $db->getQuery(true)
            ->insert($db->quoteName('thongbao_vanban'))
            ->columns([$db->quoteName('thongbao_id'), $db->quoteName('vanban_id')])
            ->values(
              implode(',', [
                $db->quote((int) $idThongbao),
                $db->quote((int) $idVanBan)
              ])
            );
          $db->setQuery($query);
          $db->execute();
        }
      }

      // ✅ Kết quả trả về
      $result = [
        'message' => $id > 0 ? 'Cập nhật thông báo thành công!' : 'Tạo mới thông báo thành công!',
        'result' => $idThongbao
      ];
    } catch (\RuntimeException $e) {
      $result = [
        'message' => 'Lỗi: ' . $e->getMessage(),
        'result' => null
      ];
    }

    return $result;
  }

  public function deleteThongbao($idUser, $idThongbao)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->update('thongbao')
      ->set('daxoa = 1')
      ->set('deleted_by = ' . $db->quote($idUser))
      ->set('deleted_at = NOW()')
      ->where('id =' . $db->quote($idThongbao));

    $db->setQuery($query);
    return $db->execute();
  }

  public function deleteVanBan($idVanban, $idThongbao): bool
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    // Xây câu lệnh DELETE
    $conditions = [
      $db->quoteName('thongbao_id') . ' = ' . $db->quote($idThongbao),
      $db->quoteName('vanban_id') . ' = ' . $db->quote($idVanban)
    ];

    $query->delete($db->quoteName('thongbao_vanban'))
      ->where($conditions);
    $db->setQuery($query);

    return $db->execute();
  }
}
