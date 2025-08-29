<?php
// admin/contact/messages.php
session_start();
include("../../includes/auth_check.php"); // must redirect if not logged in
include("../../config/database.php");    // should set $pdo (PDO)

// Small helper to safely escape output; converts arrays to json string first
function h($value) {
    if (is_array($value)) {
        // Convert arrays to compact JSON so we don't break HTML attributes
        $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    // ensure string
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Simple CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(24));
}
$csrf = $_SESSION['csrf_token'];

// Handle POST actions: delete, toggle_read
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf']) || $_POST['csrf'] !== $csrf) {
        die("Invalid CSRF token");
    }

    $action = $_POST['action'] ?? '';
    $id = intval($_POST['id'] ?? 0);

    if ($id > 0) {
        if ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['flash'] = "Message #{$id} deleted.";
            header("Location: messages.php");
            exit;
        }

        if ($action === 'toggle_read') {
            // toggle read/unread
            $stmt = $pdo->prepare("UPDATE contacts SET is_read = NOT is_read WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['flash'] = "Message status updated.";
            header("Location: messages.php");
            exit;
        }
    }
}

// Search + pagination
$q = trim($_GET['q'] ?? '');
$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 15;
$offset = ($page - 1) * $per_page;

$params = [];
$where = "";
if ($q !== '') {
    $where = "WHERE name LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ?";
    $like = "%$q%";
    $params = [$like, $like, $like, $like];
}

// total count
$total_sql = "SELECT COUNT(*) FROM contacts $where";
$total_stmt = $pdo->prepare($total_sql);
$total_stmt->execute($params);
$total = (int)$total_stmt->fetchColumn();
$pages = max(1, (int)ceil($total / $per_page));

// fetch page (bind LIMIT/OFFSET as integers)
$list_sql = "SELECT id, name, email, subject, message, is_read, submitted_at FROM contacts $where ORDER BY submitted_at DESC LIMIT ? OFFSET ?";
$list_stmt = $pdo->prepare($list_sql);

// prepare the exec params; ensure limit/offset are integers
$exec_params = array_merge($params, [$per_page, $offset]);
$list_stmt->execute($exec_params);
$messages = $list_stmt->fetchAll(PDO::FETCH_ASSOC);

// unread count
$unread_stmt = $pdo->query("SELECT COUNT(*) FROM contacts WHERE is_read = 0");
$unread_count = (int)$unread_stmt->fetchColumn();

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Contact Messages - Admin</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    :root {
      --accent: #ffc107;
      --accent-dark: #ff9800;
      --muted: #6c757d;
      --card-radius: 12px;
    }
    body { background:#f8f9fa; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; }
    .sidebar {
      min-height: 100vh;
      background: linear-gradient(180deg,#343a40,#495057);
      color: #fff;
      padding-top: 1rem;
    }
    .sidebar h5 { color: var(--accent); padding-left:1rem; }
    .sidebar .nav-link { color: #ffd; padding:.55rem 1rem; }
    .sidebar .nav-link:hover { background:rgba(255,255,255,0.06); color:var(--accent); border-radius:.375rem; }
   

    .content-area { padding: 1.25rem; }
    .table-wrap { overflow-x:auto; }
    .unread-row { background: linear-gradient(90deg, rgba(255,201,107,0.08), transparent); }
    .msg-excerpt { color: #495057; }
    .small-muted { color:var(--muted); }
    .badge-unread { background: var(--accent-dark); color: #fff; }

    /* Responsive - make content full width on small */
    @media (max-width: 767px) {
      .sidebar { display:none; }
      .offcanvas-body .nav-link { color:#343a40; }
    }
  </style>
</head>
<body>
  <?php include("../partials/navbar.php"); ?>
 <div class="row">

    <!-- Sidebar -->
    
      <?php include("../partials/sidebar.php"); ?>


      <!-- Main content -->
      <main class="col-md-9 col-lg-10 content-area">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h1 class="h4 mb-0"><i class="bi bi-envelope-fill me-2 text-warning"></i> Contact Messages</h1>
          <div>
            <form class="d-flex" method="get" action="messages.php">
              <input name="q" value="<?= h($q) ?>" class="form-control form-control-sm me-2" type="search" placeholder="Search name, email or subject" aria-label="Search">
              <button class="btn btn-sm btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
            </form>
          </div>
        </div>

        <?php if ($flash): ?>
          <div class="alert alert-success"><?= h($flash) ?></div>
        <?php endif; ?>

        <div class="mb-3 small text-muted">Showing <strong><?= count($messages) ?></strong> of <strong><?= $total ?></strong> messages. Unread: <span class="badge bg-danger"><?= $unread_count ?></span></div>

        <div class="card shadow-sm">
          <div class="card-body p-0">
            <div class="table-wrap">
              <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                  <tr>
                    <th style="width:1%;">#</th>
                    <th style="width:18%;">From</th>
                    <th style="width:20%;">Subject</th>
                    <th>Message</th>
                    <th style="width:9%;">Received</th>
                    <th style="width:12%;">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($messages)): ?>
                    <tr><td colspan="6" class="text-center py-4 small-muted">No messages found.</td></tr>
                  <?php endif; ?>
                  <?php foreach ($messages as $m): 
                    // Normalize message to string for excerpt (if array, join it)
                    $msgText = $m['message'];
                    if (is_array($msgText)) {
                        $msgText = implode(' ', array_map(function($v){ return is_string($v)? $v : json_encode($v); }, $msgText));
                    }
                    $excerpt = mb_strlen($msgText) > 120 ? mb_substr($msgText,0,120).'…' : $msgText;
                    $is_unread = empty($m['is_read']) || $m['is_read'] == '0';
                  ?>
                    <tr class="<?= $is_unread ? 'unread-row' : '' ?>">
                      <td><?= h($m['id']) ?></td>
                      <td>
                        <div><strong><?= h($m['name']) ?></strong></div>
                        <div class="small-muted"><?= h($m['email']) ?></div>
                      </td>
                      <td>
                        <div><strong><?= h($m['subject'] ?: '(No subject)') ?></strong></div>
                      </td>
                      <td class="msg-excerpt"><?= h($excerpt) ?></td>
                      <td class="small-muted"><?= h(date('Y-m-d H:i', strtotime($m['submitted_at']))) ?></td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Actions">
                          <!-- View button: fill modal via data attributes -->
                          <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewMessageModal"
                                  data-id="<?= h($m['id']) ?>"
                                  data-name="<?= h($m['name']) ?>"
                                  data-email="<?= h($m['email']) ?>"
                                  data-subject="<?= h($m['subject']) ?>"
                                  data-message="<?= h($msgText) ?>"
                                  data-submitted="<?= h($m['submitted_at']) ?>"
                                  data-read="<?= $m['is_read'] ? '1' : '0' ?>">
                            <i class="bi bi-eye"></i>
                          </button>

                          <!-- Toggle read/unread -->
                          <form method="post" style="display:inline">
                            <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                            <input type="hidden" name="id" value="<?= h($m['id']) ?>">
                            <input type="hidden" name="action" value="toggle_read">
                            <button type="submit" class="btn btn-sm <?= $m['is_read'] ? 'btn-outline-secondary' : 'btn-warning' ?>" title="<?= $m['is_read'] ? 'Mark as unread' : 'Mark as read' ?>">
                              <i class="bi <?= $m['is_read'] ? 'bi-envelope-open' : 'bi-envelope' ?>"></i>
                            </button>
                          </form>

                          <!-- Delete -->
                          <form method="post" style="display:inline" onsubmit="return confirm('Delete this message?');">
                            <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                            <input type="hidden" name="id" value="<?= h($m['id']) ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                              <i class="bi bi-trash"></i>
                            </button>
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
            <small class="text-muted">Page <?= h($page) ?> of <?= h($pages) ?></small>
            <nav>
              <ul class="pagination pagination-sm mb-0">
                <?php
                $base_url = 'messages.php';
                if ($q !== '') $base_url .= '?q='.urlencode($q).'&';
                else $base_url .= '?';
                $prev_disabled = $page <= 1 ? ' disabled' : '';
                $next_disabled = $page >= $pages ? ' disabled' : '';
                ?>
                <li class="page-item<?= $prev_disabled ?>"><a class="page-link" href="<?= $base_url ?>page=<?= max(1, $page-1) ?>">‹ Prev</a></li>
                <?php
                // show up to 7 pages with current in center
                $start = max(1, $page - 3);
                $end = min($pages, $start + 6);
                for ($p = $start; $p <= $end; $p++): ?>
                  <li class="page-item<?= $p === $page ? ' active' : '' ?>"><a class="page-link" href="<?= $base_url ?>page=<?= $p ?>"><?= $p ?></a></li>
                <?php endfor; ?>
                <li class="page-item<?= $next_disabled ?>"><a class="page-link" href="<?= $base_url ?>page=<?= min($pages, $page+1) ?>">Next ›</a></li>
              </ul>
            </nav>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- View Message Modal -->
  <div class="modal fade" id="viewMessageModal" tabindex="-1" aria-labelledby="viewMessageLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewMessageLabel">View Message</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <dl class="row">
            <dt class="col-sm-3">From</dt>
            <dd id="vm-name" class="col-sm-9"></dd>

            <dt class="col-sm-3">Email</dt>
            <dd id="vm-email" class="col-sm-9"></dd>

            <dt class="col-sm-3">Subject</dt>
            <dd id="vm-subject" class="col-sm-9"></dd>

            <dt class="col-sm-3">Received</dt>
            <dd id="vm-submitted" class="col-sm-9 small-muted"></dd>

            <dt class="col-sm-3 align-self-start">Message</dt>
            <dd id="vm-message" class="col-sm-9" style="white-space:pre-wrap;"></dd>
          </dl>
        </div>
        <div class="modal-footer">
          <form method="post" id="vm-toggle-form" style="display:inline">
            <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
            <input type="hidden" name="id" id="vm-id" value="">
            <input type="hidden" name="action" value="toggle_read">
            <button type="submit" class="btn btn-warning" id="vm-toggle-btn"><i class="bi bi-envelope"></i> Mark as read</button>
          </form>
          <form method="post" id="vm-delete-form" style="display:inline" onsubmit="return confirm('Delete this message?');">
            <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
            <input type="hidden" name="id" id="vm-del-id" value="">
            <input type="hidden" name="action" value="delete">
            <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Delete</button>
          </form>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  (function(){
    // Fill modal with data attributes from clicked view button
    const viewModal = document.getElementById('viewMessageModal');
    viewModal.addEventListener('show.bs.modal', function (event) {
      const btn = event.relatedTarget;
      if (!btn) return;
      const id = btn.getAttribute('data-id') || '';
      const name = btn.getAttribute('data-name') || '';
      const email = btn.getAttribute('data-email') || '';
      const subject = btn.getAttribute('data-subject') || '';
      const message = btn.getAttribute('data-message') || '';
      const submitted = btn.getAttribute('data-submitted') || '';
      const read = btn.getAttribute('data-read') === '1';

      document.getElementById('vm-id').value = id;
      document.getElementById('vm-del-id').value = id;
      document.getElementById('vm-name').textContent = name;
      document.getElementById('vm-email').textContent = email;
      document.getElementById('vm-subject').textContent = subject || '(No subject)';
      document.getElementById('vm-submitted').textContent = submitted;
      // message may contain newlines; put into textContent so it's safe
      document.getElementById('vm-message').textContent = message;

      const toggleBtn = document.getElementById('vm-toggle-btn');
      if (read) {
        toggleBtn.innerHTML = '<i class="bi bi-envelope-open"></i> Mark as unread';
        toggleBtn.classList.remove('btn-warning');
        toggleBtn.classList.add('btn-outline-secondary');
      } else {
        toggleBtn.innerHTML = '<i class="bi bi-envelope"></i> Mark as read';
        toggleBtn.classList.remove('btn-outline-secondary');
        toggleBtn.classList.add('btn-warning');
      }
    });
  })();
  </script>
</body>
</html>
