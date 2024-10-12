<?php
// admin/delete_user.php
include '../config/db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'];

$query = "DELETE FROM users WHERE id='$id'";
if ($conn->query($query)) {
    echo "<script>alert('Pengguna berhasil dihapus!'); window.location='list_user.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus pengguna!'); window.location='list_user.php';</script>";
}
