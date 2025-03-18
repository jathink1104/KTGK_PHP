<?php
include '../config/db.php';

$sql = "SELECT SinhVien.*, NganhHoc.TenNganh FROM SinhVien 
        LEFT JOIN NganhHoc ON SinhVien.MaNganh = NganhHoc.MaNganh";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Danh sách sinh viên</h2>
        <div class="d-flex justify-content-end mb-3">
            <a href="create.php" class="btn btn-primary">Thêm sinh viên</a>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Mã SV</th>
                    <th>Họ Tên</th>
                    <th>Giới Tính</th>
                    <th>Ngày Sinh</th>
                    <th>Hình</th>
                    <th>Ngành</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../config/db.php';
                $sql = "SELECT SinhVien.*, NganhHoc.TenNganh FROM SinhVien 
                        LEFT JOIN NganhHoc ON SinhVien.MaNganh = NganhHoc.MaNganh";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['MaSV'] ?></td>
                    <td><?= $row['HoTen'] ?></td>
                    <td><?= $row['GioiTinh'] ?></td>
                    <td><?= $row['NgaySinh'] ?></td>
                    <td><img src="../uploads/<?= $row['Hinh'] ?>" width="50" class="img-thumbnail"></td>
                    <td><?= $row['TenNganh'] ?></td>
                    <td>
                        <a href="edit.php?MaSV=<?= $row['MaSV'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="delete.php?MaSV=<?= $row['MaSV'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa sinh viên này?')">Xóa</a>
                        <a href="detail.php?MaSV=<?= $row['MaSV'] ?>" class="btn btn-info btn-sm">Xem</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>