<?php $title = "Sent Messages"; ob_start(); ?>
<div class="max-w-3xl mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4">Sent Messages</h2>
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">To</th>
                <th class="p-2 border">Subject</th>
                <th class="p-2 border">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($messages as $msg): ?>
            <tr>
                <td class="border p-2"><?= htmlspecialchars($msg['receiver']) ?></td>
                <td class="border p-2"><?= $msg['subject'] ?></td>
                <td class="border p-2"><?= $msg['created_at'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
