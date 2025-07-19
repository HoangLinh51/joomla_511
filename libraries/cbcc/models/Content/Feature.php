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
  public function getPhanquyen()
  {
    $user_id = Factory::getUser()->id;
    $db = Factory::getContainer()->get('DatabaseDriver');
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

  public function getTongTheoNam($phuongXaIds)
  {
    $db = Factory::getContainer()->get('DatabaseDriver');

    // danh sách phường xã
    $idsArray = array_map('intval', explode(',', $phuongXaIds));
    $idsList  = implode(',', $idsArray);

    // 1️⃣ Lấy danh sách từ core_menu_tabledb
    $queryMenu = $db->getQuery(true)
      ->select($db->quoteName(['menu_id', 'table_name', 'option']))
      ->from($db->quoteName('phuongxa_2025.core_menu_tabledb'));
    $db->setQuery($queryMenu);
    $menus = $db->loadAssocList();

    // 2️⃣ Sinh các SELECT cho từng bảng
    $unionParts = [];
    foreach ($menus as $menu) {
      $menuId = (int)$menu['menu_id'];
      $table  = $menu['table_name'];
      $option = (int)$menu['option'];

      // cột phường/xã phụ thuộc option
      $col = ($option === 1) ? 'n_phuongxa_id' : 'phuongxa_id';

      // build SQL nhỏ
      $part = "SELECT '{$menuId}' AS menu_id, ngaytao, ngayhieuchinh 
                     FROM phuongxa_2025.`{$table}` 
                     WHERE {$col} IN ({$idsList}) AND daxoa=0";
      $unionParts[] = $part;
    }

    // 3️⃣ Ghép các phần lại
    $unionSql = implode("\nUNION ALL\n", $unionParts);

    // 4️⃣ Ghép vào câu chính
    $finalSql = "
            SELECT mtd.menu_id, cm.name AS menu_name, cm.icon as menu_icon,
                   IFNULL(SUM(CASE WHEN YEAR(COALESCE(t.ngayhieuchinh, t.ngaytao)) = 2023 THEN 1 ELSE 0 END),0) AS n_2023,
                   IFNULL(SUM(CASE WHEN YEAR(COALESCE(t.ngayhieuchinh, t.ngaytao)) = 2024 THEN 1 ELSE 0 END),0) AS n_2024,
                   IFNULL(SUM(CASE WHEN YEAR(COALESCE(t.ngayhieuchinh, t.ngaytao)) = 2025 THEN 1 ELSE 0 END),0) AS n_2025
            FROM phuongxa_2025.core_menu_tabledb AS mtd
            LEFT JOIN phuongxa_2025.core_menu AS cm ON cm.id = mtd.menu_id
            LEFT JOIN (
                {$unionSql}
            ) AS t ON t.menu_id = mtd.menu_id
            GROUP BY mtd.menu_id, cm.name
            ORDER BY mtd.menu_id
        ";

    // 5️⃣ Thực thi
    $db->setQuery($finalSql);
    return $db->loadAssocList();
  }

  public function getTongHopLuyKe($phuongxaId)
  {
    // Kết nối DB Joomla
    $db = Factory::getContainer()->get('DatabaseDriver');

    $ids = explode(',', $phuongxaId); // ["24", "64"]
    $quotedIds = array_map(function ($id) use ($db) {
      return $db->quote(trim($id));
    }, $ids);
    $inClause = implode(',', $quotedIds);
    // Lấy danh sách bảng từ core_menu_tabledb
    $query = $db->getQuery(true)
      ->select($db->quoteName(['menu_id', 'table_name', 'option']))
      ->from($db->quoteName('core_menu_tabledb'));
    $db->setQuery($query);
    $tables = $db->loadAssocList();

    // Danh sách CTE động cho từng bảng
    $cteParts = [];
    $joinParts = [];
    $sumParts = [];
    $aliasIndex = 0;

    foreach ($tables as $row) {
      $table = $row['table_name'];
      $menu_id = $row['menu_id'];
      $option = (int)$row['option'];
      $alias = 't' . $aliasIndex++;
      // Xác định cột phường/xã
      $colPhuongXa = ($option === 1) ? 'n_phuongxa_id' : 'phuongxa_id';

      // Tạo CTE cho bảng này
      $cteParts[] = "
            {$alias}_data AS (
                SELECT DATE_FORMAT(ngaytao,'%Y-%m-01') AS ngay_thang, COUNT(*) AS so_luong
                FROM {$table}
                WHERE ngaytao >= '2023-01-01' AND ngaytao < '2026-01-01'
                  AND {$colPhuongXa} IN ({$inClause})
                  AND daxoa = 0
                GROUP BY DATE_FORMAT(ngaytao,'%Y-%m-01')
            )
        ";

      // Tạo phần join
      $joinParts[] = "LEFT JOIN {$alias}_data {$alias} ON t.ngay_thang = {$alias}.ngay_thang";

      // Tạo phần SUM lũy kế
      $sumParts[] = "SUM(COALESCE({$alias}.so_luong,0)) OVER (ORDER BY t.ngay_thang) AS {$menu_id}_luyke";
    }

    // CTE cho thang_list
    $cteThang = "
        thang_list AS (
            SELECT DATE('2023-01-01') AS ngay_thang
            UNION ALL
            SELECT DATE_ADD(ngay_thang, INTERVAL 1 MONTH)
            FROM thang_list
            WHERE ngay_thang < '2025-12-01'
        )
    ";

    // Gộp tất cả CTE
    $allCte = implode(",\n", array_merge([$cteThang], $cteParts));

    // Build final query
    $finalQuery = "
        WITH RECURSIVE
        {$allCte}
        SELECT DATE_FORMAT(t.ngay_thang, '%Y-%m') AS thang_nam,
        " . implode(",\n", $sumParts) . "
        FROM thang_list t
        " . implode("\n", $joinParts) . "
        ORDER BY t.ngay_thang
    ";

    // Thực thi query
    $db->setQuery($finalQuery);
    return $db->loadAssocList();
  }
}
// public function getNameModule($phuongxa, $year)
// {
//   $db = Factory::getContainer()->get('DatabaseDriver');
//   $phuongXaIds = array_map('intval', explode(',', $phuongxa));
//   $inList = implode(',', $phuongXaIds);

//   // Lấy danh sách bảng từ core_menu_tabledb
//   $query = $db->getQuery(true)
//     ->select($db->quoteName(['menu_id', 'table_name', 'option']))
//     ->from($db->quoteName('core_menu_tabledb'));
//   $db->setQuery($query);
//   $mappings = $db->loadAssocList();

//   $unionParts = [];

//   foreach ($mappings as $map) {
//     $menuId = (int)$map['menu_id'];
//     $opt    = (int)$map['option'];
//     $table  = $map['table_name'];

//     // Cột phường/xã theo option
//     $colPhuongXa = ($opt === 1) ? 'n_phuongxa_id' : 'phuongxa_id';
//     $unionParts[] = "
//           SELECT {$menuId} AS menu_id, COUNT(*) AS total_count
//           FROM {$table}
//           WHERE daxoa = 0
//             AND {$colPhuongXa} IN ({$inList})
//             AND (
//                   (ngayhieuchinh IS NOT NULL AND YEAR(ngayhieuchinh) = {$year})
//                OR (ngayhieuchinh IS NULL  AND ngaytao IS NOT NULL AND YEAR(ngaytao) = {$year} )
//             )
//       ";
//   }

//   $unionSql = !empty($unionParts) ? implode("\nUNION ALL\n", $unionParts) : "SELECT 0 AS menu_id, 0 AS total_count";

//   // Ghép với core_menu để lấy tên menu
//   $sql = "
//       SELECT 
//           m.id AS menu_id,
//           m.name AS menu_name,
//           COALESCE(t.total_count, 0) AS total_count
//       FROM core_menu AS m
//       INNER JOIN core_menu_tabledb AS cmt
//           ON cmt.menu_id = m.id
//       LEFT JOIN (
//           {$unionSql}
//       ) AS t ON m.id = t.menu_id
//       WHERE m.parent_id = 1
//         AND m.published = 1
//       ORDER BY total_count DESC
//   ";

//   $db->setQuery($sql);
//   return $db->loadAssocList();
// }

// public function updateTotalDataInDb($phuongxa)
// {
//   $db = Factory::getDbo();
//   $phuongXaIds = array_map('intval', explode(',', $phuongxa));
//   $inList = implode(',', $phuongXaIds);

//   // Lấy danh sách mapping từ core_menu_tabledb
//   $query = $db->getQuery(true)
//     ->select($db->quoteName(['menu_id', 'table_name', 'option']))
//     ->from($db->quoteName('core_menu_tabledb'));
//   $db->setQuery($query);
//   $mappings = $db->loadAssocList();

//   // Năm hiện tại và 3 năm gần nhất
//   $currentYear = (int)date('Y');
//   $thangHienTai = (int)date('n');

//   $unionParts = [];
//   foreach ($mappings as $map) {
//     $menuId = (int)$map['menu_id'];
//     $table  = $db->quoteName($map['table_name']); // escape tên bảng
//     $opt    = (int)$map['option'];
//     $pxCol  = ($opt === 1) ? 'n_phuongxa_id' : 'phuongxa_id';

//     $dateCol = "COALESCE(ngayhieuchinh, ngaytao)";
//     $dateCondition = "(ngayhieuchinh IS NOT NULL OR ngaytao IS NOT NULL)";
//     $dateCondition .= " AND (
//               (YEAR($dateCol) = $currentYear AND MONTH($dateCol) <= $thangHienTai)
//               OR (YEAR($dateCol) = " . ($currentYear - 1) . ")
//               OR (YEAR($dateCol) = " . ($currentYear - 2) . ")
//           )";

//     $unionParts[] = "
//           SELECT 
//               $menuId AS menu_id,
//               $pxCol AS phuongxa_id,
//               YEAR($dateCol) AS nam,
//               MONTH($dateCol) AS thang,
//               COUNT(*) AS total_count
//           FROM {$table}
//           WHERE daxoa = 0
//             AND $pxCol IN ($inList)
//             AND $dateCondition
//           GROUP BY $pxCol, YEAR($dateCol), MONTH($dateCol)
//       ";
//   }

//   $unionSql = !empty($unionParts)
//     ? implode("\nUNION ALL\n", $unionParts)
//     : "SELECT 0 AS menu_id, 0 AS phuongxa_id, 0 AS nam, 0 AS thang, 0 AS total_count";

//   $finalSql = "
//       SELECT 
//           u.menu_id, 
//           u.phuongxa_id,
//           u.nam, 
//           u.thang, 
//           SUM(u.total_count) AS total_count
//       FROM (
//           $unionSql
//       ) AS u
//       GROUP BY u.menu_id, u.phuongxa_id, u.nam, u.thang
//       ORDER BY u.menu_id, u.phuongxa_id, u.nam DESC, u.thang ASC
//   ";

//   $db->setQuery($finalSql);
//   $rows = $db->loadAssocList();

//   // ⚡ Không xóa bảng nữa, chỉ update/insert theo từng dòng
//   foreach ($rows as $row) {
//     $menuId     = (string)$row['menu_id'];
//     $phuongxaId = (string)$row['phuongxa_id'];
//     $nam        = (string)$row['nam'];
//     $thang      = (string)$row['thang'];
//     $tongso     = (string)$row['total_count'];

//     // Kiểm tra xem đã có bản ghi chưa
//     $checkQuery = $db->getQuery(true)
//       ->select('COUNT(*)')
//       ->from($db->quoteName('thongke_module'))
//       ->where($db->quoteName('menu_id') . ' = ' . $db->quote($menuId))
//       ->where($db->quoteName('phuongxa_id') . ' = ' . $db->quote($phuongxaId))
//       ->where($db->quoteName('nam') . ' = ' . $db->quote($nam))
//       ->where($db->quoteName('thang') . ' = ' . $db->quote($thang));
//     $db->setQuery($checkQuery);
//     $exists = (int)$db->loadResult();

//     if ($exists > 0) {
//       // ✅ Đã tồn tại => UPDATE
//       $update = $db->getQuery(true)
//         ->update($db->quoteName('thongke_module'))
//         ->set($db->quoteName('tongso') . ' = ' . $db->quote($tongso))
//         ->where($db->quoteName('menu_id') . ' = ' . $db->quote($menuId))
//         ->where($db->quoteName('phuongxa_id') . ' = ' . $db->quote($phuongxaId))
//         ->where($db->quoteName('nam') . ' = ' . $db->quote($nam))
//         ->where($db->quoteName('thang') . ' = ' . $db->quote($thang));
//       $db->setQuery($update);
//       $db->execute();
//     } else {
//       // ❌ Chưa tồn tại => INSERT
//       $insert = $db->getQuery(true);
//       $columns = array('menu_id', 'nam', 'thang', 'tongso', 'phuongxa_id');
//       $values = array(
//         $db->quote($menuId),
//         $db->quote($nam),
//         $db->quote($thang),
//         $db->quote($tongso),
//         $db->quote($phuongxaId)
//       );
//       $insert
//         ->insert($db->quoteName('thongke_module'))
//         ->columns($db->quoteName($columns))
//         ->values(implode(',', $values));
//       $db->setQuery($insert);
//       $db->execute();
//     }
//   }

//   return true;
// }

// public static function getModuleStatsByYear($phuongxa, $yearSelect)
// {
//   $db = Factory::getDbo();

//   // Xử lý phường/xã
//   if (!empty($phuongxa) && !is_array($phuongxa)) {
//     $phuongxa = explode(',', $phuongxa);
//   }
//   $phuongXaIds = array_map('intval', (array)$phuongxa);
//   $inList = !empty($phuongXaIds) ? implode(',', $phuongXaIds) : '';

//   // Lấy toàn bộ dữ liệu
//   $query = $db->getQuery(true)
//     ->select($db->quoteName(['nam', 'thang', 'tongso', 'phuongxa_id']))
//     ->from($db->quoteName('thongke_module'));
//   if (!empty($inList)) {
//     $query->where('phuongxa_id IN (' . $inList . ')');
//   }
//   $db->setQuery($query);
//   $rows = $db->loadAssocList();

//   if (empty($rows)) {
//     // Nếu không có dữ liệu thì trả về mảng tháng = 0
//     return [array_fill_keys(array_map(fn($m) => 'thang' . $m, range(1, 12)), 0)];
//   }

//   // Gom dữ liệu theo năm/tháng
//   $data = [];
//   $years = [];
//   foreach ($rows as $row) {
//     $y = (int)$row['nam'];
//     $m = (int)$row['thang'];
//     $t = (int)$row['tongso'];
//     if (!isset($data[$y][$m])) $data[$y][$m] = 0;
//     $data[$y][$m] += $t;
//     $years[$y] = true;
//   }

//   // Lấy năm nhỏ nhất và lớn nhất trong dữ liệu
//   $minYear = min(array_keys($years));
//   $maxYear = max(array_keys($years));

//   // Nếu $yearSelect nằm ngoài thì vẫn xử lý nhưng trong khoảng từ minYear đến yearSelect
//   if ($yearSelect < $minYear) $yearSelect = $minYear;
//   if ($yearSelect > $maxYear) $maxYear = $yearSelect; // mở rộng nếu người dùng muốn xem năm chưa có

//   // Bắt đầu cộng dồn từ năm nhỏ nhất
//   $result = array_fill(1, 12, 0);
//   $runningTotal = 0;

//   for ($y = $minYear; $y <= $yearSelect; $y++) {
//     for ($m = 1; $m <= 12; $m++) {
//       $val = isset($data[$y][$m]) ? $data[$y][$m] : 0;
//       $runningTotal += $val;
//       if ($y == $yearSelect) {
//         // Lưu kết quả cho từng tháng của năm được chọn
//         $result[$m] = $runningTotal;
//       }
//     }
//   }

//   // Định dạng trả về
//   $final = [];
//   foreach ($result as $month => $value) {
//     $final['thang' . $month] = $value;
//   }
//   return [$final];
// }

// public function getCountData($phuongxa)
// {
//   $db = Factory::getDbo();

//   $phuongXaIds = array_map('intval', explode(',', $phuongxa));
//   $inList = implode(',', $phuongXaIds);

//   $query = $db->getQuery(true)
//     ->select([
//       $db->quoteName('tm.menu_id', 'menu_id'),
//       $db->quoteName('cm.name', 'menu_name'),
//       $db->quoteName('cm.icon', 'menu_icon'),
//       'SUM(' . $db->quoteName('tm.tongso') . ') AS ' . $db->quoteName('tong_tatca_nam')
//     ])
//     ->from($db->quoteName('thongke_module', 'tm'))
//     ->leftJoin($db->quoteName('core_menu', 'cm') . ' ON ' . $db->quoteName('tm.menu_id') . ' = ' . $db->quoteName('cm.id'))
//     ->where($db->quoteName('tm.phuongxa_id') . ' IN (' . $inList . ')') 
//     ->group($db->quoteName('tm.menu_id'))
//     ->order($db->quoteName('tong_tatca_nam') . ' DESC');

//   $db->setQuery($query);
//   return $db->loadAssocList();
// }