<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Offre d'emploi | Hand2Hand</title>
  <link rel="stylesheet" href="design-system.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="h2h-main-sm">
  <div class="h2h-reveal" style="margin-bottom:28px;">
    <h1 class="h2h-page-title">Publier une <span class="accent">Offre</span></h1>
    <p class="h2h-subtitle">Partagez une opportunité d'emploi avec la communauté Hand2Hand.</p>
  </div>

  <div class="h2h-card h2h-reveal" style="padding:36px;transition-delay:.1s">
    <form action="process_job_offer.php" method="POST" style="display:flex;flex-direction:column;gap:20px;">
      <div>
        <label class="h2h-label">Intitulé du poste</label>
        <input type="text" name="job_title" required placeholder="Ex: Coordinateur terrain" class="h2h-input">
      </div>
      <div>
        <label class="h2h-label">Entreprise / Association</label>
        <input type="text" name="company" required placeholder="Nom de l'organisation" class="h2h-input">
      </div>
      <div>
        <label class="h2h-label">Localisation</label>
        <input type="text" name="location" required placeholder="Ex: Tunis, Sfax…" class="h2h-input">
      </div>
      <div>
        <label class="h2h-label">Description du poste</label>
        <textarea name="description" required rows="5" placeholder="Décrivez les missions, compétences requises…" class="h2h-textarea"></textarea>
      </div>
      <button type="submit" class="h2h-btn h2h-btn-green h2h-btn-full" style="padding:15px;font-size:.95rem;">Publier l'offre</button>
    </form>
  </div>
</main>

<script src="h2h-transition.js"></script>
</body>
</html>
