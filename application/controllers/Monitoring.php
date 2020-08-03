<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

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
		
		$tanggal = date('Y-m-d');
		$data['tanggal'] = $tanggal;
		$data['bulan'] = substr($tanggal,-2);
		$data['tahun'] = date('Y');
		
		$tanggal_dari = '';
		$tanggal_sampai = '';
		$filter_result = '';

		$p_period = $this->input->get('p_period');
		$p_period = (empty($p_period))? 'monthly' : $p_period;
		
		$filter_result = 'period = ' .$p_period. '<br>';
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
			
			$filter_result = $filter_result.'sub period = ' .$bulan. '<br>';
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
		$data['tanggal_dari'] = $tanggal_dari;
		$data['tanggal_sampai'] = $tanggal_sampai;
		
		$msg_depan = '<div class="alert alert-success text-center">';
		$msg_belakang = '</div>';
		
		$filter_result = $msg_depan.$filter_result.'from <b>'.$tanggal_dari. '</b> to <b>'.$tanggal_sampai.'</b>'.$msg_belakang;
		$data['filter_result'] = $filter_result;
		
		$data['qeury_url'] = (!empty($_SERVER['QUERY_STRING']))? $_SERVER['QUERY_STRING'] : 'p_year='.date('Y').'&p_period=monthly&p_period_sub_date='.date('Y-m-d').'&p_period_sub_month='.date('n').'&p_period_sub_quarter=q1';
		$data['periode'] = $p_period;		
		
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

}
