<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_monitoring extends CI_Model {
	function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	/*------------------------------------------------------------------------------*/
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
	
	/*------------------------------------------------------------------------------*/
	function get_fuel_positive($start, $end) {
		$SQL = "SELECT storage_name, SUM(volume) as volume, SUM(tc_vol) as tc_vol 
						FROM `trans_atg`
						INNER JOIN mst_storage ON trans_atg.storage_id=mst_storage.storage_id
						WHERE DATE_FORMAT(trans_date, '%Y-%m-%d') BETWEEN '$start' AND '$end'
						GROUP BY trans_atg.storage_id";
		$query = $this->db->query($SQL);

		return $query->result_array();
	}
	/*------------------------------------------------------------------------------*/
	function get_fuel_negative($start, $end) {
		$SQL = "SELECT 
							CASE
								WHEN QUARTER(opname_date) = 1
								THEN 'Q1'
								WHEN QUARTER(opname_date) = 2
								THEN 'Q2'
								WHEN QUARTER(opname_date) = 3
								THEN 'Q3'
								WHEN QUARTER(opname_date) = 4
								THEN 'Q4'
							END 'quarter',manual_surveyor, vol_atg, storage_id
						FROM `trans_stock_opname`						
						WHERE DATE_FORMAT(opname_date, '%Y-%m-%d') BETWEEN '$start' AND '$end'
						ORDER BY `quarter` ASC
						";
		$query = $this->db->query($SQL);

		return $query->result_array();
	}
	/*------------------------------------------------------------------------------*/
	function get_purchase_order_to_vendor($start, $end) {
		$SQL = "SELECT posting_date, vendor_id, qty_volcomp as quantity, trans_po.storage_id, storage_name 
						FROM mst_storage
						LEFT JOIN `trans_po` ON trans_po.storage_id = mst_storage.storage_id
						LEFT JOIN trans_po_received ON trans_po.trans_id = trans_po_received.trans_id
						LEFT JOIN trans_sap_log on trans_sap_log.trans_id=trans_po.trans_id
						WHERE trans_sap_log.`status` = 0 AND (trans_sap_log.error_type = NULL OR trans_sap_log.error_type = '') 
						AND DATE_FORMAT(posting_date, '%Y-%m-%d') BETWEEN '$start' AND '$end'
						ORDER BY vendor_id ASC";
		$query = $this->db->query($SQL);

		return $query->result_array();
	}
	
	/*------------------------------------------------------------------------------*/
	function get_fuel_distribution_to_mining($start, $end) {
		$SQL = "SELECT trans_sap_log.description, mst_smartfill.storage_id, storage_name, Volume, DATE_FORMAT(trans_smartfill.CreatedDate, '%d-%m-%Y') as CreatedDate
						FROM `trans_sap_log`
						INNER JOIN trans_smartfill ON trans_sap_log.trans_id=trans_smartfill.trans_id
						INNER JOIN mst_smartfill ON trans_smartfill.smartfill_id=mst_smartfill.smartfill_id
						INNER JOIN mst_storage ON mst_storage.storage_id=mst_smartfill.storage_id
						WHERE (trans_sap_log.error_type = NULL OR trans_sap_log.error_type = '')
						AND trans_sap_log.doc_type = 'GI'
						AND (movement = '9001' OR movement = '9003')
						AND DATE_FORMAT(trans_smartfill.CreatedDate, '%Y-%m-%d') BETWEEN '$start' AND '$end'
						ORDER BY movement ASC";
		$query = $this->db->query($SQL);

		return $query->result_array();
	}
	
	/*------------------------------------------------------------------------------*/
	function get_fuel_distribution_on_activity($start, $end) {
		$SQL = "SELECT movement, mst_smartfill.storage_id, storage_name, Volume, DATE_FORMAT(trans_smartfill.CreatedDate, '%d-%m-%Y') as CreatedDate
						FROM `trans_sap_log`
						INNER JOIN trans_smartfill ON trans_sap_log.trans_id=trans_smartfill.trans_id
						INNER JOIN mst_smartfill ON trans_smartfill.smartfill_id=mst_smartfill.smartfill_id
						INNER JOIN mst_storage ON mst_storage.storage_id=mst_smartfill.storage_id
						WHERE (trans_sap_log.error_type = NULL OR trans_sap_log.error_type = '')
						AND trans_sap_log.doc_type = 'GI'
						AND DATE_FORMAT(trans_smartfill.CreatedDate, '%Y-%m-%d') BETWEEN '$start' AND '$end'
						ORDER BY movement ASC";
		$query = $this->db->query($SQL);

		return $query->result_array();
	}
	
	/*------------------------------------------------------------------------------*/
	
	function get_fuel_price($start, $end, $label_type) {
		if($label_type == 'day'){
			$SQL = "SELECT posting_date, ROUND(AVG(trans_sap_log.price)) as price, trans_po.vendor_id FROM `trans_po`
							INNER JOIN trans_po_received ON trans_po.trans_id = trans_po_received.trans_id
							INNER JOIN trans_sap_log on trans_sap_log.trans_id=trans_po.trans_id
							WHERE trans_sap_log.`status` = 0 AND (trans_sap_log.error_type = NULL OR trans_sap_log.error_type = '') 
							AND DATE_FORMAT(posting_date, '%Y-%m-%d') BETWEEN '$start' AND '$end'
							GROUP BY DATE_FORMAT(posting_date, '%Y-%m-%d')";
	
		}else{
			$SQL = "SELECT DATE_FORMAT(posting_date, '%M') as posting_date, ROUND(AVG(trans_sap_log.price)) as price, trans_po.vendor_id FROM `trans_po`
							INNER JOIN trans_po_received ON trans_po.trans_id = trans_po_received.trans_id
							INNER JOIN trans_sap_log on trans_sap_log.trans_id=trans_po.trans_id
							WHERE trans_sap_log.`status` = 0 AND (trans_sap_log.error_type = NULL OR trans_sap_log.error_type = '') 
							AND DATE_FORMAT(posting_date, '%Y-%m-%d') BETWEEN '$start' AND '$end'
							GROUP BY DATE_FORMAT(posting_date, '%M')";
		}
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
		$query = $this->db->query($SQL);

		return $query->result_array();
	}
	
	/*------------------------------------------------------------------------------*/
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
	
	/*------------------------------------------------------------------------------*/
	
	function get_description_sap_mining(){
		$SQL = "SELECT description
						FROM trans_sap_log
						WHERE (trans_sap_log.error_type = NULL OR trans_sap_log.error_type = '')
						AND trans_sap_log.doc_type = 'GI'
						AND (movement = '9001' OR movement = '9003')
						GROUP BY description
						ORDER BY description ASC";
		$query = $this->db->query($SQL);

		return $query->result_array();
	}
	
	/*------------------------------------------------------------------------------*/
	
	function get_movement(){
		$SQL = "SELECT movement
						FROM trans_sap_log
						WHERE (trans_sap_log.error_type = NULL OR trans_sap_log.error_type = '')
						AND trans_sap_log.doc_type = 'GI'
						GROUP BY movement
						ORDER BY movement ASC";
		$query = $this->db->query($SQL);

		return $query->result_array();
	}
	
	/*------------------------------------------------------------------------------*/
	
	function get_storage(){
		$this->db->select('storage_id, storage_name');
		$this->db->from('mst_storage');
		$this->db->order_by('storage_id', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_vendor(){
		$this->db->select('vendor_id, alias AS vendor_name');
		$this->db->from('mst_vendor');
		$this->db->order_by('vendor_id', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_transporter(){
		$this->db->select('mst_transporter.transporter_id, mst_transporter.alias AS transporter_name');
		$this->db->from('mst_transporter');
		$this->db->order_by('transporter_id', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_performance(){
		$this->db->select('movement_reason_id, movement_reason_name');
		$this->db->from('mst_movement_reason');
		$this->db->order_by('movement_reason_id', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	/*------------------------------------------------------------------------------*/
	
	function insert_atg($data){
		return $this->db->insert('trans_atg', $data);
	}
	
}?>