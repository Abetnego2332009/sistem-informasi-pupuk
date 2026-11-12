<?php
require_once '../koneksi.php';

if (isset($_POST['tambah_kebutuhan_pupuk'])) {
    $id_lahan = $_POST['id_lahan'];
    $kebutuhan = $_POST['kebutuhan_pupuk'];

    // Ambil id_petani dan id_tanaman dari tb_lahan
    $query = mysqli_query($con, "SELECT id_pupuk, id_petani, id_tanaman FROM tb_lahan WHERE id_lahan = '$id_lahan'");
    $data = mysqli_fetch_assoc($query);
    $id_pupuk = $data['id_pupuk'];
    $id_petani = $data['id_petani'];
    $id_tanaman = $data['id_tanaman'];

    $insert = mysqli_query($con, "INSERT INTO tb_kebutuhan_pupuk (id_lahan, id_pupuk, id_petani, id_tanaman, kebutuhan_pupuk)
                VALUES ('$id_lahan', '$id_pupuk', '$id_petani', '$id_tanaman', '$kebutuhan')");

    if ($insert) {
        echo "<script>alert('Data berhasil disimpan'); location.href='kebutuhan_pupuk.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data'); history.back();</script>";
    }
}
?>
