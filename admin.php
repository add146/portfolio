<?php 
session_start(); 
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php"); exit;
}
include 'db.php'; 

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'profile';
$editId = isset($_GET['edit']) ? $_GET['edit'] : null;
$editData = null;

if ($editId) {
    // Logic ambil data edit
    if ($tab == 'experience') $editData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM experience WHERE id=$editId"));
    if ($tab == 'education') $editData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM education WHERE id=$editId"));
    if ($tab == 'skills') $editData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM skills WHERE id=$editId"));
    if ($tab == 'projects') $editData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM projects WHERE id=$editId"));
    if ($tab == 'blog') $editData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM articles WHERE id=$editId"));
}
$profileData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profile WHERE id=1"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex min-h-screen">

    <aside class="w-64 bg-gray-900 text-white flex flex-col fixed h-full overflow-y-auto z-10">
        <div class="p-6 text-2xl font-bold border-b border-gray-700">My Admin</div>
        <div class="p-4 text-xs text-gray-400">Halo, <?php echo $_SESSION['admin_name']; ?></div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="?tab=profile" class="block p-3 rounded hover:bg-gray-700 <?php echo $tab=='profile'?'bg-blue-600':''; ?>"><i class="fas fa-user w-6"></i> Profil & Sosmed</a>
            <a href="?tab=experience" class="block p-3 rounded hover:bg-gray-700 <?php echo $tab=='experience'?'bg-blue-600':''; ?>"><i class="fas fa-briefcase w-6"></i> Pengalaman</a>
            <a href="?tab=education" class="block p-3 rounded hover:bg-gray-700 <?php echo $tab=='education'?'bg-blue-600':''; ?>"><i class="fas fa-graduation-cap w-6"></i> Pendidikan</a>
            <a href="?tab=skills" class="block p-3 rounded hover:bg-gray-700 <?php echo $tab=='skills'?'bg-blue-600':''; ?>"><i class="fas fa-code w-6"></i> Skills</a>
            <a href="?tab=projects" class="block p-3 rounded hover:bg-gray-700 <?php echo $tab=='projects'?'bg-blue-600':''; ?>"><i class="fas fa-layer-group w-6"></i> Projects</a>
            <a href="?tab=blog" class="block p-3 rounded hover:bg-gray-700 <?php echo $tab=='blog'?'bg-blue-600':''; ?>"><i class="fas fa-newspaper w-6"></i> Blog / Artikel</a>
            
            <hr class="border-gray-700 my-4">
            <a href="index.php" target="_blank" class="block p-3 rounded text-green-400 hover:bg-gray-700 mt-10"><i class="fas fa-eye w-6"></i> Lihat Web</a>
            <a href="logout.php" class="block p-3 rounded text-red-400 hover:bg-gray-700" onclick="return confirm('Yakin ingin keluar?')"><i class="fas fa-sign-out-alt w-6"></i> Logout</a>
        </nav>
    </aside>

    <main class="flex-1 p-10 ml-64">
        
        <?php if($tab == 'profile'): ?>
            <h2 class="text-3xl font-bold mb-6">Edit Profil & Tampilan Utama</h2>
            
            <form action="process.php" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md space-y-6 max-w-3xl border-l-4 border-blue-500">
                <input type="hidden" name="action" value="update_profile">
                
                <div class="space-y-4 pb-6 border-b">
                    <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">1. Tampilan Halaman Depan (Hero)</h3>
                    <div class="grid grid-cols-2 gap-4">
                         <div>
                            <label class="block font-bold mb-1 text-sm text-gray-600">Judul Website</label>
                            <input type="text" name="site_title" value="<?php echo $profileData['site_title']; ?>" class="w-full border p-2 rounded bg-gray-50">
                        </div>
                         <div>
                            <label class="block font-bold mb-1 text-sm text-gray-600">Role Utama</label>
                            <input type="text" name="hero_role" value="<?php echo $profileData['hero_role']; ?>" class="w-full border p-2 rounded bg-gray-50">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-sm text-gray-600">Teks Badge Status</label>
                            <input type="text" name="availability_text" value="<?php echo $profileData['availability_text']; ?>" class="w-full border p-2 rounded bg-gray-50">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-sm text-gray-600">Limit Project</label>
                            <input type="number" name="projects_limit" value="<?php echo !empty($profileData['projects_limit']) ? $profileData['projects_limit'] : 6; ?>" class="w-full border p-2 rounded bg-gray-50">
                        </div>
                    </div>
                     <div class="bg-gray-50 p-4 rounded border border-dashed border-gray-400 mt-2">
                        <label class="block font-bold mb-2 text-sm text-gray-600">Gambar 3D Utama</label>
                        <?php if($profileData['hero_image_url']): ?>
                            <img src="<?php echo $profileData['hero_image_url']; ?>" class="h-16 mb-2">
                        <?php endif; ?>
                        <input type="file" name="hero_image_file" class="w-full text-sm">
                        <input type="hidden" name="old_hero_image" value="<?php echo $profileData['hero_image_url']; ?>">
                        <input type="text" name="hero_image_url_text" placeholder="Atau URL..." class="w-full border p-1 mt-2 text-sm">
                    </div>
                </div>

                <div class="space-y-4 pb-6 border-b">
                     <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">2. Informasi Pribadi</h3>
                    <div><label class="block font-bold mb-1 text-sm text-gray-600">Nama Lengkap</label><input type="text" name="name" value="<?php echo $profileData['name']; ?>" class="w-full border p-2 rounded"></div>
                    <div><label class="block font-bold mb-1 text-sm text-gray-600">Bio Singkat</label><textarea name="bio" class="w-full border p-2 rounded h-24"><?php echo $profileData['bio']; ?></textarea></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block font-bold mb-1 text-sm text-gray-600">Alamat</label><input type="text" name="address" value="<?php echo $profileData['address']; ?>" class="w-full border p-2 rounded"></div>
                        <div><label class="block font-bold mb-1 text-sm text-gray-600">WhatsApp</label><input type="number" name="whatsapp" value="<?php echo $profileData['whatsapp']; ?>" class="w-full border p-2 rounded"></div>
                    </div>
                    <div><label class="block font-bold mb-1 text-sm text-gray-600">Email</label><input type="email" name="email" value="<?php echo $profileData['email']; ?>" class="w-full border p-2 rounded"></div>
                </div>

                <div class="space-y-4 pb-6 border-b">
                     <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">3. Social Media Link</h3>
                     <div class="grid grid-cols-2 gap-4">
                        <input name="link_github" value="<?php echo $profileData['link_github']; ?>" class="border p-2 rounded" placeholder="GitHub URL">
                        <input name="link_linkedin" value="<?php echo $profileData['link_linkedin']; ?>" class="border p-2 rounded" placeholder="LinkedIn URL">
                        <input name="link_instagram" value="<?php echo $profileData['link_instagram']; ?>" class="border p-2 rounded" placeholder="Instagram URL">
                        <input name="link_facebook" value="<?php echo $profileData['link_facebook']; ?>" class="border p-2 rounded" placeholder="Facebook URL">
                        <input name="link_youtube" value="<?php echo $profileData['link_youtube']; ?>" class="border p-2 rounded" placeholder="YouTube URL (Baru)">
                        <input name="link_tiktok" value="<?php echo $profileData['link_tiktok']; ?>" class="border p-2 rounded" placeholder="TikTok URL (Baru)">
                     </div>
                </div>

                <div class="space-y-4">
                     <h3 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">4. Teks Lainnya</h3>
                    <div><label class="block font-bold mb-1 text-sm text-gray-600">Deskripsi Project</label><textarea name="projects_desc" class="w-full border p-2 rounded h-20"><?php echo $profileData['projects_desc']; ?></textarea></div>
                    <div><label class="block font-bold mb-1 text-sm text-gray-600">Deskripsi Kontak</label><textarea name="contact_desc" class="w-full border p-2 rounded h-20"><?php echo $profileData['contact_desc']; ?></textarea></div>
                </div>

                <button class="bg-blue-600 text-white px-6 py-3 rounded font-bold hover:bg-blue-700 transition w-full">Simpan Profil</button>
            </form>

            <div class="mt-10 pt-10 border-t border-gray-300">
                <h3 class="text-2xl font-bold mb-4 text-gray-800"><i class="fas fa-shield-alt mr-2 text-red-500"></i> Keamanan Akun</h3>
                <form action="process.php" method="POST" class="bg-red-50 p-6 rounded shadow-md border border-red-200 max-w-3xl">
                    <input type="hidden" name="action" value="change_account">
                    <div class="grid grid-cols-2 gap-6">
                        <div><label class="block font-bold mb-2 text-sm text-gray-700">Username Baru</label><input type="text" name="new_username" value="<?php echo $_SESSION['admin_name']; ?>" class="w-full border p-2 rounded" required></div>
                        <div><label class="block font-bold mb-2 text-sm text-gray-700">Password Baru</label><input type="password" name="new_password" placeholder="Isi jika ingin ganti" class="w-full border p-2 rounded"></div>
                    </div>
                    <button class="mt-4 bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 font-bold">Update Akun</button>
                </form>
            </div>
        <?php endif; ?>

        <?php if($tab == 'blog'): ?>
            <h2 class="text-3xl font-bold mb-6">Kelola Blog / Artikel</h2>
            <form action="process.php" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow mb-8 border-l-4 border-blue-500">
                <input type="hidden" name="action" value="save_article">
                <input type="hidden" name="id" value="<?php echo $editData ? $editData['id'] : ''; ?>">
                <div class="font-bold mb-4 text-xl"><?php echo $editData ? 'Edit Artikel' : 'Tulis Artikel Baru'; ?></div>
                
                <input name="title" value="<?php echo $editData ? $editData['title'] : ''; ?>" class="border p-2 rounded w-full mb-4" placeholder="Judul Artikel" required>
                
                <div class="bg-gray-50 p-4 rounded border mb-4">
                    <label class="block font-bold text-sm mb-2">Gambar Cover</label>
                    <?php if($editData && $editData['image_url']) echo "<img src='{$editData['image_url']}' class='h-24 mb-2 object-cover'>"; ?>
                    <input type="file" name="article_image_file" class="w-full text-sm">
                    <input type="hidden" name="old_article_image" value="<?php echo $editData ? $editData['image_url'] : ''; ?>">
                </div>
                
                <textarea name="content" class="border p-2 rounded w-full h-64 mb-4" placeholder="Tulis isi artikel disini..."><?php echo $editData ? $editData['content'] : ''; ?></textarea>
                
                <div class="flex gap-2">
                    <button class="bg-blue-600 text-white px-6 py-2 rounded">Simpan Artikel</button>
                    <?php if($editData): ?><a href="?tab=blog" class="bg-gray-500 text-white px-6 py-2 rounded">Batal</a><?php endif; ?>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php $art = mysqli_query($conn, "SELECT * FROM articles ORDER BY created_at DESC"); while($row = mysqli_fetch_assoc($art)): ?>
                    <div class="bg-white p-4 rounded shadow flex gap-4 border border-gray-100">
                        <?php if($row['image_url']): ?><img src="<?php echo $row['image_url']; ?>" class="w-24 h-24 object-cover rounded bg-gray-200"><?php endif; ?>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg leading-tight"><?php echo $row['title']; ?></h4>
                            <p class="text-xs text-gray-500 mb-2 mt-1"><?php echo date('d M Y', strtotime($row['created_at'])); ?></p>
                            <div class="mt-2 text-sm">
                                <a href="?tab=blog&edit=<?php echo $row['id']; ?>" class="text-blue-600 font-bold mr-2">Edit</a>
                                <a href="process.php?delete=<?php echo $row['id']; ?>&type=articles" class="text-red-600 font-bold" onclick="return confirm('Hapus?')">Hapus</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <?php if($tab == 'experience'): ?>
            <h2 class="text-3xl font-bold mb-6">Kelola Pengalaman Kerja</h2>
            <form action="process.php" method="POST" class="bg-white p-6 rounded shadow mb-8 grid grid-cols-2 gap-4 border-l-4 border-blue-500">
                <input type="hidden" name="action" value="save_experience">
                <input type="hidden" name="id" value="<?php echo $editData ? $editData['id'] : ''; ?>">
                <div class="col-span-2 font-bold text-lg mb-2"><?php echo $editData ? 'Edit Data' : 'Tambah Data Baru'; ?></div>
                <input name="role" value="<?php echo $editData ? $editData['role'] : ''; ?>" placeholder="Posisi" class="border p-2 rounded" required>
                <input name="company" value="<?php echo $editData ? $editData['company'] : ''; ?>" placeholder="Nama Perusahaan" class="border p-2 rounded" required>
                <input name="year_range" value="<?php echo $editData ? $editData['year_range'] : ''; ?>" placeholder="Tahun" class="border p-2 rounded" required>
                <textarea name="description" placeholder="Deskripsi..." class="border p-2 rounded col-span-2 h-32"><?php echo $editData ? $editData['description'] : ''; ?></textarea>
                <div class="col-span-2 flex gap-2"><button class="bg-blue-600 text-white px-6 py-2 rounded">Simpan Data</button><?php if($editData): ?><a href="?tab=experience" class="bg-gray-500 text-white px-6 py-2 rounded">Batal</a><?php endif; ?></div>
            </form>
            <div class="space-y-4">
                <?php $exp = mysqli_query($conn, "SELECT * FROM experience ORDER BY id DESC"); while($row = mysqli_fetch_assoc($exp)): ?>
                    <div class="bg-white p-4 rounded shadow flex justify-between items-start">
                        <div class="w-3/4">
                            <div class="font-bold text-lg"><?php echo $row['role']; ?> @ <?php echo $row['company']; ?></div>
                            <div class="text-gray-500 text-sm"><?php echo $row['year_range']; ?></div>
                            <p class="text-gray-400 text-xs mt-1 line-clamp-2"><?php echo $row['description']; ?></p>
                        </div>
                        <div class="flex gap-2"><a href="?tab=experience&edit=<?php echo $row['id']; ?>" class="text-blue-500 border border-blue-200 px-3 py-1 rounded">Edit</a><a href="process.php?delete=<?php echo $row['id']; ?>&type=experience" class="text-red-500 border border-red-200 px-3 py-1 rounded" onclick="return confirm('Hapus?')">Hapus</a></div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <?php if($tab == 'education'): ?>
            <h2 class="text-3xl font-bold mb-6">Kelola Pendidikan</h2>
            <form action="process.php" method="POST" class="bg-white p-6 rounded shadow mb-8 flex flex-col gap-4 border-l-4 border-blue-500">
                <input type="hidden" name="action" value="save_education">
                <input type="hidden" name="id" value="<?php echo $editData ? $editData['id'] : ''; ?>">
                <div class="font-bold"><?php echo $editData ? 'Edit Data' : 'Tambah Data Baru'; ?></div>
                <div class="flex gap-4">
                    <input name="school_name" value="<?php echo $editData ? $editData['school_name'] : ''; ?>" placeholder="Nama Sekolah/Univ" class="border p-2 rounded flex-1" required>
                    <input name="degree" value="<?php echo $editData ? $editData['degree'] : ''; ?>" placeholder="Jurusan/Gelar" class="border p-2 rounded flex-1" required>
                    <input name="year_range" value="<?php echo $editData ? $editData['year_range'] : ''; ?>" placeholder="Tahun" class="border p-2 rounded w-32" required>
                </div>
                <div class="flex gap-2"><button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button><?php if($editData): ?><a href="?tab=education" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a><?php endif; ?></div>
            </form>
            <ul class="bg-white rounded shadow divide-y">
                <?php $edu = mysqli_query($conn, "SELECT * FROM education ORDER BY id DESC"); while($row = mysqli_fetch_assoc($edu)): ?>
                    <li class="p-4 flex justify-between items-center">
                        <span><b><?php echo $row['school_name']; ?></b> - <?php echo $row['degree']; ?> (<?php echo $row['year_range']; ?>)</span>
                        <div class="flex gap-2"><a href="?tab=education&edit=<?php echo $row['id']; ?>" class="text-blue-500 px-2">Edit</a><a href="process.php?delete=<?php echo $row['id']; ?>&type=education" class="text-red-500 px-2" onclick="return confirm('Hapus?')">Hapus</a></div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>

        <?php if($tab == 'skills'): ?>
            <h2 class="text-3xl font-bold mb-6">Kelola Skill</h2>
            <form action="process.php" method="POST" class="bg-white p-6 rounded shadow mb-8 flex flex-col gap-4 border-l-4 border-blue-500">
                <input type="hidden" name="action" value="save_skill">
                <input type="hidden" name="id" value="<?php echo $editData ? $editData['id'] : ''; ?>">
                <div class="font-bold"><?php echo $editData ? 'Edit Skill' : 'Tambah Skill'; ?></div>
                <div class="flex gap-4">
                    <input name="skill_name" value="<?php echo $editData ? $editData['skill_name'] : ''; ?>" placeholder="Nama Skill" class="border p-2 rounded flex-1" required>
                    <input name="icon_url" value="<?php echo $editData ? $editData['icon_url'] : ''; ?>" placeholder="URL Icon" class="border p-2 rounded flex-1">
                </div>
                <div class="flex gap-2"><button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button><?php if($editData): ?><a href="?tab=skills" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a><?php endif; ?></div>
            </form>
            <div class="grid grid-cols-4 gap-4">
                <?php $skills = mysqli_query($conn, "SELECT * FROM skills"); while($row = mysqli_fetch_assoc($skills)): ?>
                    <div class="bg-white p-4 rounded shadow text-center relative group">
                        <img src="<?php echo $row['icon_url']; ?>" class="h-10 mx-auto mb-2">
                        <div class="font-bold"><?php echo $row['skill_name']; ?></div>
                        <div class="absolute inset-0 bg-black/80 hidden group-hover:flex items-center justify-center gap-3 rounded">
                            <a href="?tab=skills&edit=<?php echo $row['id']; ?>" class="text-blue-400 font-bold">Edit</a>
                            <a href="process.php?delete=<?php echo $row['id']; ?>&type=skills" class="text-red-400 font-bold" onclick="return confirm('Hapus?')">Hapus</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <?php if($tab == 'projects'): ?>
            <h2 class="text-3xl font-bold mb-6">Kelola Project</h2>
            <form action="process.php" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow mb-8 grid grid-cols-12 gap-4 border-l-4 border-blue-500">
                <input type="hidden" name="action" value="save_project">
                <input type="hidden" name="id" value="<?php echo $editData ? $editData['id'] : ''; ?>">
                <div class="col-span-12 font-bold"><?php echo $editData ? 'Edit Project' : 'Tambah Project Baru'; ?></div>
                <input name="title" value="<?php echo $editData ? $editData['title'] : ''; ?>" placeholder="Judul Project" class="border p-2 rounded col-span-6" required>
                <input type="number" name="display_order" value="<?php echo $editData ? $editData['display_order'] : '0'; ?>" class="border p-2 rounded col-span-2 text-center" placeholder="Urutan">
                <input name="link_url" value="<?php echo $editData ? $editData['link_url'] : ''; ?>" placeholder="Link Demo" class="border p-2 rounded col-span-4">
                <div class="col-span-12 bg-gray-50 p-4 rounded border border-dashed border-gray-400">
                    <label class="block font-bold mb-2 text-sm text-gray-600">Gambar Project</label>
                    <?php if($editData && $editData['image_url']): ?>
                    <div class="flex items-center gap-4 mb-3">
                        <img src="<?php echo $editData['image_url']; ?>" class="h-20 w-32 object-cover border bg-white rounded shadow-sm">
                    </div>
                    <?php endif; ?>
                    <input type="file" name="project_image_file" class="w-full border p-2 rounded bg-white">
                    <input type="hidden" name="old_project_image" value="<?php echo $editData ? $editData['image_url'] : ''; ?>">
                    <label class="block font-bold mt-4 mb-1 text-xs text-gray-400">Atau URL Manual:</label>
                    <input type="text" name="image_url_text" placeholder="https://..." class="w-full border p-2 rounded text-sm text-gray-500">
                </div>
                <textarea name="description" placeholder="Deskripsi Singkat..." class="border p-2 rounded col-span-12 h-20"><?php echo $editData ? $editData['description'] : ''; ?></textarea>
                <textarea name="details" placeholder="Case Study (Detail Lengkap)..." class="border p-2 rounded col-span-12 h-40"><?php echo $editData ? $editData['details'] : ''; ?></textarea>
                <div class="col-span-12 flex gap-2">
                    <button class="bg-blue-600 text-white px-6 py-2 rounded">Simpan</button>
                    <?php if($editData): ?><a href="?tab=projects" class="bg-gray-500 text-white px-6 py-2 rounded">Batal</a><?php endif; ?>
                </div>
            </form>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php $proj = mysqli_query($conn, "SELECT * FROM projects ORDER BY display_order ASC"); while($row = mysqli_fetch_assoc($proj)): ?>
                    <div class="bg-white p-4 rounded shadow flex flex-col h-full">
                        <div class="text-xs bg-gray-200 w-fit px-2 rounded mb-2">Urutan: <?php echo $row['display_order']; ?></div>
                        <img src="<?php echo $row['image_url']; ?>" class="h-32 w-full object-cover rounded bg-gray-100 mb-2">
                        <h4 class="font-bold text-lg mb-1"><?php echo $row['title']; ?></h4>
                        <div class="flex justify-between border-t pt-2 mt-auto">
                            <a href="?tab=projects&edit=<?php echo $row['id']; ?>" class="text-blue-500 text-sm font-bold">Edit</a>
                            <a href="process.php?delete=<?php echo $row['id']; ?>&type=projects" class="text-red-500 text-sm font-bold" onclick="return confirm('Hapus?')">Hapus</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

    </main>
</body>
</html>