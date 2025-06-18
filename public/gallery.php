<?php
$page_title='Gallery';
include('../includes/header.php');
include('../config/database.php');
$albums = $pdo->query("SELECT * FROM galleries ORDER BY created_at DESC")->fetchAll();
?>
<section class="container py-5">
  <h2 class="mb-4 text-center">Gallery</h2>
  <?php foreach($albums as $album): ?>
    <h3><?= htmlspecialchars($album['title']) ?></h3>
    <p><?= htmlspecialchars($album['description']) ?></p>
    <div class="row g-3 mb-5">
      <?php
        $photos = $pdo->prepare("SELECT * FROM photos WHERE gallery_id=? LIMIT 6");
        $photos->execute([$album['id']]);
        foreach($photos->fetchAll() as $p):
      ?>
        <div class="col-sm-4 col-md-3">
          <a href="/uploads/gallery_photos/<?= $p['filename'] ?>" data-bs-toggle="modal" data-bs-target="#imgModal" data-src="/uploads/gallery_photos/<?= $p['filename'] ?>">
            <img src="/uploads/gallery_photos/<?= $p['filename'] ?>" class="img-fluid rounded shadow-sm hover-zoom" alt="">
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
</section>

<!-- Modal viewer -->
<div class="modal fade" id="imgModal"><div class="modal-dialog modal-lg"><img src="" class="w-100"></div></div>
<script>
document.querySelectorAll('[data-bs-toggle="modal"]').forEach(el => {
  el.onclick = e => document.querySelector('#imgModal img').src = e.currentTarget.dataset.src;
});
</script>
<?php include('../includes/footer.php'); ?>
