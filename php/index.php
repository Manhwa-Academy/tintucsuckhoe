<?php
require_once './db.php'; // file bạn đã có

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
    <script src="../js/fireworks.js" async defer></script>
    <script src="../js/index.js" defer></script>
</head>

<body>
    <canvas class="fireworks"></canvas>
    <header>
        <div class="logo">
            <h1><a href="index.php">🩺 Sức Khỏe News</a></h1>
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