<?php
class Model_Pengajuan extends CI_Model
{
	var $table = 'pengajuan';
	var $column_order = array('pgj_id','pgj_tgl', 'pgj_nama','pgj_status', 'pgj_status_ket'); //set column field database for datatable orderable
	var $column_search = array('pgj_id','pgj_tgl', 'pgj_nama','pgj_status', 'pgj_status_ket'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('pgj_tgl' => 'asc'); // default order  	private $db_sts;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$level = $this->session->userdata('level');
		// var_dump($level);
		// exit();

		$this->db->from($this->table);

		// if($level == 2){
		// 	$this->db->where('pgj_status <= 1');
		// 	// $this->db->where('pgj_status = 4');
			
		// } else if ($level == 6){
		// 	$this->db->where('pgj_status >= 1');
		// }

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

	public function get_pengajuan()
	{
		$this->db->from("pengajuan");
		$query = $this->db->get();

		return $query->row();
	}
	public function get_gudang()
	{
		$this->db->from("gudang");
		$query = $this->db->get();

		return $query->result();
	}
	public function get_pengajuan_detail($id, $val, $n)
	{
		
		$request = $this->cari_pengajuan($val[0]);

		
		$d = [
			'pgjd_pgj_id' => $id,
			'pgjd_brg_id' => $val[0],
			'pgjd_jml' => $val[1],
			'pgjd_harga_satuan' => $val[2],
			'pgjd_hrg_brg' => $val[3],
		];
		// var_dump($d);
		// exit();

		$this->simpan('pengajuan_detail', $d);
		
	}
	public function get_pengajuanf_detail($id)
	{
		
		$this->db->from("pengajuan_detail");
		$this->db->join("pengajuan", "pgjd_pgj_id = pgj_id", "left");
		$this->db->join("barang", "pgjd_brg_id = brg_id", "left");
		// $this->db->join("pengajuan_detail", "pgjd_pgj_id = rq_id", "left");
		$this->db->where("pgjd_pgj_id", $id);
		$query = $this->db->get();

		return $query->result();
		
	}
	public function get_detail($id)
	{
		$this->db->from("pengajuan");
		$this->db->where("pgjd_pgj_id", $id);
		$query = $this->db->get();

		return $query->result();
	}
	public function get_detail_pengajuan($id)
	{
		$this->db->from("pengajuan_detail");
		$this->db->where("pgjd_pgj_id", $id);
		$query = $this->db->get();

		return $query->result();
	}
	public function get_detailpgj($id)
	{
		$this->db->from("pengajuan_detail");
		$this->db->join("barang", "pgjd_brg_id = brg_id", "left");
		$this->db->where("pgjd_id", $id);
		$query = $this->db->get();

		return $query->row();
	}
	public function get_pengajuanf($id)
	{
		$this->db->from("pengajuan");
		$this->db->join("pengajuan_detail", "pgj_id = pgjd_pgj_id", "left");
		$this->db->join("barang", "pgjd_brg_id = brg_id", "left");
		// $this->db->join("pengajuan_fix", "pgj_id = pgjb_id", "left");
		// $this->db->join("pengajuan_fix_detail", "pgj_id = pgjg_id", "left");
		$this->db->where("pgj_id", $id);
		$query = $this->db->get();

		return $query->row();
	}
	public function get_fix($id)
	{
		$this->db->from("pengajuan_fix_detail");
		$this->db->join("pengajuan_fix", "pgjg_id = pgjb_id", "left");
		$this->db->join("barang", "pgjfd_brg_id = brg_id", "left");
		// $this->db->join("pengajuan_fix_detail", "pgj_id = pgjb_id", "left");
		$this->db->where("pgjg_id", $id);
		$query = $this->db->get();

		return $query->result();
	}
	public function get_listdetail($id)
	{
		$this->db->from("pengajuan_detail");
		$this->db->join("pengajuan", "pgjd_pgj_id = pgj_id", "left");
		$this->db->join("barang", "pgjd_brg_id = brg_id", "left");
		$this->db->where("pgjd_pgj_id", $id);
		$query = $this->db->get();

		return $query->result();
	}

	public function cek_pengajuan()
	{
		$this->db->from("pengajuan");
		$query = $this->db->get();

		return $query->row();
	}

	public function cari_pengajuan($id)
	{
		$this->db->from("pengajuan");
		$this->db->where('pgj_id', $id);
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
