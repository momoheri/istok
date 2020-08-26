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
		date_default_timezone_set('Asia/Jakarta');
		$time = date('H',strtotime("+1 hour"));
		$date = date('Y-m-d');

		
		return $this->db->query("SELECT `trans_atg`.`trans_id`, `mst_atg`.`atg_name`, `mst_atg`.`atg_id`, `trans_atg`.`trans_date`,
                    `trans_atg`.`trans_time`, `trans_atg`.`tankno`, `trans_atg`.`volume`, `trans_atg`.`ullage`,tr_manual.qty_observe
                    FROM `trans_atg`
                    left join (select atg_id,qty_observe from trans_sounding_manual where trans_status=0)as tr_manual on tr_manual.atg_id = trans_atg.atg_id
                    JOIN `mst_atg` ON `trans_atg`.`atg_id` = `mst_atg`.`atg_id` 
                    JOIN `mst_storage` ON `mst_atg`.`storage_id` = `mst_storage`.`storage_id` 
                    WHERE `mst_storage`.`storage_id` = '$id' 
                    AND `trans_atg`.`trans_date` = '$date' 
                    AND trans_atg.trans_time LIKE '$time:%:%' 
                    GROUP BY `trans_atg`.`atg_id` 
                    ORDER BY `trans_atg`.`trans_date` DESC, 
                    `trans_atg`.`trans_time` DESC")->result();
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
	$date = date('Y-m-d');

	$this->db->select('max(trans_date) AS max_date');
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
				WHERE mst_storage.storage_id = '$id' AND trans_atg.trans_date LIKE '$max_date'
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
		$y = date('Y-m-d');
		/*$m = date('m');
		$this->db->select('trans_po.*','min(posting_date) as tanggal_eta');
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
		WHERE `trans_po`.`storage_id` = '$id' 
		AND posting_date >= '$y'")->result();
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
}
?>
