<?php
class Forecast extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
		$this->load->helper(array('url','html'));
		$this->load->database();
		$this->load->model('Model_schedule');
        $this->load->model('Model_home');
    }

    function index(){
        $this->auto_forecast();
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

    function forecast_recalculate($id, $max_id) {
		
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');
        
            $data_trans_atg = $this->Model_home->get_trans_atg($id);
            $atg_volume=0;$qty_manual=0;$total=0;
            if($data_trans_atg == null){
                $data_trans_atg = $this->Model_home->get_trans_atg_null($id,'1');
                if($data_trans_atg == null){
                    $data_trans_atg = $this->Model_home->get_trans_atg_null($id,'2');
                    if($data_trans_atg == null){
                        $data_trans_atg = $this->Model_home->get_trans_atg_null($id,'3');
                        if($data_trans_atg == null){
                            $data_trans_atg = $this->Model_home->get_trans_atg2($id);
                        }
                    }
                }
            }
            foreach ($data_trans_atg as $row) {
                $total += $row->volume;
                if($row->qty_observe != null){
                    $total = $total-$row->volume;
                    $qty_manual += $row->qty_observe;
                }

            }
            $atg_volume = $total+$qty_manual;
    // update parameter
    $data = array(
        'stock_realtime' => $atg_volume
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
    
    date_default_timezone_set('Asia/Jakarta');
    $tanggal = date('Y-m-d');
    $tanggal_sekarang = date('Y-m-d');
    $last_date = date('Y-m-d');
    // create forecast
    for ($i=1; $i<=60; $i++) {
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
            if ($stock_realtime < $stock_min) {
                
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
        
        //$stock_realtime=$stock_realtime-$stock_distribution+$eta_schedule;
        $last_date = $tanggal;
        $date=date_create($tanggal);
        date_add($date,date_interval_create_from_date_string("1 days"));
        $tanggal = date_format($date,"Y-m-d");
        
                    }		
            
    }
}
?>