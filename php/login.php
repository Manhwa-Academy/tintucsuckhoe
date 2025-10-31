<?php
session_start();
require_once './db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Lấy user từ db theo username
    $stmt = $pdo->prepare("SELECT tk.id_tk, tk.username, tk.password, kh.id_kh FROM dangky tk JOIN khachhang kh ON tk.id_kh = kh.id_kh WHERE tk.username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Nếu bạn lưu mật khẩu chưa mã hóa (không nên), so sánh trực tiếp
        // Nếu đã dùng password_hash, dùng password_verify
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id_kh'];  // lưu id khách hàng để dùng sau
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");  // hoặc trang bạn muốn
            exit;
        } else {
            $_SESSION['login_error'] = "Sai mật khẩu!";
        }
    } else {
        $_SESSION['login_error'] = "Không tìm thấy tên đăng nhập!";
    }
    header("Location: index.php");
    exit;
}

?>