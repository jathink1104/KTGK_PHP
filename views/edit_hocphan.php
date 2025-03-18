<?php
include '../config/db.php';

// Lấy mã học phần cần sửa
if (isset($_GET["maHP"])) {
    $maHP = $_GET["maHP"];
    $sql = "SELECT * FROM HocPhan WHERE MaHP = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $maHP);
    $stmt->execute();
    $result = $stmt->get_result();
    $hocphan = $result->fetch_assoc();
}

// Xử lý cập nhật
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $tenHP = $_POST["tenHP"];
    $soTinChi = $_POST["soTinChi"];

    $stmt = $conn->prepare("UPDATE HocPhan SET TenHP = ?, SoTinChi = ? WHERE MaHP = ?");
    $stmt->bind_param("sis", $tenHP, $soTinChi, $maHP);
    
    if ($stmt->execute()) {
        echo "<script>alert('✅ Cập nhật thành công!'); window.location.href='hocphan.php';</script>";
    } else {
        echo "<script>alert('❌ Lỗi: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Học Phần</title>
</head>
<body>
    <h2>✏ Sửa Học Phần</h2>
    <form method="POST">
        <label>Tên HP:</label>
        <input type="text" name="tenHP" value="<?= $hocphan['TenHP'] ?>" required>
        <label>Số tín chỉ:</label>
        <input type="number" name="soTinChi" value="<?= $hocphan['SoTinChi'] ?>" required>
        <button type="submit" name="update">Cập nhật</button>
    </form>
</body>
</html>
