<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$this->load->model('Model_home');

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
		$datasesion = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_level' => $this->session->userdata('user_level'),
			'user_name' => $this->session->userdata('user_name'),
			'user_name_full' => $this->session->userdata('user_name_full')
		);
		
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'user_level' => $this->session->userdata('user_level'),
			'user_name' => $this->session->userdata('user_name'),
			'user_name_full' => $this->session->userdata('user_name_full')
		);
		
		date_default_timezone_set('Asia/Jakarta');
		$tanggal = date('Y-m-d');
		$data['tanggal'] = $tanggal;
		
		// Tittle Tank 1
		$data_mst_storage = $this->Model_home->get_mst_storage('1');
		$data['data_mst_storage'] = $data_mst_storage;
		foreach ($data_mst_storage as $row) {
			$data['s1_storage_name'] = $row->storage_name;
			$data['s1_storage_height'] = $row->storage_height;
		}
		
		// Tittle Tank 2
		$data_mst_storage = $this->Model_home->get_mst_storage('2');
		$data['data_mst_storage'] = $data_mst_storage;
		foreach ($data_mst_storage as $row) {
			$data['s2_storage_name'] = $row->storage_name;
			$data['s2_storage_height'] = $row->storage_height;
		}
		
		// Tittle Tank 3
		$data_mst_storage = $this->Model_home->get_mst_storage('3');
		$data['data_mst_storage'] = $data_mst_storage;
		foreach ($data_mst_storage as $row) {
			$data['s3_storage_name'] = $row->storage_name;
			$data['s3_storage_height'] = $row->storage_height;
		}
		
		// Visual Tank 1
		$get_trans_atg = $this->Model_home->get_trans_atg('1');
		$sum_volume=0; $sum_ullage=0;
		foreach ($get_trans_atg as $row) {
			$sum_volume = $sum_volume + $row->volume;
			$sum_ullage = $sum_ullage + $row->ullage;
		}
		$data['s1_sum_volume'] = $sum_volume;
		$data['s1_sum_ullage'] = $sum_ullage;
		
		// Visual Tank 2
		$get_trans_atg = $this->Model_home->get_trans_atg('2');
		$sum_volume=0; $sum_ullage=0;
		foreach ($get_trans_atg as $row) {
			$sum_volume = $sum_volume + $row->volume;
			$sum_ullage = $sum_ullage + $row->ullage;
		}
		$data['s2_sum_volume'] = $sum_volume;
		$data['s2_sum_ullage'] = $sum_ullage;
		
		// Visual Tank 3
		$get_trans_atg = $this->Model_home->get_trans_atg('3');
		$sum_volume=0; $sum_ullage=0;
		foreach ($get_trans_atg as $row) {
			$sum_volume = $sum_volume + $row->volume;
			$sum_ullage = $sum_ullage + $row->ullage;
		}
		$data['s3_sum_volume'] = $sum_volume;
		$data['s3_sum_ullage'] = $sum_ullage;
		
		// Parameter Tank 1
		$get_mst_parameter = $this->Model_home->get_mst_parameter('1');
		$stock_max=0; $stock_min=0; $reorder_point=0; $safety_stock=0;
		$inlet_iso4=0; $inlet_iso6=0; $inlet_iso14=0;
		$outlet_iso4=0; $outlet_iso6=0; $outlet_iso14=0;
		foreach ($get_mst_parameter as $row) {
			$stock_max = $row->stock_max;
			$stock_min = $row->stock_min;
			$reorder_point = $row->reorder_point;
			$safety_stock = $row->safety_stock;
			$average_distribution = $row->average_distribution;
			// cleanliness
			$inlet_iso4 = $row->inlet_iso4;			
			$inlet_iso6 = $row->inlet_iso6;			
			$inlet_iso14 = $row->inlet_iso14;			
			$outlet_iso4 = $row->outlet_iso4;			
			$outlet_iso6 = $row->outlet_iso6;			
			$outlet_iso14 = $row->outlet_iso14;			
		}
		$data['s1_stock_max'] = $stock_max;
		$data['s1_stock_min'] = $stock_min;
		$data['s1_reorder_point'] = $reorder_point;
		$data['s1_safety_stock'] = $safety_stock;
		$data['s1_average_distribution'] = $average_distribution;
		$data['s1_inlet_iso4'] = $inlet_iso4;
		$data['s1_inlet_iso6'] = $inlet_iso6;
		$data['s1_inlet_iso14'] = $inlet_iso14;
		$data['s1_outlet_iso4'] = $outlet_iso4;
		$data['s1_outlet_iso6'] = $outlet_iso6;
		$data['s1_outlet_iso14'] = $outlet_iso14;

		// Parameter Tank 2
		$get_mst_parameter = $this->Model_home->get_mst_parameter('2');
		$stock_max=0; $stock_min=0; $reorder_point=0; $safety_stock=0;
		$inlet_iso4=0; $inlet_iso6=0; $inlet_iso14=0;
		$outlet_iso4=0; $outlet_iso6=0; $outlet_iso14=0;
		foreach ($get_mst_parameter as $row) {
			$stock_max = $row->stock_max;
			$stock_min = $row->stock_min;
			$reorder_point = $row->reorder_point;
			$safety_stock = $row->safety_stock;
			$average_distribution = $row->average_distribution;
			// cleanliness
			$inlet_iso4 = $row->inlet_iso4;			
			$inlet_iso6 = $row->inlet_iso6;			
			$inlet_iso14 = $row->inlet_iso14;			
			$outlet_iso4 = $row->outlet_iso4;			
			$outlet_iso6 = $row->outlet_iso6;			
			$outlet_iso14 = $row->outlet_iso14;			
		}
		$data['s2_stock_max'] = $stock_max;
		$data['s2_stock_min'] = $stock_min;
		$data['s2_reorder_point'] = $reorder_point;
		$data['s2_safety_stock'] = $safety_stock;
		$data['s2_average_distribution'] = $average_distribution;
		$data['s2_inlet_iso4'] = $inlet_iso4;
		$data['s2_inlet_iso6'] = $inlet_iso6;
		$data['s2_inlet_iso14'] = $inlet_iso14;
		$data['s2_outlet_iso4'] = $outlet_iso4;
		$data['s2_outlet_iso6'] = $outlet_iso6;
		$data['s2_outlet_iso14'] = $outlet_iso14;

		// Parameter Tank 3
		$get_mst_parameter = $this->Model_home->get_mst_parameter('3');
		$stock_max=0; $stock_min=0; $reorder_point=0; $safety_stock=0;
		$inlet_iso4=0; $inlet_iso6=0; $inlet_iso14=0;
		$outlet_iso4=0; $outlet_iso6=0; $outlet_iso14=0;
		foreach ($get_mst_parameter as $row) {
			$stock_max = $row->stock_max;
			$stock_min = $row->stock_min;
			$reorder_point = $row->reorder_point;
			$safety_stock = $row->safety_stock;
			$average_distribution = $row->average_distribution;
			// cleanliness
			$inlet_iso4 = $row->inlet_iso4;			
			$inlet_iso6 = $row->inlet_iso6;			
			$inlet_iso14 = $row->inlet_iso14;			
			$outlet_iso4 = $row->outlet_iso4;			
			$outlet_iso6 = $row->outlet_iso6;			
			$outlet_iso14 = $row->outlet_iso14;			
		}
		$data['s3_stock_max'] = $stock_max;
		$data['s3_stock_min'] = $stock_min;
		$data['s3_reorder_point'] = $reorder_point;
		$data['s3_safety_stock'] = $safety_stock;
		$data['s3_average_distribution'] = $average_distribution;
		$data['s3_inlet_iso4'] = $inlet_iso4;
		$data['s3_inlet_iso6'] = $inlet_iso6;
		$data['s3_inlet_iso14'] = $inlet_iso14;
		$data['s3_outlet_iso4'] = $outlet_iso4;
		$data['s3_outlet_iso6'] = $outlet_iso6;
		$data['s3_outlet_iso14'] = $outlet_iso14;
		
		// Tank 1
		// Cleanliness In
		$get_trans_cleanliness = $this->Model_home->get_trans_cleanliness_in('1');
		$iso4b=0; $iso6b=0; $iso14b=0; $iso4a=0; $iso6a=0; $iso14a=0;
		foreach ($get_trans_cleanliness as $row) {
			$iso4b = $row->iso4b;
			$iso6b = $row->iso6b;
			$iso14b = $row->iso14b;
			$iso4a = $row->iso4a;
			$iso6a = $row->iso6a;
			$iso14a = $row->iso14a;
		}
		$data['s1_in_iso4b'] = $iso4b;
		$data['s1_in_iso6b'] = $iso6b;
		$data['s1_in_iso14b'] = $iso14b;
		$data['s1_in_iso4a'] = $iso4a;
		$data['s1_in_iso6a'] = $iso6a;
		$data['s1_in_iso14a'] = $iso14a;
		// Cleanliness Out
		$get_trans_cleanliness = $this->Model_home->get_trans_cleanliness_out('1');
		$iso4b=0; $iso6b=0; $iso14b=0; $iso4a=0; $iso6a=0; $iso14a=0;
		foreach ($get_trans_cleanliness as $row) {
			$iso4b = $row->iso4b;
			$iso6b = $row->iso6b;
			$iso14b = $row->iso14b;
			$iso4a = $row->iso4a;
			$iso6a = $row->iso6a;
			$iso14a = $row->iso14a;
		}
		$data['s1_out_iso4b'] = $iso4b;
		$data['s1_out_iso6b'] = $iso6b;
		$data['s1_out_iso14b'] = $iso14b;
		$data['s1_out_iso4a'] = $iso4a;
		$data['s1_out_iso6a'] = $iso6a;
		$data['s1_out_iso14a'] = $iso14a;

		// Tank 2
		// Cleanliness In
		$get_trans_cleanliness = $this->Model_home->get_trans_cleanliness_in('2');
		$iso4b=0; $iso6b=0; $iso14b=0; $iso4a=0; $iso6a=0; $iso14a=0;
		foreach ($get_trans_cleanliness as $row) {
			$iso4b = $row->iso4b;
			$iso6b = $row->iso6b;
			$iso14b = $row->iso14b;
			$iso4a = $row->iso4a;
			$iso6a = $row->iso6a;
			$iso14a = $row->iso14a;
		}
		$data['s2_in_iso4b'] = $iso4b;
		$data['s2_in_iso6b'] = $iso6b;
		$data['s2_in_iso14b'] = $iso14b;
		$data['s2_in_iso4a'] = $iso4a;
		$data['s2_in_iso6a'] = $iso6a;
		$data['s2_in_iso14a'] = $iso14a;
		// Cleanliness Out
		$get_trans_cleanliness = $this->Model_home->get_trans_cleanliness_out('2');
		$iso4b=0; $iso6b=0; $iso14b=0; $iso4a=0; $iso6a=0; $iso14a=0;
		foreach ($get_trans_cleanliness as $row) {
			$iso4b = $row->iso4b;
			$iso6b = $row->iso6b;
			$iso14b = $row->iso14b;
			$iso4a = $row->iso4a;
			$iso6a = $row->iso6a;
			$iso14a = $row->iso14a;
		}
		$data['s2_out_iso4b'] = $iso4b;
		$data['s2_out_iso6b'] = $iso6b;
		$data['s2_out_iso14b'] = $iso14b;
		$data['s2_out_iso4a'] = $iso4a;
		$data['s2_out_iso6a'] = $iso6a;
		$data['s2_out_iso14a'] = $iso14a;

		// Tank 3
		// Cleanliness In
		$get_trans_cleanliness = $this->Model_home->get_trans_cleanliness_in('3');
		$iso4b=0; $iso6b=0; $iso14b=0; $iso4a=0; $iso6a=0; $iso14a=0;
		foreach ($get_trans_cleanliness as $row) {
			$iso4b = $row->iso4b;
			$iso6b = $row->iso6b;
			$iso14b = $row->iso14b;
			$iso4a = $row->iso4a;
			$iso6a = $row->iso6a;
			$iso14a = $row->iso14a;
		}
		$data['s3_in_iso4b'] = $iso4b;
		$data['s3_in_iso6b'] = $iso6b;
		$data['s3_in_iso14b'] = $iso14b;
		$data['s3_in_iso4a'] = $iso4a;
		$data['s3_in_iso6a'] = $iso6a;
		$data['s3_in_iso14a'] = $iso14a;
		// Cleanliness Out
		$get_trans_cleanliness = $this->Model_home->get_trans_cleanliness_out('3');
		$iso4b=0; $iso6b=0; $iso14b=0; $iso4a=0; $iso6a=0; $iso14a=0;
		foreach ($get_trans_cleanliness as $row) {
			$iso4b = $row->iso4b;
			$iso6b = $row->iso6b;
			$iso14b = $row->iso14b;
			$iso4a = $row->iso4a;
			$iso6a = $row->iso6a;
			$iso14a = $row->iso14a;
		}
		$data['s3_out_iso4b'] = $iso4b;
		$data['s3_out_iso6b'] = $iso6b;
		$data['s3_out_iso14b'] = $iso14b;
		$data['s3_out_iso4a'] = $iso4a;
		$data['s3_out_iso6a'] = $iso6a;
		$data['s3_out_iso14a'] = $iso14a;

		// Tank 1
		// History Distribution Consumption
		$chart1_label = array();
		$chart1_value = array();
		$data_trans_smartfill = $this->Model_home->get_trans_smartfill_out('1');
		foreach ($data_trans_smartfill as $row) {
			array_push($chart1_label, ($row->tanggal));
			array_push($chart1_value, ($row->total));
		}
		$data['chart1_label'] = $chart1_label;
		$data['chart1_value'] = $chart1_value;
		
		// Tank 2
		// History Distribution Consumption
		$chart2_label = array();
		$chart2_value = array();
		$data_trans_smartfill = $this->Model_home->get_trans_smartfill_out('2');
		foreach ($data_trans_smartfill as $row) {
			array_push($chart2_label, ($row->tanggal));
			array_push($chart2_value, ($row->total));
		}
		$data['chart2_label'] = $chart2_label;
		$data['chart2_value'] = $chart2_value;
		
		// Tank 3
		// History Distribution Consumption
		$chart3_label = array();
		$chart3_value = array();
		$data_trans_smartfill = $this->Model_home->get_trans_smartfill_out('3');
		foreach ($data_trans_smartfill as $row) {
			array_push($chart3_label, ($row->tanggal));
			array_push($chart3_value, ($row->total));
		}
		$data['chart3_label'] = $chart3_label;
		$data['chart3_value'] = $chart3_value;
		
		// Tank 1
		// ETA Status
		$data_trans_po = $this->Model_home->get_trans_po('1',$tanggal);
		$posting_date=null; $quantity=0;
		foreach ($data_trans_po as $row) {
			$posting_date = $row->posting_date;
			$quantity = $row->quantity;
		}
		$data['s1_po_posting_date'] = $posting_date;
		$data['s1_po_quantity'] = $quantity;

		// Tank 2
		// ETA Status
		$data_trans_po = $this->Model_home->get_trans_po('2',$tanggal);
		$posting_date=null; $quantity=0;
		foreach ($data_trans_po as $row) {
			$posting_date = $row->posting_date;
			$quantity = $row->quantity;
		}
		$data['s2_po_posting_date'] = $posting_date;
		$data['s2_po_quantity'] = $quantity;

		// Tank 3
		// ETA Status
		$data_trans_po = $this->Model_home->get_trans_po('3',$tanggal);
		$posting_date=null; $quantity=0;
		foreach ($data_trans_po as $row) {
			$posting_date = $row->posting_date;
			$quantity = $row->quantity;
		}
		$data['s3_po_posting_date'] = $posting_date;
		$data['s3_po_quantity'] = $quantity;

		// tampilkan query
		// $this->output->enable_profiler(TRUE);
		
		$this->load->view('header', $datasesion);
		$this->load->view('home',$data);
		$this->load->view('footer');
	}
	
	function smartfill_req(){
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
}
