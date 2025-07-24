<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		
		$this->load->model('Model_Barang', 'barang');
		$this->load->model('Model_Project', 'project');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$this->session->set_userdata("judul", "Data Barang");
		$ba = [
			'judul' => "Data Barang",
			'subjudul' => "Barang",
		];
		// $project = $this->project->get_project();
		// $stok = $this->barang->get_stok();
		// $gudang = $this->barang->get_gudang();
		$d = [
			// 'project' => $project,
			// 'stok' => $stok,
			// 'gudang' => $gudang,
		];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('barang', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_barang()
	{
		$list = $this->barang->get_datatables();
		// var_dump($list);
		// exit();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $barang) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $barang->brg_nama;
			$row[] = $barang->brg_satuan;
			$row[] = $barang->brg_jenis == 1 ? "Material Bangunan" : "Aset";
			$row[] = number_format($barang->brg_hrg_pasaran,0);
			// $row[] = $barang->stk_jml;
			// $row[] = $barang->stk_kategori == 1 ? "Khusus" : "Umum";
			// $row[] = $barang->nama_gudang;
			
			
			$row[] = "<a href='#' onClick='ubah_barang(" . $barang->brg_id . ")' class='btn btn-info btn-sm' title='Ubah data barang'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_barang(" . $barang->brg_id . ")' class='btn btn-danger btn-sm' title='Hapus data pengguna'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->barang->count_all(),
			"recordsFiltered" => $this->barang->count_filtered(),
			"data" => $data,
			"query" => $this->barang->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('brg_id');
		$data = $this->barang->cari_barang($id);
		// var_dump($data);
		// exit();
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('brg_id');
		$brg_nama = $this->input->post('brg_nama');
		$brg_satuan = $this->input->post('brg_satuan');
		$brg_jenis = $this->input->post('brg_jenis');
		$brg_hrg_pasaran = $this->input->post('brg_hrg_pasaran');

		// $id_stok = $this->input->post('id_stok');
		// 			$stk_id_prj = $this->input->post('stk_id_prj');
		// 			$stk_jml = $this->input->post('stk_jml');
		// 			$stk_kategori = $this->input->post('stk_kategori');
		// 			$stk_id_gudang = $this->input->post('stk_id_gudang');
	
		$data = array(
			'brg_nama' => $brg_nama,
			'brg_satuan' => $brg_satuan,
			'brg_jenis' => $brg_jenis,
			'brg_hrg_pasaran' => $brg_hrg_pasaran,
		);

		


		if ($id == 0) {
			$insert = $this->barang->simpan("barang", $data);
			// if($insert){
				// $data1 = array(
				// 	'stk_id_brg' => $insert,
				// 	'stk_id_prj' => $stk_id_prj,
				// 	'stk_jml' => $stk_jml,
				// 	'stk_kategori' => $stk_kategori,
				// 	'stk_id_gudang' => $stk_id_gudang,
				// );
				//  $this->barang->simpan("stok", $data1);

			// }
			
		} else {
			$insert = $this->barang->update("barang", array('brg_id' => $id), $data);
			// $data1 = array(
			// 		'stk_id_brg' => $id,
			// 		'stk_id_prj' => $stk_id_prj,
			// 		'stk_jml' => $stk_jml,
			// 		'stk_kategori' => $stk_kategori,
			// 		'stk_id_gudang' => $stk_id_gudang,
			// 	);
			// $insert2 = $this->barang->update("stok", array('id_stok' => $id_stok), $data1);
			// if($insert){

			// }
			
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
		$delete = $this->barang->delete('barang', 'brg_id', $id);

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
