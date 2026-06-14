# Sistema de Trámites Documentarios

Aplicación web para la gestión, registro, seguimiento y administración de trámites documentarios institucionales. Desarrollada en **PHP**, **MySQL/MariaDB**, **AdminLTE**, **jQuery** y **DataTables**.

## Requisitos

- PHP 7.4+ (recomendado PHP 8.x)
- MySQL / MariaDB
- Apache (XAMPP recomendado)
- Navegador web moderno

## Instalación

1. Copiar el proyecto en `htdocs/tramites` (o la ruta de su servidor).
2. Importar la base de datos desde `sistema_tramite (1).sql` en phpMyAdmin.
3. Verificar credenciales en `model/model_conexion.php`:
   - Host: `localhost`
   - Usuario: `root`
   - Base de datos: `sistema_tramite`
4. Asegurar que las carpetas `uploads/empresa/` y `uploads/empleados/` tengan permisos de escritura.
5. Acceder a: `http://localhost/tramites/`

## Módulos del sistema

| Módulo | Descripción |
|--------|-------------|
| **Trámites** | Registro, consulta, edición, seguimiento y eliminación de documentos |
| **Áreas** | Mantenimiento de áreas/departamentos |
| **Tipos de documento** | Catálogo de tipos documentales |
| **Empleados** | Registro de personal con foto de perfil |
| **Usuarios** | Cuentas de acceso vinculadas a empleados y áreas |
| **Configuración** | Logo, fondo del login y datos institucionales |
| **Público** | Registro de trámites y consulta de seguimiento sin sesión |

## Roles

- **Administrador**: Acceso completo a todos los módulos, configuración y estadísticas.
- **Secretario (a)**: Gestión de trámites recibidos en su área asignada.

## Acceso público (sin login)

- **Rastrear trámite**: `seguimiento.php`
- **Registrar trámite**: `registrar.php`

---

## Últimos cambios realizados

### Correcciones críticas

1. **Imágenes corregidas**
   - Rutas normalizadas con `utilitario/helper_imagen.php` para login, panel y sidebar.
   - Logo y fondo del login se guardan de forma consistente en `uploads/empresa/`.
   - Foto de empleado con avatar por defecto y subida al editar.
   - Foto del usuario en el sidebar cargada desde el empleado vinculado.

2. **Lupa verde al crear trámite**
   - Eliminada la integración con RENIEC (mensaje de membresía vencida).
   - **DNI**: busca remitentes en trámites anteriores del sistema y autocompleta datos.
   - **Nº Documento**: verifica si el número ya está registrado antes de guardar.

3. **Edición de trámites**
   - Botón editar en el listado de trámites.
   - Permite modificar trámites en estado **PENDIENTE**, **RECHAZADO** y **FINALIZADO**.
   - Edición de remitente, documento, áreas, tipo y estado.

4. **Modo oscuro**
   - Toggle para alternar entre modo claro y oscuro en el panel administrativo.
   - Icono de luna/sol en la navbar para cambiar tema.
   - Preferencia guardada en localStorage para persistencia entre sesiones.
   - Estilos oscuros aplicados a toda la interfaz: tarjetas, tablas, formularios, modales, sidebar, paginación, etc.

5. **Icono de cerrar sesión actualizado**
   - Cambiado de icono antiguo a icono moderno `fa-sign-out-alt`.

6. **Modo oscuro en páginas públicas**
   - Agregado modo oscuro en `registrar.php` y `seguimiento.php`.
   - Toggle de modo oscuro en navbar con persistencia en localStorage.
   - Estilos oscuros aplicados a toda la interfaz de estas páginas.

7. **Eliminación de footer en páginas públicas**
   - Eliminado footer con mensaje en `seguimiento.php`.

8. **Logo dinámico en páginas públicas**
   - Cambiado logo estático por logo dinámico de la empresa en `registrar.php` y `seguimiento.php`.
   - Logo cargado desde base de datos usando `model_empresa.php`.

9. **Actualización de textos institucionales**
   - Login: Texto principal cambiado a "Sistema de Catastros - Tramites. Alcaldia Juan German Roscio".
   - Páginas públicas: Texto de navbar cambiado a "Sistema de Catastros".

10. **Eliminación mejorada** (cambio anterior)
   - Usuarios: eliminación liberando referencias en movimientos.
   - Áreas: reasignación automática de usuarios antes de eliminar.
   - Trámites, empleados, tipos de documento y usuarios con confirmación.

### Mejoras de interfaz (cambio anterior)

- Login rediseñado con panel moderno y estadísticas.
- Dashboard con 7 indicadores y gráfico circular de estados.
- Módulo **Configuración** para logo, fondo y datos de la institución.
- Eliminado `demo.js` de AdminLTE que mostraba alertas molestas.

---

## Estructura del proyecto

```
tramites/
├── controller/     # Controladores PHP (lógica de peticiones)
├── model/          # Modelos y conexión a base de datos
├── view/           # Vistas del panel administrativo
├── js/             # Scripts JavaScript por módulo
├── css/            # Estilos personalizados (app-theme.css)
├── uploads/        # Imágenes subidas (empresa, empleados)
├── plantilla/      # AdminLTE y recursos estáticos
├── index.php       # Login
├── registrar.php   # Registro público de trámites
└── seguimiento.php # Consulta pública de seguimiento
```

## Usuario de prueba

Tras importar la base de datos puede usar (si existe en su BD):

- **Usuario:** JESUS
- **Contraseña:** 123456
- **Rol:** Administrador

## Notas

- Los archivos adjuntos de trámites se almacenan en `controller/tramite/documentos/`.
- Al eliminar un área con trámites históricos como origen/destino, el sistema lo bloquea para preservar la trazabilidad.
- Tras cambiar imágenes en Configuración, recargue con **Ctrl + F5** para ver los cambios.

---

*Sistema de Trámites — Alcaldía / Gestión Documental*
