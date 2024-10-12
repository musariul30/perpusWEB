<?php
// admin/login.php
include 'config/db.php'; // Pastikan jalur db.php benar sesuai struktur folder
session_start();

// Redirect jika sudah login
if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin']['role'] == 'admin') {
        header('Location: admin/admin_dashboard.php');
    } else {
        header('Location: user_dashboard.php');
    }
    exit();
}

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Query untuk mengambil pengguna berdasarkan username
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password, sesuaikan jika menggunakan hashing
        // Gunakan password_verify jika password disimpan dalam bentuk hash di database
        if ($password == $user['password']) {
            // Login berhasil
            $_SESSION['admin'] = $user; // Simpan data user di session sebagai 'admin'

            // Arahkan berdasarkan role
            if ($user['role'] == 'admin') {
                header('Location: admin/admin_dashboard.php'); // Jika admin
            } else {
                header('Location: user_dashboard.php'); // Jika pengguna biasa
            }
            exit();
        } else {
            // Password salah
            $errorMessage = 'Password salah!';
        }
    } else {
        // Pengguna tidak ditemukan
        $errorMessage = 'Pengguna tidak ditemukan!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Perpustakaan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/login.css"> <!-- Pastikan file CSS ada -->
</head>

<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <form method="POST" action="login.php">
                                <!-- Pastikan action mengarah ke file login.php -->
                                <div class="mb-md-5 mt-md-4 pb-5">
                                    <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                    <p class="text-white-50 mb-5">Please enter your login and password!</p>

                                    <!-- Tampilkan pesan kesalahan jika ada -->
                                    <?php if (!empty($errorMessage)): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= $errorMessage; ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="username" id="typeUsernameX"
                                            class="form-control form-control-lg" required />
                                        <label class="form-label" for="typeUsernameX">Username</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" name="password" id="typePasswordX"
                                            class="form-control form-control-lg" required />
                                        <label class="form-label" for="typePasswordX">Password</label>
                                    </div>


                                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>

                                    <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                        <a href="#" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                        <a href="#" class="text-white"><i
                                                class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                                        <a href="#" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>