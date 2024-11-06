<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
        /*
        $arrayVM = [
            ['id' => 1, 'vendingMachine' => 'Wapo 1', 'cabang' => 'Surabaya', 'stok' => '10', 'sisa_stok' => '5'],
            ['id' => 2, 'vendingMachine' => 'Wapo 2', 'cabang' => 'Jakarta', 'stok' => '20', 'sisa_stok' => '10'],
            ['id' => 3, 'vendingMachine' => 'Wapo 3', 'cabang' => 'Malang', 'stok' => '30', 'sisa_stok' => '15'],
        ];
        */

		$this->load->view('dashboard');
	}
}