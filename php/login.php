<?php
session_start();
require_once './db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Kiểm tra nếu các trường bắt buộc không để trống
    if (empty($username) || empty($password)) {
        $_SESSION['login_error'] = "❌ Vui lòng nhập đầy đủ thông tin!";
        header("Location: index.php");
        exit;
    }

    // Lấy user từ db theo username
    $stmt = $pdo->prepare("SELECT tk.id_tk, tk.username, tk.password, kh.id_kh 
                           FROM taotaikhoan tk 
                           JOIN khachhang kh ON tk.id_kh = kh.id_kh 
                           WHERE tk.username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // So sánh mật khẩu nhập vào với mật khẩu trong cơ sở dữ liệu
        if ($password === $user['password']) {
            // Lưu thông tin người dùng vào session
            $_SESSION['user_id'] = $user['id_kh'];  // Lưu id khách hàng vào session
            $_SESSION['username'] = $user['username'];

            // Chèn thông tin đăng nhập vào bảng dangnhap
            $stmt = $pdo->prepare("INSERT INTO dangnhap (username, password, ngay_dn) VALUES (?, ?, NOW())");
            $stmt->execute([$username, $user['password']]);  // Dùng mật khẩu thuần túy

            // Đăng nhập thành công, chuyển hướng về trang chính
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['login_error'] = "❌ Sai mật khẩu!";
        }
    } else {
        $_SESSION['login_error'] = "❌ Không tìm thấy tên đăng nhập!";
    }

    // Chuyển hướng lại trang đăng nhập nếu có lỗi
    header("Location: index.php");
    exit;
}
?>
