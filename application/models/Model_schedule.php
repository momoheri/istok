<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
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
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
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
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
		$this->db->select('trans_forecast.*, mst_barge.barge_name');
		$this->db->from('trans_forecast');
		$this->db->join('mst_storage', 'trans_forecast.storage_id = mst_storage.storage_id');
		$this->db->join('mst_barge', 'trans_forecast.barge_id = mst_barge.barge_id', 'left');
		$this->db->where('mst_storage.storage_id=', $id);
		$this->db->order_by('trans_forecast.trans_date', 'ASC');
                $this->db->limit('30');
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}

	function delete_trans_forecastById($id){
		$tables = array('trans_forecast');
		$this->db->where('storage_id', $id);
		$this->db->delete($tables);
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
        
        function get_today_forecast(){
            $this->db->select('trans_forecast.*');
            $this->db->from('trans_forecast');
            $query = $this->db->get();
            
            $result = $query->row()->trans_date;
            return $result;
            
        }
        
        function get_forecast_ById($date,$id){
            $this->db->select('trans_forecast.*');
            $this->db->from('trans_forecast');
            $this->db->where('trans_date', $date);
            $this->db->where('storage_id', $id);
            $query = $this->db->get();
            
            $result = $query->row()->trans_id;
            return $result;
        }
        
        function get_sum_order_po_ByVendor($v_id, $s_id,$start,$end){
            $this->db->select('SUM(quantity) AS total');
            $this->db->from('trans_po');
            $this->db->where('posting_date >=', $start);
            $this->db->where('posting_date <=', $end);
            $this->db->where('vendor_id', $v_id);
            $this->db->where('storage_id', $s_id);
            $query = $this->db->get();
            
            $result = $query->row()->total;
            return $result;
        }
        
        function get_sum_order_po_ByTransporter($t_id,$s_id,$start,$end){
            $this->db->select('SUM(quantity) AS total');
            $this->db->from('trans_po');
            $this->db->where('posting_date >=', $start);
            $this->db->where('posting_date <=', $end);
            $this->db->where('transporter_id', $t_id);
            $this->db->where('storage_id', $s_id);
            $query = $this->db->get();
            
            $result = $query->row()->total;
            return $result;
        }
        
        function insert_trans_forecast($data){
            return $this->db->insert('trans_forecast', $data);
	}

	
        
        function get_trans_atg($id) {
			$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
            date_default_timezone_set('Asia/Jakarta');
            $time = date('H');
            //$add_time = $time-$data;
            //$time = date('H');
            $date = date('Y-m-d');

            $this->db->select('trans_atg.trans_id, mst_atg.atg_name, mst_atg.atg_id, trans_atg.trans_date, trans_atg.trans_time, trans_atg.tankno, trans_atg.volume, trans_atg.ullage, view_alarm_qty.type_alarm, view_alarm_qty.qty_observe, view_alarm_qty.trans_date');
            $this->db->from('trans_atg');
            $this->db->join('mst_atg', 'trans_atg.atg_id = mst_atg.atg_id');
            $this->db->join('mst_storage', 'mst_atg.storage_id = mst_storage.storage_id');
            $this->db->join('view_alarm_qty', 'trans_atg.atg_id = view_alarm_qty.atg_id','left');
            $this->db->group_by('trans_atg.atg_id');
            $this->db->where('mst_storage.storage_id=', $id);
            $this->db->where('trans_atg.trans_date', $date);
            $this->db->where('trans_atg.trans_time LIKE', $time.':%:%');

            $this->db->order_by('trans_atg.trans_date', 'DESC');
            $this->db->order_by('trans_atg.trans_time', 'DESC');
            $this->db->order_by('view_alarm_qty.trans_id', 'DESC');
            // $this->db->limit(1);
            $query = $this->db->get();

            $result = array();
            if($query->num_rows() > 0) {
                    $result = $query->result();
            }
            return $result;
	}
        
        function get_trans_atg_null($id,$data){
			$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
            date_default_timezone_set('Asia/Jakarta');
            $time = date('H');
            //$time = date('H');
            $add_time = $time-$data;
            $date = date('Y-m-d');
            $result = array();

            //$query
            return $this->db->query("SELECT trans_atg.trans_id, mst_atg.atg_name, mst_atg.atg_id, trans_atg.trans_date,
            trans_atg.trans_time, trans_atg.tankno, trans_atg.volume, trans_atg.ullage,
            (select trans_sounding_manual.qty_observe from trans_sounding_manual
            where trans_sounding_manual.trans_status = '0' and trans_sounding_manual.manual_type = '1'
            and trans_sounding_manual.atg_id = mst_atg.atg_id) as qty_observe, (select trans_sounding_manual.trans_date from trans_sounding_manual
            where trans_sounding_manual.trans_status = '0' and trans_sounding_manual.manual_type = '1'
            and trans_sounding_manual.atg_id = mst_atg.atg_id) as manual_date FROM trans_atg
            JOIN mst_atg ON trans_atg.atg_id = mst_atg.atg_id
            JOIN mst_storage ON mst_atg.storage_id = mst_storage.storage_id
            WHERE mst_storage.storage_id = '$id' AND trans_atg.trans_date = '$date'
            AND trans_atg.trans_time LIKE '%$add_time:%:%'
            GROUP BY trans_atg.atg_id
            ORDER BY trans_atg.trans_date DESC,
            trans_atg.trans_time DESC")->result();

	}
        
        function get_trans_atg2($id) {
			$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
            date_default_timezone_set('Asia/Jakarta');
            $date = date('m-d');

            $this->db->select('max(trans_date) as max_date');
            $this->db->from('trans_atg');
            $this->db->where('storage_id', $id);
            $max_date = $this->db->get()->row()->max_date;

            return $this->db->query("SELECT trans_atg.trans_id, mst_atg.atg_name, mst_atg.atg_id, trans_atg.trans_date,
				trans_atg.trans_time, trans_atg.tankno, trans_atg.volume, trans_atg.ullage,
				(select trans_sounding_manual.qty_observe from trans_sounding_manual
				where trans_sounding_manual.trans_status = '0' and trans_sounding_manual.manual_type = '1'
				and trans_sounding_manual.atg_id = mst_atg.atg_id) as qty_observe, (select trans_sounding_manual.trans_date from trans_sounding_manual
				where trans_sounding_manual.trans_status = '0' and trans_sounding_manual.manual_type = '1'
				and trans_sounding_manual.atg_id = mst_atg.atg_id) as manual_date FROM trans_atg
				JOIN mst_atg ON trans_atg.atg_id = mst_atg.atg_id
				JOIN mst_storage ON mst_atg.storage_id = mst_storage.storage_id
				WHERE mst_storage.storage_id = '$id' AND trans_atg.trans_date = '$max_date'
				GROUP BY trans_atg.atg_id
				ORDER BY trans_atg.trans_date DESC,
				trans_atg.trans_time DESC")->result();
        }
        
        function get_forecastmax_id($id){
            return $this->db->query("SELECT MAX(trans_id) AS max_id FROM trans_forecast WHERE storage_id = $id")->row();
        }
	
	function get_trans_po($id,$id2) {
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
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
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
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
        
        function max_forecast_byId($id){
                $this->db->select('MAX(trans_id) as max_id');
		$this->db->from('trans_forecast');
                $this->db->where('storage_id', $id);
		$query = $this->db->get();
		
		$result = $query->row()->max_id;
		return $result;
        }
        
        function get_idtrans_before($id){
            $id_b = $id-1;
            return $this->db->query("SELECT * FROM trans_forecast WHERE trans_id=$id_b")->result();
        }
        
        function get_last_forecast($id){
            return $this->db->query("SELECT * FROM trans_forecast WHERE trans_id=$id")->result();
        }
        
        function update_curr_forecast($id,$data){
            $this->db->where('trans_id', $id);
            return $this->db->update('trans_forecast', $data);
        }
        
        function get_count_forecast($storage_id,$value1,$value2){
            return $this->db->query("SELECT count(*) as total FROM trans_forecast WHERE storage_id=$storage_id AND trans_id BETWEEN $value1 AND $value2")->row()->total;
        }
        
        function get_po_status(){
			$this->db->select('*');
			$this->db->from('trans_po');
			$this->db->where('status = 5');

			$query = $this->db->get()->row();
			$result = 0;
			if(empty($query)){
				$result=null;
			}else{
				$result = $query;
			}
			return $result;
		}
		
		function update_status(){
			
			return $this->db->query("update trans_po set status=0 where status=5");
		}
		
		function last_forecast_byDate($date){
			return $this->db->query("SELECT * FROM trans_forecast WHERE trans_date='$date'")->result();
		}
		
		function cek_forecast(){
			return $this->db->query("select trans_date from trans_forecast where trans_id=1")->row();
		}
		
        function get_trans_forecast_byDate($id,$start,$end) {
		
		if($id == 1){
			$this->db->select('log_forecast_lati.*, mst_barge.barge_name');
			$this->db->from('log_forecast_lati');
			$this->db->join('mst_storage', 'log_forecast_lati.storage_id = mst_storage.storage_id');
			$this->db->join('mst_barge', 'log_forecast_lati.barge_id = mst_barge.barge_id', 'left');
			$this->db->where('mst_storage.storage_id=', $id);
			$this->db->where('log_forecast_lati.trans_date >=', $start);
			$this->db->where('log_forecast_lati.trans_date <=', $end);
			$this->db->order_by('log_forecast_lati.trans_date', 'ASC');
		}elseif($id == 2){
			$this->db->select('log_forecast_sur.*, mst_barge.barge_name');
			$this->db->from('log_forecast_sur');
			$this->db->join('mst_storage', 'log_forecast_sur.storage_id = mst_storage.storage_id');
			$this->db->join('mst_barge', 'log_forecast_sur.barge_id = mst_barge.barge_id', 'left');
			$this->db->where('mst_storage.storage_id=', $id);
			$this->db->where('log_forecast_sur.trans_date >=', $start);
			$this->db->where('log_forecast_sur.trans_date <=', $end);
			$this->db->order_by('log_forecast_sur.trans_date', 'ASC');
		}elseif($id == 3){
			$this->db->select('log_forecast_sam.*, mst_barge.barge_name');
			$this->db->from('log_forecast_sam');
			$this->db->join('mst_storage', 'log_forecast_sam.storage_id = mst_storage.storage_id');
			$this->db->join('mst_barge', 'log_forecast_sam.barge_id = mst_barge.barge_id', 'left');
			$this->db->where('mst_storage.storage_id=', $id);
			$this->db->where('log_forecast_sam.trans_date >=', $start);
			$this->db->where('log_forecast_sam.trans_date <=', $end);
			$this->db->order_by('log_forecast_sam.trans_date', 'ASC');
		}
		
		
		$query = $this->db->get();
		
		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_storage(){
			$this->db->select('storage_id,storage_code');
			$this->db->from('mst_storage');
			$this->db->order_by('storage_id', 'ASC');
			$query = $this->db->get();
			return $query->result_array();
		}

		function get_vendor_bypo($start,$end){
			$sql ="SELECT mst_storage.storage_id,mst_storage.storage_code,po.*
					FROM mst_storage
					JOIN (
					SELECT mst_vendor.vendor_id, mst_vendor.alias, SUM(quantity) AS total, trans_po.storage_id
					FROM trans_po
					JOIN mst_vendor ON trans_po.vendor_id = mst_vendor.vendor_id
					WHERE DATE_FORMAT(trans_po.posting_date, '%Y-%m-%d') BETWEEN '$start' AND '$end'
					GROUP BY alias
					) AS po on mst_storage.storage_id = po.storage_id
					ORDER by mst_storage.storage_id ASC";
			$query = $this->db->query($sql);

			return $query->result_array();
		}

		function get_transporterbypo($start,$end){
			$sql = "SELECT mst_storage.storage_id, mst_storage.storage_code,po.*
			FROM mst_storage
			JOIN (
			SELECT mst_transporter.transporter_id,mst_transporter.alias, SUM(quantity) AS total, trans_po.storage_id, trans_po.barge_id
			FROM trans_po
			JOIN mst_barge ON trans_po.barge_id = mst_barge.barge_id
			JOIN mst_transporter ON mst_barge.transporter_id = mst_transporter.transporter_id
			WHERE DATE_FORMAT(trans_po.posting_date, '%Y-%m-%d') BETWEEN '$start' AND '$end'
			GROUP BY barge_id
			) AS po on mst_storage.storage_id = po.storage_id
			ORDER by mst_storage.storage_id ASC";
			$query = $this->db->query($sql);

			return $query->result_array();
		}
}
?>