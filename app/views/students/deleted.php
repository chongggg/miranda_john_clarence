<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleted Students - Student Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(18px) saturate(180%);
            -webkit-backdrop-filter: blur(18px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .floating-nav {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(18px) saturate(180%);
            -webkit-backdrop-filter: blur(18px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .icon-container {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }

        .fade-in {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(20px);
            }
            to { 
                opacity: 1; 
                transform: translateY(0);
            }
        }

        .table-row {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .table-row:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }

        .restore-btn {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.4);
            transition: all 0.3s ease;
        }

        .restore-btn:hover {
            background: rgba(34, 197, 94, 0.3);
            border-color: rgba(34, 197, 94, 0.6);
            transform: translateY(-2px);
        }

        .delete-btn {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.4);
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
            background: rgba(239, 68, 68, 0.3);
            border-color: rgba(239, 68, 68, 0.6);
            transform: translateY(-2px);
        }

        .profile-img {
            border: 2px solid rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
        }

        .table-row:hover .profile-img {
            border-color: rgba(59, 130, 246, 0.6);
            transform: scale(1.1);
        }

        .empty-state {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 2px dashed rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-950 to-black text-white">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full floating-nav shadow-lg z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <h1 class="text-xl font-bold gradient-text">
                        STUDENT MANAGEMENT SYSTEM
                    </h1>
                    <div class="hidden md:flex space-x-6 ml-8">
                        <a href="<?= site_url() ?>" class="text-white hover:text-blue-400 transition-colors font-medium">HOME</a>
                        <a href="<?= site_url('students') ?>" class="text-white hover:text-blue-400 transition-colors font-medium">STUDENTS</a>
                        <span class="text-blue-400 font-medium">DELETED STUDENTS</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-24 pb-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-12 text-center">
                <div class="icon-container mx-auto w-20 h-20 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-trash-restore text-white text-3xl"></i>
                </div>
                
                <h1 class="text-4xl md:text-6xl font-bold gradient-text mb-4">
                    Deleted Students
                </h1>
                <p class="text-gray-300 text-lg">View and manage soft-deleted student accounts</p>
            </div>

            <!-- Table Container -->
            <div class="glassmorphism rounded-2xl shadow-xl overflow-hidden fade-in">
                <div class="px-8 py-6 border-b border-white/10">
                    <h2 class="text-2xl font-semibold text-white">Deleted Student Directory</h2>
                    <p class="text-gray-300 mt-1">Restore or permanently delete student accounts</p>
                </div>
                
                <?php if (!empty($students)): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/10">
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Profile</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Role</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Deleted At</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $row): ?>
                            <tr class="table-row">
                                <td class="px-6 py-6 text-sm font-mono text-blue-400">
                                    #<?= htmlspecialchars($row['id'] ?? 'N/A') ?>
                                </td>
                                <td class="px-6 py-6">
                                    <?php if (isset($row['profile_image']) && $row['profile_image']): ?>
                                        <img src="<?= site_url('public/uploads/' . $row['profile_image']) ?>" 
                                             alt="Profile" 
                                             class="profile-img w-12 h-12 rounded-full object-cover">
                                    <?php else: ?>
                                        <div class="profile-img w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                            <?= isset($row['first_name']) ? strtoupper(substr($row['first_name'], 0, 1)) : 'U' ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-6 text-sm font-medium text-white">
                                    <?= htmlspecialchars(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? '')) ?>
                                </td>
                                <td class="px-6 py-6 text-sm text-blue-400">
                                    <?= htmlspecialchars($row['email'] ?? '') ?>
                                </td>
                                <td class="px-6 py-6">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= (isset($row['role']) && $row['role'] === 'admin') ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : 'bg-green-500/20 text-green-300 border border-green-500/30' ?>">
                                        <i class="fas fa-<?= (isset($row['role']) && $row['role'] === 'admin') ? 'crown' : 'user' ?> mr-1"></i>
                                        <?= ucfirst($row['role'] ?? 'student') ?>
                                    </span>
                                </td>
                                <td class="px-6 py-6 text-sm text-gray-400">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    <?= isset($row['deleted_at']) ? date('M d, Y', strtotime($row['deleted_at'])) : 'N/A' ?>
                                    <br>
                                    <small class="text-xs text-gray-500">
                                        <?= isset($row['deleted_at']) ? date('h:i A', strtotime($row['deleted_at'])) : '' ?>
                                    </small>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?= site_url('students/restore/' . $row['id']) ?>" 
                                           class="restore-btn inline-flex items-center px-4 py-2 rounded-lg text-green-300 text-sm font-medium transition-all duration-200" 
                                           title="Restore Student"
                                           onclick="return confirm('Are you sure you want to restore this student?');">
                                            <i class="fas fa-undo mr-2"></i>Restore
                                        </a>
                                        <a href="<?= site_url('students/permanent_delete/' . $row['id']) ?>" 
                                           class="delete-btn inline-flex items-center px-4 py-2 rounded-lg text-red-300 text-sm font-medium transition-all duration-200" 
                                           title="Permanently Delete"
                                           onclick="return confirm('Are you sure you want to permanently delete this student? This action cannot be undone.');">
                                            <i class="fas fa-trash-alt mr-2"></i>Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="p-12">
                    <div class="empty-state rounded-2xl p-12 text-center">
                        <div class="icon-container mx-auto w-24 h-24 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-inbox text-white text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-white mb-3">No Deleted Students</h3>
                        <p class="text-gray-400 text-lg">There are currently no soft-deleted student accounts.</p>
                        <a href="<?= site_url('students') ?>" class="inline-flex items-center mt-6 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Students
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>