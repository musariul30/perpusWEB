<?php
// user_dashboard.php
include 'config/db.php';
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['admin'])) {
    // Jika belum login, arahkan ke halaman login
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['admin']['id']; // Mengambil ID pengguna dari session

// Ambil data buku dari tabel books
$query = "SELECT * FROM books";
$result = $conn->query($query);

// Fungsi untuk logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header.css">
</head>

<body>

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="index.php">Home</a></li>
                            <li class="scroll-to-section"><a href="#daftarBuku" class="active">Daftar Buku</a></li>
                            <li class="scroll-to-section"><a href="#about">About</a></li>
                            <li class="gradient-button"><a href="user_dashboard.php?logout=true">Log Out</a></li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Main Content Start ***** -->
    <div class="main-banner">
        <div class="py-5 text-black text-center">
            <div class="container">
                <h1>Selamat datang, <?= $_SESSION['admin']['username']; ?>!</h1>
                <p></p>
            </div>
        </div>

        <div class="container my-5">
            <!-- Pesan status setelah pinjam atau kembalikan buku -->
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                echo "<div class='alert alert-success'>Buku berhasil dipinjam atau dikembalikan!</div>";
            } elseif (isset($_GET['status']) && $_GET['status'] == 'error') {
                echo "<div class='alert alert-danger'>Terjadi kesalahan saat meminjam atau mengembalikan buku. Coba lagi nanti.</div>";
            }
            ?>

            <div class="row mb-4">
                <div class="col text-center">
                    <h2>Daftar Buku Perpustakaan</h2>
                    <p>Silakan pinjam atau kembalikan buku yang tersedia.</p>
                </div>
            </div>

            <div class="row" id="daftarBuku">
                <div class="col">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Rak Buku</th>
                                <th>Stok</th>
                                <th>Pinjam</th>
                                <th>Kembalikan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Tampilkan setiap buku dalam tabel
                            if ($result->num_rows > 0) {
                                while ($book = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $book['title'] . "</td>";
                                    echo "<td>" . $book['author'] . "</td>";
                                    echo "<td>" . $book['shelf'] . "</td>";
                                    echo "<td>" . $book['stok'] . "</td>";
                                    echo "<td>";

                                    // Cek apakah pengguna sudah meminjam buku ini dan belum mengembalikannya
                                    $checkBorrowQuery = "SELECT * FROM peminjam WHERE user_id = ? AND book_id = ? AND return_date IS NULL";
                                    $stmt = $conn->prepare($checkBorrowQuery);
                                    $stmt->bind_param("ii", $user_id, $book['id']);
                                    $stmt->execute();
                                    $resultBorrow = $stmt->get_result();

                                    if ($resultBorrow->num_rows > 0) {
                                        // Jika sudah dipinjam dan belum dikembalikan, nonaktifkan tombol pinjam
                                        echo "<button class='btn btn-sm btn-secondary' disabled>Sudah Dipinjam</button>";
                                    } else {
                                        // Opsi pinjam buku
                                        if ($book['stok'] > 0) {
                                            echo "<a href='pinjam.php?book_id=" . $book['id'] . "' class='btn btn-sm btn-success'>Pinjam</a>";
                                        } else {
                                            echo "<span class='text-muted'>Tidak tersedia</span>";
                                        }
                                    }

                                    echo "</td><td>";

                                    // Opsi kembalikan buku
                                    echo "<a href='kembalikan.php?book_id=" . $book['id'] . "' class='btn btn-sm btn-warning'>Kembalikan</a>";

                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>Tidak ada buku tersedia.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Content End ***** -->

    <!-- ***** Footer Start ***** -->
    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2023 Perpustakaan Sekolah. All rights reserved.</p>
    </footer>
    <!-- ***** Footer End ***** -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>