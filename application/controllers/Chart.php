<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','html'));
		$this->load->library('session');
		$this->load->database();
		$this->load->model('Model_monitoring');
		$this->load->model('Model_supply');

    if ($this->session->userdata('login') == TRUE) {
			if ($this->session->userdata('login_app') <> 'istok') {
				$this->session->sess_destroy();
				redirect('login');
			}
		} else {
			$this->session->sess_destroy();
			redirect('login');
		}
	}
	
	public function index()	{
		echo 'chart';
	}
	
	public function fuel_receiving()	{
		$p_period = $this->input->get('p_period');
		
		if ($p_period == 'daily' || empty($p_period)) {
			$tgl = $this->input->get('p_period_sub_date');
			$tanggal_dari = (empty($tgl))? date('Y-m-d') : $tgl;
			$tanggal_sampai = $tanggal_dari;
		}
		if ($p_period == 'monthly') {
			$tahun = $this->input->get('p_year');
			$bulan = substr(('0' .$this->input->get('p_period_sub_month')),-2);
			
			$tanggal_dari = ($tahun .'-'. $bulan .'-01');
			$tanggal_sampai = date('Y-m-t', strtotime($tanggal_dari));
		}
		if ($p_period == 'quarterly') {
			$tahun = $this->input->get('p_year');
			
			if ($this->input->get('p_period_sub_quarter')=='q1') {
				$bulan1 = '01';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '03';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q2') {
				$bulan1 = '04';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '06';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q3') {
				$bulan1 = '07';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '09';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q4') {
				$bulan1 = '10';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '12';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
		}
		if ($p_period == 'yearly') {
			$tahun = $this->input->get('p_year');
			
			$tanggal_dari = ($tahun .'-01-01');
			$tanggal_sampai = ($tahun .'-12-31');
		}
		$start = $tanggal_dari;
		$end = $tanggal_sampai;
		
		$vendor = $this->Model_monitoring->get_vendor();
		$fuel = $this->Model_monitoring->fuel_receiving_with_transporter($start, $end);
		
		$temp_item = $this->_group_by($fuel, 'id_transporter');
		$feul_item = array();
		foreach($temp_item as $items) {
			$quantity = array();
			foreach($items as $item) {
				$index = $this->find_by('vendor_id', $quantity, $item['vendor_id']);
				if ($index < 0) {
						$quantity[] = $item;
				}
				else {
						$quantity[$index]['quantity'] +=  $item['quantity'];
				}
			}			
			$feul_item[$items[0]['id_transporter']] = $quantity;
		}
		$data_vendor = array();
		foreach($vendor as $data){
			$vendor_id[$data['vendor_id']] = 0;
			$data_vendor[] = "'".$data['vendor_name']."'";
		}
		$res['vendor'] = implode('|', $data_vendor);
		
		$res['chart'] = array();
		$data_quantity = array();
		$i = 0;
		foreach($feul_item as $items){
			$quantity = $vendor_id;
			foreach($items as $item){
				if(!empty($item['vendor_id']) && $item['vendor_id'] !=''){
					$quantity[$item['vendor_id']] = $item['quantity'];
				}
			}
			$res['chart'][$i] = $items[0];
			$res['chart'][$i]['quantity'] = implode(',', $quantity);
			$i++;
		}
		
		echo json_encode($res);
	}
	
	/*------------------------------------------------------------------------------*/
	
	public function vendor_performance()	{
		$p_period = $this->input->get('p_period');
		
		if ($p_period == 'daily' || empty($p_period)) {
			$tgl = $this->input->get('p_period_sub_date');
			$tanggal_dari = (empty($tgl))? date('Y-m-d') : $tgl;
			$tanggal_sampai = $tanggal_dari;
		}
		if ($p_period == 'monthly') {
			$tahun = $this->input->get('p_year');
			$bulan = substr(('0' .$this->input->get('p_period_sub_month')),-2);
			
			$tanggal_dari = ($tahun .'-'. $bulan .'-01');
			$tanggal_sampai = date('Y-m-t', strtotime($tanggal_dari));
		}
		if ($p_period == 'quarterly') {
			$tahun = $this->input->get('p_year');
			if ($this->input->get('p_period_sub_quarter')=='q1') {
				$bulan1 = '01';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '03';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q2') {
				$bulan1 = '04';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '06';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q3') {
				$bulan1 = '07';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '09';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q4') {
				$bulan1 = '10';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '12';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
		}
		if ($p_period == 'yearly') {
			$tahun = $this->input->get('p_year');
			
			$tanggal_dari = ($tahun .'-01-01');
			$tanggal_sampai = ($tahun .'-12-31');
		}
		$start = $tanggal_dari;
		$end = $tanggal_sampai;
		
		$vendor = $this->Model_monitoring->get_vendor();
		$performance = $this->Model_monitoring->get_performance();
		$vendor_performance = $this->Model_supply->get_vendor_performance($start, $end);		
		$temp_item = $this->_group_by($vendor_performance, 'movement_reason_id');
		
		$data_vendor = array();
		$array_color = array('blue', 'orage', 'grey', 'yellow', 'green', 'red',"Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","DarkOrange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen");
		foreach($vendor as $data){
			$vendor_id[$data['vendor_id']] = 0;
			$data_vendor[] = "'".$data['vendor_name']."'";
		}
		$res['vendor'] = implode('|', $data_vendor);
		
		
		$res['chart'] = array();
		$data_quantity = array();
		$i = 0;
		foreach($temp_item as $items){
			$total = $vendor_id;
			foreach($items as $item){
				if(!empty($item['vendor_id']) && $item['vendor_id'] !=''){
					$total[$item['vendor_id']] = $item['total'];
				}
			}
			$res['chart'][$i] = $items[0];
			$res['chart'][$i]['color'] = $array_color[$i];
			$res['chart'][$i]['total'] = implode(',', $total);
			$i++;
		}
				
		echo json_encode($res);
	}
	
	/*------------------------------------------------------------------------------*/
	
	public function transporter_performance()	{
		$p_period = $this->input->get('p_period');
		
		if ($p_period == 'daily' || empty($p_period)) {
			$tgl = $this->input->get('p_period_sub_date');
			$tanggal_dari = (empty($tgl))? date('Y-m-d') : $tgl;
			$tanggal_sampai = $tanggal_dari;
		}
		if ($p_period == 'monthly') {
			$tahun = $this->input->get('p_year');
			$bulan = substr(('0' .$this->input->get('p_period_sub_month')),-2);
			
			$tanggal_dari = ($tahun .'-'. $bulan .'-01');
			$tanggal_sampai = date('Y-m-t', strtotime($tanggal_dari));
		}
		if ($p_period == 'quarterly') {
			$tahun = $this->input->get('p_year');
			if ($this->input->get('p_period_sub_quarter')=='q1') {
				$bulan1 = '01';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '03';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q2') {
				$bulan1 = '04';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '06';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q3') {
				$bulan1 = '07';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '09';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q4') {
				$bulan1 = '10';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '12';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
		}
		if ($p_period == 'yearly') {
			$tahun = $this->input->get('p_year');
			
			$tanggal_dari = ($tahun .'-01-01');
			$tanggal_sampai = ($tahun .'-12-31');
		}
		$start = $tanggal_dari;
		$end = $tanggal_sampai;
		
		$transporter = $this->Model_monitoring->get_transporter();
		$performance = $this->Model_monitoring->get_performance();
		$vendor_performance = $this->Model_supply->get_transporter_performance($start, $end);		
		$temp_item = $this->_group_by($vendor_performance, 'movement_reason_id');
		
		$data_vendor = array();
		$array_color = array('blue', 'orage', 'grey', 'yellow', 'green', 'red',"Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","DarkOrange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen");
		foreach($transporter as $data){
			$transporter_id[$data['transporter_id']] = 0;
			$data_transporter[] = "'".$data['transporter_name']."'";
		}
		$res['transporter'] = implode('|', $data_transporter);
		
		
		$res['chart'] = array();
		$data_quantity = array();
		$i = 0;
		foreach($temp_item as $items){
			$total = $transporter_id;
			foreach($items as $item){
				if(!empty($item['transporter_id']) && $item['transporter_id'] !=''){
					$total[$item['transporter_id']] = $item['total'];
				}
			}
			$res['chart'][$i] = $items[0];
			$res['chart'][$i]['color'] = $array_color[$i];
			$res['chart'][$i]['total'] = implode(',', $total);
			$i++;
		}
				
		echo json_encode($res);
	}
	
	/*------------------------------------------------------------------------------*/
	
	public function getColor($num) {
		$hash = md5('color' . $num); // modify 'color' to get a different palette
		return array(
			hexdec(substr($hash, 0, 2)), // r
			hexdec(substr($hash, 2, 2)), // g
			hexdec(substr($hash, 4, 2))); //b
	}	

	function _group_by($array, $key) {
    $return = array();
    foreach($array as $val) {
			$index = (empty($val[$key]))? 0 : $val[$key];	
      $return[$index][] = $val;
    }
    return $return;
	}
	
	function find_by($key, $array, $search) {
    $result = -1;
		if(!empty($search) && $search != ''){
			for($i=0; $i<sizeof($array); $i++) {
					if ($array[$i][$key] == $search) {
							$result = $i;
							break;
					}
			}
		}
    return $result;
	}
}
