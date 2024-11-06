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
                'Details'=> $arrayDetailVM,
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

        echo "<pre>";
        echo "===TAMPIL DI CONTROLLER===";
        echo "</pre>";

        // Retrieve the 'details' array from POST data
        $details = $this->input->post('details');
        $qty = $this->input->post('qty');

        // Display the array data
        //echo "<pre>";
        //print_r($details); // Output the details array for inspection
        //echo "</pre>";

        // Display the qty value
        //echo "<pre>";
        //echo "Qty: " . $qty;
        //echo "</pre>";

        // Sample SQL query output for demonstration
        if ($details) {
            foreach ($details as $detail) {
                if (empty($detail['qty']) || $detail['qty'] < 0) {
                    $detail['qty'] = 0;
                }

                $slot = $detail['Slot'];
                $stok_akhir = $detail['StokAkhir'];
                $nama_barang = $detail['NamaBarang'];
                $status_aktif = $detail['Aktif'];
                $qty = $detail['qty'];

                //echo "INSERT INTO DetailKejadianSlotIOT (KodeNota, $slot, $stok_akhir, PrevStok)
                //SELECT KodeNota, '$slot', '$stok_akhir', 0 FROM #LastKodeNotaSlotIOT;<br>";

                $query = "INSERT INTO DetailKejadianSlotIOT (KodeNota, Slot, StokAkhir, PrevStok)
                SELECT KodeNota, '$slot', '$stok_akhir', 0 FROM #LastKodeNotaSlotIOT;<br>";

                echo "<pre>";
                echo "Qty: " . $qty;
                echo "</pre>";

                echo $query;
            }
        }

        /*
        -- 4. simpan Opname Slot IOT - di kanan atas saat detail
        --dapetin kodenota
        IF (SELECT OBJECT_ID('tempdb..#LastKodeNotaSlotIOT')) IS NOT NULL DROP TABLE #LastKodeNotaSlotIOT
        SELECT :branch+'/IOT/'+RIGHT(CAST(DATEPART(YEAR,GETDATE()) AS VARCHAR),2)+RIGHT('00'+CAST(DATEPART(MM,GETDATE()) AS VARCHAR),2)+'/'+RIGHT('0000000'+CAST(ISNULL((select top 1 CAST(RIGHT(p.KodeNota,7) AS NUMERIC(8,0)) from MasterKejadianSlotIOT p where p.KodeNota like :branch+'/IOT/'+RIGHT(CAST(DATEPART(YEAR,GETDATE()) AS VARCHAR),2)+RIGHT('00'+CAST(DATEPART(MM,GETDATE()) AS VARCHAR),2)+'/%' order by p.KodeNota desc),1) AS VARCHAR),7) KodeNota
        INTO #LastKodeNotaSlotIOT

        --insert master
        INSERT INTO MasterKejadianSlotIOT(KodeNota, Tgl, NoMesin, Keterangan, CreateBy, CreateDate, Operator, TglEntry, IsApproved, ApprovedBy, ApprovedDate, Cabang)
        SELECT KodeNota, CAST(FLOOR(CAST(GETDATE() AS FLOAT)) AS DATETIME), :NoMesin, :Keterangan, :CreateBy, GETDATE(), :Operator, GETDATE(), :IsApproved, :ApprovedBy, :ApprovedDate, :Cabang
        FROM #LastKodeNotaSlotIOT

        --untuk isapproved ini akan 1 atau 0 tergantung centangan Approved, dan ApprovedBy dan ApprovedDate akan ada isi kalau dicentang

        --insert detail, ini di looping sebanyak detail slot nya
        INSERT INTO DetailKejadianSlotIOT(KodeNota, Slot, StokAkhir, PrevStok)
        SELECT KodeNota, :Slot, :StokAkhir, 0
        FROM #LastKodeNotaSlotIOT
        */

        //echo $qty;

        //Cara 1
        /*
        die;

        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">New Qty added!</div>');
        redirect('dashboard');
        */

        //Cara 2
        $data['details'] = $details;
        $data['query'] = $query;
        //echo $query;
        $this->load->view('detail', $data);
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