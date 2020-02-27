<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_home extends CI_Model {
	function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
        function get_max_trans_atg(){}
	function get_trans_atg($id) {
            
            
		$this->db->select('trans_atg.volume, trans_atg.ullage, trans_atg.atg_id');
		$this->db->from('trans_atg');
		$this->db->join('mst_atg', 'trans_atg.atg_id = mst_atg.atg_id');
		$this->db->join('mst_storage', 'mst_atg.storage_id = mst_storage.storage_id');
		$this->db->group_by('trans_atg.atg_id');
		$this->db->where('mst_storage.storage_id=', $id);
                //$this->db->where('trans_atg.trans_date=', 'CURRENT_DATE()');
		$this->db->order_by('trans_atg.trans_date', 'DESC');
		$this->db->order_by('trans_atg.trans_time', 'DESC');
		// $this->db->limit(1);
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_trans_cleanliness_in($id) {
		$this->db->select('trans_cleanliness.*');
		$this->db->from('trans_cleanliness');
		$this->db->join('mst_cleanliness', 'trans_cleanliness.cleanliness_id = mst_cleanliness.cleanliness_id');
		$this->db->join('mst_storage', 'mst_cleanliness.storage_id = mst_storage.storage_id');
		$this->db->group_by('trans_cleanliness.cleanliness_id');
		$this->db->where('mst_storage.storage_id=', $id);
		$this->db->where('mst_cleanliness.cleanliness_type=', 'inlet');
		$this->db->order_by('trans_cleanliness.tgl', 'DESC');
		// $this->db->limit(1);
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_trans_cleanliness_out($id) {
		$this->db->select('trans_cleanliness.*');
		$this->db->from('trans_cleanliness');
		$this->db->join('mst_cleanliness', 'trans_cleanliness.cleanliness_id = mst_cleanliness.cleanliness_id');
		$this->db->join('mst_storage', 'mst_cleanliness.storage_id = mst_storage.storage_id');
		$this->db->group_by('trans_cleanliness.cleanliness_id');
		$this->db->where('mst_storage.storage_id=', $id);
		$this->db->where('mst_cleanliness.cleanliness_type=', 'outlet');
		$this->db->order_by('trans_cleanliness.tgl', 'DESC');
		// $this->db->limit(1);
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_trans_smartfill_out($id) {
		$this->db->select('(trans_smartfill.Date) as tanggal, SUM(trans_smartfill.Volume) as total');
		$this->db->from('trans_smartfill');
		$this->db->join('mst_smartfill', 'trans_smartfill.smartfill_id = mst_smartfill.smartfill_id');
		$this->db->join('mst_storage', 'mst_smartfill.storage_id = mst_storage.storage_id');
		$this->db->group_by('trans_smartfill.date');
		$this->db->where('mst_storage.storage_id=', $id);
		$this->db->where('mst_smartfill.smartfill_type=', 'out');
		$this->db->order_by('trans_smartfill.date', 'DESC');
		$this->db->limit(7);
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_trans_po($id,$tgl) {
		$this->db->select('trans_po.*');
		$this->db->from('trans_po');
		$this->db->join('mst_storage', 'trans_po.storage_id = mst_storage.storage_id');
		$this->db->where('trans_po.storage_id=', $id);
		$this->db->where('trans_po.posting_date>=', $tgl);
		$this->db->limit(1);
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_mst_storage($id) {
		$this->db->select('mst_storage.*');
		$this->db->from('mst_storage');
		$this->db->where('mst_storage.storage_id=', $id);
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_mst_parameter($id) {
		$this->db->select('*');
		$this->db->from('mst_parameter');
		$this->db->where('storage_id=', $id);
		$this->db->limit(1);
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function insert_atg($data){
		return $this->db->insert('trans_atg', $data);
	}
	
}?>