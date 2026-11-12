<?php
// berisi dari koneksi dari config
require "../koneksi.php";

$id = $_GET['id'];

// delete user data from database
mysqli_query($con, "DELETE FROM tb_kebutuhan_pupuk WHERE id_kebutuhan = '$id'") or die (mysqli_error($con));

// redirect to pelanggan page
echo "<script>alert('Berhasil Hapus Data!');window.location='kebutuhan_pupuk.php';</script>";

?>