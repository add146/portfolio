<?php
session_start();
include 'db.php';

$action = isset($_POST['action']) ? $_POST['action'] : '';
$delete = isset($_GET['delete']) ? $_GET['delete'] : '';
$type   = isset($_GET['type']) ? $_GET['type'] : '';

// =======================================================================
// 1. UPDATE PROFIL (HERO, SOSMED, PASSWORD)
// =======================================================================
if ($action == 'update_profile') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $wa = mysqli_real_escape_string($conn, $_POST['whatsapp']);
    $addr = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Teks Website
    $site_title = mysqli_real_escape_string($conn, $_POST['site_title']);
    $hero_role = mysqli_real_escape_string($conn, $_POST['hero_role']);
    $avail_text = mysqli_real_escape_string($conn, $_POST['availability_text']);
    $proj_desc = mysqli_real_escape_string($conn, $_POST['projects_desc']);
    $cont_desc = mysqli_real_escape_string($conn, $_POST['contact_desc']);
    $proj_limit = !empty($_POST['projects_limit']) ? (int)$_POST['projects_limit'] : 6;

    // Sosmed
    $ln_github = mysqli_real_escape_string($conn, $_POST['link_github']);
    $ln_linkedin = mysqli_real_escape_string($conn, $_POST['link_linkedin']);
    $ln_ig = mysqli_real_escape_string($conn, $_POST['link_instagram']);
    $ln_fb = mysqli_real_escape_string($conn, $_POST['link_facebook']);
    $ln_yt = mysqli_real_escape_string($conn, $_POST['link_youtube']);
    $ln_tt = mysqli_real_escape_string($conn, $_POST['link_tiktok']);

    // Upload Hero Image
    $hero_img = $_POST['old_hero_image']; 
    if (!empty($_FILES['hero_image_file']['name'])) {
        $filename = time() . '_hero_' . $_FILES['hero_image_file']['name'];
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0755, true); }
        if (move_uploaded_file($_FILES['hero_image_file']['tmp_name'], $target_dir . basename($filename))) {
            $hero_img = $target_dir . basename($filename);
        }
    } elseif (!empty($_POST['hero_image_url_text'])) {
        $hero_img = mysqli_real_escape_string($conn, $_POST['hero_image_url_text']);
    }

    $query = "UPDATE profile SET 
              name='$name', bio='$bio', whatsapp='$wa', address='$addr', email='$email',
              site_title='$site_title', hero_role='$hero_role', hero_image_url='$hero_img',
              availability_text='$avail_text', projects_desc='$proj_desc', contact_desc='$cont_desc',
              projects_limit='$proj_limit',
              link_github='$ln_github', link_linkedin='$ln_linkedin', link_instagram='$ln_ig', link_facebook='$ln_fb',
              link_youtube='$ln_yt', link_tiktok='$ln_tt'
              WHERE id=1";
              
    mysqli_query($conn, $query);
    header("Location: admin.php?tab=profile&status=success");
}

// =======================================================================
// 2. EXPERIENCE (PENGALAMAN KERJA)
// =======================================================================
if ($action == 'save_experience') {
    $id = $_POST['id'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $year = mysqli_real_escape_string($conn, $_POST['year_range']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    if(!empty($id)){
        $query = "UPDATE experience SET role='$role', company='$company', year_range='$year', description='$desc' WHERE id=$id";
    } else {
        $query = "INSERT INTO experience (role, company, year_range, description) VALUES ('$role', '$company', '$year', '$desc')";
    }
    mysqli_query($conn, $query);
    header("Location: admin.php?tab=experience");
}

// =======================================================================
// 3. EDUCATION (PENDIDIKAN)
// =======================================================================
if ($action == 'save_education') {
    $id = $_POST['id'];
    $school = mysqli_real_escape_string($conn, $_POST['school_name']);
    $degree = mysqli_real_escape_string($conn, $_POST['degree']);
    $year = mysqli_real_escape_string($conn, $_POST['year_range']);

    if(!empty($id)){
        $query = "UPDATE education SET school_name='$school', degree='$degree', year_range='$year' WHERE id=$id";
    } else {
        $query = "INSERT INTO education (school_name, degree, year_range) VALUES ('$school', '$degree', '$year')";
    }
    mysqli_query($conn, $query);
    header("Location: admin.php?tab=education");
}

// =======================================================================
// 4. SKILLS (KEAHLIAN)
// =======================================================================
if ($action == 'save_skill') {
    $id = $_POST['id'];
    $skill = mysqli_real_escape_string($conn, $_POST['skill_name']);
    $icon = mysqli_real_escape_string($conn, $_POST['icon_url']);

    if(!empty($id)){
        $query = "UPDATE skills SET skill_name='$skill', icon_url='$icon' WHERE id=$id";
    } else {
        $query = "INSERT INTO skills (skill_name, icon_url) VALUES ('$skill', '$icon')";
    }
    mysqli_query($conn, $query);
    header("Location: admin.php?tab=skills");
}

// =======================================================================
// 5. PROJECTS (UPLOAD + DETAILS + ORDER)
// =======================================================================
if ($action == 'save_project') {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $link = mysqli_real_escape_string($conn, $_POST['link_url']);
    $order = !empty($_POST['display_order']) ? (int)$_POST['display_order'] : 0;

    $img = $_POST['old_project_image']; 
    if (!empty($_FILES['project_image_file']['name'])) {
        $filename = time() . '_proj_' . $_FILES['project_image_file']['name'];
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0755, true); }
        if (move_uploaded_file($_FILES['project_image_file']['tmp_name'], $target_dir . basename($filename))) {
            $img = $target_dir . basename($filename);
        }
    } elseif (!empty($_POST['image_url_text'])) {
        $img = mysqli_real_escape_string($conn, $_POST['image_url_text']);
    }

    if(!empty($id)){
        $query = "UPDATE projects SET title='$title', description='$desc', details='$details', image_url='$img', link_url='$link', display_order='$order' WHERE id=$id";
    } else {
        $query = "INSERT INTO projects (title, description, details, image_url, link_url, display_order) VALUES ('$title', '$desc', '$details', '$img', '$link', '$order')";
    }
    mysqli_query($conn, $query);
    header("Location: admin.php?tab=projects");
}

// =======================================================================
// 6. BLOG / ARTIKEL (BARU)
// =======================================================================
if ($action == 'save_article') {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    
    $img = $_POST['old_article_image']; 
    if (!empty($_FILES['article_image_file']['name'])) {
        $filename = time() . '_blog_' . $_FILES['article_image_file']['name'];
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0755, true); }
        if (move_uploaded_file($_FILES['article_image_file']['tmp_name'], $target_dir . basename($filename))) {
            $img = $target_dir . basename($filename);
        }
    }

    if(!empty($id)){
        $query = "UPDATE articles SET title='$title', content='$content', image_url='$img' WHERE id=$id";
    } else {
        $query = "INSERT INTO articles (title, content, image_url) VALUES ('$title', '$content', '$img')";
    }
    mysqli_query($conn, $query);
    header("Location: admin.php?tab=blog");
}

// =======================================================================
// 7. GANTI AKUN
// =======================================================================
if ($action == 'change_account') {
    $current_user = $_SESSION['admin_name'];
    $new_username = mysqli_real_escape_string($conn, $_POST['new_username']);
    $new_password = $_POST['new_password'];

    $query = "UPDATE admin_users SET username='$new_username' WHERE username='$current_user'"; 
    $run = mysqli_query($conn, $query);

    if (!empty($new_password)) {
        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $target_user = ($run) ? $new_username : $current_user;
        mysqli_query($conn, "UPDATE admin_users SET password='$hash' WHERE username='$target_user'");
    }
    session_start();
    $_SESSION['admin_name'] = $new_username;
    header("Location: admin.php?tab=profile&status=account_updated");
}

// 8. DELETE
if ($delete && $type) {
    $id = (int)$delete;
    if ($type == 'experience') mysqli_query($conn, "DELETE FROM experience WHERE id=$id");
    if ($type == 'education') mysqli_query($conn, "DELETE FROM education WHERE id=$id");
    if ($type == 'skills') mysqli_query($conn, "DELETE FROM skills WHERE id=$id");
    if ($type == 'projects') mysqli_query($conn, "DELETE FROM projects WHERE id=$id");
    if ($type == 'blog') mysqli_query($conn, "DELETE FROM articles WHERE id=$id");
    
    header("Location: admin.php?tab=$type");
}
?>