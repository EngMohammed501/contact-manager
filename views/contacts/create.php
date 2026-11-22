<?php
$error = $error ?? '';
$old = $old ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Contact</title>
</head>
<body>
    <h1>Add Contact</h1>
    <a href="index.php">Back to Contacts</a>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars((string)$error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form action="index.php?action=store" method="POST">
        <p>
            <label>Name:</label><br>
            <input type="text" name="name" required value="<?= htmlspecialchars((string)($old['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        </p>
        <p>
            <label>Email:</label><br>
            <input type="email" name="email" required value="<?= htmlspecialchars((string)($old['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        </p>
        <p>
            <label>Phone:</label><br>
            <input type="text" name="phone" required value="<?= htmlspecialchars((string)($old['phone'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        </p>
        <button type="submit">Save</button>
    </form>
</body>
</html>