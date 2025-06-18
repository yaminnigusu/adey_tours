<?php
$page_title='Rate Us';
include('includes/header.php');
?>
<section class="container py-5">
  <h2 class="mb-4 text-center">Rate Our Service</h2>
  <form method="POST" action="submit_rating_handler.php" class="mx-auto" style="max-width:500px">
    <div class="mb-3">
      <label>Name *</label>
      <input name="customer_name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Rating *</label>
      <select name="rating" class="form-select" required>
        <?php for($i=5;$i>=1;$i--): ?>
          <option value="<?= $i ?>"><?= $i ?> Star<?= $i>1?'s':'' ?></option>
        <?php endfor; ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Comment (optional)</label>
      <textarea name="comment" rows="4" class="form-control"></textarea>
    </div>
    <button class="btn btn-primary">Submit</button>
  </form>
</section>
<?php include('includes/footer.php'); ?>
