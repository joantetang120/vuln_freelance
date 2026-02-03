<?php $title = "Home | VulnMarket"; ob_start(); ?>
<div class="container mx-auto px-4 py-8">
    <header class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Welcome to VulnMarket</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            <?php if (!empty($_SESSION['user_id'])): ?>
                Welcome back, <?= htmlspecialchars($_SESSION['username']) ?>! Ready to find your next opportunity?
            <?php else: ?>
                Connecting top talent with businesses worldwide through our secure freelance platform
            <?php endif; ?>
        </p>
    </header>

    <?php if (!empty($_SESSION['user_id'])): ?>
        <!-- Logged-in User Content -->
        <section class="grid md:grid-cols-3 gap-8 mb-16">
            <!-- Quick Actions -->
            <a href="index.php?page=jobs" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <div class="text-blue-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Browse Jobs</h3>
                <p class="text-gray-600">
                    Find your next freelance opportunity from thousands of listings.
                </p>
            </a>

            <a href="index.php?page=sendmsg" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <div class="text-green-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Messages</h3>
                <p class="text-gray-600">
                    Check your inbox and communicate with clients or freelancers.
                </p>
            </a>

            <a href="index.php?page=createjob" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <div class="text-purple-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Post a Job</h3>
                <p class="text-gray-600">
                    Need work done? Create a new job listing to attract talent.
                </p>
            </a>
        </section>

        <!-- Recent Activity Section -->
        <section class="mb-16">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Your Recent Activity</h2>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 text-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-gray-700">You have 3 new messages in your inbox</p>
                            <p class="text-sm text-gray-500">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 text-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-gray-700">Your application for "Web Developer" was viewed</p>
                            <p class="text-sm text-gray-500">1 day ago</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="index.php?page=dashboard" class="text-blue-600 hover:text-blue-800 font-medium">View full dashboard →</a>
                </div>
            </div>
        </section>

    <?php else: ?>
        <!-- Guest User Content -->
        <section class="grid md:grid-cols-3 gap-8 mb-16">
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <div class="text-blue-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Find Perfect Projects</h3>
                <p class="text-gray-600">
                    Browse thousands of job postings across all industries and skill levels.
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <div class="text-green-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Secure Payments</h3>
                <p class="text-gray-600">
                    Our escrow system ensures you get paid for work completed.
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <div class="text-purple-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Build Your Network</h3>
                <p class="text-gray-600">
                    Connect with professionals and grow your freelance business.
                </p>
            </div>
        </section>

        <section class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-8 md:p-12 mb-16">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Ready to get started?</h2>
                <p class="text-gray-600 mb-6 text-lg">
                    Join thousands of freelancers and businesses already growing with VulnMarket.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="index.php?page=register" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                        Sign Up Free
                    </a>
                    <a href="index.php?page=how-it-works" class="bg-white hover:bg-gray-100 text-gray-800 font-medium py-3 px-6 rounded-lg border border-gray-300 transition-colors">
                        Learn More
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Common Content (shown to both logged-in and guest users) -->
    <section class="mb-16">
        <h2 class="text-2xl font-bold text-center mb-8 text-gray-800">Featured Job Categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="index.php?page=jobs&category=web-development" class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                <div class="text-blue-500 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </div>
                <span class="font-medium text-gray-700">Web Development</span>
            </a>
            
            <a href="index.php?page=jobs&category=graphic-design" class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                <div class="text-pink-500 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="font-medium text-gray-700">Graphic Design</span>
            </a>
            
            <a href="index.php?page=jobs&category=digital-marketing" class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                <div class="text-green-500 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <span class="font-medium text-gray-700">Digital Marketing</span>
            </a>
            
            <a href="index.php?page=jobs&category=writing-translation" class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                <div class="text-yellow-500 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <span class="font-medium text-gray-700">Writing & Translation</span>
            </a>
        </div>
    </section>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/layout.php'; ?>