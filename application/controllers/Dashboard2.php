<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard2 extends CI_Controller {

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
        $arrayDetailVM = $this->arrayDetailVM();

        $namaStaff = $arrayDetailVM[0]['NamaStaff'];

        $cabang = $this->session->userdata('branch_refill_vendingmachine');

        $arrayVM = [
            /*
            [
                'Cabang' => $cabang,
                'NamaCabang' => 'OMEGA KOPERASI',
                'AlamatHeader' => '10',
                'KotaHeader' => '',
                'NoMesin' => 'EMULATOR34X2X1',
                'LastPing' => '2024-07-29 11:56:36.760',
                'StatusVM' => 'OFF',
                'SelisihJam' => '2376',
            ],
            */
        ];

        $data = [
            'arrayVM' => $arrayVM,
            'arrayDetailVM' => $arrayDetailVM,
            'namaStaff' => $namaStaff,
        ];

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('dashboard2', $data);
        $this->load->view('templates/footer');
	}

    public function arrayDetailVM()
    {
        $arrayDetailVM = [
            [
                'NoMesin' => 'EMULATOR34X2X1',
                'Slot' => '1',
                'StokAkhir' => '7,0000',
                'NamaOperator' => 'AZIZOMEGASOFT@GMAIL.COM',
                'TglEntry' => '2024-07-09 11:09:25.133',
                'NamaStaff' => 'AZIZOMEGASOFT@GMAIL.COM',
                'NamaCabang' => 'OMEGA KOPERASI',
                'NamaBarang' => 'Other Beverages2',
                'Aktif' => '1',
            ],
            [
                'NoMesin' => 'EMULATOR34X2X1',
                'Slot' => '2',
                'StokAkhir' => '7,0000',
                'NamaOperator' => 'AZIZOMEGASOFT@GMAIL.COM',
                'TglEntry' => '2024-07-09 11:09:25.133',
                'NamaStaff' => 'AZIZOMEGASOFT@GMAIL.COM',
                'NamaCabang' => 'OMEGA KOPERASI',
                'NamaBarang' => 'Other Beverages2',
                'Aktif' => '1',
            ],
            [
                'NoMesin' => 'EMULATOR34X2X1',
                'Slot' => '3',
                'StokAkhir' => '7,0000',
                'NamaOperator' => 'AZIZOMEGASOFT@GMAIL.COM',
                'TglEntry' => '2024-07-09 11:09:25.133',
                'NamaStaff' => 'AZIZOMEGASOFT@GMAIL.COM',
                'NamaCabang' => 'OMEGA KOPERASI',
                'NamaBarang' => 'Other Beverages2',
                'Aktif' => '1',
            ],
            [
                'NoMesin' => 'EMULATOR34X2X1',
                'Slot' => '1',
                'StokAkhir' => '7,0000',
                'NamaOperator' => 'AZIZOMEGASOFT@GMAIL.COM',
                'TglEntry' => '2024-07-09 11:09:25.133',
                'NamaStaff' => 'AZIZOMEGASOFT@GMAIL.COM',
                'NamaCabang' => 'OMEGA KOPERASI',
                'NamaBarang' => 'Other Beverages2',
                'Aktif' => '1',
            ],
            [
                'NoMesin' => 'EMULATOR34X2X1',
                'Slot' => '1',
                'StokAkhir' => '7,0000',
                'NamaOperator' => 'AZIZOMEGASOFT@GMAIL.COM',
                'TglEntry' => '2024-07-09 11:09:25.133',
                'NamaStaff' => 'AZIZOMEGASOFT@GMAIL.COM',
                'NamaCabang' => 'OMEGA KOPERASI',
                'NamaBarang' => 'Other Beverages2',
                'Aktif' => '1',
            ],
        ];

        return $arrayDetailVM;
    }
}
