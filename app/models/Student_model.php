<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Student_model extends Model
{
    protected $table = "students";
    protected $primary_key = "id";
    protected $has_soft_delete = true;
    protected $soft_delete_column = "deleted_at";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Count all records with search functionality
     */
    public function count_all_records($search = '')
    {
        if (empty($search)) {
            return $this->count(false); // Use ORM method to exclude soft-deleted
        }
        
        // For search, use raw SQL like the reference project
        $like = "%{$search}%";
        $sql = "SELECT COUNT(*) as total 
                FROM {$this->table} 
                WHERE deleted_at IS NULL 
                AND (first_name LIKE ? OR last_name LIKE ? OR email LIKE ?)";
        $result = $this->db->raw($sql, [$like, $like, $like]);
        return $result ? $result->fetch()['total'] : 0;
    }

    /**
     * Get records with pagination and search
     */
    public function get_records_with_pagination($limit_clause, $search = '')
    {
        if (empty($search)) {
            // Parse the limit clause string (format: "LIMIT offset,limit")
            $limit_parts = explode(',', str_replace('LIMIT ', '', $limit_clause));
            $offset = (int)$limit_parts[0];
            $limit = (int)$limit_parts[1];
            
            // Use ORM methods - they return arrays, not query builders
            $all_records = $this->order_by('id', 'DESC', false);
            
            // Apply offset and limit manually to the array
            return array_slice($all_records, $offset, $limit);
        }
        
        // For search, use raw SQL like the reference project
        $like = "%{$search}%";
        $sql = "SELECT id, first_name, last_name, email, profile_image, deleted_at, created_at, updated_at 
                FROM {$this->table} 
                WHERE deleted_at IS NULL 
                AND (first_name LIKE ? OR last_name LIKE ? OR email LIKE ?)
                ORDER BY id DESC {$limit_clause}";
        $result = $this->db->raw($sql, [$like, $like, $like]);
        return $result ? $result->fetchAll() : [];
    }

    /**
     * Get all students (excluding soft deleted)
     */
    public function get_all_students()
    {
        return $this->db->table($this->table)->get_all();
    }

    /**
     * Get soft deleted students
     */
    public function get_soft_deleted_students()
    {
        return $this->db->table($this->table)
                        ->where_not_null('deleted_at')
                        ->order_by('deleted_at', 'DESC')
                        ->get_all();
    }

    /**
     * Get student by ID (excluding soft-deleted)
     */
    public function get_student($id)
    {
        return $this->find($id, false); // false = exclude soft-deleted
    }

    /**
     * Get student by ID (including soft-deleted) - for testing purposes
     */
    public function get_student_with_deleted($id)
    {
        return $this->find($id, true); // true = include soft-deleted
    }


    /**
     * Insert student
     */
    public function insert_student($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->table($this->table)->insert($data);
    }

    /**
     * Update student
     */
    public function update_student($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->table($this->table)->where('id', $id)->update($data);
    }

    /**
     * Soft delete student
     */
    public function delete_student($id)
    {
        return $this->soft_delete($id);
    }

    /**
     * Override soft_delete method to automatically set updated_at timestamp
     */
    public function soft_delete($id) {
        // Update the updated_at timestamp when soft deleting
        $this->db->table($this->table)
                 ->where('id', $id)
                 ->update(['updated_at' => date('Y-m-d H:i:s')]);
        return parent::soft_delete($id);
    }

    /**
     * Override restore method to automatically set updated_at timestamp
     */
    public function restore($id) {
        // Update the updated_at timestamp when restoring
        $this->db->table($this->table)
                 ->where('id', $id)
                 ->update(['updated_at' => date('Y-m-d H:i:s')]);
        return parent::restore($id);
    }

    /**
     * Restore soft-deleted student - Using ORM method
     */
    public function restore_student($id) {
        return $this->restore($id);
    }

    /**
     * Hard delete student (permanent deletion) - Using ORM method
     */
    public function hard_delete_student($id) {
        return $this->delete($id);
    }

    /**
     * Check if email exists
     */
    public function email_exists($email, $exclude_id = null)
    {
        $query = $this->db->table($this->table)->where('email', $email);
        
        if ($exclude_id) {
            $query->where('id', '!=', $exclude_id);
        }
        
        return $query->get() ? true : false;
    }

    /**
     * Get student by email
     */
    public function get_student_by_email($email)
    {
        return $this->db->table($this->table)->where('email', $email)->get();
    }

    /**
     * Get student with authentication details
     */
    public function get_student_with_auth($id)
    {
        return $this->db->table($this->table . ' s')
                        ->join('auth a', 's.id = a.student_id')
                        ->where('s.id', $id)
                        ->where_null('s.deleted_at')
                        ->select('s.*, a.username, a.role, a.profile_image as auth_profile_image')
                        ->get();
    }

    /**
     * Check if username exists
     */
    public function username_exists($username, $exclude_student_id = null)
    {
        $query = $this->db->table('auth')
                          ->where('username', $username);
        
        if ($exclude_student_id) {
            $query->where('student_id', '!=', $exclude_student_id);
        }
        
        $result = $query->get();
        return $result ? true : false;
    }

    /**
     * Create student with authentication record
     */
    public function create_student_with_auth($student_data, $auth_data)
    {
        try {
            // Start transaction
            $this->db->transaction();
            
            // Create student record
            $student_id = $this->insert_student($student_data);
            
            if (!$student_id) {
                throw new Exception('Failed to create student record');
            }
            
            // Add student_id to auth_data
            $auth_data['student_id'] = $student_id;
            
            // Hash password if provided
            if (isset($auth_data['password']) && !empty($auth_data['password'])) {
                $auth_data['password'] = password_hash($auth_data['password'], PASSWORD_DEFAULT);
            }
            
            // Create auth record
            $auth_result = $this->db->table('auth')->insert($auth_data);
            
            if (!$auth_result) {
                throw new Exception('Failed to create authentication record');
            }
            
            // Commit transaction
            $this->db->commit();
            return $student_id;
            
        } catch (Exception $e) {
            // Rollback transaction
            $this->db->rollback();
            throw $e;
        }
    }

    /**
     * Update student with authentication record
     */
    public function update_student_with_auth($id, $student_data, $auth_data)
    {
        try {
            // Start transaction
            $this->db->transaction();
            
            // Update student record
            $student_result = $this->update_student($id, $student_data);
            
            if (!$student_result) {
                throw new Exception('Failed to update student record');
            }
            
            // Hash password if provided and not empty
            if (isset($auth_data['password']) && !empty($auth_data['password'])) {
                $auth_data['password'] = password_hash($auth_data['password'], PASSWORD_DEFAULT);
            } else {
                // Remove password from update if empty
                unset($auth_data['password']);
            }
            
            // Update auth record
            if (!empty($auth_data)) {
                $auth_result = $this->db->table('auth')
                                      ->where('student_id', $id)
                                      ->update($auth_data);
                
                if (!$auth_result) {
                    throw new Exception('Failed to update authentication record');
                }
            }
            
            // Commit transaction
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            // Rollback transaction
            $this->db->rollback();
            throw $e;
        }
    }
}
