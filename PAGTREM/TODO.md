# TODO: Transform to Navigable System with Login/Logout

## 1. Database Fixes
- [x] Update db.sql: Correct "ususarios" to "usuarios", add sensors table with sample data, add categories table if needed.
- [x] Update config/db.php: Change DB name to "login_db", add charset.

## 2. Authentication and Sessions
- [x] Create public/logout.php: Destroy session and redirect to login.
- [x] Edit public/login.php: Fix table name to "usuarios", add password hashing (update existing data or note).
- [x] Edit public/cadastro1.php: Complete multi-step registration to include username/senha/cargo, hash password, fix form to single POST.

## 3. Navigation
- [x] Edit public/menu.php: Make it includable (remove full HTML), add session check, add logout link.
- [x] Add session checks to all protected pages: dashboard.php, gestaoderotas.php, relatorios.php, notificacoes.php, monitoramento.php, etc.

## 4. Dashboard with Data
- [x] Edit public/dashboard.php: Display real data like user count, sensor statuses, categories.

## 5. User Listing
- [x] Create public/lista_usuarios.php: Display users table, link from menu.

## 6. Sensor Tables
- [x] Edit public/monitoramento.php: Add sensor data table, include menu and session check.

## 7. Testing and Fixes
- [x] Execute SQL updates to apply schema changes (manual via XAMPP/phpMyAdmin).
- [x] Test login/logout, navigation, data display.
- [x] Fix any errors from edits.
