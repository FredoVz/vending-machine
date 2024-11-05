<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load session library jika belum diload di autoload.php
        $this->load->library('session');
    }

	public function index()
	{
        if ($this->session->userdata('logged_in'))
        {
            redirect('dashboard');
        }

        // Jika form disubmit, lakukan validasi
        if ($this->input->post()) {
            $email = $this->input->post('email', true);
            $password = $this->input->post('password', true);

            // Validasi hardcoded
            if ($email === 'admin@gmail.com' && $password === 'sukses') {
                // Redirect ke halaman dashboard jika berhasil login
                // Set session userdata
                $this->session->set_userdata([
                    'email' => $email,
                    'logged_in' => true // Menandakan user telah login
                ]);
                redirect('dashboard');
            } else {
                // Set flashdata untuk pesan error
                $this->session->set_flashdata('error', 'Akun tidak ditemukan!');
                redirect('login');
            }
        } else {
            // Load view login jika belum ada input
            $this->load->view('login');
        }
		
	}

    public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}