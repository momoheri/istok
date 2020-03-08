<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_monitoring extends CI_Model {
	function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	function fuel_receiving_with_transporter($start, $end) {
		$SQL = "SELECT mst_transporter.transporter_id as id_transporter, mst_transporter.transporter_name, qw.*
						FROM mst_transporter
						LEFT JOIN (
											SELECT trans_po.transporter_id, mst_vendor.vendor_id, trans_po.quantity
											FROM trans_po_received
											INNER JOIN trans_po ON trans_po_received.trans_id=trans_po.trans_id
											INNER JOIN mst_vendor ON mst_vendor.vendor_id =trans_po.vendor_id
											WHERE DATE_FORMAT(created_date, '%Y-%m-%d') BETWEEN '$start' AND '$end'
											) AS qw on qw.transporter_id=mst_transporter.transporter_id

						ORDER BY mst_transporter.transporter_id ASC";
		$query = $this->db->query($SQL);

		return $query->result_array();
	}
	
	
	function get_trans_atg_($id) {
		$this->db->select('trans_atg.*, mst_storage.*');
		$this->db->from('trans_atg');
		$this->db->join('mst_atg', 'trans_atg.atg_id = mst_atg.atg_id');
		$this->db->join('mst_storage', 'mst_atg.storage_id = mst_storage.storage_id');
		$this->db->where('mst_storage.storage_id=', $id);
		$this->db->order_by('trans_date', 'DESC');
		$this->db->order_by('trans_time', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_trans_atg($id) {
		// $this->db2 = $this->load->database('db2', TRUE);
		
		$this->db->select('*');
		$this->db->from('trans_atg');
		// $this->db->where('atg_id=', $id);
		$this->db->order_by('trans_date', 'DESC');
		$this->db->order_by('trans_time', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_data_mst_storage($id) {
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
	
	function get_atg_max(){
		$this->db->select('MAX(trans_id) as max_id');
		$this->db->from('trans_atg');
		//$this->db->where('salesperson_id', $id);
		$query = $this->db->get();
		return $query->row()->max_id;
	}
	
	function get_vendor(){
		$this->db->select('vendor_id, vendor_name');
		$this->db->from('mst_vendor');
		$this->db->order_by('vendor_id', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function insert_atg($data){
		return $this->db->insert('trans_atg', $data);
	}
	
}?>