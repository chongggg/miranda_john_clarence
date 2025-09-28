<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students - Student Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination .page-item {
            list-style: none;
        }

        .pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            color: #374151;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .pagination .page-link:hover {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            transform: scale(1.1);
        }

        .pagination .page-item.active .page-link,
        .pagination-link.active {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .search-container {
            position: relative;
            max-width: 400px;
        }

        .search-input {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid transparent;
            border-radius: 25px;
            padding: 12px 20px 12px 50px;
            width: 100%;
            transition: all 0.3s ease;
            color: #374151;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
        }

        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
        }

        .student-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #374151;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .student-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .action-btn {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .edit-btn {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
        }

        .edit-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.4);
        }

        .delete-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .delete-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        }

        .floating-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .add-student-btn {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .add-student-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        .view-deleted-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .view-deleted-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }

        .per-page-select {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 8px 16px;
            color: #374151;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .per-page-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
        }

        .search-btn {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            border: none;
            border-radius: 0 25px 25px 0;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .search-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        @media (max-width: 768px) {
            .search-container {
                max-width: 100%;
            }
            
            .add-student-btn,
            .view-deleted-btn {
                width: 100%;
                justify-content: center;
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-50 to-indigo-100">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full floating-nav shadow-lg z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <h1 class="text-xl font-bold gradient-text">
                        STUDENT PORTAL
                    </h1>
                    <div class="hidden md:flex space-x-6 ml-8">
                        <a href="<?= site_url('') ?>" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">HOME</a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="<?= site_url('auth/profile') ?>" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600">
                        <span><?= htmlspecialchars(($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? '')) ?></span>
                    </a>

                    <a href="<?= site_url('auth/logout') ?>" class="text-gray-700 hover:text-blue-600 flex items-center space-x-1">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="hidden sm:inline">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <section class="pt-32 pb-8 text-center">
        <div class="max-w-4xl mx-auto px-6">
            <h1 class="text-4xl md:text-6xl font-bold gradient-text mb-4">
                Student Management
            </h1>
            <p class="text-gray-600 text-lg">Manage your students with style and efficiency</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <!-- Action Buttons -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                <?php if ($is_admin): ?>
                <a href="<?= site_url('students/create') ?>" class="add-student-btn">
                    <i class="fas fa-plus"></i>
                    Add New Student
                </a>
                <a href="<?= site_url('students/deleted') ?>" class="view-deleted-btn">
                    <i class="fas fa-trash"></i>
                    View Deleted
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Search and Controls -->
        <div class="mb-8 flex flex-col lg:flex-row gap-6 items-center justify-between">
            <!-- Search Form -->
            <form method="get" action="<?php echo site_url('students'); ?>" class="search-container w-full lg:w-auto">
                <input type="hidden" name="per_page" value="<?php echo $per_page ?? 10; ?>">
                <div class="relative flex">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" 
                           name="search" 
                           id="searchBox"
                           value="<?php echo htmlspecialchars($search ?? ''); ?>"
                           placeholder="Search students..."
                           class="search-input pr-20">
                    <button type="submit" class="search-btn">
                        Search
                    </button>
                </div>
            </form>

            <!-- Per Page Selector -->
            <form method="get" action="<?php echo site_url('students'); ?>" class="flex items-center space-x-3">
                <input type="hidden" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>">
                <span class="text-gray-600 font-medium whitespace-nowrap">Show:</span>
                <select name="per_page" 
                        id="per_page" 
                        class="per-page-select"
                        onchange="this.form.submit()">
                    <option value="10" <?= ($per_page ?? 10) == 10 ? 'selected' : '' ?>>10</option>
                    <option value="25" <?= ($per_page ?? 10) == 25 ? 'selected' : '' ?>>25</option>
                    <option value="50" <?= ($per_page ?? 10) == 50 ? 'selected' : '' ?>>50</option>
                    <option value="100" <?= ($per_page ?? 10) == 100 ? 'selected' : '' ?>>100</option>
                </select>
                <span class="text-gray-600 font-medium whitespace-nowrap">per page</span>
            </form>
        </div>

        <!-- Students Table -->
        <div class="student-card overflow-hidden card-hover">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-6">
                <h2 class="text-2xl font-semibold">Student Directory</h2>
                <p class="text-blue-100 mt-1">Manage and view all registered students</p>
            </div>
            
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Profile</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Role</th>
                            <?php if ($is_admin): ?>
                            <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($students as $row): ?>
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-8 py-6 whitespace-nowrap text-sm font-mono text-blue-600 font-semibold">
                                #<?= $row['id'] ?>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <?php if (isset($row['profile_image']) && $row['profile_image']): ?>
                                    <img src="<?= site_url('public/uploads/' . $row['profile_image']) ?>" 
                                         alt="Profile" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-blue-200">
                                <?php else: ?>
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                        <?= isset($row['first_name']) ? strtoupper(substr($row['first_name'], 0, 1)) : 'U' ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-sm font-medium text-gray-800">
                                <?= htmlspecialchars(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? '')) ?>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap text-sm text-gray-600">
                                <?= htmlspecialchars($row['email'] ?? '') ?>
                            </td>
                            <td class="px-8 py-6 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= (isset($row['role']) && $row['role'] === 'admin') ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' ?>">
                                    <?= ucfirst($row['role'] ?? 'student') ?>
                                </span>
                            </td>
                            <?php if ($is_admin): ?>
                            <td class="px-8 py-6 whitespace-nowrap text-sm space-x-2">
                                <a href="<?= site_url('students/edit/' . $row['id']) ?>" class="action-btn edit-btn">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
                                <a href="<?= site_url('students/delete/' . $row['id']) ?>" 
                                   onclick="return confirm('Are you sure you want to delete this student?')"
                                   class="action-btn delete-btn">
                                    <i class="fas fa-trash mr-1"></i>
                                    Delete
                                </a>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-gray-200">
                <?php foreach ($students as $row): ?>
                <div class="p-6 hover:bg-blue-50 transition-colors">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <?php if (isset($row['profile_image']) && $row['profile_image']): ?>
                                <img src="<?= site_url('public/uploads/' . $row['profile_image']) ?>" 
                                     alt="Profile" 
                                     class="w-12 h-12 rounded-full object-cover border-2 border-blue-200">
                            <?php else: ?>
                                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold">
                                    <?= isset($row['first_name']) ? strtoupper(substr($row['first_name'], 0, 1)) : 'U' ?>
                                </div>
                            <?php endif; ?>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">
                                    <?= htmlspecialchars(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? '')) ?>
                                </h3>
                                <p class="text-blue-600 font-semibold">#<?= $row['id'] ?></p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= (isset($row['role']) && $row['role'] === 'admin') ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' ?>">
                            <?= ucfirst($row['role'] ?? 'student') ?>
                        </span>
                    </div>
                    <div class="mb-4">
                        <p class="text-gray-600 flex items-center">
                            <i class="fas fa-envelope mr-2 text-blue-500"></i>
                            <?= htmlspecialchars($row['email'] ?? '') ?>
                        </p>
                    </div>
                    <?php if ($is_admin): ?>
                    <div class="flex space-x-2">
                        <a href="<?= site_url('students/edit/' . $row['id']) ?>" class="action-btn edit-btn flex-1 justify-center">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                        <a href="<?= site_url('students/delete/' . $row['id']) ?>" 
                           onclick="return confirm('Are you sure you want to delete this student?')" 
                           class="action-btn delete-btn flex-1 justify-center">
                            <i class="fas fa-trash mr-1"></i>Delete
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Pagination -->
        <?php if (isset($pagination_links) && !empty($pagination_links)): ?>
            <div class="mt-8 flex justify-center">
                <?php echo $pagination_links; ?>
            </div>
        <?php endif; ?>
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
                    const currentTable = document.querySelector('table');
                    if (newTable && currentTable) {
                        currentTable.innerHTML = newTable.innerHTML;
                    }
                });
        });

        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';

        // Show loading state for better UX
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('input[type="submit"], button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    const originalText = submitBtn.textContent;
                    submitBtn.textContent = 'Loading...';
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }, 3000);
                }
            });
        });
    });
    </script>
</body>
</html>