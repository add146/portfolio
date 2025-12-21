<?php 
include 'db.php'; 
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = mysqli_query($conn, "SELECT * FROM projects WHERE id=$id");
$project = mysqli_fetch_assoc($query);
if(!$project) { header("Location: index.php"); exit; }
$profile = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profile WHERE id=1"));
$otherProjects = mysqli_query($conn, "SELECT * FROM projects WHERE id != $id ORDER BY display_order ASC LIMIT 3");
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $project['title']; ?> - Case Study</title>
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

    <nav class="fixed top-0 w-full z-50 glass">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold tracking-wider text-purple-600 dark:text-white hover:opacity-80 transition truncate max-w-[200px]">
                <?php echo $profile['site_title']; ?>
            </a>
            <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-600 dark:text-gray-400">
                <a href="index.php" class="hover:text-purple-600 dark:hover:text-white transition">Home</a>
                <a href="index.php#projects" class="hover:text-purple-600 dark:hover:text-white transition text-purple-600 dark:text-white font-bold">Projects</a>
                <a href="index.php#blog" class="hover:text-purple-600 dark:hover:text-white transition">Blog</a>
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
        <article class="max-w-4xl mx-auto">
            <header class="mb-10 text-center md:text-left">
                <div class="inline-block px-3 py-1 rounded-full bg-purple-100 dark:bg-purple-500/10 text-purple-600 dark:text-purple-300 text-xs font-mono mb-4 border border-purple-200 dark:border-purple-500/20">
                    CASE STUDY
                </div>
                <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-6 text-slate-900 dark:text-white">
                    <?php echo $project['title']; ?>
                </h1>
            </header>

            <div class="w-full rounded-2xl overflow-hidden shadow-2xl border border-gray-200 dark:border-white/10 mb-10 bg-white dark:bg-black/50">
                <img src="<?php echo $project['image_url']; ?>" alt="<?php echo $project['title']; ?>" class="w-full h-auto object-cover">
            </div>

            <?php if($project['link_url']): ?>
            <div class="flex justify-center md:justify-start mb-10">
                <a href="<?php echo $project['link_url']; ?>" target="_blank" class="px-8 py-3 bg-slate-900 dark:bg-white text-white dark:text-black rounded-full font-bold hover:bg-purple-600 dark:hover:bg-purple-500 dark:hover:text-white transition shadow-lg flex items-center gap-2 transform hover:-translate-y-1">
                    View Live Demo <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
            <?php endif; ?>

            <div class="prose prose-lg max-w-none text-slate-600 dark:text-gray-300 leading-relaxed whitespace-pre-line text-justify border-t border-gray-200 dark:border-white/10 pt-10">
                <?php echo $project['details']; ?>
            </div>
        </article>
    </main>

    <section class="border-t border-gray-200 dark:border-white/10 bg-gray-100 dark:bg-black/20 py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <h3 class="text-2xl font-bold mb-8 text-center md:text-left text-slate-800 dark:text-white">Other Projects you might like</h3>
            <div class="grid md:grid-cols-3 gap-6">
                <?php while($p = mysqli_fetch_assoc($otherProjects)): ?>
                <div class="glass-card rounded-xl overflow-hidden group hover:border-purple-500 transition duration-300 flex flex-col h-full bg-white dark:bg-transparent shadow-md dark:shadow-none">
                    <a href="project-details.php?id=<?php echo $p['id']; ?>" class="block h-48 overflow-hidden relative">
                        <img src="<?php echo $p['image_url']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                            <span class="text-white font-bold border border-white px-4 py-1 rounded-full text-sm">View Study</span>
                        </div>
                    </a>
                    <div class="p-5 flex-grow">
                        <h4 class="font-bold text-lg mb-2 text-slate-800 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition">
                            <a href="project-details.php?id=<?php echo $p['id']; ?>"><?php echo $p['title']; ?></a>
                        </h4>
                        <p class="text-xs text-slate-500 dark:text-gray-500 line-clamp-2"><?php echo $p['description']; ?></p>
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