<?php
$page_title='Blog Post';
include('includes/header.php');
$slug = $_GET['slug'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE slug=? OR id=?");
$stmt->execute([$slug, $slug]);
$p = $stmt->fetch() ?: die("Post not found");
?>
<section class="container py-5">
  <h1><?= htmlspecialchars($p['title']) ?></h1>
  <p><small class="text-muted"><?= date('F j, Y', strtotime($p['created_at'])) ?></small></p>
  <?php if($p['featured_image']): ?>
    <img src="/uploads/blog_images/<?= htmlspecialchars($p['featured_image']) ?>" class="img-fluid mb-4 rounded shadow">
  <?php endif; ?>
  <div class="content"><?= nl2br(htmlspecialchars($p['content'])) ?></div>
</section>
<?php include('includes/footer.php'); ?>
