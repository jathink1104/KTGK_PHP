<?php
session_start();
include '../config/db.php';

$error = ""; // Biến lưu thông báo lỗi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maSV = trim($_POST["maSV"]);

    // Sử dụng Prepared Statement để tránh SQL Injection
    $sql = "SELECT * FROM SinhVien WHERE MaSV = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $maSV);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION["maSV"] = $maSV;
        header("Location: dangkymonhoc.php"); // Điều hướng đến trang đăng ký học phần
        exit();
    } else {
        $error = "❌ Mã sinh viên không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

    <h2>🔑 Đăng nhập</h2>

    <?php if ($error): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="maSV" placeholder="Nhập mã sinh viên" required>
        <button type="submit">Đăng nhập</button>
    </form>

</body>
</html>
