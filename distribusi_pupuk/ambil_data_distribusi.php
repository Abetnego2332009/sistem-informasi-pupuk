<?php
include '../koneksi.php';

if (isset($_GET['id_kebutuhan']) && is_numeric($_GET['id_kebutuhan'])) {
    $id_kebutuhan = intval($_GET['id_kebutuhan']);
    $stmt = $con->prepare("SELECT * FROM tb_kebutuhan_pupuk 
                  INNER JOIN tb_lahan ON tb_kebutuhan_pupuk.id_lahan = tb_lahan.id_lahan
                  INNER JOIN tb_petani ON tb_kebutuhan_pupuk.id_petani = tb_petani.id_petani
                  INNER JOIN tb_pupuk ON tb_kebutuhan_pupuk.id_pupuk = tb_pupuk.id_pupuk
                  INNER JOIN tb_tanaman ON tb_kebutuhan_pupuk.id_tanaman = tb_tanaman.id_tanaman WHERE id_kebutuhan = ?" 
                    );
    $stmt->bind_param("i", $id_kebutuhan);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode([
        'nik' => 0,
        'nama_tanaman' => 0,
        'nama_pupuk' => 0,
        'kebutuhan_pupuk' => 0]); // perbaikan dari ['luas_lahan'']
    }
    $stmt->close();
}
?>
