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
		<?php echo form_open("schedule/cari"); ?>
		<table cellpadding="2">
		  <tr>
			<td colspan="3" align="center"><h3>Snapshot</h3></td>
		  </tr>
		  <tr>
			<td>Year</td>
			<td><input type="number" name="p_year" class="form-control" placeholder="Year" value="<?php echo $tahun; ?>" required></td>
		  </tr>
		  <tr>
			<td>Period</td>
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
			<td id="p_period_sub_year">Sub Period</td>
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
		</table>
		<?php echo form_close(); ?>
	</div>
	<div class="leftmenufilter"><canvas id="myChart"></canvas></div>	
	<div class="leftmenufilter"><center>
		<table cellpadding="2" border="1" width="100%" style="font-size: small;">
		  <tr>
			<th></th>
			<th>LMO</th>
			<th>SUR</th>
			<th>SMO</th>
		  </tr>
		  <tr>
			<td>PAN</td>
			<td>0</td>
			<td>0</td>
			<td>3.000.000</td>
		  </tr>
		  <tr>
			<td>AKR</td>
			<td>2.000.000</td>
			<td>4.000.000</td>
			<td>2.000.000</td>
		  </tr>
		  <tr>
			<td>PTM</td>
			<td>5.500.000</td>
			<td>7.000.000</td>
			<td>0</td>
		  </tr>
		</table>
	</div>
	<div class="leftmenufilter"><canvas id="myChart2"></canvas></div>	
	<div class="leftmenufilter"><center>
		<table cellpadding="2" border="1" width="100%" style="font-size: small;">
		  <tr>
			<th></th>
			<th>WRA</th>
			<th>TBS</th>
			<th>BRK</th>
			<th>AKR</th>
		  </tr>
		  <tr>
			<td>AKR</td>
			<td>2.000.000</td>
			<td>0</td>
			<td>2.000.000</td>
			<td>4.000.000</td>
		  </tr>
		  <tr>
			<td>PIM</td>
			<td>3.500.000</td>
			<td>5.500.000</td>
			<td>3.500.000</td>
			<td>0</td>
		  </tr>
		  <tr>
			<td>PAN</td>
			<td>0</td>
			<td>3.000.000</td>
			<td>0</td>
			<td>0</td>
		  </tr>
		</table>
	</div>
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
						<td align="right"><font color="<?php echo $warna; ?>"><?php echo $rec->po_res_number; ?></font></td>
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
							<td align="right"><font color="<?php echo $warna; ?>"><?php echo $rec->po_res_number; ?></font></td>
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
							<td align="right"><font color="<?php echo $warna; ?>"><?php echo $rec->po_res_number; ?></font></td>
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

<script>
$(document).ready(function(){
	$("#p_period_sub_date").show();
	$("#p_period_sub_month").hide();
	$("#p_period_sub_quarter").hide();
	$("#p_period_sub_year").show();
	
    $("#p_period").change(function(){		
		var status = this.value;
		// alert(status);

		if (status=="daily") {
			$("#p_period_sub_date").show();
		} else {
			$("#p_period_sub_date").hide();
		};
		
		if (status=="monthly") {
			$("#p_period_sub_month").show();
		} else {
			$("#p_period_sub_month").hide();
		};
		
		if (status=="quarterly") {
			$("#p_period_sub_quarter").show();
		} else {
			$("#p_period_sub_quarter").hide();
		};

		if (status=="yearly") {
			$("#p_period_sub_year").hide();
		} else {
			$("#p_period_sub_year").show();
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
            data: [0, 0, 3000000]
        }, {
            label: 'AKR',
            backgroundColor: 'green',
            borderColor: 'rgb(255, 99, 132)',
            data: [2000000, 4000000, 2000000]
		}, {
            label: 'PTM',
            backgroundColor: 'blue',
            borderColor: 'rgb(255, 99, 132)',
            data: [5500000, 7000000, 0]
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
            label: 'AKR',
            backgroundColor: 'red',
            borderColor: 'rgb(255, 99, 132)',
            data: [2000000, 0, 2000000, 4000000]
        }, {
            label: 'PTM',
            backgroundColor: 'blue',
            borderColor: 'rgb(255, 99, 132)',
            data: [3500000, 5500000, 3500000, 0]
		}, {
            label: 'PAN',
            backgroundColor: 'yellow',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 3000000, 0, 0]
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