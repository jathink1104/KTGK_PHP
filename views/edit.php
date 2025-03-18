<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../config/db.php';

$MaSV = $_GET['MaSV'];
$sql = "SELECT * FROM SinhVien WHERE MaSV = '$MaSV'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$sqlNganh = "SELECT * FROM NganhHoc";
$resultNganh = $conn->query($sqlNganh);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    if (!empty($_FILES['Hinh']['name'])) {
        $Hinh = $_FILES['Hinh']['name'];
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["Hinh"]["name"]);
        move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file);
    } else {
        $Hinh = $row['Hinh'];
    }

    $sqlUpdate = "UPDATE SinhVien SET HoTen='$HoTen', GioiTinh='$GioiTinh', NgaySinh='$NgaySinh', Hinh='$Hinh', MaNganh='$MaNganh' WHERE MaSV='$MaSV'";

    if ($conn->query($sqlUpdate) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Lỗi cập nhật: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background: #ffffff;
        }

        .card-title {
            color: #007bff;
            font-weight: bold;
        }

        input, select {
            border-radius: 8px;
        }

        input:focus, select:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }

        .form-control {
            padding: 10px;
        }

        .btn {
            border-radius: 8px;
            font-weight: bold;
            padding: 10px 15px;
        }

        .btn-primary {
            background: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background: #545b62;
        }

        .img-thumbnail {
            border-radius: 12px;
            width: 120px;
            height: auto;
            border: 2px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card p-4 shadow-lg">
            <h2 class="text-center card-title">🎓 Chỉnh sửa sinh viên</h2>
            <form method="post" enctype="multipart/form-data" class="mt-3">
                <div class="mb-3">
                    <label class="form-label">Họ Tên:</label>
                    <input type="text" name="HoTen" class="form-control" value="<?= $row['HoTen'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giới Tính:</label>
                    <select name="GioiTinh" class="form-select">
                        <option value="Nam" <?= ($row['GioiTinh'] == 'Nam') ? 'selected' : '' ?>>Nam</option>
                        <option value="Nữ" <?= ($row['GioiTinh'] == 'Nữ') ? 'selected' : '' ?>>Nữ</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày Sinh:</label>
                    <input type="date" name="NgaySinh" class="form-control" value="<?= $row['NgaySinh'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hình:</label>
                    <input type="file" name="Hinh" class="form-control">
                    <div class="mt-2 text-center">
                        <img src="../uploads/<?= $row['Hinh'] ?>" class="img-thumbnail">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngành Học:</label>
                    <select name="MaNganh" class="form-select" required>
                        <?php while ($nganh = $resultNganh->fetch_assoc()): ?>
                            <option value="<?= $nganh['MaNganh'] ?>" <?= ($row['MaNganh'] == $nganh['MaNganh']) ? 'selected' : '' ?>>
                                <?= $nganh['TenNganh'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
                    <a href="index.php" class="btn btn-secondary">🔙 Quay lại</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
