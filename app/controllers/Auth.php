<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Auth extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('Auth_model');
        $this->call->model('Student_model');
        $this->call->library('session');
        $this->call->library('upload');
        $this->call->helper('url');
        $this->call->helper('form');
    }

    /**
     * Show login form
     */
    public function login()
    {
        // If user is already logged in, redirect to appropriate page
        if ($this->session->userdata('logged_in')) {
            $role = $this->session->userdata('role');
            if ($role === 'admin') {
                redirect('students');
            } else {
                redirect('auth/profile');
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->process_login();
        } else {
            $this->call->view('auth/login');
        }
    }

    /**
     * Process login
     */
    private function process_login()
    {
        $username = trim($this->io->post('username'));
        $password = $this->io->post('password');

        // Basic validation
        if (empty($username) || empty($password)) {
            $this->session->set_flashdata('error', 'Username and password are required!');
            $this->call->view('auth/login');
            return;
        }

        // Get auth record with student details
        $auth = $this->Auth_model->get_auth_with_student($username);

        if (!$auth) {
            $this->session->set_flashdata('error', 'Invalid username or password!');
            $this->call->view('auth/login');
            return;
        }

        // Verify password
        if (!password_verify($password, $auth['password'])) {
            $this->session->set_flashdata('error', 'Invalid username or password!');
            $this->call->view('auth/login');
            return;
        }

        // Set session data
        $this->session->set_userdata([
            'user_id' => $auth['id'],
            'student_id' => $auth['student_id'],
            'username' => $auth['username'],
            'first_name' => $auth['first_name'],
            'last_name' => $auth['last_name'],
            'email' => $auth['email'],
            'role' => $auth['role'],
            'profile_image' => $auth['profile_image'] ?: $auth['student_profile_image'],
            'logged_in' => true
        ]);

        // Redirect based on role
        if ($auth['role'] === 'admin') {
            redirect('students');
        } else {
            redirect('auth/profile');
        }
    }

    /**
     * Show registration form
     */
    public function register()
    {
        // Redirect if already logged in
        if ($this->session->userdata('user_id')) {
            redirect('');
        }

        if ($_POST) {
            $first_name = trim($_POST['first_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Validation
            $errors = [];

            if (empty($first_name)) $errors[] = 'First name is required';
            if (empty($last_name)) $errors[] = 'Last name is required';
            if (empty($email)) $errors[] = 'Email is required';
            if (empty($username)) $errors[] = 'Username is required';
            if (empty($password)) $errors[] = 'Password is required';
            if ($password !== $confirm_password) $errors[] = 'Passwords do not match';

            // Email validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format';
            }

            // Check if email already exists
            if ($this->Student_model->email_exists($email)) {
                $errors[] = 'Email already exists';
            }

            // Check if username already exists
            if ($this->Auth_model->username_exists($username)) {
                $errors[] = 'Username already exists';
            }

            if (empty($errors)) {
                // Prepare data
                $student_data = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $auth_data = [
                    'username' => $username,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => 'student',
                    'created_at' => date('Y-m-d H:i:s')
                ];

                // Register user
                $student_id = $this->Auth_model->register($student_data, $auth_data);

                if ($student_id) {
                    $this->session->set_flashdata('success', 'Registration successful! Please login.');
                    redirect('auth/login');
                } else {
                    $this->session->set_flashdata('error', 'Registration failed. Please try again.');
                }
            } else {
                $this->session->set_flashdata('error', implode('<br>', $errors));
            }
        }

        $this->call->view('auth/register');
    }


    /**
     * Profile page
     */
    public function profile()
    {
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        $user_id = $this->session->userdata('student_id');
        
        // Debug: Check if student_id exists in session
        if (!$user_id) {
            $this->session->set_flashdata('error', 'Session expired. Please login again.');
            redirect('auth/login');
        }
        
        $data['user'] = $this->Auth_model->get_auth_with_student_by_id($user_id);
        
        // Debug: Check if user data was found
        if (!$data['user']) {
            $this->session->set_flashdata('error', 'User data not found. Please login again.');
            redirect('auth/login');
        }
        
        // Also get separate auth data for profile image
        $data['auth'] = $this->Auth_model->get_auth_by_student_id($user_id);

        if ($_POST) {
            $first_name = trim($_POST['first_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $username = trim($_POST['username'] ?? '');

            // Validation
            $errors = [];

            if (empty($first_name)) $errors[] = 'First name is required';
            if (empty($last_name)) $errors[] = 'Last name is required';
            if (empty($email)) $errors[] = 'Email is required';
            if (empty($username)) $errors[] = 'Username is required';

            // Email validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format';
            }

            // Check if email already exists (excluding current user)
            if ($this->Student_model->email_exists($email, $user_id)) {
                $errors[] = 'Email already exists';
            }

            // Check if username already exists (excluding current user)
            if ($this->Auth_model->username_exists($username, $data['user']['id'])) {
                $errors[] = 'Username already exists';
            }

            if (empty($errors)) {
                // Prepare data
                $student_data = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $auth_data = [
                    'username' => $username,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Update profile
                if ($this->Auth_model->update_profile($user_id, $student_data, $auth_data)) {
                    // Update session data
                    $this->session->set_userdata([
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'username' => $username
                    ]);

                    $this->session->set_flashdata('success', 'Profile updated successfully!');
                    redirect('auth/profile');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update profile. Please try again.');
                }
            } else {
                $this->session->set_flashdata('error', implode('<br>', $errors));
            }
        }

        $this->call->view('auth/profile', $data);
    }

    /**
     * Upload profile image
     */
    public function upload_image()
    {
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }

        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $user_id = $this->session->userdata('user_id');
            
            // Initialize upload
            $this->call->library('upload');
            
            // Set the file to upload
            $this->upload->file = $_FILES['profile_image'];
            
            $this->upload
                ->max_size(5) // 5MB max
                ->min_size(0.1) // 0.1MB min
                ->set_dir('public/uploads/')
                ->allowed_extensions(['jpg', 'jpeg', 'png', 'gif'])
                ->allowed_mimes(['image/jpeg', 'image/png', 'image/gif'])
                ->is_image()
                ->encrypt_name();

            if ($this->upload->do_upload()) {
                $filename = $this->upload->get_filename();
                
                // Update database
                $student_data = [
                    'profile_image' => $filename,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                $auth_data = [
                    'profile_image' => $filename,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->Auth_model->update_profile($user_id, $student_data, $auth_data)) {
                    // Update session
                    $this->session->set_userdata('profile_image', $filename);
                    $this->session->set_flashdata('success', 'Profile image updated successfully!');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update profile image.');
                }
            } else {
                $errors = $this->upload->get_errors();
                $this->session->set_flashdata('error', implode('<br>', $errors));
            }
        } else {
            $this->session->set_flashdata('error', 'Please select a valid image file.');
        }

        redirect('auth/profile');
    }

    /**
     * Change password
     */
    public function change_password()
    {
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        if ($_POST) {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            $user_id = $this->session->userdata('student_id');
            $user = $this->Auth_model->get_auth_with_student_by_id($user_id);

            // Validation
            $errors = [];

            if (empty($current_password)) $errors[] = 'Current password is required';
            if (empty($new_password)) $errors[] = 'New password is required';
            if ($new_password !== $confirm_password) $errors[] = 'New passwords do not match';

            // Verify current password
            if (!password_verify($current_password, $user['password'])) {
                $errors[] = 'Current password is incorrect';
            }

            if (empty($errors)) {
                if ($this->Auth_model->update_password($user_id, $new_password)) {
                    $this->session->set_flashdata('success', 'Password changed successfully!');
                } else {
                    $this->session->set_flashdata('error', 'Failed to change password. Please try again.');
                }
            } else {
                $this->session->set_flashdata('error', implode('<br>', $errors));
            }
        }

        redirect('auth/profile');
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $this->session->unset_userdata(['user_id', 'student_id', 'username', 'first_name', 'last_name', 'email', 'role', 'profile_image', 'logged_in']);
        $this->session->set_flashdata('success', 'You have been logged out successfully!');
        redirect('auth/login');
    }
}
