<?php
class Model_Barang_Masuk extends CI_Model
{
	var $table = 'purchase';
	var $column_order = array('prc_id','prc_tgl', 'prc_nama','prc_status', 'prc_status_ket'); //set column field database for datatable orderable
	var $column_search = array('prc_id','prc_tgl', 'prc_nama','prc_status', 'prc_status_ket'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('prc_tgl' => 'asc'); // default order  	private $db_sts;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->from($this->table);
		// $this->db->where('log_level > 1');
		$i = 0;

		foreach ($this->column_search as $item) // loop column 
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			foreach ($this->order as $key => $order) {
				$this->db->order_by($key, $order);
			}
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);

		return $this->db->count_all_results();
	}
	public function get_gudang()
	{
		$this->db->from("gudang");
		$query = $this->db->get();

		return $query->result();
	}

	public function get_barangmasuk($id)
	{
		$this->db->from("purchase");
		$this->db->join("status_pengajuan", "prc_id = sp_id_pgjf", "left");
		$this->db->where("prc_id", $id);
		$query = $this->db->get();

		return $query->row();
	}
	public function get_barang_detail($id, $val, $n)
	{
		
		$barangmasuk = $this->cari_barangmasuk($id);
		$jb = $this->cari_jmlbrg($val[0]);


		$jml = $jb->stk_jml + $val[1];
		$id_gudang = $barangmasuk->pgj_id_gudang;
		

		
		$d = [
			'stk_jml' => $jml,
			// 'stk_id_prj' => $stk_id_prj,
			// 'stk_kategori' => $stk_kategori,
			// 'stk_id_gudang' => $id_gudang,
		];
		// var_dump($val[0]);
		// exit();

		

		$this->update('stok',array('id_stok' => $jb->id_stok, 'stk_id_gudang' => $jb->stk_id_gudang), $d);
		
	}
	public function get_barang_detailBm($id, $val, $n)
	{
		
		$barangmasuk = $this->cari_barangmasuk($val[0]);

		$jb = $this->cari_jmlbrg($val[0]);

		// var_dump($jb);
		// exit();
		
		// $this->update('stok',array('id_stok' => $jb->id_stok), $d);

		$d2 = [
			'prcd_prc_id' => $id,
			'prcd_brg_id' => $val[0],
			'prcd_jml' => $val[1],
			'prcd_harga_satuan' => $val[2],
			'prcd_hrg_brg' => $val[3],
		];
		
		$this->simpan('purchase_detail', $d2);
		
	}
	public function cari_jmlbrg($id){
		$this->db->from("stok");
		$this->db->join("barang", "brg_id = stk_id_brg", "left");
		$this->db->where("stk_id_brg", $id);
		// $this->db->where("stk_id_prj", 0);
		$query = $this->db->get();

		return $query->row();

	}
	public function cari_jmlbrgBm($id){
		$this->db->from("barang");
		$this->db->join("stok", "stk_id_brg = brg_id", "left");
		$this->db->where("brg_id", $id);
		// $this->db->where("stk_id_prj", $prj);
		$query = $this->db->get();

		return $query->row();

	}
	public function get_pengajuanf_detail($id)
	{
		
		$this->db->from("pengajuan_detail");
		$this->db->join("pengajuan", "pgjfd_pgj_id = pgjf_id", "left");
		$this->db->join("barang", "pgjfd_brg_id = brg_id", "left");
		// $this->db->join("pengajuan_detail", "pgjfd_pgjf_id = rq_id", "left");
		$this->db->where("pgjfd_pgjf_id", $id);
		$query = $this->db->get();

		return $query->row();
		
	}
	public function get_detail($id)
	{
		$this->db->from("pengajuan");
		$this->db->where("pgjfd_pgj_id", $id);
		$query = $this->db->get();

		return $query->result();
	}
	public function get_stat($id)
	{
		$this->db->from("purchase");
		$this->db->join("status_pengajuan", "prc_pgjf_id = sp_id_pgjf", "left");
		$this->db->where("prc_pgjf_id", $id);
		$query = $this->db->get();


		return $query->row();
	}
	public function get_detailpgj($id)
	{
		$this->db->from("pengajuan_detail");
		$this->db->join("barang", "pgjfd_brg_id = brg_id", "left");
		$this->db->where("pgjfd_id", $id);
		$query = $this->db->get();

		return $query->row();
	}
	public function get_pengajuanf($id)
	{
		$this->db->from("pengajuan");
		$this->db->join("pengajuan_detail", "pgjf_id = pgjfd_pgj_id", "left");
		$this->db->join("barang", "pgjfd_brg_id = brg_id", "left");
		$this->db->where("pgjf_id", $id);
		$query = $this->db->get();

		return $query->row();
	}
	public function get_listdetail($id)
	{
		$this->db->from("purchase");
		$this->db->join("purchase_detail", "prc_id = prcd_prc_id", "left");
		$this->db->join("barang", "prcd_brg_id = brg_id", "left");
		$this->db->where("prc_id", $id);
		$query = $this->db->get();


		return $query->result();
	}

	public function cek_pengajuan()
	{
		$this->db->from("pengajuan");
		$query = $this->db->get();

		return $query->row();
	}

	public function cari_barangmasuk($id)
	{
		$this->db->from("purchase");
		$this->db->join("purchase_detail", "prcd_prc_id = prc_id","left");
		// $this->db->join("pengajuan_fix", "pgjf_id = prc_pgjf_id","left");
		$this->db->join("pengajuan", "pgj_id = prc_id_pgj","left");
		$this->db->join("barang", "brg_id = prcd_brg_id", "left");
		$this->db->join("stok", "stk_id_brg = brg_id","left");
		$this->db->join("gudang", "id_gudang = stk_id_gudang","left");
		$this->db->where('prc_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	
	public function getlastquery()
	{
		$query = str_replace(array("\r", "\n", "\t"), '', trim($this->db->last_query()));

		return $query;
	}

	public function update($tbl, $where, $data)
	{
		$this->db->update($tbl, $data, $where);
		return $this->db->affected_rows();
	}

	public function simpan($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	public function simpanp($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function delete($table, $field, $id)
	{
		$this->db->where($field, $id);
		$this->db->delete($table);

		return $this->db->affected_rows();
	}
}
