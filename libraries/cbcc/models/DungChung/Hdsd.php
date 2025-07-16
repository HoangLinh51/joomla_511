<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class DungChung_Model_Hdsd extends BaseDatabaseModel
{

  public function getTitle()
  {
    return "Tie";
  }

  public function getListHdsd()
  {
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
      ->select([
        'a.id',
        'a.tieude',
        'a.icon',
        'c.code',
        'c.mime',
        'c.folder'
      ])
      ->from($db->quoteName('hdsd', 'a'))
      ->innerJoin('hdsd_vanban AS b ON b.hdsd_id = a.id')
      ->innerJoin('core_attachment AS c ON c.id = b.vanban_id')
      ->where('daxoa = 0');

    $db->setQuery($query);
    $rows = $db->loadObjectList();

    return $rows;
  }

  public function saveHdsd($formdata, $idUser)
  {
    $db = Factory::getDbo();
    $id_vanban = $formdata['idFile-vanban'] ?? [];
    $result = [];

    $columns = [
      'tieude' => $formdata["tieude"] ?? '',
      'icon' => 'fas fa-book',
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
          ->update($db->quoteName('hdsd'));

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
          ->insert($db->quoteName('hdsd'))
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
            ->insert($db->quoteName('hdsd_vanban'))
            ->columns([$db->quoteName('hdsd_id'), $db->quoteName('vanban_id')])
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
}
