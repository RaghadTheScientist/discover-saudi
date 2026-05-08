-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 08, 2026 at 08:10 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saudi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'c93ccd78b2076528346216b3b2f701e6'),
(2, 'elaf', '1234562005');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_order` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `place_id`, `image_path`, `image_order`) VALUES
(1, 1, 'images/riyadh/gallery1.avif', 1),
(2, 1, 'images/riyadh/gallery2.jpeg', 2),
(3, 2, 'images/makkah/gallery1.png', 1),
(4, 2, 'images/makkah/gallery2.png', 2),
(5, 3, 'images/alula/gallery1.png', 1),
(6, 3, 'images/alula/gallery2.png', 2),
(7, 4, 'images/alkhobar/main.jpg', 1),
(8, 5, 'images/abha/main.webp', 1),
(9, 6, 'images/tabuk/main.jpg', 1),
(32, 34, 'images/m.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `features` text COLLATE utf8mb4_unicode_ci,
  `activities` text COLLATE utf8mb4_unicode_ci,
  `top_landmarks` text COLLATE utf8mb4_unicode_ci,
  `main_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `region_id`, `name`, `description`, `location`, `features`, `activities`, `top_landmarks`, `main_image`, `created_at`) VALUES
(1, 1, 'الرياض', 'عاصمة المملكة العربية السعودية تمتزج فيها الحداثة بالتراث العريق.', 'وسط المملكة', 'ناطحات سحاب, متاحف, حدائق', 'زيارة المتاحف, التسوق, رحلات تاريخية', 'برج المملكة, قصر المصمك, حديقة الحيوانات', 'images/riyadh/main.jpg', '2026-05-07 13:15:00'),
(2, 2, 'مكة المكرمة', 'أقدس مدينة في الإسلام وجهة المسلمين للحج والعمرة.', 'غرب المملكة', 'مسجد, تاريخ, ثقافة', 'الحج, العمرة, زيارة المعالم الدينية', 'المسجد الحرام, الكعبة المشرفة, جبل النور', 'images/makkah/main.webp', '2026-05-07 13:15:00'),
(3, 3, 'العلا', 'مدينة تاريخية تضم آثاراً نبطية ومعالم طبيعية فريدة.', 'شمال غرب المملكة', 'آثار, طبيعة, صحراء', 'استكشاف الآثار, تسلق الجبال, التصوير', 'مدائن صالح, العين, جبل الفيل', 'images/alula/main.webp', '2026-05-07 13:15:00'),
(4, 4, 'الخبر', 'مدينة ساحلية حديثة تطل على الخليج العربي.', 'شرق المملكة', 'بحر, كورنيش, ترفيه', 'السباحة, المشي على الكورنيش, المطاعم', 'كورنيش الخبر, جزيرة أم الناعام, مول الراشد', 'images/alkhobar/main.jpg', '2026-05-07 13:15:00'),
(5, 5, 'أبها', 'عاصمة منطقة عسير تشتهر بطبيعتها الخلابة وأجوائها الباردة.', 'جنوب المملكة', 'جبال, ضباب, طبيعة', 'التلفريك, السياحة الجبلية, المهرجانات', 'تلفريك أبها, منتزه عسير, قرية تنومة', 'images/abha/main.webp', '2026-05-07 13:15:00'),
(6, 6, 'تبوك', 'بوابة الشمال تمتلك إرثاً تاريخياً وطبيعة متنوعة.', 'شمال المملكة', 'تاريخ, بحر, جبال', 'الغوص, زيارة الآثار, التخييم', 'شاطئ مقنا, جبال تبوك, قلعة تبوك', 'images/tabuk/main.jpg', '2026-05-07 13:15:00'),
(7, 34, 'المدينه المنوره', 'تُعرف بمكانتها الإسلامية العظيمة لاحتضانها المسجد النبوي ومعالم تاريخية ودينية بارزة.', 'غربية', 'أجواء روحانية، معالم تاريخية، أسواق شعبية، مزارع نخيل.', 'زيارة المعالم الدينية، التسوق، استكشاف المواقع التاريخية، التصوير.', 'المسجد النبوي، مسجد قباء، جبل أحد.', 'images/m.jpg', '2026-05-08 16:45:41');

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `name`, `direction`, `description`, `created_at`) VALUES
(1, 'منطقة الرياض', 'وسطى', 'عاصمة المملكة ومركزها الإداري والاقتصادي', '2026-05-07 13:15:00'),
(2, 'منطقة مكة المكرمة', 'غربية', 'أقدس البقاع وجهة الحج والعمرة', '2026-05-07 13:15:00'),
(3, 'العلا', 'غربية', 'مدينة تاريخية تضم آثاراً نبطية ومعالم طبيعية فريدة', '2026-05-07 13:15:00'),
(4, 'المنطقة الشرقية', 'شرقية', 'مركز صناعة النفط والساحل الخليجي', '2026-05-07 13:15:00'),
(5, 'منطقة عسير', 'جنوبية', 'تشتهر بطبيعتها الجبلية وأجوائها الباردة', '2026-05-07 13:15:00'),
(6, 'منطقة تبوك', 'شمالية', 'بوابة الشمال بين الجبال والبحر الأحمر', '2026-05-07 13:15:00'),
(34, 'المدينه المنوره', 'غربية', 'تُعرف بمكانتها الإسلامية العظيمة لاحتضانها المسجد النبوي ومعالم تاريخية ودينية بارزة.', '2026-05-08 16:45:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gallery_region` (`place_id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`),
  ADD KEY `region_id` (`region_id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD CONSTRAINT `fk_gallery_region` FOREIGN KEY (`place_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `places_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
