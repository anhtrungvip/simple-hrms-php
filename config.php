<?php
// =====================================================
// FILE: config.php
// CHỨC NĂNG: Kết nối PHP với MySQL Server
// VỊ TRÍ LƯU: C:\xampp\htdocs\qlns\config.php
// =====================================================

// Thông tin kết nối MySQL Server
$host = 'localhost';        // Địa chỉ server (localhost = máy tính này)
$dbname = 'hrms_database';  // Tên database vừa tạo
$username = 'root';         // Username MySQL (mặc định XAMPP là root)
$password = '';             // Password (mặc định XAMPP để trống)

// Kết nối đến MySQL Server bằng PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Nếu kết nối thành công, biến $conn sẽ dùng để thao tác database
} catch(PDOException $e) {
    die("Lỗi kết nối MySQL Server: " . $e->getMessage());
}
?>