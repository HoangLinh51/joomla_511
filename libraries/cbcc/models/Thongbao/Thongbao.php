<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class Thongbao_Model_Thongbao extends JModelLegacy
{

  public function getTitle()
  {
    return "Tie";
  }
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

  public function countItemsUnread($userId)
  {
    $db = Factory::getDbo();
    $currentDate = date('Y-m-d');
    $query =  $db->getQuery(true)
      ->select('COUNT(*) AS tongthongbao')
      ->from($db->quoteName('thongbao', 't'))
      ->leftJoin(
        $db->quoteName('trangthaithongbao', 'tt') . ' ON ' .
          $db->quoteName('t.id') . ' = ' . $db->quoteName('tt.thongbao_id') . ' AND ' .
          $db->quoteName('tt.user_id') . ' = ' . $db->quote($userId)
      )
      ->where('DATE(' . $db->quoteName('t.created_at') . ') = ' . $db->quote($currentDate))
      ->where($db->quoteName('t.status') . ' = 1')
      ->where('(tt.id IS NULL OR tt.is_seen = 0)');

    $query->where('t.daxoa = 0');

    $db->setQuery($query);
    $unreadCount = (int) $db->loadResult();
    return $unreadCount;
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

  public function removeThongbao($id, $userId)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->update('thongbao');
    $query->set('daxoa = 1');
    $query->set('deleted_by = ' . $db->quote($userId));
    $query->set('deleted = NOW()');
    $query->where('id =' . $db->quote($id));
    $db->setQuery($query);
    return $db->execute();
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
}
