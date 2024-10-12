<?php
// admin/add_book.php
include '../config/db.php';
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $shelf = $conn->real_escape_string($_POST['shelf']);
    $stok = (int)$_POST['stok']; // Mengambil stok sebagai integer

    // Masukkan data buku ke tabel books
    $query = "INSERT INTO books (title, author, shelf, stok) VALUES ('$title', '$author', '$shelf', $stok)";

    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Buku berhasil ditambahkan!'); window.location.href = 'add_book.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan, coba lagi!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Dashboard Admin</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Menghubungkan CSS -->
</head>

<body>
    <div class="header bg-teal p-3 text-white text-center">
        <h1>Tambah Buku Baru</h1>
    </div>

    <div class="navbar">
        <a href="admin_dashboard.php">Beranda</a>
        <a href="add_book.php">Tambah Buku</a>
        <a href="view_book.php">Daftar Buku</a>
        <a href="add_user.php">Tambah Pengguna</a>
        <a href="list_user.php">Daftar Pengguna</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="container mt-5">
        <div class="card p-4 shadow-sm">
            <h3 class="mb-4">Form Tambah Buku</h3>
            <form method="POST" action="add_book.php">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Buku:</label>
                    <input type="text" id="title" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Penulis:</label>
                    <input type="text" id="author" name="author" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="shelf" class="form-label">Rak Buku:</label>
                    <input type="text" id="shelf" name="shelf" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Jumlah Stok:</label>
                    <input type="number" id="stok" name="stok" class="form-control" min="0" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-teal w-100">Tambahkan Buku</button>
                </div>
            </form>
        </div>
    </div>

    <div class="footer bg-teal text-white text-center p-3 mt-5">
        <p>&copy; 2024 Perpustakaan Sekolah</p>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>