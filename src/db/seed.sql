-- Seed data for Portfolio D1 database
-- Migrated from existing MySQL data

-- Admin user (password: admin - you should change this!)
-- Hash generated with bcrypt, rounds=10
INSERT INTO admin_users (id, username, password) VALUES
(1, 'admin', '$2y$10$M57lyL7cqf7Pq9t3dkE.juK2RktTIiqG0JdUZio0/F9NpLstMyw1W');

-- Profile data
INSERT INTO profile (id, name, bio, address, whatsapp, email, site_title, hero_role, hero_image_url, availability_text, projects_desc, contact_desc, projects_limit, link_github, link_linkedin, link_instagram, link_facebook, link_youtube, link_tiktok) VALUES
(1, 'Akhirudin', 'I am a creative Web Developer with extensive experience in building modular, responsive, and user-friendly web applications. Beyond my primary role, I actively take on freelance projects, ranging from dashboard development and cloud integration to UI/UX optimization.', 'Karawang, Jawa Barat, Indonesia', '6289606357045', 'mohamadakhirudin@aol.com', 'M.Akhirudin', 'Creative Dev.', 'https://portfolio-uploads.YOUR_ACCOUNT.r2.dev/hero.png', 'AVAILABLE FOR WORK (SIDE-JOB)', 'Selected highlights of my work, delivered dynamically from the database.', 'Don''t hesitate to contact me to discuss your upcoming projects and collaboration opportunities', 6, 'https://github.com/akhirudin08', 'https://www.linkedin.com/in/mohamadakhirudin/', 'https://www.instagram.com/mohamadakhirudin_', 'https://www.facebook.com/mohamadakhirudin', '', '');

-- Education data
INSERT INTO education (id, school_name, degree, year_range) VALUES
(1, 'Universitas Buana Perjuangan Karawang', 'Sistem Informasi/S. Kom', '2019');

-- Experience data
INSERT INTO experience (id, role, company, year_range, description) VALUES
(1, 'Admin Supply Chain & Logistic', 'PT. Bekaert Indonesia', '2014 - 2018', '- Input and manage production data in SAP to support planning requirements.
- Generate production reports using BW Report for supply chain needs.
- Create and maintain SAP master data for supply chain planning.
- Process data required by the supply chain to ensure efficient operations.
- Assist in resolving issue tickets and ensuring smooth processes using BITs.'),
(2, 'PPIC Scheduler & Key User OMP', 'PT. Bekaert Indonesia', '2018 - 2024', '- Ensure the successful go-live of the OMP (Operational Master Planning) application. 
- Monitor and control the OMP application to support production planning. 
- Set up and maintain master data for OMP and MES (Manufacturing Execution System) to ensure accurate production processes. 
- Follow up on shipment disruptions to prevent delays. 
- Develop and control machine schedules in accordance with Heijunka principles. 
- Create and maintain weekly shipment and sales reports. 
- Prepare daily production reports to track progress and performance.'),
(3, 'Logistics Officer', 'PT. Indah Kiat Karawang', '2024 - 2025', '-Use SAP system to check and review outbound delivery planning.
-Book trucks with third-party logistics providers based on delivery needs and schedules.
-Create Freight Orders (FO) for outbound shipments using SAP TMS.
-Display and validate transportation rates directly in SAP TMS to ensure cost alignment and accuracy.
-Coordinate with expedition partners for the execution and delivery of outbound shipments.
-Utilize Yojee application for truck dispatch planning and allocation.
-Ensure smooth outbound flow and resolve planning issues in collaboration with related departments.'),
(4, 'Logistics Supervisor', 'PT. Indah Kiat Karawang', '2025 - Now', '-Manage Invoice');

-- Skills data
INSERT INTO skills (id, skill_name, icon_url) VALUES
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

-- Projects data
INSERT INTO projects (id, title, description, image_url, link_url, created_at, details, display_order) VALUES
(1, 'Container Plan', 'A specialized tool developed to streamline the shipment planning process. By providing a real-time 3D representation of cargo arrangement, this application helps logistics officers maximize container space efficiency, reduce calculation errors, and generate accurate loading reports instantly', 'https://portfolio-uploads.YOUR_ACCOUNT.r2.dev/proj_container.png', 'https://akhirudin08.github.io/container-cubix/', '2025-11-29 19:04:35', '1. Project Overview
The Container Load Planner is a specialized web-based tool engineered to streamline complex shipment planning processes in the logistics sector.

Maximizing container utilization is critical for cost efficiency in shipping. Traditional methods often rely on rough estimations or 2D drawing tools, which fail to accurately represent vertical space or complex item fitting. This application addresses that gap by providing a real-time 3D representation of cargo arrangement, helping logistics officers maximize space efficiency, drastically reduce calculation errors, and generate accurate loading reports instantly.

2. The Challenge
Logistics planners often face difficulties when trying to fit various cargo shapes—such as standard boxes mixed with cylindrical items (drums/barrels)—into a fixed container space.

3. The Solution & Approach
I developed a single-page web application focusing on an intuitive user experience that merges data entry with immediate visual feedback.

4. Key Features Demonstrated
Real-Time 3D Rendering, Multi-Shape Support, Interactive Viewing Angles, Instant Reporting (PDF Export).

5. Technical Stack
Frontend Core: HTML5, CSS3, Modern JavaScript (ES6+).
3D Engine: Three.js / WebGL for high-performance browser-based 3D graphics.
PDF Generation: client-side JavaScript libraries.

6. Conclusion
The Container Load Planner successfully transforms abstract shipment data into a clear, actionable visual strategy.', 1),

(2, 'QR Generator & QR Scan', 'Generator QR Code modern yang memungkinkan penyisipan logo brand langsung ke dalam kode. Dilengkapi fitur scanner terintegrasi dan dapat diinstal instan ke layar HP Android (PWA) untuk akses cepat', 'https://portfolio-uploads.YOUR_ACCOUNT.r2.dev/proj_qr.png', 'https://akhirudin08.github.io/qr-generator-and-qr-scan/', '2025-11-29 19:23:19', 'Aplikasi web 2-in-1 serbaguna untuk membuat dan memindai QR Code. Fitur unggulannya memungkinkan pengguna menyisipkan logo atau gambar kustom ke tengah QR Code untuk kebutuhan branding. Dibangun dengan teknologi Progressive Web App (PWA), aplikasi ini dapat diinstal langsung ke homescreen Android dengan sekali tekan, memberikan pengalaman layaknya aplikasi native tanpa melalui Play Store', 2),

(3, 'Web Profile Event Organizer', 'Website profil Event Organizer ini dirancang sebagai platform dinamis untuk mempromosikan berbagai layanan acara, mulai dari ulang tahun, pernikahan, gathering perusahaan, hingga konser mini.', 'https://suddenly.akhirudin.com', '', '2025-12-02 14:18:11', 'Proyek ini dikembangkan untuk membantu tim Event Organizer menampilkan portofolio dan layanan secara modular dan mudah dikelola. Backend berbasis PHP dan MySQL memungkinkan admin menambahkan berbagai jenis acara, paket harga, dan dokumentasi. Frontend menggunakan Tailwind CSS dan JavaScript untuk tampilan modern, cepat, dan mobile-friendly.

Fitur Utama:
- Manajemen Proyek Modular
- Paket Harga Dinamis
- Form Pemesanan Interaktif
- Galeri & Studi Kasus
- Integrasi Link & Gambar', 3);
