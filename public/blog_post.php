<?php
$page_title = 'Blog Post';
include('../includes/header.php');
include('../config/database.php'); 

$slug = $_GET['slug'] ?? '';

if (!$slug) {
    die("Post not found");
}

// Determine if $slug is numeric (id) or string (slug)
if (is_numeric($slug)) {
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
} else {
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE slug = ?");
}

$stmt->execute([$slug]);
$p = $stmt->fetch();

if (!$p) {
    die("Post not found");
}
?>

<style>
/* Blog Post Styles */
.blog-hero {
    background: url('../uploads/blog_images/<?= $p['featured_image'] ?? 'default.jpg' ?>') center/cover no-repeat;
    height: 50vh;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-align: center;
}

.blog-hero::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.5);
}

.blog-hero h1 {
    position: relative;
    z-index: 2;
    font-size: 3rem;
    font-weight: 700;
}

.blog-meta {
    color: #6c757d;
    margin-bottom: 1.5rem;
}

.blog-content h2, .blog-content h3 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.blog-content p {
    line-height: 1.8;
    margin-bottom: 1.25rem;
    font-size: 1.05rem;
}

.blog-content img {
    max-width: 100%;
    margin: 20px 0;
    border-radius: 8px;
}

.blog-content blockquote {
    border-left: 5px solid #0d6efd;
    padding-left: 15px;
    font-style: italic;
    color: #555;
    margin: 20px 0;
    background: #f8f9fa;
    border-radius: 5px;
}

@media (max-width: 768px) {
    .blog-hero h1 { font-size: 2rem; }
}
</style>

<!-- Blog Hero Section -->
<section class="blog-hero mb-5">
    <h1><?= htmlspecialchars($p['title']) ?></h1>
</section>

<section class="container py-5">
    <div class="row">
        <!-- Blog Content -->
        <div class="col-lg-8">
            <p class="blog-meta">
                <i class="bi bi-calendar-event"></i> <?= date('F j, Y', strtotime($p['created_at'])) ?>
                <!-- Optionally add author here -->
            </p>

            <div class="blog-content">
                <?= $p['content'] ?>
            </div>

            <hr>

            <!-- Share buttons -->
            <div class="d-flex align-items-center mt-4">
                <span class="me-3 fw-bold">Share:</span>
                <a href="#" class="btn btn-outline-primary btn-sm me-2"><i class="bi bi-facebook"></i> Facebook</a>
                <a href="#" class="btn btn-outline-info btn-sm me-2"><i class="bi bi-twitter"></i> Twitter</a>
                <a href="#" class="btn btn-outline-danger btn-sm"><i class="bi bi-envelope"></i> Email</a>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4 mt-5 mt-lg-0">
            <div class="p-4 bg-light rounded shadow-sm">
                <h5 class="mb-4">Recent Posts</h5>
                <ul class="list-unstyled">
                    <?php
                    $recent = $pdo->query("SELECT title, slug FROM blog_posts ORDER BY created_at DESC LIMIT 5");
                    while ($r = $recent->fetch()) {
                        echo '<li class="mb-2"><a href="blog_post.php?slug='.htmlspecialchars($r['slug']).'" class="text-decoration-none">'.$r['title'].'</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php include('../includes/footer.php'); ?>
