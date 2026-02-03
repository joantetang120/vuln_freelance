<?php $title = "View Job"; ob_start(); ?>
<div class="max-w-2xl mx-auto bg-white shadow p-6 rounded mt-10">
    <h2 class="text-2xl font-bold mb-4"><?= htmlspecialchars($job['title']) ?></h2>
    <p class="mb-4"><?= nl2br(htmlspecialchars($job['description'])) ?></p>
    <p class="text-sm text-gray-600 mb-6">Posted by <?= htmlspecialchars($job['username']) ?></p>
    <?php if (!empty($message)): ?>
        <p class="bg-green-100 text-green-700 p-2 rounded mb-4"><?= $message ?></p>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
    <input type="file" name="cv" required class="border p-2 mb-4 w-full">
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Apply with CV</button>
</form>

</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
