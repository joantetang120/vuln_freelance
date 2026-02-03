<?php $title = "All Applications"; ob_start(); ?>
<div class="max-w-4xl mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4">All Applications (Admin)</h2>
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Job Title</th>
                <th class="p-2 border">Applicant</th>
                <th class="p-2 border">CV</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($applications as $app): ?>
            <tr>
                <td class="border p-2"><?= $app['id'] ?></td>
                <td class="border p-2"><?= htmlspecialchars($app['job_title']) ?></td>
                <td class="border p-2"><?= htmlspecialchars($app['applicant']) ?></td>
                <td class="border p-2">
                    <a href="index.php?page=download&file=<?= urlencode($app['cv_path']) ?>" 
                       class="text-blue-600 underline">Download CV</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
