<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Codex Veritas</title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Favicons -->
    <link href="<?php echo base_url();?>assets/img/codex.png" rel="icon">
    <link href="<?php echo base_url();?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?php echo base_url();?>/assets/bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Template Main CSS File -->
    <link href="<?php echo base_url();?>/assets/css/style.css" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/bootstrap5/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/template/jquery-ui/jquery-ui.css"> 


     <!-- Ionicons  -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/template/Ionicons/css/ionicons.min.css">
     <!-- DataTables  -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/template/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- DataTables Export-->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/template/datatables-export/css/buttons.dataTables.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/template/font-awesome/css/font-awesome.min.css">
    <!-- Theme style  -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/template/dist/css/AdminLTE.min.css"> 
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load.  -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/template/dist/css/skins/_all-skins.min.css">



    <link href="<?php echo base_url();?>/assets/css/style_login.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/css/style_login2.css" rel="stylesheet">
    .modal-content {
      background-color: #fefefe;
      margin: auto;
      padding: 20px;
      border: 1px solid #888;
      width: 50%; /* Personaliza el ancho del modal según tus necesidades */
      border-radius: 10px;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    /* Estilos para los botones dentro del modal */
    .modal-buttons {
      text-align: right;
    }

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
    </div><!-- End Logo -->  
    <div class="user-info user-info-right">
    <span>Bienvenido: <?php echo $this->session->userdata('Nombre_usuario'); ?></span>
    <span>Unidad Académica: <?php echo $this->session->userdata('unidad_academica'); ?></span>
</div>

</header><!-- End Header -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>