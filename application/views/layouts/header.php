<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Codex Veritas</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<<<<<<< HEAD
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
 <!-- Vendor CSS Files -->
 <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/simple-datatables/style.css" rel="stylesheet">
<!-- Template Main CSS File -->
<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/jquery-ui/jquery-ui.css"> 
     <!-- Ionicons  -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/Ionicons/css/ionicons.min.css">
     <!-- DataTables  -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- DataTables Export-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/datatables-export/css/buttons.dataTables.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/font-awesome/css/font-awesome.min.css">
    <!-- Theme style  -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/dist/css/AdminLTE.min.css"> 
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load.  -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/dist/css/skins/_all-skins.min.css">
=======
  <!-- Favicons -->
  <link href="<?php echo base_url(); ?>assets/img/codex.png" rel="icon">
  <link href="<?php echo base_url(); ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url(); ?>/assets/css/style.css" rel="stylesheet">
  

  <!-- jquery -->
  <script src="<?php echo base_url(); ?>/assets/DataTables/jquery/jquery-3.7.1.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/jquery-ui/jquery-ui.css">
  <!-- popper -->
  <script src="https://unpkg.com/@popperjs/core@2"></script>



>>>>>>> ff9781c115fa0635d9e7d3b7612acbe08b40a5f9

  <!-- Ionicons  -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/Ionicons/css/ionicons.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/font-awesome/css/font-awesome.min.css">


  <link href="<?php echo base_url(); ?>assets/css/style_login.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/style_login2.css" rel="stylesheet">

</head>

<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="<?php echo base_url(); ?>principal" class="logo d-flex align-items-center">
      <img src="<?php echo base_url(); ?>assets/img/codex.png">
      <span class="d-none d-lg-block">CodexVerita</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="<?php echo base_url(); ?>assets/img/codex.png" alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>Kevin Anderson</h6>
            <span>Web Designer</span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
              <i class="bi bi-gear"></i>
              <span>Account Settings</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

<<<<<<< HEAD
    .modal-buttons button {
      margin-left: 5px;
    }
    .logo img {
    max-width: 100px; /* Ajusta el tamaño máximo del logo según tus necesidades */
}
  </style>
<body>

<header id="header" class="header fixed-top d-flex align-items-center blue-gradient-bg">
    <div class="d-flex align-items-center justify-content-between header-center">
        <a href="<?php echo base_url();?>principal" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block header-title">Codex Veritas</span>
        </a>
       
 
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
    <div class="user-info user-info-right">
    <span>Bienvenido: <?php echo $this->session->userdata('Nombre_usuario'); ?></span>
    <span>Unidad Académica: <?php echo $this->session->userdata('unidad_academica'); ?></span>
</div>
</ul>
    </nav><!-- End Icons Navigation -->
</header><!-- End Header -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>
=======
          <li>
            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
              <i class="bi bi-question-circle"></i>
              <span>Need Help?</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="#">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
          </li>

        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->
    </ul>
  </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
>>>>>>> ff9781c115fa0635d9e7d3b7612acbe08b40a5f9
