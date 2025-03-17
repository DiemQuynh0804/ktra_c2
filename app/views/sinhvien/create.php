<?php
include(__DIR__ . '/../../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    // Xử lý upload hình ảnh
    $targetDir = __DIR__ . "/../../app/images/"; // Đường dẫn thư mục ảnh
    $fileName = time() . "_" . basename($_FILES["Hinh"]["name"]); // Thêm timestamp để tránh trùng tên
    $targetFilePath = $targetDir . $fileName;
    
    if (!empty($_FILES["Hinh"]["name"])) {
        if (move_uploaded_file($_FILES["Hinh"]["tmp_name"], $targetFilePath)) {
            $Hinh = $fileName; // Chỉ lưu tên file, không lưu cả đường dẫn
        } else {
            $Hinh = null;
        }
    } else {
        $Hinh = null;
    }
    

    // Thêm dữ liệu vào database
    $sql = "INSERT INTO sinhvien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$MaSV, $HoTen, $GioiTinh, $NgaySinh, $Hinh, $MaNganh]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Sinh Viên</title>
</head>
<body>
    <h1>Thêm Sinh Viên</h1>
    <form method="POST" enctype="multipart/form-data">
        Mã SV: <input type="text" name="MaSV" required><br>
        Họ Tên: <input type="text" name="HoTen" required><br>
        Giới Tính: 
        <select name="GioiTinh">
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select><br>
        Ngày Sinh: <input type="date" name="NgaySinh" required><br>
        Hình: <input type="file" name="Hinh"><br>
        Ngành: <input type="text" name="MaNganh" required><br>
        <button type="submit">Thêm</button>
    </form>
</body>
</html>
