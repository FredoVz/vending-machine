<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail extends CI_Controller
{
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

	public function index($noMesin,$namaStaff,$namaCabang)
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

        $data['noMesin'] = $noMesin;
        $data['namaStaff'] = $namaStaff;
        $data['namaCabang'] = $namaCabang;
		$data['arrayDetailVM'] = $arrayDetailVM;

		$this->load->view('templates/header');
        $this->load->view('templates/sidebar');
		$this->load->view('detail', $data);
		$this->load->view('templates/footer');
	}

	public function add()
	{
        if ($this->input->post()){
            echo "<pre>===TAMPIL DI CONTROLLER===</pre>";
    
            // Ambil data hidden input dari form header
            $branch = $this->session->userdata('branch_refill_vendingmachine');
            $noMesin = $this->input->post('NoMesin');
            $namaStaff = $this->input->post('NamaStaff');
            $namaCabang = $this->input->post('NamaCabang');
            $cabang = $branch."/01";
    
            // Ambil data qty yang diinputkan oleh pengguna
            $qty = $this->input->post('qty'); // qty adalah array, misalnya qty[0], qty[1], ...
    
            // Retrieve the 'details' array from POST data
            $arrayDetailVM = json_decode($this->input->post('arrayDetailVM'), true); // Decode JSON to array

            // Ambil nilai 'approve' dari form POST
            $isApproved = $this->input->post('approve');

            // Format mengikuti database
            $createBy = $this->formatDatabase($cabang);
            $operator = $this->formatDatabase($cabang);
            $approvedBy = $this->formatDatabase($cabang);
            
            //-- 4. simpan Opname Slot IOT - di kanan atas saat detail
            //--dapetin kodenota
            echo "<pre>===Kode Nota===</pre>";
    
            $queryGetKode = "IF (SELECT OBJECT_ID('tempdb..#LastKodeNotaSlotIOT')) IS NOT NULL DROP TABLE #LastKodeNotaSlotIOT
            SELECT '" . $branch . "'+'/IOT/'+RIGHT(CAST(DATEPART(YEAR,GETDATE()) AS VARCHAR),2)+RIGHT('00'+CAST(DATEPART(MM,GETDATE()) AS VARCHAR),2)+'/'+RIGHT('0000000'+CAST(ISNULL((select top 1 CAST(RIGHT(p.KodeNota,7) AS NUMERIC(8,0)) from MasterKejadianSlotIOT p where p.KodeNota like '" . $branch . "'+'/IOT/'+RIGHT(CAST(DATEPART(YEAR,GETDATE()) AS VARCHAR),2)+RIGHT('00'+CAST(DATEPART(MM,GETDATE()) AS VARCHAR),2)+'/%' order by p.KodeNota desc),1) AS VARCHAR),7) KodeNota
            INTO #LastKodeNotaSlotIOT";
    
            echo $queryGetKode;
    
            //--insert master
            echo "<pre>===Master===</pre>";
    
            //--untuk isapproved ini akan 1 atau 0 tergantung centangan Approved, dan ApprovedBy dan ApprovedDate akan ada isi kalau dicentang
            if($isApproved == 1) {
                echo "<pre>===Is Approved===</pre>";
    
                $queryInsertMasters = "insert INTO MasterKejadianSlotIOT(KodeNota, Tgl, NoMesin, Keterangan, CreateBy, CreateDate, Operator, TglEntry, IsApproved, ApprovedBy, ApprovedDate, Cabang)
                SELECT KodeNota, CAST(FLOOR(CAST(GETDATE() AS FLOAT)) AS DATETIME), '" . $noMesin . "', '', '" . $createBy . "', GETDATE(), '" . $operator . "', GETDATE(), $isApproved, '" . $approvedBy . "', GETDATE(), '" . $cabang . "'
                FROM #LastKodeNotaSlotIOT";
    
                echo $queryInsertMasters;
            }
    
            //--untuk isapproved ini akan 1 atau 0 tergantung centangan Approved, dan ApprovedBy dan ApprovedDate akan ada isi kalau dicentang
            else if($isApproved == 0){
                echo "<pre>===Not Approved===</pre>";
    
                $queryInsertMasters1 = "insert INTO MasterKejadianSlotIOT(KodeNota, Tgl, NoMesin, Keterangan, CreateBy, CreateDate, Operator, TglEntry, IsApproved, ApprovedBy, ApprovedDate, Cabang)
                SELECT KodeNota, CAST(FLOOR(CAST(GETDATE() AS FLOAT)) AS DATETIME), '" . $noMesin . "', '', '" . $createBy . "', GETDATE(), '" . $operator . "', GETDATE(), $isApproved, NULL, NULL, '" . $cabang . "'
                FROM #LastKodeNotaSlotIOT";
        
                echo $queryInsertMasters1;
            }
    
            // Start output buffering
            ob_start();
    
            //--insert detail, ini di looping sebanyak detail slot nya
            echo "<pre>===Details===</pre>";
    
            // Sample SQL query output for demonstration
    
            // Cek apakah arrayDetailVM tidak kosong
            if (!empty($arrayDetailVM) && !empty($qty)) 
            {
                foreach ($arrayDetailVM as $index => $vm) {
    
                     // Ambil qty yang sesuai dengan index dari array qty
                    $quantity = isset($qty[$index]) ? $qty[$index] : 0; // Default ke 0 jika qty tidak ada
                    
                    // Example:
                    $slot = $vm['Slot'];
                    $nama_barang = $vm['NamaBarang'];
                    $stok_akhir = (int)$vm['StokAkhir'];
                    $aktif = $vm['Aktif'];
    
                    // Tentukan stok_akhir baru berdasarkan qty yang diinput
                    if ($quantity > 0) {
                        // Jika qty diinputkan lebih besar dari 0, maka stok_akhir digantikan dengan nilai qty
                        $stok_akhir = $quantity;  // Gantikan stok_akhir dengan qty
                    }
    
                    // Lakukan insert/update database sesuai kebutuhan
                    $query = "insert INTO DetailKejadianSlotIOT (KodeNota, Slot, StokAkhir, PrevStok)
                    SELECT KodeNota, '".$slot."', '".$stok_akhir."', 0 FROM #LastKodeNotaSlotIOT";

                    echo $query . '<br>';
                }
            }
    
            // End output buffering and send output
            ob_end_flush();
    
            //-- 5. jika centangan approved, dicentang, maka jalankan ini juga
            if($isApproved == 1){
                $query = "select * from #LastKodeNotaSlotIOT";
                $kodenotap4 = "this->opc->query($query)->row()";
                echo "<pre>===Approved===</pre>";
    
                echo "<pre>===Insert===</pre>";
    
                $queryInsertIsApproved = "insert INTO SlotIOT(NoMesin, Slot, Staff, Cabang, StokAkhir, Operator, TglEntry, Brg, SlotMerged, Aktif)
                SELECT m.NoMesin, d.Slot, '', m.Cabang, d.StokAkhir, '".$operator."', GETDATE(), NULL, NULL, 1
                FROM MasterKejadianSlotIOT m, DetailKejadianSlotIOT d
                WHERE m.KodeNota=$kodenotap4
                AND m.KodeNota=d.KodeNota
                AND NOT EXISTS(SELECT * FROM SlotIOT s WHERE m.NoMesin=s.NoMesin AND d.Slot=s.Slot)";

                //$this->opc->query($queryInsertIsApproved);
                echo $queryInsertIsApproved;
    
                echo "<pre>===Update===</pre>";
    
                $queryUpdateIsApproved = "update s
                SET s.StokAkhir=d.StokAkhir, s.Operator='".$operator."', s.TglEntry=GETDATE()
                FROM MasterKejadianSlotIOT m, DetailKejadianSlotIOT d, SlotIOT s
                WHERE m.KodeNota=$kodenotap4
                AND m.KodeNota=d.KodeNota
                AND m.NoMesin=s.NoMesin
                AND d.Slot=s.Slot";

                //$this->opc->query($queryUpdateIsApproved);
                echo $queryUpdateIsApproved;
    
                $message = "Berhasil Update Slot. *With Approve";
    
                
                $this->session->set_flashdata('message', [
                    'icon' => 'success',
                    'title' => 'Success!',
                    'text' => $message,
                ]);
            }
    
            else {
                $message = "Insert Sukses! with no Approve";
    
                
                $this->session->set_flashdata('message', [
                    'icon' => 'success',
                    'title' => 'Success!',
                    'text' => $message,
                ]);
            }

            redirect('dashboard');
        }
	}

	public function formatDatabase($cabang){
        $format = $cabang . "/01";

        return $format;
    }
}
