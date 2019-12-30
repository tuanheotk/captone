-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 28, 2019 lúc 02:10 AM
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
  `code` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `faculty_id` int(11) NOT NULL DEFAULT '0',
  `contact` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1: User thường - 2: Reviewer - 3: Moderator - 4: Admin',
  `avatar` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0: diasable - 1: enable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`id`, `code`, `name`, `email`, `password`, `faculty_id`, `contact`, `role`, `avatar`, `status`) VALUES
(1, '', 'Ngộ Không', 'ngokhong@gmail.com', '', 2, '0909123456', '1', '', 1),
(2, '', 'Đường Tăng', 'tamtang@gmail.com', '', 5, '0909456123', '1', '', 1),
(3, '', 'Người Kiểm Duyệt 1', 'reviewer1@gmail.com', '', 1, '0909999888', '2', '', 1),
(4, '', 'Người Kiểm Duyệt 2', 'reviewer2@gmail.com', '', 1, '0909112233', '2', '', 1),
(10, 't160614', 'Tuấn Heo', 't160614@vanlanguni.vn', NULL, 1, '', '4', '', 1),
(11, 't160913', 'Trần Thịnh', 't160913@vanlanguni.vn', NULL, 1, '', '2', '', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attendee`
--

CREATE TABLE `attendee` (
  `id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `event_id` int(11) NOT NULL,
  `ticket_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `attendee`
--

INSERT INTO `attendee` (`id`, `email`, `event_id`, `ticket_code`, `status`) VALUES
(3, 't160913@vanlanguni.vn', 26, 'cd5sd64f7c654df5c24', 0),
(4, 'ngokhong@gmail.com', 26, 'sd5fc45ds6f5ds4fs55', 0),
(5, 'tamtang@gmail.com', 26, 'sdf65sd4c6s5df46ds5f', 0),
(6, 'reviewer@gmail.com', 26, 'df654sc654d65dfgf', 0);

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
  `account_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `place` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ticket_number` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `expired_date` datetime NOT NULL,
  `short_desc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `user_make_question` int(11) NOT NULL DEFAULT '0',
  `user_reply_question` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `event`
--

INSERT INTO `event` (`id`, `account_id`, `category_id`, `title`, `code`, `place`, `avatar`, `ticket_number`, `start_date`, `end_date`, `expired_date`, `short_desc`, `description`, `faculty_id`, `user_make_question`, `user_reply_question`, `status`) VALUES
(26, 10, 3, 'Hội thảo công nghệ 4.1', '8IZA', 'hoi trường tcs', 'images/upload/20191227153856ck.jpg', 10, '2019-12-27 18:30:00', '2019-12-27 15:55:00', '0000-00-00 00:00:00', 'mô tả ngắn sự kiện', '<p>chi tiết sự kiện</p>', 1, 0, 0, 3),
(27, 10, 1, 'Sự kiện thêm để test email sửa 8 9 10 11 12 13', '3QFS', 'hoi truong tcs', 'images/upload/20191227162452ck.jpg', 1, '2019-12-27 16:20:00', '2019-12-27 16:55:00', '0000-00-00 00:00:00', 'mo ta ngan su kien', '<p>mo ta chi tiet</p>', 1, 0, 1, 1),
(28, 11, 1, 'Sự kiện thêm để test email', 'PNAE', 'hoi truong tcs', 'images/upload/20191227162552ck.jpg', 1, '2019-12-27 16:20:00', '2019-12-27 16:55:00', '0000-00-00 00:00:00', 'mo ta ngan su kien', '<p>mo ta chi tiet</p>', 1, 1, 0, 0),
(29, 11, 1, 'Sự kiện thêm để test email', 'BTSS', 'hoi truong tcs', 'images/upload/20191227162636ck.jpg', 1, '2019-12-27 16:20:00', '2019-12-27 16:55:00', '0000-00-00 00:00:00', 'mo ta ngan su kien', '<p>mo ta chi tiet</p>', 1, 0, 0, 0),
(30, 10, 1, '1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17', 'NIL3', 'hoi truong tcs', 'images/upload/20191227163919ck.jpg', 20, '2019-12-28 07:00:00', '2019-12-28 10:30:00', '0000-00-00 00:00:00', 'mo ta ngan du 10 ky tu', '<p>chi tiet su kien</p>', 2, 1, 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `name`, `status`) VALUES
(0, 'Chưa có', 0),
(1, 'Công Nghệ Thông Tin', 1),
(2, 'Kĩ Thuật Ô Tô', 1),
(3, 'Công Nghệ Sinh Học', 1),
(4, 'Ngoại Ngữ', 1),
(5, 'Kiến Trúc', 1),
(6, 'Xây Dựng', 1),
(7, 'Cựu Sinh Viên, Doanh Nghiệp', 1);

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
(10, 26, '', 0),
(0, 29, 't160913@vanlanguni.vn', 0),
(0, 30, 't160614@vanlanguni.vn', 0);

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
(2, 1, 4, 'không thích duyệt', '2019-12-10 10:07:09'),
(3, 1, 1, '', '2019-12-17 09:03:55'),
(4, 3, 1, '', '2019-12-17 10:47:43');

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
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `account_id` (`account_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `attendee`
--
ALTER TABLE `attendee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `review_comment`
--
ALTER TABLE `review_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `event_ibfk_4` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`),
  ADD CONSTRAINT `event_ibfk_5` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`);

--
-- Các ràng buộc cho bảng `review_comment`
--
ALTER TABLE `review_comment`
  ADD CONSTRAINT `review_comment_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
