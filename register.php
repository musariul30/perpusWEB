<?php
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'peminjam')";
    if ($conn->query($query)) {
        echo "<script>alert('Registrasi berhasil!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Registrasi gagal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Registrasi Pengguna - Perpustakaan Sekolah</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="header">
        <h1>Registrasi Pengguna</h1>
    </div>

    <div class="container">
        <div class="form-container">
            <form method="POST" action="">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan Username" required>

                <label>Email</label>
                <input type="email" name="email" placeholder="Masukkan Email" required>

                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan Password" required>

                <button type="submit">Daftar</button>
            </form>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2023 Perpustakaan Sekolah</p>
    </div>

</body>

</html>