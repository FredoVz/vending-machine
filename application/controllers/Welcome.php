<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->helper('url');
        // Load session library jika belum diload di autoload.php
        $this->load->library('session');

        // Check if user is logged in, otherwise redirect to login page
        if (!$this->session->userdata('email_refill_vendingmachine')) {
            redirect('login'); // Redirect to login page if not logged in
        }
    }
	
	public function index()
	{
		$this->load->view('welcome_message');
	}
}
