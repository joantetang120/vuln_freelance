<?php $title = "Send Message"; ob_start(); ?>
<?php
if (session_status() === PHP_SESSION_NONE) session_start(); // just to be safe
$currentUser = [
    'id' => $_SESSION['user_id'] ?? null,
    'username' => $_SESSION['username'] ?? '',
    'role' => $_SESSION['role'] ?? 'user'
];

?>
<div class="max-w-xl mx-auto bg-white shadow p-6 rounded mt-10">
    <h2 class="text-2xl font-bold mb-4">Send a Message</h2>
    <?php if(!empty($message)): ?>
        <p class="bg-green-100 text-green-700 p-2 rounded mb-4"><?= $message ?></p>
    <?php endif; ?>
    <form method="POST" class="space-y-4">
        <select name="receiver_id" class="border p-2 rounded w-full" required>
            <?php foreach($users as $user): ?>
                <?php
                    if ($user['role'] === 'admin' && $currentUser['role'] !== 'admin') {
                        continue;
                    }
                ?>
                <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['username']) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="subject" placeholder="Subject" class="border p-2 rounded w-full" required>
        <textarea name="body" placeholder="Your message" class="border p-2 rounded w-full" required></textarea>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Send</button>
    </form>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
