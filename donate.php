<?php
include 'header.php';
if ($_SESSION['role'] !== 'user') {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donate | Hand2Hand</title>
  <link rel="stylesheet" href="design-system.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="h2h-main-sm">
  <div class="h2h-reveal" style="margin-bottom:28px;">
    <h1 class="h2h-page-title">Donate an <span class="accent">Item</span></h1>
    <p class="h2h-subtitle">Your item will be reviewed before going live to associations.</p>
  </div>

  <div class="h2h-card h2h-reveal" style="padding:36px;transition-delay:.1s">
    <form action="process_donation.php" method="POST" enctype="multipart/form-data" style="display:flex;flex-direction:column;gap:20px;">

      <div>
        <label class="h2h-label">Item Photo</label>
        <input type="file" name="item_image" accept="image/*" required class="h2h-input"
          style="padding:10px 16px;cursor:pointer;">
      </div>

      <div>
        <label class="h2h-label">Item Name</label>
        <input type="text" name="item_name" required placeholder="e.g., Winter Jackets" class="h2h-input">
      </div>

      <div class="h2h-grid-2">
        <div>
          <label class="h2h-label">Category</label>
          <select name="category" class="h2h-select">
            <option>Food</option>
            <option>Clothes</option>
            <option>Medical</option>
            <option>Other</option>
          </select>
        </div>
        <div>
          <label class="h2h-label">Quantity</label>
          <input type="text" name="quantity" required placeholder="e.g., 5 units / 2kg" class="h2h-input">
        </div>
      </div>

      <div class="h2h-grid-2">
        <div>
          <label class="h2h-label">Condition</label>
          <select name="item_condition" class="h2h-select">
            <option>New</option>
            <option>Like New</option>
            <option>Good</option>
            <option>Fair</option>
          </select>
        </div>
        <div>
          <label class="h2h-label">Contact Phone</label>
          <input type="tel" name="contact_phone" required placeholder="Your phone number" class="h2h-input">
        </div>
      </div>

      <div>
        <label class="h2h-label">Extra Details</label>
        <textarea name="description" rows="3" required placeholder="Anything the association should know?" class="h2h-textarea"></textarea>
      </div>

      <button type="submit" class="h2h-btn h2h-btn-green h2h-btn-full" style="padding:15px;font-size:.95rem;">Submit Donation</button>
    </form>
  </div>
</main>

<script src="h2h-transition.js"></script>
</body>
</html>
