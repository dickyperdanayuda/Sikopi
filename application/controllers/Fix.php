<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fix extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		
		$this->load->library('session');
		$this->load->model('Model_Project', 'project');
		$this->load->model('Model_Barang', 'barang');
		$this->load->model('Model_Fix', 'fix');
		date_default_timezone_set('Asia/Jakarta');
	}
	public function index()
	{
		redirect(base_url("Fix/tampil"));
	}
	public function tampil()
	{
		$this->session->set_userdata("judul", "Data Pengajuan Fix");
		$ba = [
			'judul' => "Data Pengajuan Fix",
			'subjudul' => "Pengajuan Fix",
		];
		$project = $this->project->get_project();
		$barang = $this->barang->get_barang();
		$d = [
				'project' => $project,
				'barang' => $barang,
			];
		// var_dump($barang);
		// exit();
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('fix', $d);
		$this->load->view('background_bawah');
	}
	public function pindahPrint($id)
	{
		$this->session->set_userdata("judul", "Data Purchase Request");
		$ba = [
			'judul' => "Data Purchase Request",
			'subjudul' => "Purchase Request",
		];
		$project = $this->project->get_project();
		$barang = $this->barang->get_barang();
		$fix = $this->fix->get_pengajuan($id);
		$level = $this->session->userdata('level');
		$d = [
				'project' => $project,
				'barang' => $barang,
				'fix'=>$fix,
			'level'=>$level,
			];
		
		// var_dump($barang);
		// exit();
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('printpr', $d);
		$this->load->view('background_bawah');
	}


	public function ajax_list_fix()
	{
		$list = $this->fix->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $fix) {
			$no++;
			$row = array();
			$row[] = $no;
			$originalDate = $fix->pgjf_tgl;
			$row[] = date("d-m-Y", strtotime($originalDate));
			$row[] = $fix->pgjf_nama;
			if($fix->status_pgjf == 0){
			$row[] = "<i class='badge bg-warning'>Menunggu Purchasing</i>";	
			}elseif ($fix->status_pgjf == 1) {
			$row[] = "<i class='badge bg-success'>Sedang Purchase Request</i>";
			}elseif ($fix->status_pgjf == 2) {
			$row[] = "<i class='badge bg-warning'>Sedang Purchase Order</i>";
			}elseif ($fix->status_pgjf == 3) {
			$row[] = "<i class='badge bg-success'>Approval Direktur</i>";
			}elseif ($fix->status_pgjf == 4) {
			$row[] = "<i class='badge bg-warning'>Pending</i>";
			}elseif ($fix->status_pgjf == 5) {
			$row[] = "<i class='badge bg-danger'>Tolak</i>";
		}elseif ($fix->status_pgjf == 6) {
			$row[] = "<i class='badge bg-success'>Selesai</i>";
			}
			
			$row[] = "<a href='#' onClick='list_detail(" . $fix->pgjf_id . ")' data-target='#modal_list_detail' data-toggle='modal' class='btn btn-info btn-sm' title='Lihat data pengajuan'><i class='fa fa-list'></i></a>&nbsp;<a href='#' onClick='hapus_pengajuan(" . $fix->pgjf_id . ")' class='btn btn-danger btn-sm' title='Hapus data pengguna'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->fix->count_all(),
			"recordsFiltered" => $this->fix->count_filtered(),
			"data" => $data,
			"query" => $this->fix->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('pgjf_id');
		$data = $this->fix->get_pengajuan($id);
		// var_dump($data);
		// exit();
		echo json_encode($data);
	}

	public function list_detail($id)
	{
		$detail = $this->fix->get_listdetail($id);
		$barang = $this->barang->get_barang();
		$fix = $this->fix->get_pengajuan($id);
		$level = $this->session->userdata('level');
		$d = [
			'pengajuandetail' => $detail,
			'barang' => $barang,
			'fix'=>$fix,
			'level'=>$level,
		];
		// var_dump($detail);
		// exit();
		$this->load->helper('url');
		$this->load->view('listdetailfix', $d);
	}
	public function view_purchasedetail()
	{
		$jpjd = $this->input->post('jpjd');
		$d = [
			'list_purchasedetail' => $jpjd
		];
		// var_dump($d);
		// exit();
		$this->load->helper('url');
		// $this->load->view('vfixdetail');
		$this->load->view('vfixdetail', $d);
	}

	public function simpan()
	{
		$id = $this->input->post('prc_id');
		$prcd_id = $this->input->post('prcd_id');
		$prc_pgjf_id = $this->input->post('prc_pgjf_id');
		$prc_tgl = date('Y-m-d');
		$prc_nama = $this->input->post('prc_nama');
		$prc_status = 0;
		$prc_status_ket = "Barang Telah Di Purchase";
		
		
		$data = array(
			
			'prc_pgjf_id' => $prc_pgjf_id,
			'prc_tgl' => $prc_tgl,
			'prc_nama' => $prc_nama,
			'prc_status' => $prc_status,
			'prc_status_ket' => $prc_status_ket,
			
		);
		// var_dump($data);
		// exit();

			$insert = $this->fix->simpan("purchase", $data);
		
		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			
			$statussp = $this->fix->get_stat($prc_pgjf_id);
			$sp_id = $statussp->sp_id;
			// var_dump($sp_id);
			// exit();
			$status_pgjf = 2;

			$datstat = array(
				'status_pgjf' => $status_pgjf,
			);

			$upstat = $this->fix->update("status_pengajuan", array('sp_id' => $sp_id), $datstat);
			


			$det = explode(";", $prcd_id);
			
			for ($i = 1; $i < count($det); $i++) {
				$val = explode("-", $det[$i]);
				
				$detail = $this->fix->get_purchase_detail($insert, $val, 0);
			}
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
		// var_dump($id);
		// exit();
		$delete = $this->fix->delete('pengajuan_fix', 'pgjf_id', $id);

		if ($delete) {
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-check-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-danger'></i>&nbsp;&nbsp;&nbsp;Gagal menghapus data !";
		}
		echo json_encode($resp);
	}

		public function update_pr(){
		$id = $this->input->post('pgjf_id');
		$data = $this->fix->get_pengajuanf($id);
		$sp_id = $data->sp_id;
		$status_pgjf = 1;

		$data1 = array(
			'status_pgjf' => $status_pgjf,
		);
		
		
		$update = $this->fix->update("status_pengajuan", array('sp_id' => $sp_id), $data1);
		
		
		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}

		if ($update) {
			
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menyimpan data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}

		// var_dump($data);
		// exit();
		echo json_encode($resp);
	}

	public function approve_pr(){
		$id = $this->input->post('pgjf_id');
		$data = $this->fix->get_pengajuanf($id);
		$sp_id = $data->sp_id;
		$status_pgjf = 3;

		$data1 = array(
			'status_pgjf' => $status_pgjf,
		);
		
		
		$update = $this->fix->update("status_pengajuan", array('sp_id' => $sp_id), $data1);
		
		
		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}

		if ($update) {
			
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menyimpan data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}

		// var_dump($data);
		// exit();
		echo json_encode($resp);
	}
	public function pending_pr(){
		$id = $this->input->post('pgjf_id');
		$data = $this->fix->get_pengajuanf($id);
		$sp_id = $data->sp_id;
		$status_pgjf = 4;

		$data1 = array(
			'status_pgjf' => $status_pgjf,
		);
		
		
		$update = $this->fix->update("status_pengajuan", array('sp_id' => $sp_id), $data1);
		
		
		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}

		if ($update) {
			
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menyimpan data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}

		// var_dump($data);
		// exit();
		echo json_encode($resp);
	}
	public function tolak_pr(){
		$id = $this->input->post('pgjf_id');
		$data = $this->fix->get_pengajuanf($id);
		$sp_id = $data->sp_id;
		$status_pgjf = 5;

		$data1 = array(
			'status_pgjf' => $status_pgjf,
		);
		
		
		$update = $this->fix->update("status_pengajuan", array('sp_id' => $sp_id), $data1);
		
		
		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}

		if ($update) {
			
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menyimpan data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}

		// var_dump($data);
		// exit();
		echo json_encode($resp);
	}


	
}
