<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// 1. Fetch the existing donation
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ? AND user_id = ? AND status = 'pending'");
$stmt->execute([$id, $_SESSION['user_id']]);
$item = $stmt->fetch();

// If not found or not pending, kick them out
if (!$item) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Donation | Hand2Hand</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #05080f; color: white; font-family: 'Inter', sans-serif; }
        .glass-card { background: rgba(17, 24, 39, 0.7); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .glass-input { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: white; }
        .glass-input:focus { border-color: #10b981; outline: none; }
    </style>
</head>
<body class="pt-20">
    <?php include 'header.php'; ?>

    <div class="max-w-2xl mx-auto p-6">
        <div class="glass-card rounded-3xl p-8 shadow-2xl">
            <h2 class="text-3xl font-bold mb-2 uppercase tracking-tight">Modify <span class="text-emerald-500">Donation</span></h2>
            <p class="text-slate-400 mb-8 text-sm text-italic">You can only edit while your request is still pending.</p>

            <form action="process_edit.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">

                <div>
                    <label class="block text-sm font-semibold mb-2 text-emerald-500">Item Name</label>
                    <input type="text" name="item_name" required value="<?php echo htmlspecialchars($item['item_name']); ?>" class="glass-input w-full p-4 rounded-xl">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-emerald-500">Category</label>
                        <select name="category" class="glass-input w-full p-4 rounded-xl">
                            <?php 
                            $cats = ['Food', 'Clothes', 'Medical', 'Other'];
                            foreach($cats as $c) {
                                $sel = ($item['category'] == $c) ? 'selected' : '';
                                echo "<option value='$c' $sel>$c</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-emerald-500">Quantity</label>
                        <input type="text" name="quantity" required value="<?php echo htmlspecialchars($item['quantity']); ?>" class="glass-input w-full p-4 rounded-xl">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-emerald-500">Condition</label>
                        <select name="item_condition" class="glass-input w-full p-4 rounded-xl">
                            <?php 
                            $conds = ['New', 'Like New', 'Good', 'Fair'];
                            foreach($conds as $cond) {
                                $sel = ($item['item_condition'] == $cond) ? 'selected' : '';
                                echo "<option value='$cond' $sel>$cond</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-emerald-500">Contact Phone</label>
                        <input type="tel" name="contact_phone" required value="<?php echo htmlspecialchars($item['contact_phone']); ?>" class="glass-input w-full p-4 rounded-xl">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2 text-emerald-500">Extra Details</label>
                    <textarea name="description" rows="3" required class="glass-input w-full p-4 rounded-xl"><?php echo htmlspecialchars($item['description']); ?></textarea>
                </div>

                <div class="flex gap-4">
                    <a href="dashboard.php" class="w-1/3 bg-slate-800 text-center py-4 rounded-full font-bold hover:bg-slate-700 transition-all">Cancel</a>
                    <button type="submit" class="w-2/3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-full transition-all shadow-lg shadow-emerald-500/20">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>