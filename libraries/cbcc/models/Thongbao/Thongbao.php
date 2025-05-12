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

  public function getListThongBao($params = array(), $startFrom = 0, $perPage = 20)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    $query->select([
      'a.id',
      'a.tieude',
      'a.noidung',
      'a.vanbandinhkem',
      'DATE_FORMAT(a.created_at, "%d/%m/%Y") AS ngay_tao',
      'a.created_by',
    ])
      ->from($db->quoteName('thongbao', 'a'));

    // Lọc theo ngày hôm nay (trừ khi có yêu cầu lấy tất cả)
    if (empty($params['tatca']) || $params['tatca'] !== '1') {
      $today = date('Y-m-d');
      $query->where('DATE(a.created_at) = ' . $db->quote($today));
    }

    // Lọc theo ID
    if (!empty($params['id'])) {
      $query->where('a.id = ' . (int)$params['id']);
    }

    // Lọc theo tiêu đề
    if (!empty($params['tieude'])) {
      $tieude = $db->quote('%' . $params['tieude'] . '%');
      $query->where('a.tieude LIKE ' . $tieude);
    }

    // Lọc theo ngày cụ thể
    if (!empty($params['ngay'])) {
      $query->where('DATE(a.created_at) = ' . $db->quote($params['ngay']));
    }

    // Sắp xếp và phân trang
    $query->order('a.created_at DESC')
      ->setLimit((int)$perPage, (int)$startFrom);
    $query->where('a.daxoa = 0');
    $db->setQuery($query);

    try {
      return $db->loadObjectList();
    } catch (Exception $e) {
      Factory::getApplication()->enqueueMessage('Lỗi truy vấn thông báo: ' . $e->getMessage(), 'error');
      return [];
    }
  }

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

  public function countThongBao($userId, $mode = 'unread')
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
          'tb.vanbandinhkem',
          'DATE_FORMAT(tb.created_at, "%d/%m/%Y") AS ngay_tao',
          'tb.created_by',
          'u.name',
          'u.username',
          'u.email'
      ])
      ->from($db->quoteName('thongbao', 'tb'))
      ->leftJoin($db->quoteName('jos_users', 'u') . ' ON u.id = tb.created_by')
      ->where('tb.id = ' . $db->quote($thongbaoId))
      ->where('tb.daxoa = 0');
  
      $db->setQuery($query);
      
      try {
          $result = $db->loadObject();
          return $result ? $result : null;
      } catch (Exception $e) {
          Factory::getApplication()->enqueueMessage('SQL Error: ' . $e->getMessage(), 'error');
          return null;
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

    // column database
    $columns = [
      'tieude' => $formdata["tieude"],
      'noidung' => $formdata["noidung"],
      'vanbandinhkem' => $formdata["idTepDinhKem"],
    ];

    if ($formdata["id"] > 0) {
      // Update
      $query = $db->getQuery(true)
        ->update($db->quoteName('thongbao'))
        ->set(array_map(function ($k, $v) use ($db) {
          return $db->quoteName($k) . ' = ' . $db->quote($v);
        }, array_keys($columns), $columns))
        ->where($db->quoteName('id') . ' = ' . (int) $formdata["id"]);

      $db->setQuery($query);
      $db->execute();

      return $formdata["id"];
    } else {
      // Insert new 
      $columns['status'] = 1;
      $columns['created_by'] = $idUser;
      $columns['created_at'] = Factory::getDate()->toSql();

      $query = $db->getQuery(true)
        ->insert($db->quoteName('thongbao'))
        ->columns(array_keys($columns))
        ->values(implode(',', array_map([$db, 'quote'], array_values($columns))));

      $db->setQuery($query);
      $db->execute();

      return $db->insertid();
    }
  }

  public function getVanBan($idObject)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    $query->select([
      'a.id',
      'a.code',
      'a.filename',
      'YEAR(a.created_at) AS nam'
    ])
      ->from($db->quoteName('core_attachment', 'a'))
      ->where($db->quoteName('a.object_id') . ' = ' . $db->quote($idObject));

    $db->setQuery($query);
    try {
      $results = $db->loadObjectList();
      return $results ? $results : [];
    } catch (Exception $e) {
      Factory::getApplication()->enqueueMessage('SQL Error: ' . $e->getMessage(), 'error');
      return [];
    }
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
}
