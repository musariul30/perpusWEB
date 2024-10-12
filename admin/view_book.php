<?php
// admin/view_books.php
include '../config/db.php';
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

// Query untuk mendapatkan semua buku dari database
$query = "SELECT * FROM books";
$result = $conn->query($query);

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM books WHERE id = $delete_id";

    if ($conn->query($delete_query) === TRUE) {
        echo "<script>alert('Buku berhasil dihapus!'); window.location.href = 'view_book.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus buku, coba lagi!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Admin</title>
    <!-- Bootstrap 5.3 CDN -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="header bg-teal p-3 text-white text-center">
        <h1>Daftar Buku</h1>
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
        <table class="table table-bordered">
            <thead class="bg-teal text-white">
                <tr>
                    <th>ID</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Rak Buku</th>
                    <th>Jumlah Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['title']; ?></td>
                    <td><?= $row['author']; ?></td>
                    <td><?= $row['shelf']; ?></td>
                    <td><?= $row['stok']; ?></td>
                    <td>
                        <a href="edit_book.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="view_book.php?delete_id=<?= $row['id']; ?>"
                            onclick="return confirm('Yakin ingin menghapus buku ini?');"
                            class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="footer bg-teal text-white text-center p-3 mt-5">
        <p>&copy; 2024 Perpustakaan Sekolah</p>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>