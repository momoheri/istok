<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login extends CI_Controller{
 
	function __construct(){
		parent::__construct();		
		$this->load->model('Model_login');
 
	}
 
	function index(){
		$this->session->sess_destroy();
		$this->load->view('login');
	}
 
	function aksi_login(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$result='';
		$where = array(
			'user_name' => $email,
			'user_password' => ($password)
			);
		$cek = $this->Model_login->cek_login("mst_user", $where)->num_rows();
		if($cek > 0){
			$cekdata = $this->Model_login->get_user($email);
			if($cekdata[0]->status_active == 1){
				$data_session = array(
					'user_id' => $cekdata[0]->user_id,
					'user_name' => $cekdata[0]->user_name,
					'user_name_full' => $cekdata[0]->user_name_full,
					'user_level' => $cekdata[0]->user_level,
					'login' => TRUE,
					'login_app' => 'istok'
					);
				$this->session->set_userdata($data_session);
				login_log($email,'Login','Istock','Username : '.$cekdata[0]->user_name.'| Level : '.$cekdata[0]->user_level);
				//$this->output->enable_profiler(TRUE);
				//redirect(base_url("home"));
				$result="Success";
			} else {
				login_log($email,'Login','Istock','Username : '.$email.' is Inactive');
				$result = "Username is Inactive";
			}
				 
		} else {
			login_log($email,'Login','Istock','Username : '.$email.' is Wrong username or password');
			$result = "Wrong Username & Password !";
		}

		echo json_encode($result);
	}
 
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
}