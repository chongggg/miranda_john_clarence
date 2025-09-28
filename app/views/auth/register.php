<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Student Management System</title>
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

        .submit-btn:active {
            transform: scale(0.98);
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
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-950 to-black text-white">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/10 backdrop-blur-md shadow-lg z-50">
        <div class="max-w-6xl mx-auto px-6 py-3 flex justify-between items-center">
            <span class="text-xl font-bold tracking-wide">🎓 Student Management</span>
            <div class="text-sm text-gray-300">Registration Portal</div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center pt-20 pb-12 px-4">
        <div class="w-full max-w-lg">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="icon-container mx-auto w-20 h-20 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-user-plus text-white text-3xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-wide bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent mb-2">
                    Create Account
                </h1>
                <p class="text-gray-300">Join our student management system</p>
            </div>

            <!-- Form Container -->
            <div class="glassmorphism rounded-2xl shadow-xl overflow-hidden fade-in">
                <div class="p-8">
                    <!-- Error Messages -->
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="error-message p-4 rounded-lg text-red-200 mb-6">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <span class="block sm:inline"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Success Messages -->
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="success-message p-4 rounded-lg text-green-200 mb-6">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span class="block sm:inline"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Registration Form -->
                    <form method="POST" action="<?= site_url('auth/register') ?>" class="space-y-6">
                        <!-- Name Fields Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <input type="text"
                                       id="first_name"
                                       name="first_name"
                                       required
                                       class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none"
                                       placeholder="First name"
                                       value="<?= isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : '' ?>">
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
                                       placeholder="Last name"
                                       value="<?= isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : '' ?>">
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
                                   placeholder="Enter your email"
                                   value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
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
                                   placeholder="Choose a username"
                                   value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
                            <label for="username" class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                <i class="fas fa-at mr-2"></i>Username
                            </label>
                        </div>

                        <div class="relative">
                            <input type="password"
                                   id="password"
                                   name="password"
                                   required
                                   class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none"
                                   placeholder="Create a password">
                            <label for="password" class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                <i class="fas fa-lock mr-2"></i>Password
                            </label>
                        </div>

                        <div class="relative">
                            <input type="password"
                                   id="confirm_password"
                                   name="confirm_password"
                                   required
                                   class="form-input w-full px-4 py-3 rounded-lg text-white placeholder-transparent focus:outline-none"
                                   placeholder="Confirm your password">
                            <label for="confirm_password" class="form-label absolute left-4 top-3 text-gray-300 pointer-events-none">
                                <i class="fas fa-lock mr-2"></i>Confirm Password
                            </label>
                        </div>

                        <button type="submit" class="submit-btn w-full py-3 rounded-lg font-semibold text-white shadow-lg">
                            <i class="fas fa-user-plus mr-2"></i>Create Account
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-gray-300">
                            Already have an account?
                            <a href="<?= site_url('auth/login') ?>" class="text-blue-400 hover:text-blue-300 font-medium underline transition duration-200">
                                Sign in here
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 text-gray-400 text-sm">
                <p>© 2025 Student Management System</p>
            </div>
        </div>
    </div>

    <script>
        // Enhanced floating label functionality
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-input');
            
            inputs.forEach(input => {
                // Handle autofill detection and pre-filled values
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