<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Student Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Inter", sans-serif;
        }

        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(18px) saturate(180%);
            -webkit-backdrop-filter: blur(18px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .glassmorphism-nav {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-input {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .form-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(59, 130, 246, 0.6);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            transform: translateY(-2px);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-label {
            transition: all 0.3s ease;
        }

        .form-input:focus + .form-label,
        .form-input:not(:placeholder-shown) + .form-label,
        .form-input.has-value + .form-label {
            transform: translateY(-28px) scale(0.85);
            color: #60a5fa;
            font-weight: 600;
            background: rgba(30, 41, 59, 0.8);
            padding: 0 8px;
            border-radius: 4px;
        }

        .submit-btn {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            transition: all 0.25s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        .submit-btn-green {
            background: linear-gradient(135deg, #22c55e, #16a34a);
        }

        .submit-btn-green:hover {
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
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

        .error-message {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.4);
            backdrop-filter: blur(10px);
        }

        .success-message {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.4);
            backdrop-filter: blur(10px);
        }

        .dropdown-menu {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .role-badge {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            backdrop-filter: blur(10px);
        }

        .profile-image {
            border: 4px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .profile-image:hover {
            border-color: rgba(59, 130, 246, 0.6);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }

        .upload-btn {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            backdrop-filter: blur(10px);
            transition: all 0.25s ease;
        }

        .upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        .section-divider {
            border-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-900 via-purple-950 to-black text-white">
    <!-- Navigation -->
    <nav class="glassmorphism-nav shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <i class="fas fa-graduation-cap text-blue-400 text-2xl mr-3"></i>
                    <h1 class="text-xl font-bold text-white">Student Management System</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="<?= site_url('students') ?>" class="submit-btn px-4 py-2 rounded-lg font-medium shadow-lg">
                            <i class="fas fa-users mr-2"></i>Manage Students
                        </a>
                    <?php endif; ?>
                    
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-white hover:text-blue-300 transition duration-200">
                            <img src="<?= isset($_SESSION['profile_image']) ? site_url('public/uploads/' . $_SESSION['profile_image']) : 'https://via.placeholder.com/40x40?text=' . substr($_SESSION['first_name'] ?? 'U', 0, 1) ?>" 
                                 alt="Profile" 
                                 class="w-8 h-8 rounded-full border border-white/20">
                            <span><?= htmlspecialchars(($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? '')) ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        
                        <div class="dropdown-menu absolute right-0 mt-2 w-48 rounded-lg shadow-lg py-2 z-50 hidden group-hover:block">
                            <a href="<?= site_url('auth/profile') ?>" class="dropdown-item block px-4 py-2 text-white hover:text-blue-300">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="<?= site_url('auth/logout') ?>" class="dropdown-item block px-4 py-2 text-white hover:text-blue-300">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="glassmorphism rounded-2xl shadow-xl p-8 fade-in">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                    <i class="fas fa-user mr-3 text-blue-400"></i>My Profile
                </h2>
                <span class="role-badge text-white px-4 py-2 rounded-full text-sm font-medium shadow-lg">
                    <?= ucfirst($_SESSION['role'] ?? 'student') ?>
                </span>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-message p-4 rounded-lg text-red-200 mb-6">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span class="block sm:inline"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="success-message p-4 rounded-lg text-green-200 mb-6">
                    <i class="fas fa-check-circle mr-2"></i>
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
                                 class="profile-image w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                            
                            <form method="POST" action="<?= site_url('auth/upload_image') ?>" enctype="multipart/form-data" class="mt-4">
                                <label class="upload-btn text-white px-4 py-2 rounded-lg cursor-pointer font-medium shadow-lg inline-block">
                                    <i class="fas fa-camera mr-2"></i>Change Photo
                                    <input type="file" name="profile_image" accept="image/*" class="hidden" onchange="this.form.submit()">
                                </label>
                            </form>
                        </div>
                        
                        <h3 class="text-xl font-semibold text-white mt-4">
                            <?= htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?>
                        </h3>
                        <p class="text-gray-300"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                        <p class="text-sm text-gray-400 mt-2">Member since <?= isset($user['created_at']) ? date('M Y', strtotime($user['created_at'])) : 'Unknown' ?></p>
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="lg:col-span-2">
                    <form method="POST" action="<?= site_url('auth/profile') ?>" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative">
                                <input type="text"
                                       id="first_name"
                                       name="first_name"
                                       required
                                       class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none"
                                       placeholder="First Name"
                                       value="<?= htmlspecialchars($user['first_name'] ?? '') ?>">
                                <label for="first_name" class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                    <i class="fas fa-user mr-2"></i>First Name
                                </label>
                            </div>
                            <div class="relative">
                                <input type="text"
                                       id="last_name"
                                       name="last_name"
                                       required
                                       class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none"
                                       placeholder="Last Name"
                                       value="<?= htmlspecialchars($user['last_name'] ?? '') ?>">
                                <label for="last_name" class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                    <i class="fas fa-user mr-2"></i>Last Name
                                </label>
                            </div>
                        </div>

                        <div class="relative">
                            <input type="email"
                                   id="email"
                                   name="email"
                                   required
                                   class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none"
                                   placeholder="Email Address"
                                   value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                            <label for="email" class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                <i class="fas fa-envelope mr-2"></i>Email Address
                            </label>
                        </div>

                        <div class="relative">
                            <input type="text"
                                   id="username"
                                   name="username"
                                   required
                                   class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none"
                                   placeholder="Username"
                                   value="<?= htmlspecialchars($user['username'] ?? '') ?>">
                            <label for="username" class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                <i class="fas fa-at mr-2"></i>Username
                            </label>
                        </div>

                        <button type="submit" class="submit-btn w-full py-3 rounded-lg font-semibold text-white shadow-lg">
                            <i class="fas fa-save mr-2"></i>Update Profile
                        </button>
                    </form>

                    <!-- Change Password Section -->
                    <div class="mt-8 pt-8 border-t section-divider">
                        <h4 class="text-lg font-semibold text-white mb-4">
                            <i class="fas fa-key mr-2 text-green-400"></i>Change Password
                        </h4>
                        
                        <form method="POST" action="<?= site_url('auth/change_password') ?>" class="space-y-4">
                            <div class="relative">
                                <input type="password"
                                       id="current_password"
                                       name="current_password"
                                       required
                                       class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none"
                                       placeholder="Current Password">
                                <label for="current_password" class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                    <i class="fas fa-lock mr-2"></i>Current Password
                                </label>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="password"
                                           id="new_password"
                                           name="new_password"
                                           required
                                           class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none"
                                           placeholder="New Password">
                                    <label for="new_password" class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                        <i class="fas fa-key mr-2"></i>New Password
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="password"
                                           id="confirm_password"
                                           name="confirm_password"
                                           required
                                           class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none"
                                           placeholder="Confirm New Password">
                                    <label for="confirm_password" class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                        <i class="fas fa-key mr-2"></i>Confirm New Password
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="submit-btn submit-btn-green w-full py-3 rounded-lg font-semibold text-white shadow-lg">
                                <i class="fas fa-key mr-2"></i>Change Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Enhanced floating label functionality
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-input');
            
            inputs.forEach(input => {
                // Handle pre-filled values and autofill detection
                setTimeout(() => {
                    if (input.value) {
                        input.classList.add('has-value');
                    }
                }, 100);
                
                input.addEventListener('input', function() {
                    if (this.value) {
                        this.classList.add('has-value');
                    } else {
                        this.classList.remove('has-value');
                    }
                });

                input.addEventListener('blur', function() {
                    if (this.value) {
                        this.classList.add('has-value');
                    } else {
                        this.classList.remove('has-value');
                    }
                });
            });
        });
    </script>
</body>
</html>