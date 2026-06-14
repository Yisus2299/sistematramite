<?php
    require_once 'model/model_empresa.php';
    require_once 'utilitario/helper_imagen.php';
    $ME = new Modelo_Empresa();
    $empresa = $ME->Obtener_Empresa();
    $logoPublico = ruta_imagen($empresa['emp_logo'] ?? '', 'root', 'logo');
    $razonPublico = !empty($empresa['emp_razon']) ? $empresa['emp_razon'] : 'Sistema de Trámites';
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($razonPublico); ?> | Seguimiento de Trámite</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plantilla/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="plantilla/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="css/app-theme.css?v=<?php echo time();?>">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="index.php" class="navbar-brand">
        <img src="<?php echo htmlspecialchars($logoPublico); ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Sistema de Catastros</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="index.php" class="nav-link"><i class="fa fa-user"></i> Login</a>
          </li>
         
        </ul>

      </div>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Dark Mode Toggle -->
        <li class="nav-item">
          <a class="nav-link" href="#" onclick="toggleDarkMode()" id="darkModeToggle" title="Cambiar tema">
            <i class="fas fa-moon" id="darkModeIcon"></i>
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Realiza el seguimiento de tu tramite</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header bg-primary">
                <h5 class="card-title m-0"><b>Buscador de tramite</b></h5>
              </div>
              <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <label for="">Nro Tramite</label>
                        <input type="text" class="form-control" id="txt_numero">
                    </div>
                    <div class="col-5">
                        <label for="">Nro DNI</label>
                        <input type="text" class="form-control" id="txt_dni">
                    </div>
                    <div class="col-2">
                        <label for="">&nbsp;</label><br>
                        <button class="btn btn-danger" style="width:100%" onclick="Traer_Datos_Seguimiento()"><i class="fa fa-search"></i>Buscar</button>
                    </div>
                </div>
              </div>
            </div>

         
          </div>
          <div class="col-lg-12" id="div_buscador" style="display:none">
            <div class="card">
              <div class="card-header bg-primary">
                <h5 class="card-title m-0" id="lbl_titulo"></h5>
              </div>
              <div class="card-body">
                <div class="row">
                    <div class="col-md-12" id="div_seguimiento">
                        <!-- The time line -->
                            
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                           
                        
                    </div>                    
                </div>
              </div>
            </div>

         
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plantilla/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plantilla/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="plantilla/dist/js/adminlte.min.js"></script>
<script src="js/console_usuario.js?rev=<?php echo time();?>"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Dark Mode Toggle
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        const icon = document.getElementById('darkModeIcon');
        if (document.body.classList.contains('dark-mode')) {
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
            localStorage.setItem('darkMode', 'enabled');
        } else {
            icon.classList.remove('fa-sun');
            icon.classList.add('fa-moon');
            localStorage.setItem('darkMode', 'disabled');
        }
    }

    // Load dark mode preference on page load
    if (localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.add('dark-mode');
        const icon = document.getElementById('darkModeIcon');
        if (icon) {
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        }
    }
</script>
</body>
</html>