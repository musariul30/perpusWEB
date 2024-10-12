<?php
// admin/edit_book.php
include '../config/db.php';
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM books WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $book = $result->fetch_assoc();
    } else {
        echo "<script>alert('Buku tidak ditemukan!'); window.location.href = 'view_books.php';</script>";
        exit();
    }
}

// Jika form disubmit untuk update data buku
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $shelf = $conn->real_escape_string($_POST['shelf']);
    $stok = (int)$_POST['stok'];

    $update_query = "UPDATE books SET title = '$title', author = '$author', shelf = '$shelf', stok = $stok WHERE id = $id";

    if ($conn->query($update_query) === TRUE) {
        echo "<script>alert('Buku berhasil diperbarui!'); window.location.href = 'view_book.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui buku, coba lagi!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Dashboard Admin</title>
    <!-- Bootstrap 5.3 CDN -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="header bg-teal p-3 text-white text-center">
        <h1>Edit Buku</h1>
    </div>

    <div class="navbar">
        <a href="admin_dashboard.php">Beranda</a>
        <a href="add_book.php">Tambah Buku</a>
        <a href="edit_book.php">Daftar Buku</a>
        <a href="add_user.php">Tambah Pengguna</a>
        <a href="list_user.php">Daftar Pengguna</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="container mt-5">
        <div class="card p-4 shadow-sm">
            <h3 class="mb-4">Form Edit Buku</h3>
            <form method="POST" action="edit_book.php?id=<?= $id; ?>">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Buku:</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= $book['title']; ?>"
                        required>
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Penulis:</label>
                    <input type="text" id="author" name="author" class="form-control" value="<?= $book['author']; ?>">
                </div>
                <div class="mb-3">
                    <label for="shelf" class="form-label">Rak Buku:</label>
                    <input type="text" id="shelf" name="shelf" class="form-control" value="<?= $book['shelf']; ?>"
                        required>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Jumlah Stok:</label>
                    <input type="number" id="stok" name="stok" class="form-control" value="<?= $book['stok']; ?>"
                        min="0" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-teal w-100">Perbarui Buku</button>
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