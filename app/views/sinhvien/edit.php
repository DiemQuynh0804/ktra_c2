<?php
include(__DIR__ . '/../../config/db.php');

if (!isset($_GET['id'])) {
    die("Không tìm thấy ID");
}

$MaSV = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    // Xử lý cập nhật hình ảnh (nếu có)
    if (!empty($_FILES["Hinh"]["name"])) {
        $targetDir = "/Content/images/";
        $fileName = basename($_FILES["Hinh"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        move_uploaded_file($_FILES["Hinh"]["tmp_name"], __DIR__ . "/../../" . $targetFilePath);
        $sql = "UPDATE sinhvien SET HoTen=?, GioiTinh=?, NgaySinh=?, Hinh=?, MaNganh=? WHERE MaSV=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$HoTen, $GioiTinh, $NgaySinh, $targetFilePath, $MaNganh, $MaSV]);
    } else {
        $sql = "UPDATE sinhvien SET HoTen=?, GioiTinh=?, NgaySinh=?, MaNganh=? WHERE MaSV=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$HoTen, $GioiTinh, $NgaySinh, $MaNganh, $MaSV]);
    }

    header("Location: index.php");
    exit();
}

// Lấy dữ liệu sinh viên để hiển thị
$sql = "SELECT * FROM sinhvien WHERE MaSV = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$MaSV]);
$sinhvien = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh Sửa Sinh Viên</title>
</head>
<body>
    <h1>Chỉnh Sửa Sinh Viên</h1>
    <form method="POST" enctype="multipart/form-data">
        Họ Tên: <input type="text" name="HoTen" value="<?= $sinhvien['HoTen'] ?>" required><br>
        Giới Tính: 
        <select name="GioiTinh">
            <option value="Nam" <?= $sinhvien['GioiTinh'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
            <option value="Nữ" <?= $sinhvien['GioiTinh'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
        </select><br>
        Ngày Sinh: <input type="date" name="NgaySinh" value="<?= $sinhvien['NgaySinh'] ?>" required><br>
        Hình: <input type="file" name="Hinh"><br>
        <img src="<?= $sinhvien['Hinh'] ?>" width="80"><br>
        Mã Ngành: <input type="text" name="MaNganh" value="<?= $sinhvien['MaNganh'] ?>" required><br>
        <button type="submit">Cập Nhật</button>
    </form>
</body>
</html>
