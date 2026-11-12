<?php
include '../koneksi.php';

if (isset($_GET['id_lahan']) && is_numeric($_GET['id_lahan'])) {
    $id_lahan = intval($_GET['id_lahan']);
    $stmt = $con->prepare("SELECT * FROM tb_lahan 
                  INNER JOIN tb_petani ON tb_lahan.id_petani = tb_petani.id_petani
                  INNER JOIN tb_pupuk ON tb_lahan.id_pupuk = tb_pupuk.id_pupuk
                  INNER JOIN tb_tanaman ON tb_lahan.id_tanaman = tb_tanaman.id_tanaman WHERE id_lahan = ?");
    $stmt->bind_param("i", $id_lahan);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode([
        'luas_lahan' => 0,
        'nama_tanaman' => 0,
        'dosis_per_hektar' => 0,
        'nama_pupuk' => 0]); // perbaikan dari ['luas_lahan'']
    }
    $stmt->close();
}
?>
