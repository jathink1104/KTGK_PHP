<?php
include '../config/db.php';
$MaSV = $_GET['MaSV'];
$sql = "SELECT SinhVien.*, NganhHoc.TenNganh FROM SinhVien 
        LEFT JOIN NganhHoc ON SinhVien.MaNganh = NganhHoc.MaNganh
        WHERE MaSV = '$MaSV'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: #ffffff;
        }

        .card-title {
            color: #007bff;
            font-weight: bold;
            text-transform: uppercase;
        }

        .profile-img {
            border-radius: 50%;
            border: 4px solid #dee2e6;
            width: 150px;
            height: 150px;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .info p {
            font-size: 16px;
            font-weight: 500;
            color: #495057;
        }

        .btn-custom {
            border-radius: 8px;
            font-weight: bold;
            padding: 10px 15px;
            background: #007bff;
            border: none;
            color: white;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card p-4 text-center">
            <h2 class="card-title">🎓 Chi tiết sinh viên</h2>
            <div class="mt-4">
                <img src="../uploads/<?= $row['Hinh'] ?>" class="profile-img">
            </div>
            <div class="info mt-3 text-start">
                <p><strong>📌 Mã SV:</strong> <?= $row['MaSV'] ?></p>
                <p><strong>👤 Họ Tên:</strong> <?= $row['HoTen'] ?></p>
                <p><strong>⚥ Giới Tính:</strong> <?= $row['GioiTinh'] ?></p>
                <p><strong>🎂 Ngày Sinh:</strong> <?= $row['NgaySinh'] ?></p>
                <p><strong>📖 Ngành Học:</strong> <?= $row['TenNganh'] ?></p>
            </div>
            <div class="mt-4">
                <a href="index.php" class="btn btn-custom">🔙 Quay lại danh sách</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
