<?php
$error = $error ?? '';
$contact = $contact ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Contact</title>
</head>
<body>
    <h1>Edit Contact</h1>
    <a href="index.php">Back to Contacts</a>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars((string)$error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form action="index.php?action=update" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars((string)($contact['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        <p>
            <label>Name:</label><br>
            <input type="text" name="name" required value="<?= htmlspecialchars((string)($contact['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        </p>
        <p>
            <label>Email:</label><br>
            <input type="email" name="email" required value="<?= htmlspecialchars((string)($contact['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        </p>
        <p>
            <label>Phone:</label><br>
            <input type="text" name="phone" required value="<?= htmlspecialchars((string)($contact['phone'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        </p>
        <button type="submit">Update</button>
    </form>
</body>
</html>