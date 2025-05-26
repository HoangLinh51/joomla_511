<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class BaoCaoLoi_Model_BaoCaoLoi extends BaseDatabaseModel
{

  public function getTitle()
  {
    return "Tie";
  }

  public function getListError($keyword = '', $page = 1, $perPage = 20)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    $query->select([
      'a.id',
      'a.error_id',
      'a.enter_error',
      'a.content',
      'a.status',
      'b.name_error AS name_error',
      'c.name AS name_module',
    ])
      ->from($db->quoteName('error_report', 'a'))
      ->leftJoin($db->quoteName('error_type', 'b') . ' ON b.id = a.error_id')
      ->leftJoin($db->quoteName('name_module', 'c') . ' ON c.id = a.module_id');


    // Lọc theo tiêu đề hoặc nội dung
    if (!empty($keyword)) {
      $quotedKeyword = $db->quote('%' . $keyword . '%');
      $query->where('(a.content LIKE ' . $quotedKeyword . ' OR c.name LIKE ' . $quotedKeyword . ' OR b.name_error LIKE ' . $quotedKeyword . ')');
    }

    // Lọc theo trạng thái chưa xoá
    $query->where('a.deleted = 0');

    // Sắp xếp giảm dần theo ngày tạo
    $query->order($db->quoteName('a.created_at') . ' DESC');

    // Phân trang
    $startFrom = ($page - 1) * $perPage;
    $query->setLimit((int)$perPage, (int)$startFrom);

    $db->setQuery($query);

    try {
      $rows = $db->loadObjectList();

      // Gom lại nếu có nhiều văn bản cho một thông báo
      $result = [];
      foreach ($rows as $row) {
        $id = $row->id;
        if (!isset($result[$id])) {
          $result[$id] = (object)[
            'id' => $row->id,
            'error_id' => $row->error_id,
            'enter_error' => $row->enter_error,
            'name_error' => $row->name_error,
            'name_module' => $row->name_module,
            'status' => $row->status,
            'content' => $row->content,
          ];
        }
      }
      return array_values($result);
    } catch (Exception $e) {
      Factory::getApplication()->enqueueMessage('Lỗi khi lấy danh sách thông báo: ' . $e->getMessage(), 'error');
      return [];
    }
  }

  public function getListNameError()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select(['id', 'name_error'])
      ->from($db->quoteName('error_type'));

    $db->setQuery($query);

    try {
      return $db->loadObjectList();
    } catch (Exception $e) {
      Factory::getApplication()->enqueueMessage('Lỗi khi lấy loại lỗi: ' . $e->getMessage(), 'error');
      return [];
    }
  }

  public function getListNameModule()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select(['id', 'name'])
      ->from($db->quoteName('name_module'));

    $db->setQuery($query);

    try {
      return $db->loadObjectList();
    } catch (Exception $e) {
      Factory::getApplication()->enqueueMessage('Lỗi tên của module: ' . $e->getMessage(), 'error');
      return [];
    }
  }

  public function countBaoCaoLoi($userId)
  {
    $db = Factory::getDbo();

    $query = $db->getQuery(true)
      ->select('COUNT(*) AS tongbaocaoloi')
      ->from($db->quoteName('error_report', 't'))
      ->where('t.deleted = 0')
      ->where('t.created_by = ' . (int) $userId);

    $db->setQuery($query);
    return (int) $db->loadResult();
  }

  public function getDetailBaoCaoLoi($baocaoloiId)
  {
    if (!is_numeric($baocaoloiId) || $baocaoloiId <= 0) {
      return null;
    }

    $db = Factory::getDbo();

    // Truy vấn chính
    $query = $db->getQuery(true)
      ->select([
        'a.id',
        'a.error_id',
        'a.enter_error',
      'a.content',
        'a.status',
        'a.processing_content',
        'a.process_by',
        'd.name AS processor_name',
        'd.email AS processor_email',
        'a.process_at',
        'a.created_at',
        'a.created_by',
        'b.name_error',
        'c.name AS name_module',
        'u.name AS name_user',
        'u.username',
        'u.email'
      ])
      ->from($db->quoteName('error_report', 'a'))
      ->leftJoin($db->quoteName('error_type', 'b') . ' ON b.id = a.error_id')
      ->leftJoin($db->quoteName('name_module', 'c') . ' ON c.id = a.module_id')
      ->leftJoin($db->quoteName('jos_users', 'd') . ' ON d.id = a.process_by')
      ->leftJoin($db->quoteName('jos_users', 'u') . ' ON u.id = a.created_by')
      ->where([
        'a.id = ' . (int) $baocaoloiId,
        'a.deleted = 0'
      ]);

    $db->setQuery($query);

    try {
      $record = $db->loadObject();

      if (!$record) {
        return null;
      }

      // Truy vấn lấy danh sách ảnh từ bảng trung gian error_attachment
      $attachmentQuery = $db->getQuery(true)
        ->select(['a.id', 'a.code', 'a.filename', 'YEAR(a.created_at) AS year'])
        ->from($db->quoteName('core_attachment', 'a'))
        ->innerJoin($db->quoteName('error_attachment', 'ea') . ' ON ea.attachment_id = a.id')
        ->where('ea.error_id = ' . (int) $baocaoloiId);

      $db->setQuery($attachmentQuery);
      $attachments = $db->loadObjectList();

      // Gắn danh sách ảnh vào đối tượng record
      $record->images = $attachments;

      return $record;
    } catch (Exception $e) {
      Factory::getApplication()->enqueueMessage('Lỗi khi lấy thông tin báo cáo lỗi: ' . $e->getMessage(), 'error');
      return null;
    }
  }

  public function getIdImage($idObject)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select($db->quoteName('id'))
      ->from($db->quoteName('core_attachment'))
      ->where($db->quoteName('object_id') . ' = ' . $db->quote($idObject));

    $db->setQuery($query);
    $idImage = (int) $db->loadResult();
    return $idImage;
  }

  public function saveBaoCaoLoi($formdata, $idUser)
  {
    $db = Factory::getDbo();

    // Lấy dữ liệu đầu vào
    $error_id = (int) ($formdata['type_error_id'] ?? 0);
    $enter_error = ($error_id === 12) ? trim($formdata['name_otherError'] ?? '') : null;
    $module_id = $formdata['module_id'] ?? '';
    $content = $formdata['error_content'] ?? '';

    // Chuẩn bị dữ liệu để insert
    $columns = [
      'error_id'    => $error_id,
      'enter_error' => $enter_error,
      'module_id'   => $module_id,
      'content'     => $content,
      'status'      => 1,
      'created_by'  => $idUser,
      'created_at'  => Factory::getDate()->toSql(),
    ];

    // Tạo query insert
    $query = $db->getQuery(true)
      ->insert($db->quoteName('error_report'))
      ->columns(array_map([$db, 'quoteName'], array_keys($columns)))
      ->values(implode(',', array_map(
        fn($val) => $val !== null ? $db->quote($val) : 'NULL',
        array_values($columns)
      )));

    try {
      $db->setQuery($query);
      $db->execute();

      $insertId = $db->insertid();
      if ($insertId && !empty($formdata['imageIdInput'])) {
        return $this->saveAttachments($insertId, $formdata['imageIdInput']);
      }

      return ['success' => true, 'messages' => ['Báo cáo lỗi đã được lưu.']];
    } catch (Exception $e) {
      return ['success' => false, 'messages' => ['Lỗi khi lưu báo cáo: ' . $e->getMessage()]];
    }
  }

  public function saveAttachments($error_id, $imageIdInput)
  {
    if (!$error_id || empty($imageIdInput)) {
      return ['success' => false, 'messages' => ['ID lỗi hoặc danh sách ảnh không hợp lệ.']];
    }

    $db = Factory::getDbo();
    $attachmentIds = array_filter(array_map('intval', explode(',', $imageIdInput)));

    if (empty($attachmentIds)) {
      return ['success' => false, 'messages' => ['Không có ảnh hợp lệ để lưu.']];
    }

    $query = $db->getQuery(true);
    $columns = ['error_id', 'attachment_id'];

    $success = true;
    $messages = [];

    foreach ($attachmentIds as $attachmentId) {
      $query->clear()
        ->insert($db->quoteName('error_attachment'))
        ->columns($db->quoteName($columns))
        ->values(implode(',', [
          $db->quote($error_id),
          $db->quote($attachmentId)
        ]));

      try {
        $db->setQuery($query);
        $db->execute();
        $messages[] = "Đã lưu attachment ID $attachmentId.";
      } catch (Exception $e) {
        $success = false;
        $msg = "Lỗi khi lưu attachment ID $attachmentId: " . $e->getMessage();
        $messages[] = $msg;
        Factory::getApplication()->enqueueMessage($msg, 'error');
      }
    }

    return ['success' => $success, 'messages' => $messages];
  }


  public function saveReason($formdata)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->update('error_report')
      ->set('process_by = ' . $db->quote($formdata["idUser"]))
      ->set('status =' . $db->quote($formdata["status"]))
      ->set('process_at = NOW()')
      ->set('processing_content =' . $db->quote($formdata["contentReason"]))
      ->where('id =' . $db->quote($formdata["idError"]));

    $db->setQuery($query);
    return $db->execute();
  }
}
