<?php
session_start();
include(__DIR__ . '/../../config/db.php');

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];

// Xóa từng học phần
if (isset($_GET['delete'])) {
    $MaHP = $_GET['delete'];
    $sql = "DELETE FROM dangky WHERE MaSV = ? AND MaHP = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$MaSV, $MaHP]);
    header("Location: cart.php");
    exit();
}

// Xóa tất cả học phần
if (isset($_GET['clear'])) {
    $sql = "DELETE FROM dangky WHERE MaSV = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$MaSV]);
    header("Location: cart.php");
    exit();
}

// Lấy danh sách học phần đã đăng ký
$sql = "SELECT d.MaHP, h.TenHP, h.SoTinChi 
        FROM dangky d 
        JOIN hocphan h ON d.MaHP = h.MaHP 
        WHERE d.MaSV = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$MaSV]);
$hocphans = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tính tổng tín chỉ
$total_credits = array_sum(array_column($hocphans, 'SoTinChi'));
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
        <h2>Đăng Ký Học Phần</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Mã HP</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hocphans as $hp): ?>
                    <tr>
                        <td><?= htmlspecialchars($hp['MaHP']) ?></td>
                        <td><?= htmlspecialchars($hp['TenHP']) ?></td>
                        <td><?= htmlspecialchars($hp['SoTinChi']) ?></td>
                        <td>
                            <a href="cart.php?delete=<?= htmlspecialchars($hp['MaHP']) ?>" class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><strong>Số học phần: </strong><?= count($hocphans) ?></p>
        <p><strong>Tổng số tín chỉ: </strong><?= $total_credits ?></p>

        <a href="cart.php?clear=1" class="btn btn-warning">Xóa Đăng Ký</a>
        <a href="hocphan.php" class="btn btn-secondary">Tiếp Tục Đăng Ký</a>
    </div>
</body>
</html>
