<?php
session_start();
require_once './db.php'; // file bạn đã có

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";
    $ho_ten = trim($_POST["ho_ten"] ?? "");
    $email = trim($_POST["email"] ?? "");

    // Kiểm tra bắt buộc
    if ($username === "" || $password === "" || $confirm_password === "" || $ho_ten === "" || $email === "") {
        $_SESSION["signup_error"] = "❌ Vui lòng điền đầy đủ thông tin!";
        header("Location: index.php");
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION["signup_error"] = "❌ Mật khẩu xác nhận không khớp!";
        header("Location: index.php");
        exit;
    }

    // Kiểm tra username đã tồn tại chưa
    $stmt = $pdo->prepare("SELECT id_tk FROM taotaikhoan WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
        $_SESSION["signup_error"] = "❌ Tên đăng nhập đã tồn tại!";
        header("Location: index.php");
        exit;
    }

    // Kiểm tra email đã tồn tại chưa
    $stmt = $pdo->prepare("SELECT id_kh FROM khachhang WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $_SESSION["signup_error"] = "❌ Email đã được sử dụng!";
        header("Location: index.php");
        exit;
    }

    // Thêm khách hàng mới vào bảng khachhang trước
    $stmt = $pdo->prepare("INSERT INTO khachhang (ho_ten, email) VALUES (?, ?)");
    if (!$stmt->execute([$ho_ten, $email])) {
        $_SESSION["signup_error"] = "❌ Lỗi khi thêm khách hàng!";
        header("Location: index.php");
        exit;
    }

    // Lấy id_kh vừa tạo
    $id_kh = $pdo->lastInsertId();

    $hashedPassword = $password; // lưu mật khẩu chưa mã hóa (không khuyến nghị)

    // Thêm tài khoản vào taotaikhoan kèm id_kh làm khóa ngoại
    $stmt = $pdo->prepare("INSERT INTO taotaikhoan (username, password, id_kh) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $hashedPassword, $id_kh])) {
        $_SESSION["msg"] = "✅ Đăng ký thành công!";
        $_SESSION["username"] = $username;
    } else {
        $_SESSION["signup_error"] = "❌ Có lỗi xảy ra, vui lòng thử lại!";
    }

    header("Location: index.php");
    exit;
}
// Lấy bài nổi bật (6 bài mới nhất)
$stmt = $pdo->query("
    SELECT * FROM BaiViet
    WHERE trang_thai='da_dang'
    ORDER BY ngay_dang DESC
    LIMIT 6
");
$highlight = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Editor’s Picks (3 bài có lượt xem cao nhất)
$stmt = $pdo->query("
    SELECT * FROM BaiViet
    WHERE trang_thai='da_dang'
    ORDER BY luot_xem DESC
    LIMIT 3
");
$editors = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Latest posts (8 bài mới nhất)
$stmt = $pdo->query("
    SELECT * FROM BaiViet
    WHERE trang_thai='da_dang'
    ORDER BY ngay_dang DESC
    LIMIT 8
");
$latest = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Popular posts (5 bài có lượt xem cao nhất)
$stmt = $pdo->query("
    SELECT * FROM BaiViet
    WHERE trang_thai='da_dang'
    ORDER BY luot_xem DESC
    LIMIT 5
");
$popular = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tin tức sức khỏe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/fw.css">
    <script src="../resources/js/anime.min.js"></script>
    <link rel="stylesheet" href="../resources/css/fontawesome/css/all.min.css">
    <script src="../js/fireworks.js" async defer></script>
    <script src="../js/index.js" defer></script>
</head>

<body>
    <canvas class="fireworks"></canvas>
    <header>
        <div class="logo">
            <img src="../img/logo.svg" alt="AnniShop Logo">
        </div>
        <div class="user-info">
            <?php if (isset($_SESSION['username'])): ?>
                <strong class="welcome-message">Chào mừng, <?= htmlspecialchars($_SESSION['username']) ?>!</strong>
                <button id="togglePersonalInfo" class="btn-info">Thông tin cá nhân</button>
                <a href="./logout.php" class="logout-btn">Đăng xuất</a>
            <?php else: ?>
                <label for="showLogin">Đăng nhập</label>
            <?php endif; ?>
        </div>
        <nav>
            <a href="#">Trang chủ</a>
            <a href="#">Dinh dưỡng</a>
            <a href="#">Tập luyện</a>
            <a href="#">Nghỉ ngơi</a>
            <a href="#">Tinh thần</a>
            <a href="#">Mẹo mắt - lưng</a>
        </nav>
        <form class="search">
            <input type="text" placeholder="Tìm kiếm bài viết...">
            <button>Tìm</button>
        </form>
    </header>
    <?php if (isset($_SESSION['username'])): ?>
        <div id="personalInfo" class="personal-info"
            style="display: none; border: 1px solid #ccc; padding: 10px; max-width: 300px; margin: 10px auto;">
            <h3>Thông tin cá nhân</h3>
            <p><strong>Tên đăng nhập:</strong> <?= htmlspecialchars($_SESSION['username']) ?></p>
            <?php if (isset($_SESSION['email'])): ?>
                <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
            <?php endif; ?>
            <?php if (isset($_SESSION['phone'])): ?>
                <p><strong>Điện thoại:</strong> <?= htmlspecialchars($_SESSION['phone']) ?></p>
            <?php endif; ?>
            <a href="./user.php"
                style="display: inline-block; margin-top: 10px; background: #f86d6d; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px;">Chỉnh
                sửa thông tin</a>
        </div>
    <?php endif; ?>
    <!-- Popup -->
    <?php $popupChecked = isset($_GET['error']) ? 'checked' : ''; ?>
    <input type="radio" name="popup" id="showLogin" hidden>
    <input type="radio" name="popup" id="showSignup" hidden>
    <input type="radio" name="popup" id="hidePopup" hidden checked>
    <!-- Popup Login -->
    <div class="popup" id="loginPopup">
        <div class="popup-content">
            <h2>Đăng nhập</h2>
            <form method="post" action="./login.php" autocomplete="off">
                <input type="text" name="username" placeholder="Tên đăng nhập" required><br><br>

                <div class="password-wrapper">
                    <input type="password" name="password" id="loginPassword" placeholder="Mật khẩu" required>
                    <span class="toggle-password" data-target="loginPassword"><i class="fa fa-eye"></i></span>
                </div>

                <button type="submit">Đăng nhập</button>
            </form>
            <label for="hidePopup" class="close-btn">Đóng</label>
            <label for="showSignup" class="switch-link">Chưa có tài khoản? Đăng ký</label>
        </div>
    </div>

    <!-- Popup Signup -->
    <div class="popup" id="signupPopup">
        <div class="popup-content">
            <h2>Đăng ký</h2>
            <form method="POST" action="./signup.php" autocomplete="off">
                <input type="text" name="username" placeholder="Tên đăng nhập" required><br><br>
                <input type="text" name="ho_ten" placeholder="Họ và tên" required><br><br>
                <input type="email" name="email" placeholder="Email" required><br><br>

                <div class="password-wrapper">
                    <input type="password" name="password" id="signupPassword" placeholder="Mật khẩu" required>
                    <span class="toggle-password" data-target="signupPassword"><i class="fa fa-eye"></i></span>
                </div>

                <div class="password-wrapper">
                    <input type="password" name="confirm_password" id="signupConfirmPassword"
                        placeholder="Xác nhận mật khẩu" required>
                    <span class="toggle-password" data-target="signupConfirmPassword"><i class="fa fa-eye"></i></span>
                </div>

                <button type="submit">Đăng ký</button>
            </form>
            <label for="hidePopup" class="close-btn">Đóng</label>
            <br>
            <label for="showLogin" class="switch-link">Đã có tài khoản? Đăng nhập</label>
        </div>
    </div>

    <br>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="message-error">
            <?= htmlspecialchars($_SESSION['error']); ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php elseif (isset($_SESSION['signup_error'])): ?>
        <div class="message-error">
            <?= htmlspecialchars($_SESSION['signup_error']); ?>
        </div>
        <?php unset($_SESSION['signup_error']); ?>
    <?php elseif (isset($_SESSION['login_error'])): ?>
        <div class="message-error">
            <?= htmlspecialchars($_SESSION['login_error']); ?>
        </div>
        <?php unset($_SESSION['login_error']); ?>
    <?php elseif (isset($_SESSION['msg'])): ?>
        <div class="message-success">
            <?= htmlspecialchars($_SESSION['msg']); ?>
        </div>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>


    <main class="container">
        <div class="top-grid">
            <!-- LEFT: Editor's Picks -->
            <section class="editors">
                <h2>EDITOR'S PICKS</h2>
                <?php foreach ($editors as $e): ?>
                    <div class="editor-item">
                        <img src="<?= htmlspecialchars($e['anh_dai_dien']) ?>" alt="">
                        <div class="editor-info">
                            <h3><a href="post.php?slug=<?= urlencode($e['duong_dan']) ?>">
                                    <?= htmlspecialchars($e['tieu_de']) ?>
                                </a></h3>
                            <p class="meta">by Admin | <?= date("F d, Y", strtotime($e['ngay_dang'])) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>

            <!-- RIGHT: Main Highlights -->
            <section class="highlights">
                <div class="slider-container">
                    <div class="slider">
                        <?php
                        // Chia $highlight thành nhóm 4 bài / slide
                        $chunks = array_chunk($highlight, 4);
                        foreach ($chunks as $group): ?>
                            <div class="slide">
                                <div class="slide-grid">
                                    <?php foreach ($group as $h): ?>
                                        <div class="slide-item">
                                            <img src="<?= htmlspecialchars($h['anh_dai_dien']) ?>" alt="">
                                            <div class="overlay">
                                                <h3>
                                                    <a href="post.php?slug=<?= urlencode($h['duong_dan']) ?>">
                                                        <?= htmlspecialchars($h['tieu_de']) ?>
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="prev">&#10094;</button>
                    <button class="next">&#10095;</button>
                </div>
            </section>

        </div>

        <!-- Bottom Section -->
        <div class="bottom-section">
            <section class="latest">
                <h2>LATEST POSTS</h2>
                <div class="latest-grid">
                    <?php foreach ($latest as $l): ?>
                        <div class="latest-item">
                            <img src="<?= htmlspecialchars($l['anh_dai_dien']) ?>" alt="">
                            <a
                                href="post.php?slug=<?= urlencode($l['duong_dan']) ?>"><?= htmlspecialchars($l['tieu_de']) ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <aside class="popular">
                <h2>POPULAR POSTS</h2>
                <ul>
                    <?php foreach ($popular as $p): ?>
                        <li>
                            <img src="<?= htmlspecialchars($p['anh_dai_dien']) ?>" alt="">
                            <div>
                                <a
                                    href="post.php?slug=<?= urlencode($p['duong_dan']) ?>"><?= htmlspecialchars($p['tieu_de']) ?></a>
                                <p class="meta"><?= date("F d, Y", strtotime($p['ngay_dang'])) ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>
        </div>
    </main>

    <footer>
        <p>© 2025 Nhóm 6 - Website Tin tức Sức khỏe</p>
    </footer>
</body>

</html>