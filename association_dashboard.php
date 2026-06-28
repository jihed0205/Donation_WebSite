<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'association') {
    header("Location: login.html");
    exit();
}

$assoc_id = $_SESSION['user_id'];

if (isset($_POST['reserve_id'])) {
    $update = $pdo->prepare("UPDATE items SET status = 'reserved', assoc_id = ? WHERE id = ?");
    if ($update->execute([$assoc_id, $_POST['reserve_id']])) {
        header("Location: association_dashboard.php?success=1");
        exit();
    }
}

$stmt = $pdo->prepare("SELECT * FROM items WHERE status = 'approved' ORDER BY created_at DESC");
$stmt->execute();
$approved_items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Association Dashboard | Hand2Hand</title>
  <link rel="stylesheet" href="design-system.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="h2h-main">
  <div class="h2h-reveal" style="margin-bottom:32px;">
    <h1 class="h2h-page-title">Welcome, <span class="accent"><?php echo htmlspecialchars($_SESSION['display_name']); ?></span></h1>
    <p class="h2h-subtitle">Browse admin-approved donations and reserve what your association needs.</p>
  </div>

  <?php if (isset($_GET['success'])): ?>
    <div style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.25);border-radius:12px;padding:14px 20px;margin-bottom:24px;color:var(--green);font-weight:600;font-size:.9rem;" class="h2h-reveal">
      ✓ Item reserved successfully.
    </div>
  <?php endif; ?>

  <h2 style="font-size:1rem;font-weight:700;color:var(--slate);text-transform:uppercase;letter-spacing:1px;margin-bottom:18px;" class="h2h-reveal">Available Donations</h2>

  <?php if (count($approved_items) > 0): ?>
    <div style="display:flex;flex-direction:column;gap:12px;">
      <?php foreach ($approved_items as $i => $item): ?>
      <div class="h2h-card h2h-reveal" style="display:flex;align-items:center;gap:18px;padding:18px;transition-delay:<?php echo $i * 40; ?>ms;">
        <div style="width:80px;height:80px;flex-shrink:0;border-radius:12px;overflow:hidden;background:var(--navy-4);border:1px solid var(--border);">
          <?php if (!empty($item['item_image'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($item['item_image']); ?>" style="width:100%;height:100%;object-fit:cover;" alt="">
          <?php else: ?>
            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:.6rem;color:var(--slate);">NO IMG</div>
          <?php endif; ?>
        </div>

        <div style="flex:1;min-width:0;">
          <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:4px;">
            <span style="font-size:1rem;font-weight:700;"><?php echo htmlspecialchars($item['item_name']); ?></span>
            <span class="h2h-badge badge-green"><?php echo htmlspecialchars($item['category']); ?></span>
          </div>
          <p style="color:var(--slate);font-size:.82rem;margin-bottom:4px;"><?php echo htmlspecialchars($item['description']); ?></p>
          <p style="color:var(--slate);font-size:.78rem;">Qty: <?php echo htmlspecialchars($item['quantity']); ?> &nbsp;·&nbsp; <?php echo htmlspecialchars($item['item_condition']); ?></p>
        </div>

        <form method="POST" onsubmit="return confirm('Reserve this item for your association?');" style="flex-shrink:0;">
          <input type="hidden" name="reserve_id" value="<?php echo $item['id']; ?>">
          <button type="submit" class="h2h-btn h2h-btn-green">Reserve</button>
        </form>
      </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="h2h-card h2h-empty h2h-reveal">
      <span class="h2h-empty-icon">🔍</span>
      <p>No approved donations available right now. Check back soon.</p>
    </div>
  <?php endif; ?>
</main>

<script src="h2h-transition.js"></script>
</body>
</html>
