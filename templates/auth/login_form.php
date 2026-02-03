<?php $title = "Login"; ob_start(); ?>
<div class="max-w-md mx-auto bg-white shadow-md rounded p-6 mt-10">
    <h2 class="text-2xl font-bold mb-4">Login</h2>
    <?php if (!empty($message)) : ?>
        <p class="bg-red-100 text-red-700 p-2 rounded mb-4"><?= $message ?></p>
    <?php endif; ?>
    <form action="" method="POST" class="space-y-4">
        <input type="email" name="email" placeholder="Email"
            class="w-full p-2 border rounded" required>
        <input type="password" name="password" placeholder="Password" 
            class="w-full p-2 border rounded" required>
        <button type="submit" class="w-full bg-green-600 text-white p-2 rounded">Login</button>
    </form>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
