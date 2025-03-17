<?php
include(__DIR__ . '/../../config/db.php');

$sql = "SELECT * FROM sinhvien";
$stmt = $pdo->query($sql);
$sinhviens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Sinh Viên</title>
</head>
<body>
    <h1>TRANG SINH VIÊN</h1>
    <a href="create.php">Thêm Sinh Viên</a>
    <table border="1">
        <tr>
            <th>MaSV</th>
            <th>Họ Tên</th>
            <th>Giới Tính</th>
            <th>Ngày Sinh</th>
            <th>Hình</th>
            <th>Ngành</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($sinhviens as $sv): ?>
            <tr>
                <td><?= isset($sv['MaSV']) ? htmlspecialchars($sv['MaSV']) : 'N/A' ?></td>
                <td><?= isset($sv['HoTen']) ? htmlspecialchars($sv['HoTen']) : 'N/A' ?></td>
                <td><?= isset($sv['GioiTinh']) ? htmlspecialchars($sv['GioiTinh']) : 'N/A' ?></td>
                <td><?= isset($sv['NgaySinh']) ? htmlspecialchars($sv['NgaySinh']) : 'N/A' ?></td>
                <td>
                    <?php if (!empty($sv['Hinh'])): ?>
                        <img src="/php/kiemtra/app/images/<?= basename($sv['Hinh']) ?>" width="80">
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>

                <td><?= isset($sv['MaNganh']) ? htmlspecialchars($sv['MaNganh']) : 'N/A' ?></td>
                <td>
                    <a href="edit.php?id=<?= $sv['MaSV'] ?>">Edit</a> |
                    <a href="detail.php?id=<?= $sv['MaSV'] ?>">Details</a> |
                    <a href="delete.php?id=<?= $sv['MaSV'] ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
