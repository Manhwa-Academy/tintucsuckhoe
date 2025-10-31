-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 31, 2025 lúc 03:51 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `suckhoenews`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `baiviet`
--

CREATE TABLE `baiviet` (
  `ma_bai_viet` int(11) NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `duong_dan` varchar(255) NOT NULL,
  `noi_dung` text DEFAULT NULL,
  `anh_dai_dien` varchar(255) DEFAULT NULL,
  `ma_tac_gia` int(11) DEFAULT NULL,
  `ma_chuyen_muc` int(11) DEFAULT NULL,
  `ngay_dang` datetime DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime DEFAULT NULL,
  `trang_thai` enum('nhap','da_dang','luu_tru') DEFAULT 'nhap',
  `luot_xem` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `baiviet`
--

INSERT INTO `baiviet` (`ma_bai_viet`, `tieu_de`, `duong_dan`, `noi_dung`, `anh_dai_dien`, `ma_tac_gia`, `ma_chuyen_muc`, `ngay_dang`, `ngay_cap_nhat`, `trang_thai`, `luot_xem`) VALUES
(1, 'Top 7 thực phẩm tốt cho mắt', 'top-7-thuc-pham-cho-mat', 'Nội dung demo', '/anh/dinhduong1.jpg', 4, 1, '2025-08-01 00:00:00', NULL, 'da_dang', 120),
(2, 'Ăn nhẹ lành mạnh khi chơi game', 'an-nhe-lanh-manh', 'Nội dung demo', '/anh/dinhduong2.jpg', 4, 1, '2025-08-02 00:00:00', NULL, 'da_dang', 80),
(3, 'Vitamin cần thiết cho mắt', 'vitamin-can-thiet', 'Nội dung demo', '/anh/dinhduong3.jpg', 4, 1, '2025-08-03 00:00:00', NULL, 'da_dang', 60),
(4, 'Thực phẩm nên tránh khi mỏi mắt', 'thuc-pham-nen-tranh', 'Nội dung demo', '/anh/dinhduong4.jpg', 4, 1, '2025-08-04 00:00:00', NULL, 'da_dang', 40),
(5, 'Uống nước đúng cách', 'uong-nuoc-dung-cach', 'Nội dung demo', '/anh/dinhduong5.jpg', 4, 1, '2025-08-05 00:00:00', NULL, 'da_dang', 35),
(6, 'Thực đơn ngày thi', 'thuc-don-ngay-thi', 'Nội dung demo', '/anh/dinhduong6.jpg', 4, 1, '2025-08-06 00:00:00', NULL, 'da_dang', 25),
(7, '5 bài tập giãn cơ sau khi chơi game', '5-bai-tap-gian-co', 'Nội dung demo', '/anh/tap1.jpg', 5, 2, '2025-08-01 00:00:00', NULL, 'da_dang', 200),
(8, 'Tư thế ngồi đúng chống đau lưng', 'tu-the-ngoi-dung', 'Nội dung demo', '/anh/tap2.jpg', 5, 2, '2025-08-02 00:00:00', NULL, 'da_dang', 180),
(9, 'Chuỗi bài tập 10 phút', 'chuoi-bai-tap-10p', 'Nội dung demo', '/anh/tap3.jpg', 5, 2, '2025-08-03 00:00:00', NULL, 'da_dang', 150),
(10, 'Bài tập cổ vai gáy', 'bai-tap-co-vai', 'Nội dung demo', '/anh/tap4.jpg', 5, 2, '2025-08-04 00:00:00', NULL, 'da_dang', 100),
(11, 'Tập thở giảm stress', 'tap-tho-giam-stress', 'Nội dung demo', '/anh/tap5.jpg', 5, 2, '2025-08-05 00:00:00', NULL, 'da_dang', 90),
(12, 'Lịch luyện 4 tuần cải thiện tư thế', 'lich-luyen-4-tuan', 'Nội dung demo', '/anh/tap6.jpg', 5, 2, '2025-08-06 00:00:00', NULL, 'da_dang', 70),
(13, 'Kỹ thuật nghỉ 5 phút mỗi giờ', 'ky-thuat-nghi-5p', 'Nội dung demo', '/anh/nghi1.jpg', 6, 3, '2025-08-01 00:00:00', NULL, 'da_dang', 140),
(14, 'Cải thiện giấc ngủ cho game thủ', 'cai-thien-giac-ngu', 'Nội dung demo', '/anh/nghi2.jpg', 6, 3, '2025-08-02 00:00:00', NULL, 'da_dang', 120),
(15, 'Ánh sáng phòng khi giải trí', 'anh-sang-phong', 'Nội dung demo', '/anh/nghi3.jpg', 6, 3, '2025-08-03 00:00:00', NULL, 'da_dang', 90),
(16, 'Thói quen trước khi ngủ', 'thoi-quen-truoc-ngu', 'Nội dung demo', '/anh/nghi4.jpg', 6, 3, '2025-08-04 00:00:00', NULL, 'da_dang', 70),
(17, 'Thử thách 7 ngày không thiết bị', 'thu-thach-7-ngay', 'Nội dung demo', '/anh/nghi5.jpg', 6, 3, '2025-08-05 00:00:00', NULL, 'da_dang', 55),
(18, 'Không gian ngủ lý tưởng', 'khong-gian-ngu', 'Nội dung demo', '/anh/nghi6.jpg', 6, 3, '2025-08-06 00:00:00', NULL, 'da_dang', 40),
(19, 'Quản lý stress hiệu quả', 'quan-ly-stress', 'Nội dung demo', '/anh/tinh1.jpg', 5, 4, '2025-08-01 00:00:00', NULL, 'da_dang', 60),
(20, 'Giữ cân bằng giải trí và học tập', 'giu-can-bang', 'Nội dung demo', '/anh/tinh2.jpg', 5, 4, '2025-08-02 00:00:00', NULL, 'da_dang', 50),
(21, 'Thiền 5 phút mỗi ngày', 'thien-5-phut', 'Nội dung demo', '/anh/tinh3.jpg', 5, 4, '2025-08-03 00:00:00', NULL, 'da_dang', 40),
(22, 'Dấu hiệu quá tải tinh thần', 'dau-hieu-qua-tai', 'Nội dung demo', '/anh/tinh4.jpg', 5, 4, '2025-08-04 00:00:00', NULL, 'da_dang', 35),
(23, 'Thói quen nhỏ – tác động lớn', 'thoi-quen-nho', 'Nội dung demo', '/anh/tinh5.jpg', 5, 4, '2025-08-05 00:00:00', NULL, 'da_dang', 30),
(24, 'Podcast chia sẻ chuyên gia', 'podcast-chuyen-gia', 'Nội dung demo', '/anh/tinh6.jpg', 5, 4, '2025-08-06 00:00:00', NULL, 'da_dang', 20),
(25, 'Thiết lập ánh sáng màn hình', 'thiet-lap-anh-sang', 'Nội dung demo', '/anh/meo1.jpg', 4, 5, '2025-08-01 00:00:00', NULL, 'da_dang', 160),
(26, 'Ghế ngồi phù hợp', 'ghe-ngoi-phu-hop', 'Nội dung demo', '/anh/meo2.jpg', 4, 5, '2025-08-02 00:00:00', NULL, 'da_dang', 140),
(27, 'Kính lọc ánh sáng xanh', 'kinh-loc-anh-sang', 'Nội dung demo', '/anh/meo3.jpg', 4, 5, '2025-08-03 00:00:00', NULL, 'da_dang', 110),
(28, 'Setup bàn làm việc', 'setup-ban-lam-viec', 'Nội dung demo', '/anh/meo4.jpg', 4, 5, '2025-08-04 00:00:00', NULL, 'da_dang', 90),
(29, 'Bảo vệ cổ tay khi gõ phím', 'bao-ve-co-tay', 'Nội dung demo', '/anh/meo5.jpg', 4, 5, '2025-08-05 00:00:00', NULL, 'da_dang', 70),
(30, 'Kiểm tra thị lực tại nhà', 'kiem-tra-thi-luc', 'Nội dung demo', '/anh/meo6.jpg', 4, 5, '2025-08-06 00:00:00', NULL, 'da_dang', 50);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bai_the`
--

CREATE TABLE `bai_the` (
  `ma_bai_viet` int(11) NOT NULL,
  `ma_the` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bai_the`
--

INSERT INTO `bai_the` (`ma_bai_viet`, `ma_the`) VALUES
(1, 1),
(1, 7),
(2, 4),
(2, 7),
(7, 2),
(7, 9),
(8, 2),
(8, 5),
(13, 1),
(13, 3),
(19, 3),
(19, 8),
(21, 1),
(21, 6),
(25, 1),
(25, 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binhluan`
--

CREATE TABLE `binhluan` (
  `ma_binh_luan` int(11) NOT NULL,
  `ma_bai_viet` int(11) NOT NULL,
  `ma_nguoi_dung` int(11) DEFAULT NULL,
  `noi_dung` text NOT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `trang_thai` enum('hien','an') DEFAULT 'hien'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `binhluan`
--

INSERT INTO `binhluan` (`ma_binh_luan`, `ma_bai_viet`, `ma_nguoi_dung`, `noi_dung`, `ngay_tao`, `trang_thai`) VALUES
(1, 1, 7, 'Bài viết rất hữu ích!', '2025-08-02 00:00:00', 'hien'),
(2, 1, 8, 'Mình sẽ thử ngay.', '2025-08-02 00:00:00', 'hien'),
(3, 7, 9, 'Bài tập dễ làm và hiệu quả.', '2025-08-03 00:00:00', 'hien'),
(4, 8, 10, 'Tư thế này rất cần thiết.', '2025-08-04 00:00:00', 'hien'),
(5, 13, 7, 'Mẹo nghỉ 5 phút rất hữu dụng.', '2025-08-05 00:00:00', 'hien'),
(6, 15, 8, 'Thử thách 7 ngày đáng thử.', '2025-08-06 00:00:00', 'hien'),
(7, 19, 9, 'Thiền giúp mình bình tĩnh hơn.', '2025-08-07 00:00:00', 'hien'),
(8, 21, 10, 'Ghế chơi game mình nên đổi mới.', '2025-08-08 00:00:00', 'hien'),
(9, 2, 7, 'Có nên ăn trước khi chơi game không?', '2025-08-09 00:00:00', 'hien'),
(10, 3, 8, 'Bữa ăn trước kỳ thi hợp lý.', '2025-08-10 00:00:00', 'hien'),
(11, 4, 9, 'Bài viết rất chi tiết.', '2025-08-11 00:00:00', 'hien'),
(12, 9, 7, 'Tập thở giảm stress rõ rệt.', '2025-08-12 00:00:00', 'hien'),
(13, 25, 8, 'Kính lọc hữu ích nhưng hơi đắt.', '2025-08-13 00:00:00', 'hien'),
(14, 12, 10, 'Giấc ngủ cải thiện sau khi thay đổi.', '2025-08-14 00:00:00', 'hien'),
(15, 6, 7, 'Uống đủ nước quan trọng thật.', '2025-08-15 00:00:00', 'hien');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chuyenmuc`
--

CREATE TABLE `chuyenmuc` (
  `ma_chuyen_muc` int(11) NOT NULL,
  `ten_chuyen_muc` varchar(100) NOT NULL,
  `mo_ta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chuyenmuc`
--

INSERT INTO `chuyenmuc` (`ma_chuyen_muc`, `ten_chuyen_muc`, `mo_ta`) VALUES
(1, 'Dinh dưỡng', 'Bài viết về chế độ ăn, thực phẩm tốt cho mắt và sức khỏe'),
(2, 'Tập luyện', 'Bài tập vận động, giãn cơ'),
(3, 'Nghỉ ngơi', 'Giấc ngủ và phục hồi năng lượng'),
(4, 'Sức khỏe tinh thần', 'Quản lý stress, cân bằng tâm lý'),
(5, 'Mẹo mắt - lưng', 'Bảo vệ mắt và cột sống cho người ngồi lâu');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dangky`
--

CREATE TABLE `dangky` (
  `id_tk` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_password` varchar(255) DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `id_kh` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dangky`
--

INSERT INTO `dangky` (`id_tk`, `username`, `password`, `confirm_password`, `ngay_tao`, `id_kh`) VALUES
(1, 'peak', 'takina412', NULL, '2025-10-30 13:44:31', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dangnhap`
--

CREATE TABLE `dangnhap` (
  `id_dn` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ngay_dn` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `id_kh` int(11) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sdt` varchar(20) DEFAULT NULL,
  `dia_chi` varchar(255) DEFAULT NULL,
  `gioi_tinh` enum('Nam','Nữ','Khác') DEFAULT 'Khác',
  `ngay_sinh` date DEFAULT NULL,
  `quoc_gia` varchar(50) DEFAULT 'Việt Nam',
  `tinh_thanh` varchar(50) DEFAULT NULL,
  `vai_tro` enum('Khach','NhanVien','QuanTri') DEFAULT 'Khach'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`id_kh`, `ho_ten`, `email`, `sdt`, `dia_chi`, `gioi_tinh`, `ngay_sinh`, `quoc_gia`, `tinh_thanh`, `vai_tro`) VALUES
(1, 'Hayase Yuuka', 'takina412a@gmail.com', NULL, NULL, 'Khác', NULL, 'Việt Nam', NULL, 'Khach'),
(2, 'Hayase Yuuka', 'vuliztva1@gmail.com', NULL, NULL, 'Khác', NULL, 'Việt Nam', NULL, 'Khach');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teptin`
--

CREATE TABLE `teptin` (
  `ma_tep` int(11) NOT NULL,
  `ma_bai_viet` int(11) DEFAULT NULL,
  `loai` enum('anh','video','infographic') DEFAULT 'anh',
  `duong_dan` varchar(255) DEFAULT NULL,
  `chu_thich` varchar(255) DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `teptin`
--

INSERT INTO `teptin` (`ma_tep`, `ma_bai_viet`, `loai`, `duong_dan`, `chu_thich`, `ngay_tao`) VALUES
(1, 7, 'video', '/media/videos/gian-co-1.mp4', 'Video bài tập giãn cơ', '2025-10-30 10:35:25'),
(2, 9, 'infographic', '/media/info/10p-chart.png', 'Infographic 10 phút', '2025-10-30 10:35:25'),
(3, 13, 'anh', '/media/images/5p-break.jpg', 'Ảnh minh họa nghỉ 5 phút', '2025-10-30 10:35:25'),
(4, 21, 'anh', '/media/images/chon-ghe.jpg', 'Ảnh hướng dẫn ghế', '2025-10-30 10:35:25'),
(5, 1, 'anh', '/media/images/mat-foods.jpg', 'Ảnh thực phẩm tốt cho mắt', '2025-10-30 10:35:25'),
(6, 2, 'anh', '/media/images/snack-healthy.jpg', 'Ảnh snack lành mạnh', '2025-10-30 10:35:25'),
(7, 12, 'video', '/media/videos/sleep-tips.mp4', 'Video mẹo ngủ ngon', '2025-10-30 10:35:25'),
(8, 25, 'anh', '/media/images/blue-light.jpg', 'Ảnh kính lọc ánh sáng xanh', '2025-10-30 10:35:25'),
(9, 5, 'infographic', '/media/info/avoid-foods.png', 'Infographic thực phẩm nên tránh', '2025-10-30 10:35:25'),
(10, 17, 'anh', '/media/images/breathing.jpg', 'Ảnh hướng dẫn thở', '2025-10-30 10:35:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `the`
--

CREATE TABLE `the` (
  `ma_the` int(11) NOT NULL,
  `ten_the` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `the`
--

INSERT INTO `the` (`ma_the`, `ten_the`) VALUES
(4, 'dinh dưỡng'),
(3, 'giấc ngủ'),
(2, 'giãn cơ'),
(10, 'infographic'),
(6, 'kính lọc'),
(1, 'mỏi mắt'),
(8, 'thở'),
(7, 'thực phẩm'),
(5, 'tư thế'),
(9, 'video');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `baiviet`
--
ALTER TABLE `baiviet`
  ADD PRIMARY KEY (`ma_bai_viet`),
  ADD UNIQUE KEY `duong_dan` (`duong_dan`),
  ADD KEY `ma_tac_gia` (`ma_tac_gia`),
  ADD KEY `ma_chuyen_muc` (`ma_chuyen_muc`);

--
-- Chỉ mục cho bảng `bai_the`
--
ALTER TABLE `bai_the`
  ADD PRIMARY KEY (`ma_bai_viet`,`ma_the`),
  ADD KEY `ma_the` (`ma_the`);

--
-- Chỉ mục cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`ma_binh_luan`),
  ADD KEY `ma_bai_viet` (`ma_bai_viet`),
  ADD KEY `ma_nguoi_dung` (`ma_nguoi_dung`);

--
-- Chỉ mục cho bảng `chuyenmuc`
--
ALTER TABLE `chuyenmuc`
  ADD PRIMARY KEY (`ma_chuyen_muc`),
  ADD UNIQUE KEY `ten_chuyen_muc` (`ten_chuyen_muc`);

--
-- Chỉ mục cho bảng `dangky`
--
ALTER TABLE `dangky`
  ADD PRIMARY KEY (`id_tk`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `dangnhap`
--
ALTER TABLE `dangnhap`
  ADD PRIMARY KEY (`id_dn`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`id_kh`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `teptin`
--
ALTER TABLE `teptin`
  ADD PRIMARY KEY (`ma_tep`),
  ADD KEY `ma_bai_viet` (`ma_bai_viet`);

--
-- Chỉ mục cho bảng `the`
--
ALTER TABLE `the`
  ADD PRIMARY KEY (`ma_the`),
  ADD UNIQUE KEY `ten_the` (`ten_the`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `baiviet`
--
ALTER TABLE `baiviet`
  MODIFY `ma_bai_viet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  MODIFY `ma_binh_luan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `chuyenmuc`
--
ALTER TABLE `chuyenmuc`
  MODIFY `ma_chuyen_muc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `dangky`
--
ALTER TABLE `dangky`
  MODIFY `id_tk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `dangnhap`
--
ALTER TABLE `dangnhap`
  MODIFY `id_dn` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `id_kh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `teptin`
--
ALTER TABLE `teptin`
  MODIFY `ma_tep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `the`
--
ALTER TABLE `the`
  MODIFY `ma_the` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `baiviet`
--
ALTER TABLE `baiviet`
  ADD CONSTRAINT `baiviet_ibfk_1` FOREIGN KEY (`ma_tac_gia`) REFERENCES `nguoidung` (`ma_nguoi_dung`) ON DELETE SET NULL,
  ADD CONSTRAINT `baiviet_ibfk_2` FOREIGN KEY (`ma_chuyen_muc`) REFERENCES `chuyenmuc` (`ma_chuyen_muc`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `bai_the`
--
ALTER TABLE `bai_the`
  ADD CONSTRAINT `bai_the_ibfk_1` FOREIGN KEY (`ma_bai_viet`) REFERENCES `baiviet` (`ma_bai_viet`) ON DELETE CASCADE,
  ADD CONSTRAINT `bai_the_ibfk_2` FOREIGN KEY (`ma_the`) REFERENCES `the` (`ma_the`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD CONSTRAINT `binhluan_ibfk_1` FOREIGN KEY (`ma_bai_viet`) REFERENCES `baiviet` (`ma_bai_viet`) ON DELETE CASCADE,
  ADD CONSTRAINT `binhluan_ibfk_2` FOREIGN KEY (`ma_nguoi_dung`) REFERENCES `nguoidung` (`ma_nguoi_dung`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `teptin`
--
ALTER TABLE `teptin`
  ADD CONSTRAINT `teptin_ibfk_1` FOREIGN KEY (`ma_bai_viet`) REFERENCES `baiviet` (`ma_bai_viet`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
