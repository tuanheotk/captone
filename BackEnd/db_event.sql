-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2020 at 05:07 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_event`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `code` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `faculty_id` int(11) NOT NULL DEFAULT '-1',
  `contact` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1: User thường - 2: Reviewer - 3: Moderator - 4: Admin',
  `avatar` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `verify_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `verified` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0: diasable - 1: enable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `code`, `name`, `email`, `password`, `faculty_id`, `contact`, `role`, `avatar`, `verify_code`, `verified`, `status`) VALUES
(1, '', 'Hữu Kha nè', 'ngokhong@gmail.com', '123456', -1, '0909123456', '2', '', '', 1, 1),
(2, '', 'Đường Tăng', 'tamtang@gmail.com', '123456', 5, '0909456123', '2', '', '456sd4fs45c5s64dfsf', 1, 1),
(3, '', 'Người Kiểm Duyệt 1', 'reviewer1@gmail.com', '', 1, '0909999888', '2', '', '', 0, 1),
(4, '', 'Người Kiểm Duyệt 2', 'reviewer2@gmail.com', '', 1, '0909112233', '2', '', '', 0, 1),
(10, 't160614', 'Bùi Trung Tuấn', 't160614@vanlanguni.vn', NULL, 1, '', '4', '', '', 0, 1),
(11, 't160913', 'Trần Thịnh', 't160913@vanlanguni.vn', NULL, 1, '', '2', '', '', 0, 1),
(12, '', 'Tuấn HEO TK', 'tuanheotk3@gmail.com', '123456', 1, '', '1', '', '1ce119a526d80d89763a82496ebb2cb9', 1, 1),
(13, '', 'Thịnh Mập', 'tthinhtt@gmail.com', 'ConDiChoThinh', 1, '', '2', '', 'da221142a75544172c91fb86e5105b69', 0, 1),
(18, 't163152', 'Phan Anh Tú', 't163152@vanlanguni.vn', NULL, 1, '', '1', '', '', 0, 1),
(21, 't161552', 'Quan Truong', 't161552@vanlanguni.vn', NULL, 3, '', '1', '', '', 0, 1),
(26, '', 'Tài khoản mới', 'anhtu@gmail.com', '123456', 7, '', '1', '', '6405e6ebf3944dddfb93c3a03c6f90d7', 1, 1),
(27, '', 'Họ và Tên', 'sdi10141@zzrgg.com', '123123', 7, '', '1', '', '998144733de6ea7f1e16a502d7a8696f', 1, 1),
(28, '', 'tuanheo', 'tuanheotk2@gmail.com', 'tuanheo2', -1, '', '1', '', 'b1bf4c56d5a11a23f8fc916b56f57a49', 0, 1),
(29, '', 'tuanheo', 'tuanheotk@gmail.com', 'tuanheo2', -1, '', '1', '', 'b90d107f65c759bd867e8319ab4869fe', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `event_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `user_fullname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`event_id`, `question_id`, `user_id`, `user_fullname`, `content`, `create_at`) VALUES
(31, 67, '10', 'Bùi Trung Tuấn', 'Đi về hướng Bắc', '2020-03-28 21:37:21'),
(31, 67, '10', 'Bùi Trung Tuấn', 'đi thẳng tới đèn đỏ rồi rẻ trái', '2020-03-31 12:50:19'),
(31, 67, '10', 'Bùi Trung Tuấn', 'đi thẳng rồi hỏi đường tiếp', '2020-03-31 13:48:11'),
(31, 67, 'guest_91019', 'Người Lạ 91019', 'Tui k chỉ đâu', '2020-03-31 13:49:12');

-- --------------------------------------------------------

--
-- Table structure for table `attendee`
--

CREATE TABLE `attendee` (
  `id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `event_id` int(11) NOT NULL,
  `ticket_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `attendee`
--

INSERT INTO `attendee` (`id`, `email`, `event_id`, `ticket_code`, `status`) VALUES
(1, 't160913@vanlanguni.vn', 31, 'sdifujsdfs56f4w6q8x3cs654df', 0),
(2, 't160913@vanlanguni.vn', 33, '6s5456dc13a2s1a65c46a5a6', 1),
(3, 't163152@vanlanguni.vn', 33, '1', 1),
(4, 'sdi10141@zzrgg.com', 33, 'cf051be51ef724c6bfca1bed2a42ef53', 0),
(10, 't161552@vanlanguni.vn', 31, '5f72a6b973d96db3f31d66a25e50fc25', 0),
(11, 't160614@vanlanguni.vn', 31, 'b02d7b7af87f77f98c7c771dca82ba16', 0),
(12, 't160614@vanlanguni.vn', 37, '7ddbf705821244ae4a9b2bc24e111e43', 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Học Thuật'),
(2, 'Văn Hóa'),
(3, 'Thể thao');

-- --------------------------------------------------------

--
-- Table structure for table `event`
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
  `check_question` int(11) NOT NULL DEFAULT '1',
  `last_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `public_at` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `account_id`, `category_id`, `title`, `code`, `place`, `avatar`, `ticket_number`, `start_date`, `end_date`, `expired_date`, `short_desc`, `description`, `faculty_id`, `user_make_question`, `user_reply_question`, `check_question`, `last_modified`, `public_at`, `status`) VALUES
(31, 10, 1, 'Hơn 30 nhà văn, nhà thơ, nhà báo \"gạo cội\" giao lưu cùng sinh viên ngành Văn học Ứng dụng ', 'CG54', 'Hội trường Trịnh Công Sơn', 'images/upload/20191231125619vlu-giao-luu-van-hoc-1.jpg', 100, '2020-01-02 13:50:00', '2020-01-02 17:00:00', '0000-00-00 00:00:00', 'Khoa Xã hội  Nhân văn Trường Đại học Văn Lang tổ chức Giao lưu Văn học tại phòng Khánh tiết Cơ sơ ', '<p>Buổi giao lưu nhận được sự quan tâm của các cấp lãnh đạo Trường Đại học Văn Lang. Ông Bùi Quang Độ – Chủ tịch Hội đồng Quản trị, TS. Nguyễn Đắc Tâm – Phó Chủ tịch Hội đồng Quản trị, Nhà báo Dương Trọng Dật - Giám đốc Viện Đào tạo Văn hóa – Nghệ thuật &amp; Truyền thông (nguyên là Tổng biên tập Tòa soạn Báo Sài Gòn Giải phóng), PGS. TS. Đặng Ngọc Lệ - Trưởng Khoa Xã hội và Nhân văn, TS. Hồ Quốc Hùng – Phó trưởng Khoa Xã hội và Nhân văn (Trưởng bộ môn Văn học Ứng dụng) Trường Đại học Văn Lang đã tham dự sự kiện và dẫn dắt sinh viên Văn học ứng dụng giao lưu cùng các tiền bối trong nghề.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/vlu-Tue_Khanh/thang_9-2019/bai_5-_Giao_l%C6%B0u_v%C4%83n_h%E1%BB%8Dc/vlu-giao-luu-van-hoc-1.jpg\" alt=\"vlu giao luu van hoc 1\"></figure><p>Mở đầu buổi gặp gỡ, ông Bùi Quang Độ - Chủ tịch Hội đồng Quản trị Trường Đại học Văn Lang xúc động chia sẻ: <i>“Chúng ta có mặt tại đây ngày hôm nay như một minh chứng cho các giá trị nhân văn cốt lõi trong mỗi cá nhân vẫn còn tồn tại trong xã hội hiện đại. Cần khẳng định rằng Văn học là nhân học, con người không chú trọng đến nhân học thì không thể phát triển một cách toàn diện. Vì vậy, Trường Đại học Văn Lang đã và đang chú trọng xây dựng ngành Văn học Ứng dụng với mục tiêu phát triển các giá trị nhân văn cốt lõi cho thế hệ trẻ.\"</i></p><p>Khách mời tham dự giao lưu đều là những nhà văn, nhà thơ, nhà báo và nhà giáo đã trải qua những năm tháng đấu tranh của đất nước trong thời kỳ chống Mỹ, có những đóng góp nhất định cho sự phát triển của Văn học Việt Nam trong thời kỳ khó khăn đó.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/vlu-Tue_Khanh/thang_9-2019/bai_5-_Giao_l%C6%B0u_v%C4%83n_h%E1%BB%8Dc/vlu-giao-luu-van-hoc-2.jpg\" alt=\"vlu giao luu van hoc 2\"></figure><p>TS.Hồ Quốc Hùng - Phó trưởng Khoa Xã hội và Nhân văn Trường Đại học Văn Lang khẳng định: <i>“Thế hệ của chúng tôi, dù riêng biệt nhưng có những suy nghĩ như nhau và đều có khát vọng của tuổi trẻ giống nhau. Dù đã ở độ tuổi 70 nhưng chúng tôi vẫn mang trong mình tinh thần nhiệt huyết rực rỡ đối với văn chương và mong rằng những thế hệ sinh viên giờ đây có thể cảm nhận được sức nóng của ngọn lửa, để nối tiếp đam mê đó.”</i></p><p>Qua những chia sẻ truyền lửa đam mê của thế hệ tiền bối, sinh viên ngành Văn học Ứng dụng Trường Đại học Văn Lang bắt đầu nêu những khó khăn và trăn trở về cách học, cách đọc hay con đường sau khi ra trường,... nhiều câu hỏi hay và thú vị. Từng thắc mắc đều được các khách mời tham dự buổi giao lưu lắng nghe và giải đáp cụ thể, để mỗi sinh viên có thể rút ra cho mình những lời khuyên bổ ích và định hướng bản thân trong tương lai.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/vlu-Tue_Khanh/thang_9-2019/bai_5-_Giao_l%C6%B0u_v%C4%83n_h%E1%BB%8Dc/vlu-giao-luu-van-hoc-7.jpg\" alt=\"vlu giao luu van hoc 7\"></figure><p>Đại tá Công an Trần Thanh Xuân chia sẻ chân thành trước trăn trở của sinh viên về việc học gì và ra trường sẽ làm gì. Ông nói: “<i>Học Xã hội chính là học làm văn, học cách sử dụng ngôn ngữ. Chúng ta phải học rất nhiều, phải biết rất nhiều, mọi công việc đều cần đến kiến thức Văn học. Khi các em đã làm chủ được kiến thức và cách thức sử dụng Văn chương thành thục, em có thể làm được nhiều công việc mình mong muốn trong tương lai.</i>”</p><p>Đại tá Nguyễn Thị Hồng - nguyên Trưởng ban Công tác nữ Quân đội Nhân dân Việt Nam&nbsp;(thứ 2 từ trái sang) cũng chia sẻ: <i>“Chúng tôi sinh ra trong thời đánh Mỹ, mang trong mình khát vọng của tuổi trẻ và văn chương. Chúng tôi vừa ra trường đã dấn thân ngay vào vòng xoay của xã hội đương thời, của chiến tranh, cũng vì vậy mà trau dồi thêm nhiều kiến thức thực tiễn và mài dũa kinh nghiệm trong chính cuộc chiến năm ấy. Vậy nên, các bạn hãy cứ học đi, hãy cứ theo đuổi đam mê và hãy sống đi, phần còn lại cứ để cuộc đời tạo nên thành công cho các bạn”.</i></p><p>Giảng viên Trường Đại học Ngân hàng - Cô Vũ Thị Hợp (ngoài cùng bên trái)&nbsp; tiếp lời: <i>“Các bạn là những người học văn, nên hãy yêu văn học, hãy yêu quý con người. Khi các bạn biết yêu và được yêu, đó cũng là một sự thành công của bản thân mình.”</i></p>', 4, 0, 0, 1, '2020-01-03 11:12:28', '0000-00-00 00:00:00', 4),
(32, 11, 1, 'Khoa Du lịch tham gia dự án Phát triển môn học trực tuyến do AUF tài trợ', '48E4', 'Hội trường Trịnh Công Sơn', 'images/upload/20191231125754van-lang-2015-du-an-MOOC-Tunisia.jpg', 150, '2020-01-04 01:30:00', '2020-01-03 10:05:00', '0000-00-00 00:00:00', 'Chương trình tập huấn về Phát triển các khóa học trực tuyến đại trà cho cộng đồng', '<p>Chương trình tập huấn về MOOC nằm trong khuôn khổ hợp tác giữa Hệ thống các môn học trực tuyến (FUN) thuộc Bộ Giáo dục và Đào tạo Pháp, Tổ chức các trường Đại học khối Pháp ngữ (AUF), và các trường Đại học thành viên, nhằm phát triển các khóa học trực tuyến đại trà cho cộng đồng. TS. Thomas Laigie và TS. Rémi Sharock từ France Tél é come là diễn giả của đợt tập huấn này.&nbsp;</p><p>Từ 21 dự án đăng ký, 6 dự án thuộc nhiều lĩnh vực giáo dục đã được lựa chọn: du lịch, công nghệ sinh học, ngôn ngữ học, văn hóa học...<i>, </i>gồm<i> môn học Phát triển bền vững</i> của nhóm giảng viên đến từ ĐH Kinshasa, Congo với sự tài trợ của UNESCO; <i>Đối thoại đa văn hóa </i>của ĐH Sagesse, Lebanon; <i>Hướng dẫn sử dụng Linux</i> của nhóm giảng viên ĐH hai nước Tunisia và Maroc; <i>Chuẩn bị thi DELF, DALF</i> của ĐH Jendouba, Tunisia; <i>Công nghệ sinh học </i>của Viện Công nghệ Campuchia và <i>Thiết kế sản phẩm du lịch văn hóa</i> của Trường ĐH Văn Lang, Việt Nam. Mục tiêu chương trình tập huấn nhằm giúp các nhóm hiểu rõ thế nào là một khóa học trực tuyến (MOOC) và làm thế nào để xây dựng một khóa học trực tuyến chất lượng cao: các thành tố của MOOC, các hoạt động có thể tổ chức trong MOOC; các kỹ thuật quay phim, thiết kế video cũng như làm thế nào để dựng MOOC hoàn chỉnh...</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>Video về phát triển khóa học trực tuyến trên website Hệ thống môn học trực tuyến (FUN) thuộc Bộ Giáo dục và Đào tạo Pháp</p><p>Đợt tập huấn tại Tunisia tập trung vào các kỹ năng cần thiết để có thể xây dựng môn học trực tuyến theo đúng quy định của Hệ thống các môn học trực tuyến (FUN) thuộc Bộ Giáo dục và Đào tạo Pháp. Đợt tập huấn tiếp theo dự kiến sẽ được tổ chức vào đầu năm 2016 với nội dung chính là cách thức hoạt động của hệ thống FUN, hướng dẫn cách quản lý, vận hành môn học trên hệ thống trực tuyến của FUN, đóng góp vào việc truyền tải kiến thức đến cộng đồng. Sau khóa học, 6 nhóm giảng viên tiếp tục hoàn chỉnh dự án của mình, dự kiến đến tháng 6/2016, các dự án đạt chuẩn sẽ được đưa vào hệ thống trực tuyến của FUN để sinh viên trên toàn thế giới có thể đăng ký tham gia môn học.</p><p>Để tham gia khóa tập huấn, các cá nhân hoặc nhóm giảng viên đang giảng dạy chính thức tại một trường thành viên AUF phải gửi hồ sơ ứng tuyển, mô tả môn học dự định xây dựng thành khóa học trực tuyến, với các điều kiện:<br>&nbsp; &nbsp;- Tổng thời lượng môn học không vượt quá 6 tuần<br>&nbsp; &nbsp;- Cho phép đăng ký học tự do và miễn phí qua Internet<br>&nbsp; &nbsp;- Dạy hoàn toàn bằng tiếng Pháp - Khuyến khích các chương trình có cấp giấy chứng nhận hoặc chứng chỉ qua bài thi cuối khóa tập trung<br>&nbsp; &nbsp;- Khuyến khích mọi hình thức liên kết với một hay nhiều trường đại học khác (bất cứ nước nào) hoặc với các doanh nghiệp trong việc tổ chức biên soạn giáo trình.<br>Khoa Du lịch, Trường ĐH Văn Lang đã có những bước chuẩn bị từ năm 2014, tham gia Lớp đào tạo chuyển giao công nghệ về thiết kế giáo trình trực tuyến của AUF tổ chức tại Tp. Hồ Chí Minh. Từ nhiều năm nay, khoa Du lịch Trường ĐH Văn Lang đã hợp tác với ĐH Perpignan (Pháp) giảng dạy chương trình Hai văn bằng Pháp - Việt ngành Quản trị Khách sạn và ngành Quản trị Dịch vụ Du lịch &amp; Lữ hành. Tham gia dự án MOOC là cơ hội để khoa Du lịch đưa môn học của mình đến với sinh viên sử dụng tiếng Pháp trên toàn thế giới, thể hiện sâu sắc hơn vai trò của Trường ĐH Văn Lang trong Tổ chức Đại học Pháp ngữ (AUF).</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/12/mooc-tunisia-auf/van-lang-2015-du-an-MOOC-Tunisia_AUF.jpg\" alt=\"van lang 2015 du an MOOC Tunisia AUF\"></figure><p>Thông tin về đợt tập huấn tại Tunisia trên website của Tổ chức các trường Đại học khối Pháp ngữ (AUF) (bấm vào hình để xem).</p>', 3, 0, 0, 1, '2020-01-03 11:12:28', '0000-00-00 00:00:00', 4),
(33, 2, 1, 'Khoa Mỹ thuật Công nghiệp: Sinh viên ngành Thiết kế Nội thất gặp gỡ nhà thiết kế David Trubridge', '4C4L', 'Hội trường Trịnh Công Sơn', 'images/upload/20191231125940talkshow-David-Trubridge-003.jpg', 130, '2020-01-15 10:15:00', '2020-01-15 13:10:00', '0000-00-00 00:00:00', 'nhà thiết kế David Trubridge - “phù thủy” của ngành Thiết kế Nội thất thế giới -', '<p>David Trubridge học kiến trúc sư hàng hải tại nước Anh trước khi bắt đầu công việc thiết kế. Tính độc đáo trong ý tưởng và chất liệu thể hiện đưa danh tiếng của ông vượt xa lãnh thổ châu Âu. Năm 2013, tuần báo L’Express bình chọn ông là một trong 15 nhà thiết kế đương đại quan trọng nhất của ngành nội thất thế giới. Trong buổi talkshow sáng 28/10/2015 tại Trường ĐH Văn Lang, ông đã chia sẻ với SV chuyên ngành Thiết kế Nội thất, khoa Mỹ thuật Công nghiệp, những kinh nghiệm trong sáng tạo nghề nghiệp.&nbsp;</p><p>Talkshow với nhà thiết kế David Trubridge là hoạt động mở, dành cho tất cả SV quan tâm đến lĩnh vực nội thất và xu hướng thiết kế bền vững. Gần 300 SV đã tham dự chương trình, chủ yếu là ngành Thiết kế Nội thất.</p><h4>“Thiết kế xanh”</h4><p>David Trubridge theo đuổi xu hướng thiết kế thân thiện với môi trường, không sử dụng vật liệu nhựa. Ông chỉ sử dụng vật liệu gỗ, đặc biệt là tre. Đây cũng là loại cây phổ biến ở Việt Nam, vì vậy, những kiến thức về tính chất và kỹ thuật làm việc với vật liệu được trình bày đều rất hữu ích và nhiều khả năng ứng dụng.</p><p>&nbsp; David Trubridge giải thích về sự lựa chọn chất liệu tre: “Tôi bỏ nhiều công sức để nghiên cứu làm sao cho ít ảnh hưởng đến môi trường nhất. Bị chặt đi, cây cối sẽ tái tạo lại, và chúng ta có thể tận dụng ở mức cao nhất: trong rừng tre, măng dùng để ăn, còn cây lớn dùng để làm ra sản phẩm. Khi sản phẩm gỗ không dùng được nữa, nó cũng phân hủy nhanh. Nhưng chỉ một mẩu nhựa cũng cần cả ngàn năm để phân hủy”. Ông giảm tối đa các chi tiết sử dụng kim loại và nhựa trong sản phẩm của mình, ngay cả vật liệu kết dính cũng sử dụng loại thân thiện với môi trường. Nhà thiết kế còn ngỏ lời với SV: \"Nếu bạn sáng chế ra loại bóng đèn dùng chất liệu thân thiện hơn, tôi sẵn sàng mua để đưa vào sản phẩm tạo dáng của mình, thay cho bóng đèn compact\".</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/12/david-trubridge/talkshow-David-Trubridge-004.jpg\" alt=\"talkshow David Trubridge 004\"></figure><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/12/david-trubridge/talkshow-David-Trubridge-005.jpg\" alt=\"talkshow David Trubridge 005\"></figure><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/12/david-trubridge/talkshow-David-Trubridge-006.jpg\" alt=\"talkshow David Trubridge 006\"></figure><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/12/david-trubridge/talkshow-David-Trubridge-007.jpg\" alt=\"talkshow David Trubridge 007\"></figure><p>Đây là hình ảnh minh họa một số mẫu đèn do David Trubridge thiết kế, nguồn: www.davidtrubridge.com</p><p>&nbsp; David Trubridge chứng minh rằng vẫn còn nhiều khả năng khai thác vật liệu tự nhiên trong thiết kế nội thất.&nbsp;Kể về thất bại của mình khi thử nghiệm chất liệu tre, ông nhắn nhủ SV: hãy thử nghiệm nhiều lần, rồi bạn sẽ tìm ra cách chế tác phù hợp, không có giới hạn nào trong việc sử dụng chất liệu thiên nhiên.&nbsp; Sau những giờ học cùng thầy cô trên giảng đường, cuộc trò chuyện với David Trubridge đã thuyết phục các bạn SV thêm một lần nữa, rằng xu hướng “thiết kế xanh” không chỉ hấp dẫn vì tính hiện đại và lợi ích lâu dài, mà còn có sự sang trọng và độc đáo từ bản thân chất liệu.</p><h4>“Hãy trung thực với con tim mình”</h4><p>Cuộc gặp gỡ giữa bậc thầy trong ngành thiết kế và các SV&nbsp;diễn ra trong hai tiếng đồng hồ ngắn ngủi. Ngoài kiến thức chuyên môn, giá trị vô hình của buổi nói chuyện còn đến từ niềm cảm hứng được lan truyền từ một nhà thiết kế lừng lẫy, với quan niệm nghề nghiệp hết sức bình dị nhưng dứt khoát.</p><p>Nổi tiếng thế giới với các mẫu đèn chiếu sáng, David gây ngạc nhiên khi bộc bạch: “Tôi không thiết kế đèn để đẩy lùi bóng tối, tôi thiết kế cảm xúc, thay đổi không gian sao cho ấm áp, hấp dẫn hơn”. Ông chia sẻ cách làm việc trân trọng giá trị tinh thần: lấy cảm hứng từ cây cối và trong những khu rừng, học hỏi những kết cấu tự nhiên, phác thảo ý tưởng bằng tay thay vì máy tính để cá nhân hóa từng thiết kế…</p><p>Khi được đặt câu hỏi cho David Trubridge, nhiều SV tập trung vào yếu tố tinh thần của công việc thiết kế: Làm sao để giữ được đam mê nếu thực tế nghề nghiệp không như ý? Có cách nào để gợi cảm hứng thiết kế không?... Trả lời các bạn, David Trubridge nhắc đi nhắc lại nhiều lần: “Trong đời sống đô thị ồn ào, phải lắng mình lại để nghe xem mình muốn gì, đừng bị ảnh hưởng từ những xô bồ xung quanh, hãy trung thực với con tim và giữ con đường của mình”.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/12/david-trubridge/talkshow-David-Trubridge-003.jpg\" alt=\"talkshow David Trubridge 003\"></figure><p>David Trubridge truyền cảm hứng cho SV qua những chia sẻ chân thành và phong cách thân thiện.</p><p>Cách làm của David Trubridge không dễ thực hiện, và ngay cả tâm lý của từng người khi nghĩ đến con đường “làm việc không phải để kiếm tiền, làm vì sở thích của chính tôi” không phải không có những e ngại hay nghi ngờ. Nhưng sự có mặt của ông đã tiếp thêm ít nhiều sức mạnh cho SV, như một hình ảnh sống động về thành công gắn liền với lòng kiên định, sự tự tin.</p>', 6, 0, 0, 1, '2020-01-03 11:12:28', '0000-00-00 00:00:00', 1),
(34, 21, 1, 'Sinh viên Kế toán chinh phục kỹ năng: BẢN LĨNH BÀN PHÍM', '27G4', 'Hội trường Trịnh Công Sơn', 'images/upload/20191231130124ktkt-ban-linh-ban-phim-002.jpg', 170, '2020-01-12 09:00:00', '2020-01-12 11:30:00', '0000-00-00 00:00:00', 'Năm nay, khoa Kế toán - Kiểm toán, Trường ĐH Văn Lang tổ chức cuộc thi \"Hành trình chinh phục kỹ năn', '<p>Không dùng phím tắt trên bàn phím, không nhớ các tổ hợp phím nóng, không biết cách dàn một trang MS-Word đúng quy chuẩn, không thuộc các hàm tính trên Excel,... tưởng chừng là chuyện \"vụn vặt\" với sinh viên, nhưng sẽ là những trở ngại&nbsp;hữu hình trong công việc sau này. Các bạn sử dụng máy tính rất thạo để lướt web, chơi game, tương tác trên các trang mạng xã hội, cập nhật những phần mềm, ứng dụng chuyên ngành; nhưng lại xem nhẹ việc rèn luyện kỹ năng sử dụng các ứng dụng tin học văn phòng, vì... ngày nào mình cũng \"thăm\" chúng mà! Nếu suy nghĩ vậy, bạn hãy tìm hiểu về cuộc thi \"Vô địch Tin học Văn phòng Thế giới\" (MOSWC) - sân chơi tầm cỡ quốc tế về kỹ năng công nghệ, tin học văn phòng được lần đầu tổ chức năm 2002 tại Mỹ. Chỉ với 3 nội dung MS - Word, Excel, Powerpoint nhưng độ phức tạp và lắt léo của đề thi mỗi năm luôn khiến thí sinh các quốc gia phải rèn luyện rất vất vả. Từ năm 2015, cuộc thi Tin học Văn phòng Thế giới tại Việt Nam chính thức được Bộ Giáo dục &amp; Đào tạo đồng tổ chức, với mục tiêu thúc đẩy phong trào rèn luyện và nâng cao kỹ năng tin học văn phòng trong học sinh, sinh viên, làm cơ sở xây dựng nguồn nhân lực chất lượng cao cho đất nước.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/13/ktkt-ban-linh-ban-phim/ITA_MOSWC_2015_Logo1.png\" alt=\"ITA MOSWC 2015 Logo1\"></figure><p>Poster MOSWC 2015</p><p>Hòa cùng mục tiêu trên, cuộc thi \"Hành trình chinh phục kỹ năng - lần 1\", chủ đề \"Bản lĩnh bàn phím\" do Câu lạc bộ A&amp;M, khoa Kế toán - Kiểm toán, Trường ĐH Văn Lang tổ chức là \"đòn bẩy\" nâng cao nhận thức và tạo điều kiện cho sinh viên tiếp cận các kỹ năng tin học văn phòng theo tiêu chuẩn quốc tế, nhằm nâng cao kết quả học tập và hiệu quả công việc sau này. Kỹ năng tin học văn phòng, xử lý về công nghệ thông tin rất quan trọng với sinh viên ra trường, tạo ưu thế thu hút các nhà tuyển dụng.&nbsp;&nbsp;</p><h4>Hành trình cuộc thi&nbsp;&nbsp;</h4><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/13/ktkt-ban-linh-ban-phim/ktkt-ban-linh-ban-phim-002.jpg\" alt=\"ktkt ban linh ban phim 002\"></figure><p>14/11/2015, tại các phòng máy, Cơ sở 2</p><h4>VÒNG 1: Thử sức&nbsp;&nbsp;&nbsp;</h4><ul><li>200 thí sinh đăng ký tham gia, đến từ 4 khóa Khoa Kế toán Kiểm toán và các khoa bạn thuộc khối ngành kinh tế (Thương mại, Tài chính - Ngân hàng).</li><li>Mục tiêu: chọn lọc những thí sinh có kỹ năng tin học đại cương tốt nhất.</li><li>Thi cá nhân trên máy tính, kiểm tra các kỹ năng: tốc độ gõ bàn phím, soạn văn bản MS-Word, xử lý bảng tính Excel theo yêu cầu</li></ul><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/13/ktkt-ban-linh-ban-phim/ktkt-ban-linh-ban-phim-003.jpg\" alt=\"ktkt ban linh ban phim 003\"></figure><p>14/11/2015, tại các phòng máy, Cơ sở 2</p><h4>&nbsp;VÒNG 2:&nbsp;Tranh tài&nbsp;&nbsp;</h4><ul><li>15 thí sinh có điểm số cao nhất từ vòng 1.</li><li>Mục tiêu: đánh giá kỹ năng vận dụng các phần mềm Microsoft... vào một dự án thực tế.</li><li>Thi theo nhóm, trong 10 ngày, các bạn cần đưa ra ý tưởng một dự án kinh doanh khởi nghiệp và thuyết trình trong ngày thi, vận dụng MS- Word, Excel, Powerpoint.</li></ul><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/13/ktkt-ban-linh-ban-phim/ktkt-ban-linh-ban-phim-004.jpg\" alt=\"ktkt ban linh ban phim 004\"></figure><p>8g00, 13/12/2015, tại P.C601, Cơ sở 2</p><p>VÒNG CHUNG KẾT&nbsp;&nbsp;</p><ul><li>8 thí sinh có điểm số cao nhất từ vòng 2.</li><li>Mục tiêu: kiểm tra toàn diện kiến thức về các ứng dụng tin học văn phòng; kỹ năng sử dụng phím tắt, phím nóng; xử lý tình huống thực tế.</li><li>Thi cá nhân qua 3 chặng đấu, bao gồm: trả lời trắc nghiệm, thi trên bàn phím, bốc thăm tình huống.</li></ul><p>Cuộc thi \"Hành trình chinh phục kỹ năng - Lần 1\" diễn ra trong suốt một tháng, mỗi vòng thi có hình thức riêng biệt nên cách thức tổ chức khác nhau. \"Bản lĩnh bàn phím\" là một chặng đua bền bỉ của các thí sinh, với sự theo sát xuyên suốt của Ban tổ chức. Chị Phạm Thị Mộng Tuyền - Trưởng Ban tổ chức, Chủ nhiệm Câu lạc bộ A&amp;M chia sẻ: năm đầu tiên tổ chức nên lo lắng, áp lực rất nhiều, từ đề thi, cách thi, chất lượng thí sinh đến những tình huống không lường trước được. Vòng 2 vừa thử thách sức bền, sáng tạo của thí sinh; vừa gây khó khăn cho Ban tổ chức khi đưa ra các tiêu chí chấm điểm thật công bằng, vì làm nhóm nhưng điểm cá nhân. Vòng chung kết lại là một bài toán khó, làm sao để buổi thi hấp dẫn, thu hút khán giả khi \"khoảng lặng\" của các chặng thi khá nhiều. Giải pháp Ban tổ chức tìm ra thật thú vị! &nbsp;&nbsp;</p>', 6, 0, 0, 1, '2020-01-03 11:12:28', '0000-00-00 00:00:00', 4),
(35, 18, 1, 'Tọa đàm “Hoa văn trang trí – bình phong Huế dưới góc nhìn đào tạo ứng dụng\": Nghiên cứu vốn cổ vì nh', '0NEZ', 'Hội trường Trịnh Công Sơn', 'images/upload/20191231130311toa-dam-binh-phong-hue-003.jpg', 200, '2020-01-21 14:00:00', '2020-01-21 18:00:00', '0000-00-00 00:00:00', 'Khoa Mỹ thuật Công nghiệp Trường ĐH Văn Lang phối hợp với Bảo tàng Mỹ thuật Tp.HCM, Hội Mỹ thuật Tp.', '<p>Tọa đàm tập hợp nhiều tên tuổi lớn trong giới sáng tác và phê bình nghệ thuật, trong đó có những người con của xứ Huế. Đồng hành và cùng chia sẻ quan tâm của các họa sỹ, các nhà lý luận phê bình, là những cơ quan bảo tồn di tích, bảo tàng, doanh nghiệp, khoa mỹ thuật của một số trường đại học bạn. Từ nghiên cứu vốn cổ dân tộc đến mỹ thuật ứng dụng.</p><p>Tháng 7/2015, thông qua hợp tác giữa Khoa Mỹ thuật Công nghiệp Trường ĐH Văn Lang và Viện Văn hóa Nghệ thuật Quốc gia Việt Nam - Phân viện Huế, sinh viên khóa 19 ngành Thiết kế Đồ họa đi nghiên cứu thực tế tại Huế. Mục tiêu đầu tiên của chuyến đi đã đạt được: SV được rèn luyện kỹ năng nghiên cứu, ghi chép tư liệu, hệ thống hóa thông tin, phân tích và định hướng dữ liệu hoa văn trang trí thành tài liệu ứng dụng thiết kế đồ họa. ThS. Nguyễn Đắc Thái – Phó Trưởng Khoa MTCN, khi giới thiệu chương trình đào tạo và các sản phẩm của SV, đã tổng kết: “Sau chuyến đi khoảng 1.000 km, chúng tôi thu được hơn 1.000 họa tiết và gần 100 sản phẩm ứng dụng. Cùng với đó là lượng kiến thức khá đồ sộ về lịch sử vùng đất kinh kỳ. SV được tiếp xúc, làm việc với những nhà nghiên cứu chuyên môn, những người có cùng đam mê về vẻ đẹp của hoa văn vốn cổ…”&nbsp;Những bài ghi chép hoa văn, chép lại họa tiết bình phong và những sản phẩm ứng dụng trang trí của SV sau đó đã được trưng bày tại Trường ĐH Văn Lang&nbsp;vào tháng 9/2015.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/13/toa-dam-binh-phong-hue/toa-dam-binh-phong-hue-001.jpg\" alt=\"toa dam binh phong hue 001\"></figure><p>Từ các sản phẩm đồ họa SV sưu tầm và khôi phục được sau chuyến đi nghiên cứu thực địa Huế, Khoa Mỹ thuật Công nghiệp tổ chức 1 đợt triển lãm tại Trường và 1 Tọa đàm khoa học kết hợp triển lãm.</p><p>&nbsp;</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/13/toa-dam-binh-phong-hue/toa-dam-binh-phong-hue-002.jpg\" alt=\"toa dam binh phong hue 002\"></figure><p>Ảnh: Một phòng trưng bày bài vẽ của SV tại Tọa đàm</p><p>Tọa đàm khoa học “Hoa văn trang trí và bình phong Huế dưới góc nhìn đào tạo ứng dụng” được tổ chức 3 tháng sau triển lãm SV, mở thêm một chiều kích nữa của câu chuyện: những hoa văn trang trí và bình phong đã được SV dày công chép lại thành tư liệu thiết kế đồ họa không chỉ là sản phẩm trang trí, mà còn là biểu hiện vật chất đang dần mai một của đời sống tinh thần người Huế, của đời sống xã hội Huế - một trong những vùng đất phong dật nhất về văn hóa nghệ thuật. Người họa sỹ đặt một hoa văn trang trí lên sản phẩm mỹ thuật cũng là một quá trình tìm hiểu về sức sống văn hóa của hoa văn ấy. Ở góc cạnh sâu thẳm này, SV cần đến sự hỗ trợ, tham vấn của các chuyên gia, những nhà văn hóa, nhà lý luận phê bình, để khai mở cội rễ văn hóa, quan niệm thẫm mỹ biểu hiện qua các họa tiết trang trí mỹ thuật. Các sản phẩm của SV được chọn lọc lại để mở một không gian trưng bày vừa vặn xung quanh Tọa đàm, còn ở khu vực trung tâm là nơi trao đổi về văn hóa, nghệ thuật trang trí, nghệ thuật bình phong Huế. Cũng có thể hiểu là sản phẩm mỹ thuật ứng dụng của SV xuất phát từ một trung tâm mãnh liệt và phong phú hơn rất nhiều, nơi những quan niệm văn hóa, nghệ thuật đang ẩn hiện trong đời sống.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/13/toa-dam-binh-phong-hue/toa-dam-binh-phong-hue-003.jpg\" alt=\"toa dam binh phong hue 003\"></figure><p>Các sản phẩm mỹ thuật ứng dụng hoa văn trang trí Huế được trưng bày tại không gian của buổi Tọa đàm</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/13/toa-dam-binh-phong-hue/toa-dam-binh-phong-hue-004.jpg\" alt=\"toa dam binh phong hue 003\"></figure><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/13/toa-dam-binh-phong-hue/toa-dam-binh-phong-hue-005.jpg\" alt=\"toa dam binh phong hue 003\"></figure><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/13/toa-dam-binh-phong-hue/toa-dam-binh-phong-hue-006.jpg\" alt=\"toa dam binh phong hue 003\"></figure><p>Từ hoa văn, bình phong Huế đến hoa văn đình chùa Nam bộ<br>TS. Mã Thanh&nbsp;Cao – nguyên Giám đốc Bảo tàng Mỹ thuật Tp.HCM, hiện tham gia giảng dạy tại khoa Mỹ thuật Công nghiệp trường ĐH Văn Lang, và ThS.HS. Phan Quân Dũng – Trưởng Khoa Mỹ thuật Công nghiệp Trường ĐH Văn Lang là “người dẫn chuyện” của Tọa đàm. Trong một không gian vừa đủ ấm cúng, các họa sỹ, nhà nghiên cứu, nhà hoạt động bảo tồn di tích, doanh nghiệp… đã cùng trao đổi các vấn đề về hoa văn và đặc biệt về bình phong Huế. Ngoài ra, nhiều bài tham luận khác đã gửi về Tọa đàm, khai thác nhiều hướng nghiên cứu di sản bình phong Huế và lịch sử văn hóa Huế.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/13/toa-dam-binh-phong-hue/toa-dam-binh-phong-hue-007.jpg\" alt=\"toa dam binh phong hue 007\"></figure><p>Gần 80 nhà nghiên cứu, họa sỹ, doanh nghiệp, giảng viên, cơ quan truyền thông và 81 SV Trường ĐH Văn Lang tham dự Tọa đàm. <i>Ảnh: TS. Mã Thanh Cao - Nguyên Giám đốc Bảo tàng Mỹ thuật Tp.HCM giới thiệu mục tiêu của Tọa đàm.</i></p><p>&nbsp;Bình phong là dấn ấn của văn hóa Huế, phổ biến từ nhiều dạng bình phong đến cổng ngõ, hàng rào, thành xây trong hầu hết kiến trúc phủ đệ của quý tộc, tư thất của quan lại, lẫn những nhà cửa của giới thượng lưu, và còn lan tỏa đến kiến trúc dân dã. TS. Nguyễn Hữu Thông (Nguyên Viện trưởng Phân viện Văn hóa Nghệ thuật Quốc gia Việt Nam tại Huế) cho rằng:&nbsp;<i>Trong mắt tôi, đó là một cách ứng phó theo dạng cách ly, vừa thể hiện sự “kín cổng cao tường” để bảo vệ nếp nhà, đẳng cấp và thân phận xã hội, đồng thời cũng là biện pháp giấu kín một thực tế thiếu đồng bộ trong cuộc sống thường nhật.&nbsp;</i>PGS.TS. Hoàng Dũng (Trường ĐH Sư phạm Tp.HCM) góp ý: có thể bình phong thể hiện sự ứng phó cách ly, nhưng nếu hiểu bình phong trong quan niệm của người Huế như một biểu hiện của giấc mơ hoạn lộ - một tâm thức trải rộng từ tầng lớp quý tộc đến bình dân – thì sẽ giải quyết được nhiều mặt của vấn đề hơn. Bài nghiên cứu “Bình phong trong chức năng hương hỏa của đại gia đình Huế” của TS. Trần Đình Hằng (Viện trưởng Phân viện Văn hóa Nghệ thuật Quốc gia Việt Nam tại Huế) lại đặt bình phong trong câu chuyện hương hỏa, và rộng hơn là câu chuyện văn hóa dòng tộc – một đặc trưng của đời sống xã hội Huế, để từ đó khảo sát bình phong trong kiến trúc nhà vườn truyền thống trên nhiều phương diện, từ kiến trúc mỹ thuật tới phong thủy, quan niệm nhân sinh.&nbsp;</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/9/13/toa-dam-binh-phong-hue/toa-dam-binh-phong-hue-008.png\" alt=\"toa dam binh phong hue 008\"></figure><p>Thầy trò ngành Thiết kế Đồ họa Trường ĐH Văn Lang tỉ mỉ nghiên cứu và lấp rập những hoa văn họa tiết cổ còn lưu lại trên đất kinh kỳ.</p>', 2, 0, 0, 1, '2020-01-03 11:12:28', '0000-00-00 00:00:00', 1),
(36, 21, 2, ' Trường Đại học Văn Lang ký kết hợp tác với VINTECH', 'YMYY', 'Hội trường Trịnh Công Sơn', 'images/upload/20191231130617DH-Van-Lang-KI-MOU-1.jpg', 200, '2020-01-16 02:05:00', '2020-01-16 06:00:00', '0000-00-00 00:00:00', 'PGS. TS. Trần Thị Mỹ Diệu – Hiệu trưởng Trường Đại học Văn Lang đã ký kết hợp tác với Công ty Cổ phầ', '<p>Nhận lời mời của Tập đoàn Vingroup, PGS.TS. Trần Thị Mỹ Diệu – Uỷ viên Hội đồng Quản trị, Hiệu trưởng Trường Đại học Văn Lang đã tham dự Lễ ra mắt Công ty Cổ phần Phát triển Công nghệ VINTECH, Viện nghiên cứu Dữ liệu lớn, Viện Nghiên cứu Công nghệ cao, Quỹ Hỗ trợ Nghiên cứu Khoa học và Công nghệ Ứng dụng. Trong khuôn khổ buổi Lễ, đại diện Trường Đại học Văn Lang đã ký kết biên bản hợp tác với Công ty Cổ phần Phát triển Công nghệ VINTECH.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/VLU_THI/2018/THANG_9/KY_MOU_2018/DH-Van-Lang-KI-MOU-1.jpg\" alt=\"DH Van Lang KI MOU 1\"></figure><p>PGS.TS. Trần Thị Mỹ Diệu – Hiệu trưởng Trường ĐH Văn Lang và ông Nguyễn Việt Quang, Phó Chủ tịch, kiêm Tổng Giám đốc Tập đoàn Vingroup trao đổi bản thỏa thuận hợp tác của hai đơn vị (Hà Nội, 21/8/2018).</p><p>&nbsp;<strong>Theo nội dung bản thỏa thuận, trong thời gian 3 năm, Văn Lang và VINTECH sẽ tiến hành hợp tác ở 4 lĩnh vực:</strong></p><p>&nbsp;(1) <strong>Tài trợ các dự án nghiên cứu khoa học - công nghệ</strong>: VINTECH sẽ thành lập Quỹ Hỗ trợ Nghiên cứu Khoa học – Công nghệ ứng dụng. Hằng năm, Quỹ tài trợ cho các dự án nghiên cứu khoa học – công nghệ trong lĩnh vực khoa học máy tính, trí tuệ nhân tạo, robotics, tự động hóa, công nghệ nano, năng lượng tái tạo, nguyên liệu thế hệ mới… và mua bản quyền các sáng chế có thể ứng dụng đưa vào sản xuất dựa trên đánh giá về mức độ phù hợp, hiệu quả và tính khả thi.</p><p>&nbsp;(2) <strong>Trao đổi học hỏi kinh nghiệm giữa các giáo sư, nhà nghiên cứu, sinh viên</strong>: Hai bên hợp tác cùng tạo môi trường trao đổi kinh nghiệm cho các giáo sư, các nhà nghiên cứu khoa học; hỗ trợ đào tạo và tư vấn cho sinh viên các kiến thức và thực tế về dữ liệu lớn, trí tuệ nhân tạo, công nghệ sinh học, công nghệ vật lý mới nhất.</p><p>(3) <strong>Giảng dạy và chia sẻ tri thức</strong>: Hai bên hợp tác nhằm kết nối, thu hút các giáo sư và nhà khoa học hàng đầu trong khu vực và thế giới để cùng nhau triển khai một số chương trình giảng dạy; tạo cơ hội cho sinh viên được tiếp cận tinh hoa tri thức toàn cầu.</p><p>(4) <strong>Cung cấp nguồn nhân lực chất lượng cao</strong>: Hai bên hợp tác phối hợp đào tạo nguồn nhân lực dài hạn có chất lượng cao theo nhu cầu nhân lực thực tiễn ngành, đặc biệt là nguồn nhân lực thiên về thực hành: lập trình viên, kỹ sư thực hành, chuyên viên công nghệ, chuyên viên kiểm thử phần mềm, chuyên viên phần cứng… tạo điều kiện cho sinh viên tốt nghiệp của Trường Đại học Văn Lang làm việc tại VINTECH và các công ty khác trong hệ sinh thái của Tập đoàn Vingroup.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/VLU_THI/2018/THANG_9/KY_MOU_2018/DH-Van-Lang-KI-MOU-2.jpg\" alt=\"DH Van Lang KI MOU 2\"></figure><p>Được biết, trong khuôn khổ sự kiện, Vingroup ký thỏa thuận hợp tác với 50 trường đại học trong cả nước nhằm phát triển công tác đào tạo, nghiên cứu và cung cấp nguồn nhân lực chất lượng cao cho tập đoàn và xã hội. <i>(Hình ảnh: https://vov.vn)</i></p><p>VINTECH là công ty con của Tập đoàn Vingroup, có chức năng nghiên cứu và phát triển khoa học, trụ sở tại Hà Nội. Văn Lang là trường đại học có uy tín và nhiều kinh nghiệm trong lĩnh vực đào tạo và nghiên cứu khoa học tại Tp. Hồ Chí Minh. Biên bản ghi nhớ hợp tác là cơ sở pháp lý để hai đơn vị cùng triển khai nhiều hoạt động trong tương lai.&nbsp;</p>', 2, 0, 0, 1, '2020-01-03 11:12:28', '0000-00-00 00:00:00', 4),
(37, 18, 2, 'Văn Lang ký biên bản hợp tác với các trường ĐH Bắc Âu', 'P6XA', 'Hội trường Trịnh Công Sơn', 'images/upload/20191231130730DH-van-lang-chuyen-cong-tac-bac-au-2017-05.jpg', 200, '2020-02-05 10:05:00', '2020-01-05 14:05:00', '0000-00-00 00:00:00', 'Vừa qua, Trường ĐH Văn Lang đã ký Biên bản ghi nhớ hợp tác với Trường ĐH Bắc Đan Mạch và Trường ĐH S', '<p>Từ ngày 26/8 – 4/9/2017, PGS.TS. Trần Thị Mỹ Diệu – UV Hội đồng Quản trị, Hiệu trưởng Trường ĐH Văn Lang đã tham gia chuyến công tác do Bộ trưởng Bộ GD&amp;ĐT Phùng Xuân Nhạ dẫn đầu đến các nước Phần Lan, Đan Mạch và Thụy Điển. Đây là những quốc gia có nền giáo dục phát triển hàng đầu thế giới, có phương pháp giáo dục độc đáo và chính sách đầu tư tối ưu cho giáo dục. Trong chuyến đi này, được tận mắt nhìn, được tận tai nghe, cũng như thấy sự phù hợp về định hướng và chương trình đào tạo của Trường ĐH Văn Lang, PGS.TS. Trần Thị Mỹ Diệu đã ký biên bản ghi nhớ hợp tác với một số trường đại học tại các quốc gia này.</p><p>&nbsp;</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/vlu-oanh/2017/thang_9-2017/chuyen_cong_tac_bac_au_2017/DH-van-lang-chuyen-cong-tac-bac-au-2017-05.jpg\" alt=\"DH van lang chuyen cong tac bac au 2017 05\"></figure><p>PGS.TS. Trần Thị Mỹ Diệu ký Biên bản ghi nhớ hợp tác giáo dục với Trường ĐH Bắc Đan Mạch tại Bộ Đại học và Khoa học Đan Mạch, 30/8/2017.Sáng 30/8/2017, trước sự chứng kiến của Bộ trưởng Bộ GD&amp;ĐT Phùng Xuân Nhạ và Bộ trưởng Bộ Đại học &amp; Khoa học Vương quốc Đan Mạch, Hiệu trưởng Trường ĐH Văn Lang và Hiệu trưởng Trường ĐH Bắc Đan Mạch (UCN) đã cùng ký kết Biên bản ghi nhớ thỏa thuận hợp tác, cho phép hai trường triển khai các hoạt động hợp tác: trao đổi cán bộ giảng dạy, nghiên cứu và nhân viên quản lý; trao đổi sinh viên sau đại học; tiến hành các dự án hợp tác nghiên cứu và các hoạt động đào tạo; thiết lập mối kết nối trong chương trình đào tạo giáo dục chung; các dự án hợp tác về văn hoá, tổ chức hội nghị hội thảo quốc tế và hội thảo; thúc đẩy các hoạt động hợp tác khác trong thời hạn 5 năm.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/vlu-oanh/2017/thang_9-2017/chuyen_cong_tac_bac_au_2017/DH-van-lang-chuyen-cong-tac-bac-au-2017-06.jpg\" alt=\"DH van lang chuyen cong tac bac au 2017 06\"></figure><p><br>Tại buổi ký kết, PGS.TS. Trần Thị Mỹ Diệu và bà Lene Augusta Jorgensen đã trò chuyện thân mật, và trao đổi về những nội dung hợp tác cụ thể. Dự kiến trong thời gian tới, Văn Lang sẽ xúc tiến triển khai hợp tác đào tạo ngành Kiến trúc, xúc tiến hoạt động hợp tác nghiên cứu và ứng dụng về năng lượng tái tạo; chương trình huấn đào tạo ngắn hạn cho giảng viên khoa Ngoại ngữ.<br><i>(ảnh: Bà Lene Augusta Jorgensen, Hiệu trưởng Trường ĐH Bắc Đan Mạch và PGS.TS. Trần Thị Mỹ Diệu – Hiệu trưởng Trường ĐH Văn Lang trao đổi Biên bản ghi nhớ hợp tác.)</i></p><p>UCN là trường đại học công lập, tọa lạc tại trung tâm thành phố Aalborg, một trong những thành phố lớn nhất của Đan Mạch. UCN hiện có hơn 40 chương trình giảng dạy thuộc các lĩnh vực: Công nghệ Kiến trúc, Quản lý Xây dựng, Quản lý Nhà hàng Khách sạn, Marketing &amp; Kinh doanh, Phát triển Phần mềm…, đào tạo theo khung chuẩn của Châu Âu. Chương trình giảng dạy được kiểm định chất lượng bởi Viện Kiểm định Giáo dục Đan Mạch.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/vlu-oanh/2017/thang_9-2017/chuyen_cong_tac_bac_au_2017/DH-van-lang-chuyen-cong-tac-bac-au-2017-02.jpg\" alt=\"DH van lang chuyen cong tac bac au 2017 02\"></figure><p>Trước đó, từ ngày 26-29/8, PGS.TS. Trần Thị Mỹ Diệu tham quan và giao lưu với một số trường ĐH nổi tiếng tại Phần Lan, đã gặp và trao đổi với lãnh đạo Trường ĐH Khoa học ứng dụng Saimaa. <a href=\"http://www.vanlanguni.edu.vn/component/content/article?id=328:van-lang-ghi-nho-hop-tac-voi-truong-dai-hoc-saimaa-phan-lan&amp;Itemid=363\">Hai trường đã ký Biên bản ghi nhớ hợp tác giáo dục từ ngày 7/6/2017 tại Trụ sở Trường ĐH Văn Lang</a>. <i>(ảnh: Ông Lauri Haiko – Giám đốc Phát triển của Trường ĐH Khoa học ứng dụng Saimaa và PGS.TS. Trần Thị Mỹ Diệu – Hiệu trưởng Trường ĐH Văn Lang trao đổi Biên bản ghi nhớ hợp tác, 7/6/2017)</i>.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/vlu-oanh/2017/thang_9-2017/chuyen_cong_tac_bac_au_2017/DH-van-lang-chuyen-cong-tac-bac-au-2017-04.jpg\" alt=\"DH van lang chuyen cong tac bac au 2017 04\"></figure><p>Nhân chuyến đi này, đại diện hai trường có cơ hội trao đổi cụ thể hơn về các hoạt động hợp tác sẽ xúc tiến trong thời gian tới về đào tạo ngành Quản trị Khách sạn, ngành Quản trị Dịch vụ Du lịch &amp; Lữ hành, và các hoạt động trao đổi giảng viên, sinh viên như trong Biên bản thỏa thuận hợp tác hai bên đã cùng nhau ký kết.<i> (ảnh: PGS.TS. Trần Thị Mỹ Diệu trao đổi với đại diện của Trường ĐH Khoa học ứng dụng Saimaa tại buổi tọa đàm kết nối doanh nghiệp tổ chức tại Trường ĐH Helsinki, 28/8/2017.)</i></p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/vlu-oanh/2017/thang_9-2017/chuyen_cong_tac_bac_au_2017/DH-van-lang-chuyen-cong-tac-bac-au-2017-03.jpg\" alt=\"DH van lang chuyen cong tac bac au 2017 03\"></figure><p>Trong khuôn khổ chuyến đi, Hiệu trưởng Trường ĐH Văn Lang, các thành viên trong Đoàn đã cùng GS.TS. Phùng Xuân Nhạ tham dự triển lãm tranh gây quỹ ủng hộ học sinh Lào Cai tại thành phố Helsinki (Phần Lan), đến thăm, trao đổi và học hỏi kinh nghiệm về cách thức quản trị đại học, cách thức thu hút doanh nghiệp tham gia quá trình đào tạo; phát triển nghiên cứu khoa học, các mô hình quản lý nhà trường hiện đại, cách đánh giá, kiểm định chất lượng giáo dục tại các trường đại học ở các quốc gia này.</p><p>Chuyến đi đã mở ra nhiều triển vọng hợp tác mới của Trường ĐH Văn Lang. Thông qua việc mở rộng hợp tác quốc tế, Văn Lang tìm hiểu các cơ hội hợp tác, học hỏi từ những nền giáo dục tiên tiến trên thế giới, ứng dụng phù hợp với thực tiễn và định hướng của Trường để góp phần thúc đẩy giáo dục phát triển, giúp đội ngũ người dạy – người học của Trường phát triển tư duy toàn cầu, khẳng định năng lực bản thân. Cơ hội ký các biên bản ghi nhớ là bước khai mở quan trọng, Văn Lang sẽ nỗ lực duy trì thực hiện các việc tiếp theo sau các ký kết này, để hiện thực hóa những điều khoản theo cách hiệu quả nhất.&nbsp;</p>', 4, 0, 0, 1, '2020-01-03 11:12:28', '0000-00-00 00:00:00', 4),
(38, 11, 2, ' Nghiệm thu đề tài nghiên cứu khoa học của bộ môn Toán', '78F9', 'Hội trường Trịnh Công Sơn', 'images/upload/20191231131025nghiem-thu-de-tai-bo-mon-toan.jpg', 230, '2020-01-02 10:10:00', '2020-01-02 12:05:00', '0000-00-00 00:00:00', 'ộ môn Toán Ban Khoa học cơ bản trường ĐH Văn Lang đã bảo vệ thành công đề tài nghiên cứu khoa học ', '<p>Hội đồng nghiệm thu đề tài do PGS.TS. Nguyễn Định (Trường ĐH Quốc tế - ĐHQG Tp.HCM) làm Chủ tịch, các ủy viên gồm TS. Nguyễn Xuân Hải (Chủ nhiệm bộ môn Toán – Học viên Bưu chính Viễn thông Tp.HCM, Phản biện 1), ThS. Trần Thanh Hiệp (Giảng viên ĐH FPT Tp.HCM, Phản biện 2), GVC.CN. Lê Cường và CN. Trương Thanh Duy (GV bộ môn Toán Trường ĐH Văn Lang). Hội đồng đánh giá loại giỏi đối với đề tài “Thay đổi nội dung, giáo trình và phương pháp giảng dạy học phần toán Giải tích 1 cho sinh viên các ngành học Toán cao cấp A” và khẳng định đây là công trình công phu, có ý nghĩa ứng dụng cao trong giảng dạy môn Toán Giải tích 1. Kết quả của đề tài là Giáo trình Toán Giải tích 1 (dịch và biên soạn từ Giáo trình Calculus 1 của tác giả James Stewart) gồm bài đọc, bài giảng và bài tập. Ngoài ra, đề tài còn cung cấp tài nguyên kèm theo giáo trình gồm các file mô phỏng phục vụ giảng dạy trực quan.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/nhom-nhap-tin/2017/08/30/nghiem-thu-de-tai-bo-mon-toan/nghiem-thu-de-tai-bo-mon-toan.jpg\" alt=\"nghiem thu de tai bo mon toan\"></figure><p>ThS. Phạm Thị Diệu Hường báo cáo đề tài trước Hội đồng nghiệm thu</p><p>Hiện nay, Giáo trình Calculus 1 được giảng dạy ở nhiều trường ĐH trên thế giới. Ở Việt Nam, một số trường đã dạy môn Toán Giải tích 1 theo giáo trình này (ĐH Quốc tế - ĐHQG Tp.HCM, ĐH Hoa Sen…). Đặc điểm ưu việt của giáo trình Calculus 1 là tính ứng dụng cao, thay vì dạy lý thuyết hàn lâm, giáo trình đi từ ví dụ thực tế đến định nghĩa toán học, và trở lại giải quyết những bài toán thực tế. Nếu đưa vào giảng dạy, trước hết cho SV Văn Lang ngành Công nghệ thông tin đào tạo theo chương trình của ĐH Carnegie Mellon, hứa hẹn SV sẽ yêu thích môn học và thực hành hiệu quả từ những ứng dụng của môn học.</p><p>Đây là đề tài đã được Tổ Bộ môn Toán thực hiện trong thời gian hơn 1 năm (từ tháng 6/2009 đến tháng 8/2010), một số phần đã đưa vào ứng dụng giảng dạy thực tế. Đước biết, việc chỉnh sửa, hoàn thiện đề tài để chuẩn bị cho đợt bảo vệ, nghiệm thu đã được tiến hành cẩn thận, với sự hỗ trợ của nhiều đơn vị trong trường. Công trình thể hiện mong muốn của tập thể giảng viên bộ môn và cũng là mong muốn chung của nhà trường: hiện đại hoá giáo trình, từng bước tiếp cận thực sự với các giáo trình và phương pháp giảng dạy tiên tiến, nâng tầm đội ngũ giảng viên thông qua các hoạt động chuyên môn đi vào thực chất.</p><p>Công trình được nghiệm thu và được Hội đồng nhất trí đánh giá loại Giỏi. Đây là một niềm vui lớn và là một nguồn động viên sâu sắc đối với tập thể Tổ Bộ môn Toán, Ban Khoa học cơ bản trường ĐHDL Văn Lang. Xin chúc mừng Bộ môn Toán, chúc mừng các Thầy Cô, và mong muốn càng ngày càng có thêm nhiều công trình được triển khai theo tinh thần khoa học và thiết thực này. &nbsp;</p>', 6, 0, 0, 1, '2020-01-03 11:12:28', '0000-00-00 00:00:00', 4),
(39, 18, 3, 'Xavi xem nhẹ tài dự đoán ở Asian Cup 2019', 'PBGT', 'Hội trường Trịnh Công Sơn', 'images/upload/20191231131452Untitled-6132-1549688200.jpg', 120, '2020-01-03 14:55:00', '2020-01-04 19:35:00', '0000-00-00 00:00:00', '\"Tôi dự đoán Qatar vô địch Asian Cup vì có thiện cảm với họ. Tôi cũng hiểu rõ tiềm năng của họ. Tôi ', '<p>\"Tôi dự đoán Qatar vô địch Asian Cup vì có thiện cảm với họ. Tôi cũng hiểu rõ tiềm năng của họ. Tôi thân thiết với các cầu thủ và ở gần họ mỗi ngày. Tôi biết khả năng của các cầu thủ và phong cách đặc biệt mà HLV Felix Sanchez đã áp dụng\", Xavi tiết lộ với kênh truyền hình&nbsp;<i>Al Kass</i>.</p><figure class=\"table\"><table><tbody><tr><td><figure class=\"image\"><img src=\"https://i-thethao.vnecdn.net/2019/02/09/Untitled-6132-1549688200.jpg\" alt=\"Xavi cho rằng thành công của tuyển Qatar tại Asian Cup&nbsp;là điều dễ hiểu. Ảnh: Fox.\"></figure></td></tr><tr><td>Xavi cho rằng thành công của tuyển Qatar tại Asian Cup&nbsp;là điều dễ hiểu. Ảnh: <i>Fox</i>.</td></tr></tbody></table></figure><p>Xavi đã khiến mọi người ngạc nhiên khi dự đoán Qatar vô địch Asian Cup 2019 từ trước khi giải bắt đầu. Anh thậm chí đoán đúng 7/8 đội lọt vào tứ kết. Tiền vệ đang chơi cho CLB&nbsp;Al Sadd được cho là có vai trò đặc biệt trong sự phát triển của bóng đá Qatar vài năm gần đây.</p><p>\"Chúng ta phải nhớ rằng Liên đoàn bóng đá Qatar đã đầu tư cho lứa cầu thủ này trong nhiều năm. Học viện bóng đá&nbsp;Aspire là ý tưởng của Sheikh Jassim bin Hamad Al Thani và nó đã mang lại thành công lớn. Người hâm mộ bóng đá Qatar giờ đã nhìn thấy kết quả\", Xavi nói.</p><p>Học viện bóng đá&nbsp;Aspire đóng góp 13 cầu thủ trong đội hình Qatar vô địch Asian Cup. Theo dõi sự phát triển của học viện này, Xavi cho rằng thành công của thầy trò HLV Sanchez không bất ngờ.&nbsp;\"Nhiều CĐV ở Tây Ban Nha nói với tôi về phép màu đang diễn ra ở Qatar. Tôi giải thích&nbsp;cho họ rằng chẳng có phép màu nào ở đây cả. Nó đến từ sự đầu tư trong nhiều năm đồng thời từ nỗ lực và kế hoạch dài hạn của học viện Aspire\", Xavi nói.</p><p>Cựu tiền vệ Barca tiết lộ anh đã làm việc riêng với HLV Felix Sanchez để giúp Qatar chuẩn bị cho Asian Cup và World Cup 2022.&nbsp;\"Tôi yêu bóng đá, bất kể là thi đấu hay huấn luyện. Đó là lý do tại sao tôi có mặt ở Aspire để giúp Felix Sanchez trong dự án này. Sự hiện diện của tôi ở Qatar là để chuẩn bị cho World Cup 2022\", Xavi nói.</p>', 3, 0, 0, 1, '2020-01-03 11:12:28', '0000-00-00 00:00:00', 1),
(40, 11, 3, 'Liverpool vẫn giữ đỉnh bảng nếu không có VAR', '6OBG', 'Hội trường Trịnh Công Sơn', 'images/upload/20191231131630pl-ranking-5745-1577750288.jpg', 500, '2020-01-08 14:10:00', '2020-01-08 18:10:00', '0000-00-00 00:00:00', 'ANHNếu không có VAR, thầy trò Jurgen Klopp sẽ có ít hơn năm điểm, nhưng vẫn hơn đội nhì bảng Man Cit', '<p>Liverpool được cho là hưởng nhiều quyết định có lợi từ VAR, nhất là sau trận thắng Wolves 1-0 hôm Chủ nhật 29/12, dù cả hai quyết định đều chính xác: công nhận bàn thắng của Sadio Mane và từ chối bàn gỡ của Pedro Neto.</p><p>Tuy nhiên, ngay cả khi bỏ những tác động của VAR trong mùa 2019-2020, Liverpool vẫn giữ đỉnh bảng. Theo <i>The Sun</i>, thầy trò Jurgen Klopp sẽ có 50 điểm, ít hơn hiện tại năm điểm, và chỉ hơn đội nhì bảng, trong trường hợp này là Man City, sáu điểm.</p><figure class=\"table\"><table><tbody><tr><td><figure class=\"image\"><img src=\"https://i-thethao.vnecdn.net/2019/12/31/pl-ranking-5745-1577750288.jpg\" alt=\"Bảng điểm Ngoại hạng Anh bỏ qua những tác động của VAR. Ảnh: The Sun.\"></figure></td></tr><tr><td>Bảng điểm Ngoại hạng Anh bỏ qua những tác động của VAR. Ảnh: <i>The Sun.</i></td></tr></tbody></table></figure><p>Kể từ đầu mùa, VAR có tổng cộng 58 quyết định, ảnh hưởng tới tỷ số các trận đấu. Riêng Liverpool, họ bốn lần hưởng lợi và gặp hai quyết định bất lợi. Man City xếp sau, cũng hưởng bốn quyết định có lợi, nhưng có tới ba lần gặp bất lợi.</p><p>Brighton là đội được VAR \"ưu ái\" nhất với bảy quyết định có lợi dành cho họ, và chỉ hai dành cho các đối thủ. Tuy nhiên ngay cả khi không có VAR, chủ sân Express vẫn giữ nguyên vị trí thứ 14 trên bảng điểm, dù ít hơn thực tế một điểm.&nbsp;</p><p>Tottenham là đội thăng tiến mạnh mẽ nhất nhờ VAR. Nếu không có công nghệ này, thầy trò Jose Mourinho sẽ đứng thứ 12, thay vì thứ sáu như hiện tại. Tương tự&nbsp; Liverpool, \"Gà trống\" có thêm năm điểm nhờ các phán quyết của VAR.</p><figure class=\"table\"><table><tbody><tr><td><figure class=\"image\"><img src=\"https://i-thethao.vnecdn.net/2019/12/31/mane-8537-1577750288.jpg\" alt=\"Mane mừng bàn thắng duy nhất vào lưới Wolves. Ảnh: PA.\"></figure></td></tr><tr><td>Mane mừng bàn thắng duy nhất vào lưới Wolves. Ảnh: <i>PA.</i></td></tr></tbody></table></figure><p>Wolves là đội đen đủi nhất khi VAR xuất hiện. Tính cả hai quyết định bất lợi trong trận thua Liverpool, thầy trò Nuno Santo bị VAR tước tổng cộng bảy điểm, nhiều nhất trong số 20 đội dự Ngoại hạng Anh mùa này. Nếu có bảy điểm ấy, thay vì thứ bảy, \"ngựa ô\" mùa trước sẽ lên vị trí thứ năm.</p><p>Xét về thứ bậc, Arsenal là đội bị tụt nhiều nhất vì VAR. \"Pháo thủ\" sẽ xếp thứ chín, tăng ba bậc so với hiện tại.&nbsp;</p><p>Bốn vị trí dẫn đầu bảng điểm vẫn là Liverpool, Man City, Leicester và Chelsea. Dù vậy, Man City và Leicester đổi vị trí cho nhau, với năm điểm nhiều hơn thuộc về thầy trò Guardiola.</p>', 2, 0, 0, 1, '2020-01-03 11:12:28', '0000-00-00 00:00:00', 4),
(41, 10, 3, 'HLV Park Hang-seo xem nhẹ sự nổi tiếng mà ông đang có với bóng đá Việt Nam', 'YDTU', 'Hội trường Trịnh Công Sơn', 'images/upload/20191231132123Untitled-5940-1577717762.jpg', 123, '2020-01-02 18:55:00', '2020-01-03 19:50:00', '0000-00-00 00:00:00', 'HLV Park Hang-seo xem nhẹ sự nổi tiếng mà ông đang có với bóng đá Việt Nam', '<p>\"Khi mọi thứ không suôn sẻ, một ngày nào đó, những gì tôi đang có sẽ tan biến\", ông chia sẻ trên tờ <i>Chosun</i> (Hàn Quốc). \"Cuộc đời của một HLV được định đoạt bởi thắng hoặc thua trong 90 phút. Tôi cố gắng sống một cách bình thường vì tôi biết sự nổi tiếng chỉ như làn khói\".</p><figure class=\"table\"><table><tbody><tr><td><figure class=\"image\"><img src=\"https://i-thethao.vnecdn.net/2019/12/30/Untitled-5940-1577717762.jpg\" alt=\"HLV Park trong buổi phỏng vấn gần đây với tờ Chosun. Ảnh: Chosun.\"></figure></td></tr><tr><td>HLV Park trong buổi phỏng vấn gần đây với tờ Chosun. Ảnh: <i>Chosun</i>.</td></tr></tbody></table></figure><p>Từ khi nhậm chức cuối năm 2017, HLV Park liên tiếp gây tiếng vang bằng cách đưa các đội tuyển Việt Nam vào chung kết U23 châu Á 2018, tứ kết Asian Cup 2018, vô địch AFF Cup 2018 và giành HC vàng SEA Games 2019. Những chiến tích đó giúp sự nghiệp của ông sang trang, đi kèm với đó là sự mến mộ rộng rãi tại Việt Nam, Hàn Quốc và nhiều quốc gia châu Á khác.</p><p>Nhưng HLV Park tự nhận bản thân là người không giỏi giữ gìn hình ảnh trước công chúng. Ông nói: \"Tôi hiểu sự nổi tiếng mang lại những gì. Tôi không phải người giỏi ngoại giao. Nhưng tôi sẽ không phớt lờ nếu ai đó gọi lớn tên mình hoặc xin chụp hình chung\".</p><p>Sau khi thống trị bóng đá Đông Nam Á, mục tiêu tiếp theo của HLV Park là vòng chung kết U23 châu Á 2020 tại Thái Lan. Cách đây hai năm, Việt Nam đã giành HC bạc giải đấu này, nhưng giải sắp tới có ý nghĩa hơn khi ba đội đứng đầu sẽ được trao suất dự Olympic 2020. \"Trước mắt tôi cứ đặt mục tiêu qua vòng bảng. Còn khi vào vòng đấu loại trực tiếp rồi, không biết chuyện gì sẽ xảy ra\", ông nói.</p><p>Trong giai đoạn tập huấn ở Hàn Quốc cách đây gần hai tuần, HLV Park từng tuyên bố rằng ông muốn kết thúc sự nghiệp huấn luyện ở Việt Nam. Khi được hỏi lại vấn đề này, chiến lược gia sinh năm 1959 nhấn mạnh: \"Một ngày nào đó, tôi sẽ giải nghệ. Sau đó có thể tôi sẽ làm việc ở một học viện hoặc một nơi nào đó nhằm bồi dưỡng cho&nbsp;thế hệ cầu thủ trẻ của Việt Nam\".</p><p>Mới đây, đồng hương của HLV Park - Shin Tae-yong - đã nhận lời dẫn dắt đội tuyển Indonesia. Vào ngày 4/6/2020, cả hai sẽ có dịp chạm trán khi Việt Nam gặp Indonesia ở lượt về vòng loại World Cup 2022 khu vực châu Á.&nbsp;\"Cá nhân tôi luôn thân thiết và tôn trọng những HLV trẻ. Tôi cho rằng trên sân mỗi HLV phải làm hết sức, không nhượng bộ cho dù đối thủ là ai. Đó mới là xem trọng danh dự và sự tự hào của nhau\", ông nói.&nbsp;</p>', 6, 0, 0, 1, '2020-01-07 09:07:40', '0000-00-00 00:00:00', 0);
INSERT INTO `event` (`id`, `account_id`, `category_id`, `title`, `code`, `place`, `avatar`, `ticket_number`, `start_date`, `end_date`, `expired_date`, `short_desc`, `description`, `faculty_id`, `user_make_question`, `user_reply_question`, `check_question`, `last_modified`, `public_at`, `status`) VALUES
(42, 10, 3, 'Trường Đại học Văn Lang đăng cai tổ chức Giải Việt dã Sinh viên Tp.HCM lần X năm 2019 sửa rồi nè', '3CKF', 'Sân vận động Mỹ Đình', 'images/upload/20191231144625ttt.jpg', 100, '2020-01-04 15:45:00', '2020-01-04 23:40:00', '0000-00-00 00:00:00', ' Sáng ngày 08122019, tại Nhà văn hóa sinh viên thuộc khu đô thị Đại học Quốc gia TP.HCM', '<p>&nbsp;<strong>Sáng ngày 08/12/2019, tại Nhà văn hóa sinh viên thuộc khu đô thị Đại học Quốc gia TP.HCM, Hội Sinh viên TP.HCM và Trường Đại học Văn Lang phối hợp tổ chức&nbsp;Giải Việt dã Sinh viên TP. HCM lần X.</strong></p><p>Năm 2019 đánh dấu cột mốc lần thứ 10 tổ chức của Giải Việt dã sinh viên Tp. HCM từ khi Giải được Hội sinh viên Tp. HCM chính thức phát động vào năm 2003, với tiền thân là Giải Việt dã sinh viên học sinh của Trường Đại học Văn Lang khởi động từ năm 2000. Năm nay, Giải thu hút hàng ngàn sinh viên các trường Đại học, Cao đẳng trên địa bàn thành phố. Đây là hoạt động hướng tới kỷ niệm 70 năm ngày truyền thống học sinh, sinh viên và Hội sinh viên Việt Nam (09/01/1950 - 09/01/2020) và kỷ niệm 25 năm thành lập Trường Đại học Văn Lang (1995 - 2020).</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/VLU-HOANGLUAN/VIET_DA_SINH_VIEN_2019/VLU_-_A.jpg\" alt=\"VLU A\"></figure><p>Sinh viên các trường Đại học, Cao đẳng trên địa bàn thành phố quy tụ về Nhà Văn hóa Sinh viên thuộc Khu đô thị Đại học Quốc gia TP.HCM để tham dự giải Việt dã sinh viên Tp.HCM lần X năm 2019 (08/12/2019).</p><p>Là đơn vị đăng cai tổ chức và cũng là trường tiên phong trong phong trào nâng cao thể lực, rèn luyện sức khỏe cho sinh viên, năm nay Trường Đại học Văn Lang có số lượng sinh viên tham dự giải đông đảo nhất, cùng với sự tham gia của sinh viên các trường: Trường Đại học Công nghệ Tp. HCM, Trường Đại học Nguyễn Tất Thành, Trường Đại học Sư phạm Kỹ thuât Tp. HCM, các trường thành viên Đại học Quốc gia Tp. HCM,...</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/VLU-HOANGLUAN/VIET_DA_SINH_VIEN_2019/VLU_-_B.jpg\" alt=\"VLU B\"></figure><p>Phát biểu khai mạc Giải Việt dã, ThS. Võ Văn Tuấn – Phó Hiệu trưởng thường trực Trường Đại học Văn Lang cảm ơn các đơn vị đồng hành tổ chức và đơn vị tài trợ cho chương trình. Đây là một sân chơi rèn luyện sức khỏe, ngày hội thi đấu thể thao và giao lưu học hỏi, tăng cường đoàn kết của sinh viên trên địa bàn thành phố. Trường Đại học Văn Lang rất vinh dự là đơn vị đăng cai tổ chức hoạt động ý nghĩa này. Trải qua 10 lần tổ chức, quy mô của giải tiếp tục duy trì ở cấp thành phố, nhận được sự đồng hành của sinh viên các trường bạn và tác động tích cực đến phong trào bảo vệ sức khỏe, nâng cao thể lực của học sinh, sinh viên. ThS. Võ Văn Tuấn cũng mong rằng sau khi tham gia sân chơi, các em học sinh, sinh viên sẽ nhận thức được tầm quan trọng của sức khỏe, từ đó thường xuyên luyện tập thể dục thể thao để có sức khỏe và trí lực dồi dào, hoàn thành việc học tập rèn luyện ở trường.</p><p>Năm nay, Giải Việt dã chia làm 2 nội dung thi đấu chính thức là 3.000 m đối với sinh viên nữ và 4.000 m đối với sinh viên nam. Các bạn sinh viên có 30 phút để hoàn thành đường chạy. Với thông điệp “<i><strong>Chạy vì sức khỏe – Chạy để chung tay bảo vệ môi trường – Chạy để chia sẻ yêu thương</strong></i>”, mỗi sinh viên hoàn thành đường chạy trong thời gian quy định sẽ đóng góp 5.000 đồng vào việc chung tay vì trẻ em khó khăn trên địa bàn thành phố.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/VLU-HOANGLUAN/VIET_DA_SINH_VIEN_2019/VLU_-_C.jpg\" alt=\"VLU C\"></figure><p>Khẩu hiệu xuất phát vang lên, mọi người đều hào hứng chạy nhanh nhất để hoàn thành đường đua trong thời gian quy định.&nbsp;ThS. Võ Văn Tuấn – Phó Hiệu trưởng thường trực Trường Đại học Văn Lang là một trong những “vận động viên” hoàn thành sớm nhất đường đua dành cho các đại biểu, khách mời, cổ vũ, khích lệ tinh thần các bạn sinh viên.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/VLU-HOANGLUAN/VIET_DA_SINH_VIEN_2019/VLU-E.jpg\" alt=\"VLU E\"></figure><p>Sinh viên Khoa Du lịch Trường Đại học Văn Lang cùng nhau chạy về đich</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/VLU-HOANGLUAN/VIET_DA_SINH_VIEN_2019/VLU-F.jpg\" alt=\"VLU F\"></figure><p>Nam sinh Khoa Y dược Trường Đại học Văn Lang chuẩn bị cán đích cự ly 4000 m cho nam.</p><figure class=\"image\"><img src=\"http://www.vanlanguni.edu.vn/images/VLU-HOANGLUAN/VIET_DA_SINH_VIEN_2019/VLU-G.jpg\" alt=\"VLU G\"></figure><p>Các bạn sinh viên cùng nhau chạy về đích hoàn thành đường chạy đúng thời gian quy định của Ban tổ chức. Mỗi sinh viên hoàn thành đường chạy trong thời gian quy định sẽ đóng góp 5.000 đồng vào việc chung tay vì trẻ em khó khăn trên địa bàn thành phố.</p>', 1, 0, 0, 1, '2020-01-03 11:12:28', '0000-00-00 00:00:00', 1),
(43, 10, 1, 'Khoa Kinh doanh Thương mại đón tiếp đoàn kiến học từ Brunei tham quan Cơ sở 3', 'LYTN', 'HỘi trường tcs\'', 'images/upload/20200107213948ck.jpg', 500, '2020-01-15 14:35:00', '2020-01-16 19:55:00', '0000-00-00 00:00:00', 'Sáng ngày 24122019, Trường Đại học Văn Lang đón tiếp đoàn kiến học gồm các Trưởng Khoa, giảng viên', '<p>ông bran\'\'</p><p>&nbsp;</p>', 1, 1, 0, 1, '2020-01-07 21:47:12', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `name`, `status`) VALUES
(-1, 'Chưa có', 0),
(0, 'Cựu Sinh Viên, Doanh Nghiệp', 1),
(1, 'Công Nghệ Thông Tin', 1),
(2, 'Kĩ Thuật Ô Tô', 1),
(3, 'Công Nghệ Sinh Học', 1),
(4, 'Ngoại Ngữ', 1),
(5, 'Kiến Trúc', 1),
(6, 'Xây Dựng', 1),
(7, 'Môi Trường', 1);

-- --------------------------------------------------------

--
-- Table structure for table `moderator`
--

CREATE TABLE `moderator` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moderator`
--

INSERT INTO `moderator` (`id`, `event_id`, `email`, `status`) VALUES
(3, 31, 't160913@vanlanguni.vn', 0),
(4, 32, 't160913@vanlanguni.vn', 0),
(5, 33, 't160913@vanlanguni.vn', 0),
(6, 34, 't160913@vanlanguni.vn', 0),
(7, 35, 't160913@vanlanguni.vn', 0),
(8, 36, 't160913@vanlanguni.vn', 0),
(9, 37, 't160913@vanlanguni.vn', 0),
(10, 38, 't160913@vanlanguni.vn', 0),
(15, 39, 't160913@vanlanguni.vn', 0),
(22, 41, 't160913@vanlanguni.vn', 0),
(23, 42, 't160614@vanlanguni.vn', 0),
(24, 31, 'tamtang@gmail.com', 0),
(25, 42, 't160614@vanlanguni.vn', 0),
(38, 43, 't160614@vanlanguni.vn', 0);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `user_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_fullname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `pinned` int(11) NOT NULL DEFAULT '0',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '(0: chờ duyệt) (1: đã duyệt) (2: đã xóa)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `user_id`, `event_id`, `user_fullname`, `content`, `pinned`, `create_at`, `status`) VALUES
(4, '10', 31, 'Bùi Trung Tuấn', 'đặt câu hỏi nè trả lời đi :)', 0, '2020-03-20 15:19:06', 0),
(5, '10', 31, 'Bùi Trung Tuấn', 'chỉnh sưa câu hỏi', 0, '2020-03-20 15:20:28', 0),
(6, '10', 31, 'Bùi Trung Tuấn', 'cho tui hỏi cái nè ', 0, '2020-03-20 15:35:49', 0),
(47, '10', 31, 'Bùi Trung Tuấn', 'hehe xin chào nè', 0, '2020-03-20 19:47:25', 1),
(48, '10', 31, 'Bùi Trung Tuấn', 'đặt câu hỏi cho trang quản lý', 0, '2020-03-20 20:11:59', 1),
(49, '10', 31, 'Bùi Trung Tuấn', 'tí duyệt', 0, '2020-03-20 20:13:00', 0),
(54, '10', 31, 'Bùi Trung Tuấn', 'fetch câu hỏi đã duyệt - duyệt cho nè', 0, '2020-03-20 20:34:29', 1),
(55, '10', 31, 'Bùi Trung Tuấn', 'vô luôn bạn ơi', 0, '2020-03-20 20:36:02', 1),
(56, '10', 31, 'Bùi Trung Tuấn', 'vô thẳng nè nha', 0, '2020-03-20 20:39:14', 1),
(60, '10', 31, 'Bùi Trung Tuấn', 'câu hỏi để duyệt', 0, '2020-03-20 21:53:02', 1),
(61, '10', 31, 'Bùi Trung Tuấn', 'vô duyệt đi bạn ơi', 0, '2020-03-20 22:09:10', 1),
(62, '10', 31, 'Bùi Trung Tuấn', 'lên thẳng luôn nè', 0, '2020-03-20 22:09:31', 1),
(63, '11', 31, 'Trần Thịnh', 'gửi câu hỏi nè', 0, '2020-03-21 13:35:44', 1),
(64, '10', 31, 'Bùi Trung Tuấn', 'đặt câu hỏi', 0, '2020-03-21 13:49:04', 1),
(65, '10', 31, 'Bùi Trung Tuấn', 'gửi luôn nè nha', 0, '2020-03-21 13:49:18', 1),
(67, '2', 31, 'Đường Tăng', 'cho hỏi đường đi đến tây thiên', 0, '2020-03-21 20:03:16', 1),
(68, '2', 31, 'Đường Tăng', 'gửi nè nha anha a', 0, '2020-03-21 20:55:51', 1),
(69, '10', 31, 'Bùi Trung Tuấn', '1 câu hỏi', 0, '2020-03-24 16:07:19', 1),
(78, '10', 31, 'Bùi Trung Tuấn', 'đặt câu hỏi demo đã chỉnh sửa', 0, '2020-03-31 13:40:52', 1),
(79, '10', 31, 'Bùi Trung Tuấn', 'lên câu hỏi luôn nè nha', 0, '2020-03-31 13:41:23', 1),
(80, 'guest_91019', 31, 'Người Lạ 91019', 'Người lạ đặt câu hỏi', 1, '2020-03-31 13:43:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reaction`
--

CREATE TABLE `reaction` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reaction`
--

INSERT INTO `reaction` (`id`, `event_id`, `user_id`, `question_id`) VALUES
(65, 31, '2', 67),
(73, 31, '10', 67),
(75, 31, 'guest_72253', 80),
(76, 31, '10', 80);

-- --------------------------------------------------------

--
-- Table structure for table `reviewer`
--

CREATE TABLE `reviewer` (
  `event_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviewer`
--

INSERT INTO `reviewer` (`event_id`, `account_id`, `email`) VALUES
(42, 0, 'tamtang@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `review_comment`
--

CREATE TABLE `review_comment` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `day_comment` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `review_comment`
--

INSERT INTO `review_comment` (`id`, `event_id`, `account_id`, `comment`, `day_comment`) VALUES
(1, 1, 3, 'nội dung k phù hợp', '2019-12-10 09:10:18'),
(2, 1, 4, 'không thích duyệt', '2019-12-10 10:07:09'),
(3, 1, 1, '', '2019-12-17 09:03:55'),
(4, 3, 1, '', '2019-12-17 10:47:43'),
(5, 42, 1, 'cô nói từ chối', '2019-12-31 14:52:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `attendee`
--
ALTER TABLE `attendee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`,`faculty_id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `moderator`
--
ALTER TABLE `moderator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reaction`
--
ALTER TABLE `reaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review_comment`
--
ALTER TABLE `review_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`,`account_id`),
  ADD KEY `account_id` (`account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `attendee`
--
ALTER TABLE `attendee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `moderator`
--
ALTER TABLE `moderator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `reaction`
--
ALTER TABLE `reaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `review_comment`
--
ALTER TABLE `review_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`);

--
-- Constraints for table `attendee`
--
ALTER TABLE `attendee`
  ADD CONSTRAINT `attendee_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `event_ibfk_4` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`),
  ADD CONSTRAINT `event_ibfk_5` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`);

--
-- Constraints for table `review_comment`
--
ALTER TABLE `review_comment`
  ADD CONSTRAINT `review_comment_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
