<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaporanStok extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		
		$this->load->model('Model_LaporanStok', 'laporanstok');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$this->session->set_userdata("judul", "Data Barang");
		$ba = [
			'judul' => "Data laporan stok",
			'subjudul' => "laporan stok",
		];
		$gudang = $this->laporanstok->get_gudang();
		$d = [
			'gudang' => $gudang,
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('laporanstok', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_laporanstok($gudg)
	{
		
		$list = $this->laporanstok->get_datatables($gudg);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $laporanstok) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $laporanstok->brg_nama;
			$row[] = $laporanstok->stk_jml;
			$row[] = $laporanstok->brg_satuan;
			if($laporanstok->stk_kategori == 1){
				$row[] = $laporanstok->stk_kategori == 1 ? "Khusus" : "Umum";
				$row[] = $laporanstok->nama_project;
			}else{
				$row[] = $laporanstok->stk_kategori == 1 ? "Khusus" : "Umum";
				$row[] = "Untuk Umum";
			}
			$row[] = $laporanstok->brg_jenis == 1 ? "Material Bangunan" : "Aset";
			
			// $row[] = "<a href='#' onClick='ubah_barang(" . $laporanstok->brg_id . ")' class='btn btn-info btn-sm' title='Detail data barang'><i class='fa fa-list'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->laporanstok->count_all($gudg),
			"recordsFiltered" => $this->laporanstok->count_filtered($gudg),
			"data" => $data,
			"query" => $this->laporanstok->getlastquery($gudg),
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
	public function cetak_stok($gdg)
	{
		$data = $this->laporanstok->get_stokgdg($gdg);
		$d = [
		'stokbarang' => $data,
		];
		// var_dump($d);
		// exit();
		$this->load->view("cetakstok",$d);
	}



}
