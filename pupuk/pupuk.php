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
            <i class="fas fa-table text-primary"></i><span style="color: blue;"> DATA PUPUK</span>
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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#tambahmodal" class="btn btn-outline-info btn-sm"><i class="bi bi-droplet"></i> Tambah Data Pupuk</a>
                  </div>
              </div>
                  
              <?php
              // Ambil data pengguna sekali saja
              $sql_pupuk = mysqli_query($con, "SELECT * FROM tb_pupuk") or die(mysqli_error($con));
              $pupuk = [];
              while ($row = mysqli_fetch_array($sql_pupuk)) {
                $pupuk[] = $row;
              }
              ?>

              <table class="table table-bordered table-striped" id="example2">
                <thead>
                  <tr role="row" class="text-center">
                      <th>#</th>
                      <th>Nama Pupuk</th>
                      <th>Jenis Pupuk</th>
                      <th><i class="fas fa-cog"></i></th>
                  </tr>
                </thead>

                <tbody>

                  <?php $no = 1; foreach ($pupuk as $data) { ?>

                  <tr>
                      <td><?=$no++ ?></td>
                      <td><?= htmlspecialchars($data['nama_pupuk']);?></td>
                      <td><?= htmlspecialchars($data['jenis_pupuk']);?></td>
                      <td width="200px">
                      <a href="#" data-bs-toggle="modal" data-bs-target="#editmodal<?=$data['id_pupuk']?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                         | 
                      <a href="hapus_pupuk.php?id=<?=$data['id_pupuk'];?>" onclick="return confirm('Yakin Hapus Data?')" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash me-2"></i>Hapus</a>
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
          <h5 class="modal-title" id="modalLabel">Tambah Data Pupuk</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <form action="proses_pupuk.php" method="post" enctype="multipart/form-data">

            <div class="mb-3">
              <label for="nama_pupuk" class="form-label">Nama Pupuk</label>
              <input type="text" class="form-control" id="nama_pupuk" name="nama_pupuk">
            </div>

            <div class="mb-3">
              <label for="jenis_pupuk" class="form-label">Jenis Pupuk</label>
              <input type="text" class="form-control" id="jenis_pupuk" name="jenis_pupuk">
            </div>


            <div class="mt-4 text-end">
              <button type="submit" class="btn btn-info" name="tambah_pupuk">
                <i class="fas fa-save me-1"></i> Tambah Data
              </button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>




 <!-- Modal Edit (dibuat dari data array yang sama) -->
  <?php foreach ($pupuk as $data) { ?>
  <div class="modal fade" id="editmodal<?= $data['id_pupuk'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $data['id_pupuk'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content shadow rounded-3">
        <div class="modal-header bg-success text-white rounded-top-3">
          <h5 class="modal-title" id="modalLabel<?= $data['id_pupuk'] ?>">Edit Data Pupuk - <?= htmlspecialchars($data['nama_pupuk']) ?></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <form action="proses_pupuk.php" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id_pupuk" value="<?= $data['id_pupuk'] ?>">


            <div class="mb-3">
              <label for="nama_pupuk" class="form-label">Nama Pupuk</label>
              <input type="text" class="form-control" id="nama_pupuk" name="nama_pupuk" value="<?= $data['nama_pupuk'] ?>">
            </div>

            <div class="mb-3">
              <label for="jenis_pupuk" class="form-label">Jenis Pupuk</label>
              <input type="text" class="form-control" id="jenis_pupuk" name="jenis_pupuk" value="<?= $data['jenis_pupuk'] ?>">
            </div>

            <div class="mt-4 text-end">
              <button type="submit" class="btn btn-success" name="edit_pupuk">
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
