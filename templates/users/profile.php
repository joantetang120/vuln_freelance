<?php $title = "My Profile"; ob_start(); ?>
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Update Profile</h2>
    <?php if(!empty($message)): ?>
        <p class="bg-green-100 text-green-700 p-2 rounded mb-4"><?= $message ?></p>
    <?php endif; ?>
    <form id="profile-form" method="POST" action="#" class="space-y-4">

        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" class="border p-2 w-full rounded" required>
        
        <input type="password" name="password" placeholder="New Password" class="border p-2 w-full rounded">
        <input type="file" name="profile_pic" class="border p-2 w-full rounded">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Changes</button>
    </form>
</div>

   

<script>


// ⚠️ DEBUG ONLY – REMOVE IN PRODUCTION!
console.debug("allowedRole:", "<?= md5($_SESSION['user_id'] . 'admin') ?>");
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("#profile-form");
    if (!form) {
        console.error("Form not found!");
        return;
    }

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        try {
            const res = await fetch("index.php?page=api/profile", {
                method: "POST",
                body: formData
            });

            // Check response content type before parsing JSON
            const contentType = res.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                const text = await res.text();
                console.error("Server returned HTML instead of JSON:", text);
                alert("Server error. Check console for details.");
                return;
            }

            const result = await res.json();
        let msg = result.message;
        if (result.file) {
            msg += `\nUploaded file: ${result.file}`;
        }
        alert(msg);

        } catch (err) {
            console.error("Fetch error:", err);
            alert("Something went wrong.");
        }
    });
});
</script>


<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
