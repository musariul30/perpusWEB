<?php
// detail_buku.php
include 'config/db.php';
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['admin'])) {
    // Jika belum login, arahkan ke halaman login
    header('Location: login.php');
    exit();
}

// Proses pengembalian buku
if (isset($_GET['return'])) {
    $query = "UPDATE books SET available = 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        // Redirect kembali ke halaman detail dengan pesan sukses
        header('Location: detail_buku.php?book_id=' . $book_id . '&status=returned');
    } else {
        // Redirect kembali ke halaman detail dengan pesan error
        header('Location: detail_buku.php?book_id=' . $book_id . '&status=error');
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <h2>Detail Buku</h2>

        <!-- Pesan status pengembalian -->
        <?php
        if (isset($_GET['status']) && $_GET['status'] == 'returned') {
            echo "<div class='alert alert-success'>Buku berhasil dikembalikan!</div>";
        } elseif (isset($_GET['status']) && $_GET['status'] == 'error') {
            echo "<div class='alert alert-danger'>Terjadi kesalahan saat mengembalikan buku. Coba lagi nanti.</div>";
        }
        ?>

        <!-- Detail Buku -->
        <table class="table table-bordered">
            <tr>
                <th>Judul Buku</th>
                <td><?= $book['title']; ?></td>
            </tr>
            <tr>
                <th>Penulis</th>
                <td><?= $book['author']; ?></td>
            </tr>
            <tr>
                <th>Rak Buku</th>
                <td><?= $book['shelf']; ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <?= $book['available'] ? "<span class='badge bg-success'>Tersedia</span>" : "<span class='badge bg-danger'>Dipinjam</span>"; ?>
                </td>
            </tr>
        </table>

        <!-- Opsi kembalikan buku -->
        <?php if (!$book['available']) : ?>
            <a href="detail_buku.php?book_id=<?= $book_id ?>&return=true" class="btn btn-warning">Kembalikan Buku</a>
        <?php endif; ?>

        <a href="user_dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>