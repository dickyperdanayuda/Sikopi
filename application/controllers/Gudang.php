<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gudang extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		
		$this->load->model('Model_Gudang', 'gudang');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function tampil()
	{
		$this->session->set_userdata("judul", "Data Gudang");
		$ba = [
			'judul' => "Data Gudang",
			'subjudul' => "Gudang",
		];
		$d = [];
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('gudang', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_gudang()
	{
		$list = $this->gudang->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $gudang) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $gudang->nama_gudang;
			$row[] = $gudang->alamat_gudang;
			
			$row[] = "<a href='#' onClick='ubah_gudang(" . $gudang->id_gudang . ")' class='btn btn-info btn-sm' title='Ubah data gudang'><i class='fa fa-edit'></i></a>&nbsp;<a href='#' onClick='hapus_gudang(" . $gudang->id_gudang . ")' class='btn btn-danger btn-sm' title='Hapus data gudang'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->gudang->count_all(),
			"recordsFiltered" => $this->gudang->count_filtered(),
			"data" => $data,
			"query" => $this->gudang->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('id_gudang');
		$data = $this->gudang->cari_gudang($id);
		echo json_encode($data);
	}

	public function simpan()
	{
		$id = $this->input->post('id_gudang');
		
		
		$nama_gudang = $this->input->post('nama_gudang');
		$alamat_gudang = $this->input->post('alamat_gudang');

		$data = array(
			'nama_gudang' => $nama_gudang,
			'alamat_gudang' => $alamat_gudang,
		);

		if ($id == 0) {
			

			$insert = $this->gudang->simpan("gudang", $data);
		} else {

			$insert = $this->gudang->update("gudang", array('id_gudang' => $id), $data);
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
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->gudang->delete('gudang', 'id_gudang', $id);

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
