<?php
// admin/view_user.php
include '../config/db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'];

$query = "SELECT * FROM users WHERE id='$id'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "<script>alert('Pengguna tidak ditemukan!'); window.location='list_user.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Pengguna - Perpustakaan Sekolah</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <div class="header">
        <h1>Detail Pengguna</h1>
    </div>

    <div class="navbar">
        <a href="admin_dashboard.php">Beranda</a>
        <a href="add_book.php">Tambah Buku</a>
        <a href="view_book.php">Daftar Buku</a>
        <a href="add_user.php">Tambah Pengguna</a>
        <a href="list_user.php">Daftar Pengguna</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="container">
        <p><strong>ID:</strong> <?php echo $user['id']; ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Role:</strong> <?php echo $user['role']; ?></p>
        <p><strong>Created At:</strong> <?php echo $user['created_at']; ?></p>
    </div>

    <div class="footer">
        <p>&copy; 2023 Perpustakaan Sekolah</p>
    </div>

</body>

</html>