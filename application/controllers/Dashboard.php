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
            /*
        $arrayVM = [
            ['id' => 1, 'vendingMachine' => 'Wapo 1', 'cabang' => 'Surabaya', 'stok' => '10', 'sisa_stok' => '5'],
            ['id' => 2, 'vendingMachine' => 'Wapo 2', 'cabang' => 'Jakarta', 'stok' => '20', 'sisa_stok' => '10'],
            ['id' => 3, 'vendingMachine' => 'Wapo 3', 'cabang' => 'Malang', 'stok' => '30', 'sisa_stok' => '15'],
        ];
            */

        $arrayDetailVM = $this->arrayDetailVM();

        $namaStaff = $arrayDetailVM[0]['NamaStaff'];

        //echo json_encode($arrayDetailVM);
        //echo $namaStaff;
        //die;

        $arrayVM = [
            [
                'Cabang' => '00013/01', 
                'NamaCabang' => 'OMEGA KOPERASI', 
                'AlamatHeader' => '10', 
                'KotaHeader' => '',
                'NoMesin'=> 'EMULATOR34X2X1',
                'LastPing'=> '2024-07-29 11:56:36.760',
                'StatusVM'=> 'OFF',
                'SelisihJam'=> '2376',
            ],
        ];

        $data = [
            'arrayVM' => $arrayVM,
            'arrayDetailVM' => $arrayDetailVM,
            'namaStaff'=> $namaStaff,
        ];

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
		$this->load->view('dashboard', $data);
        $this->load->view('templates/footer');
	}

    public function detail(){

        $qty = $this->input->post('qty');

        //echo $qty;
        //die;

        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">New Qty added!</div>');
        redirect('dashboard');
    }

    public function arrayDetailVM(){
        $arrayDetailVM = [
            [
                'NoMesin'=> 'EMULATOR34X2X1',
                'Slot'=> '1',
                'StokAkhir'=> '7,0000',
                'NamaOperator'=> 'AZIZOMEGASOFT@GMAIL.COM',
                'TglEntry'=> '2024-07-09 11:09:25.133',
                'NamaStaff'=> 'AZIZOMEGASOFT@GMAIL.COM',
                'NamaCabang'=> 'OMEGA KOPERASI',
                'NamaBarang'=> 'Other Beverages2',
                'Aktif'=> '1',
            ],
            [
                'NoMesin'=> 'EMULATOR34X2X1',
                'Slot'=> '1',
                'StokAkhir'=> '7,0000',
                'NamaOperator'=> 'AZIZOMEGASOFT@GMAIL.COM',
                'TglEntry'=> '2024-07-09 11:09:25.133',
                'NamaStaff'=> 'AZIZOMEGASOFT@GMAIL.COM',
                'NamaCabang'=> 'OMEGA KOPERASI',
                'NamaBarang'=> 'Other Beverages2',
                'Aktif'=> '1',
            ],
            [
                'NoMesin'=> 'EMULATOR34X2X1',
                'Slot'=> '1',
                'StokAkhir'=> '7,0000',
                'NamaOperator'=> 'AZIZOMEGASOFT@GMAIL.COM',
                'TglEntry'=> '2024-07-09 11:09:25.133',
                'NamaStaff'=> 'AZIZOMEGASOFT@GMAIL.COM',
                'NamaCabang'=> 'OMEGA KOPERASI',
                'NamaBarang'=> 'Other Beverages2',
                'Aktif'=> '1',
            ],
            [
                'NoMesin'=> 'EMULATOR34X2X1',
                'Slot'=> '1',
                'StokAkhir'=> '7,0000',
                'NamaOperator'=> 'AZIZOMEGASOFT@GMAIL.COM',
                'TglEntry'=> '2024-07-09 11:09:25.133',
                'NamaStaff'=> 'AZIZOMEGASOFT@GMAIL.COM',
                'NamaCabang'=> 'OMEGA KOPERASI',
                'NamaBarang'=> 'Other Beverages2',
                'Aktif'=> '1',
            ],
            [
                'NoMesin'=> 'EMULATOR34X2X1',
                'Slot'=> '1',
                'StokAkhir'=> '7,0000',
                'NamaOperator'=> 'AZIZOMEGASOFT@GMAIL.COM',
                'TglEntry'=> '2024-07-09 11:09:25.133',
                'NamaStaff'=> 'AZIZOMEGASOFT@GMAIL.COM',
                'NamaCabang'=> 'OMEGA KOPERASI',
                'NamaBarang'=> 'Other Beverages2',
                'Aktif'=> '1',
            ],
        ];

        return $arrayDetailVM;
    }
}