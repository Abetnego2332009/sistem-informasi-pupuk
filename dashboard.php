<?php 
include 'koneksi.php';

if (!isset($_SESSION['user']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas' && $_SESSION['role'] != 'petani')) {
    // Redirect ke login jika belum login atau bukan admin/kasir
    echo "<script>window.location = '" . base_url() . "'; </script>";
    exit;
}
?>


<!doctype html>
<html lang="en">

<?php include 'head.php';?>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">

    <?php include 'navbar.php';?>
    <?php include 'sidebar.php';?>

    <div class="content-wrapper">

      <!-- Main content -->
            <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Content -->
          <div class="flex-grow-1 p-4">

              <!-- Table preview DISTRIBUSI PUPUK-->
            <div class="card card-default mt-2">
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
                  <thead class="table-light">
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
                        </tr>
                    <?php } ?>
                  </tbody>
                </table>

                </div>
              </div>
            </div>



            <!-- Table preview PUPUK-->
            <div class="card card-default mt-5">
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

                <?php
                  // Ambil data pengguna sekali saja
                  $sql_pupuk = mysqli_query($con, "SELECT * FROM tb_pupuk") or die(mysqli_error($con));
                  $pupuk = [];
                  while ($row = mysqli_fetch_array($sql_pupuk)) {
                    $pupuk[] = $row;
                  }
                  ?>

                <table class="table table-bordered table-striped" id="example3">
                  <thead >
                    <tr role="row" class="text-center">
                        <th>#</th>
                        <th>Nama Pupuk</th>
                        <th>Jenis Pupuk</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1; foreach ($pupuk as $data) { ?>

                        <tr>
                            <td><?=$no++ ?></td>
                            <td><?= htmlspecialchars($data['nama_pupuk']);?></td>
                            <td><?= htmlspecialchars($data['jenis_pupuk']);?></td>
                        </tr>
                    <?php } ?>
                  </tbody>
                </table>
                </div>
              </div>
            </div>



            <!-- Table preview PETANI-->
            <div class="card card-default mt-5">
              <div class="card-header">
                  <i class="fas fa-table text-primary"></i><span style="color: blue;"> DATA PETANI</span>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                    </div>
              </div>

                <div class="card-body">
                  <div class="table-responsive">

                  <?php
                    // Ambil data pengguna sekali saja
                    $sql_petani = mysqli_query($con, "SELECT * FROM tb_petani") or die(mysqli_error($con));
                    $petani = [];
                    while ($row = mysqli_fetch_array($sql_petani)) {
                      $petani[] = $row;
                    }
                  ?>

                  <table class="table table-bordered table-striped" id="example4">
                    <thead class="table-light">
                      <tr role="row" class="text-center">
                          <th>#</th>
                          <th>NIK</th>
                          <th>Nama</th>
                          <th>Alamat</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1; foreach ($petani as $data) { ?>

                          <tr>
                              <td><?=$no++ ?></td>
                              <td><?= htmlspecialchars($data['nik']);?></td>
                              <td><?= htmlspecialchars($data['nama']);?></td>
                              <td><?= htmlspecialchars($data['alamat']);?></td>
                          </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  
                  </div>
                </div>
            </div>


            <!-- Table preview LAHAN PETANI-->
            <div class="card card-default mt-5">
              <div class="card-header">
                  <i class="fas fa-table text-primary"></i><span style="color: blue;"> DATA LAHAN PETANI</span>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                    </div>
              </div>

                <div class="card-body">
                  <div class="table-responsive">

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

                  <table class="table table-bordered table-striped" id="example5">
                    <thead class="table-light">
                      <tr role="row" class="text-center">
                        <th>#</th>
                        <th>Petani</th>
                        <th>Luas Lahan <small>(m²)</small></th>
                        <th>Tanaman</th>
                        <th>Masa Tanam</th>
                        <th>Pupuk</th>
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
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  
                  </div>
                </div>
            </div>


            <!-- Table preview TANAMAN-->
            <div class="card card-default mt-5">
              <div class="card-header">
                  <i class="fas fa-table text-primary"></i><span style="color: blue;"> DATA TANAMAN</span>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                    </div>
              </div>

                <div class="card-body">
                  <div class="table-responsive">

                  <?php
                    // Ambil data pengguna sekali saja
                    $sql_tanaman = mysqli_query($con, "SELECT * FROM tb_tanaman") or die(mysqli_error($con));
                    $tanaman = [];
                    while ($row = mysqli_fetch_array($sql_tanaman)) {
                      $tanaman[] = $row;
                    }
                  ?>

                  <table class="table table-bordered table-striped" id="example6">
                    <thead class="table-light">
                      <tr role="row" class="text-center">
                        <th>#</th>
                        <th>Nama Tanaman</th>
                        <th>Dosis per Hektar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1; foreach ($tanaman as $data) { ?>
                        <tr>
                          <td><?=$no++ ?></td>
                          <td><?= htmlspecialchars($data['nama_tanaman']);?></td>
                          <td><?= $data['dosis_per_hektar'];?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  
                  </div>
                </div>
            </div>

          </div>

        </div>
      </section>
    </div>


<?php include 'footer.php';?>

  </div>


<?php include 'javascript.php';?>

</body>


  </body>
</html>
