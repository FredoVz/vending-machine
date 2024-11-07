<style>
    /* Ukuran default logo */
    .sidebar-brand-icon img {
        transition: all 0.3s ease; /* Smooth transition */
        height: 30px;
        width: auto;
    }

    /* Saat sidebar dalam keadaan collapse */
    .sidebar.collapsed .sidebar-brand-icon img {
        height: 15px; /* Logo lebih kecil */
        width: auto;
    }

    /* Mobile view: Logo lebih kecil */
    @media (max-width: 768px) {
        .sidebar-brand-icon img {
            height: 15px;
        }
    }

    .fixed-top-custom {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1030; /* 1030 Pastikan di atas konten lainnya */
    }

    /* Sidebar tetap terlihat saat di-scroll */
    .sidebar {
        position: sticky;
        top: 0;
        left: 0;
        height: 100%; /* Penuh sampai bawah */
        width: auto; /* Lebar default */
        transition: width 0.3s;
        z-index: 1020; /* 1020 */
    }
</style>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
         <!-- #b18cc2 -->
        <ul class="navbar-nav bg-gradient-light sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url('dashboard') ?>">
            </a>

            <!-- Divider -->
            <!--hr class="sidebar-divider my-0" style="border-color: #D3D3D3;"--> <!-- #D3D3D3 -->

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php echo ($this->uri->segment(1) == 'dashboard') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url('dashboard'); ?>">
                    <i class="fas fa-fw fa-database" style="color: black;"></i>
                    <span style="color: black;">Dashboard</span>
                </a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle" 
                        style="background-color: gray; color: white;"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column"> <!-- style="margin-left: 250px;" -->
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow fixed-top-custom"> <!-- sticky-top, fixed-top-custom -->
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div>
                        <h3>Vending Machine</h3>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                            aria-labelledby="searchDropdown">
                                <!--form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                        placeholder="Search Track" aria-label="Search"
                                        aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-dark" type="button" style="background-color: #b18cc2;">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form-->
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <ul class="na navbar-nav navbar-right d-flex align-items-center">
                            <?php if ($this->session->userdata('logged_in')) { ?>
                                <li class="nav-item">
                                <!--li-->
                                    <div>Selamat Datang, <?php echo $this->session->userdata('email'); ?></div>
                                </li>
                                <li class="nav-item ml-2">
                                <!--li class="ml-2"-->
                                    <?php echo anchor('login/logout', 'Logout', ['class' => 'nav-link']); ?>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item">
                                <!--li-->
                                    <?php echo anchor('login/index', 'Login', ['class' => 'nav-link']); ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </ul>
                </nav>
            <!--/div-->
            <!-- End of Topbar -->
        <!--/div-->
        <!-- End of Content Wrapper -->

<script>
    // Mendapatkan elemen sidebar dan tombol toggle
    var sidebar = document.getElementById('accordionSidebar');
    var sidebarToggle = document.getElementById('sidebarToggle');

    // Event listener untuk toggle sidebar
    sidebarToggle.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');
    });

    // Event listener untuk toggle sidebar
    sidebarToggleTop.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');
    });
</script>