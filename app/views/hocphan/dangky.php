<?php
session_start();
include(__DIR__ . '/../../config/db.php');

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['MaHP'])) {
    $MaHP = $_POST['MaHP'];

    // Kiểm tra xem đã đăng ký học phần này chưa
    $sql_check = "SELECT * FROM dangkyhocphan WHERE MaSV = ? AND MaHP = ?";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([$MaSV, $MaHP]);

    if ($stmt_check->rowCount() > 0) {
        echo "<script>alert('Bạn đã đăng ký học phần này rồi!'); window.location='hocphan.php';</script>";
    } else {
        // Thêm vào bảng đăng ký học phần
        $sql_insert = "INSERT INTO dangkyhocphan (MaSV, MaHP) VALUES (?, ?)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->execute([$MaSV, $MaHP]);

        echo "<script>alert('Đăng ký học phần thành công!'); window.location='hocphan.php';</script>";
    }
}
?>
