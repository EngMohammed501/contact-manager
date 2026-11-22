# Contact Manager (PHP MVC)

A simple Contact Manager web application built using a custom PHP MVC architecture (`models/`, `views/`, `controllers/`, and front controller `index.php`) with MySQL (PDO).

## Admin Login Credentials
- **Username:** `admin`
- **Password:** `Admin@123`

## Database Setup
- Import the SQL script located in the `sql/` folder (`schema.sql`) into MySQL (`contact_manager` database).

## Security List
1. **Prepared Statements (PDO):** All database queries (`SELECT`, `INSERT`, `UPDATE`, `DELETE`) use PDO prepared statements with bound parameters to prevent SQL Injection.
2. **Password Hashing:** Admin password verification uses PHP's `password_hash()` and `password_verify()` instead of plain-text comparison.
3. **Session & Access Control:** Protected actions (`add`, `edit`, `delete`) verify `$_SESSION['is_admin']` and call `session_regenerate_id(true)` upon login to mitigate session fixation.
4. **Input Sanitization & Output Escaping:** User inputs are trimmed/validated, and rendered values in views are escaped using `htmlspecialchars()` to prevent XSS.

## Integrity Statement
I confirm that this submission represents my own work and understanding of the custom PHP MVC architecture required for Assignment 1. In accordance with the course policy on transparent AI usage, AI assistance was used solely for debugging guidance, syntax verification, and structuring documentation, while all code integration, database setup, and local testing were performed and verified by me.