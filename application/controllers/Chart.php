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
		$array_color = array('blue', 'orange', 'grey', 'yellow', 'green', 'red',"Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","DarkOrange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen");
		
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
			$data_vendor[] = $data['vendor_name'];
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
			$res['chart'][$i]['color'] = $array_color[$i];
			$res['chart'][$i]['quantity'] = implode(',', $quantity);
			$i++;
		}
		
		echo json_encode($res);
	}
	
	/*----------------------------------------------------------------------*/
	
	public function fuel_positive()	{
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
		
		$fuel = $this->Model_monitoring->get_fuel_positive($start, $end);
		$array_color = array('blue', 'orange', 'grey', 'yellow', 'green', 'red',"Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","DarkOrange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen");
		
		
		$res = array();
		$temp = array();
		$i = 0;
		foreach($fuel as $item){
			$temp['storage'][$i] = $item['storage_name'];
			$temp['color'][$i] = $array_color[$i];
			$temp['fuel'][$i] = round($item['volume'] - $item['tc_vol']);
			$i++;
		}
		$res['storage'] = implode(',', $temp['storage']);
		$res['color'] = implode(',', $temp['color']);
		$res['fuel'] = implode(',', $temp['fuel']);
		echo json_encode($res);
	}
	
	/*------------------------------------------------------------------------------*/
	
	public function fuel_distribution_to_mining()	{
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
		
		$storage = $this->Model_monitoring->get_storage();
		$description = $this->Model_monitoring->get_description_sap_mining();
		$fuel = $this->Model_monitoring->get_fuel_distribution_to_mining($start, $end);
		$array_color = array('blue', 'orange', 'grey', 'yellow', 'green', 'red',"Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","DarkOrange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen");
		
		$temp_item = $this->_group_by($fuel, 'description');
		$feul_item = array();
		foreach($temp_item as $items) {
			$quantity = array();
			foreach($items as $item) {
				$index = $this->find_by('storage_id', $quantity, $item['storage_id']);
				if ($index < 0) {
						$quantity[] = $item;
				}
				else {
						$quantity[$index]['Volume'] +=  $item['Volume'];
				}
			}			
			$feul_item[$items[0]['description']] = $quantity;
		}
		
		$data_storage = array();
		foreach($storage as $data){
			$vendor_id[$data['storage_id']] = 0;
			$data_storage[] = $data['storage_name'];
		}
		$res['storage'] = implode('|', $data_storage);
		
		$res['chart'] = array();
		$res['chart'] = array();
		$data_quantity = array();
		$i = 0;
		foreach($feul_item as $items){
			$quantity = $vendor_id;
			foreach($items as $item){
				if(!empty($item['storage_id']) && $item['storage_id'] !=''){
					$quantity[$item['storage_id']] = $item['Volume'];
				}
			}
			$res['chart'][$i] = $items[0];
			$res['chart'][$i]['color'] = $array_color[$i];
			$res['chart'][$i]['quantity'] = implode(',', $quantity);
			$i++;
		}
		
		foreach($description as $storage_data){	
				$index = $this->find_by('description', $res['chart'], $storage_data['description']);
				if($index < 0){
					$list['CreatedDate'] = '';  
					$list['color'] =  $array_color[$i];
					$list['quantity'] =  implode(',', $vendor_id);
					$res['chart'][$i] = $list;
					$i++;
				}
		}
		
		echo json_encode($res);
	}
	
	/*------------------------------------------------------------------------------*/
	
	public function fuel_negative()	{		
		$tahun = $this->input->get('p_year');
		
		$tanggal_dari = ($tahun .'-01-01');
		$tanggal_sampai = ($tahun .'-12-31');
		
		$start = $tanggal_dari;
		$end = $tanggal_sampai;
		
		$quarter = array(0=>'Q1',1=>'Q2',2=>'Q3',3=>'Q4');
		$storage = $this->Model_monitoring->get_storage();
		$fuel = $this->Model_monitoring->get_fuel_negative($start, $end);
		$array_color = array('blue', 'orange', 'grey', 'yellow', 'green', 'red',"Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","DarkOrange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen");
		
		$temp_item = $this->_group_by($fuel, 'storage_id');
		$feul_item = array();
		foreach($temp_item as $items) {
			$quantity = array();
			foreach($items as $item) {
				$index = $this->find_by('quarter', $quantity, $item['quarter']);
				if ($index < 0 ) {
						$quantity[] = $item;
				}
				else{
						$quantity[$index]['manual_surveyor'] +=  $item['manual_surveyor'];
						$quantity[$index]['vol_atg'] +=  $item['vol_atg'];
				}
			}			
			$feul_item[$items[0]['storage_id']] = $quantity;
		}
		
		$data_quarter = array();
		foreach($quarter as $data){
			$vendor_id[$data] = 0;
			$data_quarter[] = $data;
		}
		$res['quarter'] = implode('|', $data_quarter);
		
		$res['chart'] = array();
		$res['chart'] = array();
		$data_quantity = array();
		$i = 0;
		foreach($feul_item as $items){
			$quantity = $vendor_id;
			foreach($items as $item){
				if(!empty($item['quarter']) && $item['quarter'] !=''){
					$quantity[$item['quarter']] = round($item['manual_surveyor'] - $item['vol_atg']);
				}
			}
			$res['chart'][$i] = $items[0];
			$res['chart'][$i]['color'] = $array_color[$i];
			$res['chart'][$i]['quantity'] = implode(',', $quantity);
			$i++;
		}
		
		foreach($storage as $key => $item){	
				$index = $this->find_by('storage_id', $res['chart'], $item['storage_id']);
				if($index < 0){
					$list['CreatedDate'] = ''; 
					$list['storage_id'] = $item['storage_id']; 
					$list['storage'] = $item['storage_name']; 
					$list['color'] =  $array_color[$i];
					$list['quantity'] =  implode(',', $vendor_id);
					$res['chart'][$i] = $list;
					$i++;
				}else{
					$res['chart'][$index]['storage_id'] =$item['storage_id'];
					$res['chart'][$index]['storage'] =$item['storage_name'];
				}
		}
		$items_sort = $res['chart'];
		$result = array_column($items_sort, 'storage_id');

		array_multisort($result, SORT_ASC, $items_sort);
		$res['chart'] = $items_sort;
		echo json_encode($res);
	}
	
	function array_msort($array, $cols)
{
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\''.$col.'\'],'.$order.',';
    }
    $eval = substr($eval,0,-1).');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k,1);
            if (!isset($ret[$k])) $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    return $ret;

}
	/*------------------------------------------------------------------------------*/
	
	public function fuel_distribution_base_on_activity()	{
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
		
		$storage = $this->Model_monitoring->get_storage();
		$movement = $this->Model_monitoring->get_movement();
		$fuel = $this->Model_monitoring->get_fuel_distribution_on_activity($start, $end);
		$array_color = array('blue', 'orange', 'grey', 'yellow', 'green', 'red',"Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","DarkOrange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen");
		
		$temp_item = $this->_group_by($fuel, 'storage_id');
		$feul_item = array();
		foreach($temp_item as $items) {
			$quantity = array();
			foreach($items as $item) {
				$index = $this->find_by('movement', $quantity, $item['movement']);
				if ($index < 0) {
						$quantity[] = $item;
				}
				else {
						$quantity[$index]['Volume'] +=  $item['Volume'];
				}
			}			
			$feul_item[$items[0]['storage_id']] = $quantity;
		}
		
		$data_movement = array();
		foreach($movement as $data){
			$vendor_id[$data['movement']] = 0;
			$data_movement[] = $data['movement'];
		}
		$res['movement'] = implode('|', $data_movement);
		
		$res['chart'] = array();
		$res['chart'] = array();
		$data_quantity = array();
		$i = 0;
		foreach($feul_item as $items){
			$quantity = $vendor_id;
			foreach($items as $item){
				if(!empty($item['movement']) && $item['movement'] !=''){
					$quantity[$item['movement']] = $item['Volume'];
				}
			}
			$res['chart'][$i] = $items[0];
			$res['chart'][$i]['color'] = $array_color[$i];
			$res['chart'][$i]['quantity'] = implode(',', $quantity);
			$i++;
		}
		
		foreach($storage as $storage_data){	
				$index = $this->find_by('storage_id', $res['chart'], $storage_data['storage_id']);
				if($index < 0){
					$list['CreatedDate'] = ''; 
					$list['storage_name'] = $storage_data['storage_name']; 
					$list['color'] =  $array_color[$i];
					$list['quantity'] =  implode(',', $vendor_id);
					$res['chart'][$i] = $list;
					$i++;
				}
		}
		
		echo json_encode($res);
	}
	
	/*------------------------------------------------------------------------------*/
	
	public function purchase_order_to_vendor()	{
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
		$fuel = $this->Model_monitoring->get_purchase_order_to_vendor($start, $end);
		$array_color = array('blue', 'orange', 'grey', 'yellow', 'green', 'red',"Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","DarkOrange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen");
		
		$temp_item = $this->_group_by($fuel, 'storage_id');
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
			$feul_item[$items[0]['storage_id']] = $quantity;
		}
		
		$data_vendor = array();
		foreach($vendor as $data){
			$vendor_id[$data['vendor_id']] = 0;
			$data_vendor[] = $data['vendor_name'];
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
			$res['chart'][$i]['color'] = $array_color[$i];
			$res['chart'][$i]['quantity'] = implode(',', $quantity);
			$i++;
		}
		
		echo json_encode($res);
	}
	
	/*------------------------------------------------------------------------------*/
	
	public function vendor_performance()	{
		$p_period = $this->input->get('p_period');
		
		if ($p_period == 'daily') {
			$tgl = $this->input->get('p_period_sub_date');
			$tanggal_dari = (empty($tgl))? date('Y-m-d') : $tgl;
			$tanggal_sampai = $tanggal_dari;
		}
		if ($p_period == 'monthly'|| empty($p_period)) {
			$tahun = $this->input->get('p_year');
			$tahun = (empty($tahun))? date('Y') : $tahun;
			$bulan = $this->input->get('p_period_sub_month');
			$bulan = (empty($bulan))? date('n') : $bulan;
			$bulan = substr(('0' .$bulan),-2);
			
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
		$array_color = array('blue', 'orange', 'grey', 'yellow', 'green', 'red',"Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","DarkOrange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen");
		foreach($vendor as $data){
			$vendor_id[$data['vendor_id']] = 0;
			$data_vendor[] = $data['vendor_name'];
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
		
		if ($p_period == 'daily') {
			$tgl = $this->input->get('p_period_sub_date');
			$tanggal_dari = (empty($tgl))? date('Y-m-d') : $tgl;
			$tanggal_sampai = $tanggal_dari;
		}
		if ($p_period == 'monthly' || empty($p_period)) {
			$tahun = $this->input->get('p_year');
			$tahun = (empty($tahun))? date('Y') : $tahun;
			$bulan = $this->input->get('p_period_sub_month');
			$bulan = (empty($bulan))? date('n') : $bulan;
			$bulan = substr(('0' .$bulan),-2);
			
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
		$array_color = array('blue', 'orange', 'grey', 'yellow', 'green', 'red',"Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","DarkOrange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen");
		foreach($transporter as $data){
			$transporter_id[$data['transporter_id']] = 0;
			$data_transporter[] = $data['transporter_name'];
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
	
	public function fuel_price_by_history ()	{
		$p_period = $this->input->get('p_period');
		$label_type = 'month';
		if ($p_period == 'daily') {
			$label_type = 'day';
			$tgl = $this->input->get('p_period_sub_date');
			$tanggal_dari = (empty($tgl))? date('Y-m-d') : $tgl;
			$tanggal_sampai = $tanggal_dari;
		}
		if ($p_period == 'monthly' || empty($p_period)) {
			$label_type = 'day';
			$tahun = $this->input->get('p_year');
			$tahun = (empty($tahun))? date('Y') : $tahun;
			$bulan = $this->input->get('p_period_sub_month');
			$bulan = (empty($bulan))? date('n') : $bulan;
			$bulan = substr(('0' .$bulan),-2);
			
			$tanggal_dari = ($tahun .'-'. $bulan .'-01');
			$tanggal_sampai = date('Y-m-t', strtotime($tanggal_dari));
		}
		if ($p_period == 'quarterly') {
			$tahun = $this->input->get('p_year');
			if ($this->input->get('p_period_sub_quarter')=='q1') {
				$label_type = 'quarterly';
				$bulan1 = '01';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '03';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q2') {				
				$label_type = 'quarterly';
				$bulan1 = '04';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '06';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q3') {
				$label_type = 'quarterly';
				$bulan1 = '07';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '09';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q4') {
				$label_type = 'quarterly';
				$bulan1 = '10';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '12';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
		}
		if ($p_period == 'yearly') {
				$label_type = 'month';
			$tahun = $this->input->get('p_year');
			
			$tanggal_dari = ($tahun .'-01-01');
			$tanggal_sampai = ($tahun .'-12-31');
		}
		$start = $tanggal_dari;
		$end = $tanggal_sampai;
				
		$vendor = $this->Model_monitoring->get_vendor();
		$fuel_price 	= $this->Model_monitoring->get_fuel_price($start, $end, $label_type);
		$array_color = array('blue', 'orange', 'grey', 'yellow', 'green', 'red',"Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","DarkOrange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen");
		
		
		if($label_type == 'month'){
			$x = 0;
			while($x++ < 12) {
				$MonthNumbers[] = $x;
			}

			foreach ($MonthNumbers as $MonthNumber) {
				$mon = $MonthNumber-1;
				$monmin = $MonthNumber-2;
				$months[] = date("F", strtotime("+".$mon."month",strtotime('2020-01-01')));
				$months_before[] = date("F", strtotime("+".$monmin."month",strtotime('2020-01-01')));
			}
		}elseif($label_type == 'quarterly'){
			$start = date("n", strtotime($tanggal_dari));
			$end = date("n", strtotime($tanggal_sampai));
			$x = $start-1;
			while($x++ < $end) {
				$MonthNumbers[] = $x;
			}
			foreach ($MonthNumbers as $MonthNumber) {
				$mon = $MonthNumber-1;
				$months[] = date("F", strtotime("+".$mon."month",strtotime('2020-01-01')));
			}
		}elseif($label_type == 'day'){
			$start = $tanggal_dari;
			$end = $tanggal_sampai;
			while(strtotime($start) <= strtotime($end)) {
				$months[] = $start;
				$start = date ("Y-m-d", strtotime("+1 day", strtotime($start)));
			}
		}
		$temp_item = $this->_group_by($fuel_price, 'vendor_id');
		
		$data_vendor = array();
		$i=0;
		foreach($vendor as $data){
			if(isset($temp_item[$data['vendor_id']])){				
				$data_vendor[$i]['name'] = $data['vendor_name'];
				$data_vendor[$i]['data'] = $temp_item[$data['vendor_id']];
			}else{
				$data_vendor[$i]['name'] = $data['vendor_name'];
				$data_vendor[$i]['data'] = array();
			}
			$i++;
		}
		
		$label = array();
		$average = array();		
		$total = array();
		$i=0;
		foreach($months as $item){
			$label[$i] = $item;			
			$i++;				
		}
		$n=0;
		foreach($data_vendor as $item_vendor){
			$temp_data[$n]['vendor_name'] = $item_vendor['name'];
			$i=0;
			foreach($months as $item){
				$index = $this->find_by('posting_date', $item_vendor['data'], $item);
				$temp_data[$n]['posting_date'][$i] = $item;
				if($index >= 0){
					$temp_data[$n]['price'][$i] = $item_vendor['data'][$index]['price'];
				}else{
					$temp_data[$n]['price'][$i] = 0;
				}	
				if(!isset($total[$item])){
					$total[$item] = 0;
				}
				$total[$item] = $total[$item] + $temp_data[$n]['price'][$i];
				$i++;				
			}
			$n++;			
		}
		$total_vendor = count($data_vendor);
		foreach($total as $item){
			$average[] = ($item/$total_vendor);
		}
		
		$res['chart'] = array();
		$res['chart_fill'] = array();
		$res['labels'] = implode(',', $label);
		$i=0;
		foreach($temp_data as $chart){
			$res['chart'][$i]['label'] = $chart['vendor_name'];
			$res['chart'][$i]['datas'] = implode(',', $chart['price']);
			$res['chart'][$i]['color'] = $array_color[$i];	
			$i++;
		}
		$res['chart_fill'][1]['label'] = 'Average Price';
		$res['chart_fill'][1]['datas'] = implode(',', $average);
		$res['chart_fill'][1]['color'] = 'ForestGreen';
		echo json_encode($res);
	}
	
	/*------------------------------------------------------------------------------*/
	public function inventory_performance($storage_id)	{
		$p_period = $this->input->get('p_period');
		$label_type = 'month';
		if ($p_period == 'daily') {
			$label_type = 'day';
			$tgl = $this->input->get('p_period_sub_date');
			$tanggal_dari = (empty($tgl))? date('Y-m-d') : $tgl;
			$tanggal_sampai = $tanggal_dari;
		}
		if ($p_period == 'monthly' || empty($p_period)) {
			$label_type = 'day';
			$tahun = $this->input->get('p_year');
			$tahun = (empty($tahun))? date('Y') : $tahun;
			$bulan = $this->input->get('p_period_sub_month');
			$bulan = (empty($bulan))? date('n') : $bulan;
			$bulan = substr(('0' .$bulan),-2);
			
			$tanggal_dari = ($tahun .'-'. $bulan .'-01');
			$tanggal_sampai = date('Y-m-t', strtotime($tanggal_dari));
		}
		if ($p_period == 'quarterly') {
			$tahun = $this->input->get('p_year');
			if ($this->input->get('p_period_sub_quarter')=='q1') {
				$label_type = 'quarterly';
				$bulan1 = '01';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '03';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q2') {				
				$label_type = 'quarterly';
				$bulan1 = '04';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '06';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q3') {
				$label_type = 'quarterly';
				$bulan1 = '07';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '09';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q4') {
				$label_type = 'quarterly';
				$bulan1 = '10';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '12';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
		}
		if ($p_period == 'yearly') {
				$label_type = 'month';
			$tahun = $this->input->get('p_year');
			
			$tanggal_dari = ($tahun .'-01-01');
			$tanggal_sampai = ($tahun .'-12-31');
		}
		$start = $tanggal_dari;
		$end = $tanggal_sampai;
		
		$inventory_performance 	= $this->Model_supply->get_inventory_performance_new($storage_id,$start, $end, $label_type);
		$forecast 							= $this->Model_supply->get_forecast($storage_id,$start, $end, $label_type);
		
		if($label_type == 'month'){
			$x = 0;
			while($x++ < 12) {
				$MonthNumbers[] = $x;
			}

			foreach ($MonthNumbers as $MonthNumber) {
				$mon = $MonthNumber-1;
				$monmin = $MonthNumber-2;
				$months[] = date("F", strtotime("+".$mon."month",strtotime('2020-01-01')));
				$months_before[] = date("F", strtotime("+".$monmin."month",strtotime('2020-01-01')));
			}
		}elseif($label_type == 'quarterly'){
			$start = date("n", strtotime($tanggal_dari));
			$end = date("n", strtotime($tanggal_sampai));
			$x = $start-1;
			while($x++ < $end) {
				$MonthNumbers[] = $x;
			}
			foreach ($MonthNumbers as $MonthNumber) {
				$mon = $MonthNumber-1;
				$monmin = $MonthNumber-2;
				$months[] = date("F", strtotime("+".$mon."month",strtotime('2020-01-01')));
				$months_before[] = date("F", strtotime("+".$monmin."month",strtotime('2020-01-01')));
			}
		}elseif($label_type == 'day'){
			$start = $tanggal_dari;
			$end = $tanggal_sampai;
			while(strtotime($start) <= strtotime($end)) {
				$months[] = $start;
				$start = date ("Y-m-d", strtotime("+1 day", strtotime($start)));
				$months_before[] = date ("Y-m-d", strtotime("-2 day", strtotime($start)));
			}
		}
		
		foreach ($inventory_performance as $inventory) {
			$data[$inventory['month_date']]['average'] = $inventory['vol'] + $inventory['qty_observe']; 
		}
		
		foreach ($forecast as $item_forecast) {
			$data[$item_forecast['trans_date']]['forecast'] = $item_forecast['inventory']; 
		}
		$parameters = $this->Model_supply->get_parameters($storage_id);
		foreach ($parameters as $inventory) {  
			$data[1]['maximal'] = $inventory['maximal']; 
			$data[1]['minimum'] = $inventory['minimum']; 
			$data[1]['safety'] = $inventory['safety']; 
		}
		$label = array();
		$average = array();
		$data_forecast = array();
		$maximal = array();
		$minimum = array();
		$safety = array();
		$temp_average = 0;
		$i=0;
		foreach($months as $item){
			if(isset($data[$item])){
				$label[$i] = $item;
				if(isset($data[$item]['average'])){
					$average[$i] = $data[$item]['average'];
					$temp_average = $data[$item]['average'];
				}elseif(isset($data[$item]['forecast'])){
					if(isset($data[$months_before[$i]]['forecast']) && !empty($data[$months_before[$i]]['forecast']) && $temp_average > 0){
						$average[$i] = ($temp_average-$data[$months_before[$i]]['forecast'])+$data[$item]['forecast'];
						$temp_average = $average[$i];
					}else{
						$temp_average = $data[$item]['forecast'];
						$average[$i] = $data[$item]['forecast'];
					}
					
				}else{
					$average[$i] = 0;
				}
				$data_forecast[$i] = (isset($data[$item]['forecast']))? $data[$item]['forecast'] : 0;
			}else{
				$label[$i] = $item;
				$average[$i] = 0;
				$data_forecast[$i] = 0;
			}	
			$maximal[$i] = $data[1]['maximal'];
			$minimum[$i] = $data[1]['minimum'];
			$safety[$i] = $data[1]['safety'];
			$i++;
		}
		
		$res['chart'] = array();
		$res['chart_fill'] = array();
		$res['labels'] = implode(',', $label);
		$res['chart'][0]['label'] = 'Status Stock';
		$res['chart'][0]['datas'] = implode(',', $average);
		$res['chart'][0]['color'] = 'orange';
		$res['chart'][1]['label'] = 'Forecast';
		$res['chart'][1]['datas'] = implode(',', $data_forecast);
		$res['chart'][1]['color'] = '#0080ff';
		$res['chart_fill'][1]['label'] = 'Stock Max';
		$res['chart_fill'][1]['datas'] = implode(',', $maximal);
		$res['chart_fill'][1]['color'] = '#90EE90';
		$res['chart_fill'][1]['fill'] = '3';
		$res['chart_fill'][2]['label'] = 'Stock Min';
		$res['chart_fill'][2]['datas'] = implode(',', $minimum);
		$res['chart_fill'][2]['color'] = '#FFFACD';
		$res['chart_fill'][2]['fill'] = '4';
		$res['chart_fill'][3]['label'] = 'Safety Stock';
		$res['chart_fill'][3]['datas'] = implode(',', $safety);
		$res['chart_fill'][3]['color'] = '#FFC0CB';
		$res['chart_fill'][3]['fill'] = 'start';
		echo json_encode($res);
	}
	
	/*------------------------------------------------------------------------------*/
	
	public function availability_performance($storage_id)	{
		$p_period = $this->input->get('p_period');
		$label_type = 'month';
		if ($p_period == 'daily') {
			$label_type = 'day';
			$tgl = $this->input->get('p_period_sub_date');
			$tanggal_dari = (empty($tgl))? date('Y-m-d') : $tgl;
			$tanggal_sampai = $tanggal_dari;
		}
		if ($p_period == 'monthly' || empty($p_period)) {
			$label_type = 'day';
			$tahun = $this->input->get('p_year');
			$tahun = (empty($tahun))? date('Y') : $tahun;
			$bulan = $this->input->get('p_period_sub_month');
			$bulan = (empty($bulan))? date('n') : $bulan;
			$bulan = substr(('0' .$bulan),-2);
			
			$tanggal_dari = ($tahun .'-'. $bulan .'-01');
			$tanggal_sampai = date('Y-m-t', strtotime($tanggal_dari));
		}
		if ($p_period == 'quarterly') {
			$tahun = $this->input->get('p_year');
			if ($this->input->get('p_period_sub_quarter')=='q1') {
				$label_type = 'quarterly';
				$bulan1 = '01';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '03';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q2') {				
				$label_type = 'quarterly';
				$bulan1 = '04';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '06';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q3') {
				$label_type = 'quarterly';
				$bulan1 = '07';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '09';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->get('p_period_sub_quarter')=='q4') {
				$label_type = 'quarterly';
				$bulan1 = '10';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '12';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
		}
		if ($p_period == 'yearly') {
				$label_type = 'month';
			$tahun = $this->input->get('p_year');
			
			$tanggal_dari = ($tahun .'-01-01');
			$tanggal_sampai = ($tahun .'-12-31');
		}
		$start = $tanggal_dari;
		$end = $tanggal_sampai;
		
		$availability_performance 	= $this->Model_supply->get_availability_performance($storage_id,$start, $end, $label_type);
		$parameters = $this->Model_supply->get_parameters($storage_id);
		print_r($availability_performance);
		print_r($parameters);
		die();
		if($label_type == 'month'){
			$x = 0;
			while($x++ < 12) {
				$MonthNumbers[] = $x;
			}

			foreach ($MonthNumbers as $MonthNumber) {
				$mon = $MonthNumber-1;
				$monmin = $MonthNumber-2;
				$months[] = date("F", strtotime("+".$mon."month",strtotime('2020-01-01')));
				$months_before[] = date("F", strtotime("+".$monmin."month",strtotime('2020-01-01')));
			}
		}elseif($label_type == 'quarterly'){
			$start = date("n", strtotime($tanggal_dari));
			$end = date("n", strtotime($tanggal_sampai));
			$x = $start-1;
			while($x++ < $end) {
				$MonthNumbers[] = $x;
			}
			foreach ($MonthNumbers as $MonthNumber) {
				$mon = $MonthNumber-1;
				$monmin = $MonthNumber-2;
				$months[] = date("F", strtotime("+".$mon."month",strtotime('2020-01-01')));
				$months_before[] = date("F", strtotime("+".$monmin."month",strtotime('2020-01-01')));
			}
		}elseif($label_type == 'day'){
			$start = $tanggal_dari;
			$end = $tanggal_sampai;
			while(strtotime($start) <= strtotime($end)) {
				$months[] = $start;
				$start = date ("Y-m-d", strtotime("+1 day", strtotime($start)));
				$months_before[] = date ("Y-m-d", strtotime("-2 day", strtotime($start)));
			}
		}
		
		foreach ($inventory_performance as $inventory) {
			$data[$inventory['month_date']]['average'] = $inventory['vol'] + $inventory['qty_observe']; 
		}
		
		foreach ($forecast as $item_forecast) {
			$data[$item_forecast['trans_date']]['forecast'] = $item_forecast['inventory']; 
		}
		
		foreach ($parameters as $inventory) {  
			$data[1]['maximal'] = $inventory['maximal']; 
			$data[1]['minimum'] = $inventory['minimum']; 
			$data[1]['safety'] = $inventory['safety']; 
		}
		$label = array();
		$average = array();
		$data_forecast = array();
		$maximal = array();
		$minimum = array();
		$safety = array();
		$temp_average = 0;
		$i=0;
		foreach($months as $item){
			if(isset($data[$item])){
				$label[$i] = $item;
				if(isset($data[$item]['average'])){
					$average[$i] = $data[$item]['average'];
					$temp_average = $data[$item]['average'];
				}elseif(isset($data[$item]['forecast'])){
					if(isset($data[$months_before[$i]]['forecast']) && !empty($data[$months_before[$i]]['forecast']) && $temp_average > 0){
						$average[$i] = ($temp_average-$data[$months_before[$i]]['forecast'])+$data[$item]['forecast'];
						$temp_average = $average[$i];
					}else{
						$temp_average = $data[$item]['forecast'];
						$average[$i] = $data[$item]['forecast'];
					}
					
				}else{
					$average[$i] = 0;
				}
				$data_forecast[$i] = (isset($data[$item]['forecast']))? $data[$item]['forecast'] : 0;
			}else{
				$label[$i] = $item;
				$average[$i] = 0;
				$data_forecast[$i] = 0;
			}	
			$maximal[$i] = $data[1]['maximal'];
			$minimum[$i] = $data[1]['minimum'];
			$safety[$i] = $data[1]['safety'];
			$i++;
		}
		
		$res['chart'] = array();
		$res['chart_fill'] = array();
		$res['labels'] = implode(',', $label);
		$res['chart'][0]['label'] = 'Status Stock';
		$res['chart'][0]['datas'] = implode(',', $average);
		$res['chart'][0]['color'] = 'orange';
		$res['chart'][1]['label'] = 'Forecast';
		$res['chart'][1]['datas'] = implode(',', $data_forecast);
		$res['chart'][1]['color'] = '#0080ff';
		$res['chart_fill'][1]['label'] = 'Stock Max';
		$res['chart_fill'][1]['datas'] = implode(',', $maximal);
		$res['chart_fill'][1]['color'] = '#90EE90';
		$res['chart_fill'][1]['fill'] = '3';
		$res['chart_fill'][2]['label'] = 'Stock Min';
		$res['chart_fill'][2]['datas'] = implode(',', $minimum);
		$res['chart_fill'][2]['color'] = '#FFFACD';
		$res['chart_fill'][2]['fill'] = '4';
		$res['chart_fill'][3]['label'] = 'Safety Stock';
		$res['chart_fill'][3]['datas'] = implode(',', $safety);
		$res['chart_fill'][3]['color'] = '#FFC0CB';
		$res['chart_fill'][3]['fill'] = 'start';
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
					if(isset($array[$i][$key])){
						if ($array[$i][$key] == $search) {
								$result = $i;
								break;
						}
					}
			}
		}
    return $result;
	}

}
