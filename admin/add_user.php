<?php
include '../config/db.php'; // Pastikan file ini ada dan path sudah benar
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $role = $conn->real_escape_string($_POST['role']); // Disanitasi untuk keamanan

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email tidak valid!');</script>";
    } else {
        $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";

        if ($conn->query($query)) {
            echo "<script>alert('Pengguna berhasil ditambahkan!'); window.location='list_user.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan pengguna: " . $conn->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna - Perpustakaan Sekolah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/header.css">
</head>

<body>

    <div class="header">
        <h1>Tambah Pengguna Baru</h1>
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
            <form method="POST" action="add_user.php">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan Username" required>

                <label>Email</label>
                <input type="email" name="email" placeholder="Masukkan Email" required>

                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan Password" required>

                <label>Role</label>
                <select name="role">
                    <option value="admin">Admin</option>
                    <option value="peminjam">Peminjam</option>
                </select>

                <button type="submit">Tambah Pengguna</button>
            </form>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Perpustakaan Sekolah</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>