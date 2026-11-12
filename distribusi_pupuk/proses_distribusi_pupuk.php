<?php
require_once '../koneksi.php';

if (isset($_POST['tambah_distribusi_pupuk'])) {
    $id_kebutuhan = $_POST['id_kebutuhan'];
    $jumlah_distribusi = $_POST['jumlah_distribusi'];
    $status_distribusi = $_POST['status_distribusi'];
    $tanggal_distribusi = $_POST['tanggal_distribusi'];

    // Ambil id_petani dan id_tanaman dari tb_kebutuhan_pupuk
    $query = mysqli_query($con, "SELECT id_lahan, id_pupuk, id_petani, id_tanaman FROM tb_kebutuhan_pupuk WHERE id_kebutuhan = '$id_kebutuhan'");
    $data = mysqli_fetch_assoc($query);
    $id_lahan = $data['id_lahan'];
    $id_pupuk = $data['id_pupuk'];
    $id_petani = $data['id_petani'];
    $id_tanaman = $data['id_tanaman'];

    $insert = mysqli_query($con, "INSERT INTO tb_distribusi_pupuk (id_kebutuhan, id_lahan, id_pupuk, id_petani, id_tanaman, jumlah_distribusi, status_distribusi, tanggal_distribusi)
                VALUES ('$id_kebutuhan', '$id_lahan', '$id_pupuk', '$id_petani', '$id_tanaman', '$jumlah_distribusi', '$status_distribusi', '$tanggal_distribusi')");

    if ($insert) {
        echo "<script>alert('Data berhasil disimpan'); location.href='distribusi_pupuk.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data'); history.back();</script>";
    }
}

else if (isset($_POST['edit_distribusi_pupuk'])) {

    $id_distribusi_pupuk = $_POST['id_distribusi_pupuk'];

    $jumlah_distribusi = $_POST['jumlah_distribusi'];
    $status_distribusi = $_POST['status_distribusi'];
    $tanggal_distribusi = $_POST['tanggal_distribusi'];

    mysqli_query($con, "UPDATE tb_distribusi_pupuk SET jumlah_distribusi = '$jumlah_distribusi', status_distribusi = '$status_distribusi', tanggal_distribusi = '$tanggal_distribusi' WHERE id_distribusi_pupuk = '$id_distribusi_pupuk'") or die(mysqli_error($con));
       
    echo "<script>alert('Data berhasil di edit!');window.location='" . base_url('distribusi_pupuk/distribusi_pupuk.php') . "';</script>";
}


?>
