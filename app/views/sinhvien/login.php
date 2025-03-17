<?php
session_start();
include(__DIR__ . '/../../config/db.php'); // Kết nối database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];

    // Kiểm tra xem sinh viên có tồn tại trong database không
    $sql = "SELECT * FROM sinhvien WHERE MaSV = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$MaSV]);
    $sinhvien = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($sinhvien) {
        $_SESSION['MaSV'] = $sinhvien['MaSV'];
        $_SESSION['HoTen'] = $sinhvien['HoTen'];
        header("Location: hocphan.php"); // Chuyển hướng đến trang học phần
        exit();
    } else {
        $error = "Mã sinh viên không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Đăng Nhập</h2>
        <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="MaSV" class="form-label">Mã Sinh Viên</label>
                <input type="text" class="form-control" name="MaSV" required>
            </div>
            <button type="submit" class="btn btn-primary">Đăng Nhập</button>
        </form>
    </div>
</body>
</html>
