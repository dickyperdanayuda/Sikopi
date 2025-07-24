<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		
		$this->load->model('Model_Stok', 'stok');
		$this->load->model('Model_Barang', 'barang');
		$this->load->model('Model_Gudang', 'gudang');
		$this->load->model('Model_Project', 'project');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$this->session->set_userdata("judul", "Data Stok");
		$ba = [
			'judul' => "Data Stok",
			'subjudul' => "Stok",
		];
		$project = $this->project->get_project();
		$barang = $this->barang->get_barang();
		$gudang = $this->barang->get_gudang();
		$d = [
			'project' => $project,
			'barang' => $barang,
			'gudang' => $gudang,
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('stok', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_stok()
	{
		$list = $this->stok->get_datatables();
		// var_dump($list);
		// exit();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $stok) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $stok->brg_nama;
			$row[] = $stok->stk_jml;
			$row[] = $stok->brg_satuan;
			$row[] = $stok->nama_gudang;
			$row[] = $stok->brg_jenis == 1 ? "Material Bangunan" : "Aset";
			$row[] = $stok->stk_kategori == 1 ? "Khusus" : "Umum";
			
			
			$row[] = "<a href='#' onClick='ubah_stok(" . $stok->id_stok . ")' class='btn btn-info btn-sm' title='Ubah data barang'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_stok(" . $stok->id_stok . ")' class='btn btn-danger btn-sm' title='Hapus data pengguna'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->stok->count_all(),
			"recordsFiltered" => $this->stok->count_filtered(),
			"data" => $data,
			"query" => $this->stok->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('id_stok');
		$data = $this->stok->cari_stok($id);
		// var_dump($data);
		// exit();
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('id_stok');
		$stk_id_brg = $this->input->post('stk_id_brg');
		
		$stk_id_prj = $this->input->post('stk_id_prj');
		$stk_jml = $this->input->post('stk_jml');
		$stk_kategori = $this->input->post('stk_kategori');
		$stk_id_gudang = $this->input->post('stk_id_gudang');
	
		$data = array(
					'stk_id_brg' => $stk_id_brg,
					'stk_id_prj' => $stk_id_prj,
					'stk_jml' => $stk_jml,
					'stk_kategori' => $stk_kategori,
					'stk_id_gudang' => $stk_id_gudang,
				);

		


		if ($id == 0) {
			$insert = $this->barang->simpan("stok", $data);	
		} else {
			$insert = $this->barang->update("stok", array('id_stok' => $id), $data);
			
		}
		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		
		if ($insert) {

			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menyimpan data";
		} else {
			// if($id==0){
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
			// } else{
			// 	$resp['status'] = 1;
			// $resp['desc'] = "Berhasil menyimpan data";
			// }
			
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->stok->delete('stok', 'id_stok', $id);

		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-check-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-danger'></i>&nbsp;&nbsp;&nbsp;Gagal menghapus data !";
		}
		echo json_encode($resp);
	}
}
