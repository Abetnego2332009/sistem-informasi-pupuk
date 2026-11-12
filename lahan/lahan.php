<?php 
include '../koneksi.php';

if (!isset($_SESSION['user']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas')) {
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
            <i class="fas fa-table text-primary"></i><span style="color: blue;"> DATA LAHAN</span>
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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#tambahmodal" class="btn btn-outline-info btn-sm"><i class="bi bi-terminal-plus"></i> Tambah Lahan</a>
                  </div>
              </div>
                  
              <?php
              // Ambil data pengguna sekali saja
              $sql_lahan = mysqli_query($con, "SELECT * FROM tb_lahan
                INNER JOIN tb_tanaman ON tb_lahan.id_tanaman = tb_tanaman.id_tanaman
                INNER JOIN tb_pupuk ON tb_lahan.id_pupuk = tb_pupuk.id_pupuk
                INNER JOIN tb_petani ON tb_lahan.id_petani = tb_petani.id_petani") or die(mysqli_error($con));
              $lahan = [];
              while ($row = mysqli_fetch_array($sql_lahan)) {
                $lahan[] = $row;
              }
              ?>

              <table class="table table-bordered table-striped" id="example2">
                <thead>
                  <tr role="row" class="text-center">
                      <th>#</th>
                      <th>Petani</th>
                      <th>Luas Lahan <small>(m²)</small></th>
                      <th>Tanaman</th>
                      <th>Masa Tanam</th>
                      <th>Pupuk</th>
                      <th><i class="fas fa-cog"></i></th>
                  </tr>
                </thead>

                <tbody>

                  <?php $no = 1; foreach ($lahan as $data) { ?>

                  <tr>
                      <td><?=$no++ ?></td>
                      <td><?= htmlspecialchars($data['nama']);?></td>
                      <td><?= $data['luas_lahan'];?></td>
                      <td><?= $data['nama_tanaman'];?></td>
                      <td><?= htmlspecialchars($data['masa_tanam']);?></td>
                      <td><?= htmlspecialchars($data['nama_pupuk']);?></td>
                      <td width="200px">
                      <a href="#" data-bs-toggle="modal" data-bs-target="#editmodal<?=$data['id_lahan']?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                         | 
                      <a href="hapus_lahan.php?id=<?=$data['id_lahan'];?>" onclick="return confirm('Yakin Hapus Data?')" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash me-2"></i>Hapus</a>
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
          <h5 class="modal-title" id="modalLabel">Tambah Data Lahan</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <form action="proses_lahan.php" method="post" enctype="multipart/form-data">

            <div class="mb-3">
              <label for="id_petani" class="form-label">Nama Petani</label>
              <select class="form-select" id="id_petani" name="id_petani" required>
                <option disabled selected>Pilih Nama Petani</option>
                <?php
                $sql_petani = mysqli_query($con, "SELECT * FROM tb_petani") or die(mysqli_error($con));
                $petaniArray = [];
                while ($petani = mysqli_fetch_assoc($sql_petani)) {
                    $petaniArray[] = $petani;
                }
                ?>
                <?php foreach ($petaniArray as $petani): ?>
                  <option value="<?= $petani['id_petani'] ?>"
                          data-nama="<?= $petani['nama'] ?>">
                    <?= $petani['nama'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="luas_lahan" class="form-label">Luas Lahan <small>(m²)</small></label>
              <input type="number" class="form-control" id="luas_lahan" name="luas_lahan">
            </div>

            <div class="mb-3">
              <label for="id_tanaman" class="form-label">Nama Tanaman</label>
              <select class="form-select" id="id_tanaman" name="id_tanaman" required>
                <option disabled selected>Pilih Tanaman</option>
                <?php
                $sql_tanaman = mysqli_query($con, "SELECT * FROM tb_tanaman") or die(mysqli_error($con));
                $tanamanArray = [];
                while ($tanaman = mysqli_fetch_assoc($sql_tanaman)) {
                    $tanamanArray[] = $tanaman;
                }
                ?>
                <?php foreach ($tanamanArray as $tanaman): ?>
                  <option value="<?= $tanaman['id_tanaman'] ?>"
                          data-nama="<?= $tanaman['nama_tanaman'] ?>">
                    <?= $tanaman['nama_tanaman'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="masa_tanam" class="form-label">Masa Tanam</label>
              <input type="text" class="form-control" id="masa_tanam" name="masa_tanam">
            </div>

            <div class="mb-3">
              <label for="nama_pupuk" class="form-label">Nama Pupuk</label>
              <select class="form-select" id="nama_pupuk" name="id_pupuk" required>
                <option disabled selected>Pilih Pupuk</option>
                <?php
                $sql_pupuk = mysqli_query($con, "SELECT * FROM tb_pupuk") or die(mysqli_error($con));
                $pupukArray = [];
                while ($pupuk = mysqli_fetch_assoc($sql_pupuk)) {
                    $pupukArray[] = $pupuk; }
                ?>
                <?php foreach ($pupukArray as $pupuk): ?>
                  <option value="<?= $pupuk['id_pupuk'] ?>"
                          data-nama="<?= $pupuk['nama_pupuk'] ?>">
                    <?= $pupuk['nama_pupuk'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mt-4 text-end">
              <button type="submit" class="btn btn-info" name="tambah_lahan">
                <i class="fas fa-save me-1"></i> Tambah Data
              </button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>




 <!-- Modal Edit (dibuat dari data array yang sama) -->
  <?php foreach ($lahan as $data) { ?>
  <div class="modal fade" id="editmodal<?= $data['id_lahan'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $data['id_lahan'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content shadow rounded-3">
        <div class="modal-header bg-success text-white rounded-top-3">
          <h5 class="modal-title" id="modalLabel<?= $data['id_lahan'] ?>">Edit Data Lahan - <?= htmlspecialchars($data['nama']) ?></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <form action="proses_lahan.php" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id_lahan" value="<?= $data['id_lahan'] ?>">

            <div class="mb-3">
              <label for="id_petani">Petani</label>
              <select class="form-select produk-select" name="id_petani" id="id_petani" data-target-id="<?= $data['id_lahan'] ?>">
                <option disabled selected>Pilih Petani</option>
                <?php
                $sql_petani = mysqli_query($con, "SELECT * FROM tb_petani") or die(mysqli_error($con));
                while ($petani = mysqli_fetch_array($sql_petani)) {
                    $selected = ($petani['id_petani'] == $data['id_petani']) ? 'selected' : '';
                    echo "<option value='{$petani['id_petani']}' $selected>{$petani['nama']}</option>";
                }
                ?>
              </select>
            </div>


            <div class="mb-3">
              <label for="luas_lahan" class="form-label">Luas Lahan <small>(Hektar)</small></label>
              <input type="number" class="form-control" id="luas_lahan" name="luas_lahan" value="<?= $data['luas_lahan'] ?>">
            </div>

            <div class="mb-3">
              <label for="id_tanaman">Tanaman</label>
              <select class="form-select produk-select" name="id_tanaman" id="id_tanaman" data-target-id="<?= $data['id_tanaman'] ?>">
                <option disabled selected>Pilih Tanaman</option>
                <?php
                $sql_tanaman = mysqli_query($con, "SELECT * FROM tb_tanaman") or die(mysqli_error($con));
                while ($tanaman = mysqli_fetch_array($sql_tanaman)) {
                    $selected = ($tanaman['id_tanaman'] == $data['id_tanaman']) ? 'selected' : '';
                    echo "<option value='{$tanaman['id_tanaman']}' $selected>{$tanaman['nama_tanaman']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="masa_tanam" class="form-label">Masa Tanam</label>
              <input type="text" class="form-control" id="masa_tanam" name="masa_tanam" value="<?= $data['masa_tanam'] ?>">
            </div>

            <div class="mb-3">
              <label for="id_pupuk">Nama Pupuk</label>
              <select class="form-select produk-select" name="id_pupuk" id="id_pupuk" data-target-id="<?= $data['id_pupuk'] ?>">
                <option disabled selected>Pilih Pupuk</option>
                <?php
                $sql_pupuk = mysqli_query($con, "SELECT * FROM tb_pupuk") or die(mysqli_error($con));
                while ($pupuk = mysqli_fetch_array($sql_pupuk)) {
                    $selected = ($pupuk['id_pupuk'] == $data['id_pupuk']) ? 'selected' : '';
                    echo "<option value='{$pupuk['id_pupuk']}' $selected>{$pupuk['nama_pupuk']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="mt-4 text-end">
              <button type="submit" class="btn btn-success" name="edit_lahan">
                <i class="fas fa-save me-1"></i> Edit Data
              </button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  <?php } ?>


<?php include '../footer.php';?>

</div>

<?php include '../javascript.php';?>
</body>
</html>
