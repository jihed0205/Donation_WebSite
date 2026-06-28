<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<div id="h2h-overlay"></div>
<header class="h2h-header">
  <a href="index.html" class="h2h-logo">
    <span class="h2h-logo-icon">❤</span>
    Hand2Hand
  </a>
  <nav class="h2h-nav">
    <a href="index.html" class="h2h-back" title="Back to home">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M19 12H5M12 5l-7 7 7 7"/>
      </svg>
      <span>Home</span>
    </a>
    <div class="h2h-user">
      <div class="h2h-avatar"><?php echo strtoupper(substr($_SESSION['display_name'] ?? 'U', 0, 1)); ?></div>
      <span class="h2h-name"><?php echo htmlspecialchars($_SESSION['display_name'] ?? ''); ?></span>
      <span class="h2h-role"><?php echo ucfirst($_SESSION['role'] ?? ''); ?></span>
    </div>
    <a href="logout.php" class="h2h-logout">Logout</a>
  </nav>
</header>
<link rel="stylesheet" href="design-system.css">
<script defer src="h2h-transition.js"></script>
