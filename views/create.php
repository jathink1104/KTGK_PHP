<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    // Xử lý upload hình
    $Hinh = $_FILES['Hinh']['name'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["Hinh"]["name"]);
    
    if (move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
                VALUES ('$MaSV', '$HoTen', '$GioiTinh', '$NgaySinh', '$Hinh', '$MaNganh')";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
            exit();
        } else {
            echo "Lỗi: " . $conn->error;
        }
    } else {
        echo "Lỗi khi tải lên hình ảnh.";
    }
}

$sqlNganh = "SELECT * FROM NganhHoc";
$resultNganh = $conn->query($sqlNganh);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="text-center mb-4">Thêm sinh viên</h2>
    <div class="card p-4 shadow-sm">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Mã SV:</label>
                <input type="text" name="MaSV" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Họ Tên:</label>
                <input type="text" name="HoTen" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Giới Tính:</label>
                <select name="GioiTinh" class="form-select">
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Ngày Sinh:</label>
                <input type="date" name="NgaySinh" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Hình:</label>
                <input type="file" name="Hinh" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ngành Học:</label>
                <select name="MaNganh" class="form-select" required>
                    <?php while ($row = $resultNganh->fetch_assoc()): ?>
                        <option value="<?= $row['MaNganh'] ?>"><?= $row['TenNganh'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Thêm</button>
        </form>
    </div>
</body>
</html>