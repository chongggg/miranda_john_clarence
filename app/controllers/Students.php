<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Students extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('Student_model', 'student');
        $this->call->model('Auth_model', 'auth');
        $this->call->library('pagination');
        $this->call->library('session');
        $this->call->library('upload');
        $this->call->helper('url');
        
        $this->pagination->set_theme('custom');
        $this->pagination->set_custom_classes([
            'nav'    => 'flex justify-center mt-6',
            'ul'     => 'inline-flex items-center space-x-1',
            'li'     => 'inline',
            'a'      => 'px-3 py-1 rounded-md border border-gray-300 text-gray-700 bg-white hover:bg-blue-500 hover:text-white transition',
            'active' => 'px-7 py-1 rounded-md border border-blue-500 bg-blue text-black font-bold'
        ]);
    }

    /**
     * Check if user is logged in
     */
    private function check_auth()
    {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Please login to access this page.');
            redirect('auth/login');
        }
    }

    /**
     * Check if user is admin
     */
    private function check_admin()
    {
        $this->check_auth();
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Access denied. Admin privileges required.');
            redirect('');
        }
    }

    public function index($page = 1)
    {
        $this->check_auth();
        
        $per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $allowed_per_page = [10, 25, 50, 100];
        if (!in_array($per_page, $allowed_per_page)) {
            $per_page = 10;
        }

        // Handle search (from query string)
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        // Count rows
        $total_rows = $this->student->count_all_records($search);

        // Init pagination
        $pagination_data = $this->pagination->initialize(
            $total_rows,
            $per_page,
            $page,
            'students/index',
            5
        );

        // Get paginated students with auth info
        $limit_clause = $pagination_data['limit'];
        $students = $this->student->get_records_with_pagination($limit_clause, $search);
        
        // Get auth info for each student
        $students_with_auth = [];
        foreach ($students as $student) {
            $auth_info = $this->auth->get_auth_with_student_by_id($student['id']);
            if ($auth_info) {
                // Preserve student ID and merge auth info
                $merged = array_merge($student, $auth_info);
                $merged['id'] = $student['id']; // Ensure student ID is preserved
                $students_with_auth[] = $merged;
            } else {
                $students_with_auth[] = $student;
            }
        }
        
        $data['students'] = $students_with_auth;
        $data['total_records'] = $total_rows;
        $data['pagination_data'] = $pagination_data;
        $data['pagination_links'] = $this->pagination->paginate();
        $data['search'] = $search;
        $data['per_page'] = $per_page;
        $data['is_admin'] = $this->session->userdata('role') === 'admin';

        $this->call->view('students/index', $data);
    }

    public function create()
    {
        $this->check_admin();
        
        if ($_POST) {
            $first_name = trim($_POST['first_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'student';

            // Validation
            $errors = [];

            if (empty($first_name)) $errors[] = 'First name is required';
            if (empty($last_name)) $errors[] = 'Last name is required';
            if (empty($email)) $errors[] = 'Email is required';
            if (empty($username)) $errors[] = 'Username is required';
            if (empty($password)) $errors[] = 'Password is required';

            // Email validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format';
            }

            // Check if email already exists
            if ($this->student->email_exists($email)) {
                $errors[] = 'Email already exists';
            }

            // Check if username already exists
            if ($this->auth->username_exists($username)) {
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
                    'role' => $role,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                // Register user
                $student_id = $this->auth->register($student_data, $auth_data);

                if ($student_id) {
                    $this->session->set_flashdata('success', 'Student created successfully!');
                    redirect('students');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create student. Please try again.');
                }
            } else {
                $this->session->set_flashdata('error', implode('<br>', $errors));
            }
        }
        
        $this->call->view('students/create');
    }

    public function edit($id)
    {
        $this->check_admin();
        
        if ($_POST) {
            $first_name = trim($_POST['first_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $role = $_POST['role'] ?? 'student';
            $password = $_POST['password'] ?? '';

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
            if ($this->student->email_exists($email, $id)) {
                $errors[] = 'Email already exists';
            }

            // Check if username already exists (excluding current user)
            $user = $this->auth->get_auth_with_student_by_id($id);
            if ($user && $this->auth->username_exists($username, $user['auth_id'])) {
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
                    'role' => $role,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Update password if provided
                if (!empty($password)) {
                    $auth_data['password'] = password_hash($password, PASSWORD_DEFAULT);
                }

                // Update profile
                if ($this->auth->update_profile($id, $student_data, $auth_data)) {
                    $this->session->set_flashdata('success', 'Student updated successfully!');
                    redirect('students');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update student. Please try again.');
                }
            } else {
                $this->session->set_flashdata('error', implode('<br>', $errors));
            }
        }
        
        $data['student'] = $this->auth->get_auth_with_student_by_id($id);
        $this->call->view('students/edit', $data);
    }

    public function delete($id)
    {
        $this->check_admin();
        
        if (!$id) {
            $this->session->set_flashdata('error', 'Student ID is required!');
            redirect('students');
        }
        
        // Debug: Log the attempt
        error_log("Controller: Attempting to soft delete student ID: " . $id);
        
        $result = $this->student->delete_student($id);
        error_log("Controller: Soft delete result: " . ($result ? 'true' : 'false'));
        
        if ($result) {
            $this->session->set_flashdata('success', 'Student archived successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to archive student. Please try again.');
        }
        
        redirect('students');
    }

    public function deleted()
    {
        $this->check_admin();
        
        $deleted_students = $this->student->get_soft_deleted_students();
        
        // Get auth info for each deleted student
        $students_with_auth = [];
        foreach ($deleted_students as $student) {
            $auth_info = $this->auth->get_auth_by_student_id($student['id']);
            if ($auth_info) {
                // Preserve student ID and merge auth info
                $merged = array_merge($student, $auth_info);
                $merged['id'] = $student['id']; // Ensure student ID is preserved
                $students_with_auth[] = $merged;
            } else {
                $students_with_auth[] = $student;
            }
        }
        
        $data['students'] = $students_with_auth;
        $data['is_admin'] = $this->session->userdata('role') === 'admin';
        
        $this->call->view('students/deleted', $data);
    }

    public function restore($id)
    {
        $this->check_admin();
        
        try {
            $result = $this->student->restore_student($id);
            if ($result) {
                $this->session->set_flashdata('success', 'Student restored successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to restore student!');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Error restoring student: ' . $e->getMessage());
        }
        
        redirect('students/deleted');
    }

    public function permanent_delete($id)
    {
        $this->check_admin();
        
        try {
            $result = $this->student->hard_delete_student($id);
            if ($result) {
                $this->session->set_flashdata('success', 'Student permanently deleted!');
            } else {
                $this->session->set_flashdata('error', 'Failed to permanently delete student!');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Error permanently deleting student: ' . $e->getMessage());
        }
        
        redirect('students/deleted');
    }

}
