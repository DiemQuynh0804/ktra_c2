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

    // Xóa đăng ký học phần
    $sql_delete = "DELETE FROM dangkyhocphan WHERE MaSV = ? AND MaHP = ?";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->execute([$MaSV, $MaHP]);

    echo "<script>alert('Đã hủy đăng ký học phần!'); window.location='dshocphan.php';</script>";
}
?>
