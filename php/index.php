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
    <link rel="stylesheet" href="../css/fw.css">
    <link rel="stylesheet" href="../css/index.css">
    <script src="../resources/js/anime.min.js"></script>
    <link rel="stylesheet" href="../resources/css/fontawesome/css/all.min.css">
    <script src="../js/fireworks.js" async defer></script>
</head>

<body>
    <canvas class="fireworks"></canvas>
    <header class="site-header">
        <!-- Logo -->
        <div class="left">
            <a href="index.php" class="logo-link">
                <img src="../img/logo.svg" alt="Logo" class="logo-img" />
            </a>
        </div>

        <!-- Menu điều hướng -->
        <nav class="main-nav" aria-label="Main navigation">
            <a href="#">Trang chủ</a>
            <a href="#">Dinh dưỡng</a>
            <a href="#">Tập luyện</a>
            <a href="#">Nghỉ ngơi</a>
            <a href="#">Tinh thần</a>
            <a href="#">Mẹo mắt - lưng</a>
        </nav>

        <!-- Bên phải header -->
        <div class="right">
            <!-- Nút tìm kiếm -->
            <button class="icon-btn" id="openSearch" aria-label="Tìm kiếm">
                <i class="fas fa-search"></i>
            </button>
            <div class="search-bar" id="searchBar">
                <input type="text" placeholder="Tìm kiếm bài viết..." id="searchInput">
                <button id="searchSubmit"><i class="fas fa-arrow-right"></i></button>
            </div>

            <!-- Nút thông báo -->
            <button class="icon-btn" aria-label="Thông báo">
                <i class="fas fa-bell"></i>
            </button>

            <!-- Khu vực người dùng -->
            <?php if (isset($_SESSION['username'])): ?>
                <div class="user-menu">
                    <button class="user-toggle" id="userToggle" aria-haspopup="true" aria-expanded="false">
                        <img src="<?= htmlspecialchars($_SESSION['avatar'] ?? '../img/default-avatar.jpg') ?>" alt="Avatar"
                            class="user-avatar" />
                        <span class="user-name"><?= htmlspecialchars($_SESSION['ho_ten'] ?? $_SESSION['username']) ?></span>
                        <i class="arrow">▾</i>
                    </button>

                    <!-- Dropdown -->
                    <div class="dropdown" id="dropdownMenu" role="menu" aria-hidden="true">
                        <div class="user-header">
                            <img src="<?= htmlspecialchars($_SESSION['avatar'] ?? '../img/default-avatar.jpg') ?>"
                                alt="Avatar" />
                            <div class="uh-info">
                                <strong><?= htmlspecialchars($_SESSION['ho_ten'] ?? $_SESSION['username']) ?></strong>
                                <div class="uh-sub"><?= htmlspecialchars($_SESSION['email'] ?? '') ?></div>
                            </div>
                        </div>

                        <ul class="menu-list">
                            <li>
                                <a href="#"><i class="fas fa-user"></i> Tài khoản</a>
                                <span class="tag vip">VIP 0</span>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-history"></i> Lịch sử</a>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-bookmark"></i> Đã lưu</a>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-bell"></i> Thông báo</a>
                            </li>
                            <li>
                                <a href="./logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <label for="showLogin" class="switch-link">Đăng nhập</label>
            <?php endif; ?>
        </div>
    </header>

    <!-- Overlay tìm kiếm -->
    <div id="searchOverlay" class="search-overlay" aria-hidden="true">
        <div class="search-box">
            <input type="text" placeholder="Tìm kiếm bài viết..." id="searchInput" />
            <button id="searchSubmit" class="btn">Tìm</button>
            <button id="closeSearch" class="btn-close" aria-label="Đóng">✕</button>
        </div>
    </div>


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
    <script src="../js/index.js" defer></script>
</body>

</html>