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
            $username = $this->input->post('username', true);
            $password = $this->input->post('password', true);

            // Validasi hardcoded
            if ($username === 'admin' && $password === 'sukses') {
                // Redirect ke halaman dashboard jika berhasil login
                // Set session userdata
                $this->session->set_userdata([
                    'username' => $username,
                    'logged_in' => true // Menandakan user telah login
                ]);
                redirect('dashboard');
            } else {
                // Set flashdata untuk pesan error
                $this->session->set_flashdata('error', 'Username atau Password salah!');
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