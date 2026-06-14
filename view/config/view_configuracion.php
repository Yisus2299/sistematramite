<script src="../js/console_config.js?rev=<?php echo time();?>"></script>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1 class="m-0">CONFIGURACIÓN DEL SISTEMA</h1></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Inicio</a></li>
          <li class="breadcrumb-item active">Configuración</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header"><h3 class="card-title"><b>Datos de la Institución</b></h3></div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12 mb-3">
                <label>Razón Social / Nombre</label>
                <input type="text" class="form-control" id="txt_razon">
              </div>
              <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" class="form-control" id="txt_email_emp">
              </div>
              <div class="col-md-6 mb-3">
                <label>Teléfono</label>
                <input type="text" class="form-control" id="txt_telefono">
              </div>
              <div class="col-md-12 mb-3">
                <label>Dirección</label>
                <input type="text" class="form-control" id="txt_direccion">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header"><h3 class="card-title"><b>Imágenes del Sistema</b></h3></div>
          <div class="card-body">
            <label>Logo institucional</label>
            <img id="preview_logo" class="config-preview-logo d-block mb-2 mx-auto" src="../plantilla/dist/img/logo.jpeg" alt="Logo">
            <input type="file" class="form-control mb-3" id="file_logo" accept="image/jpeg,image/png,image/webp">
            <label>Imagen de fondo (Login)</label>
            <img id="preview_fondo" class="config-preview d-block mb-2" src="../plantilla/dist/img/fondo.jpg" alt="Fondo">
            <input type="file" class="form-control" id="file_fondo" accept="image/jpeg,image/png,image/webp">
            <small class="text-muted">Formatos: JPG, PNG, WEBP. Recomendado fondo 1920×1080 px.</small>
          </div>
          <div class="card-footer">
            <button class="btn btn-success btn-block" onclick="Guardar_Configuracion()">
              <i class="fas fa-save"></i> Guardar Cambios
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){ Cargar_Configuracion(); });
</script>
