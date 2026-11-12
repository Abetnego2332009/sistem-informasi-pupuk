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
            <i class="fas fa-table text-primary"></i><span style="color: blue;"> DATA DISTRIBUSI PUPUK</span>
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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#tambahmodal" class="btn btn-outline-info btn-sm"><i class="bi bi-minecart-loaded"></i> Tambah Distribusi Pupuk</a>
                  </div>
              </div>
                  
              <?php
              // Ambil data pengguna sekali saja
              $sql_distribusi_pupuk = mysqli_query($con, "SELECT * FROM tb_distribusi_pupuk
                INNER JOIN tb_kebutuhan_pupuk ON tb_distribusi_pupuk.id_kebutuhan = tb_kebutuhan_pupuk.id_kebutuhan
                INNER JOIN tb_lahan ON tb_distribusi_pupuk.id_lahan = tb_lahan.id_lahan
                INNER JOIN tb_pupuk ON tb_distribusi_pupuk.id_pupuk = tb_pupuk.id_pupuk
                INNER JOIN tb_petani ON tb_distribusi_pupuk.id_petani = tb_petani.id_petani
                INNER JOIN tb_tanaman ON tb_distribusi_pupuk.id_tanaman = tb_tanaman.id_tanaman
                ORDER BY tanggal_distribusi DESC") or die(mysqli_error($con));
              $distribusi_pupuk = [];
              while ($row = mysqli_fetch_array($sql_distribusi_pupuk)) {
                $distribusi_pupuk[] = $row;
              }
              ?>

              <table class="table table-bordered table-striped" id="example2">
                <thead>
                  <tr role="row" class="text-center">
                      <th>#</th>
                      <th>NIK</th>
                      <th>Nama Petani</th>
                      <th>Tanaman</th>
                      <th>Pupuk</th>
                      <th>Kebutuhan (Kg)</th>
                      <th>Jumlah Distribusi (Kg)</th>
                      <th>Status Distribusi</th>
                      <th>Tanggal Distribusi</th>
                      <th><i class="fas fa-cog"></i></th>
                  </tr>
                </thead>

                <tbody>

                  <?php $no = 1; foreach ($distribusi_pupuk as $data) { ?>

                  <tr>
                      <td><?=$no++ ?></td>
                      <td><?= htmlspecialchars($data['nik']);?></td>
                      <td><?= htmlspecialchars($data['nama']);?></td>
                      <td><?= htmlspecialchars($data['nama_tanaman']);?></td>
                      <td><?= htmlspecialchars($data['nama_pupuk']);?></td>
                      <td><?= $data['kebutuhan_pupuk'];?></td>
                      <td><?= $data['jumlah_distribusi'];?></td>
                      <td><?= htmlspecialchars($data['status_distribusi']);?></td>
                      <td><?= date('d F Y', strtotime($data['tanggal_distribusi'])); ?></td>
                      <td width="100px" align="center">
                      <a href="#" data-bs-toggle="modal" data-bs-target="#editmodal<?=$data['id_distribusi_pupuk']?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                         | 
                      <a href="hapus_distribusi_pupuk.php?id=<?=$data['id_distribusi_pupuk'];?>" onclick="return confirm('Yakin Hapus Data?')" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i>
                      </a>
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
          <h5 class="modal-title" id="modalLabel">Tambah Distribusi Pupuk</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <form action="proses_distribusi_pupuk.php" method="post" enctype="multipart/form-data">

            <div class="mb-3">
              <label for="id_kebutuhan" class="form-label">Nama Petani</label>
              <select class="form-select" id="id_kebutuhan" name="id_kebutuhan" required>
                <option disabled selected>Pilih Petani</option>
                <?php
                $sql_kebutuhan = mysqli_query($con, "SELECT * FROM tb_kebutuhan_pupuk
                  INNER JOIN tb_lahan ON tb_kebutuhan_pupuk.id_lahan = tb_lahan.id_lahan
                  INNER JOIN tb_petani ON tb_kebutuhan_pupuk.id_petani = tb_petani.id_petani
                  INNER JOIN tb_pupuk ON tb_kebutuhan_pupuk.id_pupuk = tb_pupuk.id_pupuk
                  INNER JOIN tb_tanaman ON tb_kebutuhan_pupuk.id_tanaman = tb_tanaman.id_tanaman") or die(mysqli_error($con));
                $kebutuhanArray = [];
                while ($kebutuhan = mysqli_fetch_assoc($sql_kebutuhan)) {
                    $kebutuhanArray[] = $kebutuhan;
                }
                ?>
                <?php foreach ($kebutuhanArray as $kebutuhan): ?>
                  <option value="<?= $kebutuhan['id_kebutuhan'] ?>"
                          data-nama="<?= $kebutuhan['nama'] ?>"
                          data-nik="<?= $kebutuhan['nik'] ?>"
                          data-nama_tanaman="<?= $kebutuhan['nama_tanaman'] ?>"
                          data-nama_pupuk="<?= $kebutuhan['nama_pupuk'] ?>"
                          data-kebutuhan_pupuk="<?= $kebutuhan['kebutuhan_pupuk'] ?>">
                    <?= $kebutuhan['nama'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="nik" class="form-label">NIK</label>
              <input type="text" class="form-control" id="nik" name="nik" readonly>
            </div>

            <div class="mb-3">
              <label for="nama_tanaman" class="form-label">Tanaman</label>
              <input type="text" class="form-control" id="nama_tanaman" name="id_tanaman" readonly>
            </div>

            <div class="mb-3">
              <label for="nama_pupuk" class="form-label">Pupuk</label>
              <input type="text" class="form-control" id="nama_pupuk" name="id_pupuk" readonly>
            </div>

            <div class="mb-3">
              <label for="kebutuhan_pupuk" class="form-label">Total Kebutuhan Pupuk (Kg)</label>
              <input type="number" class="form-control" id="kebutuhan_pupuk" name="kebutuhan_pupuk" readonly>
            </div>

            <div class="mb-3">
              <label for="jumlah_distribusi" class="form-label">Jumlah Distribusi (Kg)</label>
              <input type="number" class="form-control" id="jumlah_distribusi" name="jumlah_distribusi">
            </div>

            <div class="mb-3">
              <label for="status_distribusi" class="form-label">Status Distribusi</label>
              <select class="form-select" id="status_distribusi" name="status_distribusi" required>
                <option value="Belum Dikirim">Belum Dikirim</option>
                <option value="Sebagian Dikirim">Sebagian Dikirim</option>
                <option value="Terkirim">Terkirim</option>
                <option value="Ditunda">Ditunda</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="tanggal_distribusi" class="form-label">Tanggal Distribusi</label>
              <input type="date" class="form-control" id="tanggal_distribusi" name="tanggal_distribusi">
            </div>

            <div class="mt-4 text-end">
              <button type="submit" class="btn btn-info" name="tambah_distribusi_pupuk">
                <i class="fas fa-save me-1"></i> Tambah Data Distribusi
              </button>
            </div>
          </form>

        </div>

      </div>
    </div>
  </div>




 <!-- Modal Edit (dibuat dari data array yang sama) -->
  <?php foreach ($distribusi_pupuk as $data) { ?>
  <div class="modal fade" id="editmodal<?= $data['id_distribusi_pupuk'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $data['id_distribusi_pupuk'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content shadow rounded-3">
        <div class="modal-header bg-success text-white rounded-top-3">
          <h5 class="modal-title" id="modalLabel<?= $data['id_distribusi_pupuk'] ?>">Edit Distribusi Pupuk - <?= htmlspecialchars($data['nama']) ?></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <form action="proses_distribusi_pupuk.php" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id_distribusi_pupuk" value="<?= $data['id_distribusi_pupuk'] ?>">

            <div class="mb-3">
              <label for="nik" class="form-label">NIK</label>
              <input type="text" class="form-control" id="nik" name="nik" value="<?= htmlspecialchars($data['nik']) ?>" readonly>
            </div>

            <div class="mb-3">
              <label for="id_petani" class="form-label">Petani</label>
              <input type="text" class="form-control" id="id_petani" name="id_petani" value="<?= htmlspecialchars($data['nama']) ?>" readonly>
            </div>

            <div class="mb-3">
              <label for="id_tanaman" class="form-label">Tanaman</label>
              <input type="text" class="form-control" id="id_tanaman" name="id_tanaman" value="<?= htmlspecialchars($data['nama_tanaman']) ?>" readonly>
            </div>

            <div class="mb-3">
              <label for="id_pupuk" class="form-label">Pupuk</label>
              <input type="text" class="form-control" id="id_pupuk" name="id_pupuk" value="<?= htmlspecialchars($data['nama_pupuk']) ?>" readonly>
            </div>

            <div class="mb-3">
              <label for="kebutuhan_pupuk" class="form-label">Kebutuhan (Kg)</label>
              <input type="text" class="form-control" id="kebutuhan_pupuk" name="kebutuhan_pupuk" value="<?= htmlspecialchars($data['kebutuhan_pupuk']) ?>" readonly>
            </div>

            <div class="mb-3">
              <label for="jumlah_distribusi" class="form-label">Jumlah Distribusi</label>
              <input type="number" class="form-control" id="jumlah_distribusi" name="jumlah_distribusi" value="<?= htmlspecialchars($data['jumlah_distribusi']) ?>">
            </div>

            <div class="mb-3">
              <label for="status_distribusi" class="form-label">Status Distribusi</label>
              <select class="form-select" name="status_distribusi" id="status_distribusi">
                <?php
                $status_distribusi = ['Belum Dikirim','Sebagian Dikirim','Terkirim','Ditunda'];
                foreach ($status_distribusi as $status) {
                  $selected = ($data['status_distribusi'] == $status) ? 'selected' : '';
                  echo "<option value='$status' $selected>$status</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="tanggal_distribusi" class="form-label">Tanggal Distribusi</label>
              <input type="date" class="form-control" id="tanggal_distribusi" name="tanggal_distribusi" value="<?= htmlspecialchars($data['tanggal_distribusi']) ?>">
            </div>

            <div class="mt-4 text-end">
              <button type="submit" class="btn btn-success" name="edit_distribusi_pupuk">
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


<script>
$(document).ready(function () {
  $('#id_kebutuhan').on('change', function () {
    var id_kebutuhan = $(this).val();
    if (id_kebutuhan) {
      $.ajax({
        url: 'ambil_data_distribusi.php',
        method: 'GET',
        data: { id_kebutuhan: id_kebutuhan },
        dataType: 'json',
        success: function (data) {
          $('#nik').val(data.nik);
          $('#nama_tanaman').val(data.nama_tanaman);
          $('#nama_pupuk').val(data.nama_pupuk);
          $('#kebutuhan_pupuk').val(data.kebutuhan_pupuk);
        },
        error: function () {
          alert('Gagal mengambil data kebutuhan pupuk.');
        }
      });
    } else {
      $('#nik, #nama_tanaman, #nama_pupuk, #kebutuhan_pupuk').val('');
    }
  });
});
</script>



</body>
</html>
