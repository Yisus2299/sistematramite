<?php
    session_start();
    if(isset($_SESSION['S_ID'])){
      header('Location: view/index.php');
      exit;
    }
    require_once 'model/model_empresa.php';
    require_once 'utilitario/helper_imagen.php';
    $ME = new Modelo_Empresa();
    $empresa = $ME->Obtener_Empresa();
    $fondo = ruta_imagen($empresa['emp_fondo'] ?? '', 'root', 'fondo');
    $logo  = ruta_imagen($empresa['emp_logo'] ?? '', 'root', 'logo');
    $razon = !empty($empresa['emp_razon']) ? $empresa['emp_razon'] : 'Sistema de Trámites Documentarios';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($razon); ?> | Inicio de Sesión</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap">
  <link rel="stylesheet" href="plantilla/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plantilla/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="css/app-theme.css?v=<?php echo time();?>">
</head>
<body class="login-modern">
  <div class="login-bg" style="background-image:url('<?php echo htmlspecialchars($fondo);?>')"></div>
  <div class="login-wrapper">
    <div class="login-panel">
      <div class="login-brand">
        <img src="<?php echo htmlspecialchars($logo);?>" alt="Logo institucional" id="img_logo_login">
        <h1>Sistema de Catastros - Tramites. Alcaldia Juan German Roscio</h1>
        <p>Gestión eficiente de trámites documentarios. Control, seguimiento y trazabilidad en un solo lugar.</p>
        <div class="login-stats" id="login_stats">
          <div class="login-stat"><strong id="stat_total">—</strong><span>Trámites</span></div>
          <div class="login-stat"><strong id="stat_finalizados">—</strong><span>Finalizados</span></div>
        </div>
      </div>
      <div class="login-form-side">
        <h2>Iniciar Sesión</h2>
        <p class="subtitle">Ingrese sus credenciales para acceder al panel</p>
        <div class="form-group">
          <label class="small text-muted font-weight-bold">USUARIO</label>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Nombre de usuario" id="txt_usuario">
            <div class="input-group-append"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
          </div>
        </div>
        <div class="form-group">
          <label class="small text-muted font-weight-bold">CONTRASEÑA</label>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Contraseña" id="txt_contra">
            <div class="input-group-append"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
          </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="icheck-primary">
            <input type="checkbox" id="remember">
            <label for="remember" class="small">Recordarme</label>
          </div>
          <button type="button" class="btn btn-primary btn-login px-4" onclick="Iniciar_Sesion()">
            <i class="fas fa-sign-in-alt mr-1"></i> Ingresar
          </button>
        </div>
        <div class="login-links">
          <a href="seguimiento.php"><i class="fas fa-search mr-1"></i> Rastrear Trámite</a>
          <a href="registrar.php"><i class="fas fa-file-alt mr-1"></i> Registrar Trámite</a>
        </div>
      </div>
    </div>
  </div>
<script src="plantilla/plugins/jquery/jquery.min.js"></script>
<script src="plantilla/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="js/console_usuario.js?rev=<?php echo time();?>"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  const rmcheck = document.getElementById('remember'),
        usuarioInput = document.getElementById('txt_usuario'),
        passInput = document.getElementById('txt_contra');
  if(localStorage.checkbox && localStorage.checkbox != ""){
    rmcheck.setAttribute("checked","checked");
    usuarioInput.value = localStorage.usuario;
    passInput.value = localStorage.pass;
  }
  $.post('controller/usuario/controlador_traer_dashboard.php', function(resp){
    let d = JSON.parse(resp);
    if(d.total !== undefined){
      document.getElementById('stat_total').textContent = d.total;
      document.getElementById('stat_finalizados').textContent = d.finalizados;
    }
  });
</script>
</body>
</html>
