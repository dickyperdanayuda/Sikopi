<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BarangMasuk extends CI_Controller
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
		$this->load->model('Model_Barang_Masuk', 'barangmasuk');
		date_default_timezone_set('Asia/Jakarta');
	}
	public function index()
	{
		redirect(base_url("BarangMasuk/tampil"));
	}
	public function tampil()
	{
		$this->session->set_userdata("judul", "Data Pengajuan Fix");
		$ba = [
			'judul' => "Data Penerimaan Barang",
			'subjudul' => "Barang Masuk",
		];
		$project = $this->project->get_project();
		$barang = $this->barang->get_barang();
		$gudang = $this->barangmasuk->get_gudang();
		$level = $this->session->userdata('level');
		$d = [
				'project' => $project,
				'barang' => $barang,
				'gudang' => $gudang,
				'level' => $level,
			];
		// var_dump($barang);
		// exit();
		$this->load->helper('url');
		$this->load->view('background_atas', $ba);
		$this->load->view('barangmasuk', $d);
		$this->load->view('background_bawah');
	}

	public function ajax_list_barang()
	{
		$list = $this->barangmasuk->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $barangmasuk) {
			$no++;
			$row = array();
			$row[] = $no;
			$originalDate = $barangmasuk->prc_tgl;
			$row[] = date("d-m-Y", strtotime($originalDate));
			$row[] = $barangmasuk->prc_nama;
			if($barangmasuk->prc_status == 0){
			$row[] = "<i class='badge bg-warning'>Menunggu Proses</i>";	
			}elseif ($barangmasuk->prc_status == 1) {
			$row[] = "<i class='badge bg-success'>Diterima</i>";
			}elseif ($barangmasuk->prc_status == 2) {
			$row[] = "<i class='badge bg-danger'>Ditolak</i>";
			}elseif ($barangmasuk->prc_status == 3) {
			$row[] = "<i class='badge bg-success'>Donasi</i>";
			}
			
			$row[] = $barangmasuk->prc_status_ket;
			
			$row[] = "<a href='#' onClick='list_detail(" . $barangmasuk->prc_id . ")' data-target='#modal_list_detail' data-toggle='modal' class='btn btn-info btn-sm' title='Lihat data pengajuan'><i class='fa fa-list'></i></a>&nbsp;<a href='#' onClick='hapus_pengajuan(" . $barangmasuk->prc_id . ")' class='btn btn-danger btn-sm' title='Hapus data pengguna'><i class='fa fa-trash-alt'></i></a>";
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->barangmasuk->count_all(),
			"recordsFiltered" => $this->barangmasuk->count_filtered(),
			"data" => $data,
			"query" => $this->barangmasuk->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('prc_id');
		$data = $this->barangmasuk->get_barangmasuk($id);
		
		echo json_encode($data);
	}

	public function list_detail($id)
	{
		$detail = $this->barangmasuk->get_listdetail($id);
		$barang = $this->barang->get_barang();
		$barangmasuk = $this->barangmasuk->get_barangmasuk($id);
		$level = $this->session->userdata('level');
		// $test = $this->barangmasuk->cari_barangmasuk($id);
		// print_r($test);
		// exit();
		// $level = $this->session->userdata('log_level');
		$d = [
			'barangdetail' => $detail,
			'barang' => $barang,
			'barangmasuk'=>$barangmasuk,
			'level' => $level,
		];
		// var_dump($barangmasuk);
		// exit();
		$this->load->helper('url');
		$this->load->view('listdetailbarang', $d);
	}
	public function view_brgmasukdetail()
	{
		$jpjd = $this->input->post('jpjd_1');
		$d = [
			'list_brgmasukdetail' => $jpjd
		];
		// var_dump($d);
		// exit();
		$this->load->helper('url');
		$this->load->view('vbrgmasukdetail', $d);
	}
	public function view_brgdetail()
	{
		$jpjd = $this->input->post('jpjd');
		$d = [
			'list_barangdetail' => $jpjd
		];
		// var_dump($d);
		// exit();
		$this->load->helper('url');
		$this->load->view('vbarangdetail', $d);
	}

	public function simpanBm()
	{
		$id = $this->input->post('prc_id_1');
		$prcd_id = $this->input->post('prcd_id_1');
		// var_dump($prcd_id);
		// exit();
		$tgls = explode("/", $this->input->post('prc_tgl_1'));

		$prc_tgl = "{$tgls[2]}-{$tgls[1]}-{$tgls[0]}";
		$prc_nama = $this->input->post('prc_nama_1');
		$prc_status = 3;
		$prc_status_ket = "Telah Diterima";
		$prc_sumber = $this->input->post('prc_sumber');

		$stk_kategori = $this->input->post('stk_kategori_1');
		$stk_id_prj = $this->input->post('stk_id_prj_1');
		$stk_id_gudang = $this->input->post('stk_id_gudang_1');
		
		$data = array(
			
			'prc_tgl' => $prc_tgl,
			'prc_nama' => $prc_nama,
			'prc_status' => $prc_status,
			'prc_status_ket' => $prc_status_ket,
			'prc_sumber' => $prc_sumber,
			
		);
		// var_dump($stk_kategori);
		// exit();

		$insert = $this->barangmasuk->simpan("purchase", $data);
		
		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {

			$sp_id_pgjf = $insert;
			$status_pgjf = 7;
			$data2 = array(
				'sp_id_pgjf' => $sp_id_pgjf,
				'status_pgjf' => $status_pgjf,
			);
			$sp = $this->barangmasuk->simpan("status_pengajuan", $data2);


			$det = explode(";", $prcd_id);
			// var_dump($det);
			// exit();
			
			for ($i = 1; $i < count($det); $i++) {
				$val = explode("-", $det[$i]);
				$jb = $this->barangmasuk->cari_jmlbrg($val[0]);

				$jml = $jb->stk_jml + $val[1];
				$stk_id_brg = $val[0];
						
				$d = [
					'stk_jml' => $jml,
					'stk_id_brg' => $stk_id_brg,
					'stk_id_prj' => $stk_id_prj,
					'stk_kategori' => $stk_kategori,
					'stk_id_gudang' => $stk_id_gudang,
					
				];
				$stk = $this->barangmasuk->simpan('stok', $d);
				
				$detail = $this->barangmasuk->get_barang_detailBm($insert, $val, 0);
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

	public function simpan()
	{
		$id = $this->input->post('prc_id');
		$prcd_id = $this->input->post('prcd_id');
		$prc_pgjf_id = $this->input->post('prc_pgjf_id');
		$prc_tgl = date('Y-m-d');
		$prc_nama = $this->input->post('prc_nama');
		$prc_status = 1;
		$prc_status_ket = "Diterima Gudang";
		
		
		$data = array(
			
			'prc_pgjf_id' => $prc_pgjf_id,
			'prc_tgl' => $prc_tgl,
			'prc_nama' => $prc_nama,
			'prc_status' => $prc_status,
			'prc_status_ket' => $prc_status_ket,
			
		);
		// var_dump($id);
		// exit();

		$insert = $this->barangmasuk->update("purchase", array('prc_id' => $id), $data);
		
		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			
			$statussp = $this->barangmasuk->get_stat($prc_pgjf_id);
			$sp_id = $statussp->sp_id;
			// var_dump($sp_id);
			// exit();
			$status_pgjf = 6;

			$datstat = array(
				'status_pgjf' => $status_pgjf,
			);

			$upstat = $this->barangmasuk->update("status_pengajuan", array('sp_id' => $sp_id), $datstat);

			$det = explode(";", $prcd_id);
			
			for ($i = 1; $i < count($det); $i++) {
				$val = explode("-", $det[$i]);
				// var_dump($val);
				// exit();			
				
				$detail = $this->barangmasuk->get_barang_detail($id, $val, 0);
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
		$delete = $this->barangmasuk->delete('purchase', 'prc_id', $id);

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
