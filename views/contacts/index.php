<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$contacts = $contacts ?? [];
$isLoggedIn = $isLoggedIn ?? false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contacts</title>
</head>
<body>
    <h1>Contact Manager</h1>

    <div>
        <?php if ($isLoggedIn): ?>
            <a href="index.php?action=create">Add Contact</a> |
            <a href="index.php?action=logout">Logout</a>
        <?php else: ?>
            <a href="index.php?action=login">Admin Login</a>
        <?php endif; ?>
    </div>

    <br>

    <table border="1" cellpadding="6" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Created At</th>
            <?php if ($isLoggedIn): ?>
                <th>Actions</th>
            <?php endif; ?>
        </tr>

        <?php if (!empty($contacts)): ?>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= htmlspecialchars((string)($contact['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars((string)($contact['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars((string)($contact['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars((string)($contact['phone'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars((string)($contact['created_at'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>

                    <?php if ($isLoggedIn): ?>
                        <td>
                            <a href="index.php?action=edit&id=<?= urlencode((string)($contact['id'] ?? '')) ?>">Edit</a>
                            |
                            <form action="index.php?action=delete" method="POST" style="display:inline;" onsubmit="return confirm('Delete this contact?');">
                                <input type="hidden" name="id" value="<?= htmlspecialchars((string)($contact['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="<?= $isLoggedIn ? 6 : 5 ?>">No contacts found.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>