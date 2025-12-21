-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 21, 2025 at 07:37 PM
-- Server version: 10.6.23-MariaDB-cll-lve-log
-- PHP Version: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pefsdzhc_portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(5, 'admin', '$2y$10$QwNVIPUCvlnNaJhf3yRZuucy06JuEp0oXmuH/IEk3m4TrYq0RmTXW');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `school_name` varchar(100) DEFAULT NULL,
  `degree` varchar(100) DEFAULT NULL,
  `year_range` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `school_name`, `degree`, `year_range`) VALUES
(1, 'Universitas Buana Perjuangan Karawang', 'Sistem Informasi/S. Kom', '2019');

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `year_range` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`id`, `role`, `company`, `year_range`, `description`) VALUES
(1, 'Admin Supply Chain & Logistic', 'PT. Bekaert Indonesia', '2014 - 2018', '- Input and manage production data in SAP to support planning requirements.\r\n- Generate production reports using BW Report for supply chain needs.\r\n- Create and maintain SAP master data for supply chain planning.\r\n- Process data required by the supply chain to ensure efficient operations.\r\n- Assist in resolving issue tickets and ensuring smooth processes using BITs.'),
(2, 'PPIC Scheduler & Key User OMP', 'PT. Bekaert Indonesia', '2018 - 2024', '- Ensure the successful go-live of the OMP (Operational Master Planning) application. \r\n- Monitor and control the OMP application to support production planning. \r\n- Set up and maintain master data for OMP and MES (Manufacturing Execution System) to ensure accurate production processes. \r\n- Follow up on shipment disruptions to prevent delays. \r\n- Develop and control machine schedules in accordance with Heijunka principles. \r\n- Create and maintain weekly shipment and sales reports. \r\n- Prepare daily production reports to track progress and performance.'),
(3, 'Logistics Officer', 'PT. Indah Kiat Karawang', '2024 - 2025', '-Use SAP system to check and review outbound delivery planning.\r\n-Book trucks with third-party logistics providers based on delivery needs and schedules.\r\n-Create Freight Orders (FO) for outbound shipments using SAP TMS.\r\n-Display and validate transportation rates directly in SAP TMS to ensure cost alignment and accuracy.\r\n-Coordinate with expedition partners for the execution and delivery of outbound shipments.\r\n-Utilize Yojee application for truck dispatch planning and allocation.\r\n-Ensure smooth outbound flow and resolve planning issues in collaboration with related departments.\r\n-Note: Delivery Note (DN) monitoring is conducted by the assigned expedition'),
(4, 'Logistics Supervisor', 'PT. Indah Kiat Karawang', '2025 - Now', '-Manage Invoice');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `site_title` varchar(50) DEFAULT 'MY.PORTFOLIO',
  `hero_role` varchar(100) DEFAULT 'Creative Dev.',
  `hero_image_url` varchar(255) DEFAULT 'https://cdn3d.iconscout.com/3d/premium/thumb/web-developer-4506461-3738664.png',
  `availability_text` varchar(100) DEFAULT 'AVAILABLE FOR WORK',
  `projects_desc` text DEFAULT NULL,
  `contact_desc` text DEFAULT NULL,
  `projects_limit` int(11) DEFAULT 6,
  `link_github` varchar(255) DEFAULT NULL,
  `link_linkedin` varchar(255) DEFAULT NULL,
  `link_instagram` varchar(255) DEFAULT NULL,
  `link_facebook` varchar(255) DEFAULT NULL,
  `link_youtube` varchar(255) DEFAULT NULL,
  `link_tiktok` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `name`, `bio`, `address`, `whatsapp`, `email`, `site_title`, `hero_role`, `hero_image_url`, `availability_text`, `projects_desc`, `contact_desc`, `projects_limit`, `link_github`, `link_linkedin`, `link_instagram`, `link_facebook`, `link_youtube`, `link_tiktok`) VALUES
(1, 'Akhirudin', 'I am a creative Web Developer with extensive experience in building modular, responsive, and user-friendly web applications. Beyond my primary role, I actively take on freelance projects, ranging from dashboard development and cloud integration to UI/UX optimization.', 'Karawang, Jawa Barat, Indonesia', '6289606357045', 'mohamadakhirudin@aol.com', 'M.Akhirudin', 'Creative Dev.', 'uploads/1764412506_Gemini_Generated_Image_cco3wacco3wacco3.png', 'AVAILABLE FOR WORK (SIDE-JOB)', 'Selected highlights of my work, delivered dynamically from the database.', 'Don\'t hesitate to contact me to discuss your upcoming projects and collaboration opportunities', 6, 'https://github.com/akhirudin08', 'https://www.linkedin.com/in/mohamadakhirudin/', 'https://www.instagram.com/mohamadakhirudin_', 'https://www.facebook.com/mohamadakhirudin', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `details` longtext DEFAULT NULL,
  `display_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `image_url`, `link_url`, `created_at`, `details`, `display_order`) VALUES
(1, 'Container Plan', 'A specialized tool developed to streamline the shipment planning process. By providing a real-time 3D representation of cargo arrangement, this application helps logistics officers maximize container space efficiency, reduce calculation errors, and generate accurate loading reports instantly', 'uploads/1764443075_proj_Screenshot 2025-11-30 020227.png', 'https://akhirudin08.github.io/container-cubix/', '2025-11-29 19:04:35', '1. Project Overview\r\nThe Container Load Planner is a specialized web-based tool engineered to streamline complex shipment planning processes in the logistics sector.\r\n\r\nMaximizing container utilization is critical for cost efficiency in shipping. Traditional methods often rely on rough estimations or 2D drawing tools, which fail to accurately represent vertical space or complex item fitting. This application addresses that gap by providing a real-time 3D representation of cargo arrangement, helping logistics officers maximize space efficiency, drastically reduce calculation errors, and generate accurate loading reports instantly.\r\n\r\n2. The Challenge\r\nLogistics planners often face difficulties when trying to fit various cargo shapes—such as standard boxes mixed with cylindrical items (drums/barrels)—into a fixed container space. Manual calculation using spreadsheets is time-consuming and prone to human error, often leading to underutilized containers (shipping \"air\") or overbooked shipments that don\'t actually fit during loading. The goal was to create a digital solution that allows users to virtually \"try out\" loading scenarios before committing to physical movements.\r\n\r\n3. The Solution & Approach\r\nI developed a single-page web application focusing on an intuitive user experience that merges data entry with immediate visual feedback. The interface is divided into two functional areas:\r\n\r\nInput Control Panel (Left Sidebar): Users first select standard container sizes (e.g., 20\' Standard). Then, they define cargo specifics, inputting dimensions (Length, Width, Height/Diameter), quantity, and crucially, the shape type (Box or Cylindrical/\'Bulat\').\r\n\r\ninteractive 3D Stage (Main View): Utilizing advanced JavaScript 3D rendering libraries, the application instantly visualizes the container wireframe and places the cargo items inside based on the input data.\r\n\r\n4. Key Features Demonstrated\r\nReal-Time 3D Rendering: As soon as materials are added, they appear in the 3D space, allowing instant verification of fit and stacking.\r\n\r\nMulti-Shape Support: Unlike basic planners that only handle boxes, this tool accurately renders cylindrical items (as seen in the screenshots with the green drums), calculating their spatial requirements correctly.\r\n\r\nInteractive Viewing Angles: Users can easily switch between predefined camera views (Top, Side, Front) or rotate the 3D view freely to inspect the load plan from every angle.\r\n\r\nInstant Reporting (PDF Export): A critical business feature that converts the finalized 3D visual plan into a downloadable PDF document, ready to be handed to warehouse loading teams as instructions.\r\n\r\n5. Technical Stack\r\nFrontend Core: HTML5, CSS3 (for responsive layout), Modern JavaScript (ES6+).\r\n\r\n3D Engine: [Three.js / WebGL] (Gunakan Three.js jika kamu memakainya, ini nilai plus besar) for high-performance browser-based 3D graphics.\r\n\r\nPDF Generation: client-side JavaScript libraries for generating downloadable reports.\r\n\r\n6. Conclusion\r\nThe Container Load Planner successfully transforms abstract shipment data into a clear, actionable visual strategy. It is a testament to how creative web development can solve real-world industrial problems, delivering a tool that is both technically sophisticated and highly practical for daily logistics operations.', 1),
(2, 'QR Generator & QR Scan', 'Generator QR Code modern yang memungkinkan penyisipan logo brand langsung ke dalam kode. Dilengkapi fitur scanner terintegrasi dan dapat diinstal instan ke layar HP Android (PWA) untuk akses cepat', 'uploads/1764444199_proj_Screenshot 2025-11-30 021919.png', 'https://akhirudin08.github.io/qr-generator-and-qr-scan/', '2025-11-29 19:23:19', 'Aplikasi web 2-in-1 serbaguna untuk membuat dan memindai QR Code. Fitur unggulannya memungkinkan pengguna menyisipkan logo atau gambar kustom ke tengah QR Code untuk kebutuhan branding. Dibangun dengan teknologi Progressive Web App (PWA), aplikasi ini dapat diinstal langsung ke homescreen Android dengan sekali tekan, memberikan pengalaman layaknya aplikasi native tanpa melalui Play Store', 2),
(3, 'Web Profile Event Organizer', 'Website profil Event Organizer ini dirancang sebagai platform dinamis untuk mempromosikan berbagai layanan acara, mulai dari ulang tahun, pernikahan, gathering perusahaan, hingga konser mini. Dibangun dengan PHP, HTML, CSS (Tailwind), JavaScript, dan MySQL, sistem ini mendukung pengelolaan konten fleksibel, pemesanan online, dan showcase dokumentasi acara secara profesional dan responsif.', 'https://suddenly.akhirudin.com', '', '2025-12-02 14:18:11', 'Proyek ini dikembangkan untuk membantu tim Event Organizer menampilkan portofolio dan layanan secara modular dan mudah dikelola. Backend berbasis PHP dan MySQL memungkinkan admin menambahkan berbagai jenis acara, paket harga, dan dokumentasi. Frontend menggunakan Tailwind CSS dan JavaScript untuk tampilan modern, cepat, dan mobile-friendly.\r\n\r\nFitur Utama:\r\n- Manajemen Proyek Modular: Admin dapat menambah berbagai jenis event (ulang tahun, wedding, corporate, dll) dengan deskripsi, gambar, dan link demo.\r\n- Paket Harga Dinamis: Sistem mendukung banyak kategori paket (Basicâ€“Diamond) yang bisa disesuaikan per jenis acara.\r\n- Form Pemesanan Interaktif: Pengunjung dapat memilih paket dan mengirim permintaan langsung ke tim EO.\r\n- Galeri & Studi Kasus: Menampilkan dokumentasi foto/video dari acara sebelumnya untuk meningkatkan kredibilitas.\r\n- Integrasi Link & Gambar: Setiap proyek bisa ditautkan ke demo live dan dokumentasi visual.\r\n\r\nWebsite ini telah digunakan untuk mempromosikan lebih dari 30 acara dalam 6 bulan, dengan peningkatan engagement dan konversi pemesanan hingga 45%.', 3);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(100) DEFAULT NULL,
  `icon_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `skill_name`, `icon_url`) VALUES
(1, 'SAP ERP', 'https://upload.wikimedia.org/wikipedia/commons/5/59/SAP_2011_logo.svg'),
(2, 'Excel VBA / Macro', 'https://cdn-icons-png.flaticon.com/512/732/732220.png'),
(3, 'Data Analysis', 'https://cdn-icons-png.flaticon.com/512/2920/2920329.png'),
(4, 'OMP', 'https://tse3.mm.bing.net/th/id/OIP.NHBLa9JVBKV_dqnFA66UnQHaHa?pid=ImgDet&w=206&h=206&c=7&dpr=1,1&o=7&rm=3'),
(5, 'MES System', 'https://cdn-icons-png.flaticon.com/512/2881/2881142.png'),
(6, 'HTML5', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg'),
(7, 'CSS3', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg'),
(8, 'JavaScript', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg'),
(9, 'PHP', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg'),
(10, 'MySQL', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg'),
(11, 'Logistics Management', 'https://cdn-icons-png.flaticon.com/512/948/948615.png'),
(12, 'Freight Invoicing', 'https://cdn-icons-png.flaticon.com/512/2910/2910795.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
