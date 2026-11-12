<?php 
include '../koneksi.php';

if (!isset($_SESSION['user']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas' && $_SESSION['role'] != 'petani')) {
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
            <i class="fas fa-table text-primary"></i><span style="color: blue;"> PENGGUNA</span>
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
                      <!-- Link menuju controller mengakses function -->
                       <a href="<?= base_url("users/tambah_pengguna.php"); ?>" class="btn btn-outline-info btn-sm">
                          <i class="fas fa-cart-plus"> Tambah Pengguna</i>
                      </a>
                  </div>
              </div>
                  
              <table class="table table-bordered table-striped" id="example2">
                <thead>
                  <tr role="row" class="text-center">
                      <th>#</th>
                      <th>Pengguna</th>
                      <th>Email</th>
                      <th>Role</th>
                      <?php if ($_SESSION['role'] != 'kasir') { ?>
                      <th><i class="fas fa-cog"></i></th>
                      <?php } ?>
                  </tr>
                </thead>

                  <tbody align="center" >

                    <?php
                      $no = 1;
                      // query untuk mengambil semua data dari tabel 
                      $sql_pengguna = mysqli_query($con, "SELECT * FROM tb_user") or die(mysqli_error($con));
                      // query untuk mengambil data dan membentuknya dalam array
                      while ($data = mysqli_fetch_array($sql_pengguna)) { ?>

                          <tr>
                              <td><?=$no++ ?></td>
                              <td><?=$data['username'];?></td>
                              <td><?=$data['email'];?></td>
                              <td><?=$data['role'];?></td>
                              <?php if ($_SESSION['role'] != 'kasir') { ?>
                              <td align="center">
                              <a href="#" data-bs-toggle="modal" data-bs-target="#editmodal<?=$data['id_user']?>" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                 | 
                              <a href="hapus_pengguna.php?id=<?=$data['id_user'];?>" onclick="return confirm('Yakin Hapus Data?')" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash me-2"></i>Hapus</a>
                              </td>
                              <?php } ?>
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


<?php

$sql_user = mysqli_query($con, "SELECT * FROM tb_user") or die(mysqli_error($con));
// query untuk mengambil data dan membentuknya dalam array
while ($data = mysqli_fetch_array($sql_user)) { ?>


<div class="modal fade" id="editmodal<?= $data['id_user'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $data['id_user']; ?>" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow rounded-3">
      <div class="modal-header bg-primary text-white rounded-top-3">
        <h5 class="modal-title" id="modalLabel<?= $data['id_user'] ?>">Edit Pengguna - <?= htmlspecialchars($data['username']) ?></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        
        <form action="proses_pengguna.php" method="post" enctype="multipart/form-data">

          <input type="hidden" name="id_user" value="<?= $data['id_user']; ?>">

          <div class="row g-3">
            <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= $data['username']; ?>">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $data['email']; ?>">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan bila tidak ingin di ganti">
          </div>
          <div class="mb-3">
              <label for="role">Role</label>
              <select class="form-select" name="role">
                <?php
                  $metode_list = ["Admin", "Kasir"];
                  foreach ($metode_list as $metode) {
                    $selected = ($data['role'] == $metode) ? "selected" : "";
                    echo "<option value='$metode' $selected>$metode</option>";
                  }
                ?>
              </select>
          </div>

          <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary" name="edit_pengguna">
              <i class="fas fa-save me-1"></i> Simpan Perubahan
            </button>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>



<?php }  ?>


<?php include '../footer.php';?>

</div>

<?php include '../javascript.php';?>
</body>
</html>
