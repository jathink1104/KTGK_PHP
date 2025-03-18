<?php
include '../config/db.php';

if (isset($_GET['MaSV'])) {
    $MaSV = $_GET['MaSV'];

    // Xóa sinh viên
    $sql = "DELETE FROM SinhVien WHERE MaSV='$MaSV'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Lỗi xóa: " . $conn->error;
    }
}
?>
