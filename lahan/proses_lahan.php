<?php
// berisi dari koneksi dari config
require_once "../koneksi.php";


// isset guna untuk mengirim nilai balik dan bersifat boolean (true or false)
if(isset($_POST['tambah_lahan'])){

	$id_petani = mysqli_real_escape_string($con, $_POST['id_petani']);
	$luas_lahan = mysqli_real_escape_string($con, $_POST['luas_lahan']);
	$id_tanaman = mysqli_real_escape_string($con, $_POST['id_tanaman']);
	$masa_tanam = trim(mysqli_real_escape_string($con, $_POST['masa_tanam']));
	$id_pupuk = trim(mysqli_real_escape_string($con, $_POST['id_pupuk']));

	// query menginput data ke dalam tabel user
	mysqli_query($con, "INSERT INTO tb_lahan (id_petani, luas_lahan, id_tanaman, masa_tanam, id_pupuk) VALUES('$id_petani', '$luas_lahan', '$id_tanaman', '$masa_tanam', '$id_pupuk')") or die (mysqli_error($con));
	echo "<script>alert('Berhasil daftar data lahan.');window.location='". base_url('lahan/lahan.php') . "';</script>";
} 

else if (isset($_POST['edit_lahan'])) {

    $id_lahan = trim(mysqli_real_escape_string($con, $_POST['id_lahan']));
    $id_petani = trim(mysqli_real_escape_string($con, $_POST['id_petani']));
    $luas_lahan = mysqli_real_escape_string($con, $_POST['luas_lahan']);
    $id_tanaman = mysqli_real_escape_string($con, $_POST['id_tanaman']);
    $masa_tanam = trim(mysqli_real_escape_string($con, $_POST['masa_tanam']));
    $id_pupuk = trim(mysqli_real_escape_string($con, $_POST['id_pupuk']));
    
    mysqli_query($con, "UPDATE tb_lahan SET id_petani = '$id_petani', luas_lahan = '$luas_lahan', id_tanaman = '$id_tanaman', masa_tanam = '$masa_tanam', id_pupuk = '$id_pupuk' WHERE id_lahan = '$id_lahan'") or die(mysqli_error($con));
       
    echo "<script>alert('Data berhasil di edit!');window.location='" . base_url('lahan/lahan.php') . "';</script>";
}


?>