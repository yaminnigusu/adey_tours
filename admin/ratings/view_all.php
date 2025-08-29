<?php
// admin/ratings/view_all.php
session_start();
include("../../includes/auth_check.php"); 
include("../../config/database.php");    

$table = 'ratings';

// helper
function h($v){ if(is_array($v)) $v = json_encode($v, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES); return htmlspecialchars((string)$v, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8'); }

if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(24));
$csrf = $_SESSION['csrf_token'];

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf']) || $_POST['csrf'] !== $csrf) die("Invalid CSRF token");
    $action = $_POST['action'] ?? '';
    $id = intval($_POST['id'] ?? 0);

    if ($id > 0) {
        if ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM `$table` WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['flash'] = "Rating #{$id} deleted.";
            header("Location: view_all.php");
            exit;
        }
    }
}

// Search + pagination + sorting
$q = trim($_GET['q'] ?? '');
$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 20;
$offset = ($page - 1) * $per_page;

// Sorting
$allowed_sorts = ['id','customer_name','rating','created_at'];
$sort = $_GET['sort'] ?? 'created_at';  // Default
if (!in_array($sort, $allowed_sorts)) {
    $sort = 'created_at';
}

$dir = (isset($_GET['dir']) && strtolower($_GET['dir']) === 'asc') ? 'ASC' : 'DESC';


$where = "";
$params = [];
if ($q !== '') {
    $where = "WHERE customer_name LIKE ? OR comment LIKE ?";
    $like = "%$q%";
    $params = [$like, $like];
}

// total
try {
    $total_sql = "SELECT COUNT(*) FROM `$table` $where";
    $stmt = $pdo->prepare($total_sql);
    $stmt->execute($params);
    $total = (int)$stmt->fetchColumn();
} catch (PDOException $e) {
    $err = "DB error: " . $e->getMessage();
    $total = 0;
}

// fetch list
$select_cols = "id, customer_name, rating, comment, created_at";
try {
    $list_sql = "SELECT $select_cols FROM `$table` $where ORDER BY `$sort` $dir LIMIT ? OFFSET ?";
    $stmt = $pdo->prepare($list_sql);
    $exec_params = array_merge($params, [$per_page, $offset]);
    $stmt->execute($exec_params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $rows = [];
    $err = "DB error: " . $e->getMessage();
}

// stats
$avg_rating = null;
try {
    $avg_stmt = $pdo->prepare("SELECT AVG(rating) as avg_rating, COUNT(*) as cnt FROM `$table`");
    $avg_stmt->execute();
    $avg_row = $avg_stmt->fetch(PDO::FETCH_ASSOC);
    if ($avg_row) {
        $avg_rating = round($avg_row['avg_rating'] ?: 0, 2);
        $total_all = (int)$avg_row['cnt'];
    }
} catch (PDOException $e) {
    // ignore
}

// CSV export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    $csv_sql = "SELECT $select_cols FROM `$table` " . ($where ? $where : "") . " ORDER BY `$sort` $dir";
    $csv_stmt = $pdo->prepare($csv_sql);
    $csv_stmt->execute($params);
    $csv_rows = $csv_stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=ratings_export_'.date('Ymd_His').'.csv');
    $out = fopen('php://output','w');
    fputcsv($out, array_keys($csv_rows[0] ?? ['id','customer_name','rating','comment','created_at']));
    foreach ($csv_rows as $r) {
        fputcsv($out, array_map(fn($v)=>is_null($v)?'':(string)$v, $r));
    }
    fclose($out);
    exit;
}

$pages = max(1, (int)ceil(($total ?: 0) / $per_page));

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Manage Ratings</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body{font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background:#f8f9fa;}
    .sidebar{ min-height:100vh; background:linear-gradient(180deg,#343a40,#495057); color:#fff; padding-top:1rem; }
    .sidebar h5{ color:#ffc107; padding-left:1rem; }
    .table-wrap{ overflow:auto; }
    .rating-badge { font-weight:600; padding:.35rem .5rem; border-radius:.35rem; }
    .star { color:#f5b301; }
  </style>
</head>
<body>
    <?php include("../partials/navbar.php"); ?>
   <div class="row">

    <!-- Sidebar for desktop -->
   
      <?php include("../partials/sidebar.php"); ?>
      <main class="col-md-9 col-lg-10 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h3 class="mb-0"><i class="bi bi-star-fill text-warning"></i> Ratings</h3>
            <small class="text-muted">Average rating: <?= $avg_rating ?? '—' ?> (<?= $total_all ?? 0 ?> total)</small>
          </div>
          <div class="d-flex gap-2">
            <form class="d-flex" method="get" action="view_all.php">
              <input name="q" value="<?= h($q) ?>" class="form-control form-control-sm me-2" placeholder="Search name, email, review">
              <input type="hidden" name="sort" value="<?= h($sort) ?>">
              <input type="hidden" name="dir" value="<?= h(strtolower($dir)=='asc' ? 'asc' : 'desc') ?>">
              <button class="btn btn-outline-secondary btn-sm" type="submit"><i class="bi bi-search"></i></button>
            </form>

            <a href="view_all.php?<?= ($q !== '' ? 'q='.urlencode($q).'&' : '') . 'sort='.urlencode($sort).'&dir='.urlencode($dir).'&export=csv' ?>" class="btn btn-sm btn-outline-success">Export CSV</a>
          </div>
        </div>

        <?php if (!empty($err)): ?>
          <div class="alert alert-danger"><?= h($err) ?></div>
        <?php endif; ?>

        <?php if ($flash): ?>
          <div class="alert alert-success"><?= h($flash) ?></div>
        <?php endif; ?>

        <div class="card mb-3">
          <div class="card-body p-0">
            <div class="table-wrap">
              <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                  <tr>
                    <th style="width:1%;">#</th>
                    <th style="width:18%;">Name</th>
                    <th style="width:12%;">Rating</th>
                    <th>Review</th>
                    <th style="width:12%;">Submitted</th>
                    <th style="width:12%;">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($rows)): ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">No ratings found.</td></tr>
                  <?php endif; ?>

                  <?php foreach ($rows as $r): 
                    $rating = isset($r['rating']) ? (float)$r['rating'] : null;
                    $review = $r['review'] ?? '';
                    // normalize arrays if present
                    if (is_array($review)) $review = implode(' ', array_map(function($v){ return is_string($v)?$v: json_encode($v); }, $review));
                  ?>
                    <tr>
                      <td><?= h($r['id'] ?? '') ?></td>
                      <td>
                        <div><strong><?= h($r['name'] ?? '—') ?></strong></div>
                        <div class="small text-muted"><?= h($r['email'] ?? '') ?></div>
                      </td>
                      <td>
                        <?php if ($rating !== null): ?>
                          <span class="rating-badge bg-light border"><?= h($rating) ?></span>
                          <div class="small"><span class="star"><?= str_repeat('★', (int)round($rating)) ?></span></div>
                        <?php else: ?>
                          <span class="text-muted">—</span>
                        <?php endif; ?>
                      </td>
                      <td style="max-width:45ch; white-space:normal;"><?= h(mb_strlen($review) > 240 ? mb_substr($review,0,240).'…' : $review) ?></td>
                      <td class="small text-muted"><?= h(isset($r['submitted_at']) ? date('Y-m-d H:i', strtotime($r['submitted_at'])) : '') ?></td>
                      <td>
                        <div class="btn-group" role="group">
                          <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewRatingModal"
                            data-id="<?= h($r['id'] ?? '') ?>"
                            data-name="<?= h($r['name'] ?? '') ?>"
                            data-email="<?= h($r['email'] ?? '') ?>"
                            data-rating="<?= h($rating) ?>"
                            data-review="<?= h($review) ?>"
                            data-submitted="<?= h($r['submitted_at'] ?? '') ?>"
                            >View</button>

                          <form method="post" style="display:inline">
                            <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                            <input type="hidden" name="id" value="<?= h($r['id'] ?? '') ?>">
                            <input type="hidden" name="action" value="toggle_approve">
                            <button type="submit" class="btn btn-sm btn-outline-secondary" title="Toggle approve"><i class="bi bi-check2-all"></i></button>
                          </form>

                          <form method="post" style="display:inline" onsubmit="return confirm('Delete this rating?');">
                            <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                            <input type="hidden" name="id" value="<?= h($r['id'] ?? '') ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>

                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <small class="text-muted">Page <?= h($page) ?> of <?= h($pages) ?> — <?= h($total) ?> matching</small>
            <nav>
              <ul class="pagination pagination-sm mb-0">
                <?php
                  $base_q = ($q !== '') ? 'q='.urlencode($q).'&' : '';
                  $base_q .= 'sort='.urlencode($sort).'&dir='.urlencode(strtolower($dir));
                ?>
                <li class="page-item<?= $page<=1? ' disabled':'' ?>"><a class="page-link" href="view_all.php?<?= $base_q ?>&page=<?= max(1,$page-1) ?>">‹ Prev</a></li>
                <?php
                  $start = max(1, $page-3); $end = min($pages, $start+6);
                  for ($p=$start;$p<=$end;$p++): ?>
                  <li class="page-item<?= $p===$page ? ' active':'' ?>"><a class="page-link" href="view_all.php?<?= $base_q ?>&page=<?= $p ?>"><?= $p ?></a></li>
                <?php endfor; ?>
                <li class="page-item<?= $page>=$pages? ' disabled':'' ?>"><a class="page-link" href="view_all.php?<?= $base_q ?>&page=<?= min($pages,$page+1) ?>">Next ›</a></li>
              </ul>
            </nav>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- View Rating Modal -->
  <div class="modal fade" id="viewRatingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Rating Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <dl class="row">
            <dt class="col-sm-3">Name</dt><dd id="vr-name" class="col-sm-9"></dd>
            <dt class="col-sm-3">Email</dt><dd id="vr-email" class="col-sm-9"></dd>
            <dt class="col-sm-3">Rating</dt><dd id="vr-rating" class="col-sm-9"></dd>
            <dt class="col-sm-3">Submitted</dt><dd id="vr-submitted" class="col-sm-9"></dd>
            <dt class="col-sm-3 align-self-start">Review</dt><dd id="vr-review" class="col-sm-9" style="white-space:pre-wrap;"></dd>
          </dl>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
  const viewModal = document.getElementById('viewRatingModal');
  viewModal.addEventListener('show.bs.modal', function(e){
    const btn = e.relatedTarget;
    if (!btn) return;
    document.getElementById('vr-name').textContent = btn.getAttribute('data-name') || '';
    document.getElementById('vr-email').textContent = btn.getAttribute('data-email') || '';
    document.getElementById('vr-rating').textContent = btn.getAttribute('data-rating') || '';
    document.getElementById('vr-submitted').textContent = btn.getAttribute('data-submitted') || '';
    document.getElementById('vr-review').textContent = btn.getAttribute('data-review') || '';
  });
})();
</script>
</body>
</html>
