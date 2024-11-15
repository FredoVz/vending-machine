<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load session library jika belum diload di autoload.php
        $this->load->library('session');

        //$this->db_vm = $this->load->database('db_vm', TRUE);
        //$this->opc = $this->load->database('opc', TRUE);
        //$this->opc6 = $this->load->database('opc6', TRUE);
    }

    public function index()
    {
        /*
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        */

        // Array of hardcoded staff members
        $arrayStaff = [
            [
                "Kode" => "00013\/01\/0P",
                "Nama" => "SALESSCTHR1@GMAIL.COM",
                "Email" => "SALESSCTHR1@GMAIL.COM",
                "NamaAlias" => "",
                "Aktif" => "1",
                "Jabatan" => "ADMINISTRATOR",
                "Branch" => "00013",
                "Password" => "omega",
            ],
            [
                "Kode" => "0000J\/01\/02",
                "Nama" => "admin@gmail.com",
                "Email" => "admin@gmail.com",
                "NamaAlias" => "Logistik",
                "Aktif" => "1",
                "Jabatan" => "ADMINISTRATOR",
                "Branch" => "0000J",
                "Password" => "omega",
            ],
        ];

        // If form is submitted, perform validation
        if ($this->input->post()) {
            $email = $this->input->post('email', true);
            $password = $this->input->post('password', true);

            // Check if the email and password match any entry in arrayStaff
            $foundUser = null;
            foreach ($arrayStaff as $staff) {
                if (strtolower($staff['Email']) === strtolower($email) && $staff['Password'] === $password) {
                    $foundUser = $staff;
                    break;
                }
            }



            if ($foundUser) {
                $nama = strtolower($foundUser['Nama']);
                
                // Set session data if login is successful
                $this->session->set_userdata([
                    'email' => $nama,
                    'kode' => $foundUser['Kode'],
                    'aktif' => $foundUser['Aktif'],
                    'jabatan' => $foundUser['Jabatan'],
                    'branch' => $foundUser['Branch'],
                    'logged_in' => true, // Marks user as logged in
                ]);
                redirect('dashboard');
            } else {
                // Set flashdata for error message
                $this->session->set_flashdata('error', [
                    'icon' => 'error',
                    'title' => 'Login Gagal!',
                    'text' => 'Akun tidak ditemukan!',
                ]);
                redirect('login');
            }
        } else {
            // Load login view if form is not submitted
            $this->load->view('login');
        }
    }


    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}