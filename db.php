<?php
// admin/db.php
$db = new PDO('sqlite:../bookings.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Tạo bảng bookings nếu chưa có
$db->exec("CREATE TABLE IF NOT EXISTS bookings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    phone TEXT,
    message TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$db->exec("CREATE TABLE IF NOT EXISTS admin_users (
    id INTEGER PRIMARY KEY,
    username TEXT UNIQUE,
    password TEXT
)");

// Tài khoản admin mặc định (username: admin | mật khẩu: admin123)
$check = $db->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
if ($check == 0) {
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $db->exec("INSERT INTO admin_users (username, password) VALUES ('admin', '$hash')");
}
?>