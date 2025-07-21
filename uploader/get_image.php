<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$code = $_GET['code'] ?? null;
$folder = $_GET['folder'] ?? null;

if(empty($folder) || $folder === null){
    $uri = $_SERVER['REQUEST_URI'];
    $part = parse_url($uri, PHP_URL_PATH); // /uploader/get_image.php/upload/2025/7
    $parts = explode('/uploader/get_image.php/', $part);
    $folder = isset($parts[1]) ? $parts[1] : null;
}

// Loại bỏ phần đầu để chỉ còn "upload/2025/7"

if (!$code) {
    die("❌ Không có mã code ảnh!");
}

// ⚡ Tạo đường dẫn đến file trong tmp
$filePath = "C:/xampp/htdocs/Joomla_511/". $folder. "/" . $code;

// 🔍 Kiểm tra file tồn tại
if (!file_exists($filePath)) {
    die("❌ File không tồn tại: " . $filePath);
}

// 🔥 Lấy MIME Type từ Database (Ví dụ: image/jpeg)
// $mysqli = new mysqli("10.49.41.247", "pxdnict", "PX@2024!@#", "phuongxa_2025");
$mysqli = new mysqli("10.49.41.247:7306", "root", "database@Mysql8.0@", "phuongxa_2025");
// $mysqli = new mysqli("localhost:3306", "pxdnict", "PX@2024!@#", "phuongxa_2025");
if ($mysqli->connect_error) {
    die("Kết nối database thất bại: " . $mysqli->connect_error);
}

$sql = "SELECT mime FROM core_attachment WHERE code = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $code);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("❌ Không tìm thấy thông tin MIME trong database.");
}

$mimeType = $row['mime']; // VD: image/jpeg
$stmt->close();
$mysqli->close();

// ✅ Trả về ảnh với đúng MIME Type
header("Content-Type: " . $mimeType);
readfile($filePath);
exit;
?>