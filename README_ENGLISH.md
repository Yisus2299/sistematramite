# Document Management System for the Juan Germán Roscio Mayor's Office in the Catastros Area. Venezuela, Guárico State - San Juan de los Morros (2024 - 2026)

Web application for the management, registration, tracking, and administration of institutional document procedures. Developed in **PHP**, **MySQL/MariaDB**, **AdminLTE**, **jQuery**, and **DataTables**.

## Requirements

- PHP 7.4+ (PHP 8.x recommended)
- MySQL / MariaDB
- Apache (XAMPP recommended)
- Modern web browser

## Installation

1. Copy the project to `htdocs/tramites` (or your server's path).
2. Import the database from `sistema_tramite (1).sql` in phpMyAdmin.
3. Verify credentials in `model/model_conexion.php`:
   - Host: `localhost`
   - User: `root`
   - Database: `sistema_tramite`
4. Ensure that the folders `uploads/empresa/` and `uploads/empleados/` have write permissions.
5. Access: `http://localhost/tramites/`

## System Modules

| Module | Description |
|--------|-------------|
| **Procedures (Trámites)** | Registration, query, editing, tracking, and deletion of documents |
| **Areas (Áreas)** | Maintenance of areas/departments |
| **Document Types (Tipos de documento)** | Catalog of document types |
| **Employees (Empleados)** | Personnel registration with profile photo |
| **Users (Usuarios)** | Access accounts linked to employees and areas |
| **Configuration (Configuración)** | Logo, login background, and institutional data |
| **Public (Público)** | Procedure registration and tracking consultation without session |

## Roles

- **Administrator**: Full access to all modules, configuration, and statistics.
- **Secretary**: Management of procedures received in their assigned area.

## Public Access (without login)

- **Track procedure**: `seguimiento.php`
- **Register procedure**: `registrar.php`

---

## Recent Changes

### Critical Fixes

1. **Images corrected**
   - Normalized paths with `utilitario/helper_imagen.php` for login, panel, and sidebar.
   - Login logo and background saved consistently in `uploads/empresa/`.
   - Employee photo with default avatar and upload when editing.
   - User photo in sidebar loaded from the linked employee.

2. **Green magnifying glass when creating procedure**
   - Removed RENIEC integration (membership expired message).
   - **DNI**: searches for senders in previous system procedures and auto-completes data.
   - **Document Number**: verifies if the number is already registered before saving.

3. **Procedure editing**
   - Edit button in the procedure list.
   - Allows modifying procedures in **PENDING**, **REJECTED**, and **FINISHED** status.
   - Editing of sender, document, areas, type, and status.

4. **Dark mode**
   - Toggle to switch between light and dark mode in the administrative panel.
   - Moon/sun icon in the navbar to change the theme.
   - Preference saved in localStorage for persistence between sessions.
   - Dark styles applied to the entire interface: cards, tables, forms, modals, sidebar, pagination, etc.

5. **Logout icon updated**
   - Changed from old icon to modern icon `fa-sign-out-alt`.

6. **Dark mode on public pages**
   - Added dark mode in `registrar.php` and `seguimiento.php`.
   - Dark mode toggle in navbar with localStorage persistence.
   - Dark styles are applied to the entire interface of these pages.

7. **Footer removal on public pages**
   - Removed footer with message in `seguimiento.php`.

8. **Dynamic logo on public pages**
   - Changed static logo to dynamic company logo in `registrar.php` and `seguimiento.php`.
   - Logo loaded from database using `model_empresa.php`.

9. **Institutional text update**
   - Login: Main text changed to "Sistema de Catastros - Trámites. Alcaldía Juan Germán Roscio".
   - Public pages: Navbar text changed to "Sistema de Catastros".

10. **Improved deletion** (previous change)
    - Users: deletion, releasing references in movements.
    - Areas: automatic reassignment of users before deletion.
    - Procedures, employees, document types, and users with confirmation.

### Interface improvements (previous change)

- Login redesigned with a modern panel and statistics.
- Dashboard with 7 indicators and circular status chart.
- **Configuration** module for logo, background, and institutional data.
- Removed `demo.js` from AdminLTE that showed annoying alerts.

---

## Project Structure

```
tramites/
├── controller/     # PHP controllers (request logic)
├── model/          # Models and database connection
├── view/           # Administrative panel views
├── js/             # JavaScript scripts by module
├── css/            # Custom styles (app-theme.css)
├── uploads/        # Uploaded images (company, employees)
├── plantilla/      # AdminLTE and static resources
├── index.php       # Login
├── registrar.php   # Public procedure registration
└── seguimiento.php # Public tracking consultation
```

## Test User

After importing the database, you can use this administrator user to test the functionalities:

- **User:** JESUS
- **Password:** 123456
- **Role:** Administrator

## Notes

- Procedure attachment files are stored in `controller/tramite/documentos/`.
- When deleting an area with historical procedures as origin/destination, the system blocks it to preserve traceability.
- After changing images in Configuration, reload with **Ctrl + F5** to see the changes.

---

*Document Management System — Mayor's Office / Document Management*
