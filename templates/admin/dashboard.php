<?php $title = "Admin Dashboard"; ob_start(); ?>
<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Admin Dashboard</h2>
    <table class="w-full border">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $u): ?>
                <tr>
                    <td class="border p-2"><?= $u['id'] ?></td>
                    <td class="border p-2"><?= htmlspecialchars($u['username']) ?></td>
                    <td class="border p-2"><?= $u['role'] ?></td>
                    <td class="border p-2 space-y-1">
                        <!-- Delete user -->
                        <form method="POST" action="index.php?page=delete_user" onsubmit="return confirm('Are you sure?');">
                            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>

                        <!-- Confirm user -->
                        <?php if (!$u['confirmed']): ?>
                            <form method="POST" action="index.php?page=confirm_user" onsubmit="return confirm('Confirm this ?');">
                                <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                <button type="submit" class="text-green-600 hover:underline">Confirm</button>
                            </form>
                        <?php endif; ?>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
