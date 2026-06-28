<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$search     = $_GET['search'] ?? '';
$cat_filter = $_GET['category'] ?? '';

$query  = "SELECT * FROM items WHERE status = 'approved'";
$params = [];
if ($search)     { $query .= " AND item_name LIKE ?"; $params[] = "%$search%"; }
if ($cat_filter) { $query .= " AND category = ?";     $params[] = $cat_filter; }
$query .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Browse Donations | Hand2Hand</title>
  <link rel="stylesheet" href="design-system.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="h2h-main">
  <div class="h2h-reveal" style="margin-bottom:28px;">
    <h1 class="h2h-page-title">Available <span class="accent">Donations</span></h1>
    <p class="h2h-subtitle">Find items approved and ready for reservation.</p>
  </div>

  <!-- Filter bar -->
  <form method="GET" class="h2h-card h2h-reveal" style="padding:18px;display:flex;gap:12px;flex-wrap:wrap;margin-bottom:28px;transition-delay:.1s">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by name…" class="h2h-input" style="flex:1;min-width:180px;">
    <select name="category" class="h2h-select" style="min-width:160px;">
      <option value="">All Categories</option>
      <?php foreach (['Food','Clothes','Medical','Other'] as $cat): ?>
        <option value="<?php echo $cat; ?>" <?php if ($cat_filter === $cat) echo 'selected'; ?>><?php echo $cat; ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="h2h-btn h2h-btn-green">Filter</button>
  </form>

  <!-- Grid -->
  <?php if (count($items) > 0): ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px;">
      <?php foreach ($items as $i => $item): ?>
      <div class="h2h-card hoverable h2h-reveal" style="overflow:hidden;display:flex;flex-direction:column;transition-delay:<?php echo $i * 50; ?>ms;">
        <div style="height:200px;overflow:hidden;background:var(--navy-4);">
          <?php if (!empty($item['item_image'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($item['item_image']); ?>" style="width:100%;height:100%;object-fit:cover;transition:transform .4s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" alt="">
          <?php else: ?>
            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--slate);font-size:.8rem;">No image</div>
          <?php endif; ?>
        </div>
        <div style="padding:20px;flex:1;display:flex;flex-direction:column;gap:10px;">
          <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
            <span style="font-weight:700;font-size:1rem;"><?php echo htmlspecialchars($item['item_name']); ?></span>
            <span class="h2h-badge badge-green"><?php echo htmlspecialchars($item['category']); ?></span>
          </div>
          <p style="color:var(--slate);font-size:.83rem;line-height:1.5;flex:1;"><?php echo htmlspecialchars(mb_strimwidth($item['description'], 0, 80, '…')); ?></p>
          <p style="color:var(--slate);font-size:.78rem;">Qty: <?php echo htmlspecialchars($item['quantity']); ?> &nbsp;·&nbsp; <?php echo htmlspecialchars($item['item_condition']); ?></p>
          <a href="reserve_item.php?id=<?php echo $item['id']; ?>" class="h2h-btn h2h-btn-ghost h2h-btn-full" style="margin-top:4px;">Reserve</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="h2h-card h2h-empty h2h-reveal">
      <span class="h2h-empty-icon">🔍</span>
      <p>No donations match your search. Try different filters.</p>
    </div>
  <?php endif; ?>
</main>

<script src="h2h-transition.js"></script>
</body>
</html>
