function Cargar_Configuracion(){
    $.ajax({
        url: "../controller/empresa/controlador_obtener_empresa.php",
        type: 'POST'
    }).done(function(resp){
        let d = JSON.parse(resp);
        if(d && d.empresa_id){
            document.getElementById('txt_razon').value = d.emp_razon || '';
            document.getElementById('txt_email_emp').value = d.emp_email || '';
            document.getElementById('txt_telefono').value = d.emp_telefono || '';
            document.getElementById('txt_direccion').value = d.emp_direccion || '';
            if(d.emp_logo){
                document.getElementById('preview_logo').src = '../' + d.emp_logo;
            }
            if(d.emp_fondo){
                document.getElementById('preview_fondo').src = '../' + d.emp_fondo;
            }
        }
    });
    $('#file_logo').off('change').on('change', function(e){
        if(e.target.files[0]){
            document.getElementById('preview_logo').src = URL.createObjectURL(e.target.files[0]);
        }
    });
    $('#file_fondo').off('change').on('change', function(e){
        if(e.target.files[0]){
            document.getElementById('preview_fondo').src = URL.createObjectURL(e.target.files[0]);
        }
    });
}

function Guardar_Configuracion(){
    let formData = new FormData();
    formData.append('razon', document.getElementById('txt_razon').value);
    formData.append('email', document.getElementById('txt_email_emp').value);
    formData.append('telefono', document.getElementById('txt_telefono').value);
    formData.append('direccion', document.getElementById('txt_direccion').value);
    if(document.getElementById('file_logo').files[0]){
        formData.append('logo', document.getElementById('file_logo').files[0]);
    }
    if(document.getElementById('file_fondo').files[0]){
        formData.append('fondo', document.getElementById('file_fondo').files[0]);
    }
    $.ajax({
        url: "../controller/empresa/controlador_actualizar_empresa.php",
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false
    }).done(function(resp){
        if(resp > 0){
            Swal.fire("Confirmación", "Configuración actualizada correctamente", "success").then(()=>{
                Cargar_Configuracion();
                $.post("../controller/empresa/controlador_obtener_empresa.php", function(r){
                    let d = JSON.parse(r);
                    if(d.emp_logo){
                        document.getElementById('sidebar_logo').src = '../' + d.emp_logo;
                    }
                });
            });
        } else {
            Swal.fire("Error", "No se pudo guardar la configuración", "error");
        }
    });
}
