<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <nav class="bg-black/20 backdrop-blur-sm border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                        STUDENT PORTAL
                    </h1>
                    <div class="hidden md:flex space-x-6">
                        <a href="<?php echo site_url('students'); ?>" class="text-gray-400 hover:text-blue-400 transition-colors font-medium">HOME</a>
                        <a href="#" class="text-white hover:text-blue-400 transition-colors font-medium">EDIT STUDENT</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <a href="<?php echo site_url('students'); ?>" 
                   class="inline-flex items-center text-gray-400 hover:text-white transition-colors mr-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Students
                </a>
            </div>
            
            <h1 class="text-5xl lg:text-6xl font-bold text-white mb-4 tracking-tight">
                EDIT
                <span class="block bg-gradient-to-r from-orange-400 via-pink-400 to-purple-400 bg-clip-text text-transparent">
                    STUDENT
                </span>
            </h1>
            <p class="text-gray-400 text-lg max-w-2xl leading-relaxed">
                Update student information.
            </p>
        </div>

        <!-- Form Container -->
        <div class="bg-white/5 backdrop-blur-sm rounded-2xl border border-gray-800 overflow-hidden shadow-2xl">
            <div class="px-8 py-6 border-b border-gray-800">
                <h2 class="text-2xl font-semibold text-white">Student Information</h2>
                <p class="text-gray-400 mt-1">Update the details for this student</p>
                <?php if (isset($student['id'])): ?>
                <div class="mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 011-1h2a2 2 0 011 1v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></svg>
                        Student ID: #<?php echo htmlspecialchars($student['id']); ?>
                    </span>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="p-8">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <span class="block sm:inline"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!$student): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <span class="block sm:inline">Student not found.</span>
                    </div>
                <?php else: ?>
                <form method="post" action="<?= site_url('students/edit/' . $student['id']) ?>" class="space-y-8">
                    <!-- First Name Field -->
                    <div class="group">
                        <label for="first_name" class="block text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wider">
                            First Name *
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="first_name"
                                name="first_name" 
                                value="<?= htmlspecialchars($student['first_name']) ?>"
                                required
                                class="w-full px-4 py-4 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 hover:border-gray-600"
                                placeholder="Enter student's first name"
                            >
                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-orange-500/20 to-pink-500/20 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                        </div>
                    </div>

                    <!-- Last Name Field -->
                    <div class="group">
                        <label for="last_name" class="block text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wider">
                            Last Name *
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="last_name"
                                name="last_name" 
                                value="<?= htmlspecialchars($student['last_name']) ?>"
                                required
                                class="w-full px-4 py-4 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 hover:border-gray-600"
                                placeholder="Enter student's last name"
                            >
                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-orange-500/20 to-pink-500/20 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="group">
                        <label for="email" class="block text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wider">
                            Email Address *
                        </label>
                        <div class="relative">
                            <input 
                                type="email" 
                                id="email"
                                name="email" 
                                value="<?= htmlspecialchars($student['email']) ?>"
                                required
                                class="w-full px-4 py-4 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 hover:border-gray-600"
                                placeholder="Enter student's email address"
                            >
                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-orange-500/20 to-pink-500/20 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                        </div>
                    </div>

                    <!-- Username Field -->
                    <div class="group">
                        <label for="username" class="block text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wider">
                            Username *
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="username"
                                name="username" 
                                value="<?= htmlspecialchars($student['username']) ?>"
                                required
                                class="w-full px-4 py-4 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 hover:border-gray-600"
                                placeholder="Enter username for login"
                            >
                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-orange-500/20 to-pink-500/20 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="group">
                        <label for="password" class="block text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wider">
                            Password (Leave blank to keep current)
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password"
                                name="password" 
                                class="w-full px-4 py-4 bg-gray-800/50 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 hover:border-gray-600"
                                placeholder="Enter new password (optional)"
                            >
                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-orange-500/20 to-pink-500/20 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                        </div>
                    </div>

                    <!-- Role Field -->
                    <div class="group">
                        <label for="role" class="block text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wider">
                            Role *
                        </label>
                        <div class="relative">
                            <select 
                                id="role"
                                name="role" 
                                required
                                class="w-full px-4 py-4 bg-gray-800/50 border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 hover:border-gray-600"
                            >
                                <option value="student" <?= $student['role'] === 'student' ? 'selected' : '' ?>>Student</option>
                                <option value="admin" <?= $student['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-orange-500/20 to-pink-500/20 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-8">
                        <button 
                            type="submit"
                            class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-orange-500 to-pink-600 hover:from-orange-600 hover:to-pink-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12"></path>
                            </svg>
                            Update Student
                        </button>
                        
                        <a 
                            href="<?php echo site_url('students'); ?>"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center px-8 py-4 bg-gray-700/50 hover:bg-gray-600/50 text-gray-300 hover:text-white font-semibold rounded-xl border border-gray-600 hover:border-gray-500 transition-all duration-200"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Background Elements -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-orange-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-pulse"></div>
    </div>
</body>
</html>