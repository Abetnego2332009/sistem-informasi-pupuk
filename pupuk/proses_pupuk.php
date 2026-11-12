<?php
// berisi dari koneksi dari config
require_once "../koneksi.php";


// isset guna untuk mengirim nilai balik dan bersifat boolean (true or false)
if(isset($_POST['tambah_pupuk'])){

	$nama_pupuk = trim(mysqli_real_escape_string($con, $_POST['nama_pupuk']));
	$jenis_pupuk = trim(mysqli_real_escape_string($con, $_POST['jenis_pupuk']));

	// query menginput data ke dalam tabel user
	mysqli_query($con, "INSERT INTO tb_pupuk (nama_pupuk, jenis_pupuk) VALUES('$nama_pupuk', '$jenis_pupuk')") or die (mysqli_error($con));
	echo "<script>alert('Berhasil daftar data pupuk.');window.location='". base_url('pupuk/pupuk.php') . "';</script>";
	

} 

else if (isset($_POST['edit_pupuk'])) {

    $id_pupuk = trim(mysqli_real_escape_string($con, $_POST['id_pupuk']));
    $nama_pupuk = trim(mysqli_real_escape_string($con, $_POST['nama_pupuk']));
    $jenis_pupuk = trim(mysqli_real_escape_string($con, $_POST['jenis_pupuk']));
    
    mysqli_query($con, "UPDATE tb_pupuk SET nama_pupuk = '$nama_pupuk', jenis_pupuk = '$jenis_pupuk' WHERE id_pupuk = '$id_pupuk'") or die(mysqli_error($con));
        
    echo "<script>alert('Data pupuk berhasil di edit!');window.location='" . base_url('pupuk/pupuk.php') . "';</script>";

}
?>