<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','html'));
		$this->load->library('session');
		$this->load->database();
		$this->load->model('Model_schedule');

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
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
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
		
		// storage 1
		$data_mst_storage = $this->Model_schedule->get_mst_storage('1');
		$storage_name=''; $storage_height=0;
		foreach ($data_mst_storage as $row) {
			$storage_name = $row->storage_name;
			$storage_height = $row->storage_height;
		}
		$data['s1_storage_name'] = $storage_name;
		$data['s1_storage_height'] = $storage_height;
		
		// storage 2
		$data_mst_storage = $this->Model_schedule->get_mst_storage('2');
		$storage_name=''; $storage_height=0;
		foreach ($data_mst_storage as $row) {
			$storage_name = $row->storage_name;
			$storage_height = $row->storage_height;
		}
		$data['s2_storage_name'] = $storage_name;
		$data['s2_storage_height'] = $storage_height;
		
		// storage 3
		$data_mst_storage = $this->Model_schedule->get_mst_storage('3');
		$storage_name=''; $storage_height=0;
		foreach ($data_mst_storage as $row) {
			$storage_name = $row->storage_name;
			$storage_height = $row->storage_height;
		}
		$data['s3_storage_name'] = $storage_name;
		$data['s3_storage_height'] = $storage_height;
		
		// parameter 1
		$data_mst_parameter = $this->Model_schedule->get_mst_parameter('1');
		$parameter_name=''; $lead_time=0; $dead_stock=0; $average_distribution=0; $average_distribution_max=0;
		$safety_stock=0; $reorder_point=0; $stock_max=0; $stock_min=0;
		foreach ($data_mst_parameter as $row) {
			$parameter_name = $row->parameter_name;
			$lead_time = $row->lead_time;
			$dead_stock = $row->dead_stock;
			$average_distribution = $row->average_distribution;
			$average_distribution_max = $row->average_distribution_max;
			$safety_stock = $row->safety_stock;
			$reorder_point = $row->reorder_point;
			$stock_max = $row->stock_max;
			$stock_min = $row->stock_min;
		}
		$data['s1_parameter_name'] = $parameter_name;
		$data['s1_lead_time'] = $lead_time;
		$data['s1_dead_stock'] = $dead_stock;
		$data['s1_average_distribution'] = $average_distribution;
		$data['s1_average_distribution_max'] = $average_distribution_max;
		$data['s1_safety_stock'] = $safety_stock;
		$data['s1_reorder_point'] = $reorder_point;
		$data['s1_stock_max'] = $stock_max;
		$data['s1_stock_min'] = $stock_min;
		
		// parameter 2
		$data_mst_parameter = $this->Model_schedule->get_mst_parameter('2');
		$parameter_name=''; $lead_time=0; $dead_stock=0; $average_distribution=0; $average_distribution_max=0;
		$safety_stock=0; $reorder_point=0; $stock_max=0; $stock_min=0;
		foreach ($data_mst_parameter as $row) {
			$parameter_name = $row->parameter_name;
			$lead_time = $row->lead_time;
			$dead_stock = $row->dead_stock;
			$average_distribution = $row->average_distribution;
			$average_distribution_max = $row->average_distribution_max;
			$safety_stock = $row->safety_stock;
			$reorder_point = $row->reorder_point;
			$stock_max = $row->stock_max;
			$stock_min = $row->stock_min;
		}
		$data['s2_parameter_name'] = $parameter_name;
		$data['s2_lead_time'] = $lead_time;
		$data['s2_dead_stock'] = $dead_stock;
		$data['s2_average_distribution'] = $average_distribution;
		$data['s2_average_distribution_max'] = $average_distribution_max;
		$data['s2_safety_stock'] = $safety_stock;
		$data['s2_reorder_point'] = $reorder_point;
		$data['s2_stock_max'] = $stock_max;
		$data['s2_stock_min'] = $stock_min;
		
		// parameter 3
		$data_mst_parameter = $this->Model_schedule->get_mst_parameter('3');
		$parameter_name=''; $lead_time=0; $dead_stock=0; $average_distribution=0; $average_distribution_max=0;
		$safety_stock=0; $reorder_point=0; $stock_max=0; $stock_min=0;
		foreach ($data_mst_parameter as $row) {
			$parameter_name = $row->parameter_name;
			$lead_time = $row->lead_time;
			$dead_stock = $row->dead_stock;
			$average_distribution = $row->average_distribution;
			$average_distribution_max = $row->average_distribution_max;
			$safety_stock = $row->safety_stock;
			$reorder_point = $row->reorder_point;
			$stock_max = $row->stock_max;
			$stock_min = $row->stock_min;
		}
		$data['s3_parameter_name'] = $parameter_name;
		$data['s3_lead_time'] = $lead_time;
		$data['s3_dead_stock'] = $dead_stock;
		$data['s3_average_distribution'] = $average_distribution;
		$data['s3_average_distribution_max'] = $average_distribution_max;
		$data['s3_safety_stock'] = $safety_stock;
		$data['s3_reorder_point'] = $reorder_point;
		$data['s3_stock_max'] = $stock_max;
		$data['s3_stock_min'] = $stock_min;
                
		date_default_timezone_set('Asia/Jakarta');
		$tanggal = date('Y-m-d');
        
		
                
                
		$p_period = $this->input->get('p_period');
        if($p_period != null){
            if ($p_period == 'daily' || empty($p_period)) {
				$tgl = $this->input->get('p_period_sub_date');
				$tanggal_dari = (empty($tgl))? date('Y-m-d') : $tgl;
				$tanggal_sampai = $tanggal_dari;
			}
			if ($p_period == 'monthly') {
				$tahun = $this->input->get('p_year');
				$bulan = substr(('0' .$this->input->get('p_period_sub_month')),-2);
				
				$tanggal_dari = ($tahun .'-'. $bulan .'-01');
				$tanggal_sampai = date('Y-m-t', strtotime($tanggal_dari));
			}
			if ($p_period == 'quarterly') {
				$tahun = $this->input->get('p_year');
				
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

			

			$data['s1_forecast'] = $this->Model_schedule->get_trans_forecast_byDate(1,$start,$end);
			$data['s2_forecast'] = $this->Model_schedule->get_trans_forecast_byDate(2,$start,$end);
			$data['s3_forecast'] = $this->Model_schedule->get_trans_forecast_byDate(3,$start,$end);
        } else {

			$tahun = date('Y');
			$bulan = date('m');
			$tanggal_dari = ($tahun .'-'. $bulan .'-01');
			$tanggal_sampai = date('Y-m-t', strtotime($tanggal_dari));
			$start = $tanggal_dari;
			$end = $tanggal_sampai;
			
            // forecast 1
            $data_forecast = $this->Model_schedule->get_trans_forecast('1');
		
            $data['s1_forecast'] = $data_forecast;
		
		    // forecast 2
            $data_forecast = $this->Model_schedule->get_trans_forecast('2');
            $data['s2_forecast'] = $data_forecast;
            
            // forecast 3
            $data_forecast = $this->Model_schedule->get_trans_forecast('3');
            $data['s3_forecast'] = $data_forecast;
        }
		$data['query_url'] = (!empty($_GET))? http_build_query($_GET) : 'p_year='.date('Y').'&p_period=monthly&p_period_sub_date='.date('Y-m-d').'&p_period_sub_month='.date('n').'&p_period_sub_quarter=q1';
		$data['periode'] = $p_period;
        
		$this->load->view('header', $datasesion);
		$this->load->view('schedule',$data);
		$this->load->view('footer');
	}
	
	public function auto_forecast(){
			$this->Model_schedule->delete_trans_forecast();
            $max_id = $this->Model_schedule->max_trans_forecast();
            $this->forecast_recalculate('1', $max_id);
            $max_id = $this->Model_schedule->max_trans_forecast();
            $this->forecast_recalculate('2', $max_id);
            $max_id = $this->Model_schedule->max_trans_forecast();
            $this->forecast_recalculate('3', $max_id);
	}
        
        function daily_calculate($id_today,$storage_id){
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d');
            
            $data_trans_atg = $this->Model_schedule->get_trans_atg($storage_id);
            $atg_volume=0;$qty_manual=0;
            if($data_trans_atg == null){
                $data_trans_atg = $this->Model_schedule->get_trans_atg_null($storage_id,1);
                if($data_trans_atg == null){
                    $data_trans_atg = $this->Model_schedule->get_trans_atg_null($storage_id,2);
                    if($data_trans_atg == null){
                        $data_trans_atg = $this->Model_schedule->get_trans_atg_null($storage_id,3);
                        if($data_trans_atg == null){
                            $data_trans_atg = $this->Model_schedule->get_trans_atg2($storage_id);
                        }
                    }
                }
            }
            foreach ($data_trans_atg as $row) {
            	$atg_volume = $atg_volume + $row->volume;
                if($row->qty_observe != null){
                    $atg_volume = $atg_volume - $row->volume;
                }
                $qty_manual = $qty_manual + $row->qty_observe;
            }
            $total = $atg_volume+$qty_manual;
            /*$data = array(
			'stock_realtime' => $total
		);		
		$this->Model_schedule->update_mst_parameter($data, $storage_id);*/
		
            // update parameter
            $realtime_parameter = $this->Model_schedule->get_mst_parameter($storage_id);
            $today_realtime=0;
            foreach ($realtime_parameter as $real){
                $today_realtime = $real->stock_realtime;
            }
            
            
            $max_forecast = $this->Model_schedule->max_forecast_byId($storage_id);
            
            $get_total = $this->Model_schedule->get_count_forecast($storage_id,$id_today,$max_forecast);
            
            if($get_total < 90 && $storage_id == '1'){
               
                    $this->Model_schedule->delete_trans_forecast();

                    // proses forecast 1
                    $max_id = $this->Model_schedule->max_trans_forecast();
                    $this->forecast_recalculate('1', $max_id);

                    // proses forecast 2
                    $max_id = $this->Model_schedule->max_trans_forecast();
                    $this->forecast_recalculate('2', $max_id);

                    // proses forecast 3
                    $max_id = $this->Model_schedule->max_trans_forecast();
                    $this->forecast_recalculate('3', $max_id);
            } else if($atg_volume == $today_realtime){
                //NOTHING
            } else {
                $data = array(
                    'stock_realtime' => $total
                );		
                $this->Model_schedule->update_mst_parameter($data, $storage_id);
                
                $data_mst_parameter = $this->Model_schedule->get_mst_parameter($storage_id);
		$stock_realtime=0; $stock_min=0; $stock_distribution_parameter=0; $stock_distribution_max_parameter=0;
                $reorder_point=0;
		foreach ($data_mst_parameter as $row) {
			$stock_realtime = $row->stock_realtime;
			$stock_min = $row->stock_min;
			$stock_distribution_parameter = $row->average_distribution;
			$stock_distribution_max_parameter = $row->average_distribution_max;
                        $reorder_point = $row->reorder_point;
                }
            
           
            for($i=$id_today;$i<=$max_forecast;$i++){
                //$stock_distribution = rand($stock_distribution_parameter,$stock_distribution_max_parameter);
                
                if($i == $id_today){
                    $today_forecast = $this->Model_schedule->get_last_forecast($id_today);
                    $t_trans_date=date('Y-m-d'); $t_inventory=0; $t_distribution=0; $t_eta=0; $t_barge=0; $t_po_num='';
                    foreach ($today_forecast as $t_values){
                        $t_trans_date = $t_values->trans_date;
                        $t_inventory = $t_values->inventory;
                        $t_distribution = $t_values->distribution;
                        $t_eta = $t_values->eta_schedule;
                        $t_barge = $t_values->barge_id;
                        $t_po_num = $t_values->po_res_number;
                    }
                    
                    $get_po = $this->Model_schedule->get_trans_po($storage_id,$t_trans_date);
                    $p_eta=0; $p_po=''; $p_barge=0;
                    foreach ($get_po as $p_values){
                        $p_eta = $p_values->quantity;
                        $p_po = $p_values->po_res_number;
                        $p_barge = $p_values->barge_id;
                    }
                    
                    $curr_data =array(
                        'inventory' => $stock_realtime,
                        'distribution' => $t_distribution,
                        'eta_schedule' => $p_eta,
                        'barge_id' => $p_barge,
                        'po_res_number' => $p_po
                    );
                    
                    $this->Model_schedule->update_curr_forecast($i,$curr_data);
                } else {
                    $next_realtime=0;
                    
                    $get_before = $this->Model_schedule->get_idtrans_before($i);
                    $b_inventory=0; $b_distribution=0; $b_eta=0; $b_po='';
                    foreach ($get_before as $b_values){
                        $b_inventory = $b_values->inventory;
                        $b_distribution = $b_values->distribution;
                        $b_eta = $b_values->eta_schedule;
                        $b_po = $b_values->po_res_number;
                    }
                    
                    
                    $get_last_forecast = $this->Model_schedule->get_last_forecast($i);
                    $l_trans_date=''; $l_inventory=0; $l_distribution=0; $l_eta=0; $l_barge=0; $l_po_num='';
                    foreach($get_last_forecast as $l_values){
                        $l_trans_date = $l_values->trans_date;
                        $l_inventory = $l_values->inventory;
                        $l_distribution = $l_values->distribution;
                        $l_eta = $l_values->eta_schedule;
                        $l_barge = $l_values->barge_id;
                        $l_po_num = $l_values->po_res_number;
                    }
                    
                    
                    $get_po = $this->Model_schedule->get_trans_po($storage_id,$l_trans_date);
                    $p_eta=0; $p_po=''; $p_barge=0;
                    foreach ($get_po as $p_values){
                        $p_eta = $p_values->quantity;
                        $p_po = $p_values->po_res_number;
                        $p_barge = $p_values->barge_id;
                    }
                    $next_realtime = $b_inventory-$b_distribution+$l_eta;
                    
                    
                        
                        $data = array(
                            'inventory' => $next_realtime,
                            'distribution' => $l_distribution,
                            'eta_schedule' => $l_eta,
                            /*'barge_id' => $l_barge,
                            'po_res_number' => $l_po_num*/
                        );
                        $this->Model_schedule->update_curr_forecast($i,$data);
                    //}
                   
                }
            }
        }
            //return $result;
        }
	
	function forecast_recalculate($id, $max_id) {
		// cek volume atg terkini
		$data_trans_atg = $this->Model_schedule->get_trans_atg($id);
		$atg_volume=0;$qty_manual=0;
                if($data_trans_atg == null){
                $data_trans_atg = $this->Model_schedule->get_trans_atg_null($id,1);
                if($data_trans_atg == null){
                    $data_trans_atg = $this->Model_schedule->get_trans_atg_null($id,2);
                    if($data_trans_atg == null){
                        $data_trans_atg = $this->Model_schedule->get_trans_atg_null($id,3);
                        if($data_trans_atg == null){
                            $data_trans_atg = $this->Model_schedule->get_trans_atg2($id);
                        }
                    }
                }
            }
		foreach ($data_trans_atg as $row) {
            	$atg_volume = $atg_volume + $row->volume;
                    if($row->qty_observe != null){
                        $atg_volume = $atg_volume - $row->volume;
                    }
                    $qty_manual = $qty_manual + $row->qty_observe;
                }
                $total = $atg_volume+$qty_manual;
		
		// update parameter
		$data = array(
			'stock_realtime' => $total
		);		
		$this->Model_schedule->update_mst_parameter($data, $id);
		
		// cek parameter
		$data_mst_parameter = $this->Model_schedule->get_mst_parameter($id);
		$stock_realtime=0; $stock_min=0; $stock_distribution_parameter=0; $stock_distribution_max_parameter=0;
                $reorder_point=0;
		foreach ($data_mst_parameter as $row) {
			$stock_realtime = $row->stock_realtime;
			$stock_min = $row->stock_min;
			$stock_distribution_parameter = $row->average_distribution;
			$stock_distribution_max_parameter = $row->average_distribution_max;
                        $reorder_point = $row->reorder_point;
		}
		
		if ($max_id != null) {
			$trans_id = $max_id;			
		} else {
			$trans_id = 0;
		}
		$this->Model_schedule->update_status();
		date_default_timezone_set('Asia/Jakarta');
		$tanggal = date('Y-m-d');
		$tanggal_sekarang = date('Y-m-d');
		$last_date = date('Y-m-d');
		
		// create forecast
		for ($i=1; $i<=90; $i++) {
			// cek stok bulan sebelumnya di tanggal yg sama
			$time = strtotime($tanggal);
			$tanggal_bef = date("Y-m-d", strtotime("-1 month", $time));
			
			if ($tanggal==$tanggal_sekarang) {
				$stock_distribution = rand($stock_distribution_parameter,$stock_distribution_max_parameter);
				
				$data_po = $this->Model_schedule->get_trans_po($id,$tanggal);
				$eta_schedule = 0; $po_res_number=''; $barge_id=0;
				foreach ($data_po as $row) {
					$eta_schedule = $row->quantity;
					$po_res_number = $row->po_res_number;
					$barge_id = $row->barge_id;
				}
			} else {
				$stock_distribution = rand($stock_distribution_parameter,$stock_distribution_max_parameter);
				$last_forecast = $this->Model_schedule->last_forecast_byDate($last_date);
                $l_stoc=0;$l_distribution=0;$l_eta=0;
                foreach($last_forecast as $val){
                    $l_stoc = $val->inventory;
                    $l_distribution = $val->distribution;
                    $l_eta = $val->eta_schedule;
                }
				
				$data_po = $this->Model_schedule->get_trans_po($id,$tanggal);
				$eta_schedule = 0; $po_res_number=''; $barge_id=0;
				foreach ($data_po as $row) {
					$eta_schedule = $row->quantity;
					$po_res_number = $row->po_res_number;
					$barge_id = $row->barge_id;
				}
				
				$stock_realtime=$l_stoc-$l_distribution+$l_eta;
				
				// jika inv. kurang dari min. stok cek kapal
				if ($stock_realtime < $reorder_point) {
					
					$data_last = $this->Model_schedule->get_trans_forecast_last($id);
					$prioritas = 0;
					foreach ($data_last as $row) {
						$prioritas = $row->prioritas;
					}
					
					$prioritas_max = $this->Model_schedule->max_mst_barge_prioritas($id);
					if ($prioritas==$prioritas_max) {
						$prioritas = 0;
					}

					$data_barge = $this->Model_schedule->get_mst_barge($id, $prioritas);
					foreach ($data_barge as $row) {
						$barge_id = $row->barge_id;
						$eta_schedule = $row->volume;
					}
					
					$stock_realtime=$l_stoc-$l_distribution;

					// tampilkan query
					// $this->output->enable_profiler(TRUE);
				}
			}			

			$data = array(
				'trans_id' => ($trans_id + $i),
				'trans_date' => $tanggal,
				'inventory' => $stock_realtime,
				'distribution' => $stock_distribution,
				'eta_schedule' => $eta_schedule,
				'po_res_number' => $po_res_number,
				'barge_id' => $barge_id,
				'storage_id' => $id
			);
			$this->Model_schedule->insert_trans_forecast($data);
			
			// $stock_realtime=$stock_realtime-$stock_distribution;
			$last_date = $tanggal;
			$date=date_create($tanggal);
			date_add($date,date_interval_create_from_date_string("1 days"));
			$tanggal = date_format($date,"Y-m-d");
                        }		
                
        }
	
	function logout(){
			$this->session->sess_destroy();
			redirect(base_url('login'));
	}
}
