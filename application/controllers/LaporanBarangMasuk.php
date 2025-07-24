<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaporanBarangMasuk extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		
		$this->load->model('Model_LaporanBarangMasuk', 'laporanbarangmasuk');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$this->session->set_userdata("judul", "Data Barang");
		$ba = [
			'judul' => "Data laporan barang masuk",
			'subjudul' => "laporan barang masuk",
		];
		// $gudang = $this->laporanbarang->get_gudang();
		$d = [
			// 'gudang' => $gudang,
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('laporanbarangmasuk', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_laporanbarangmasuk()
	{
		
		$list = $this->laporanbarangmasuk->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $laporanbarangmasuk) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $laporanbarangmasuk->brg_nama;
			$row[] = $laporanbarangmasuk->prcd_jml;
			$row[] = $laporanbarangmasuk->brg_satuan;
			$row[] = $laporanbarangmasuk->prcd_harga_satuan;
			$row[] = $laporanbarangmasuk->prc_nama;
			$row[] = $laporanbarangmasuk->nama_project;
			$row[] = $laporanbarangmasuk->status_pgjf == 7 ? "Donatur" : "Pengajuan";
			
			
			
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->laporanbarangmasuk->count_all(),
			"recordsFiltered" => $this->laporanbarangmasuk->count_filtered(),
			"data" => $data,
			"query" => $this->laporanbarangmasuk->getlastquery(),
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
		$data = $this->laporanbarangmasuk->get_barangmasuk();
		$d = [
		'barangmasuk' => $data,
		];
		// var_dump($d);
		// exit();
		$this->load->view("cetakbrgmasuk",$d);
	}



}
