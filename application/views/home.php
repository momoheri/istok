<div class="container-fluid" style="background-color:#92d14f;">
<div class="row">
  <!------ Start Menu Left ---------->
  <div class="col-md-3">
	<nav class="sidenav">
	  <ul class="navbar-nav">
		<li class="nav-item jarak">
		  <a class="" href="<?php echo base_url(); ?>home">&nbsp;<img src="<?php echo base_url(); ?>assets/images/person.jpg" class="rounded-circle" alt="Cinque Terre" width="80" height="80"><div class="menu-satu"><?php echo " Hi, " .$user_name; ?></div></a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="<?php echo base_url(); ?>monitoring"><img src="<?php echo base_url(); ?>assets/images/menu-rm.png"><div class="menu-dua">Reporting & Monitoring</div></a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="<?php echo base_url(); ?>schedule"><img src="<?php echo base_url(); ?>assets/images/menu-schedule.png"><div class="menu-tiga">Schedule Decision System</div></a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="<?php echo base_url(); ?>supply"><img src="<?php echo base_url(); ?>assets/images/menu-sup.png"><div class="menu-empat">Supply Chain Performance</div></a>
		</li>
	  </ul>
	</nav>
  </div>
  <!------ End Menu Left ---------->

  <!------ Start content ---------->
  <div class="col-md-9">

<div class="col-md-12">
	<div class="row">
		<div class="col-md-4">
			<br>
			<div class="tank-tittle"><font color="white"><center><?php echo $s1_storage_name; ?></center></font></div>
			<div><canvas id="myCanvas" height="300"></canvas></div>
			<?php
				// set visual Tank
				$volume=0; $ullage=0; $nilai=0; $ullage_tank1=0; $s1_pesan='';
				
				$visual=300;
				$total=$s1_storage_height;
				
				$volume=$s1_sum_volume;
				$ullage=$s1_sum_ullage;
				
				if ($total>0) {
					// $nilai=($ullage/$total)*100;
					$nilai=100-(($volume/$total)*100);
					$ullage_tank1=$visual*($nilai/100);
				} else {
					$nilai=0;
					$ullage_tank1=$visual;
				}
				
				if ($total<($volume+$ullage)) {
					$s1_pesan='tinggi storage lebih kecil dari total tinggi ATG';
				}
				//--------------------------------------------------------------------------------
				// set visual Tank parameter (max, min, reoder, safety)
				$s1_visual_stock_max=0; $s1_visual_reorder_point=0; 
				$s1_visual_stock_min=0; $s1_visual_safety_stock=0;
				// stock_max
				$nilai=100-(($s1_stock_max/$s1_storage_height)*100);
				$s1_visual_stock_max=($visual*$nilai)/100;
				// reorder_point
				$nilai=100-(($s1_reorder_point/$s1_storage_height)*100);
				$s1_visual_reorder_point=($visual*$nilai)/100;
				// stock_min
				$nilai=100-(($s1_stock_min/$s1_storage_height)*100);
				$s1_visual_stock_min=($visual*$nilai)/100;
				// stock_min
				$nilai=100-(($s1_safety_stock/$s1_storage_height)*100);
				$s1_visual_safety_stock=($visual*$nilai)/100;
				
				if ($s1_storage_height<$s1_stock_max) {
					echo 'max stock lebih besar dari tinggi storage';
				}
				if ($s1_storage_height<$s1_reorder_point) {
					echo 'reorder point lebih besar dari tinggi storage';
				}
				if ($s1_storage_height<$s1_stock_min) {
					echo 'min stock lebih besar dari tinggi storage';
				}
				if ($s1_storage_height<$s1_safety_stock) {
					echo 'safety stock lebih besar dari tinggi storage';
				}
			?>
			<div class="tank-isi">
				<table style="width:100%; font-size: small;">
				  <tr>
					<td width="150">Stock Reability</td>
					<td><?php $reability_lmo = $s1_sum_volume/$s1_average_distribution; echo floor($reability_lmo); ?> days</td>
					<td>
						<?php if($s1_sum_volume >= $s1_stock_min) { ?>
							<img src="<?php echo base_url(); ?>assets/images/sign-yes.png" width="20" height="20" alt="">
						<?php } else { ?>
							<img src="<?php echo base_url(); ?>assets/images/sign-no.png" width="20" height="20" alt="">
						<?php } ?>
					</td>
				  </tr>
				</table>
			</div>
			<div class="tank-isi">
				<table style="width:100%; font-size: small;">
				  <tr>
					<td width="150">ETA Status</td>
					<td>
						<?php 
							if ($s1_po_posting_date==null) {
								$jum_hari=0;
							} else {
								$now = strtotime($tanggal); // or your date as well
								$your_date = strtotime($s1_po_posting_date);
								$datediff = $your_date - $now;

								$jum_hari = round($datediff / (60 * 60 * 24));
							}
						?>
						<?php echo $jum_hari; ?> days
					</td>
					<td>
						<?php 
							$total = ($s1_average_distribution*$jum_hari) + $s1_po_quantity;
							if ($total>0) {
								$eta_alert = floor($s1_sum_volume/$total);
							} else {
								$eta_alert = 0;
							}
						?>
						<?php if( $reability_lmo > $jum_hari) { ?>
							<img src="<?php echo base_url(); ?>assets/images/sign-yes.png" width="20" height="20" alt="">
						<?php } else { ?>
							<img src="<?php echo base_url(); ?>assets/images/sign-no.png" width="20" height="20" alt="">
						<?php } ?>
					</td>
				  </tr>
				</table>
			</div>
			<div class="tank-isi">
				<table style="width:100%; font-size: small;">
				  <tr>
					<th>Clean Liness</th>
					<th>ISO Standard</th>
					<th>Actual</th>
				  </tr>
				  <tr>
					<td>- Inlet</td>
					<td><?php echo $s1_inlet_iso4; ?> / <?php echo $s1_inlet_iso6; ?> / <?php echo $s1_inlet_iso14; ?></td>
					<td>
						<?php 
							if($s1_in_iso4a<$s1_inlet_iso4) {
								echo '<font color="red">'.$s1_in_iso4a.'</font>'; 
							} else {
								echo $s1_in_iso4a; 
							}
						?>
						<?php 
							if($s1_in_iso6a<$s1_inlet_iso6) {
								echo '/ <font color="red">'.$s1_in_iso6a.'</font> /'; 
							} else {
								echo '/ '.$s1_in_iso6a.' /'; 
							}
						?>
						<?php 
							if($s1_in_iso14a<$s1_inlet_iso14) {
								echo '<font color="red">'.$s1_in_iso14a.'</font>'; 
							} else {
								echo $s1_in_iso14a; 
							}
						?>
					</td>
				  </tr>
				  <tr>
					<td>- Outlet</td>
					<td><?php echo $s1_outlet_iso4; ?> / <?php echo $s1_outlet_iso6; ?> / <?php echo $s1_outlet_iso14; ?></td>
					<td>
						<?php 
							if($s1_out_iso4a<$s1_outlet_iso4) {
								echo '<font color="red">'.$s1_out_iso4a.'</font>'; 
							} else {
								echo $s1_out_iso4a; 
							}
						?>
						<?php 
							if($s1_out_iso6a<$s1_outlet_iso6) {
								echo '/ <font color="red">'.$s1_out_iso6a.'</font> /'; 
							} else {
								echo '/ '.$s1_out_iso6a.' /'; 
							}
						?>
						<?php 
							if($s1_out_iso14a<$s1_outlet_iso14) {
								echo '<font color="red">'.$s1_out_iso14a.'</font>'; 
							} else {
								echo $s1_out_iso14a; 
							}
						?>
					</td>
				  </tr>
				</table>
			</div>
			<div><canvas id="myChart"></canvas></div>
		</div>
		<div class="col-md-4">
			<br>
			<div class="tank-tittle"><font color="white"><center><?php echo $s2_storage_name; ?></center></font></div>
			<div><canvas id="myCanvas2" height="300"></canvas></div>
			<?php
				// set visual Tank
				$volume=0; $ullage=0; $nilai=0; $ullage_tank2=0; $s2_pesan='';
				
				$visual=300;
				$total=$s2_storage_height;
				
				$volume=$s2_sum_volume;
				$ullage=$s2_sum_ullage;
				
				if ($total>0) {
					// $nilai=($ullage/$total)*100;
					$nilai=100-(($volume/$total)*100);
					$ullage_tank2=$visual*($nilai/100);
				} else {
					$nilai=0;
					$ullage_tank2=$visual;
				}
				
				if ($total<($volume+$ullage)) {
					$s2_pesan='tinggi storage lebih kecil dari total tinggi ATG';
				}
				//--------------------------------------------------------------------------------
				// set visual Tank parameter (max, min, reoder, safety)
				$s2_visual_stock_max=0; $s2_visual_reorder_point=0; 
				$s2_visual_stock_min=0; $s2_visual_safety_stock=0;
				// stock_max
				$nilai=100-(($s2_stock_max/$s2_storage_height)*100);
				$s2_visual_stock_max=($visual*$nilai)/100;
				// reorder_point
				$nilai=100-(($s2_reorder_point/$s2_storage_height)*100);
				$s2_visual_reorder_point=($visual*$nilai)/100;
				// stock_min
				$nilai=100-(($s2_stock_min/$s2_storage_height)*100);
				$s2_visual_stock_min=($visual*$nilai)/100;
				// stock_min
				$nilai=100-(($s2_safety_stock/$s2_storage_height)*100);
				$s2_visual_safety_stock=($visual*$nilai)/100;
				
				if ($s2_storage_height<$s2_stock_max) {
					echo 'max stock lebih besar dari tinggi storage';
				}
				if ($s2_storage_height<$s2_reorder_point) {
					echo 'reorder point lebih besar dari tinggi storage';
				}
				if ($s2_storage_height<$s2_stock_min) {
					echo 'min stock lebih besar dari tinggi storage';
				}
				if ($s2_storage_height<$s2_safety_stock) {
					echo 'safety stock lebih besar dari tinggi storage';
				}
			?>
			<div class="tank-isi">
				<table style="width:100%; font-size: small;">
				  <tr>
					<td width="150">Stock Reability</td>
					<td><?php $reability_sur = $s2_sum_volume/$s2_average_distribution; echo floor($reability_sur); ?> days</td>
					<td>
						<?php if($s2_sum_volume >= $s2_stock_min) { ?>
							<img src="<?php echo base_url(); ?>assets/images/sign-yes.png" width="20" height="20" alt="">
						<?php } else { ?>
							<img src="<?php echo base_url(); ?>assets/images/sign-no.png" width="20" height="20" alt="">
						<?php } ?>
					</td>
				  </tr>
				</table>
			</div>
			<div class="tank-isi">
				<table style="width:100%; font-size: small;">
				  <tr>
					<td width="150">ETA Status</td>
					<td>
						<?php 
							if ($s2_po_posting_date==null) {
								$jum_hari=0;
							} else {
								$now = strtotime($tanggal); // or your date as well
								$your_date = strtotime($s2_po_posting_date);
								$datediff = $your_date - $now;

								$jum_hari = round($datediff / (60 * 60 * 24));
							}
						?>
						<?php echo $jum_hari; ?> days
					</td>
					<td>
						<?php 
							$total = ($s2_average_distribution*$jum_hari) + $s2_po_quantity;
							if ($total>0) {
								$eta_alert = floor($s2_sum_volume/$total);
							} else {
								$eta_alert = 0;
							}
						?>
						<?php if($reability_sur > $jum_hari) { ?>
							<img src="<?php echo base_url(); ?>assets/images/sign-yes.png" width="20" height="20" alt="">
						<?php } else { ?>
							<img src="<?php echo base_url(); ?>assets/images/sign-no.png" width="20" height="20" alt="">
						<?php } ?>
					</td>
				  </tr>
				</table>
			</div>
			<div class="tank-isi">
				<table style="width:100%; font-size: small;">
				  <tr>
					<th>Clean Liness</th>
					<th>ISO Standard</th>
					<th>Actual</th>
				  </tr>
				  <tr>
					<td>- Inlet</td>
					<td><?php echo $s2_inlet_iso4; ?> / <?php echo $s2_inlet_iso6; ?> / <?php echo $s2_inlet_iso14; ?></td>
					<td>
						<?php 
							if($s2_in_iso4a<$s2_inlet_iso4) {
								echo '<font color="red">'.$s2_in_iso4a.'</font>'; 
							} else {
								echo $s2_in_iso4a; 
							}
						?>
						<?php 
							if($s2_in_iso6a<$s2_inlet_iso6) {
								echo '/ <font color="red">'.$s2_in_iso6a.'</font> /'; 
							} else {
								echo '/ '.$s2_in_iso6a.' /'; 
							}
						?>
						<?php 
							if($s2_in_iso14a<$s2_inlet_iso14) {
								echo '<font color="red">'.$s2_in_iso14a.'</font>'; 
							} else {
								echo $s2_in_iso14a; 
							}
						?>
					</td>
				  </tr>
				  <tr>
					<td>- Outlet</td>
					<td><?php echo $s2_outlet_iso4; ?> / <?php echo $s2_outlet_iso6; ?> / <?php echo $s2_outlet_iso14; ?></td>
					<td>
						<?php 
							if($s2_out_iso4a<$s2_outlet_iso4) {
								echo '<font color="red">'.$s2_out_iso4a.'</font>'; 
							} else {
								echo $s2_out_iso4a; 
							}
						?>
						<?php 
							if($s2_out_iso6a<$s2_outlet_iso6) {
								echo '/ <font color="red">'.$s2_out_iso6a.'</font> /'; 
							} else {
								echo '/ '.$s2_out_iso6a.' /'; 
							}
						?>
						<?php 
							if($s2_out_iso14a<$s2_outlet_iso14) {
								echo '<font color="red">'.$s2_out_iso14a.'</font>'; 
							} else {
								echo $s2_out_iso14a; 
							}
						?>
					</td>
				  </tr>
				</table>
			</div>
			<div><canvas id="myChart2"></canvas></div>
		</div>
		<div class="col-md-4">
			<br>
			<div class="tank-tittle"><font color="white"><center><?php echo $s3_storage_name; ?></center></font></div>
			<div><canvas id="myCanvas3" height="300"></canvas></div>
			<?php
				// set visual Tank
				$volume=0; $ullage=0; $nilai=0; $ullage_tank3=0; $s3_pesan='';
				
				$visual=300;
				$total=$s3_storage_height;
				
				$volume=$s3_sum_volume;
				$ullage=$s3_sum_ullage;
				
				if ($total>0) {
					// $nilai=($ullage/$total)*100;
					$nilai=100-(($volume/$total)*100);
					$ullage_tank3=$visual*($nilai/100);
				} else {
					$nilai=0;
					$ullage_tank3=$visual;
				}
				
				if ($total<($volume+$ullage)) {
					$s3_pesan='tinggi storage lebih kecil dari total tinggi ATG';
				}
				//--------------------------------------------------------------------------------
				// set visual Tank parameter (max, min, reoder, safety)
				$s3_visual_stock_max=0; $s3_visual_reorder_point=0; 
				$s3_visual_stock_min=0; $s3_visual_safety_stock=0;
				// stock_max
				$nilai=100-(($s3_stock_max/$s3_storage_height)*100);
				$s3_visual_stock_max=($visual*$nilai)/100;
				// reorder_point
				$nilai=100-(($s3_reorder_point/$s3_storage_height)*100);
				$s3_visual_reorder_point=($visual*$nilai)/100;
				// stock_min
				$nilai=100-(($s3_stock_min/$s3_storage_height)*100);
				$s3_visual_stock_min=($visual*$nilai)/100;
				// stock_min
				$nilai=100-(($s3_safety_stock/$s3_storage_height)*100);
				$s3_visual_safety_stock=($visual*$nilai)/100;
				
				if ($s3_storage_height<$s3_stock_max) {
					echo 'max stock lebih besar dari tinggi storage';
				}
				if ($s3_storage_height<$s3_reorder_point) {
					echo 'reorder point lebih besar dari tinggi storage';
				}
				if ($s3_storage_height<$s3_stock_min) {
					echo 'min stock lebih besar dari tinggi storage';
				}
				if ($s3_storage_height<$s3_safety_stock) {
					echo 'safety stock lebih besar dari tinggi storage';
				}
			?>
			<div class="tank-isi">
				<table style="width:100%; font-size: small;">
				  <tr>
					<td width="150">Stock Reability</td>
					<td><?php $reability_sam = $s3_sum_volume/$s3_average_distribution; echo floor($reability_sam); ?> days</td>
					<td>
						<?php if($s3_sum_volume >= $s3_stock_min) { ?>
							<img src="<?php echo base_url(); ?>assets/images/sign-yes.png" width="20" height="20" alt="">
						<?php } else { ?>
							<img src="<?php echo base_url(); ?>assets/images/sign-no.png" width="20" height="20" alt="">
						<?php } ?>
					</td>
				  </tr>
				</table>
			</div>
			<div class="tank-isi">
				<table style="width:100%; font-size: small;">
				  <tr>
					<td width="150">ETA Status</td>
					<td>
						<?php 
							if ($s3_po_posting_date==null) {
								$jum_hari=0;
							} else {
								$now = strtotime($tanggal); // or your date as well
								$your_date = strtotime($s3_po_posting_date);
								$datediff = $your_date - $now;

								$jum_hari = round($datediff / (60 * 60 * 24));
							}
						?>
						<?php echo $jum_hari; ?> days
					</td>
					<td>
						<?php 
							$total = ($s3_average_distribution*$jum_hari) + $s3_po_quantity;
							if ($total>0) {
								$eta_alert = floor($s3_sum_volume/$total);
							} else {
								$eta_alert = 0;
							}
						?>
						<?php if($reability_sam > $jum_hari) { ?>
							<img src="<?php echo base_url(); ?>assets/images/sign-yes.png" width="20" height="20" alt="">
						<?php } else { ?>
							<img src="<?php echo base_url(); ?>assets/images/sign-no.png" width="20" height="20" alt="">
						<?php } ?>
					</td>
				  </tr>
				</table>
			</div>
			<div class="tank-isi">
				<table style="width:100%; font-size: small;">
				  <tr>
					<th>Clean Liness</th>
					<th>ISO Standard</th>
					<th>Actual</th>
				  </tr>
				  <tr>
					<td>- Inlet</td>
					<td><?php echo $s3_inlet_iso4; ?> / <?php echo $s3_inlet_iso6; ?> / <?php echo $s3_inlet_iso14; ?></td>
					<td>
						<?php 
							if($s3_in_iso4a<$s3_inlet_iso4) {
								echo '<font color="red">'.$s3_in_iso4a.'</font>'; 
							} else {
								echo $s3_in_iso4a; 
							}
						?>
						<?php 
							if($s3_in_iso6a<$s3_inlet_iso6) {
								echo '/ <font color="red">'.$s3_in_iso6a.'</font> /'; 
							} else {
								echo '/ '.$s3_in_iso6a.' /'; 
							}
						?>
						<?php 
							if($s3_in_iso14a<$s3_inlet_iso14) {
								echo '<font color="red">'.$s3_in_iso14a.'</font>'; 
							} else {
								echo $s3_in_iso14a; 
							}
						?>
					</td>
				  </tr>
				  <tr>
					<td>- Outlet</td>
					<td><?php echo $s3_outlet_iso4; ?> / <?php echo $s3_outlet_iso6; ?> / <?php echo $s3_outlet_iso14; ?></td>
					<td>
						<?php 
							if($s3_out_iso4a<$s3_outlet_iso4) {
								echo '<font color="red">'.$s3_out_iso4a.'</font>'; 
							} else {
								echo $s3_out_iso4a; 
							}
						?>
						<?php 
							if($s3_out_iso6a<$s3_outlet_iso6) {
								echo '/ <font color="red">'.$s3_out_iso6a.'</font> /'; 
							} else {
								echo '/ '.$s3_out_iso6a.' /'; 
							}
						?>
						<?php 
							if($s3_out_iso14a<$s3_outlet_iso14) {
								echo '<font color="red">'.$s3_out_iso14a.'</font>'; 
							} else {
								echo $s3_out_iso14a; 
							}
						?>
					</td>
				  </tr>
				</table>
			</div>
			<div><canvas id="myChart3"></canvas></div>
		</div>
	</div>
</div>

<script>
setTimeout(function() {
  location.reload();
}, 30000);
</script>

<script>
	<!-- tank 1 Visual -->
	var canvas = document.getElementById("myCanvas");
	var ctx = canvas.getContext("2d");

	ctx.beginPath();
	ctx.rect(canvas.width / 2 - 140, 0, 200, 300);
	ctx.fillStyle = "orange";
	ctx.fill();
	ctx.lineWidth = 1;
	ctx.strokeStyle = "black";
	ctx.stroke();

	ctx.beginPath();
	ctx.rect(canvas.width / 2 - 140, 0, 200, <?php echo $ullage_tank1; ?>);
	ctx.fillStyle = "white";
	ctx.fill();
	ctx.lineWidth = 1;
	ctx.strokeStyle = "black";
	ctx.stroke();

	<!-- tank 1 Volume Text -->
	ctx.font = "14px Arial";
	ctx.textAlign = "center";
	ctx.textBaseline = "middle";
	ctx.fillStyle = "black";
	<?php if ($s1_pesan=='') { ?>
		ctx.fillText("<?= number_format($s1_sum_volume) .' L' ?>", 110, canvas.height / 2);
	<?php } else { ?>
		ctx.fillText("<?= $s1_pesan ?>", canvas.width / 2, canvas.height / 2);
	<?php } ?>
	
	<!-- tank 1 Max Line -->
	ctx.beginPath();
	ctx.setLineDash([5, 5]);
	ctx.moveTo(0, <?php echo $s1_visual_stock_max; ?>);
	ctx.lineTo(220, <?php echo $s1_visual_stock_max; ?>);
	ctx.strokeStyle = "Red";
	ctx.stroke();

	<!-- tank 1 Max Text -->
	ctx.font = "12px Comic Sans MS";
	ctx.textAlign = "left";
	ctx.fillStyle = "red";
	ctx.fillText("Max Stock", 220, <?php echo $s1_visual_stock_max; ?>);
	
	<!-- tank 1 Reorder Line -->
	ctx.beginPath();
	ctx.setLineDash([5, 5]);
	ctx.moveTo(0, <?php echo $s1_visual_reorder_point; ?>);
	ctx.lineTo(220, <?php echo $s1_visual_reorder_point; ?>);
	ctx.strokeStyle = "Blue";
	ctx.stroke();
	
	<!-- tank 1 Reorder Text -->
	ctx.font = "12px Comic Sans MS";
	ctx.textAlign = "left";
	ctx.fillStyle = "Blue";
	ctx.fillText("Reorder Point", 220, <?php echo $s1_visual_reorder_point; ?>);
	
	<!-- tank 1 Min Line -->
	ctx.beginPath();
	ctx.setLineDash([5, 5]);
	ctx.moveTo(0, <?php echo $s1_visual_stock_min; ?>);
	ctx.lineTo(220, <?php echo $s1_visual_stock_min; ?>);
	ctx.strokeStyle = "red";
	ctx.stroke();
	
	<!-- tank 1 Reorder Text -->
	ctx.font = "12px Comic Sans MS";
	ctx.textAlign = "left";
	ctx.fillStyle = "red";
	ctx.fillText("Min Stock", 220, <?php echo $s1_visual_stock_min; ?>);
	
	<!-- tank 1 Safty Line -->
	ctx.beginPath();
	ctx.setLineDash([5, 5]);
	ctx.moveTo(0, <?php echo $s1_visual_safety_stock; ?>);
	ctx.lineTo(220, <?php echo $s1_visual_safety_stock; ?>);
	ctx.strokeStyle = "blue";
	ctx.stroke();
	
	<!-- tank 1 Safty Text -->
	ctx.font = "12px Comic Sans MS";
	ctx.textAlign = "left";
	ctx.fillStyle = "blue";
	ctx.fillText("Safety Stock", 220, <?php echo $s1_visual_safety_stock; ?>);
</script>

<script>
	<!-- tank 2 Visual -->
	var canvas = document.getElementById("myCanvas2");
	var ctx = canvas.getContext("2d");

	ctx.beginPath();
	ctx.rect(canvas.width / 2 - 140, 0, 200, 300);
	ctx.fillStyle = "orange";
	ctx.fill();
	ctx.lineWidth = 1;
	ctx.strokeStyle = "black";
	ctx.stroke();

	ctx.beginPath();
	ctx.rect(canvas.width / 2 - 140, 0, 200, <?php echo $ullage_tank2; ?>);
	ctx.fillStyle = "white";
	ctx.fill();
	ctx.lineWidth = 1;
	ctx.strokeStyle = "black";
	ctx.stroke();

	<!-- tank 2 Volume Text -->
	ctx.font = "14px Arial";
	ctx.textAlign = "center";
	ctx.textBaseline = "middle";
	ctx.fillStyle = "black";
	<?php if ($s2_pesan=='') { ?>
		ctx.fillText("<?= number_format($s2_sum_volume) .' L' ?>", 110, canvas.height / 2);
	<?php } else { ?>
		ctx.fillText("<?= $s2_pesan ?>", canvas.width / 2, canvas.height / 2);
	<?php } ?>
	
	<!-- tank 2 Max Line -->
	ctx.beginPath();
	ctx.setLineDash([5, 5]);
	ctx.moveTo(0, <?php echo $s2_visual_stock_max; ?>);
	ctx.lineTo(220, <?php echo $s2_visual_stock_max; ?>);
	ctx.strokeStyle = "Red";
	ctx.stroke();

	<!-- tank 2 Max Text -->
	ctx.font = "12px Comic Sans MS";
	ctx.textAlign = "left";
	ctx.fillStyle = "red";
	ctx.fillText("Max Stock", 220, <?php echo $s2_visual_stock_max; ?>);
	
	<!-- tank 2 Reorder Line -->
	ctx.beginPath();
	ctx.setLineDash([5, 5]);
	ctx.moveTo(0, <?php echo $s2_visual_reorder_point; ?>);
	ctx.lineTo(220, <?php echo $s2_visual_reorder_point; ?>);
	ctx.strokeStyle = "Blue";
	ctx.stroke();
	
	<!-- tank 2 Reorder Text -->
	ctx.font = "12px Comic Sans MS";
	ctx.textAlign = "left";
	ctx.fillStyle = "Blue";
	ctx.fillText("Reorder Point", 220, <?php echo $s2_visual_reorder_point; ?>);
	
	<!-- tank 2 Min Line -->
	ctx.beginPath();
	ctx.setLineDash([5, 5]);
	ctx.moveTo(0, <?php echo $s2_visual_stock_min; ?>);
	ctx.lineTo(220, <?php echo $s2_visual_stock_min; ?>);
	ctx.strokeStyle = "red";
	ctx.stroke();
	
	<!-- tank 2 Reorder Text -->
	ctx.font = "12px Comic Sans MS";
	ctx.textAlign = "left";
	ctx.fillStyle = "red";
	ctx.fillText("Min Stock", 220, <?php echo $s2_visual_stock_min; ?>);
	
	<!-- tank 2 Safty Line -->
	ctx.beginPath();
	ctx.setLineDash([5, 5]);
	ctx.moveTo(0, <?php echo $s2_visual_safety_stock; ?>);
	ctx.lineTo(220, <?php echo $s2_visual_safety_stock; ?>);
	ctx.strokeStyle = "blue";
	ctx.stroke();
	
	<!-- tank 2 Safty Text -->
	ctx.font = "12px Comic Sans MS";
	ctx.textAlign = "left";
	ctx.fillStyle = "blue";
	ctx.fillText("Safety Stock", 220, <?php echo $s2_visual_safety_stock; ?>);
</script>

<script>
	<!-- tank 3 Visual -->
	var canvas = document.getElementById("myCanvas3");
	var ctx = canvas.getContext("2d");

	ctx.beginPath();
	ctx.rect(canvas.width / 2 - 140, 0, 200, 300);
	ctx.fillStyle = "orange";
	ctx.fill();
	ctx.lineWidth = 1;
	ctx.strokeStyle = "black";
	ctx.stroke();

	ctx.beginPath();
	ctx.rect(canvas.width / 2 - 140, 0, 200, <?php echo $ullage_tank3; ?>);
	ctx.fillStyle = "white";
	ctx.fill();
	ctx.lineWidth = 1;
	ctx.strokeStyle = "black";
	ctx.stroke();

	<!-- tank 3 Volume Text -->
	ctx.font = "14px Arial";
	ctx.textAlign = "center";
	ctx.textBaseline = "middle";
	ctx.fillStyle = "black";
	<?php if ($s3_pesan=='') { ?>
		ctx.fillText("<?= $s3_sum_volume .' L' ?>", 110, canvas.height / 2);
	<?php } else { ?>
		ctx.fillText("<?= $s3_pesan ?>", canvas.width / 2, canvas.height / 2);
	<?php } ?>
	
	<!-- tank 3 Max Line -->
	ctx.beginPath();
	ctx.setLineDash([5, 5]);
	ctx.moveTo(0, <?php echo $s3_visual_stock_max; ?>);
	ctx.lineTo(220, <?php echo $s3_visual_stock_max; ?>);
	ctx.strokeStyle = "Red";
	ctx.stroke();

	<!-- tank 3 Max Text -->
	ctx.font = "12px Comic Sans MS";
	ctx.textAlign = "left";
	ctx.fillStyle = "red";
	ctx.fillText("Max Stock", 220, <?php echo $s3_visual_stock_max; ?>);
	
	<!-- tank 3 Reorder Line -->
	ctx.beginPath();
	ctx.setLineDash([5, 5]);
	ctx.moveTo(0, <?php echo $s3_visual_reorder_point; ?>);
	ctx.lineTo(220, <?php echo $s3_visual_reorder_point; ?>);
	ctx.strokeStyle = "Blue";
	ctx.stroke();
	
	<!-- tank 3 Reorder Text -->
	ctx.font = "12px Comic Sans MS";
	ctx.textAlign = "left";
	ctx.fillStyle = "Blue";
	ctx.fillText("Reorder Point", 220, <?php echo $s3_visual_reorder_point; ?>);
	
	<!-- tank 3 Min Line -->
	ctx.beginPath();
	ctx.setLineDash([5, 5]);
	ctx.moveTo(0, <?php echo $s3_visual_stock_min; ?>);
	ctx.lineTo(220, <?php echo $s3_visual_stock_min; ?>);
	ctx.strokeStyle = "red";
	ctx.stroke();
	
	<!-- tank 3 Reorder Text -->
	ctx.font = "12px Comic Sans MS";
	ctx.textAlign = "left";
	ctx.fillStyle = "red";
	ctx.fillText("Min Stock", 220, <?php echo $s3_visual_stock_min; ?>);
	
	<!-- tank 3 Safty Line -->
	ctx.beginPath();
	ctx.setLineDash([5, 5]);
	ctx.moveTo(0, <?php echo $s3_visual_safety_stock; ?>);
	ctx.lineTo(220, <?php echo $s3_visual_safety_stock; ?>);
	ctx.strokeStyle = "blue";
	ctx.stroke();
	
	<!-- tank 3 Safty Text -->
	ctx.font = "12px Comic Sans MS";
	ctx.textAlign = "left";
	ctx.fillStyle = "blue";
	ctx.fillText("Safety Stock", 220, <?php echo $s3_visual_safety_stock; ?>);
</script>

<script>
	var ctx = document.getElementById('myChart').getContext('2d');
	var chart = new Chart(ctx, {
		// The type of chart we want to create
		type: 'line',

		// The data for our dataset
		data: {
			labels: [<?php 
				foreach ($chart1_label as $object) {
					echo '"'. $object. '",';
				};
				?>],
			datasets: [{
				label: 'History Distribution Consumption',
				fill: false,
				backgroundColor: 'rgb(255, 99, 132)',
				borderColor: 'rgb(255, 99, 132)',
				data: [<?php 
				foreach ($chart1_value as $object) {
					echo '"'. $object. '",';
				};
				?>]
			}]
		},

		// Configuration options go here
		options: {}
	});
	var ctx = document.getElementById('myChart2').getContext('2d');
	var chart = new Chart(ctx, {
		// The type of chart we want to create
		type: 'line',

		// The data for our dataset
		data: {
			labels: [<?php 
				foreach ($chart2_label as $object) {
					echo '"'. $object. '",';
				};
				?>],
			datasets: [{
				label: 'History Distribution Consumption',
				fill: false,
				backgroundColor: 'rgb(255, 99, 132)',
				borderColor: 'rgb(255, 99, 132)',
				data: [<?php 
				foreach ($chart2_value as $object) {
					echo '"'. $object. '",';
				};
				?>]
			}]
		},

		// Configuration options go here
		options: {}
	});
	var ctx = document.getElementById('myChart3').getContext('2d');
	var chart = new Chart(ctx, {
		// The type of chart we want to create
		type: 'line',

		// The data for our dataset
		data: {
			labels: [<?php 
				foreach ($chart3_label as $object) {
					echo '"'. $object. '",';
				};
				?>],
			datasets: [{
				label: 'History Distribution Consumption',
				fill: false,
				backgroundColor: 'rgb(255, 99, 132)',
				borderColor: 'rgb(255, 99, 132)',
				data: [<?php 
				foreach ($chart3_value as $object) {
					echo '"'. $object. '",';
				};
				?>]
			}]
		},

		// Configuration options go here
		options: {}
	});
</script>