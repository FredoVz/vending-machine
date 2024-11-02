<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load session library jika belum diload di autoload.php
        $this->load->library('session');

        // Check if user is logged in, otherwise redirect to login page
        if (!$this->session->userdata('logged_in')) {
            redirect('login'); // Redirect to login page if not logged in
        }
    }

	public function index()
	{
        $arrayVM = [
            ['vendingMachine' => 'Wapo 1', 'cabang' => 'Surabaya'],
            ['vendingMachine' => 'Wapo 2', 'cabang' => 'Jakarta'],
            ['vendingMachine' => 'Wapo 3', 'cabang' => 'Malang'],
        ];

        $data = ['arrayVM' => $arrayVM];

		$this->load->view('dashboard', $data);
	}
}