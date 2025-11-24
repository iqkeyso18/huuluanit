<?php 
session_start(); 
require_once 'db.php';
if (!isset($_SESSION['admin'])) { header('Location: index.php'); exit; }

// Xóa đơn
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $db->prepare("DELETE FROM bookings WHERE id = ?")->execute([$id]);
    header('Location: dashboard.php');
}

// Thống kê
$total = $db->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$today = $db->query("SELECT COUNT(*) FROM bookings WHERE DATE(created_at) = DATE('now')")->fetchColumn();
$bookings = $db->query("SELECT * FROM bookings ORDER BY created_at DESC LIMIT 100")->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Trường An Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        :root{--red:#E31E24;--gold:#FFD700;--dark:#111;}
        body{margin:0;font-family:Arial;background:#f4f4f4;color:#333}
        header{background:var(--red);color:var(--gold);padding:20px;text-align:center;font-size:24px;position:relative}
        .logout{position:absolute;top:20px;right:20px;background:var(--gold);color:var(--red);padding:10px 20px;border-radius:50px;text-decoration:none;font-weight:bold}
        .container{max-width:1200px;margin:20px auto;padding:20px}
        .stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:30px}
        .stat-box{background:white;padding:25px;border-radius:15px;box-shadow:0 5px 20px rgba(0,0,0,0.1);text-align:center}
        .stat-box h3{font-size:36px;margin:10px 0;color:var(--red)}
        table{width:100%;border-collapse:collapse;background:white;border-radius:15px;overflow:hidden;box-shadow:0 5px 20px rgba(0,0,0,0.1)}
        th{background:var(--red);color:white;padding:15px}
        td{padding:15px;text-align:center;border-bottom:1px solid #ddd}
        tr:hover{background:#fff8e1}
        .delete-btn{background:#e74c3c;color:white;border:none;padding:8px 15px;border-radius:50px;cursor:pointer}
        .delete-btn:hover{background:#c0392b}
        footer{text-align:center;padding:30px;color:#666}
    </style>
</head>
<body>
<header>
    QUẢN TRỊ - TRƯỜNG AN TRAVEL
    <a href="logout.php" class="logout">Đăng xuất</a>
</header>

<div class="container">
    <div class="stats">
        <div class="stat-box">
            <h3><?php echo $total; ?></h3>
            <p>Tổng đơn đặt</p>
        </div>
        <div class="stat-box">
            <h3><?php echo $today; ?></h3>
            <p>Đơn hôm nay</p>
        </div>
        <div class="stat-box">
            <h3><?php echo date('d/m/Y'); ?></h3>
            <p>Ngày hiện tại</p>
        </div>
    </div>

    <h2 style="color:var(--red);margin-bottom:20px">Danh sách đơn đặt xe / tour</h2>
    <table>
        <tr>
            <th>STT</th>
            <th>Họ tên</th>
            <th>Số điện thoại</th>
            <th>Nội dung</th>
            <th>Thời gian</th>
            <th>Hành động</th>
        </tr>
        <?php $i=1; foreach($bookings as $b): ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><strong><?php echo htmlspecialchars($b['name']); ?></strong></td>
            <td><a href="tel:<?php echo $b['phone']; ?>"><?php echo $b['phone']; ?></a></td>
            <td><?php echo htmlspecialchars($b['message']); ?></td>
            <td><?php echo date('d/m/Y H:i', strtotime($b['created_at'])); ?></td>
            <td>
                <a href="?delete=<?php echo $b['id']; ?>" 
                   onclick="return confirm('Xóa đơn này?')" 
                   class="delete-btn">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($bookings)): ?>
        <tr><td colspan="6" style="text-align:center;padding:40px;color:#999">Chưa có đơn đặt nào</td></tr>
        <?php endif; ?>
    </table>
</div>

<footer>© 2026 Trường An Travel - Admin Panel by Grok</footer>
</body>
</html>