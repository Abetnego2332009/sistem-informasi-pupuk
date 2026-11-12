<?php require_once "koneksi.php";
if (isset($_SESSION['user'])) {
    // script menampilkan jendela lokasi menuju halaman tujuan
    echo "<script>window.location='" . base_url('auth.php') . "';</script>";
} else { ?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="/pupuk/logo.png">
  <title>Login | Sistem Informasi Pupuk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('background.jpg') no-repeat center center fixed;
      background-size: cover;
      position: relative;
    }

    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 0;
    }

    .login-container {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      z-index: 1;
    }

    .card-login {
      background: #fff;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 400px;
    }

    .form-control:focus {
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.8);
      border-color: #007bff;
    }
  </style>
</head>
<body>
  <div class="overlay"></div>

  <div class="login-container">
    <div class="card-login">
    <?php
      if (isset($_POST['login'])) {
          // con diambil dari file koneksi, post diambil dari name form
          $username = trim(mysqli_real_escape_string($con, $_POST['username']));
          $pass = sha1(trim(mysqli_real_escape_string($con, $_POST['password'])));
          //query mengambil data dari tb user
          
          $sql_login = mysqli_query($con, "SELECT * FROM tb_user WHERE username = '$username' AND password = '$pass'") or die(mysqli_error($con));
          $r = mysqli_fetch_array($sql_login);
          
          // fungsi isset agar tidak terjadi type of null
          $id_user = isset($r['id_user']) ? $r['id_user'] : '' ;
          $username = isset($r['username']) ? $r['username'] : '' ;
          $password = isset($r['password']) ? $r['password'] : '' ;
          $role = isset($r['role']) ? $r['role'] : '' ;

          if($username == $username && $pass == $password){
              // query untuk mencetak session
              $_SESSION['id_user'] = $id_user;
              $_SESSION['user'] = $username;
              $_SESSION['role'] = $role;
              echo "<script>window.location='" . base_url('auth.php') . "';</script>";
              
          } else { ?>
              <div class="row">
                  <div class="col-lg-12">
                      <div class="alert alert-danger alert-dismissable" role="alert">
                          <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                          <strong>Login Gagal: Username atau Password salah!</strong>
                      </div>
                  </div>
              </div>
              <?php
            }
          }
      ?>


    <h2 class="text-center text-success fw-bold">LOGIN</h2>
    <h4 class="text-center mb-4 text-success fw-bold">Login Sistem Pupuk</h4>

    <form class="user" method="post" action="">
      <div class="mb-3">
        <label for="username" class="form-label">Nama Pengguna</label>
        <input type="text" class="form-control" id="username" name="username" required autofocus>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Kata Sandi</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-success w-100" name="login">Login</button>
    </form>
  </div>
</div>
</body>
</html>

<?php } ?>