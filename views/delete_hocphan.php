<?php
include '../config/db.php';

// Lấy mã học phần cần xóa
if (isset($_GET["maHP"])) {
    $maHP = $_GET["maHP"];

    // Xóa học phần
    $stmt = $conn->prepare("DELETE FROM HocPhan WHERE MaHP = ?");
    $stmt->bind_param("s", $maHP);
    
    if ($stmt->execute()) {
        echo "<script>alert('✅ Xóa học phần thành công!'); window.location.href='hocphan.php';</script>";
    } else {
        echo "<script>alert('❌ Lỗi: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}
?>
