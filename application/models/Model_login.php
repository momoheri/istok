<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Model_login extends CI_Model{	
	// db2 digunakan untuk mengakses database ke-2
	private $db2;

	public function __construct()
	{
		parent::__construct();
	}
	
	function cek_login($table, $where){		
		return $this->db->get_where($table,$where);
	}	
	
	function get_user($email){
		$this->db->where('user_name', $email);
        $query = $this->db->get('mst_user');
		return $query->result();
	}
}