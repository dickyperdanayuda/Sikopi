<?php
class Model_Request extends CI_Model
{
	var $table = 'request';
	var $column_order = array('rq_id', 'rq_tgl', 'rq_nama','rq_total','rq_status'); //set column field database for datatable orderable
	var $column_search = array('rq_id', 'rq_tgl', 'rq_nama','rq_status'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('rq_tgl' => 'asc'); // default order  	private $db_sts;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$level = $this->session->userdata('level');
		
		$this->db->from($this->table);

		
		
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

	public function get_detail($id)
	{
		$this->db->from("request");
		$this->db->where("rqd_rq_id", $id);
		$query = $this->db->get();

		return $query->result();
	}
	public function get_request($id)
	{
		$this->db->from("request");
		$this->db->join("request_detail", "rq_id = rqd_rq_id", "left");
		$this->db->join("barang", "rqd_brg_id = brg_id", "left");
		$this->db->join("project", "id_prj = id_project", "left");
		$this->db->where("rq_id", $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_detail_request($id)
	{
		$this->db->from("request_detail");
		$this->db->where("rqd_rq_id", $id);
		$query = $this->db->get();

		return $query->result();
	}
	public function get_detail_request_0($id)
	{
		$this->db->from("request_detail");
		$this->db->where("rqd_rq_id", $id);
		
		$query = $this->db->get();

		return $query->num_rows();
	}
	public function get_detail_request_1($id)
	{
		$this->db->from("request_detail");
		$this->db->where("rqd_rq_id", $id);
		$this->db->where("rqd_status", 1);
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function get_proses($id)
	{
		$this->db->from("request");
		$this->db->join("pengajuan", "rq_id = pgj_id_rq", "left");
		$this->db->join("purchase", "pgj_id = prc_id_pgj", "left");
		// $this->db->join("status_pengajuan", "pgjf_id = sp_id_pgjf", "left");
		$this->db->order_by("rq_id", "desc");
		$this->db->where("rq_id", $id);
		$query = $this->db->get();

		return $query->row();
	}
	public function cek_request()
	{
		$this->db->from("request");
		$query = $this->db->get();

		return $query->row();
	}
	public function get_listdetail($id)
	{
		$this->db->from("request_detail");
		$this->db->join("request", "rqd_rq_id = rq_id", "left");
		$this->db->join("barang", "rqd_brg_id = brg_id", "left");
		$this->db->where("rqd_rq_id", $id);
		$query = $this->db->get();

		return $query->result();
	}
	public function get_listdetail2($id)
	{
		$this->db->from("request_detail");
		$this->db->where("rqd_rq_id", $id);
		$query = $this->db->get();

		return $query->result();
	}
	public function cari_barang($id)
	{
		$this->db->from("barang");
		$this->db->where("brg_id", $id);
		$query = $this->db->get();

		return $query->row();
	}
	public function get_gudang()
	{
		$this->db->from("gudang");
		$query = $this->db->get();

		return $query->result();
	}

	public function get_request_detail($id, $val, $n)
	{
		
		$request = $this->cari_request($val[0]);

		
		$d = [
			'rqd_rq_id' => $id,
			'rqd_brg_id' => $val[0],
			'rqd_jml' => $val[1],
			'rqd_harga_satuan' => $val[2],
			'rqd_hrg_brg' => $val[3],
		];

		$this->simpan('request_detail', $d);
		
	}
	public function get_pengajuan_detail($id)
	{
		
		$this->db->from("request_detail");
		$this->db->join("request", "rqd_rq_id = rq_id", "left");
		$this->db->join("barang", "rqd_brg_id = brg_id", "left");
		// $this->db->join("pengajuan_detail", "pgjd_pgj_id = rq_id", "left");
		$this->db->where("rqd_rq_id", $id);
		$this->db->where("rqd_status", "0");
		$query = $this->db->get();

		return $query->result();
		
	}

	public function cari_request($id)
	{
		$this->db->from("request");
		$this->db->where('rq_id', $id);
		$query = $this->db->get();

		return $query->row();
	}
	public function cari_requestt($id)
	{
		$this->db->from("request");
		$this->db->where('rq_id', $id);
		$query = $this->db->get();

		return $query->result();
	}
	public function cari_requestd($id)
	{
		$this->db->from("request");
		$this->db->where('rq_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	function cek($username, $password)
	{
		$this->db->where("log_user", $username);
		$this->db->where("log_pass", md5($password));
		return $this->db->get("sys_login");
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
