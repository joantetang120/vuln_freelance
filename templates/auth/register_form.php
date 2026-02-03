<?php $title = "Register"; ob_start(); ?>
<div class="max-w-md mx-auto bg-white shadow-md rounded p-6 mt-10">
    <h2 class="text-2xl font-bold mb-4">Create Account</h2>
    <?php if (!empty($message)) : ?>
        <p class="bg-blue-100 text-blue-700 p-2 rounded mb-4"><?= $message ?></p>
    <?php endif; ?>
    <form action="" method="POST" class="space-y-4">
        <input type="text" name="username" placeholder="Username" 
            class="w-full p-2 border rounded" required>
        <input type="email" name="email" placeholder="Email"
            class="w-full p-2 border rounded" required>
        <input type="password" name="password" placeholder="Password" 
            class="w-full p-2 border rounded" required>
        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Register</button>
    </form>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
