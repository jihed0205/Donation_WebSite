<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

$stmt = $pdo->query("SELECT items.*, users.first_name, users.last_name 
                     FROM items 
                     JOIN users ON items.user_id = users.id 
                     WHERE items.status = 'pending' 
                     ORDER BY items.created_at ASC");
$pending_items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel | Hand2Hand</title>
  <link rel="stylesheet" href="design-system.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="h2h-main">
  <div class="h2h-reveal" style="margin-bottom:32px;">
    <h1 class="h2h-page-title">Pending <span class="accent">Approvals</span></h1>
    <p class="h2h-subtitle">Review community donations before they reach associations.</p>
  </div>

  <?php if (count($pending_items) > 0): ?>
    <div style="display:flex;flex-direction:column;gap:14px;">
      <?php foreach ($pending_items as $i => $item): ?>
      <div class="h2h-card h2h-reveal" style="display:flex;align-items:center;gap:20px;padding:20px;transition-delay:<?php echo $i * 50; ?>ms;flex-wrap:wrap;">
        <div style="width:88px;height:88px;flex-shrink:0;border-radius:14px;overflow:hidden;background:var(--navy-4);border:1px solid var(--border);">
          <img src="uploads/<?php echo htmlspecialchars($item['item_image']); ?>" style="width:100%;height:100%;object-fit:cover;" alt="">
        </div>

        <div style="flex:1;min-width:200px;">
          <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:6px;">
            <span style="font-size:1.05rem;font-weight:700;"><?php echo htmlspecialchars($item['item_name']); ?></span>
            <span class="h2h-badge badge-yellow"><?php echo htmlspecialchars($item['category']); ?></span>
          </div>
          <p style="color:var(--slate);font-size:.83rem;margin-bottom:8px;line-height:1.5;"><?php echo htmlspecialchars($item['description']); ?></p>
          <p style="color:var(--slate);font-size:.78rem;">
            👤 <?php echo htmlspecialchars($item['first_name'] . ' ' . $item['last_name']); ?>
            &nbsp;·&nbsp; Qty: <?php echo htmlspecialchars($item['quantity']); ?>
            &nbsp;·&nbsp; <?php echo htmlspecialchars($item['item_condition']); ?>
          </p>
        </div>

        <div style="display:flex;gap:10px;flex-shrink:0;">
          <a href="update_status.php?id=<?php echo $item['id']; ?>&action=approved" class="h2h-btn h2h-btn-green">Approve</a>
          <a href="update_status.php?id=<?php echo $item['id']; ?>&action=refused"  class="h2h-btn h2h-btn-red">Refuse</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="h2h-card h2h-empty h2h-reveal">
      <span class="h2h-empty-icon">✅</span>
      <p>All clear — no pending donations to review.</p>
    </div>
  <?php endif; ?>
</main>

<script src="h2h-transition.js"></script>
</body>
</html>
