<?php
// admin/edit_user.php
include '../config/db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'];

// Mengambil data pengguna
$query = "SELECT * FROM users WHERE id='$id'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "<script>alert('Pengguna tidak ditemukan!'); window.location='list_users.php';</script>";
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $_POST['role'];

    $query = "UPDATE users SET username='$username', email='$email', role='$role' WHERE id='$id'";
    if ($conn->query($query)) {
        echo "<script>alert('Pengguna berhasil diupdate!'); window.location='list_users.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate pengguna!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Pengguna - Perpustakaan Sekolah</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <div class="header">
        <h1>Edit Pengguna</h1>
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
        <div class="form-container">
            <form method="POST" action="">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <label>Role</label>
                <select name="role">
                    <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="peminjam" <?php if ($user['role'] == 'peminjam') echo 'selected'; ?>>Peminjam
                    </option>
                </select>

                <button type="submit">Update Pengguna</button>
            </form>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2023 Perpustakaan Sekolah</p>
    </div>

</body>

</html>