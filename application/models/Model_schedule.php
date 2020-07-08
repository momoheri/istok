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
        
        function get_sum_order_po_ByVendor($v_id, $s_id){
            $year = date('Y');
            $month = date('m');
            $min_date = date($year.'-'.$month.'-01');
            $max_date = date('Y-m-d', strtotime($min_date . "+ 30 days"));
            
            $this->db->select('SUM(quantity) AS total');
            $this->db->from('trans_po');
            $this->db->where('posting_date >=', $min_date);
            $this->db->where('posting_date <=', $max_date);
            $this->db->where('vendor_id', $v_id);
            $this->db->where('storage_id', $s_id);
            $query = $this->db->get();
            
            $result = $query->row()->total;
            return $result;
        }
        
        function get_sum_order_po_ByTransporter($t_id,$s_id){
            $year = date('Y');
            $month = date('m');
            $min_date = date($year.'-'.$month.'-01');
            $max_date = date('Y-m-d', strtotime($min_date . "+ 30 days"));
            
            $this->db->select('SUM(quantity) AS total');
            $this->db->from('trans_po');
            $this->db->where('posting_date >=', $min_date);
            $this->db->where('posting_date <=', $max_date);
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
		$this->db->select('tran_atg.volume, trans_atg.ullage, trans_atg.atg_id');
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
        
        function get_forecastmax_id($id){
            return $this->db->query("SELECT MAX(trans_id) AS max_id FROM trans_forecast WHERE storage_id = $id")->row();
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
		
		function last_forecast_byDate($date){
			return $this->db->query("SELECT * FROM trans_forecast WHERE trans_date='$date'")->result();
		}
        
        function update_curr_forecast($id,$data){
            $this->db->where('trans_id', $id);
            return $this->db->update('trans_forecast', $data);
        }
        
        function get_count_forecast($storage_id,$value1,$value2){
            return $this->db->query("SELECT count(*) as total FROM trans_forecast WHERE storage_id=$storage_id AND trans_id BETWEEN $value1 AND $value2")->row()->total;
        }
        
        //16-06-2020
        function update_log_forecast($id,$data){
            $this->db->where('storage_id',$id);
            return $this->db->insert('log_trans_forecast', $data);
        }
        
        function get_log_last_forecast($id_storage){
            return $this->db->query("select min(trans_id) as id from trans_forecast where storage_id=$id_storage")->row()->id;
        }
        
        function get_data_log_forecast($storage_id){
            $trans_id = $this->db->query("select min(trans_id) as id from trans_forecast where storage_id=$storage_id")->row()->id;
            return $this->db->query("select * from trans_forecast where trans_id=$trans_id")->result();
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
}?>