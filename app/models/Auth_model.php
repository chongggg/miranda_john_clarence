<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Auth_model extends Model
{
    protected $table = "auth";
    protected $primary_key = "id";
    protected $soft_delete = true;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Register a new user
     */
    public function register($student_data, $auth_data)
    {
        try {
            $this->db->transaction();
            
            // Insert student record
            $student_id = $this->db->table('students')->insert($student_data);
            
            if (!$student_id) {
                throw new Exception('Failed to create student record');
            }
            
            // Insert auth record
            $auth_data['student_id'] = $student_id;
            $auth_result = $this->db->table($this->table)->insert($auth_data);
            
            if (!$auth_result) {
                throw new Exception('Failed to create auth record');
            }
            
            $this->db->commit();
            return $student_id;
            
        } catch (Exception $e) {
            $this->db->roll_back();
            return false;
        }
    }

    /**
     * Login user
     */
    public function login($username, $password)
    {
        $user = $this->db->table($this->table)
            ->join('students', 'auth.student_id = students.id')
            ->where('auth.username', $username)
            ->where('students.deleted_at', null)
            ->get();
            
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }

    /**
     * Get user by student ID
     */
    public function get_user_by_student_id($student_id)
    {
        return $this->db->table($this->table)
            ->join('students', 'auth.student_id = students.id')
            ->where('auth.student_id', $student_id)
            ->where('students.deleted_at', null)
            ->get();
    }

    /**
     * Get auth with student details by student ID
     */
    public function get_auth_with_student_by_id($student_id)
    {
        return $this->db->table($this->table . ' a')
                        ->join('students s', 'a.student_id = s.id')
                        ->where('a.student_id', $student_id)
                        ->where_null('s.deleted_at')
                        ->select('a.id as auth_id, a.student_id, a.username, a.password, a.role, a.profile_image, a.created_at as auth_created_at, a.updated_at as auth_updated_at, s.id, s.first_name, s.last_name, s.email, s.profile_image as student_profile_image')
                        ->get();
    }

    /**
     * Get auth record by student ID
     */
    public function get_auth_by_student_id($student_id)
    {
        return $this->db->table($this->table)
                        ->where('student_id', $student_id)
                        ->get();
    }

    /**
     * Get auth with student details
     */
    public function get_auth_with_student($username)
    {
        return $this->db->table($this->table . ' a')
                        ->join('students s', 'a.student_id = s.id')
                        ->where('a.username', $username)
                        ->where_null('s.deleted_at')
                        ->select('a.*, s.first_name, s.last_name, s.email, s.profile_image as student_profile_image')
                        ->get();
    }

    /**
     * Update user profile
     */
    public function update_profile($student_id, $student_data, $auth_data = null)
    {
        try {
            $this->db->transaction();
            
            // Update student record
            $student_result = $this->db->table('students')
                ->where('id', $student_id)
                ->update($student_data);
            
            if (!$student_result) {
                throw new Exception('Failed to update student record');
            }
            
            // Update auth record if provided
            if ($auth_data) {
                $auth_result = $this->db->table($this->table)
                    ->where('student_id', $student_id)
                    ->update($auth_data);
                
                if (!$auth_result) {
                    throw new Exception('Failed to update auth record');
                }
            }
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->roll_back();
            return false;
        }
    }

    /**
     * Check if username exists
     */
    public function username_exists($username, $exclude_id = null)
    {
        $query = $this->db->table($this->table)->where('username', $username);
        
        if ($exclude_id) {
            $query->where('id', '!=', $exclude_id);
        }
        
        return $query->get() ? true : false;
    }

    /**
     * Get all users with student info (for admin)
     */
    public function get_all_users()
    {
        return $this->db->table($this->table)
            ->join('students', 'auth.student_id = students.id')
            ->where('students.deleted_at', null)
            ->order_by('students.created_at', 'DESC')
            ->get_all();
    }

    /**
     * Delete user (soft delete)
     */
    public function delete_user($student_id)
    {
        try {
            $this->db->transaction();
            
            // Soft delete student (auth table doesn't have deleted_at column)
            $student_result = $this->db->table('students')
                ->where('id', $student_id)
                ->update(['deleted_at' => date('Y-m-d H:i:s')]);
            
            if (!$student_result) {
                throw new Exception('Failed to delete student record');
            }
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->roll_back();
            return false;
        }
    }

    /**
     * Restore user (un-soft delete)
     */
    public function restore_user($student_id)
    {
        try {
            $this->db->transaction();
            
            // Use the Student model's restore method
            $student_result = $this->db->table('students')
                ->where('id', $student_id)
                ->update(['deleted_at' => NULL]);
            
            if (!$student_result) {
                throw new Exception('Failed to restore student record');
            }
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->roll_back();
            error_log('Restore user error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Force delete user (permanent delete)
     */
    public function force_delete_user($student_id)
    {
        try {
            $this->db->transaction();
            
            // Delete auth record first (due to foreign key constraint)
            $auth_result = $this->db->table($this->table)
                ->where('student_id', $student_id)
                ->delete();
            
            // Delete student record
            $student_result = $this->db->table('students')
                ->where('id', $student_id)
                ->delete();
            
            if (!$student_result) {
                throw new Exception('Failed to permanently delete student record');
            }
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->roll_back();
            error_log('Force delete user error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update password
     */
    public function update_password($student_id, $new_password)
    {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        return $this->db->table($this->table)
            ->where('student_id', $student_id)
            ->update(['password' => $hashed_password]);
    }
}
