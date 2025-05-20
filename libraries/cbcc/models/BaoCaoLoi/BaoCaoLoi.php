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
      ->from($db->quoteName('baocaoloi', 'a'))
      ->leftJoin($db->quoteName('loailoi', 'b') . ' ON b.id = a.error_id')
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
      ->from($db->quoteName('loailoi'));

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
      ->from($db->quoteName('baocaoloi', 't'))
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
        'a.image_id',
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
      ->from($db->quoteName('baocaoloi', 'a'))
      ->leftJoin($db->quoteName('loailoi', 'b') . ' ON b.id = a.error_id')
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

      // Truy vấn phụ để lấy danh sách ảnh
      $attachmentQuery = $db->getQuery(true)
        ->select(['id', 'code', 'filename', 'YEAR(created_at) AS year'])
        ->from($db->quoteName('core_attachment'))
        ->where('object_id = ' . (int) $record->image_id);

      $db->setQuery($attachmentQuery);
      $attachments = $db->loadObjectList();

      // Gắn danh sách images vào record
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

  public function saveBaoCaoLoi($formdata, $idUser): int
  {
    $db = Factory::getDbo();

    // Lấy giá trị error_id
    $error_id = (int) ($formdata['error_id'] ?? 0);
    $enter_error = ($error_id === 12) ? ($formdata['name_otherError'] ?? '') : null;

    // Chuẩn bị dữ liệu để lưu
    $columns = [
      'error_id' => $error_id,
      'enter_error' => $enter_error,
      'module_id' => $formdata['module_id'] ?? '',
      'content' => $formdata['error_content'] ?? '',
      'image_id' => (int)$formdata['imageIdInput'],
      'status' => 1,
      'created_by' => $idUser,
      'created_at' => Factory::getDate()->toSql(),
    ];

    $query = $db->getQuery(true)
      ->insert($db->quoteName('baocaoloi'))
      ->columns(array_map([$db, 'quoteName'], array_keys($columns)))
      ->values(implode(',', array_map(
        fn($val) => $val !== null ? $db->quote($val) : 'NULL',
        array_values($columns)
      )));

    $db->setQuery($query);
    $db->execute();

    return (int) $db->insertid();
  }

  public function saveReason($formdata)
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->update('baocaoloi')
      ->set('process_by = ' . $db->quote($formdata["idUser"]))
      ->set('status =' . $db->quote($formdata["status"]))
      ->set('process_at = NOW()')
      ->set('processing_content =' . $db->quote($formdata["contentReason"]))
      ->where('id =' . $db->quote($formdata["idError"]));

    $db->setQuery($query);
    return $db->execute();
  }
}
