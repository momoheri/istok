<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_log extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function save_log($param){
        $sql = $this->db->insert_string('trans_log', $param);
        $qr = $this->db->query($sql);
        return $this->db->affected_rows($sql);
    }
}
?>