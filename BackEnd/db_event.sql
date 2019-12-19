-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 10, 2019 lúc 05:14 AM
-- Phiên bản máy phục vụ: 10.1.28-MariaDB
-- Phiên bản PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_event`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `contact` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '1: User thường - 2: Reviewer - 3: Moderator - 4: Admin',
  `avatar` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`id`, `name`, `username`, `email`, `faculty_id`, `contact`, `role`, `avatar`) VALUES
(1, 'Ngộ Không', 'tonngokhong', 'ngokhong@gmail.com', 1, '0909123456', '3', ''),
(2, 'Đường Tăng', 'duongtang', 'tamtang@gmail.com', 1, '0909456123', '3', ''),
(3, 'Người kiểm duyệt 1', 'reviewer1', 'reviewer1@gmail.com', 1, '0909999888', '2', ''),
(4, 'Người kiểm duyệt 2', 'reviewer2', 'reviewer2@gmail.com', 2, '0909112233', '2', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attendee`
--

CREATE TABLE `attendee` (
  `id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `event_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `attendee`
--

INSERT INTO `attendee` (`id`, `email`, `event_id`, `status`) VALUES
(1, 'email1@gmail.com', 3, 0),
(2, 'email2@gmail.com', 3, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Học Thuật'),
(2, 'Văn Hóa'),
(3, 'Thể thao');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `place` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ticket_number` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `expired_date` datetime NOT NULL,
  `short_desc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `event`
--

INSERT INTO `event` (`id`, `category_id`, `title`, `place`, `avatar`, `ticket_number`, `start_date`, `end_date`, `expired_date`, `short_desc`, `description`, `faculty_id`, `status`) VALUES
(1, 1, 'TalkShow AI', 'Hội trường Trịnh Công Sơn', 'http://channel.mediacdn.vn/2019/10/30/photo-1-15724079189741018495520.jpg', 200, '2019-12-12 07:00:00', '2019-12-12 12:00:00', '2019-12-16 00:00:00', 'Thảo luận về vấn đề việc làm thời nay', '<ol><li>AI là cái quái gì</li><li>Tình hình AI hiện nay</li></ol><p>Xem thêm <a href=\"http://vanlanguni.edu.vn\">tại</a></p>', 1, 2),
(2, 1, 'Hội thảo CNTT', 'Hội trường Trịnh Công Sơn', 'http://channel.mediacdn.vn/2019/10/30/photo-1-15724079189741018495520.jpg', 200, '2019-12-12 07:00:00', '2019-12-12 12:00:00', '2019-12-27 00:00:00', 'Thảo luận về CNTT', '<p>Mô tả chi tiết nè</p><p>Xem thêm <a href=\"http://vanlanguni.edu.vn\">tại</a></p>', 1, 0),
(3, 1, 'Hội Thảo Việc Làm 4.0', 'Hội trường Trịnh Công Sơn', 'http://channel.mediacdn.vn/2019/10/30/photo-1-15724079189741018495520.jpg', 200, '2019-12-12 07:00:00', '2019-12-12 12:00:00', '0000-00-00 00:00:00', 'Thảo luận về vấn đề việc làm thời nay', '<ol><li>Vấn đề 1</li><li>Vấn đề 2</li><li>Vấn đề 3</li><li>Hướng giải quyết</li></ol><p>Xem thêm <a href=\"http://vanlanguni.edu.vn\">tại</a></p>', 1, 4),
(6, 2, 'Giáng sinh Văn Lang', 'Hội trường Trịnh Công Sơn', 'images/upload/20191210083747Doraemon.png', 696, '2019-12-24 17:00:00', '2019-12-24 17:00:00', '0000-00-00 00:00:00', 'Đón giáng sinh cùng Văn Lang', '<ol><li>đi thăm ông già Noel</li><li>đi thăm bà gìa Noel</li><li>Gặp Doraemon</li></ol><p>Chi tiết xem <a href=\"http://vanlanguni.edu.vn\">tại</a></p>', 2, 0),
(7, 3, 'Xem đá bóng', '', 'images/upload/201912100849329 practice.jpg', 999, '2019-12-20 19:30:00', '2019-12-20 22:00:00', '0000-00-00 00:00:00', 'Xem đá bóng cùng VLU', '<ol><li>Xem hiệp 1</li><li>Xem hiệp 2</li><li>Đi bão</li></ol><p>Chi tiết <a href=\"http://vanlanguni.edu.vn\">tại</a></p>', 2, 1),
(8, 3, 'thêm dể xóa', 'tcs', 'images/palacebg.jpg', 123, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '123', '<p>chi tiết nè</p><p><a href=\"hehe\">hehe</a></p>', 2, 0),
(10, 1, 'Mới thêm cuối cùng', '', 'images/upload/20191210110006scale.png', 123, '2019-12-10 10:00:00', '2019-12-10 18:00:00', '0000-00-00 00:00:00', 'thêm thử', '<p>Thêm thử chơi thôi <i>mà</i></p><ol><li>một</li><li>hai</li><li>ba</li><li>bốn</li><li>năm</li><li>sáu</li></ol>', 1, 0),
(11, 1, 'Mới thêm cuối cùng', '', 'images/upload/20191210110006scale.png', 123, '2019-12-10 10:00:00', '2019-12-10 18:00:00', '0000-00-00 00:00:00', 'thêm thử', '<p>Thêm thử chơi thôi <i>mà</i></p><ol><li>một</li><li>hai</li><li>ba</li><li>bốn</li><li>năm</li><li>sáu</li></ol>', 1, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `name`, `status`) VALUES
(1, 'Công Nghệ Thông Tin', 1),
(2, 'Khác', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `moderator`
--

CREATE TABLE `moderator` (
  `account_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `moderator`
--

INSERT INTO `moderator` (`account_id`, `event_id`, `email`, `status`) VALUES
(1, 3, '', 0),
(2, 2, '', 0),
(2, 1, '', 0),
(2, 6, '', 0),
(1, 8, '', 0),
(1, 7, '', 0),
(1, 10, '', 0),
(1, 11, '', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviewer`
--

CREATE TABLE `reviewer` (
  `event_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `review_comment`
--

CREATE TABLE `review_comment` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `day_comment` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `review_comment`
--

INSERT INTO `review_comment` (`id`, `event_id`, `account_id`, `comment`, `day_comment`) VALUES
(1, 1, 3, 'nội dung k phù hợp', '2019-12-10 09:10:18'),
(2, 1, 4, 'không thích duyệt', '2019-12-10 10:07:09');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Chỉ mục cho bảng `attendee`
--
ALTER TABLE `attendee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`,`faculty_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Chỉ mục cho bảng `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Chỉ mục cho bảng `review_comment`
--
ALTER TABLE `review_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`,`account_id`),
  ADD KEY `account_id` (`account_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `attendee`
--
ALTER TABLE `attendee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `review_comment`
--
ALTER TABLE `review_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`);

--
-- Các ràng buộc cho bảng `attendee`
--
ALTER TABLE `attendee`
  ADD CONSTRAINT `attendee_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`);

--
-- Các ràng buộc cho bảng `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `event_ibfk_4` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`);

--
-- Các ràng buộc cho bảng `review_comment`
--
ALTER TABLE `review_comment`
  ADD CONSTRAINT `review_comment_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
