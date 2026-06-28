<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM items WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$my_items = $stmt->fetchAll();

$total   = count($my_items);
$pending = count(array_filter($my_items, fn($i) => $i['status'] === 'pending'));
$active  = count(array_filter($my_items, fn($i) => $i['status'] === 'approved'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | Hand2Hand</title>
  <link rel="stylesheet" href="design-system.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="h2h-main">

  <!-- Title row -->
  <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;margin-bottom:36px;">
    <div class="h2h-reveal">
      <h1 class="h2h-page-title">My <span class="accent">Donations</span></h1>
      <p class="h2h-subtitle">Track everything you've contributed.</p>
    </div>
    <a href="donate.php" class="h2h-btn h2h-btn-green h2h-reveal" style="transition-delay:.1s">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
      New Donation
    </a>
  </div>

  <!-- Stats -->
  <div class="h2h-grid-3" style="margin-bottom:36px;">
    <div class="h2h-card h2h-reveal" style="padding:22px 24px;transition-delay:.05s">
      <p style="color:var(--slate);font-size:.78rem;font-weight:600;margin-bottom:8px;text-transform:uppercase;letter-spacing:.8px">Total</p>
      <p style="font-size:2.2rem;font-weight:800;line-height:1"><?php echo $total; ?></p>
    </div>
    <div class="h2h-card h2h-reveal" style="padding:22px 24px;transition-delay:.1s">
      <p style="color:var(--slate);font-size:.78rem;font-weight:600;margin-bottom:8px;text-transform:uppercase;letter-spacing:.8px">Pending</p>
      <p style="font-size:2.2rem;font-weight:800;line-height:1;color:var(--yellow)"><?php echo $pending; ?></p>
    </div>
    <div class="h2h-card h2h-reveal" style="padding:22px 24px;transition-delay:.15s">
      <p style="color:var(--slate);font-size:.78rem;font-weight:600;margin-bottom:8px;text-transform:uppercase;letter-spacing:.8px">Active</p>
      <p style="font-size:2.2rem;font-weight:800;line-height:1;color:var(--green)"><?php echo $active; ?></p>
    </div>
  </div>

  <!-- Items list -->
  <h2 style="font-size:1rem;font-weight:700;color:var(--slate);text-transform:uppercase;letter-spacing:1px;margin-bottom:18px;" class="h2h-reveal">Recent Activity</h2>

  <?php if ($total > 0): ?>
    <div style="display:flex;flex-direction:column;gap:12px;">
      <?php foreach ($my_items as $i => $item):
        $statusMap = [
          'pending'   => 'badge-yellow',
          'approved'  => 'badge-green',
          'reserved'  => 'badge-blue',
          'completed' => 'badge-slate',
          'refused'   => 'badge-red',
        ];
        $badgeClass = $statusMap[$item['status']] ?? 'badge-slate';
      ?>
      <div class="h2h-card h2h-reveal" style="display:flex;align-items:center;gap:18px;padding:18px;transition-delay:<?php echo $i * 40; ?>ms;">
        <!-- Image -->
        <div style="width:72px;height:72px;flex-shrink:0;border-radius:12px;overflow:hidden;background:var(--navy-4);border:1px solid var(--border);">
          <?php if (!empty($item['item_image'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($item['item_image']); ?>" style="width:100%;height:100%;object-fit:cover;" alt="">
          <?php else: ?>
            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:.6rem;color:var(--slate);">NO IMG</div>
          <?php endif; ?>
        </div>

        <!-- Info -->
        <div style="flex:1;min-width:0;">
          <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:4px;">
            <span style="font-size:1rem;font-weight:700;"><?php echo htmlspecialchars($item['item_name']); ?></span>
            <span class="h2h-badge badge-green"><?php echo htmlspecialchars($item['category']); ?></span>
          </div>
          <p style="color:var(--slate);font-size:.8rem;">Qty: <?php echo htmlspecialchars($item['quantity']); ?> &nbsp;·&nbsp; <?php echo htmlspecialchars($item['item_condition']); ?> &nbsp;·&nbsp; <?php echo date('d M Y', strtotime($item['created_at'])); ?></p>
        </div>

        <!-- Status + actions -->
        <div style="display:flex;align-items:center;gap:10px;flex-shrink:0;">
          <span class="h2h-badge <?php echo $badgeClass; ?>"><?php echo $item['status']; ?></span>
          <?php if ($item['status'] === 'pending'): ?>
            <a href="edit_donation.php?id=<?php echo $item['id']; ?>" class="h2h-btn h2h-btn-blue" style="padding:8px 14px;font-size:.78rem;">Edit</a>
            <a href="delete_donation.php?id=<?php echo $item['id']; ?>" onclick="return confirm('Delete this donation?')" class="h2h-btn h2h-btn-red" style="padding:8px 14px;font-size:.78rem;">Delete</a>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="h2h-card h2h-empty h2h-reveal">
      <span class="h2h-empty-icon">🎁</span>
      <p>No donations yet. <a href="donate.php">Make your first one</a></p>
    </div>
  <?php endif; ?>
</main>

<script src="h2h-transition.js"></script>
</body>
</html>
