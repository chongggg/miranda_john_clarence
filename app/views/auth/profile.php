<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Student Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <i class="fas fa-graduation-cap text-blue-600 text-2xl mr-3"></i>
                    <h1 class="text-xl font-bold text-gray-900">Student Management System</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="<?= site_url('students') ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                            <i class="fas fa-users mr-2"></i>Manage Students
                        </a>
                    <?php endif; ?>
                    
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                            <img src="<?= isset($_SESSION['profile_image']) ? site_url('public/uploads/' . $_SESSION['profile_image']) : 'https://via.placeholder.com/40x40?text=' . substr($_SESSION['first_name'] ?? 'U', 0, 1) ?>" 
                                 alt="Profile" 
                                 class="w-8 h-8 rounded-full">
                            <span><?= htmlspecialchars(($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? '')) ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 hidden group-hover:block">
                            <a href="<?= site_url('auth/profile') ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="<?= site_url('auth/logout') ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900">
                    <i class="fas fa-user mr-3"></i>My Profile
                </h2>
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                    <?= ucfirst($_SESSION['role'] ?? 'student') ?>
                </span>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <span class="block sm:inline"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <span class="block sm:inline"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Profile Image Section -->
                <div class="lg:col-span-1">
                    <div class="text-center">
                        <div class="relative inline-block">
                            <img src="<?= isset($_SESSION['profile_image']) ? site_url('public/uploads/' . $_SESSION['profile_image']) : 'https://via.placeholder.com/200x200?text=' . substr($_SESSION['first_name'] ?? 'U', 0, 1) ?>" 
                                 alt="Profile Image" 
                                 class="w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 border-gray-200">
                            
                            <form method="POST" action="<?= site_url('auth/upload_image') ?>" enctype="multipart/form-data" class="mt-4">
                                <label class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 cursor-pointer transition duration-200">
                                    <i class="fas fa-camera mr-2"></i>Change Photo
                                    <input type="file" name="profile_image" accept="image/*" class="hidden" onchange="this.form.submit()">
                                </label>
                            </form>
                        </div>
                        
                        <h3 class="text-xl font-semibold text-gray-900 mt-4">
                            <?= htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?>
                        </h3>
                        <p class="text-gray-600"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                        <p class="text-sm text-gray-500 mt-2">Member since <?= isset($user['created_at']) ? date('M Y', strtotime($user['created_at'])) : 'Unknown' ?></p>
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="lg:col-span-2">
                    <form method="POST" action="<?= site_url('auth/profile') ?>" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2"></i>First Name
                                </label>
                                <input type="text" 
                                       id="first_name" 
                                       name="first_name" 
                                       required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                       value="<?= htmlspecialchars($user['first_name'] ?? '') ?>">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2"></i>Last Name
                                </label>
                                <input type="text" 
                                       id="last_name" 
                                       name="last_name" 
                                       required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                       value="<?= htmlspecialchars($user['last_name'] ?? '') ?>">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2"></i>Email Address
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                   value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                        </div>

                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-at mr-2"></i>Username
                            </label>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                   value="<?= htmlspecialchars($user['username'] ?? '') ?>">
                        </div>

                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium">
                            <i class="fas fa-save mr-2"></i>Update Profile
                        </button>
                    </form>

                    <!-- Change Password Section -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-key mr-2"></i>Change Password
                        </h4>
                        
                        <form method="POST" action="<?= site_url('auth/change_password') ?>" class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Current Password
                                </label>
                                <input type="password" 
                                       id="current_password" 
                                       name="current_password" 
                                       required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                       placeholder="Enter current password">
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                                        New Password
                                    </label>
                                    <input type="password" 
                                           id="new_password" 
                                           name="new_password" 
                                           required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                           placeholder="Enter new password">
                                </div>
                                <div>
                                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Confirm New Password
                                    </label>
                                    <input type="password" 
                                           id="confirm_password" 
                                           name="confirm_password" 
                                           required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                           placeholder="Confirm new password">
                                </div>
                            </div>
                            
                            <button type="submit" 
                                    class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 font-medium">
                                <i class="fas fa-key mr-2"></i>Change Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
