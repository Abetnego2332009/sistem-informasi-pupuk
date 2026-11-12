<?php
// berisi dari koneksi dari config
require_once "../koneksi.php";


// isset guna untuk mengirim nilai balik dan bersifat boolean (true or false)
if(isset($_POST['tambah_tanaman'])){

	$nama_tanaman = trim(mysqli_real_escape_string($con, $_POST['nama_tanaman']));
	$dosis_per_hektar = mysqli_real_escape_string($con, $_POST['dosis_per_hektar']);

	// query menginput data ke dalam tabel user
	mysqli_query($con, "INSERT INTO tb_tanaman (nama_tanaman, dosis_per_hektar) VALUES('$nama_tanaman', '$dosis_per_hektar')") or die (mysqli_error($con));
	echo "<script>alert('Berhasil daftar data tanaman.');window.location='". base_url('tanaman/tanaman.php') . "';</script>";
	

} 

else if (isset($_POST['edit_tanaman'])) {

    $id_tanaman = trim(mysqli_real_escape_string($con, $_POST['id_tanaman']));
    $nama_tanaman = trim(mysqli_real_escape_string($con, $_POST['nama_tanaman']));
    $dosis_per_hektar = mysqli_real_escape_string($con, $_POST['dosis_per_hektar']);
    
    mysqli_query($con, "UPDATE tb_tanaman SET nama_tanaman = '$nama_tanaman', dosis_per_hektar = '$dosis_per_hektar' WHERE id_tanaman = '$id_tanaman'") or die(mysqli_error($con));
        
    echo "<script>alert('Data tanaman berhasil di edit!');window.location='" . base_url('tanaman/tanaman.php') . "';</script>";

}
?>