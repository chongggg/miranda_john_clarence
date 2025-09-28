<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students - Student Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'modern': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
    .pagination-link.active {
        background-color: #4358acff;
        box-shadow: 0 0 6px rgba(59, 130, 246, 0.5);
        font-weight: 600;
    }
    </style>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-gray-900 to-black font-modern">
    <!-- Navigation -->
    <nav class="bg-black/20 backdrop-blur-sm border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                        STUDENT PORTAL
                    </h1>
                    <div class="hidden md:flex space-x-6">
                        <a href="<?= site_url('') ?>" class="text-white hover:text-blue-400 transition-colors font-medium">HOME</a>
                    </div>
                </div>
                
                    <div class="flex items-center space-x-4">
                        <a href="<?= site_url('auth/profile') ?>" class="flex items-center space-x-2 text-white hover:text-blue-400">
                            <span><?= htmlspecialchars(($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? '')) ?></span>
                        </a>

                        <a href="<?= site_url('auth/logout') ?>" class="text-white hover:text-blue-400 flex items-center space-x-1">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-8 lg:mb-0">
                    <h1 class="text-5xl lg:text-6xl font-bold text-white mb-4 tracking-tight">
                        STUDENT
                        <span class="block bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
                            MANAGEMENT
                        </span>
                    </h1>
                </div>
                <?php if ($is_admin): ?>
                <div class="flex-shrink-0">
                    <a href="<?= site_url('students/create') ?>" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add New Student
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex justify-between items-center mb-4">
            <div class="flex gap-4">
                <h1 class="text-2xl font-bold"></h1>
                <?php if ($is_admin): ?>
                <a href="<?= site_url('students/deleted') ?>" 
                   class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">
                    <i class="fas fa-trash mr-2"></i>View Deleted
                </a>
                <?php endif; ?>
            </div>
            <div class="flex gap-4">
                <!-- Per Page Selector -->
                <form method="get" action="<?php echo site_url('students'); ?>" class="flex items-center">
                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>">
                    <label for="per_page" class="text-white mr-2">Per page:</label>
                    <select name="per_page" id="per_page" onchange="this.form.submit()" 
                            class="px-3 py-2 bg-gray-800 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                        <option value="10" <?= ($per_page ?? 10) == 10 ? 'selected' : '' ?>>10</option>
                        <option value="25" <?= ($per_page ?? 10) == 25 ? 'selected' : '' ?>>25</option>
                        <option value="50" <?= ($per_page ?? 10) == 50 ? 'selected' : '' ?>>50</option>
                        <option value="100" <?= ($per_page ?? 10) == 100 ? 'selected' : '' ?>>100</option>
                    </select>
                </form>
                
                <!-- Search Form -->
                <form method="get" action="<?php echo site_url('students'); ?>" class="flex">
                    <input type="hidden" name="per_page" value="<?php echo $per_page ?? 10; ?>">
                    <input type="text" name="search" id="searchBox"
                        value="<?php echo htmlspecialchars($search ?? ''); ?>"
                        placeholder="Search..."
                        class="px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring focus:border-blue-300">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600">
                        Search
                    </button>
                </form>
            </div>
        </div>


        <!-- Students Table -->
        <div class="bg-white/5 backdrop-blur-sm rounded-2xl border border-gray-800 overflow-hidden shadow-2xl">
            <div class="px-8 py-6 border-b border-gray-800">
                <h2 class="text-2xl font-semibold text-white">Student Directory</h2>
                <p class="text-gray-400 mt-1">Manage and view all registered students</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-900/50">
                        <tr>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">Profile</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">Email</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">Role</th>
                            <?php if ($is_admin): ?>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        <?php foreach ($students as $row): ?>
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-8 py-6 whitespace-nowrap text-sm font-mono text-gray-400">
                                #<?= $row['id'] ?>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <?php if (isset($row['profile_image']) && $row['profile_image']): ?>
                                    <img src="<?= site_url('public/uploads/' . $row['profile_image']) ?>" 
                                         alt="Profile" 
                                         class="w-10 h-10 rounded-full object-cover">
                                <?php else: ?>
                                    <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center text-white font-semibold text-sm">
                                        <?= isset($row['first_name']) ? strtoupper(substr($row['first_name'], 0, 1)) : 'U' ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-sm font-medium text-white">
                                <?= htmlspecialchars(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? '')) ?>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-sm text-blue-400">
                                <?= htmlspecialchars($row['email'] ?? '') ?>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= (isset($row['role']) && $row['role'] === 'admin') ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' ?>">
                                    <?= ucfirst($row['role'] ?? 'student') ?>
                                </span>
                            </td>
                            <?php if ($is_admin): ?>
                            <td class="px-8 py-6 whitespace-nowrap text-sm space-x-3">
                                <a href="<?= site_url('students/edit/' . $row['id']) ?>" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 hover:text-blue-300 rounded-lg transition-all duration-200 border border-blue-500/30">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </a>
                                <a href="<?= site_url('students/delete/' . $row['id']) ?>" 
                                   onclick="return confirm('Are you sure you want to delete this student?')"
                                   class="inline-flex items-center px-4 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-400 hover:text-red-300 rounded-lg transition-all duration-200 border border-red-500/30">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </a>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (isset($pagination_links) && !empty($pagination_links)): ?>
            <div class="mt-6">
                <?php echo $pagination_links; ?>
            </div>
        <?php endif; ?>


    </div>

    <!-- Background Elements -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchBox = document.getElementById('searchBox');
        searchBox.addEventListener('keyup', function(e) {
            const query = this.value;
            fetch('<?php echo site_url("students/index"); ?>?search=' + query)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTable = doc.querySelector('table');
                    document.querySelector('table').innerHTML = newTable.innerHTML;
                });
        });
    });
    </script>
</body>
</html>