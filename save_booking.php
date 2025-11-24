<?php
require_once 'db.php';
if ($_POST && !empty($_POST['phone'])) {
    $name = $_POST['name'] ?? 'Không tên';
    $phone = $_POST['phone'];
    $message = $_POST['message'] ?? '';
    
    $stmt = $db->prepare("INSERT INTO bookings (name, phone, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $phone, $message]);
}
echo '<h2 style="text-align:center;color:green;margin-top:100px">Cảm ơn quý khách! Chúng tôi sẽ gọi lại ngay!</h2>';
echo '<script>setTimeout(()=>location.href="/", 3000)</script>';
?>