<?php
// berisi dari koneksi dari config
require_once "../koneksi.php";


// isset guna untuk mengirim nilai balik dan bersifat boolean (true or false)
if(isset($_POST['tambah_petani'])){

	$nama = trim(mysqli_real_escape_string($con, $_POST['nama']));
	$nik = trim(mysqli_real_escape_string($con, $_POST['nik']));
	$alamat = trim(mysqli_real_escape_string($con, $_POST['alamat']));
	$id_user = '3';

	// cek no identitas sebelum menginput data
	$sql_cek_user = mysqli_query($con, "SELECT * FROM tb_petani WHERE nik = '$nik'") or die  (mysqli_error($con));
	if(mysqli_num_rows($sql_cek_user) > 0) {
		echo "<script>alert('NIK telah digunakan!'); window.location='". base_url('petani/petani.php') . "';</script>";
	} else {
	// query menginput data ke dalam tabel user
	mysqli_query($con, "INSERT INTO tb_petani (nama, nik, alamat, id_user) VALUES('$nama', '$nik', '$alamat', '$id_user')") or die (mysqli_error($con));
	echo "<script>alert('Berhasil daftar data petani.');window.location='". base_url('petani/petani.php') . "';</script>";
	}

} 

else if (isset($_POST['edit_petani'])) {

    $id_petani = trim(mysqli_real_escape_string($con, $_POST['id_petani']));
    $nama = trim(mysqli_real_escape_string($con, $_POST['nama']));
    $nik = trim(mysqli_real_escape_string($con, $_POST['nik']));
    $alamat = trim(mysqli_real_escape_string($con, $_POST['alamat']));

    // Cek apakah email sudah digunakan oleh user lain
    $sql_cek_petani = mysqli_query($con, "SELECT * FROM tb_petani WHERE nik = '$nik' AND id_petani != '$id_petani'") or die(mysqli_error($con));

    if (mysqli_num_rows($sql_cek_petani) > 0) {
        echo "<script>alert('NIK telah digunakan! Tolong Diganti!'); window.location='" . base_url('petani/petani.php') . "';</script>";
    } else {
    
    mysqli_query($con, "UPDATE tb_petani SET nama = '$nama', nik = '$nik', alamat = '$alamat' WHERE id_petani = '$id_petani'") or die(mysqli_error($con));
        }
        echo "<script>alert('Data berhasil di edit!');window.location='" . base_url('petani/petani.php') . "';</script>";
}


?>