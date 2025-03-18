<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION["maSV"])) {
    header("Location: login.php");
    exit();
}

$maSV = $_SESSION["maSV"];

// Xóa học phần
if (isset($_GET["xoa"])) {
    $maHP = $_GET["xoa"];
    $conn->query("DELETE FROM ChiTietDangKy WHERE MaHP = '$maHP'");
    echo "<script>alert('Đã xóa học phần!'); window.location='giohang.php';</script>";
}

// Lấy danh sách học phần đã đăng ký
$sql = "SELECT HocPhan.* FROM ChiTietDangKy 
        JOIN DangKy ON ChiTietDangKy.MaDK = DangKy.MaDK
        JOIN HocPhan ON ChiTietDangKy.MaHP = HocPhan.MaHP
        WHERE DangKy.MaSV = '$maSV'";
$result = $conn->query($sql);
?>
    
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Học phần đã đăng ký</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

    <h2>📋 Học phần đã đăng ký</h2>
    <ul>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <li><?= $row["TenHP"] ?> <a href="?xoa=<?= $row["MaHP"] ?>" style="color: red;">[Xóa]</a></li>
        <?php endwhile; ?>
    </ul>

</body>
</html>
