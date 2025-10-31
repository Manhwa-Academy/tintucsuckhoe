<?php
session_start();
session_unset();     // Xóa toàn bộ session
session_destroy();   // Hủy session
require_once './db.php';

// Lưu thông báo vào session thay vì query string
$_SESSION["msg"] = "✅ Bạn đã đăng xuất thành công!";

header("Location: index.php");
exit;
