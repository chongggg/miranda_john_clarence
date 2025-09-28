<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleted Students - Student Management System</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-gray-900 to-black font-modern">

    <!-- Navigation -->
    <nav class="bg-gray-900/80 backdrop-blur-sm border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="<?= site_url() ?>" class="text-2xl font-bold text-white">
                            <span class="text-blue-400">STUDENT</span> PORTAL
                        </a>
                    </div>
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="<?= site_url() ?>" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            HOME
                        </a>
                        <a href="<?= site_url('students') ?>" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            STUDENTS
                        </a>
                        <a href="<?= site_url('students/deleted') ?>" class="text-orange-400 hover:text-orange-300 px-3 py-2 rounded-md text-sm font-medium">
                            DELETED STUDENTS
                        </a>
                    </div>
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
                        DELETED
                        <span class="block bg-gradient-to-r from-red-400 via-orange-400 to-yellow-400 bg-clip-text text-transparent">
                            STUDENTS
                        </span>
                    </h1>
                    <p class="text-gray-400 text-lg">View and manage soft-deleted student accounts</p>
                </div>
            </div>
        </div>

        <!-- Deleted Students Table -->
        <div class="bg-white/5 backdrop-blur-sm rounded-2xl border border-gray-800 overflow-hidden shadow-2xl">
            <div class="px-8 py-6 border-b border-gray-800">
                <h2 class="text-2xl font-semibold text-white">Deleted Student Directory</h2>
                <p class="text-gray-400 mt-1">Manage soft-deleted student accounts</p>
            </div>
            
            <?php if (!empty($students)): ?>
            <div class="overflow-x-auto">
                <table class="w-full table-fixed">
                    <thead class="bg-gray-900/50">
                        <tr>
                            <th scope="col" class="w-16 px-4 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                            <th scope="col" class="w-20 px-4 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Profile</th>
                            <th scope="col" class="w-48 px-4 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                            <th scope="col" class="w-64 px-4 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                            <th scope="col" class="w-24 px-4 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Role</th>
                            <th scope="col" class="w-40 px-4 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Deleted At</th>
                            <th scope="col" class="w-48 px-4 py-4 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800/30 divide-y divide-gray-700">
                        <?php foreach ($students as $row): ?>
                        <tr class="hover:bg-gray-700/30 transition-colors duration-200">
                            <td class="px-4 py-6 text-sm font-mono text-gray-300 truncate">
                                #<?= htmlspecialchars($row['id'] ?? 'N/A') ?>
                            </td>
                            <td class="px-4 py-6">
                                <?php if (isset($row['profile_image']) && $row['profile_image']): ?>
                                    <img src="<?= site_url('public/uploads/' . $row['profile_image']) ?>" 
                                         alt="Profile" 
                                         class="w-8 h-8 rounded-full object-cover">
                                <?php else: ?>
                                    <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center text-white font-semibold text-xs">
                                        <?= isset($row['first_name']) ? strtoupper(substr($row['first_name'], 0, 1)) : 'U' ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-6 text-sm font-medium text-white truncate">
                                <?= htmlspecialchars(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? '')) ?>
                            </td>
                            <td class="px-4 py-6 text-sm text-blue-400 truncate">
                                <?= htmlspecialchars($row['email'] ?? '') ?>
                            </td>
                            <td class="px-4 py-6">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium <?= (isset($row['role']) && $row['role'] === 'admin') ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' ?>">
                                    <?= ucfirst($row['role'] ?? 'student') ?>
                                </span>
                            </td>
                            <td class="px-4 py-6 text-sm text-gray-400 truncate">
                                <?= isset($row['deleted_at']) ? date('M d, Y h:i A', strtotime($row['deleted_at'])) : 'N/A' ?>
                            </td>
                            <td class="px-4 py-6 text-right text-sm font-medium">
                                <div class="flex flex-col space-y-1">
                                    <a href="<?= site_url('students/restore/' . $row['id']) ?>" 
                                       class="text-green-600 hover:text-green-900 transition-colors duration-200 text-xs" 
                                       title="Restore Student"
                                       onclick="return confirm('Are you sure you want to restore this student?');">
                                        <i class="fas fa-undo mr-1"></i>Restore
                                    </a>
                                    <a href="<?= site_url('students/permanent_delete/' . $row['id']) ?>" 
                                       class="text-red-600 hover:text-red-900 transition-colors duration-200 text-xs" 
                                       title="Permanently Delete"
                                       onclick="return confirm('Are you sure you want to permanently delete this student? This action cannot be undone.');">
                                        <i class="fas fa-trash-alt mr-1"></i>Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="px-8 py-12 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-trash-alt text-6xl mb-4"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">No Deleted Students</h3>
                <p class="text-gray-400">There are currently no soft-deleted student accounts.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Background Elements -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-red-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-orange-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
    </div>
</body>
</html>
