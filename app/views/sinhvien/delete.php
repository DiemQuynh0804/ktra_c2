<?php
include(__DIR__ . '/../../config/db.php');

$MaSV = $_GET['id'];

$sql = "DELETE FROM sinhvien WHERE MaSV = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$MaSV]);

header("Location: index.php");
exit();
?>
