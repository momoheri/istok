<?php
function log_activity($action,$item,$description){
    $CI =& get_instance();

    $param['log_user'] = $CI->session->userdata('user_name_full');
    $param['log_action'] = $action;
    $param['log_item'] = $item;
    $param['log_description'] = $description;

    $CI->load->model('Model_log');

    $CI->Model_log->save_log($param);
}

function login_log($username,$action,$item,$description){
    $CI =& get_instance();
    
    $param['log_user'] = $username;
    $param['log_action'] = $action;
    $param['log_item'] = $item;
    $param['log_description'] = $description;

    $CI->load->model('Model_log');

    $CI->Model_log->save_log($param);
}
?>