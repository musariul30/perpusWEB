<?php
$host = 'localhost'; // Nama host (localhost jika di XAMPP)
$user = 'root'; // Nama pengguna (root jika di XAMPP)
$pass = ''; // Kata sandi (kosong jika di XAMPP default)
$dbname = 'perpustakaan'; // Nama database yang ingin Anda cek koneksinya

// Membuat koneksi
$koneksi = new mysqli($host, $user, $pass, $dbname);

// Mengecek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
} else {
    echo "Koneksi berhasil!";
}

// Menutup koneksi
$koneksi->close();
