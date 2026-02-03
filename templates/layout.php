<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'VulnMarket - Freelance Marketplace') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
    const BASE_PATH = "<?php echo dirname($_SERVER['PHP_SELF']); ?>/";
</script>
</head>
<body class="bg-gray-50 text-gray-900 flex flex-col min-h-screen">
    <!-- Enhanced Header -->
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4">
            <nav class="flex items-center justify-between py-4">
                <!-- Logo/Brand -->
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <a href="index.php" class="text-2xl font-bold text-gray-800 hover:text-blue-600 transition-colors">VulnMarket</a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Home</a>
                    <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="index.php?page=applications" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Applications</a>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="index.php?page=admin" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Admin Dash</a>
                    <?php endif; ?>
                    <a href="index.php?page=jobs" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Browse Jobs</a>
                    <a href="index.php?page=freelancers" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Find Freelancers</a>
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <div class="relative group">
                            <button class="text-gray-600 hover:text-blue-600 transition-colors font-medium flex items-center">
                                Messages <i class="fas fa-chevron-down ml-1 text-xs"></i>
                            </button>
                            <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-md mt-2 py-2 w-48 z-10">
                                <a href="index.php?page=inbox" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Inbox</a>
                                <a href="index.php?page=sentmsg" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Sent</a>
                                <a href="index.php?page=sendmsg" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Compose</a>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <div class="relative group">
                            <button class="flex items-center space-x-1 text-gray-600 hover:text-blue-600 transition-colors font-medium">
                            <span><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-md mt-2 py-2 w-48 right-0 z-10">
                                <a href="index.php?page=profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="index.php?page=dashboard" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                <a href="index.php?page=logout" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 border-t border-gray-100">Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="index.php?page=login" class="text-gray-600 hover:text-blue-600 transition-colors font-medium hidden md:block">Log In</a>
                        <a href="index.php?page=register" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">Sign Up</a>
                    <?php endif; ?>
                    
                    <!-- Mobile menu button -->
                    <button class="md:hidden text-gray-600 focus:outline-none" aria-controls="mobile-menu">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </nav>
        </div>

        <!-- Mobile Navigation (hidden by default) -->
        <div class="md:hidden bg-white border-t border-gray-200 hidden" id="mobile-menu">
            <div class="px-4 py-3 space-y-3">
                <a href="index.php" class="block text-gray-600 hover:text-blue-600">Home</a>
                <a href="index.php?page=jobs" class="block text-gray-600 hover:text-blue-600">Browse Jobs</a>
                <a href="index.php?page=freelancers" class="block text-gray-600 hover:text-blue-600">Find Freelancers</a>
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <a href="index.php?page=profile" class="block text-gray-600 hover:text-blue-600">Profile</a>
                    <a href="index.php?page=dashboard" class="block text-gray-600 hover:text-blue-600">Dashboard</a>
                    <a href="/vuln-marketplace/src/auth/logout.php" class="block text-gray-600 hover:text-blue-600">Logout</a>
                <?php else: ?>
                    <a href="index.php?page=login" class="block text-gray-600 hover:text-blue-600">Log In</a>
                    <a href="index.php?page=register" class="block text-blue-600 font-medium">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow min-h-[100vh] container mx-auto px-4 py-8">
        <?= $content ?? '' ?>
    </main>

    <!-- Professional Footer -->
    <footer class="bg-gray-800 text-gray-300 py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">VulnMarket</h3>
                    <p class="mb-4">Connecting businesses with top freelance talent worldwide.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="index.php?page=jobs" class="hover:text-white transition-colors">Browse Jobs</a></li>
                        <li><a href="index.php?page=freelancers" class="hover:text-white transition-colors">Find Freelancers</a></li>
                        <li><a href="index.php?page=about" class="hover:text-white transition-colors">About Us</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <?php if (!empty($_SESSION['user_id'])): ?>
                 <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Messages</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php?page=inbox" class="hover:text-white transition-colors">Inbox</a></li>
                        <li><a href="index.php?page=sentmsg" class="hover:text-white transition-colors">Sent</a></li>
                        <li><a href="index.php?page=sendmsg" class="hover:text-white transition-colors">Compose</a></li>
                    </ul>
                </div>
                <?php endif; ?>
             


                <!-- Newsletter -->
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Newsletter</h3>
                    <p class="mb-4">Subscribe to get updates on new jobs and freelancers.</p>
                    <form class="flex">
                        <input type="email" placeholder="Your email" class="px-4 py-2 rounded-l-md focus:outline-none text-gray-900 w-full">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-md transition-colors">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; <?= date('Y') ?> VulnMarket. All rights reserved.</p>
                <div class="mt-2 space-x-4">
                    <a href="index.php?page=terms" class="hover:text-white transition-colors">Terms</a>
                    <a href="index.php?page=privacy" class="hover:text-white transition-colors">Privacy</a>
                    <a href="index.php?page=cookies" class="hover:text-white transition-colors">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.querySelector('button[aria-controls="mobile-menu"]').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const searchInput = document.querySelector('input[name="q"]');
    // Remove common SQL injection patterns
    searchInput.value = searchInput.value
        .replace(/'/g, '')       
        .replace(/--/g, '')   
        .replace(/;/g, '')     
        .replace(/\b(OR|AND|DROP|DELETE|INSERT|UPDATE|SELECT|UNION|EXEC)\b/gi, '');
});
</script>

</body>
</html>