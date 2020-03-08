<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','html'));
		$this->load->library('session');
		$this->load->database();
		$this->load->model('Model_monitoring');

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
		$filter_result = 'period = ' .$p_period. '<br>';
		
		if ($p_period == 'daily' || empty($p_period)) {
			$tgl = $this->input->get('p_period_sub_date');
			$tanggal_dari = (empty($tgl))? date('Y-m-d') : $tgl;
			$tanggal_sampai = $tanggal_dari;
		}
		if ($p_period == 'monthly') {
			$filter_result = $filter_result.'sub period = ' .$this->input->get('p_period_sub_month'). '<br>';

			$tahun = $this->input->get('p_year');
			$bulan = substr(('0' .$this->input->get('p_period_sub_month')),-2);
			
			$tanggal_dari = ($tahun .'-'. $bulan .'-01');
			$tanggal_sampai = date('Y-m-t', strtotime($tanggal_dari));
		}
		if ($p_period == 'quarterly') {
			$tahun = $this->input->get('p_year');
			$filter_result = $filter_result.'sub period = ' .$this->input->get('p_period_sub_quarter'). '<br>';
			
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
		$res['vendor'] = implode(',', $data_vendor);
		
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
