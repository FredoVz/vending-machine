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
            ['id' => '1', 'vendingMachine' => 'Wapo 1', 'cabang' => 'Surabaya', 'stok' => '10', 'sisa_stok' => '5'],
            ['id' => '2', 'vendingMachine' => 'Wapo 2', 'cabang' => 'Jakarta', 'stok' => '20', 'sisa_stok' => '5'],
            ['id' => '3', 'vendingMachine' => 'Wapo 3', 'cabang' => 'Malang', 'stok' => '30', 'sisa_stok' => '5'],
        ];

        $data = ['arrayVM' => $arrayVM];

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
		$this->load->view('dashboard', $data);
        $this->load->view('templates/footer');
	}

    public function detail(){
        $qty = $this->input->post('qty');

        //echo $qty;

        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">New Qty added!</div>');
        redirect('dashboard');
    }
}