<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
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

        .form-input {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            color: white;
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

        .form-input option {
            background: rgba(30, 41, 59, 0.9);
            color: white;
        }

        .submit-btn {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            transition: all 0.25s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        .cancel-btn {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .cancel-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
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

        .icon-container {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }

        .group:hover .form-input {
            border-color: rgba(59, 130, 246, 0.4);
        }

        .group:hover .overlay-gradient {
            opacity: 1;
        }

        .overlay-gradient {
            opacity: 0;
            transition: opacity 0.3s ease;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(29, 78, 216, 0.1));
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
                        <a href="<?php echo site_url('students'); ?>" class="text-white hover:text-blue-400 transition-colors font-medium">HOME</a>
                        <span class="text-blue-400 font-medium">EDIT STUDENT</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-24 pb-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="mb-12 text-center">

                <div class="icon-container mx-auto w-20 h-20 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-user-edit text-white text-3xl"></i>
                </div>
                
                <h1 class="text-4xl md:text-6xl font-bold gradient-text mb-4">
                    Edit Student
                </h1>
                <p class="text-gray-300 text-lg">Update student information</p>
            </div>

            <!-- Form Container -->
            <div class="glassmorphism rounded-2xl shadow-xl overflow-hidden fade-in">
                <div class="px-8 py-6 border-b border-white/10">
                    <h2 class="text-2xl font-semibold text-white">Student Information</h2>
                    <p class="text-gray-300 mt-1">Update the details for this student</p>
                    <?php if (isset($student['id'])): ?>
                    <div class="mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 011-1h2a2 2 0 011 1v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                            Student ID: #<?php echo htmlspecialchars($student['id']); ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="p-8">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="error-message p-4 rounded-lg text-red-200 mb-6">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <span class="block sm:inline"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!$student): ?>
                        <div class="error-message p-4 rounded-lg text-red-200 mb-6">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <span class="block sm:inline">Student not found.</span>
                        </div>
                    <?php else: ?>
                    <form method="post" action="<?= site_url('students/edit/' . $student['id']) ?>" class="space-y-8">
                        <!-- First Name Field -->
                        <div class="group">
                            <label for="first_name" class="block text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wider">
                                <i class="fas fa-user mr-2"></i>First Name *
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="first_name"
                                    name="first_name" 
                                    value="<?= htmlspecialchars($student['first_name']) ?>"
                                    required
                                    class="form-input w-full px-4 py-4 rounded-xl focus:outline-none"
                                    placeholder="Enter student's first name"
                                >
                                <div class="overlay-gradient absolute inset-0 rounded-xl pointer-events-none"></div>
                            </div>
                        </div>

                        <!-- Last Name Field -->
                        <div class="group">
                            <label for="last_name" class="block text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wider">
                                <i class="fas fa-user mr-2"></i>Last Name *
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="last_name"
                                    name="last_name" 
                                    value="<?= htmlspecialchars($student['last_name']) ?>"
                                    required
                                    class="form-input w-full px-4 py-4 rounded-xl focus:outline-none"
                                    placeholder="Enter student's last name"
                                >
                                <div class="overlay-gradient absolute inset-0 rounded-xl pointer-events-none"></div>
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="group">
                            <label for="email" class="block text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wider">
                                <i class="fas fa-envelope mr-2"></i>Email Address *
                            </label>
                            <div class="relative">
                                <input 
                                    type="email" 
                                    id="email"
                                    name="email" 
                                    value="<?= htmlspecialchars($student['email']) ?>"
                                    required
                                    class="form-input w-full px-4 py-4 rounded-xl focus:outline-none"
                                    placeholder="Enter student's email address"
                                >
                                <div class="overlay-gradient absolute inset-0 rounded-xl pointer-events-none"></div>
                            </div>
                        </div>

                        <!-- Username Field -->
                        <div class="group">
                            <label for="username" class="block text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wider">
                                <i class="fas fa-at mr-2"></i>Username *
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="username"
                                    name="username" 
                                    value="<?= htmlspecialchars($student['username']) ?>"
                                    required
                                    class="form-input w-full px-4 py-4 rounded-xl focus:outline-none"
                                    placeholder="Enter username for login"
                                >
                                <div class="overlay-gradient absolute inset-0 rounded-xl pointer-events-none"></div>
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="group">
                            <label for="password" class="block text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wider">
                                <i class="fas fa-lock mr-2"></i>Password (Leave blank to keep current)
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password"
                                    name="password" 
                                    class="form-input w-full px-4 py-4 rounded-xl focus:outline-none"
                                    placeholder="Enter new password (optional)"
                                >
                                <div class="overlay-gradient absolute inset-0 rounded-xl pointer-events-none"></div>
                            </div>
                        </div>

                        <!-- Role Field -->
                        <div class="group">
                            <label for="role" class="block text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wider">
                                <i class="fas fa-user-tag mr-2"></i>Role *
                            </label>
                            <div class="relative">
                                <select 
                                    id="role"
                                    name="role" 
                                    required
                                    class="form-input w-full px-4 py-4 rounded-xl focus:outline-none"
                                >
                                    <option value="student" <?= $student['role'] === 'student' ? 'selected' : '' ?>>Student</option>
                                    <option value="admin" <?= $student['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                </select>
                                <div class="overlay-gradient absolute inset-0 rounded-xl pointer-events-none"></div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-8">
                            <button 
                                type="submit"
                                class="submit-btn flex-1 inline-flex items-center justify-center px-8 py-4 text-white font-semibold rounded-xl shadow-lg"
                            >
                                <i class="fas fa-save mr-2"></i>
                                Update Student
                            </button>
                            
                            <a 
                                href="<?php echo site_url('students'); ?>"
                                class="cancel-btn flex-1 sm:flex-none inline-flex items-center justify-center px-8 py-4 text-gray-300 hover:text-white font-semibold rounded-xl transition-all duration-200"
                            >
                                <i class="fas fa-times mr-2"></i>
                                Cancel
                            </a>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>