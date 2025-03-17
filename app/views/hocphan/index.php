<?php
session_start();
include(__DIR__ . '/../../config/db.php');

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];
$HoTen = $_SESSION['HoTen'];

// Lấy danh sách học phần
$sql = "SELECT * FROM hocphan";
$stmt = $pdo->query($sql);
$hocphans = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh Sách Học Phần</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Danh Sách Học Phần</h2>
        <p>Xin chào, <strong><?= htmlspecialchars($HoTen) ?></strong> (Mã SV: <?= htmlspecialchars($MaSV) ?>)</p>
        <a href="logout.php" class="btn btn-danger">Đăng Xuất</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Mã HP</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Đăng Ký</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hocphans as $hp): ?>
                    <tr>
                        <td><?= htmlspecialchars($hp['MaHP']) ?></td>
                        <td><?= htmlspecialchars($hp['TenHP']) ?></td>
                        <td><?= htmlspecialchars($hp['SoTinChi']) ?></td>
                        <td>
                            <form method="POST" action="dangky.php">
                                <input type="hidden" name="MaHP" value="<?= htmlspecialchars($hp['MaHP']) ?>">
                                <button type="submit" class="btn btn-success">Đăng Ký</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
