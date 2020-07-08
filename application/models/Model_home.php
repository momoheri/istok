<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_home extends CI_Model {
	function __construct()
    {
        parent::__construct();
		$this->load->database();
    }

    function get_max_trans_atg(){}
	function get_trans_atg($id) {
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
            date_default_timezone_set('Asia/Bangkok');
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

	function get_alarm($id){
	    $this->db->select('*');
	    $this->db->from('trans_alarm');
	    $this->db->where('atg_id=', $id);
	    $this->db->where('alarm_status=0');
	    $query = $this->db->get();

	    if($query->num_rows() > 0){
	        return true;
        } else {
	        return false;
        }

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
		$y = date('Y-m-%');
		/*$m = date('m');
		$this->db->select('trans_po.*','min(posting_date) as tanggal_eta');
		$this->db->select('trans_po.*');
		$this->db->from('trans_po');
		$this->db->join('mst_storage', 'trans_po.storage_id = mst_storage.storage_id');
		$this->db->where('trans_po.storage_id=', $id);
		$this->db->where('trans_po.posting_date LIKE', $y);
		$this->db->limit(1);
		$query = $this->db->get();

		$result = array();
		if($query->num_rows() > 0) {
			$result = $query->result();
		}*/
		return $this->db->query("SELECT `trans_po`.*, min(posting_date) as tanggal_eta FROM `trans_po` 
		JOIN `mst_storage` ON `trans_po`.`storage_id` = `mst_storage`.`storage_id` 
		WHERE `trans_po`.`storage_id` = '1' 
		AND posting_date LIKE '$y'")->result();
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

	function get_atg($id){
	    $this->db->select('*');
	    $this->db->from('mst_atg');
	    $this->db->where('atg_id=', $id);
	    $query = $this->db->get();

	    $result = array();
	    if($query->num_rows() > 0){
	        $result = $query->result();
        }
	    return $result;
    }

	function insert_atg($data){
		return $this->db->insert('trans_atg', $data);
	}

	function updateManual($data,$id){
	    $this->db->where('atg_id', $id);
	    $this->db->where('trans_status', 0);
	    return $this->db->update('trans_sounding_manual', $data);
    }

	function insert_manual($data){
	    return $this->db->insert('trans_sounding_manual', $data);
    }

		function updateManual2($id,$data){
			$this->db->where('atg_id', $id);
			$this->db->where('manual_type', 1);
			return $this->db->update('trans_sounding_manual', $data);
		}

		function getAlarmActive(){
			$this->db->select('*');
			$this->db->from('trans_alarm');
			$query = $this->db->get();

			$result = array();
			if($query->num_rows() > 0){
				$result = $query->result();
			}

			return $result;
		}
        function get_all_new_forecast($storage_id){
                date_default_timezone_set('Asia/Jakarta');
		$tanggal = date('Y-m-d');
                
                    $min_id = $this->db->query("select min(trans_id) as min_id from trans_forecast where storage_id = $storage_id")->row()->min_id;
                    $max_id = $this->db->query("select max(trans_id) as max_id from trans_forecast where storage_id = $storage_id")->row()->max_id;
                    $sql = "select * from trans_forecast where trans_id between $min_id and $max_id";
                
                return $this->db->query($sql)->result();
        }
        
        
        function get_forecast($storage_id){
            return $this->db->query("select trans_date,inventory,distribution,eta_schedule,barge_id,po_res_number,storage_id FROM trans_forecast
                            where trans_forecast.storage_id=$storage_id")->result();
        }
                function insert_log($storage_id,$data){
                    if($storage_id == 1){
                        
                        return $this->db->insert('log_forecast_lati',$data);
                             
                    } elseif ($storage_id == 2){
                        return $this->db->insert('log_forecast_sur',$data);
                    } elseif ($storage_id == 3) {
                        return $this->db->insert('log_forecast_sur',$data);
                    }
                    //return $this->db->query($sql);
                }
                
                function update_log($storage_id,$trans_date,$data){
                    if($storage_id == 1){
                        $update = 'log_forecast_lati';
                    } elseif ($storage_id == 2) {
                        $update = 'log_forecast_sur';
                    } elseif ($storage_id == 3) {
                        $update = 'log_forecast_sam';
                    }
                    $this->db->where('trans_date', $trans_date);
                    return $this->db->update($update, $data);
                }
                
                function forecast_is_exist($storage_id,$date){
                    $result = true;
                    if($storage_id == 1){
                        $sql = "select * from log_forecast_lati where trans_date = '$date'";
                    } elseif ($storage_id == 2) {
                        $sql = "select * from log_forecast_sur where trans_date = '$date'";
                    } elseif ($storage_id == 3) {
                        $sql = "select * from log_forecast_sam where trans_date = '$date'";
                    }
                    $query = $this->db->query($sql)->result();
                    if($query != 0){
                        $result = false;
                    } else {
                        $result = true;
                    }
                    
                    return $result;
                }
}
?>
