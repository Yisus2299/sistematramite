<?php
    session_start();
    if(!isset($_SESSION['S_ID'])){
      header('Location: ../index.php');
      exit;
    }
    require_once '../model/model_empresa.php';
    require_once '../utilitario/helper_imagen.php';
    $ME = new Modelo_Empresa();
    $empresa = $ME->Obtener_Empresa();
    $logoApp  = ruta_imagen($empresa['emp_logo'] ?? '', 'view', 'logo');
    $fotoUsuario = ruta_imagen($_SESSION['S_FOTO'] ?? '', 'view', 'avatar');
    $razonApp = !empty($empresa['emp_razon']) ? $empresa['emp_razon'] : 'Sistema de Trámites';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($razonApp); ?> | Panel</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plantilla/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../plantilla/dist/css/adminlte.min.css">
  <link rel="stylesheet" type="text/css" href="../utilitario/DataTables/datatables.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/app-theme.css?v=<?php echo time();?>">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
  
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Dark Mode Toggle -->
      <li class="nav-item">
        <a class="nav-link" href="#" onclick="toggleDarkMode()" id="darkModeToggle" title="Cambiar tema">
          <i class="fas fa-moon" id="darkModeIcon"></i>
        </a>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
            <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
        <?php  echo $_SESSION['S_USU']  ?>
        <i class="fas fa-caret-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="../controller/usuario/controlador_cerrar_sesion.php" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
          </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-modern">
    <a href="index.php" class="brand-link brand-link-modern">
      <img src="<?php echo htmlspecialchars($logoApp); ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity:.9" id="sidebar_logo">
      <span class="brand-text font-weight-light"><?php echo htmlspecialchars($razonApp); ?></span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo htmlspecialchars($fotoUsuario); ?>" class="img-circle elevation-2" alt="Usuario" style="width:34px;height:34px;object-fit:cover" id="sidebar_foto" onerror="this.src='../plantilla/dist/img/avatar.png'">
        </div>
        <div class="info">
          <a href="#" class="d-block text-white"><?php echo htmlspecialchars($_SESSION['S_USU']); ?></a>
          <small class="text-muted"><?php echo htmlspecialchars($_SESSION['S_ROL']); ?></small>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
       
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <?php if($_SESSION['S_ROL']=='Administrador') {?>
          <li class="nav-item">
            <a onclick="cargar_contenido('contenido_principal','tramite/view_tramite.php')" class="nav-link">
              <i class="nav-icon fas fa-file-signature"></i>
              <p>
                Tramite
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a onclick="cargar_contenido('contenido_principal','usuario/view_usuario.php')" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Usuario
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a onclick="cargar_contenido('contenido_principal','empleado/view_empleado.php')" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Empleado
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a onclick="cargar_contenido('contenido_principal','area/view_area.php')" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Area
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a onclick="cargar_contenido('contenido_principal','tipo_documento/view_tipodocumento.php')" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>Tipo Documento</p>
            </a>
          </li>
          <li class="nav-item">
            <a onclick="cargar_contenido('contenido_principal','config/view_configuracion.php')" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>Configuración</p>
            </a>
          </li>
          <?php 
          } 
          ?>
        <?php if($_SESSION['S_ROL']=='Secretario (a)') {?>
          <li class="nav-item">
            <a onclick="cargar_contenido('contenido_principal','tramite_area/view_tramite.php')" class="nav-link">
              <i class="nav-icon fas fa-file-signature"></i>
              <p>
                Tramite Recibidos
              </p>
            </a>
          </li>
          <?php 
          } 
          ?>  
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <input type="text" id="txtprincipalid" value="<?php echo $_SESSION['S_ID']; ?>" hidden>
  <input type="text" id="txtprincipalusu" value="<?php echo $_SESSION['S_USU']; ?>" hidden>
  <input type="text" id="txtprincipalrol" value="<?php echo $_SESSION['S_ROL']; ?>" hidden>
  <div class="content-wrapper" id="contenido_principal">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1 class="m-0">Panel de Control</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <?php if($_SESSION['S_ROL']=='Administrador') {?>
        <div class="dashboard-welcome">
          <h2><i class="fas fa-chart-line mr-2"></i>Bienvenido, <?php echo htmlspecialchars($_SESSION['S_USU']); ?></h2>
          <p>Resumen general del sistema de trámites documentarios — <?php echo date('d/m/Y'); ?></p>
        </div>
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box stat-card bg-gradient-primary">
              <div class="inner"><h3 id="lbl_tramite">0</h3><p>Trámites Registrados</p></div>
              <div class="icon"><i class="fas fa-file-alt"></i></div>
              <a onclick="cargar_contenido('contenido_principal','tramite/view_tramite.php')" class="small-box-footer">Ver trámites <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box stat-card bg-gradient-success">
              <div class="inner"><h3 id="lbl_tramite_finalizado">0</h3><p>Finalizados</p></div>
              <div class="icon"><i class="fas fa-check-circle"></i></div>
              <a onclick="cargar_contenido('contenido_principal','tramite/view_tramite.php')" class="small-box-footer">Ver trámites <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box stat-card bg-gradient-warning">
              <div class="inner"><h3 id="lbl_tramite_pendiente">0</h3><p>Pendientes</p></div>
              <div class="icon"><i class="fas fa-clock"></i></div>
              <a onclick="cargar_contenido('contenido_principal','tramite/view_tramite.php')" class="small-box-footer">Ver trámites <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box stat-card bg-gradient-danger">
              <div class="inner"><h3 id="lbl_tramite_rechazado">0</h3><p>Rechazados</p></div>
              <div class="icon"><i class="fas fa-times-circle"></i></div>
              <a onclick="cargar_contenido('contenido_principal','tramite/view_tramite.php')" class="small-box-footer">Ver trámites <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box stat-card bg-gradient-info">
              <div class="inner"><h3 id="lbl_tramite_mes">0</h3><p>Este Mes</p></div>
              <div class="icon"><i class="fas fa-calendar-alt"></i></div>
              <span class="small-box-footer">&nbsp;</span>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box stat-card bg-gradient-dark">
              <div class="inner"><h3 id="lbl_usuarios">0</h3><p>Usuarios Activos</p></div>
              <div class="icon"><i class="fas fa-users"></i></div>
              <a onclick="cargar_contenido('contenido_principal','usuario/view_usuario.php')" class="small-box-footer">Ver usuarios <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box stat-card bg-gradient-orange">
              <div class="inner"><h3 id="lbl_areas">0</h3><p>Áreas Activas</p></div>
              <div class="icon"><i class="fas fa-building"></i></div>
              <a onclick="cargar_contenido('contenido_principal','area/view_area.php')" class="small-box-footer">Ver áreas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card chart-card">
              <div class="card-header border-0"><h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i> Estado de Trámites</h3></div>
              <div class="card-body"><canvas id="chartTramites" height="180"></canvas></div>
            </div>
          </div>
        </div>
        <?php } else { ?>
        <div class="dashboard-welcome">
          <h2><i class="fas fa-inbox mr-2"></i>Bienvenido, <?php echo htmlspecialchars($_SESSION['S_USU']); ?></h2>
          <p>Panel de gestión de trámites recibidos en su área.</p>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->



<!-- REQUIRED SCRIPTS -->
<script>
    // Dark Mode Toggle
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        const icon = document.getElementById('darkModeIcon');
        if (document.body.classList.contains('dark-mode')) {
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
            localStorage.setItem('darkMode', 'enabled');
            applyDarkModeToPagination();
        } else {
            icon.classList.remove('fa-sun');
            icon.classList.add('fa-moon');
            localStorage.setItem('darkMode', 'disabled');
            removeDarkModeFromPagination();
        }
    }

    // Apply dark mode styles to pagination buttons
    function applyDarkModeToPagination() {
        const paginateButtons = document.querySelectorAll('.dataTables_paginate .paginate_button');
        paginateButtons.forEach(btn => {
            btn.style.setProperty('background-color', '#16213e', 'important');
            btn.style.setProperty('color', '#e0e0e0', 'important');
            btn.style.setProperty('border-color', '#2a2a4a', 'important');
            btn.style.setProperty('background', 'linear-gradient(to bottom, #16213e 0%, #16213e 100%)', 'important');
        });

        const currentButtons = document.querySelectorAll('.dataTables_paginate .paginate_button.current');
        currentButtons.forEach(btn => {
            btn.style.setProperty('background-color', '#1a5276', 'important');
            btn.style.setProperty('color', '#ffffff', 'important');
            btn.style.setProperty('border-color', '#1a5276', 'important');
            btn.style.setProperty('background', 'linear-gradient(to bottom, #1a5276 0%, #0e3349 100%)', 'important');
        });

        const disabledButtons = document.querySelectorAll('.dataTables_paginate .paginate_button.disabled');
        disabledButtons.forEach(btn => {
            btn.style.setProperty('background-color', '#16213e', 'important');
            btn.style.setProperty('color', 'rgba(224,224,224,0.3)', 'important');
            btn.style.setProperty('border-color', '#2a2a4a', 'important');
            btn.style.setProperty('background', 'transparent', 'important');
        });
    }

    // Remove dark mode styles from pagination buttons
    function removeDarkModeFromPagination() {
        const paginateButtons = document.querySelectorAll('.dataTables_paginate .paginate_button');
        paginateButtons.forEach(btn => {
            btn.style.removeProperty('background-color');
            btn.style.removeProperty('color');
            btn.style.removeProperty('border-color');
            btn.style.removeProperty('background');
        });
    }

    // Load dark mode preference on page load
    if (localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.add('dark-mode');
        const icon = document.getElementById('darkModeIcon');
        if (icon) {
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        }
        // Apply dark mode to pagination after a short delay to ensure DataTables is loaded
        setTimeout(applyDarkModeToPagination, 500);
    }

    // Re-apply dark mode styles when DataTables pagination changes
    $(document).on('draw.dt', function() {
        if (document.body.classList.contains('dark-mode')) {
            setTimeout(applyDarkModeToPagination, 100);
        }
    });

    function cargar_contenido(id,vista){
        $("#"+id).load(vista);
    }

    var idioma_espanol = {
			select: {
			rows: "%d fila seleccionada"
			},
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ning&uacute;n dato disponible en esta tabla",
			"sInfo":           "Registros del (_START_ al _END_) total de _TOTAL_ registros",
			"sInfoEmpty":      "Registros del (0 al 0) total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "<b>No se encontraron datos</b>",
			"oPaginate": {
					"sFirst":    "Primero",
					"sLast":     "Último",
					"sNext":     "Siguiente",
					"sPrevious": "Anterior"
			},
			"oAria": {
					"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
					"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
   }
   function soloNumeros(e){
      tecla = (document.all) ? e.keyCode : e.which;
      if (tecla==8){
          return true;
      }
      // Patron de entrada, en este caso solo acepta numeros
      patron =/[0-9]/;
      tecla_final = String.fromCharCode(tecla);
      return patron.test(tecla_final);
  }
  function soloLetras(e){
      key = e.keyCode || e.which;
      tecla = String.fromCharCode(key).toLowerCase();
      letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
      especiales = "8-37-39-46";
      tecla_especial = false
      for(var i in especiales){
          if(key == especiales[i]){
              tecla_especial = true;
              break;
          }
      }
      if(letras.indexOf(tecla)==-1 && !tecla_especial){
          return false;
      }
  }

  function filterFloat(evt,input){
    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {
              return true;
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{
                    return true;
                }
          }else{
              return false;
          }
    }
}
function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
    if(preg.test(__val__) === true){
        return true;
    }else{
        return false;
    }
}
</script>
<!-- jQuery -->
<script src="../plantilla/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plantilla/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../plantilla/dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../utilitario/DataTables/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
<?php if($_SESSION['S_ROL']=='Administrador') {?>
  var chartTramites = null;
  Traer_Dashboard();
  function Traer_Dashboard(){
    $.ajax({
        url:"../controller/usuario/controlador_traer_dashboard.php",
        type:'POST'
    }).done(function(resp){
        let d = JSON.parse(resp);
        if(d){
          document.getElementById('lbl_tramite').innerHTML = d.total || 0;
          document.getElementById('lbl_tramite_finalizado').innerHTML = d.finalizados || 0;
          document.getElementById('lbl_tramite_pendiente').innerHTML = d.pendientes || 0;
          document.getElementById('lbl_tramite_rechazado').innerHTML = d.rechazados || 0;
          document.getElementById('lbl_tramite_mes').innerHTML = d.mes_actual || 0;
          document.getElementById('lbl_usuarios').innerHTML = d.usuarios || 0;
          document.getElementById('lbl_areas').innerHTML = d.areas || 0;
          renderChart(parseInt(d.finalizados)||0, parseInt(d.pendientes)||0, parseInt(d.rechazados)||0);
        }
    });
  }
  function renderChart(finalizados, pendientes, rechazados){
    let ctx = document.getElementById('chartTramites');
    if(!ctx) return;
    if(chartTramites) chartTramites.destroy();
    chartTramites = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Finalizados','Pendientes','Rechazados'],
        datasets: [{
          data: [finalizados, pendientes, rechazados],
          backgroundColor: ['#27ae60','#f39c12','#c0392b'],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
      }
    });
  }
<?php } ?>
</script>

</body>
</html>
