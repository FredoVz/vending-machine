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
        if (!$this->session->userdata('logged_in')) {
            redirect('login'); // Redirect to login page if not logged in
        }
    }

	public function index()
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

		if($isApproved == 1) {
			echo "<pre>===Is Approved===</pre>";

			$queryInsertMasters = "insert INTO MasterKejadianSlotIOT(KodeNota, Tgl, NoMesin, Keterangan, CreateBy, CreateDate, Operator, TglEntry, IsApproved, ApprovedBy, ApprovedDate, Cabang)
			SELECT KodeNota, CAST(FLOOR(CAST(GETDATE() AS FLOAT)) AS DATETIME), '" . $noMesin . "', '', '" . $createBy . "', GETDATE(), '" . $operator . "', GETDATE(), $isApproved, '" . $approvedBy . "', GETDATE(), '" . $cabang . "'
			FROM #LastKodeNotaSlotIOT";

			echo $queryInsertMasters;
		}

		else if($isApproved == 0){
			echo "<pre>===No Approved===</pre>";

			$queryInsertMasters1 = "insert INTO MasterKejadianSlotIOT(KodeNota, Tgl, NoMesin, Keterangan, CreateBy, CreateDate, Operator, TglEntry, IsApproved, ApprovedBy, ApprovedDate, Cabang)
			SELECT KodeNota, CAST(FLOOR(CAST(GETDATE() AS FLOAT)) AS DATETIME), '" . $noMesin . "', '', '" . $createBy . "', GETDATE(), '" . $operator . "', GETDATE(), $isApproved, NULL, NULL, '" . $cabang . "'
			FROM #LastKodeNotaSlotIOT";
	
			echo $queryInsertMasters1;
		}

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
                SELECT KodeNota, '".$slot."', '".$stok_akhir."', 0 FROM #LastKodeNotaSlotIOT;<br>";

				//echo "<pre>";
				//echo "Qty: " . $qty;
				//echo "</pre>";

				echo $query;
			}
		}

		if($isApproved == 1) {
			echo "<pre>===Approved===</pre>";

			$queryInsertIsApproved = "insert INTO SlotIOT(NoMesin, Slot, Staff, Cabang, StokAkhir, Operator, TglEntry, Brg, SlotMerged, Aktif)
			SELECT m.NoMesin, d.Slot, '', m.Cabang, d.StokAkhir, '" . $operator . "', GETDATE(), NULL, NULL, 1
			FROM MasterKejadianSlotIOT m, DetailKejadianSlotIOT d
			WHERE m.KodeNota=:kodenotaPoint4
			AND m.KodeNota=d.KodeNota 
			AND NOT EXISTS(SELECT * FROM SlotIOT s WHERE m.NoMesin=s.NoMesin AND d.Slot=s.Slot)";
			echo $queryInsertIsApproved;
	
			$queryUpdateIsApproved = "update s
			SET s.StokAkhir=d.StokAkhir, s.Operator='" . $operator . "', s.TglEntry=GETDATE() 
			FROM MasterKejadianSlotIOT m, DetailKejadianSlotIOT d, SlotIOT s 
			WHERE m.KodeNota=:kodenotaPoint4
			AND m.KodeNota=d.KodeNota 
			AND m.NoMesin=s.NoMesin 
			AND d.Slot=s.Slot";
			echo $queryUpdateIsApproved;
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

		//echo $qty;

		//Cara 1
		/*
		die;

		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">New Qty added!</div>');
		redirect('dashboard');
		*/

		//Cara 2
		/*
		$data['noMesin'] = $noMesin;
		$data['namaStaff'] = $namaStaff;
		$data['namaCabang'] = $namaCabang;
		$data['cabang'] = $cabang;
		$data['isApproved'] = $isApproved;
		$data['createBy'] = $createBy;
		$data['operator'] = $operator;
		$data['approvedBy'] = $approvedBy;
		$data['details'] = $details;
		$data['query'] = $query;
		*/
		//echo $query;
		//$this->load->view('detail', $data);
	}

	public function formatDatabase($cabang){
        $format = $cabang . "/01";

        return $format;
    }
}
