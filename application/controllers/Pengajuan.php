<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->userdata['id_user'])) {
			redirect(base_url("login"));
		}
		$this->load->library('upload');
		$this->load->model('Model_Pengajuan', 'pengajuan');
		$this->load->model('Model_Barang', 'barang');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		redirect(base_url("Pengajuan/tampil"));
	}

	public function tampil()
	{
		$ba = [
			'judul' => "Pengajuan",
			'subjudul' => "",
		];
		$barang = $this->barang->get_barang();
		$gudang = $this->pengajuan->get_gudang();
		$level = $this->session->userdata('level');
		$d = [
			'barang' => $barang,
			'gudang' => $gudang,
			];

		$this->load->view('background_atas', $ba);
		$this->load->view('pengajuan', $d);
		$this->load->view('background_bawah');
	}
	public function ajax_list_pengajuan()
	{
		$list = $this->pengajuan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pengajuan) {
			$no++;
			$row = array();
			$row[] = $no;
			$originalDate = $pengajuan->pgj_tgl;
			$row[] = date("d-m-Y", strtotime($originalDate));
			$row[] = $pengajuan->pgj_nama;
			if($pengajuan->pgj_status == 0){
				$row[] = "<i class='badge bg-warning'>Pending</i>";
			}elseif ($pengajuan->pgj_status == 1) {
			$row[] = "<i class='badge bg-warning'>Menunggu Proses</i>";
			}elseif ($pengajuan->pgj_status == 2) {
			$row[] = "<i class='badge bg-success'>Diterima</i>";
			}elseif ($pengajuan->pgj_status == 3) {
				$row[] = "<i class='badge bg-warning'>Menunggu Proses</i>";
			
			}elseif ($pengajuan->pgj_status == 4) {
			$row[] = "<i class='badge bg-danger'>Ditolak</i>";
			}

			
			$row[] = $pengajuan->pgj_status_ket;
			$row[] = "<a href='#' onClick='list_detail(" . $pengajuan->pgj_id . ")' data-target='#modal_list_detail' data-toggle='modal' class='btn btn-info btn-sm' title='Lihat data pengajuan'><i class='fa fa-list'></i></a>&nbsp;<a href='#' onClick='hapus_pengajuan(" . $pengajuan->pgj_id . ")' class='btn btn-danger btn-sm' title='Hapus data pengguna'><i class='fa fa-trash-alt'></i></a>";
			
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pengajuan->count_all(),
			"recordsFiltered" => $this->pengajuan->count_filtered(),
			"data" => $data,
			"query" => $this->pengajuan->getlastquery(),
		);
		echo json_encode($output);
	}

	public function cari()
	{
		$id = $this->input->post('pgj_id');
		$data = $this->pengajuan->get_pengajuan($id);
		// var_dump($data);
		// exit();
		echo json_encode($data);
	}
	public function carib()
	{
		$id = $this->input->post('pgjd_id');
		$data = $this->pengajuan->get_detailpgj($id);
		// var_dump($data);
		// exit();
		echo json_encode($data);
	}
	
	public function list_detail($id)
	{
		$detail = $this->pengajuan->get_listdetail($id);
		$pengajuan = $this->pengajuan->get_pengajuanf($id);
		// $detailfix = $this->pengajuan->get_fix($id);
		$level = $this->session->userdata('level');
		$d = [
			'pengajuandetail' => $detail,
			'pengajuan'=>$pengajuan,
			// 'detailfix'=>$detailfix,
			'level' => $level,
		];
		// var_dump($d);
		// exit();
		$this->load->helper('url');
		$this->load->view('listdetailpengajuan', $d);
	}

	public function view_pengajuandetail()
	{
		$jpjd = $this->input->post('jpjd');
		$d = [
			'list_pengajuandetail' => $jpjd
		];
		// var_dump($d);
		// exit();
		$this->load->helper('url');
		$this->load->view('vpengajuandetail', $d);
	}
	public function simpan()
	{
		$id = $this->input->post('pgj_id');
		$pgjd_id = $this->input->post('pgjd_id');
		$tgls = explode("/", $this->input->post('pgj_tgl'));
		$pgj_tgl = "{$tgls[2]}-{$tgls[1]}-{$tgls[0]}";
		$pgj_nama = $this->input->post('pgj_nama');
		$pgj_status_ket = $this->input->post('pgj_status_ket');
		$pgj_id_gudang = $this->input->post('pgj_id_gudang');
		
		
		$data = array(
			
			'pgj_tgl' => $pgj_tgl,
			'pgj_nama' => $pgj_nama,
			'pgj_status_ket' => $pgj_status_ket,
			'pgj_id_gudang' => $pgj_id_gudang,
			
		);
		if ($id == 0) {
			$insert = $this->pengajuan->simpan("pengajuan", $data);
		} else {
			$insert = $this->pengajuan->update("pengajuan", array('pgj_id' => $id), $data);
		}
		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}
		if ($insert) {
			
			$det = explode(";", $pgjd_id);
			for ($i = 1; $i < count($det); $i++) {
				$val = explode("-", $det[$i]);

				$detail = $this->pengajuan->get_pengajuan_detail($insert, $val, 0);
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
	public function update_fix(){
		$id = $this->input->post('pgj_id');
		$data = $this->pengajuan->get_pengajuanf($id);

		$pgj_nama = $data->pgj_nama;
		$pgj_tgl = $data->pgj_tgl;
		$pgj_status = 1;
		$pgj_status_ket = "Diterima oleh pengelola";
		$pgj_id_gudang = $data->pgj_id_gudang;
		$data1 = array(
			'pgj_nama' => $pgj_nama,
			'pgj_tgl' => $pgj_tgl,
			'pgj_status' => $pgj_status,
			'pgj_status_ket' => $pgj_status_ket,
			'pgj_id_gudang' => $pgj_id_gudang,
		);
		
		
		$update = $this->pengajuan->update("pengajuan", array('pgj_id' => $id), $data1);
		
		
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
	public function pending_pengajuan(){
		$id = $this->input->post('pgj_id');
		$data = $this->pengajuan->get_pengajuanf($id);

		$pgj_status = 0;
		$pgj_status_ket = "Pengajuan di Pending";
		$data1 = array(
			
			'pgj_status' => $pgj_status,
			'pgj_status_ket' => $pgj_status_ket,
		);
		
		
		$update = $this->pengajuan->update("pengajuan", array('pgj_id' => $id), $data1);
		
		
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
	public function simpan_fix(){
		$id = $this->input->post('pgj_id');
		$prc_nama_toko = $this->input->post('prc_nama_toko');
		$prc_no_faktur = $this->input->post('prc_no_faktur');
		$prc_foto = $this->input->post('prc_foto');

		$data = $this->pengajuan->get_pengajuanf($id);

		$pgj_nama = $data->pgj_nama;
		$pgj_id = $data->pgj_id;
		$pgj_tgl = $data->pgj_tgl;
		$pgj_status = 2;
		$pgj_status1 = 1;
		$pgj_status_ket = "Selesai";
		$prc_sumber = "Pengajuan";



		if (!empty($_FILES['prc_foto']['name'])) {
			$filename = $_FILES['prc_foto']['name'];
			$arrName = explode(".", $filename);
			$idxName = count($arrName);
			$ext = $arrName[$idxName - 1];
			$config['upload_path'] = 'assets/images/faktur/'; //path folder
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|webp'; //type yang dapat diakses bisa anda sesuaikan
			$config['encrypt_name'] = FALSE; //Enkripsi nama yang terupload
			$config['overwrite'] = TRUE; //Enkripsi nama yang terupload
			$config['file_name'] = $prc_nama_toko . "." . $ext; //ganti nama file
			$this->upload->initialize($config);
		}
		if (!is_dir('assets/images/faktur')) {
			mkdir('assets/images/faktur', 0777, TRUE);
			mkdir('assets/images/faktur/thumbs', 0777, TRUE);
		}
		if (!empty($_FILES['prc_foto']['name'])) {
			if ($this->upload->do_upload('prc_foto')) {
				$gbr = $this->upload->data();
			// 	//Compress Image
			// 	$config['image_library'] = 'gd2';
			// 	$config['source_image'] = 'assets/images/request/' . $gbr['file_name'];
			// 	$config['create_thumb'] = FALSE;
			// 	$config['maintain_ratio'] = FALSE;
			// 	$config['quality'] = '50%';
			// 	$config['width'] = 150;
			// 	$config['height'] = 150;
			// 	$config['new_image'] = 'assets/images/request/thumbs/' . $gbr['file_name'];
			// 	$this->load->library('image_lib', $config);
			// 	$this->image_lib->resize();
				$foto = $gbr['file_name'];

			}

			$data = array(
			'prc_nama' => $pgj_nama,
			'prc_tgl' => $pgj_tgl,
			'prc_status' => $pgj_status1,
			'prc_status_ket' => $pgj_status_ket,
			'prc_id_pgj' => $pgj_id,
			'prc_nama_toko' => $prc_nama_toko,
			'prc_no_faktur' => $prc_no_faktur,
			'prc_sumber' => $prc_sumber,
			'prc_foto' => $foto,
			);
		}
		else{
			$data = array(
			'prc_nama' => $pgj_nama,
			'prc_tgl' => $pgj_tgl,
			'prc_status' => $pgj_status1,
			'prc_status_ket' => $pgj_status_ket,
			'prc_id_pgj' => $pgj_id,
			'prc_nama_toko' => $prc_nama_toko,
			'prc_no_faktur' => $prc_no_faktur,
			'prc_sumber' => $prc_sumber,
			);

		}
		// var_dump($gbr);
		// exit();


		$data1 = array(
			'pgj_nama' => $pgj_nama,
			'pgj_tgl' => $pgj_tgl,
			'pgj_status' => $pgj_status,
			'pgj_status_ket' => $pgj_status_ket,
		);

		
		// var_dump($data);
		// 		exit();
		$update = $this->pengajuan->update("pengajuan", array('pgj_id' => $id), $data1);
		$insert = $this->pengajuan->simpan("purchase", $data);
		
		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}

		if ($insert) {
			$rqd = $this->pengajuan->get_pengajuanf_detail($id);

			$sp_id_pgjf = $insert;
			$status_pgjf = 6;
			$data2 = array(
				'sp_id_pgjf' => $sp_id_pgjf,
				'status_pgjf' => $status_pgjf,
			);
			$sp = $this->pengajuan->simpan("status_pengajuan", $data2);
			
			for ($i = 0; $i < count($rqd); $i++) {
				
				
				$prcd_prc_id = $insert;
				$prcd_brg_id = $rqd[$i]->pgjd_brg_id;
				$prcd_jml = $rqd[$i]->pgjd_jml;
				// $pgjd_satuan = $rqd[$i]->rqd_satuan;
				$prcd_harga_satuan = $rqd[$i]->pgjd_harga_satuan;
				$prcd_hrg_brg = $rqd[$i]->pgjd_hrg_brg;
				$pgjg_id = $id;
				$dt = array(
					'prcd_prc_id' => $prcd_prc_id,
					'prcd_brg_id' => $prcd_brg_id,
					'prcd_jml' => $prcd_jml,
					// 'pgjd_satuan' => $pgjd_satuan,
					'prcd_harga_satuan' => $prcd_harga_satuan,
					'prcd_hrg_brg' => $prcd_hrg_brg,
					// 'pgjg_id' => $id
				);

				$this->pengajuan->simpanp('purchase_detail', $dt);

				$stk_id_brg = $prcd_brg_id;
				$stk_id_prj = $rqd[$i]->pgj_id_prj;
				$stk_jml = $prcd_jml;
				$stk_kategori = 2;
				$stk_id_gudang = $rqd[$i]->pgj_id_gudang;

				$dbm = array(
					'stk_id_brg' => $stk_id_brg,
					'stk_id_prj' => $stk_id_prj,
					'stk_jml' => $stk_jml,
					'stk_kategori' => $stk_kategori,
					'stk_id_gudang' => $stk_id_gudang,

				);

				$this->pengajuan->simpanp('stok', $dbm);

				
			}
			// var_dump($dt);
			// 	exit();
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

	public function tolak_pengajuan(){
		$id = $this->input->post('pgj_id');
		$data = $this->pengajuan->get_pengajuanf($id);

		$pgj_nama = $data->pgj_nama;
		$pgj_tgl = $data->pgj_tgl;
		$pgj_status = 4;
		$pgj_status_ket = "Ditolak oleh pengelola";
		$data = array(
			'pgj_nama' => $pgj_nama,
			'pgj_tgl' => $pgj_tgl,
			'pgj_status' => $pgj_status,
			'pgj_status_ket' => $pgj_status_ket,
		);
		
		// var_dump($data);
		// 		exit();
		$update = $this->pengajuan->update("pengajuan", array('pgj_id' => $id), $data);
		
		$error = $this->db->error();
		if (!empty($error)) {
			$err = $error['message'];
		} else {
			$err = "";
		}

		if ($update) {
			// var_dump($dt);
			// 	exit();
			$resp['status'] = 1;
			$resp['desc'] = "Berhasil menolak pengajuan";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "Ada kesalahan dalam penyimpanan!";
			$resp['error'] = $err;
		}

		// var_dump($data);
		// exit();
		echo json_encode($resp);
	}

	public function hapus($id)
	{
		$delete = $this->pengajuan->delete('pengajuan', 'pgj_id', $id);

		if ($delete) {
			$detail = $this->pengajuan->get_detail_pengajuan($id);

			foreach($detail as $det){
				$this->pengajuan->delete('pengajuan_detail', 'pgjd_id', $det->pgjd_id);
			}
			$resp['status'] = 1;
			$resp['desc'] = "<i class='fa fa-check-circle text-success'></i>&nbsp;&nbsp;&nbsp; Berhasil menghapus data";
		} else {
			$resp['status'] = 0;
			$resp['desc'] = "<i class='fa fa-exclamation-circle text-danger'></i>&nbsp;&nbsp;&nbsp;Gagal menghapus data !";
		}
		echo json_encode($resp);
	}

	public function ubahpgjd(){
		$id = $this->input->post('pgjd_id');
		$pgjd_jml = $this->input->post('pgjd_jml');
		$pgjd_harga_satuan = $this->input->post('pgjd_harga_satuan');
		$total = $pgjd_jml*$pgjd_harga_satuan;

		$data = array(
			
			'pgjd_jml' => $pgjd_jml,
			'pgjd_harga_satuan' => $pgjd_harga_satuan,
			'pgjd_hrg_brg' => $total,
			
		);

		if ($id == 0) {
			$insert = $this->pengajuan->simpan("pengajuan_detail", $data);
		} else {
			$insert = $this->pengajuan->update("pengajuan_detail", array('pgjd_id' => $id), $data);
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
	public function hapusp($id)
	{
		// var_dump($id);
		// exit();
		$delete = $this->pengajuan->delete('pengajuan_detail', 'pgjd_id', $id);

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
