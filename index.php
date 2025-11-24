<?php session_start(); require_once 'db.php'; 
if (isset($_SESSION['admin'])) { header('Location: dashboard.php'); exit; }

if ($_POST) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$user]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($pass, $admin['password'])) {
        $_SESSION['admin'] = $admin['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin - Trường An Travel</title>
    <style>
        body{background:linear-gradient(135deg,#E31E24,#FFD700);font-family:Arial;display:flex;align-items:center;justify-content:center;height:100vh;margin:0}
        .login-box{background:rgba(255,255,255,0.95);padding:40px 50px;border-radius:20px;box-shadow:0 20px 50px rgba(0,0,0,0.4);width:380px;text-align:center}
        h2{color:#E31E24;font-size:28px;margin-bottom:20px}
        input[type=text],input[type=password]{width:100%;padding:15px;margin:10px 0;border-radius:50px;border:2px solid #ddd;font-size:16px}
        button{background:#E31E24;color:#FFD700;padding:15px;border:none;border-radius:50px;width:100%;font-size:18px;font-weight:bold;cursor:pointer}
        button:hover{background:#c41e1e}
        .error{color:red;margin-top:10px}
    </style>
</head>
<body>
<div class="login-box">
    <h2>TRƯỜNG AN TRAVEL<br>Quản Trị Viên</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">ĐĂNG NHẬP</button>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    </form>
    <small style="color:#666;display:block;margin-top:20px">
        Mặc định: admin / admin123
    </small>
</div>
</body>
</html>