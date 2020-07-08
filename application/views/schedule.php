<div class="container-fluid" >
<div class="row">
  <!------ Start Menu Left ---------->
  <div class="col-md-3" style="clear: both; padding: 0; margin: 0;">
	<nav class="leftmenu">
	  <ul class="navbar-nav">
		<li class="nav-item">
		  <a class="nav-link" href="<?php echo base_url(); ?>schedule"><img src="<?php echo base_url(); ?>assets/images/menu-schedule.png"><div class="menu-satu">Schedule Decision System</div></a>
		</li>
	  </ul>
	</nav>
	
<div class="leftmenufilter card shadow">
	<div class="leftmenufilter"><center>
		<?php echo form_open("schedule", array('method'=>'post')); ?>
		<table cellpadding="2">
		  <tr>
			<td colspan="3" align="center"><h3>Snapshot</h3></td>
		  </tr>
		  <tr>
			<td id="p_year_text">Year</td>
			<td><input type="number" name="p_year" id="p_year" class="form-control" placeholder="Year" value="<?php echo $tahun; ?>" required></td>
		  </tr>
		  <tr>
			<td id="p_period_text">Period</td>
			<td>
				<select name="p_period" id="p_period" class="form-control">
				  <option value="daily">Daily</option>
				  <option value="monthly">Monthly</option>
				  <option value="quarterly">Quarterly</option>
				  <option value="yearly">Yearly</option>
				</select>
			</td>
		  </tr>
		  <tr>
			<td id="p_period_sub_text">Sub Period</td>
			<td>
				<input type="date" name="p_period_sub_date" id="p_period_sub_date" class="form-control" placeholder="Daily" value="<?php echo $tanggal; ?>" required>

				<select name="p_period_sub_month" id="p_period_sub_month" class="form-control">
				  <option value="1">January</option>
				  <option value="2">February</option>
				  <option value="3">March</option>
				  <option value="4">April</option>
				  <option value="5">May</option>
				  <option value="6">June</option>
				  <option value="7">July</option>
				  <option value="8">August</option>
				  <option value="9">September</option>
				  <option value="10">October</option>
				  <option value="11">November</option>
				  <option value="12">December</option>
				</select>

				<select name="p_period_sub_quarter" id="p_period_sub_quarter" class="form-control">
				  <option value="q1">Q1</option>
				  <option value="q2">Q2</option>
				  <option value="q3">Q3</option>
				  <option value="q4">Q4</option>
				</select>
			</td>
		  </tr>
		  <tr>
			<td></td>
			<td>
				<button class="btn btn-primary btn-icon-split" type="submit">
					<span class="icon text-white-50"><i class="fas fa-check"></i></span>
					<span class="text">Search</span></button>
			</td>
		  </tr>
                  <tr>
                      <td></td>
                  </tr>
		</table>
		<?php echo form_close(); ?>
		<!--<?php echo $filter_result; ?>-->
	</div>
	<div class="leftmenufilter"><canvas id="myChart"></canvas></div>	
        <div class="leftmenufilter"><canvas id="myChart2"></canvas></div>
</div>
 </div>
  <!------ End Menu Left ---------->

  <!------ Start content ---------->
  <div class="col-md-9">

<div class="col-md-12">
	<div class="row">
		<div class="col-md-4">
			<div class="card shadow">
				<div class="card-body">Parameter - <?php echo $s1_storage_name; ?></div>
				<table cellpadding="2" border="1" width="100%" style="font-size: x-small;">
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Lead Time</b></font></td>
					<td align="right"><?php echo $s1_lead_time; ?> day</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Dead Stock</b></font></td>
					<td align="right"><?php echo number_format($s1_dead_stock, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Average Dist. / day</b></font></td>
					<td align="right"><?php echo number_format($s1_average_distribution, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Max Dist. / day</b></font></td>
					<td align="right"><?php echo number_format($s1_average_distribution_max, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Safety Stock</b></font></td>
					<td align="right"><?php echo number_format($s1_safety_stock, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Reorder Point</b></font></td>
					<td align="right"><?php echo number_format($s1_reorder_point, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Max Stock</b></font></td>
					<td align="right"><?php echo number_format($s1_stock_max, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Min Stock</b></font></td>
					<td align="right"><?php echo number_format($s1_stock_min, 2, ',', '.');?> L</td>
				  </tr>
				</table>
                                <!--<?php echo $testmax->max_id; ?>-->
			</div>
			
			<div class="card shadow">
				<div class="card-body">Forecast Schedule - <?php echo $s1_parameter_name; ?></div>
				<div class="table-responsive">
					<table cellpadding="2" class="table table-bordered table-striped" width="100%" style="font-size: x-small;">
					  <tr>
						<th>Date</th>
						<th>Inventory</th>
						<th>Distribution</th>
						<th>ETA Schedule</th>
						<th>Barge</th>
						<th>PO</th>
					  </tr>
						<?php 
						if( !empty($s1_forecast) ) {
							foreach($s1_forecast as $rec){ 
							
							$quantity=''; $quantity_text=''; $warna='red';
							if ($rec->eta_schedule > 0) {
								$quantity=number_format($rec->eta_schedule, 0, ',', '.') .' L';
							}
							
							if ($rec->po_res_number!=null) {
								$warna='green';
							}
						?>
					  <tr>
						<td align="right"><?php echo $rec->trans_date; ?></td>
						<td align="right"><?php echo number_format($rec->inventory, 0, ',', '.'); ?> L</td>
						<td align="right"><?php echo number_format($rec->distribution, 0, ',', '.'); ?> L</td>
						<td align="right"><font color="<?php echo $warna; ?>"><?php echo $quantity; ?></font></td>
						<td align="right"><font color="<?php echo $warna; ?>"><?php echo $rec->barge_name; ?></font></td>
						<td align="right"><font color="<?php echo $warna; ?>"><?php echo substr($rec->po_res_number,11); ?></font></td>
					  </tr>
						<?php 
							} 				
						}
						?>
					</table>
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="card shadow">
				<div class="card-body">Parameter - <?php echo $s2_storage_name; ?></div>
				<table cellpadding="2" border="1" width="100%" style="font-size: x-small;">
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Lead Time</b></font></td>
					<td align="right"><?php echo $s2_lead_time; ?> day</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Dead Stock</b></font></td>
					<td align="right"><?php echo number_format($s2_dead_stock, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Average Dist. / day</b></font></td>
					<td align="right"><?php echo number_format($s2_average_distribution, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Max Dist. / day</b></font></td>
					<td align="right"><?php echo number_format($s2_average_distribution_max, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Safety Stock</b></font></td>
					<td align="right"><?php echo number_format($s2_safety_stock, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Reorder Point</b></font></td>
					<td align="right"><?php echo number_format($s2_reorder_point, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Max Stock</b></font></td>
					<td align="right"><?php echo number_format($s2_stock_max, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Min Stock</b></font></td>
					<td align="right"><?php echo number_format($s2_stock_min, 2, ',', '.');?> L</td>
				  </tr>
				</table>
			</div>
			
			<div class="card shadow">
				<div class="card-body">Forecast Schedule - <?php echo $s2_parameter_name; ?></div>
				<div class="table-responsive">
					<table cellpadding="2" class="table table-bordered table-striped" width="100%" style="font-size: x-small;">
					  <tr>
						<th>Date</th>
						<th>Inventory</th>
						<th>Distribution</th>
						<th>ETA Schedule</th>
						<th>Barge</th>
						<th>PO</th>
					  </tr>
							<?php 
							if( !empty($s2_forecast) ) {
								foreach($s2_forecast as $rec){ 
								
								$quantity=''; $quantity_text=''; $warna='red';
								if ($rec->eta_schedule > 0) {
									$quantity=number_format($rec->eta_schedule, 0, ',', '.') .' L';
								}
								
								if ($rec->po_res_number!=null) {
									$warna='green';
								}
							?>
						  <tr>
							<td align="right"><?php echo $rec->trans_date; ?></td>
							<td align="right"><?php echo number_format($rec->inventory, 0, ',', '.'); ?> L</td>
							<td align="right"><?php echo number_format($rec->distribution, 0, ',', '.'); ?> L</td>
							<td align="right"><font color="<?php echo $warna; ?>"><?php echo $quantity; ?></font></td>
							<td align="right"><font color="<?php echo $warna; ?>"><?php echo $rec->barge_name; ?></font></td>
							<td align="right"><font color="<?php echo $warna; ?>"><?php echo substr($rec->po_res_number,11); ?></font></td>
						  </tr>
							<?php 
								} 				
							}
							?>
					</table>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card shadow">
				<div class="card-body">Parameter - <?php echo $s3_storage_name; ?></div>
				<table cellpadding="2" border="1" width="100%" style="font-size: x-small;">
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Lead Time</b></font></td>
					<td align="right"><?php echo $s3_lead_time; ?> day</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Dead Stock</b></font></td>
					<td align="right"><?php echo number_format($s3_dead_stock, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Average Dist. / day</b></font></td>
					<td align="right"><?php echo number_format($s3_average_distribution, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Max Dist. / day</b></font></td>
					<td align="right"><?php echo number_format($s3_average_distribution_max, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Safety Stock</b></font></td>
					<td align="right"><?php echo number_format($s3_safety_stock, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Reorder Point</b></font></td>
					<td align="right"><?php echo number_format($s3_reorder_point, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Max Stock</b></font></td>
					<td align="right"><?php echo number_format($s3_stock_max, 2, ',', '.');?> L</td>
				  </tr>
				  <tr>
					<td bgcolor="#a2d668"><font color="white"><b>Min Stock</b></font></td>
					<td align="right"><?php echo number_format($s3_stock_min, 2, ',', '.');?> L</td>
				  </tr>
				</table>
			</div>
			
			<div class="card shadow">
				<div class="card-body">Forecast Schedule - <?php echo $s3_parameter_name; ?></div>
				<div class="table-responsive">
					<table cellpadding="2" class="table table-bordered table-striped" width="100%" style="font-size: x-small;">
					  <tr>
						<th>Date</th>
						<th>Inventory</th>
						<th>Distribution</th>
						<th>ETA Schedule</th>
						<th>Barge</th>
						<th>PO</th>
					  </tr>
							<?php 
							if( !empty($s3_forecast) ) {
								foreach($s3_forecast as $rec){ 
								
								$quantity=''; $quantity_text=''; $warna='red';
								if ($rec->eta_schedule > 0) {
									$quantity=number_format($rec->eta_schedule, 0, ',', '.') .' L';
								}
								
								if ($rec->po_res_number!=null) {
									$warna='green';
								}
							?>
						  <tr>
							<td align="right"><?php echo $rec->trans_date; ?></td>
							<td align="right"><?php echo number_format($rec->inventory, 0, ',', '.'); ?> L</td>
							<td align="right"><?php echo number_format($rec->distribution, 0, ',', '.'); ?> L</td>
							<td align="right"><font color="<?php echo $warna; ?>"><?php echo $quantity; ?></font></td>
							<td align="right"><font color="<?php echo $warna; ?>"><?php echo $rec->barge_name; ?></font></td>
							<td align="right"><font color="<?php echo $warna; ?>"><?php echo substr($rec->po_res_number,11); ?></font></td>
						  </tr>
							<?php 
								} 				
							}
							?>
					</table>
				</div>
			</div>
		</div>

	</div>
</div>

<!-- Filter -->
<script>
$(document).ready(function(){
	$("#p_period_sub_date_text").show();
	$("#p_period_sub_date").show();
	$("#p_year_text").hide();
	$("#p_year").hide();
	$("#p_period_text").show();
	$("#p_period_sub_text").show();	
	$("#p_period_sub_month").hide();
	$("#p_period_sub_quarter").hide();
	
    $("#p_period").change(function(){		
		var status = this.value;
		// alert(status);

		if (status=="daily") {
			$("#p_period_sub_date_text").show();
			$("#p_period_sub_date").show();
			$("#p_year_text").hide();
			$("#p_year").hide();
			$("#p_period_text").show();
			$("#p_period_sub_text").show();	
			$("#p_period_sub_month").hide();
			$("#p_period_sub_quarter").hide();
		};
		
		if (status=="monthly") {
			$("#p_period_sub_date_text").hide();
			$("#p_period_sub_date").hide();
			$("#p_year_text").show();
			$("#p_year").show();
			$("#p_period_text").show();
			$("#p_period_sub_text").show();	
			$("#p_period_sub_month").show();
			$("#p_period_sub_quarter").hide();
		};
		
		if (status=="quarterly") {
			$("#p_period_sub_date_text").hide();
			$("#p_period_sub_date").hide();
			$("#p_year_text").show();
			$("#p_year").show();
			$("#p_period_text").show();
			$("#p_period_sub_text").show();	
			$("#p_period_sub_month").hide();
			$("#p_period_sub_quarter").show();
		};

		if (status=="yearly") {
			$("#p_period_sub_date_text").hide();
			$("#p_period_sub_date").hide();
			$("#p_year_text").show();
			$("#p_year").show();
			$("#p_period_text").show();
			$("#p_period_sub_text").hide();	
			$("#p_period_sub_month").hide();
			$("#p_period_sub_quarter").hide();
		};

	});
});
</script>

<script>
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',
    // The data for our dataset
    data: {
        labels: ['LMO', 'SUR', 'SMO'],
        datasets: [{
            label: 'PAN',
            backgroundColor: 'orange',
            borderColor: 'rgb(255, 99, 132)',
            data: [<?= $sum_pan_lmo ?>, <?= $sum_pan_sur ?>, <?= $sum_pan_sam ?>]
        }, {
            label: 'AKR',
            backgroundColor: 'green',
            borderColor: 'rgb(255, 99, 132)',
            data: [<?= $sum_akr_lati ?>, <?= $sum_akr_sur ?>, <?= $sum_akr_sam ?>]
		}, {
            label: 'PTM',
            backgroundColor: 'blue',
            borderColor: 'rgb(255, 99, 132)',
            data: [<?= $sum_ptm_lmo ?>, <?= $sum_ptm_sur ?>, <?= $sum_ptm_sam ?>]
		}]
    },
	
	options: {
			title: {
				display: true,
				text: 'Confirm Order to Vendor by Release PO'
			},
		responsive: true,
		legend: {
			display: false,
			position: 'right' // place legend on the right side of chart
		},
		scales: {
			xAxes: [{
				stacked: true // this should be set to make the bars stacked
			}],
			yAxes: [{
				stacked: true // this also..
			}]
		}
	}
});
</script>

<script>
var ctx = document.getElementById('myChart2').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',
    // The data for our dataset
    data: {
        labels: ['WRA', 'TBS', 'BRK', 'AKR'],
        datasets: [{
            label: 'LMO',
            backgroundColor: 'red',
            borderColor: 'rgb(255, 99, 132)',
            data: [<?= $sum_wra_lmo ?>, <?= $sum_tbs_lmo ?>, <?= $sum_brk_lmo ?>, <?= $sum_akr_lmo ?>]
        }, {
            label: 'SUR',
            backgroundColor: 'blue',
            borderColor: 'rgb(255, 99, 132)',
            data: [<?= $sum_wra_sur ?>, <?= $sum_tbs_sur ?>, <?= $sum_brk_sur ?>, <?= $sum_akr_sur ?>]
		}, {
            label: 'SAM',
            backgroundColor: 'yellow',
            borderColor: 'rgb(255, 99, 132)',
            data: [<?= $sum_wra_sam ?>, <?= $sum_tbs_sam ?>, <?= $sum_brk_sam ?>, <?= $sum_trans_akr_sam ?>]
		}]
    },
	
	options: {
			title: {
				display: true,
				text: 'Transporter Utilization by Confirm PO'
			},
		responsive: true,
		legend: {
			display: false,
			position: 'right' // place legend on the right side of chart
		},
		scales: {
			xAxes: [{
				stacked: true // this should be set to make the bars stacked
			}],
			yAxes: [{
				stacked: true // this also..
			}]
		}
	}
});
</script>

<script>

setInterval(function(){
	/*$.ajax({
		url: '<?php echo base_url() ?>index.php/schedule/getStatus/',
		type: 'post',
		dataType: 'json',
		success: function(result){
			
		}
	});*/
}, 1000);
// var ctx = document.getElementById('myChart').getContext('2d');
// var chart = new Chart(ctx, {
    // // The type of chart we want to create
    // type: 'bar',

    // // The data for our dataset
    // data: {
        // labels: ['January', 'February', 'March'],
        // datasets: [{
            // label: 'My First dataset',
            // backgroundColor: 'rgb(255, 99, 132)',
            // borderColor: 'rgb(255, 99, 132)',
            // data: [20, 30, 45]
        // }]
    // },

    // // Configuration options go here
	// options: {
			// title: {
				// display: true,
				// text: 'Confirm Order to Vendor'
			// }
    // },
// });

// var ctx = document.getElementById('myChart2').getContext('2d');
// var chart = new Chart(ctx, {
    // // The type of chart we want to create
    // type: 'bar',

    // // The data for our dataset
    // data: {
        // labels: ['January', 'February', 'March'],
        // datasets: [{
            // label: 'My First dataset',
            // backgroundColor: 'rgb(255, 99, 132)',
            // borderColor: 'rgb(255, 99, 132)',
            // data: [20, 30, 45]
        // }]
    // },

    // // Configuration options go here
	// options: {
			// title: {
				// display: true,
				// text: 'Transporter Utilization'
			// }
    // },
// });
</script>