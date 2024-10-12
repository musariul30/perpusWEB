<?php
include 'config/db.php';
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Ambil ID buku dari parameter URL
if (isset($_GET['book_id'])) {
    $book_id = intval($_GET['book_id']);
    $user_id = $_SESSION['admin']['id']; // Mengambil ID pengguna dari session

    // Cek apakah pengguna telah meminjam buku ini dan belum mengembalikannya
    $checkBorrowQuery = "SELECT * FROM peminjam WHERE user_id = ? AND book_id = ? AND return_date IS NULL";
    $stmt = $conn->prepare($checkBorrowQuery);
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Mulai transaksi
        $conn->begin_transaction();
        try {
            // Tambah stok buku
            $updateBookQuery = "UPDATE books SET stok = stok + 1 WHERE id = ?";
            $stmt = $conn->prepare($updateBookQuery);
            $stmt->bind_param("i", $book_id);
            $stmt->execute();

            // Update return_date di tabel peminjam
            $updatePeminjamQuery = "UPDATE peminjam SET return_date = NOW() WHERE user_id = ? AND book_id = ? AND return_date IS NULL";
            $stmt = $conn->prepare($updatePeminjamQuery);
            $stmt->bind_param("ii", $user_id, $book_id);
            $stmt->execute();

            // Commit transaksi
            $conn->commit();
            header('Location: user_dashboard.php?status=return_success');
        } catch (Exception $e) {
            // Jika terjadi kesalahan, rollback
            $conn->rollback();
            header('Location: user_dashboard.php?status=error');
        }
    } else {
        // Jika pengguna tidak meminjam buku ini, atau sudah mengembalikannya
        header('Location: user_dashboard.php?status=not_borrowed');
    }
} else {
    header('Location: user_dashboard.php?status=error');
}

$conn->close();
