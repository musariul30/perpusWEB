<?php
// index.php
include 'config/db.php';
session_start();

// Ambil data buku dari tabel books
$query = "SELECT * FROM books";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
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
                            <li class="scroll-to-section"><a href="#" class="active">Home</a></li>
                            <li class="scroll-to-section"><a href="user_dashboard.php">Daftar Buku</a></li>
                            <li class="scroll-to-section"><a href="#about">About</a></li>
                            <li class="gradient-button"><a href="login.php">Sign In</a></li>
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
        <div class="py-5 text-black text-center" id="judul">
            <div class="container">
                <h1>Perpustakaan Sekolah</h1>
                <p>Selamat datang di perpustakaan digital kami!</p>
            </div>
        </div>

        <div class="container my-5">
            <div class="row mb-4">
                <div class="col text-center">
                    <h2>Daftar Buku Perpustakaan</h2>
                    <p></p>
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
                                    echo "<td>" . $book['stok'] . "</td>"; // Tampilkan stok buku
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>Tidak ada buku tersedia.</td></tr>";
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