<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supply extends CI_Controller {

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
		$data['bulan'] = substr($tanggal,-2);
		$data['tahun'] = date('Y');
		
		$data_mst_storage = $this->Model_supply->get_data_mst_storage('1');
		$data['data_mst_storage'] = $data_mst_storage;
		foreach ($data_mst_storage as $row) {
			$data['s1_storage_name'] = $row->storage_name;
			$data['s1_storage_height'] = $row->storage_height;
		}
		
		$data_trans_atg = $this->Model_supply->get_trans_atg($tanggal);
		$data['data_trans_atg'] = $data_trans_atg;
		
		// //tampung
		// foreach ($data_trans_atg as $row) {
			// $max_id = $this->Model_supply->get_atg_max();
			
			// if ($row->trans_id > $max_id) {
				// $data_insert = array(
					// 'trans_id' => $row->trans_id,
					// 'trans_date' => $row->trans_date,
					// 'trans_time' => $row->trans_time,
					// 'tankno' => $row->tankno,
					// 'volume' => $row->volume,
					// 'tc_vol' => $row->tc_vol,
					// 'ullage' => $row->ullage,
					// 'product_height' => $row->product_height,
					// 'water' => $row->water,
					// 'temp_c' => $row->temp_c,
					// 'water_vol' => $row->water_vol,
					// 'atg_id' => $row->atg_id
				// );
				// $this->Model_supply->insert_atg($data_insert);				
			// }
		// }
		
		$this->load->view('header', $datasesion);
		$this->load->view('supply',$data);
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
