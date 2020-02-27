<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

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
		
		$data['tanggal_dari'] = '';
		$data['tanggal_sampai'] = '';
		$data['filter_result'] = '';
		
		$data_mst_storage = $this->Model_monitoring->get_data_mst_storage('1');
		$data['data_mst_storage'] = $data_mst_storage;
		foreach ($data_mst_storage as $row) {
			$data['s1_storage_name'] = $row->storage_name;
			$data['s1_storage_height'] = $row->storage_height;
		}
		
		$data_trans_atg = $this->Model_monitoring->get_trans_atg($tanggal);
		$data['data_trans_atg'] = $data_trans_atg;
		
		// //tampung
		// foreach ($data_trans_atg as $row) {
			// $max_id = $this->Model_monitoring->get_atg_max();
			
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
				// $this->Model_monitoring->insert_atg($data_insert);				
			// }
		// }
		
		$this->load->view('header', $datasesion);
		$this->load->view('monitoring',$data);
		$this->load->view('footer');
	}
	
	function cari(){
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
		
		$filter_result = '';

		$p_period = $this->input->post('p_period');
		$filter_result = 'period = ' .$p_period. '<br>';
		
		if ($p_period == 'daily') {
			$tanggal_dari = $this->input->post('p_period_sub_date');
			$tanggal_sampai = $this->input->post('p_period_sub_date');
		}
		if ($p_period == 'monthly') {
			$filter_result = $filter_result.'sub period = ' .$this->input->post('p_period_sub_month'). '<br>';

			$tahun = $this->input->post('p_year');
			$bulan = substr(('0' .$this->input->post('p_period_sub_month')),-2);
			
			$tanggal_dari = ($tahun .'-'. $bulan .'-01');
			$tanggal_sampai = date('Y-m-t', strtotime($tanggal_dari));
		}
		if ($p_period == 'quarterly') {
			$tahun = $this->input->post('p_year');
			$filter_result = $filter_result.'sub period = ' .$this->input->post('p_period_sub_quarter'). '<br>';
			
			if ($this->input->post('p_period_sub_quarter')=='q1') {
				$bulan1 = '01';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '03';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->post('p_period_sub_quarter')=='q2') {
				$bulan1 = '04';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '06';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->post('p_period_sub_quarter')=='q3') {
				$bulan1 = '07';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '09';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
			
			if ($this->input->post('p_period_sub_quarter')=='q4') {
				$bulan1 = '10';				
				$tanggal_dari = ($tahun .'-'. $bulan1 .'-01');
				
				$bulan2 = '12';				
				$tanggal2 = ($tahun .'-'. $bulan2 .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal2));
			}
		}
		if ($p_period == 'yearly') {
			$tahun = $this->input->post('p_year');
			
			$tanggal_dari = ($tahun .'-01-01');
			$tanggal_sampai = ($tahun .'-12-31');
		}
		$data['tanggal_dari'] = $tanggal_dari;
		$data['tanggal_sampai'] = $tanggal_sampai;
		
		$msg_depan = '<div class="alert alert-success text-center">';
		$msg_belakang = '</div>';
		
		$filter_result = $msg_depan.$filter_result.'from <b>'.$tanggal_dari. '</b> to <b>'.$tanggal_sampai.'</b>'.$msg_belakang;
		$data['filter_result'] = $filter_result;

		// //set chart2
		// //detail
		// $chart2_label = array();
		// $chart2_value = array();
		// $chart2_color = array();
		// $total = 0;
		// foreach ($dataku as $row) {
            // array_push($chart2_label, $row->user_fullname);
            // array_push($chart2_value, $row->v_f2f);
            // array_push($chart2_color, $this->getColor($row->user_fullname.$row->total));
			// $total = $total+($row->total);
		// }
		// //rekap
		// if ($s_branch != null) {
			// $datakuall = $this->Model_sum_aktifitas->get_visit_all($this->session->userdata('user_company'), $s_eta_dari, $s_eta_sampai, $s_visit_pr);		
			// foreach ($datakuall as $row) {
				// array_push($chart2_label, 'Other SBU');
				// array_push($chart2_value, ($row->v_f2f-$total));
				// array_push($chart2_color, $this->getColor($row->user_fullname.$row->total));
			// }
		// }
		// $data['chart2_label'] = $chart2_label;
		// $data['chart2_value'] = $chart2_value;
		// $data['chart2_color'] = $chart2_color;

		$this->load->view('header', $datasesion);
		$this->load->view('monitoring',$data);
		$this->load->view('footer');
	}
	
	public function getColor($num) {
		$hash = md5('color' . $num); // modify 'color' to get a different palette
		return array(
			hexdec(substr($hash, 0, 2)), // r
			hexdec(substr($hash, 2, 2)), // g
			hexdec(substr($hash, 4, 2))); //b
	}	

	function logout(){
			$this->session->sess_destroy();
			redirect(base_url('login'));
	}
}
