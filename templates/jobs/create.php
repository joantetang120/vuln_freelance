<?php $title = "Create Job"; ob_start(); ?>
<div class="max-w-xl mx-auto bg-white shadow p-6 rounded mt-10">
    <h2 class="text-2xl font-bold mb-4">Create a New Job</h2>
    <?php if (!empty($message)): ?>
        <p class="bg-green-100 text-green-700 p-2 rounded mb-4"><?= $message ?></p>
    <?php endif; ?>
    <form method="POST" class="space-y-4">
        <input type="text" name="title" placeholder="Job Title" class="w-full p-2 border rounded" required>
        <textarea name="description" placeholder="Job Description" class="w-full p-2 border rounded" required></textarea>
        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Create Job</button>
    </form>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
