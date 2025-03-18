<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../config/db.php';

// Xử lý thêm học phần
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    $maHP = $_POST["maHP"];
    $tenHP = $_POST["tenHP"];
    $soTinChi = $_POST["soTinChi"];

    $stmt = $conn->prepare("INSERT INTO HocPhan (MaHP, TenHP, SoTinChi) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $maHP, $tenHP, $soTinChi);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Thêm học phần thành công!'); window.location.href='hocphan.php';</script>";
    } else {
        echo "<script>alert('❌ Lỗi: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Lấy danh sách học phần
$sql = "SELECT * FROM HocPhan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Học Phần</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: #f4f6f9;
            text-align: center;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #3498db;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        tr:hover {
            background: #ecf0f1;
        }

        .action-links a {
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 6px;
            margin: 2px;
            display: inline-block;
        }

        .edit {
            background: #27ae60;
            color: white;
        }

        .delete {
            background: #e74c3c;
            color: white;
        }

        .edit:hover {
            background: #218c53;
        }

        .delete:hover {
            background: #c0392b;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 400px;
            margin: 0 auto;
        }

        input, button {
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
            transition: 0.3s;
        }

        input:focus {
            border-color: #3498db;
            outline: none;
        }

        button {
            background: #3498db;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📚 Danh sách Học Phần</h2>
    <table>
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
                <td class="action-links">
                    <a href="edit_hocphan.php?maHP=<?= $row['MaHP'] ?>" class="edit">✏ Sửa</a>
                    <a href="delete_hocphan.php?maHP=<?= $row['MaHP'] ?>" class="delete" onclick="return confirm('Bạn có chắc muốn xóa?')">❌ Xóa</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>➕ Thêm Học Phần</h2>
    <form method="POST">
        <input type="text" name="maHP" placeholder="Mã HP" required>
        <input type="text" name="tenHP" placeholder="Tên HP" required>
        <input type="number" name="soTinChi" placeholder="Số tín chỉ" required>
        <button type="submit" name="add">Thêm</button>
    </form>
</div>

</body>
</html>
