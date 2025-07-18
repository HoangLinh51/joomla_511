<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

class Content_Model_Feature extends BaseDatabaseModel
{

  public function getTitle()
  {
    return "Tie";
  }

  public function getNameModule()
  {
    $db = \Joomla\CMS\Factory::getDbo();

    // 1. Lấy danh sách mapping menu_id -> table_name -> option
    $query = $db->getQuery(true)
      ->select($db->quoteName(['menu_id', 'table_name', 'option']))
      ->from($db->quoteName('core_menu_tabledb'));

    $db->setQuery($query);
    $mappings = $db->loadAssocList();

    // 2. Sinh subquery UNION ALL theo danh sách
    $unionParts = [];
    foreach ($mappings as $map) {
      $menuId = (int)$map['menu_id'];
      $opt    = (int)$map['option'];
      $table  = $map['table_name'];

      if ($opt === 1) {
        $unionParts[] = "SELECT {$menuId} AS menu_id, COUNT(*) AS total_count FROM {$table} WHERE daxoa = 0 AND n_phuongxa_id IN (24,64)";
      } else {
        $unionParts[] = "SELECT {$menuId} AS menu_id, COUNT(*) AS total_count FROM {$table} WHERE daxoa = 0 AND phuongxa_id IN (24,64)";
      }
    }

    $unionSql = '';
    if (!empty($unionParts)) {
      $unionSql = implode("\nUNION ALL\n", $unionParts);
    } else {
      $unionSql = "SELECT 0 AS menu_id, 0 AS total_count";
    }

    // 3. Gộp vào câu truy vấn chính
    // Chỉ lấy menu có trong core_menu_tabledb -> dùng INNER JOIN
    $sql = "
        SELECT 
            m.id AS menu_id,
            m.name AS menu_name,
            COALESCE(t.total_count, 0) AS total_count
        FROM core_menu AS m
        INNER JOIN core_menu_tabledb AS cmt
            ON cmt.menu_id = m.id
        LEFT JOIN (
            {$unionSql}
        ) AS t ON m.id = t.menu_id
        WHERE m.parent_id = 1
          AND m.published = 1
        ORDER BY total_count DESC
    ";
    $db->setQuery($sql);
    return $db->loadAssocList();
  }


  // public function getNameModule()
  // {
  //   // Lấy đối tượng DB Joomla
  //   $db = \Joomla\CMS\Factory::getDbo();

  //   // 1. Lấy danh sách mapping menu_id -> table_name -> option
  //   $query = $db->getQuery(true)
  //     ->select($db->quoteName(['menu_id', 'table_name', 'option']))
  //     ->from($db->quoteName('core_menu_tabledb'));

  //   $db->setQuery($query);
  //   $mappings = $db->loadAssocList();

  //   // 2. Sinh subquery UNION ALL
  //   $unionParts = [];
  //   foreach ($mappings as $map) {
  //     $menuId = (int)$map['menu_id'];
  //     $tableName = $db->quoteName($map['table_name'], false); // tránh lỗi tên bảng
  //     // chú ý: option trong DB có thể là string, nên cast về int
  //     $opt = (int)$map['option'];

  //     if ($opt === 1) {
  //       $unionParts[] = "SELECT {$menuId} AS menu_id, COUNT(*) AS total_count FROM {$map['table_name']} WHERE daxoa = 0 AND n_phuongxa_id IN (24,64)";
  //     } else {
  //       $unionParts[] = "SELECT {$menuId} AS menu_id, COUNT(*) AS total_count FROM {$map['table_name']} WHERE daxoa = 0 AND phuongxa_id IN (24,64)";
  //     }
  //   }

  //   // Nếu không có bảng nào thì tránh lỗi
  //   $unionSql = '';
  //   if (!empty($unionParts)) {
  //     $unionSql = implode("\nUNION ALL\n", $unionParts);
  //   } else {
  //     // Tạo subquery rỗng trả về menu_id không tồn tại
  //     $unionSql = "SELECT 0 AS menu_id, 0 AS total_count";
  //   }

  //   // 3. Gộp vào câu truy vấn chính
  //   $sql = "
  //       SELECT 
  //           m.id AS menu_id,
  //           m.name AS menu_name,
  //           COALESCE(t.total_count, 0) AS total_count
  //       FROM core_menu AS m
  //       LEFT JOIN (
  //           {$unionSql}
  //       ) AS t ON m.id = t.menu_id
  //       WHERE m.parent_id = 1
  //         AND m.published = 1
  //       ORDER BY m.id ASC
  //   ";

  //   $db->setQuery($sql);
  //   return $db->loadAssocList();
  // }
}