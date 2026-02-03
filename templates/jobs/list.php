<?php $title = "Job Listings"; ob_start(); ?>
<div class="flex justify-between mb-4">
    <form method="GET" class="flex">
        <input type="hidden" name="page" value="jobs">
        <input type="text" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" 
               placeholder="Search jobs..." class="border p-2 rounded-l">
        <button type="submit" class="bg-blue-600 text-white px-4 rounded-r">Search</button>
    </form>
    <?php if (!empty($_SESSION['user_id'])): ?>
        <a href="index.php?page=createjob" class="bg-green-600 text-white px-4 py-2 rounded">+ Create Job</a>
    <?php endif; ?>
</div>
<div class="grid grid-cols-1 gap-4">
    <?php foreach($jobs as $job): ?>
    <div class="bg-white p-4 shadow rounded">
        <h3 class="text-xl font-bold">
            <a href="index.php?page=viewjob&id=<?= $job['id'] ?>"><?= htmlspecialchars($job['title']) ?></a>
        </h3>
        <p class="mt-2"><?= htmlspecialchars(substr($job['description'], 0, 100)) ?>...</p>
        <p class="text-gray-600 text-sm">Posted by <?= htmlspecialchars($job['username']) ?></p>
    </div>
    <?php endforeach; ?>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
