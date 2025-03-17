<?php
session_start();
include(__DIR__ . '/../../config/db.php');

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];

// Lấy danh sách học phần đã đăng ký
$sql = "SELECT hp.MaHP, hp.TenHP, hp.SoTinChi 
        FROM dangkyhocphan dk
        JOIN hocphan hp ON dk.MaHP = hp.MaHP
        WHERE dk.MaSV = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$MaSV]);
$hocphans = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Học Phần Đã Đăng Ký</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Học Phần Đã Đăng Ký</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Mã HP</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Hủy</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hocphans as $hp): ?>
                    <tr>
                        <td><?= htmlspecialchars($hp['MaHP']) ?></td>
                        <td><?= htmlspecialchars($hp['TenHP']) ?></td>
                        <td><?= htmlspecialchars($hp['SoTinChi']) ?></td>
                        <td>
                            <form method="POST" action="huydangky.php">
                                <input type="hidden" name="MaHP" value="<?= htmlspecialchars($hp['MaHP']) ?>">
                                <button type="submit" class="btn btn-danger">Hủy</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
