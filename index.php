<?php 
include 'db.php'; 
$profile = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profile WHERE id=1"));
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $profile['name']; ?> - Portfolio</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            darkMode: 'class', // Mengaktifkan mode dark via class HTML
        }
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s, color 0.3s; /* Efek transisi halus saat ganti tema */
        }

        /* Background Magis (Hanya muncul di Dark Mode) */
        .dark .magic-bg {
            background: radial-gradient(circle at 50% 50%, rgba(124, 58, 237, 0.15) 0%, rgba(15, 23, 42, 0) 50%);
            position: fixed; inset: 0; z-index: -1;
        }

        /* Glassmorphism Adaptive */
        .glass {
            background: rgba(255, 255, 255, 0.8); /* Light Mode: Putih Transparan */
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        .dark .glass {
            background: rgba(15, 23, 42, 0.8); /* Dark Mode: Gelap Transparan */
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Glass Card Adaptive */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .dark .glass-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: none;
        }

        /* Animasi */
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-20px); } 100% { transform: translateY(0px); } }
        
        .firefly { position: absolute; width: 4px; height: 4px; background: #fbbf24; border-radius: 50%; box-shadow: 0 0 10px #fbbf24; opacity: 0; animation: fly 5s linear infinite; }
        @keyframes fly { 0% { transform: translate(0, 0); opacity: 0; } 50% { opacity: 0.8; } 100% { transform: translate(60px, -100px); opacity: 0; } }

        .text-gradient { background: linear-gradient(to right, #c084fc, #db2777); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="antialiased bg-gray-50 text-slate-800 dark:bg-[#0f172a] dark:text-white selection:bg-purple-500 selection:text-white">

    <div class="magic-bg hidden dark:block"></div> <div id="fireflies-container" class="fixed inset-0 pointer-events-none z-0 hidden dark:block"></div>

    <nav class="fixed w-full z-50 top-0 glass transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center relative">
            
            <div class="text-2xl font-bold tracking-wider text-gradient truncate max-w-[200px]">
                <?php echo $profile['site_title']; ?>
            </div>

            <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-600 dark:text-gray-300">
                <a href="#home" class="hover:text-purple-600 dark:hover:text-white transition">Home</a>
                <a href="#skills" class="hover:text-purple-600 dark:hover:text-white transition">Skills</a>
                <a href="#about" class="hover:text-purple-600 dark:hover:text-white transition">About</a>
                <a href="#projects" class="hover:text-purple-600 dark:hover:text-white transition">Projects</a>
                <a href="#blog" class="hover:text-purple-600 dark:hover:text-white transition">Blog</a>
            </div>

            <div class="flex items-center gap-4">
                <button id="theme-toggle" class="text-gray-500 dark:text-yellow-400 hover:bg-gray-200 dark:hover:bg-white/10 p-2 rounded-full transition focus:outline-none">
                    <i class="fas fa-sun hidden dark:block"></i> <i class="fas fa-moon block dark:hidden"></i> </button>

                <a href="admin.php" class="text-xs text-gray-600 hover:text-purple-400 dark:text-gray-400" title="Login Admin">
                    <i class="fas fa-lock"></i>
                </a>
                
                <button onclick="toggleMobileMenu()" class="md:hidden text-gray-800 dark:text-white focus:outline-none p-2">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden absolute top-20 left-0 w-full bg-white dark:bg-[#0f172a] border-b border-gray-200 dark:border-white/10 shadow-2xl flex flex-col z-40">
            <a href="#home" class="py-4 text-center text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-white/5 border-b border-gray-100 dark:border-white/5" onclick="toggleMobileMenu()">Home</a>
            <a href="#skills" class="py-4 text-center text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-white/5 border-b border-gray-100 dark:border-white/5" onclick="toggleMobileMenu()">Skills</a>
            <a href="#about" class="py-4 text-center text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-white/5 border-b border-gray-100 dark:border-white/5" onclick="toggleMobileMenu()">About</a>
            <a href="#projects" class="py-4 text-center text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-white/5 border-b border-gray-100 dark:border-white/5" onclick="toggleMobileMenu()">Projects</a>
            <a href="#blog" class="py-4 text-center text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-white/5" onclick="toggleMobileMenu()">Blog</a>
        </div>
    </nav>

    <section id="home" class="relative min-h-screen flex items-center pt-24 px-6">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center w-full z-10">
            <div class="space-y-6 order-2 lg:order-1 text-center lg:text-left pt-10 lg:pt-0">
                <div class="inline-block px-4 py-1 rounded-full bg-purple-100 dark:bg-purple-900/30 border border-purple-200 dark:border-purple-500/30 text-purple-600 dark:text-purple-300 text-xs font-bold tracking-widest uppercase mb-2 shadow-sm dark:shadow-none">
                    <?php echo !empty($profile['availability_text']) ? $profile['availability_text'] : 'AVAILABLE'; ?>
                </div>
                <h1 class="text-5xl lg:text-7xl font-bold leading-tight text-slate-800 dark:text-white">
                    Hi, I'm <?php echo explode(' ', $profile['name'])[0]; ?> <br>
                    <span class="text-gradient"><?php echo $profile['hero_role']; ?></span>
                </h1>
                <p class="text-slate-600 dark:text-gray-400 max-w-lg text-lg leading-relaxed whitespace-pre-line mx-auto lg:mx-0">
                    <?php echo nl2br($profile['bio']); ?>
                </p>
                <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-4">
                    <a href="#projects" class="px-8 py-3 bg-slate-900 dark:bg-white text-white dark:text-black font-bold rounded-full hover:bg-purple-600 dark:hover:bg-gray-200 transition transform hover:-translate-y-1 shadow-lg">View Projects</a>
                    <a href="https://wa.me/<?php echo $profile['whatsapp']; ?>" target="_blank" class="px-8 py-3 glass rounded-full hover:bg-gray-200 dark:hover:bg-white/10 transition flex items-center gap-2 text-slate-700 dark:text-white border border-gray-200 dark:border-white/10"><i class="fab fa-whatsapp"></i> Contact Me</a>
                </div>
                <div class="flex justify-center lg:justify-start items-center gap-2 text-slate-500 dark:text-gray-500 text-sm mt-8">
                    <i class="fas fa-map-marker-alt text-purple-500"></i> <?php echo $profile['address']; ?>
                </div>
            </div>
            
            <div class="relative order-1 lg:order-2 flex justify-center">
                <div class="absolute inset-0 bg-purple-600/30 blur-[100px] rounded-full animate-pulse hidden dark:block"></div>
                <img src="<?php echo $profile['hero_image_url']; ?>" alt="Hero Image" class="relative w-[300px] lg:w-[500px] object-contain animate-float drop-shadow-2xl z-10">
            </div>
        </div>
    </section>

    <section id="skills" class="py-20 relative z-10">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-3xl font-bold mb-10 text-center text-slate-800 dark:text-white">My <span class="text-gradient">Weaponry</span></h2>
            <div class="flex flex-wrap justify-center gap-6">
                <?php 
                $skills = mysqli_query($conn, "SELECT * FROM skills");
                while($s = mysqli_fetch_assoc($skills)): 
                ?>
                <div class="glass-card px-6 py-4 rounded-2xl flex items-center gap-4 hover:border-purple-500 transition-all duration-300 hover:transform hover:-translate-y-1 cursor-default group">
                    <?php if($s['icon_url']): ?>
                        <img src="<?php echo $s['icon_url']; ?>" class="w-8 h-8 group-hover:scale-110 transition">
                    <?php else: ?>
                        <i class="fas fa-code text-purple-400 text-xl"></i>
                    <?php endif; ?>
                    <span class="font-bold text-slate-700 dark:text-gray-200"><?php echo $s['skill_name']; ?></span>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <section id="about" class="py-20 px-6 bg-gray-100 dark:bg-black/20">
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-16">
            
            <div>
                <h3 class="text-2xl font-bold mb-8 flex items-center gap-3 text-purple-600 dark:text-purple-300">
                    <i class="fas fa-graduation-cap bg-purple-200 dark:bg-purple-900/30 p-3 rounded-lg"></i> Education
                </h3>
                <div class="space-y-8 pl-4 border-l border-gray-300 dark:border-white/10">
                    <?php 
                    $edu = mysqli_query($conn, "SELECT * FROM education ORDER BY id DESC");
                    while($e = mysqli_fetch_assoc($edu)): 
                    ?>
                    <div class="relative pl-8 group">
                        <div class="absolute -left-[5px] top-2 w-2.5 h-2.5 bg-purple-500 rounded-full group-hover:bg-pink-500 transition"></div>
                        <h4 class="text-xl font-bold text-slate-800 dark:text-white"><?php echo $e['school_name']; ?></h4>
                        <div class="text-sm text-purple-600 dark:text-purple-400 font-mono mb-2"><?php echo $e['year_range']; ?></div>
                        <p class="text-slate-600 dark:text-gray-400"><?php echo $e['degree']; ?></p>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div>
                <h3 class="text-2xl font-bold mb-8 flex items-center gap-3 text-purple-600 dark:text-purple-300">
                    <i class="fas fa-briefcase bg-purple-200 dark:bg-purple-900/30 p-3 rounded-lg"></i> Experience
                </h3>
                <div class="space-y-8 pl-4 border-l border-gray-300 dark:border-white/10">
                    <?php 
                    $exp = mysqli_query($conn, "SELECT * FROM experience ORDER BY id DESC");
                    while($x = mysqli_fetch_assoc($exp)): 
                    ?>
                    <div class="relative pl-8 group">
                        <div class="absolute -left-[5px] top-2 w-2.5 h-2.5 bg-purple-500 rounded-full group-hover:bg-pink-500 transition"></div>
                        <h4 class="text-xl font-bold text-slate-800 dark:text-white"><?php echo $x['role']; ?></h4>
                        <div class="text-sm text-purple-600 dark:text-purple-400 font-mono mb-1"><?php echo $x['company']; ?> | <?php echo $x['year_range']; ?></div>
                        <div class="text-slate-600 dark:text-gray-400 text-sm leading-relaxed whitespace-pre-line"><?php echo nl2br($x['description']); ?></div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>

        </div>
    </section>

    <section id="projects" class="py-24 px-6 max-w-7xl mx-auto">
        <div class="flex flex-col items-center mb-16 text-center">
            <h2 class="text-4xl font-bold mb-4 text-slate-800 dark:text-white">Featured <span class="text-gradient">Projects</span></h2>
            <p class="text-slate-600 dark:text-gray-400 max-w-2xl"><?php echo !empty($profile['projects_desc']) ? $profile['projects_desc'] : 'Kumpulan hasil karya terbaik saya.'; ?></p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php 
            $limit = !empty($profile['projects_limit']) ? $profile['projects_limit'] : 6;
            $proj = mysqli_query($conn, "SELECT * FROM projects ORDER BY display_order ASC LIMIT $limit"); 
            while($p = mysqli_fetch_assoc($proj)): 
            ?>
            <div class="glass-card rounded-2xl overflow-hidden group hover:border-purple-500 transition duration-500 flex flex-col h-full bg-white dark:bg-transparent shadow-lg dark:shadow-none">
                <div class="relative h-56 overflow-hidden flex-shrink-0">
                    <img src="<?php echo $p['image_url']; ?>" alt="<?php echo $p['title']; ?>" 
                         class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    
                    <div class="absolute inset-0 bg-black/80 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col items-center justify-center gap-3">
                        <a href="project-details.php?id=<?php echo $p['id']; ?>" class="px-6 py-2 border border-purple-500 text-purple-400 rounded-full text-sm font-bold hover:bg-purple-500 hover:text-white transition transform translate-y-4 group-hover:translate-y-0 duration-300">
                            Read Study
                        </a>
                        <?php if(!empty($p['link_url'])): ?>
                            <a href="<?php echo $p['link_url']; ?>" target="_blank" class="px-6 py-2 bg-white text-black rounded-full text-sm font-bold hover:bg-gray-200 transition transform translate-y-4 group-hover:translate-y-0 duration-300 delay-75">
                                Live Demo
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="p-6 flex-grow flex flex-col">
                    <h3 class="text-xl font-bold mb-2 text-slate-800 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition"><?php echo $p['title']; ?></h3>
                    <div class="text-slate-600 dark:text-gray-400 text-sm line-clamp-3 leading-relaxed whitespace-pre-line flex-grow"><?php echo nl2br($p['description']); ?></div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </section>

    <section id="blog" class="py-24 px-6 max-w-7xl mx-auto bg-gray-100 dark:bg-black/20">
        <h2 class="text-4xl font-bold mb-12 text-center text-slate-800 dark:text-white">Latest <span class="text-gradient">Articles</span></h2>
        
        <div class="grid md:grid-cols-3 gap-8">
            <?php 
            $blogs = mysqli_query($conn, "SELECT * FROM articles ORDER BY created_at DESC LIMIT 3"); 
            while($b = mysqli_fetch_assoc($blogs)): 
            ?>
            <div class="glass-card rounded-xl overflow-hidden hover:-translate-y-2 transition duration-300 group bg-white dark:bg-transparent shadow-md dark:shadow-none">
                <?php if($b['image_url']): ?>
                    <div class="h-48 overflow-hidden">
                        <img src="<?php echo $b['image_url']; ?>" class="h-full w-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                <?php endif; ?>
                <div class="p-6">
                    <div class="text-xs text-purple-600 dark:text-purple-400 mb-2 font-mono"><?php echo date('d M Y', strtotime($b['created_at'])); ?></div>
                    <h3 class="text-xl font-bold mb-2 line-clamp-2 text-slate-800 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition"><?php echo $b['title']; ?></h3>
                    <a href="article.php?id=<?php echo $b['id']; ?>" class="text-sm text-slate-500 dark:text-gray-400 hover:text-purple-600 dark:hover:text-white inline-flex items-center gap-1 transition">
                        Read More <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </section>

    <footer class="border-t border-gray-200 dark:border-white/5 bg-white dark:bg-black/40 pt-16 pb-8 text-center relative z-10 transition-colors">
        <div class="max-w-4xl mx-auto px-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-slate-800 dark:text-white">Ready to collaborate?</h2>
            <p class="text-slate-600 dark:text-gray-400 mb-6"><?php echo !empty($profile['contact_desc']) ? $profile['contact_desc'] : 'Hubungi saya untuk diskusi lebih lanjut.'; ?></p>
            
            <a href="mailto:<?php echo $profile['email']; ?>" class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-white border-b border-purple-400 pb-1 text-lg inline-block mb-10 font-bold">
                <?php echo $profile['email']; ?>
            </a>

            <div class="flex justify-center gap-6 mt-4 text-2xl flex-wrap">
                <?php if(!empty($profile['link_github'])): ?>
                    <a href="<?php echo $profile['link_github']; ?>" target="_blank" class="text-gray-400 hover:text-slate-900 dark:hover:text-white transition transform hover:scale-110" title="GitHub"><i class="fab fa-github"></i></a>
                <?php endif; ?>

                <?php if(!empty($profile['link_linkedin'])): ?>
                    <a href="<?php echo $profile['link_linkedin']; ?>" target="_blank" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition transform hover:scale-110" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                <?php endif; ?>

                <?php if(!empty($profile['link_instagram'])): ?>
                    <a href="<?php echo $profile['link_instagram']; ?>" target="_blank" class="text-gray-400 hover:text-pink-600 dark:hover:text-pink-500 transition transform hover:scale-110" title="Instagram"><i class="fab fa-instagram"></i></a>
                <?php endif; ?>

                <?php if(!empty($profile['link_facebook'])): ?>
                    <a href="<?php echo $profile['link_facebook']; ?>" target="_blank" class="text-gray-400 hover:text-blue-700 dark:hover:text-blue-600 transition transform hover:scale-110" title="Facebook"><i class="fab fa-facebook"></i></a>
                <?php endif; ?>

                <?php if(!empty($profile['link_youtube'])): ?>
                    <a href="<?php echo $profile['link_youtube']; ?>" target="_blank" class="text-gray-400 hover:text-red-600 dark:hover:text-red-500 transition transform hover:scale-110" title="YouTube"><i class="fab fa-youtube"></i></a>
                <?php endif; ?>

                <?php if(!empty($profile['link_tiktok'])): ?>
                    <a href="<?php echo $profile['link_tiktok']; ?>" target="_blank" class="text-gray-400 hover:text-black dark:hover:text-white transition transform hover:scale-110" title="TikTok"><i class="fab fa-tiktok"></i></a>
                <?php endif; ?>
            </div>
        </div>
        <div class="text-slate-500 dark:text-gray-600 text-sm mt-8 border-t border-gray-200 dark:border-white/5 pt-8 w-3/4 mx-auto">&copy; 2025 <?php echo $profile['name']; ?>. Made with <i class="fas fa-heart text-red-500"></i> & PHP Native.</div>
    </footer>

    <a href="https://wa.me/<?php echo $profile['whatsapp']; ?>" target="_blank" 
       class="fixed bottom-6 right-6 z-[9999] bg-green-500 hover:bg-green-600 w-14 h-14 rounded-full flex items-center justify-center text-white shadow-[0_0_20px_rgba(34,197,94,0.5)] transition-all hover:-translate-y-2 animate-bounce">
        <i class="fab fa-whatsapp text-3xl"></i>
    </a>

    <script>
        // Toggle Mobile Menu
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Dark Mode Logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const sunIcon = themeToggleBtn.querySelector('.fa-sun');
        const moonIcon = themeToggleBtn.querySelector('.fa-moon');

        themeToggleBtn.addEventListener('click', function() {
            // Toggle Icons
            sunIcon.classList.toggle('hidden');
            sunIcon.classList.toggle('block');
            moonIcon.classList.toggle('hidden');
            moonIcon.classList.toggle('block');

            // Toggle HTML Class
            if (localStorage.theme === 'dark') {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        });

        // Fireflies
        const container = document.getElementById('fireflies-container');
        if(container) {
            for (let i = 0; i < 20; i++) {
                const div = document.createElement('div');
                div.classList.add('firefly');
                div.style.left = Math.random() * 100 + 'vw';
                div.style.top = Math.random() * 100 + 'vh';
                div.style.animationDuration = (Math.random() * 10 + 10) + 's';
                div.style.animationDelay = Math.random() * 5 + 's';
                container.appendChild(div);
            }
        }
    </script>
</body>
</html>