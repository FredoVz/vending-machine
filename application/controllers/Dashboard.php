<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

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
        $arrayDetailVM = $this->arrayDetailVM();

        $namaStaff = $arrayDetailVM[0]['NamaStaff'];

        //echo json_encode($arrayDetailVM);
        //echo $namaStaff;
        //die;

        $cabang = $this->session->userdata('branch');

        $arrayVM = [
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
            [
                'Cabang' => $cabang,
                'NamaCabang' => 'OMEGA KOPERASI',
                'AlamatHeader' => '12',
                'KotaHeader' => '',
                'NoMesin' => 'EMULATOR34X2X2',
                'LastPing' => '2024-07-29 11:56:36.762',
                'StatusVM' => 'OFF',
                'SelisihJam' => '2377',
            ],
            [
                'Cabang' => $cabang,
                'NamaCabang' => 'OMEGA KOPERASI',
                'AlamatHeader' => '13',
                'KotaHeader' => '',
                'NoMesin' => 'EMULATOR34X2X3',
                'LastPing' => '2024-07-29 11:56:36.763',
                'StatusVM' => 'OFF',
                'SelisihJam' => '2378',
            ],
        ];

        $data = [
            'arrayVM' => $arrayVM,
            'arrayDetailVM' => $arrayDetailVM,
            'namaStaff' => $namaStaff,
        ];

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('dashboard', $data);
        $this->load->view('templates/footer');
    }

    public function details()
    {

        echo "<pre>";
        echo "===TAMPIL DI CONTROLLER===";
        echo "</pre>";

        // Ambil data hidden input dari form header
        $branch = $this->session->userdata('branch');
        $noMesin = $this->input->post('NoMesin');
        $namaStaff = $this->input->post('NamaStaff');
        $namaCabang = $this->input->post('NamaCabang');
        $cabang = $this->input->post('Cabang');

        // Retrieve the 'details' array from POST data
        $details = $this->input->post('details');
        $status_aktif = $details[0]['Aktif'];

        // Ambil nilai 'approve' dari form POST
        $isApproved = $this->input->post('approve');

        // Format mengikuti database
        $createBy = $this->formatDatabase($cabang);
        $operator = $this->formatDatabase($cabang);
        $approvedBy = $this->formatDatabase($cabang);

        // Display the array data
        //echo "<pre>";
        //print_r($details); // Output the details array for inspection
        //echo "</pre>";

        echo "<pre>===Kode Nota===</pre>";

        $queryGetKode = "IF (SELECT OBJECT_ID('tempdb..#LastKodeNotaSlotIOT')) IS NOT NULL DROP TABLE #LastKodeNotaSlotIOT
        SELECT '" . $branch . "'+'/IOT/'+RIGHT(CAST(DATEPART(YEAR,GETDATE()) AS VARCHAR),2)+RIGHT('00'+CAST(DATEPART(MM,GETDATE()) AS VARCHAR),2)+'/'+RIGHT('0000000'+CAST(ISNULL((select top 1 CAST(RIGHT(p.KodeNota,7) AS NUMERIC(8,0)) from MasterKejadianSlotIOT p where p.KodeNota like '" . $branch . "'+'/IOT/'+RIGHT(CAST(DATEPART(YEAR,GETDATE()) AS VARCHAR),2)+RIGHT('00'+CAST(DATEPART(MM,GETDATE()) AS VARCHAR),2)+'/%' order by p.KodeNota desc),1) AS VARCHAR),7) KodeNota
        INTO #LastKodeNotaSlotIOT";

        echo $queryGetKode;

        echo "<pre>===Master===</pre>";

        if ($isApproved == 1) {
            echo "<pre>===Is Approved===</pre>";

            $queryInsertMasters = "insert INTO MasterKejadianSlotIOT(KodeNota, Tgl, NoMesin, Keterangan, CreateBy, CreateDate, Operator, TglEntry, IsApproved, ApprovedBy, ApprovedDate, Cabang)
			SELECT KodeNota, CAST(FLOOR(CAST(GETDATE() AS FLOAT)) AS DATETIME), '" . $noMesin . "', '', '" . $createBy . "', GETDATE(), '" . $operator . "', GETDATE(), $isApproved, '" . $approvedBy . "', GETDATE(), '" . $cabang . "'
			FROM #LastKodeNotaSlotIOT";

            echo $queryInsertMasters;
        } else if ($isApproved == 0) {
            echo "<pre>===No Approved===</pre>";

            $queryInsertMasters1 = "insert INTO MasterKejadianSlotIOT(KodeNota, Tgl, NoMesin, Keterangan, CreateBy, CreateDate, Operator, TglEntry, IsApproved, ApprovedBy, ApprovedDate, Cabang)
			SELECT KodeNota, CAST(FLOOR(CAST(GETDATE() AS FLOAT)) AS DATETIME), '" . $noMesin . "', '', '" . $createBy . "', GETDATE(), '" . $operator . "', GETDATE(), $isApproved, NULL, NULL, '" . $cabang . "'
			FROM #LastKodeNotaSlotIOT";

            echo $queryInsertMasters1;
        }

        // Start output buffering
        ob_start();

        echo "<pre>===Details===</pre>";

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

                //echo "insert INTO DetailKejadianSlotIOT (KodeNota, $slot, $stok_akhir, PrevStok)
                //SELECT KodeNota, '$slot', '$stok_akhir', 0 FROM #LastKodeNotaSlotIOT;<br>";

                $query = "insert INTO DetailKejadianSlotIOT (KodeNota, Slot, StokAkhir, PrevStok)
                        SELECT KodeNota, '" . $slot . "', '" . $stok_akhir . "', 0 FROM #LastKodeNotaSlotIOT";

                //$query = "insert INTO DetailKejadianSlotIOT (KodeNota, Slot, StokAkhir, PrevStok)
                //SELECT KodeNota, '".$slot."', '".$stok_akhir."', 0 FROM #LastKodeNotaSlotIOT;";

                //echo "<pre>";
                //echo "Qty: " . $qty;
                //echo "</pre>";

                //echo $query . '<br>';
            }
        }

        // End output buffering and send output
        ob_end_flush();

        if ($isApproved == 1) {
            $query = "select * from #LastKodeNotaSlotIOT";
            //$kodenotap4 = $this->opc->query($query)->row();
            echo "<pre>===Approved===</pre>";

            $queryInsertIsApproved = "insert INTO SlotIOT(NoMesin, Slot, Staff, Cabang, StokAkhir, Operator, TglEntry, Brg, SlotMerged, Aktif)
                    SELECT m.NoMesin, d.Slot, '', m.Cabang, d.StokAkhir, '" . $operator . "', GETDATE(), NULL, NULL, 1
                    FROM MasterKejadianSlotIOT m, DetailKejadianSlotIOT d
                    WHERE m.KodeNota=:kodenotaPoint4
                    AND m.KodeNota=d.KodeNota
                    AND NOT EXISTS(SELECT * FROM SlotIOT s WHERE m.NoMesin=s.NoMesin AND d.Slot=s.Slot)";
            //$this->opc->query($queryInsertIsApproved);
            echo $queryInsertIsApproved;

            $queryUpdateIsApproved = "update s
                    SET s.StokAkhir=d.StokAkhir, s.Operator='" . $operator . "', s.TglEntry=GETDATE()
                    FROM MasterKejadianSlotIOT m, DetailKejadianSlotIOT d, SlotIOT s
                    WHERE m.KodeNota=:kodenotaPoint4
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
        } else {
            $message = "Insert Sukses! with no Approve";

            $this->session->set_flashdata('message', [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => $message,
            ]);
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

              -- 5. jika centangan approved, dicentang, maka jalankan ini juga
              INSERT INTO SlotIOT(NoMesin, Slot, Staff, Cabang, StokAkhir, Operator, TglEntry, Brg, SlotMerged, Aktif)
              SELECT m.NoMesin, d.Slot, '', m.Cabang, d.StokAkhir, :operator, GETDATE(), NULL, NULL, 1
              FROM MasterKejadianSlotIOT m, DetailKejadianSlotIOT d
              WHERE m.KodeNota=:kodenotaPoint4
              AND m.KodeNota=d.KodeNota 
              AND NOT EXISTS(SELECT * FROM SlotIOT s WHERE m.NoMesin=s.NoMesin AND d.Slot=s.Slot)

              UPDATE s
              SET s.StokAkhir=d.StokAkhir, s.Operator=:operator, s.TglEntry=GETDATE() 
              FROM MasterKejadianSlotIOT m, DetailKejadianSlotIOT d, SlotIOT s 
              WHERE m.KodeNota=:kodenotaPoint4
              AND m.KodeNota=d.KodeNota 
              AND m.NoMesin=s.NoMesin 
              AND d.Slot=s.Slot
              */

        //Cara 1
        //$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">New Qty added!</div>');
        /*
        $this->session->set_flashdata('message', [
            'icon' => 'success',
            'title' => 'Data Berhasil Masuk!',
            'text' => 'Data berhasil ditambahkan!',
        ]);
        */
        redirect('dashboard');
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

    public function formatDatabase($cabang)
    {
        $format = $cabang . "/01";

        return $format;
    }
}