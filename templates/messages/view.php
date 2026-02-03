<?php $title = "View Message"; ob_start(); ?>
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h3 class="text-xl font-bold mb-2"><?= htmlspecialchars($message['subject']) ?></h3>
    <p class="text-gray-600 mb-4">From: <?= htmlspecialchars($message['sender']) ?></p>
    <?php
    // --- Hard Mode Filter ---
    function safeMessage($html) {
        // 1. Strip script tags completely
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);

        // 2. Remove inline event handlers (onclick, onerror, onload...)
        $html = preg_replace('/on\w+\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/i', '', $html);

        // 3. Remove javascript: and vbscript: protocols
        $html = preg_replace('/(javascript:|vbscript:)/i', '', $html);

        // 4. Only allow "safe" tags (false sense of security)
        $allowedTags = '<b><i><u><p><br><a><strong><em>';
        return strip_tags($html, $allowedTags);
    }

    // Apply the flawed sanitizer
    $cleanBody = safeMessage($message['body']);
    ?>
    <!-- Render cleaned but still vulnerable HTML -->
    <div class="prose"><?= $cleanBody ?></div>

    <p class="text-sm text-gray-500 mt-4"><?= $message['created_at'] ?></p>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
roj