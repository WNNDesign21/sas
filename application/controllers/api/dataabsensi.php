<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Dataabsensi extends RestController
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries/models if needed
        // $this->load->model('Attendance_model'); // Example if you have a model
        $this->load->library('session');
        $this->load->database(); // Ensure database is loaded
    }

    /**
     * API endpoint to get attendance data for the logged-in student, grouped by course.
     * Requires the user to be logged in (session check).
     * URL: /api/dataabsensi/get_student_attendance
     * Method: GET
     * Response: JSON
     */
    public function index_get()
    {
        // Ambil id_user dari parameter GET
        $id_user = $this->get('id_user');

        $id_user = $this->session->userdata('id_user'); // Get logged-in student's ID (NPM) from session

        if (empty($id_user)) {
            $this->response([
                'status' => false,
                'message' => 'Parameter id_user wajib diisi.'
            ], RestController::HTTP_BAD_REQUEST); // 400 Bad Request
            return;
        }

        // Query to get attendance data for the specific student, joining with mata_kuliah
        // Assuming 'absensi' table has columns: npm (or id_user), id_mk, pertemuan, status, tanggal, timestamp
        // Assuming 'mata_kuliah' table has columns: id_mk, nama_mk
        // Note: Based on scanqr.php, the column for student ID in 'absensi' is 'npm'. Let's use 'npm'.
        $this->db->select('a.id_mk, mk.nama_mk, a.pertemuan, a.status, a.tanggal, a.timestamp');
        $this->db->from('absensi a');
        $this->db->join('mata_kuliah mk', 'a.id_mk = mk.id_mk', 'left');
        $this->db->where('a.npm', $id_user); // Use 'npm' based on scanqr.php
        $this->db->order_by('mk.nama_mk ASC, a.pertemuan ASC'); // Order for better grouping

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $results = $query->result_array();

            // Group results by mata_kuliah
            $grouped_attendance = [];
            foreach ($results as $row) {
                $id_mk = $row['id_mk'];
                $nama_mk = $row['nama_mk'];

                // If this course hasn't been added yet, initialize it
                if (!isset($grouped_attendance[$id_mk])) {
                    $grouped_attendance[$id_mk] = [
                        'id_mk' => $id_mk,
                        'nama_mk' => $nama_mk,
                        'attendance' => []
                    ];
                }

                // Add the attendance detail to the course
                $grouped_attendance[$id_mk]['attendance'][] = [
                    'pertemuan' => (int) $row['pertemuan'], // Cast to integer
                    'status' => $row['status'],
                    'tanggal' => $row['tanggal'], // Include date
                    'timestamp' => $row['timestamp'] // Include timestamp
                ];
            }

            // Convert associative array (keyed by id_mk) to indexed array for cleaner JSON output
            $output_data = array_values($grouped_attendance);

            $this->response([
                'status' => true,
                'message' => 'Attendance data retrieved successfully.',
                'data' => $output_data
            ], RestController::HTTP_OK); // 200 OK

        } else {
            // No attendance data found for this user
            $this->response([
                'status' => true, // Still true, just no data found for the user
                'message' => 'No attendance data found for this user.',
                'data' => []
            ], RestController::HTTP_OK); // 200 OK
        }
    }

    // You can add other API methods here for mobile app needs

}

/* End of file Dataabsensi.php */
/* Location: ./application/controllers/api/Dataabsensi.php */