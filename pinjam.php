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

    // Cek apakah pengguna sudah meminjam buku ini dan belum mengembalikannya
    $checkBorrowQuery = "SELECT * FROM peminjam WHERE user_id = ? AND book_id = ? AND return_date IS NULL";
    $stmt = $conn->prepare($checkBorrowQuery);
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika pengguna sudah meminjam buku ini dan belum mengembalikannya
        header('Location: user_dashboard.php?status=already_borrowed');
    } else {
        // Mulai transaksi
        $conn->begin_transaction();
        try {
            // Kurangi stok buku
            $updateBookQuery = "UPDATE books SET stok = stok - 1 WHERE id = ? AND stok > 0";
            $stmt = $conn->prepare($updateBookQuery);
            $stmt->bind_param("i", $book_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Jika stok berhasil dikurangi, masukkan data peminjam
                $insertBorrowQuery = "INSERT INTO peminjam (user_id, book_id) VALUES (?, ?)";
                $stmt = $conn->prepare($insertBorrowQuery);
                $stmt->bind_param("ii", $user_id, $book_id);
                $stmt->execute();

                // Commit transaksi
                $conn->commit();
                header('Location: user_dashboard.php?status=success');
            } else {
                // Jika stok tidak cukup, rollback
                $conn->rollback();
                header('Location: user_dashboard.php?status=out_of_stock');
            }

            $stmt->close();
        } catch (Exception $e) {
            // Jika terjadi kesalahan, rollback
            $conn->rollback();
            header('Location: user_dashboard.php?status=error');
        }
    }
} else {
    header('Location: user_dashboard.php?status=error');
}

$conn->close();
