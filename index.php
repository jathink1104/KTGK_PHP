<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sinh Viên</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: #f0f2f5;
        }

        .navbar {
            display: flex;
            justify-content: center;
            background: red;
            padding: 12px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            margin: 0 8px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 20px;
            transition: 0.3s;
        }

        .navbar a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        iframe {
            width: 100%;
            height: 600px;
            border: none;
            border-radius: 8px; 
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="views/index.php" target="contentFrame">📋 Quản lý Sinh Viên</a>
        <a href="views/hocphan.php" target="contentFrame">📚 Quản lý Học Phần</a>
        <a href="views/login.php" target="contentFrame">📝 Đăng ký Học Phần</a>
        <a href="views/login.php" target="contentFrame">🔐 Đăng nhập</a>
    </div>

    <div class="container">
        <iframe name="contentFrame" src="views/index.php"></iframe>
    </div>

</body>
</html>
