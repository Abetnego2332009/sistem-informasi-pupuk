<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-1 d-flex">
        <div class="image">
          <img src="<?= base_url() ?>/logo.jpg" class="img-circle elevation-2" alt="UD. Hana">
        </div>
        <div class="info text-white">
          <h3 style="font-family: roboto;">PUPUK</h3>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?=base_url('dashboard.php'); ?>" class="nav-link">
              <i class="bi bi-speedometer2 text-warning"></i>
              <p>
              Dashboard
              </p>
            </a>
          </li>

          <?php if ($_SESSION['role'] != 'petani') { ?>

          <hr style="border-top: 2px solid #FAEBD7; margin: 0 1rem 1rem 1rem;">

          <li class="nav-header">Data Petani & Pupuk</li>

          <li class="nav-item">
            <a href="<?= base_url("petani/petani.php"); ?>" class="nav-link">
              <i class="bi bi-person-lines-fill text-warning"></i>
              <p>Data Petani</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url("tanaman/tanaman.php"); ?>" class="nav-link">
              <i class="bi bi-tree text-warning"></i>
              <p>Data Tanaman</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url("lahan/lahan.php"); ?>" class="nav-link">
              <i class="bi bi-terminal-plus text-warning"></i>
              <p>Data Lahan</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url("pupuk/pupuk.php"); ?>" class="nav-link">
              <i class="bi bi-droplet text-warning"></i>
              <p>
                Data Pupuk
              </p>
            </a>
          </li>
          <?php } ?>
          
          <?php if ($_SESSION['role'] != 'petugas' && $_SESSION['role'] != 'petani') { ?>

          <hr style="border-top: 2px solid #FAEBD7; margin: 0 1rem 1rem 1rem;">
          
          <li class="nav-header">Distribusi & Kebutuhan</li>

          <li class="nav-item">
            <a href="<?= base_url("kebutuhan_pupuk/kebutuhan_pupuk.php"); ?>" class="nav-link">
              <i class="bi bi-inboxes text-warning"></i>
              <p>
                Kebutuhan Pupuk
              </p>
            </a>
          </li>

          
          <li class="nav-item">
            <a href="<?= base_url("distribusi_pupuk/distribusi_pupuk.php"); ?>" class="nav-link">
              <i class="bi bi-minecart-loaded text-warning"></i>
              <p>
                Distribusi Pupuk
              </p>
            </a>
          </li>
        <?php } ?>

        </ul>


      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>