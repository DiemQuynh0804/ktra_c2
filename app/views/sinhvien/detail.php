<?php
include(__DIR__ . '/../../config/db.php');

if (!isset($_GET['id'])) {
    die("Không tìm thấy ID");
}

$MaSV = $_GET['id'];

$sql = "SELECT * FROM sinhvien WHERE MaSV = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$MaSV]);
$sinhvien = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Sinh Viên</title>
</head>
<body>
    <h1>Chi Tiết Sinh Viên</h1>
    <p>Mã SV: <?= $sinhvien['MaSV'] ?></p>
    <p>Họ Tên: <?= $sinhvien['HoTen'] ?></p>
    <p>Giới Tính: <?= $sinhvien['GioiTinh'] ?></p>
    <p>Ngày Sinh: <?= $sinhvien['NgaySinh'] ?></p>
    <p>Mã Ngành: <?= $sinhvien['MaNganh'] ?></p>
    <p><img src="<?= $sinhvien['Hinh'] ?>" width="100"></p>
    <a href="index.php">Quay lại</a>
</body>
</html>
