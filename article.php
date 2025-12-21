<?php 
include 'db.php'; 
if (!isset($_GET['id']) || empty($_GET['id'])) { header("Location: index.php"); exit; }
$id = (int)$_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM articles WHERE id=$id");
$art = mysqli_fetch_assoc($query);
if(!$art) { header("Location: index.php"); exit; }

$profile = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profile WHERE id=1"));
// Ambil artikel lain untuk "Read Next"
$otherArticles = mysqli_query($conn, "SELECT * FROM articles WHERE id != $id ORDER BY created_at DESC LIMIT 3");
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title><?php echo $art['title']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; transition: background-color 0.3s, color 0.3s; }
        .glass { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,0.05); }
        .dark .glass { background: rgba(15, 23, 42, 0.95); border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .glass-card { background: rgba(255, 255, 255, 0.7); border: 1px solid rgba(0, 0, 0, 0.05); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .dark .glass-card { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.05); box-shadow: none; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col bg-gray-50 text-slate-800 dark:bg-[#0f172a] dark:text-white">

    <nav class="fixed top-0 w-full z-50 glass transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center relative">
            <a href="index.php" class="text-2xl font-bold tracking-wider text-purple-600 dark:text-white hover:opacity-80 transition truncate max-w-[200px]">
                <?php echo $profile['site_title']; ?>
            </a>
            <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-600 dark:text-gray-400">
                <a href="index.php" class="hover:text-purple-600 dark:hover:text-white transition">Home</a>
                <a href="index.php#projects" class="hover:text-purple-600 dark:hover:text-white transition">Projects</a>
                <a href="index.php#blog" class="hover:text-purple-600 dark:hover:text-white transition text-purple-600 dark:text-white font-bold">Blog</a>
            </div>
            <div class="flex items-center gap-4">
                <button id="theme-toggle" class="text-gray-500 dark:text-yellow-400 hover:bg-gray-200 dark:hover:bg-white/10 p-2 rounded-full transition focus:outline-none">
                    <i class="fas fa-sun hidden dark:block"></i>
                    <i class="fas fa-moon block dark:hidden"></i>
                </button>
                <a href="index.php" class="text-xs text-gray-500 hover:text-purple-600 dark:text-gray-400 dark:hover:text-white border border-gray-300 dark:border-gray-600 px-3 py-1 rounded-full transition">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-grow pt-28 pb-20 px-6">
        <article class="max-w-3xl mx-auto">
            <header class="mb-8 text-center md:text-left">
                <div class="inline-block px-3 py-1 rounded-full bg-purple-100 dark:bg-purple-500/10 text-purple-600 dark:text-purple-300 text-xs font-mono mb-4 border border-purple-200 dark:border-purple-500/20">
                    <i class="far fa-calendar-alt mr-2"></i> <?php echo date('d F Y', strtotime($art['created_at'])); ?>
                </div>
                <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-6 text-slate-900 dark:text-white">
                    <?php echo $art['title']; ?>
                </h1>
            </header>

            <?php if($art['image_url']): ?>
                <div class="w-full rounded-2xl overflow-hidden shadow-2xl border border-gray-200 dark:border-white/5 mb-10 group bg-white dark:bg-black/50">
                    <img src="<?php echo $art['image_url']; ?>" alt="<?php echo $art['title']; ?>" class="w-full h-auto object-cover transform transition duration-700 hover:scale-105">
                </div>
            <?php endif; ?>

            <div class="prose prose-lg max-w-none text-slate-600 dark:text-gray-300 leading-relaxed whitespace-pre-line text-justify">
                <?php echo $art['content']; ?>
            </div>
        </article>
    </main>

    <section class="border-t border-gray-200 dark:border-white/10 bg-gray-100 dark:bg-black/20 py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <h3 class="text-2xl font-bold mb-8 text-center md:text-left text-slate-800 dark:text-white">Read Next</h3>
            <div class="grid md:grid-cols-3 gap-6">
                <?php while($b = mysqli_fetch_assoc($otherArticles)): ?>
                <div class="glass-card rounded-xl overflow-hidden hover:-translate-y-2 transition duration-300 group bg-white dark:bg-transparent shadow-md dark:shadow-none">
                    <?php if($b['image_url']): ?>
                        <div class="h-48 overflow-hidden">
                            <img src="<?php echo $b['image_url']; ?>" class="h-full w-full object-cover group-hover:scale-110 transition duration-500">
                        </div>
                    <?php endif; ?>
                    <div class="p-6">
                        <div class="text-xs text-purple-600 dark:text-purple-400 mb-2 font-mono"><?php echo date('d M Y', strtotime($b['created_at'])); ?></div>
                        <h3 class="text-lg font-bold mb-2 line-clamp-2 text-slate-800 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition"><?php echo $b['title']; ?></h3>
                        <a href="article.php?id=<?php echo $b['id']; ?>" class="text-sm text-slate-500 dark:text-gray-400 hover:text-purple-600 dark:hover:text-white inline-flex items-center gap-1 transition">Read More &rarr;</a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <footer class="border-t border-gray-200 dark:border-white/5 bg-white dark:bg-black/40 pt-16 pb-8 text-center transition-colors">
        <div class="max-w-4xl mx-auto px-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 text-slate-800 dark:text-white">Ready to collaborate?</h2>
            <p class="text-slate-600 dark:text-gray-400 mb-6"><?php echo !empty($profile['contact_desc']) ? $profile['contact_desc'] : 'Hubungi saya untuk diskusi lebih lanjut.'; ?></p>
            <a href="mailto:<?php echo $profile['email']; ?>" class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-white border-b border-purple-400 pb-1 text-lg font-bold"><?php echo $profile['email']; ?></a>
        </div>
        <div class="text-slate-500 dark:text-gray-600 text-sm mt-8 border-t border-gray-200 dark:border-white/5 pt-8 w-3/4 mx-auto">&copy; 2025 <?php echo $profile['name']; ?>. Made with <i class="fas fa-heart text-red-500"></i> & PHP Native.</div>
    </footer>

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const sunIcon = themeToggleBtn.querySelector('.fa-sun');
        const moonIcon = themeToggleBtn.querySelector('.fa-moon');
        themeToggleBtn.addEventListener('click', function() {
            sunIcon.classList.toggle('hidden'); sunIcon.classList.toggle('block');
            moonIcon.classList.toggle('hidden'); moonIcon.classList.toggle('block');
            if (localStorage.theme === 'dark') { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } 
            else { document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; }
        });
    </script>
</body>
</html>