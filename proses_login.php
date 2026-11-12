<?php
session_start();
include 'koneksi.php'; // koneksi ke database

$username = $_POST['username'];
$password = $_POST['password'];

// Cek user
$query = "SELECT * FROM tb_user WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user && sha1($password, $user['password'])) {
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Redirect berdasarkan role
    if ($user['role'] == 'admin') {
        header("Location: admin/dashboard.php");
    } elseif ($user['role'] == 'petugas') {
        header("Location: petugas/dashboard.php");
    } else {
        header("Location: petani/beranda.php");
    }
    exit();
} else {
    $_SESSION['error'] = "Username atau password salah!";
    header("Location: index.php");
    exit();
}
?>
