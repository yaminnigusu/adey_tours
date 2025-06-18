<?php
$page_title='Blog';
include('../includes/header.php');
include('../config/database.php');
$posts = $pdo->query("SELECT id, title, slug, featured_image, created_at FROM blog_posts ORDER BY created_at DESC")->fetchAll();
?>
<section class="container py-5">
  <h2 class="mb-4 text-center">Latest Blog Posts</h2>
  <div class="row g-4">
    <?php foreach($posts as $post): ?>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <?php if($post['featured_image']): ?>
            <img src="/uploads/blog_images/<?= htmlspecialchars($post['featured_image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($post['title']) ?>">
          <?php endif; ?>
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
            <p class="card-text"><small class="text-muted"><?= date('M d, Y', strtotime($post['created_at'])) ?></small></p>
            <a href="/blog_post.php?slug=<?= htmlspecialchars($post['slug'] ?: $post['id']) ?>" class="btn btn-outline-primary">Read More</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php include('../includes/footer.php'); ?>
