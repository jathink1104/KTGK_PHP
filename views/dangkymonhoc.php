<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../config/db.php';

session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION["maSV"])) {
    echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='../login.php';</script>";
    exit();
}

$maSV = $_SESSION["maSV"];

// Lấy thông tin sinh viên
$sql_sv = "SELECT MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh
           FROM SinhVien WHERE MaSV = ?";
$stmt = $conn->prepare($sql_sv);
$stmt->bind_param("s", $maSV);
$stmt->execute();
$result_sv = $stmt->get_result();
$sinhvien = $result_sv->fetch_assoc();

// Lấy danh sách học phần
$sql = "SELECT * FROM HocPhan";
$result = $conn->query($sql);

// Xử lý đăng ký học phần
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $maHP = $_POST["maHP"];

    // Kiểm tra sinh viên đã đăng ký học phần chưa
    $check_sql = "SELECT * FROM ChiTietDangKy 
                  JOIN DangKy ON ChiTietDangKy.MaDK = DangKy.MaDK
                  WHERE DangKy.MaSV = ? AND ChiTietDangKy.MaHP = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ss", $maSV, $maHP);
    $stmt->execute();
    $result_check = $stmt->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>alert('⚠ Học phần này đã được đăng ký trước đó!');</script>";
    } else {
        // Kiểm tra xem sinh viên đã có MaDK chưa
        $check_dk_sql = "SELECT MaDK FROM DangKy WHERE MaSV = ?";
        $stmt = $conn->prepare($check_dk_sql);
        $stmt->bind_param("s", $maSV);
        $stmt->execute();
        $result_dk = $stmt->get_result();

        if ($result_dk->num_rows > 0) {
            $row = $result_dk->fetch_assoc();
            $maDK = $row["MaDK"];
        } else {
            // Nếu chưa có, tạo mới
            $insert_dk = "INSERT INTO DangKy (MaSV, NgayDK) VALUES (?, NOW())";
            $stmt = $conn->prepare($insert_dk);
            $stmt->bind_param("s", $maSV);
            $stmt->execute();
            $maDK = $conn->insert_id;
        }

        // Thêm vào bảng ChiTietDangKy
        $insert_ctdk = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_ctdk);
        $stmt->bind_param("is", $maDK, $maHP);
        if ($stmt->execute()) {
            echo "<script>alert('✅ Đăng ký học phần thành công!'); window.location.href='dangkymonhoc.php';</script>";
        } else {
            echo "<script>alert('❌ Lỗi: " . $stmt->error . "');</script>";
        }
    }
}

// Xử lý xóa học phần
if (isset($_GET["delete"])) {
    $maDK = $_GET["delete"];
    $delete_sql = "DELETE FROM ChiTietDangKy WHERE MaDK = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $maDK);
    if ($stmt->execute()) {
        echo "<script>alert('✅ Xóa học phần thành công!'); window.location.href='dangkymonhoc.php';</script>";
    } else {
        echo "<script>alert('❌ Lỗi khi xóa học phần');</script>";
    }
}

// Xử lý xóa tất cả đăng ký
if (isset($_POST["delete_all"])) {
    $delete_all_sql = "DELETE FROM ChiTietDangKy WHERE MaDK IN (SELECT MaDK FROM DangKy WHERE MaSV = ?)";
    $stmt = $conn->prepare($delete_all_sql);
    $stmt->bind_param("s", $maSV);
    if ($stmt->execute()) {
        echo "<script>alert('✅ Xóa tất cả học phần thành công!'); window.location.href='dangkymonhoc.php';</script>";
    }
}

// Lấy danh sách học phần đã đăng ký của sinh viên
$sql_dk = "SELECT ChiTietDangKy.MaDK, HocPhan.MaHP, HocPhan.TenHP, HocPhan.SoTinChi, DangKy.NgayDK
           FROM ChiTietDangKy
           JOIN HocPhan ON ChiTietDangKy.MaHP = HocPhan.MaHP
           JOIN DangKy ON ChiTietDangKy.MaDK = DangKy.MaDK
           WHERE DangKy.MaSV = ?";
$stmt = $conn->prepare($sql_dk);
$stmt->bind_param("s", $maSV);
$stmt->execute();
$registered_courses = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký Học Phần</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<h2>👨‍🎓 Thông Tin Sinh Viên</h2>
    <table border="1">
        <tr>
            <th>Mã Sinh Viên</th>
            <td><?= $sinhvien["MaSV"] ?></td>
        </tr>
        <tr>
            <th>Họ Tên</th>
            <td><?= $sinhvien["HoTen"] ?></td>
        </tr>
        <tr>
            <th>Giới Tính</th>
            <td><?= $sinhvien["GioiTinh"] ?></td>
        </tr>
        <tr>
            <th>Ngày Sinh</th>
            <td><?= $sinhvien["NgaySinh"] ?></td>
        </tr>
        <tr>
            <th>Ảnh Đại Diện</th>
            <td>
                <img src="../uploads/<?= $sinhvien["Hinh"] ?>" alt="Ảnh sinh viên" width="100">
            </td>
        </tr>
        <tr>
            <th>Mã Ngành</th>
            <td><?= $sinhvien["MaNganh"] ?></td>
        </tr>
    </table>
    <h2>📚 Danh sách Học Phần</h2>
    <table border="1">
        <tr>
            <th>Mã HP</th>
            <th>Tên HP</th>
            <th>Số tín chỉ</th>
            <th>Hành động</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?= $row["MaHP"] ?></td>
                <td><?= $row["TenHP"] ?></td>
                <td><?= $row["SoTinChi"] ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="maHP" value="<?= $row['MaHP'] ?>">
                        <button type="submit" name="register">Đăng ký</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>🛒 Học phần đã đăng ký</h2>
    <table border="1">
        <tr>
            <th>Mã HP</th>
            <th>Tên HP</th>
            <th>Số tín chỉ</th>
            <th>Ngày Đăng Ký</th>
            <th>Hành động</th>
        </tr>
        <?php while ($row = $registered_courses->fetch_assoc()) : ?>
            <tr>
                <td><?= $row["MaHP"] ?></td>
                <td><?= $row["TenHP"] ?></td>
                <td><?= $row["SoTinChi"] ?></td>
                <td><?= $row["NgayDK"] ?></td>
                <td>
                    <a href="dangkymonhoc.php?delete=<?= $row['MaDK'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">❌ Xóa</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <form method="POST">
        <button type="submit" name="delete_all" onclick="return confirm('Bạn có chắc muốn xóa tất cả đăng ký?')">🗑 Xóa tất cả</button>
    </form>

</body>
</html>
