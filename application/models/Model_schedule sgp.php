<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_schedule extends CI_Model {
	function __construct()
    {
        parent::__construct();
		$this->load->database();
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
		$this->db->select('mst_parameter.*');
		$this->db->from('mst_parameter');
		$this->db->join('mst_storage', 'mst_parameter.storage_id = mst_storage.storage_id');
		$this->db->where('mst_parameter.storage_id=', $id);
		$this->db->order_by('mst_parameter.parameter_id', 'ASC');
		$this->db->limit(1);
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_mst_barge($id,$id2) {
		$this->db->select('mst_barge.*');
		$this->db->from('mst_barge');
		$this->db->where('mst_barge.storage_id = ', $id);
		$this->db->where('mst_barge.prioritas > ', $id2);
		$this->db->order_by('mst_barge.prioritas', 'ASC');
		$this->db->limit(1);
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function max_mst_barge_prioritas($id){
		$this->db->select('MAX(prioritas) as max_id');
		$this->db->from('mst_barge');
		$this->db->where('mst_barge.storage_id = ', $id);
		$query = $this->db->get();
		
		$result = $query->row()->max_id;
		return $result;
	}

	function update_mst_parameter($data, $id){
		$this->db->where('storage_id', $id);
		return $this->db->update('mst_parameter', $data);
	}

	function get_trans_forecast($id) {
		$this->db->select('trans_forecast.*, mst_barge.barge_name');
		$this->db->from('trans_forecast');
		$this->db->join('mst_storage', 'trans_forecast.storage_id = mst_storage.storage_id');
		$this->db->join('mst_barge', 'trans_forecast.barge_id = mst_barge.barge_id', 'left');
		$this->db->where('mst_storage.storage_id=', $id);
		$this->db->order_by('trans_forecast.trans_date', 'ASC');
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}

	function delete_trans_forecast(){
		$tables = array('trans_forecast');
		$this->db->where('trans_id > 0');
		$this->db->delete($tables);
	}

	function max_trans_forecast(){
		$this->db->select('MAX(trans_id) as max_id');
		$this->db->from('trans_forecast');
		$query = $this->db->get();
		
		$result = $query->row()->max_id;
		return $result;
	}

	function insert_trans_forecast($data){
		return $this->db->insert('trans_forecast', $data);
	}

	function get_trans_atg($id) {
		$this->db->select('trans_atg.volume, trans_atg.ullage, trans_atg.atg_id');
		$this->db->from('trans_atg');
		$this->db->join('mst_atg', 'trans_atg.atg_id = mst_atg.atg_id');
		$this->db->join('mst_storage', 'mst_atg.storage_id = mst_storage.storage_id');
		$this->db->group_by('trans_atg.atg_id');
		$this->db->where('mst_storage.storage_id=', $id);
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
	
	function get_trans_po($id,$id2) {
		$this->db->select('trans_po.*');
		$this->db->from('trans_po');
		$this->db->join('mst_storage', 'trans_po.storage_id = mst_storage.storage_id');
		$this->db->where('trans_po.storage_id=', $id);
		$this->db->where('trans_po.posting_date=', $id2);
		$this->db->order_by('trans_po.trans_id', 'ASC');
		$this->db->limit(1);
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}

	function get_trans_forecast_last($id) {
		$this->db->select('trans_forecast.*, barge_name, prioritas');
		$this->db->from('trans_forecast');
		$this->db->join('mst_storage', 'trans_forecast.storage_id = mst_storage.storage_id');
		$this->db->join('mst_barge', 'trans_forecast.barge_id = mst_barge.barge_id');
		$this->db->where('mst_storage.storage_id=', $id);
		$this->db->order_by('trans_forecast.trans_date', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
}?>