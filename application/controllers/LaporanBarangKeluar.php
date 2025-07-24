<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaporanBarangKeluar extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		
		$this->load->model('Model_LaporanBarangKeluar', 'laporanbarangkeluar');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$this->session->set_userdata("judul", "Data Barang");
		$ba = [
			'judul' => "Data laporan barang keluar",
			'subjudul' => "laporan barang keluar",
		];
		// $gudang = $this->laporanbarang->get_gudang();
		$d = [
			// 'gudang' => $gudang,
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('laporanbarangkeluar', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_laporanbarangkeluar()
	{
		
		$list = $this->laporanbarangkeluar->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $laporanbarangkeluar) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $laporanbarangkeluar->brg_nama;
			$row[] = $laporanbarangkeluar->rqd_jml;
			$row[] = $laporanbarangkeluar->brg_satuan;
			$row[] = $laporanbarangkeluar->rq_nama;
			$row[] = $laporanbarangkeluar->nama_project;
			
			
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->laporanbarangkeluar->count_all(),
			"recordsFiltered" => $this->laporanbarangkeluar->count_filtered(),
			"data" => $data,
			"query" => $this->laporanbarangkeluar->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('brg_id');
		$data = $this->laporanstok->cari_barang($id);
		// var_dump($data);
		// exit();
		echo json_encode($data);
	}
	public function cetak()
	{
		$data = $this->laporanbarangkeluar->get_barangkeluar();
		$d = [
		'barangkeluar' => $data,
		];
		// var_dump($d);
		// exit();
		$this->load->view("cetakbrgkeluar",$d);
	}



}
