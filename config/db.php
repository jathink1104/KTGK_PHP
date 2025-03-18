<?php
$servername = "localhost"; // Đổi nếu cần
$username = "root"; // Tài khoản mặc định của XAMPP
$password = ""; // Mật khẩu (mặc định là rỗng)
$database = "Test1"; // Tên database

$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Lỗi kết nối: " . $conn->connect_error);
}
?>
