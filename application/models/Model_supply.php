<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_supply extends CI_Model {
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	
	/*------------------------------------------------------------------------------*/
	
	function get_transporter_performance($start, $end) {
		$SQL = "SELECT mst_movement_reason.movement_reason_id, mst_movement_reason.movement_reason_name, performance.*
						FROM mst_movement_reason
						LEFT JOIN (	
							SELECT mst_transporter.transporter_id, mst_transporter.transporter_name, trans_po.posting_date, count(trans_po.trans_id) as total, trans_po_received.movement_reason
							FROM `trans_po`
							INNER JOIN trans_po_received on trans_po.trans_id=trans_po_received.trans_id
							INNER JOIN mst_transporter on trans_po.transporter_id=mst_transporter.transporter_id
							WHERE DATE_FORMAT(trans_po.posting_date, '%Y-%m-%d') BETWEEN '$start' AND '$end'
							GROUP BY transporter_name, movement_reason
						) AS performance ON mst_movement_reason.movement_reason_id=performance.movement_reason

						ORDER BY mst_movement_reason.movement_reason_id, transporter_id ASC";
		$query = $this->db->query($SQL);

		return $query->result_array();
	}
	/*------------------------------------------------------------------------------*/
	
	function get_vendor_performance($start, $end) {
		$SQL = "SELECT mst_movement_reason.movement_reason_id, mst_movement_reason.movement_reason_name, performance.*
						FROM mst_movement_reason
						LEFT JOIN (	
							SELECT mst_vendor.vendor_id, mst_vendor.vendor_name, trans_po.posting_date, count(trans_po.trans_id) as total, trans_po_received.movement_reason
							FROM `trans_po`
							INNER JOIN trans_po_received on trans_po.trans_id=trans_po_received.trans_id
							INNER JOIN mst_vendor on trans_po.vendor_id=mst_vendor.vendor_id
							WHERE DATE_FORMAT(trans_po.posting_date, '%Y-%m-%d') BETWEEN '$start' AND '$end'
							GROUP BY vendor_name, movement_reason
						) AS performance ON mst_movement_reason.movement_reason_id=performance.movement_reason

						ORDER BY mst_movement_reason.movement_reason_id, vendor_id ASC";
		$query = $this->db->query($SQL);

		return $query->result_array();
	}
	
	/*------------------------------------------------------------------------------*/
	
	function get_inventory_performance($storage_id, $start, $end, $label_type) {
		if($label_type == 'day'){
			$SQL = "SELECT ROUND(AVG(volume)) as average, stock_max as maximal, stock_min as minimum, safety_stock as safety, DATE_FORMAT(trans_date, '%Y-%m-%d') as month_date
							FROM `trans_atg`
							INNER JOIN mst_parameter ON mst_parameter.storage_id=trans_atg.storage_id
							WHERE DATE_FORMAT(trans_date, '%Y-%m-%d') BETWEEN '$start' AND '$end'
							AND trans_atg.storage_id = '$storage_id'
							GROUP BY DATE_FORMAT(trans_date, '%Y-%m-%d')";
	
		}else{
			$SQL = "SELECT ROUND(AVG(volume)) as average, stock_max as maximal, stock_min as minimum, safety_stock as safety, DATE_FORMAT(trans_date, '%M') as month_date
							FROM `trans_atg`
							INNER JOIN mst_parameter ON mst_parameter.storage_id=trans_atg.storage_id
							WHERE DATE_FORMAT(trans_date, '%Y-%m-%d') BETWEEN '$start' AND '$end'
							AND trans_atg.storage_id = '$storage_id'
							GROUP BY DATE_FORMAT(trans_date, '%M')";
		}
		$query = $this->db->query($SQL);

		return $query->result_array();
	}
	
	function get_forecast($storage_id, $start, $end, $label_type) {
		if($storage_id == 1){
			$table = 'log_forecast_lati';
		}elseif($storage_id == 2){
			$table = 'log_forecast_sur';			
		}elseif($storage_id == 3){			
			$table = 'log_forecast_sam';
		}
		
		$start = date ("Y-m-d", strtotime("-1 day", strtotime($start)));
		if($label_type == 'day'){
			$SQL = "SELECT inventory, DATE_FORMAT(trans_date, '%Y-%m-%d') as trans_date FROM $table
							WHERE DATE_FORMAT(trans_date, '%Y-%m-%d') BETWEEN '$start' AND '$end'
							AND storage_id = '$storage_id'";
	
		}else{
			$SQL = "SELECT ROUND(AVG(inventory)) as inventory, DATE_FORMAT(trans_date, '%M') as trans_date FROM $table
							WHERE DATE_FORMAT(trans_date, '%Y-%m-%d') BETWEEN '$start' AND '$end'
							AND storage_id = '$storage_id'
							GROUP BY DATE_FORMAT(trans_date, '%M')";
		}
		$query = $this->db->query($SQL);

		return $query->result_array();
	}
	
	function get_inventory_performance_new($storage_id, $start, $end, $label_type) {
		if($label_type == 'day'){
			$SQL = "SELECT ROUND(SUM(volume)) as vol, trans_date, qty_observe, DATE_FORMAT(trans_date, '%Y-%m-%d') as month_date from (
								SELECT trans_atg.trans_id, trans_atg.atg_id, trans_atg.trans_date,
												trans_atg.trans_time, trans_atg.tankno, trans_atg.volume, trans_atg.ullage,
												(select trans_sounding_manual.qty_observe from trans_sounding_manual
												where trans_sounding_manual.trans_status = '0' and trans_sounding_manual.manual_type = '1'
												and trans_sounding_manual.atg_id = trans_atg.atg_id) as qty_observe
										FROM trans_atg
												JOIN mst_storage ON trans_atg.storage_id = mst_storage.storage_id
												WHERE mst_storage.storage_id = '$storage_id' AND (DATE_FORMAT(trans_date, '%Y-%m-%d') BETWEEN '$start' AND '$end')
												GROUP BY trans_atg.atg_id, DATE_FORMAT(trans_date, '%Y-%m-%d')
												ORDER BY trans_atg.trans_date DESC,
												trans_atg.trans_time DESC) as res
							GROUP BY DATE_FORMAT(trans_date, '%Y-%m-%d')";
	
		}else{
			$SQL = "SELECT ROUND(AVG(vol)) as vol, trans_date, qty_observe, DATE_FORMAT(trans_date, '%M') as month_date from (
								SELECT SUM(volume) as vol, trans_date, qty_observe, DATE_FORMAT(trans_date, '%M') as month_date from (
									SELECT trans_atg.trans_id, trans_atg.atg_id, trans_atg.trans_date,
													trans_atg.trans_time, trans_atg.tankno, trans_atg.volume, trans_atg.ullage,
													(select trans_sounding_manual.qty_observe from trans_sounding_manual
													where trans_sounding_manual.trans_status = '0' and trans_sounding_manual.manual_type = '1'
													and trans_sounding_manual.atg_id = trans_atg.atg_id) as qty_observe
											FROM trans_atg
													JOIN mst_storage ON trans_atg.storage_id = mst_storage.storage_id
													WHERE mst_storage.storage_id = '$storage_id' AND (DATE_FORMAT(trans_date, '%Y-%m-%d') BETWEEN '$start' AND '$end')
													GROUP BY trans_atg.atg_id, DATE_FORMAT(trans_date, '%Y-%m-%d')
													ORDER BY trans_atg.trans_date DESC,
													trans_atg.trans_time DESC) as res
								GROUP BY DATE_FORMAT(trans_date, '%Y-%m-%d')) as rest
							GROUP BY DATE_FORMAT(trans_date, '%M')";
		}
		$query = $this->db->query($SQL);

		return $query->result_array();
	}
	
	/*------------------------------------------------------------------------------*/
	
	function get_parameters($id) {
		$SQL = "SELECT stock_max as maximal, stock_min as minimum, safety_stock as safety
							FROM mst_parameter
							WHERE storage_id = '$id'";
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
	
	function insert_atg($data){
		return $this->db->insert('trans_atg', $data);
	}
	
}?>