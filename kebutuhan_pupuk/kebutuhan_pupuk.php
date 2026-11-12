<?php 
include '../koneksi.php';

if (!isset($_SESSION['user']) || ($_SESSION['role'] != 'admin')) {
    // Redirect ke login jika belum login atau bukan admin/kasir
    echo "<script>window.location = '" . base_url() . "'; </script>";
    exit;
}
?>

<!doctype html>
<html lang="en">

<?php include '../head.php';?>


<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

  <?php include '../navbar.php';?>
  <?php include '../sidebar.php';?>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        
      </div>
    </div>


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">

          <div class="card-header">
            <i class="fas fa-table text-primary"></i><span style="color: blue;"> DATA KEBUTUHAN PUPUK</span>
              <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
              </div>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <div style="margin-bottom: 50px;">
                  <div class="float-right">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#tambahmodal" class="btn btn-outline-info btn-sm"><i class="bi bi-inboxes"></i> Tambah Data Kebutuhan Pupuk</a>
                  </div>
              </div>
                  
              <?php
              // Ambil data pengguna sekali saja
              $sql_kebutuhan_pupuk = mysqli_query($con, "SELECT * FROM tb_kebutuhan_pupuk
                INNER JOIN tb_lahan ON tb_kebutuhan_pupuk.id_lahan = tb_lahan.id_lahan
                INNER JOIN tb_pupuk ON tb_kebutuhan_pupuk.id_pupuk = tb_pupuk.id_pupuk
                INNER JOIN tb_petani ON tb_kebutuhan_pupuk.id_petani = tb_petani.id_petani
                INNER JOIN tb_tanaman ON tb_kebutuhan_pupuk.id_tanaman = tb_tanaman.id_tanaman") or die(mysqli_error($con));
              $kebutuhan_pupuk = [];
              while ($row = mysqli_fetch_array($sql_kebutuhan_pupuk)) {
                $kebutuhan_pupuk[] = $row;
              }
              ?>

              <table class="table table-bordered table-striped" id="example2">
                <thead>
                  <tr role="row" class="text-center">
                      <th>#</th>
                      <th>NIK</th>
                      <th>Nama Petani</th>
                      <th>Luas Lahan <small>(m²)</small></th>
                      <th>Tanaman</th>
                      <th>Dosis Per Hektar</th>
                      <th>Pupuk</th>
                      <th>Kebutuhan (Kg)</th>
                      <th><i class="fas fa-cog"></i></th>
                  </tr>
                </thead>

                <tbody>

                  <?php $no = 1; foreach ($kebutuhan_pupuk as $data) { ?>

                  <tr>
                      <td><?=$no++ ?></td>
                      <td><?= htmlspecialchars($data['nik']);?></td>
                      <td><?= htmlspecialchars($data['nama']);?></td>
                      <td><?= $data['luas_lahan'];?></td>
                      <td><?= htmlspecialchars($data['nama_tanaman']);?></td>
                      <td><?= $data['dosis_per_hektar'];?> Kg</td>
                      <td><?= htmlspecialchars($data['nama_pupuk']);?></td>
                      <td><?= $data['kebutuhan_pupuk'];?></td>
                      <td width="150px" align="center">
                      <a href="hapus_kebutuhan_pupuk.php?id=<?=$data['id_kebutuhan'];?>" onclick="return confirm('Yakin Hapus Data?')" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash me-2"></i>Hapus Data</a>
                      </td>
                  </tr>
                <?php } ?>

                </tbody>
              </table>
            
            </div>
          </div>
        </div>
      </div>
    </section>
</div>


 <!-- Modal Tambah Pengguna -->
  <div class="modal fade" id="tambahmodal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content shadow rounded-3">
        <div class="modal-header bg-info text-white rounded-top-3">
          <h5 class="modal-title" id="modalLabel">Tambah Kebutuhan Pupuk</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <form action="proses_kebutuhan_pupuk.php" method="post" enctype="multipart/form-data">

            <div class="mb-3">
              <label for="id_lahan" class="form-label">Nama Petani</label>
              <select class="form-select" id="id_lahan" name="id_lahan" required>
                <option disabled option>Pilih Petani</option>
                <?php
                $sql_lahan = mysqli_query($con, "SELECT * FROM tb_lahan 
                  INNER JOIN tb_petani ON tb_lahan.id_petani = tb_petani.id_petani
                  INNER JOIN tb_tanaman ON tb_lahan.id_tanaman = tb_tanaman.id_tanaman") or die(mysqli_error($con));
                $lahanArray = [];
                while ($lahan = mysqli_fetch_assoc($sql_lahan)) {
                    $lahanArray[] = $lahan;
                }
                ?>
                <?php foreach ($lahanArray as $lahan): ?>
                  <option value="<?= $lahan['id_lahan'] ?>"
                          data-nama="<?= $lahan['nama'] ?>"
                          data-nama_tanaman="<?= $lahan['nama_tanaman'] ?>"
                          data-dosis_per_hektar="<?= $lahan['dosis_per_hektar'] ?>">
                    <?= $lahan['nama'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
            <label for="luas_lahan" class="form-label">Luas Lahan (m2)</label>
            <input type="text" class="form-control" id="luas_lahan" name="luas_lahan" readonly>
          </div>

            <div class="mb-3">
              <label for="nama_tanaman" class="form-label">Tanaman</label>
              <input type="text" class="form-control" id="nama_tanaman" name="id_tanaman" readonly>
            </div>

            <div class="mb-3">
              <label for="dosis_per_hektar" class="form-label">Dosis Per Hektar</label>
              <input type="number" class="form-control" id="dosis_per_hektar" name="dosis_per_hektar" readonly>
            </div>

            <div class="mb-3">
              <label for="nama_pupuk" class="form-label">Pupuk</label>
              <input type="text" class="form-control" id="nama_pupuk" name="id_pupuk" readonly>
            </div>

            <div class="mb-3">
              <label for="kebutuhan_pupuk" class="form-label">Total Kebutuhan Pupuk (Kg)</label>
              <input type="number" class="form-control" id="kebutuhan_pupuk" name="kebutuhan_pupuk" readonly>
            </div>

            <div class="mt-4 text-end">
              <button type="submit" class="btn btn-info" name="tambah_kebutuhan_pupuk">
                <i class="fas fa-save me-1"></i> Tambah Data
              </button>
            </div>
          </form>

        </div>

      </div>
    </div>
  </div>



<?php include '../footer.php';?>

</div>

<?php include '../javascript.php';?>


<script>
$(document).ready(function () {
  $('#id_lahan').on('change', function () {
    var id_lahan = $(this).val();
    if (id_lahan) {
      $.ajax({
        url: 'ambil_data_kebutuhan.php',
        method: 'GET',
        data: { id_lahan: id_lahan },
        dataType: 'json',
        success: function (data) {
          $('#luas_lahan').val(data.luas_lahan);
          $('#nama_tanaman').val(data.nama_tanaman);
          $('#dosis_per_hektar').val(data.dosis_per_hektar);
          $('#nama_pupuk').val(data.nama_pupuk);

          // Hitung kebutuhan pupuk
          var luas = parseFloat(data.luas_lahan);
          var dosis = parseFloat(data.dosis_per_hektar);
          if (!isNaN(luas) && !isNaN(dosis)) {
            var kebutuhan = (luas / 10000) * dosis;
            $('#kebutuhan_pupuk').val(kebutuhan.toFixed(2));
          } else {
            $('#kebutuhan_pupuk').val('');
          }
        },
        error: function () {
          alert('Gagal mengambil data kebutuhan pupuk.');
        }
      });
    } else {
      $('#luas_lahan, #nama_tanaman, #dosis_per_hektar, #nama_pupuk, #kebutuhan_pupuk').val('');
    }
  });
});
</script>



</body>
</html>
