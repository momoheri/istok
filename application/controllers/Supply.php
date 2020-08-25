<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supply extends CI_Controller {

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
		
		$tanggal = date('Y-m-d');
		$data['tanggal'] = $tanggal;
		$data['bulan'] = substr($tanggal,-2);
		$data['tahun'] = date('Y');
		
		$tanggal_dari = '';
		$tanggal_sampai = '';
		$filter_result = '';

		$p_period = $this->input->post('p_period');
		$p_period = (empty($p_period))? 'monthly' : $p_period;
		
		$filter_result = 'period = ' .$p_period. '<br>';
		if ($p_period == 'daily') {
			$tgl = $this->input->post('p_period_sub_date');
			$tanggal_dari = (empty($tgl))? date('Y-m-d') : $tgl;
			$tanggal_sampai = $tanggal_dari;
		}
		if ($p_period == 'monthly' || empty($p_period)) {
			$tahun = $this->input->post('p_year');
			$tahun = (empty($tahun))? date('Y') : $tahun;
			$bulan = $this->input->post('p_period_sub_month');
			$bulan = (empty($bulan))? date('n') : $bulan;
			$bulan = substr(('0' .$bulan),-2);
			$tanggal_dari = ($tahun .'-'. $bulan .'-01');
			$tanggal_sampai = date('Y-m-t', strtotime($tanggal_dari));
			
			$filter_result = $filter_result.'sub period = ' .$bulan. '<br>';
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
		
		$data['qeury_url'] = (!empty($_POST))? http_build_query($_POST) : 'p_year='.date('Y').'&p_period=monthly&p_period_sub_date='.date('Y-m-d').'&p_period_sub_month='.date('n').'&p_period_sub_quarter=q1';
		$data['periode'] = $p_period;
		
		$this->load->view('header', $datasesion);
		$this->load->view('supply',$data);
		$this->load->view('footer');
	}
	
}