<div class="container-fluid" >
<div class="row">
  <!------ Start Menu Left ---------->
  <div class="col-md-3" style="clear: both; padding: 0; margin: 0;">
	<nav class="leftmenu">
	  <ul class="navbar-nav">
		<li class="nav-item">
		  <a class="nav-link" href="<?php echo base_url(); ?>monitoring"><img src="<?php echo base_url(); ?>assets/images/menu-rm.png"><div class="menu-satu">Reporting & Monitoring</div></a>
		</li>
	  </ul>
	</nav>
	
<div class="leftmenufilter card shadow">
	<div class="leftmenufilter"><center>
		<?php echo form_open("monitoring", array('method'=>'post')); ?>
		<table cellpadding="2">
		  <tr>
			<td colspan="3" align="center"><h3>Snapshot</h3></td>
		  </tr>
		  <tr>
			<td id="p_year_text">Year</td>
			<td><input type="number" name="p_year" id="p_year" class="form-control" placeholder="Year" value="<?php echo $tahun; ?>"></td>
		  </tr>
		  <tr>
			<td id="p_period_text">Period</td>
			<td>
				<select name="p_period" id="p_period" class="form-control">
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
				<button class="btn btn-primary btn-icon-split" type="submit" id="cari">
					<span class="icon text-white-50"><i class="fas fa-check"></i></span>
					<span class="text">Search</span></button>
			</td>
		  </tr>
		</table>
		<?php echo form_close(); ?>
		<?php echo $filter_result; ?>
	</div>
	<div class="leftmenufilter"><canvas id="myChart"  height="300"></canvas></div>	
	<!--div class="leftmenufilter"><center>
		<table cellpadding="2" border="1" width="100%" style="font-size: small;">
		  <tr>
			<th></th>
			<th>PAN</th>
			<th>PIM</th>
			<th>AKR</th>
		  </tr>
		  <tr>
			<td>SMG</td>
			<td>5.000.000</td>
			<td>6.000.000</td>
			<td>7.000.000</td>
		  </tr>
		  <tr>
			<td>SUR</td>
			<td>13.000.000</td>
			<td>11.000.000</td>
			<td>11.000.000</td>
		  </tr>
		  <tr>
			<td>IMG</td>
			<td>12.000.000</td>
			<td>11.000.000</td>
			<td>10.000.000</td>
		  </tr>
		</table>
	</div>
	<div class="leftmenufilter" style="font-size: small;"><center>
		<table cellpadding="2" border="1" width="100%">
		  <tr>
			<th>Total Fuel Amount</th>
			<th>Rp. 4.482.000.000.000</th>
		  </tr>
		  <tr>
			<th>Total Transport Amount</th>
			<th>Rp. 99.600.000.000</th>
		  </tr>
		</table>
	</div-->
	<div class="leftmenufilter card shadow" style="font-size: small;">
	</br>
	</br>
	</br>
 	</div>
</div>
 </div>
  <!------ End Menu Left ---------->

  <!------ Start content ---------->
  <div class="col-md-9">

<div class="col-md-12">
	<div class="row">
		<div class="col-md-4 card shadow"><canvas id="myChart2" height="300"></canvas></div>
		<div class="col-md-4 card shadow"><canvas id="myChart3" height="300"></canvas></div>
		<div class="col-md-4 card shadow"><canvas id="myChart4" height="300"></canvas></div>
		<div class="col-md-8 card shadow"><canvas id="myChart5" height="400"></canvas></div>
		<div class="col-md-4 card shadow">
			<canvas id="myChart6" height="200"></canvas>
			<canvas id="myChart7" height="200"></canvas>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
		var queryString = new URL('<?php echo current_url().'?'.$qeury_url; ?>');
		var urlParams = new URLSearchParams(queryString.search);
		var status = '<?php echo $periode; ?>';
		var year = urlParams.get('p_year');
		var date = urlParams.get('p_period_sub_date');
		var month = urlParams.get('p_period_sub_month');
		var quarter = urlParams.get('p_period_sub_quarter');
		
		if (status=="daily") {
			$("#p_period").val(status);
			$("#p_period_sub_date_text").show();
			$("#p_period_sub_date").show();
			$("#p_period_sub_date").val(date);
			$("#p_year_text").hide();
			$("#p_year").hide();
			$("#p_period_text").show();
			$("#p_period_sub_text").show();	
			$("#p_period_sub_month").hide();
			$("#p_period_sub_quarter").hide();
		};
		
		if (status=="monthly") {
			$("#p_period").val(status);
			$("#p_period_sub_date_text").hide();
			$("#p_period_sub_date").hide();
			$("#p_year_text").show();
			$("#p_year").show();
			$("#p_year").val(year);
			$("#p_period_text").show();
			$("#p_period_sub_text").show();	
			$("#p_period_sub_month").show();
			$("#p_period_sub_month").val(month);
			$("#p_period_sub_quarter").hide();
		};
		
		if (status=="quarterly") {
			$("#p_period").val(status);
			$("#p_period_sub_date_text").hide();
			$("#p_period_sub_date").hide();
			$("#p_year_text").show();
			$("#p_year").show();
			$("#p_year").val(year);
			$("#p_period_text").show();
			$("#p_period_sub_text").show();	
			$("#p_period_sub_month").hide();
			$("#p_period_sub_quarter").show();
			$("#p_period_sub_quarter").val(quarter);
		};

		if (status=="yearly") {
			$("#p_period").val(status);
			$("#p_period_sub_date_text").hide();
			$("#p_period_sub_date").hide();
			$("#p_year_text").show();
			$("#p_year").show();
			$("#p_year").val(year);
			$("#p_period_text").show();
			$("#p_period_sub_text").hide();	
			$("#p_period_sub_month").hide();
			$("#p_period_sub_quarter").hide();
		};

    $("#p_period").change(function(){		
			var status = this.value;

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
		
		$("#cari").click(function(){	
			var url = location.protocol + '//' + location.host + location.pathname + '?'+$("form").serialize();
			$(location).attr('href',url);
		});
});
</script>
<script>
const api_url_fuel_receiving = "<?php echo base_url().'chart/fuel_receiving?'.$qeury_url; ?>";

var departments = [];

async function getData_fuel_receiving() {
	const response = await fetch(api_url_fuel_receiving);
	const data = await response.json();
	const data_label = data.vendor;
	for (var department in data.chart) {
		var departmentObject = prepareDepartmentDetails(data.chart[department].transporter_name, data.chart[department].quantity, data.chart[department].color);
		departments.push(departmentObject);
	}
	return {data_label, departments};	
}


 async function setup_fuel_receiving() {
	const ctx = document.getElementById('myChart2').getContext('2d');
	const globalTemps = await getData_fuel_receiving();
	
	var chartData = {
			labels: globalTemps.data_label.split('|'),
			datasets : globalTemps.departments
	};
	const myChart2 = new Chart(ctx, {
		type: 'horizontalBar',
		data: chartData,
		options: {
			title: {
				display: true,
				text: 'Fuel Receiving'
			},
			responsive: true,
			tooltips: {
				mode: 'nearest',
			  callbacks: {
					label: function(tooltipItem, data) {
						var value = tooltipItem.xLabel;
						value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						return data.datasets[tooltipItem.datasetIndex].label+' : '+value;
					}
			  } // end callbacks:
			},
			scales: {
				xAxes: [{
					stacked: true, // this should be set to make the bars stacked
					ticks: {
									// Include a dollar sign in the ticks
									callback: function(value, index, values) {
											return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
									}
                }
				}],
				yAxes: [{
					stacked: true // this also..
				}]
			}
		}
	});
}
	
function prepareDepartmentDetails(transporter_name, quantity, color){
    return {
        label : transporter_name,
        data : quantity.split(','),
        backgroundColor: color,
        borderColor: color,
        pointBackgroundColor : color,
        fill: false,
        lineTension: 0,
        pointRadius: 5
    }
}


setup_fuel_receiving();
</script>
<script>
const api_url_purchase_order_to_vendor = "<?php echo base_url().'chart/purchase_order_to_vendor?'.$qeury_url; ?>";

var departments_purchase_order_to_vendor = [];

async function getData_purchase_order_to_vendor() {
	const response = await fetch(api_url_purchase_order_to_vendor);
	const data = await response.json();
	const data_label = data.vendor;
	for (var department in data.chart) {
		var departmentObject = prepareDepartmentDetailsBar(data.chart[department].storage_name, data.chart[department].quantity, data.chart[department].color);
		departments_purchase_order_to_vendor.push(departmentObject);
	}
	return {data_label, departments_purchase_order_to_vendor};	
}


 async function setup_purchase_order_to_vendor() {
	const ctx = document.getElementById('myChart').getContext('2d');
	const globalTemps = await getData_purchase_order_to_vendor();
	
	var chartData = {
			labels: globalTemps.data_label.split('|'),
			datasets : globalTemps.departments_purchase_order_to_vendor
	};
	const myChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			title: {
				display: true,
				text: 'Purchase Order to Vendor'
			},
			responsive: true,
			tooltips: {
				mode: 'nearest',
			  callbacks: {
					label: function(tooltipItem, data) {
						var value = tooltipItem.yLabel;
						value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						return data.datasets[tooltipItem.datasetIndex].label+' : '+value;
					}
			  } // end callbacks:
			},
			scales: {
				
				xAxes: [{
					stacked: true // this also..
				}],
				yAxes: [{
					stacked: true, // this should be set to make the bars stacked
					ticks: {
									// Include a dollar sign in the ticks
									callback: function(value, index, values) {
											return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
									}
                }
				}]
			}
		}
	});
}
	
function prepareDepartmentDetailsBar(storage_name, quantity, color){
    return {
        label : storage_name,
        data : quantity.split(','),
        backgroundColor: color,
        borderColor: color,
        pointBackgroundColor : color,
        fill: false,
        lineTension: 0,
        pointRadius: 5
    }
}

setup_purchase_order_to_vendor();
</script>
<script>
const api_url_fuel_price_by_history = "<?php echo base_url().'chart/fuel_price_by_history?'.$qeury_url; ?>";

var departments_fuel_price_by_history = [];

async function getData_fuel_price_by_history() {
	const response = await fetch(api_url_fuel_price_by_history);
	const data = await response.json();
	const data_label = data.labels;
	for (var department in data.chart) {
		var departmentObject = prepareDepartmentDetailsBar2(data.chart[department].label, data.chart[department].datas, data.chart[department].color);
		departments_fuel_price_by_history.push(departmentObject);
	}
	for (var department_fill in data.chart_fill) {
		var departmentObject_fill = prepareDepartmentDetailsBar3(data.chart_fill[department_fill].label, data.chart_fill[department_fill].datas, data.chart_fill[department_fill].color);
		departments_fuel_price_by_history.push(departmentObject_fill);
	}
	return {data_label, departments_fuel_price_by_history};	
}


 async function setup_fuel_price_by_history() {
	const ctx = document.getElementById('myChart5').getContext('2d');
	const globalTemps = await getData_fuel_price_by_history();
	
	var chartData = {
			labels: globalTemps.data_label.split(','),
			datasets : globalTemps.departments_fuel_price_by_history
	};
	const myChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			title: {
				display: true,
				text: 'Fuel Price by Purchase Order History'
			},
			responsive: true,
			tooltips: {
				mode: 'nearest',
			  callbacks: {
					label: function(tooltipItem, data) {
						var value = tooltipItem.yLabel;
						value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						return data.datasets[tooltipItem.datasetIndex].label+' : '+value;
					}
			  } // end callbacks:
			},
			scales: {
				
				xAxes: [{
					stacked: true // this also..
				}],
				yAxes: [{
					stacked: true, // this should be set to make the bars stacked
					ticks: {
									// Include a dollar sign in the ticks
									callback: function(value, index, values) {
											return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
									}
                }
				}]
			}
		}
	});
}
	
function prepareDepartmentDetailsBar2(label, datas, color){
    return {
        label : label,
        data : datas.split(','),
        backgroundColor: color,
        borderColor: color,
        pointBackgroundColor : color,
				type: 'line',
				fill: false
    }
}

function prepareDepartmentDetailsBar3(label, datas, color){
    return {
        label : label,
        data : datas.split(','),
        backgroundColor: color,
        borderColor: color,
        pointBackgroundColor : color,
        hoverBackgroundColor : color,
				pointHoverBackgroundColor : color
    }
}

setup_fuel_price_by_history();
</script>

<script>
const api_url_fuel_distribution_to_mining = "<?php echo base_url().'chart/fuel_distribution_to_mining?'.$qeury_url; ?>";

var departments_fuel_distribution_to_mining = [];

async function fuel_distribution_to_mining() {
	const response = await fetch(api_url_fuel_distribution_to_mining);
	const data = await response.json();
	const data_label = data.storage;
	for (var department in data.chart) {
		var departmentObject = prepareDepartmentDetailsBar(data.chart[department].description, data.chart[department].quantity, data.chart[department].color);
		departments_fuel_distribution_to_mining.push(departmentObject);
	}
	return {data_label, departments_fuel_distribution_to_mining};	
}


 async function setup_fuel_distribution_to_mining() {
	const ctx = document.getElementById('myChart3').getContext('2d');
	const globalTemps = await fuel_distribution_to_mining();
	
	var chartData = {
			labels: globalTemps.data_label.split('|'),
			datasets : globalTemps.departments_fuel_distribution_to_mining
	};
	const myChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			title: {
				display: true,
				text: 'Fuel Distribution to Mining Contractor'
			},
			responsive: true,
			tooltips: {
				mode: 'nearest',
			  callbacks: {
					label: function(tooltipItem, data) {
						var value = tooltipItem.yLabel;
						value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						return data.datasets[tooltipItem.datasetIndex].label+' : '+value;
					}
			  } // end callbacks:
			},
			scales: {
				
				xAxes: [{
					stacked: false // this also..
				}],
				yAxes: [{
					stacked: false, // this should be set to make the bars stacked
					ticks: {
									// Include a dollar sign in the ticks
									callback: function(value, index, values) {
											return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
									}
                }
				}]
			}
		}
	});
}

setup_fuel_distribution_to_mining();
</script>

<script>
const api_url_fuel_distribution_base_on_activity = "<?php echo base_url().'chart/fuel_distribution_base_on_activity?'.$qeury_url; ?>";

var departments_fuel_distribution_base_on_activity = [];

async function fuel_distribution_base_on_activity() {
	const response = await fetch(api_url_fuel_distribution_base_on_activity);
	const data = await response.json();
	const data_label = data.movement;
	for (var department in data.chart) {
		var departmentObject = prepareDepartmentDetailsBar(data.chart[department].storage_name, data.chart[department].quantity, data.chart[department].color);
		departments_fuel_distribution_base_on_activity.push(departmentObject);
	}
	return {data_label, departments_fuel_distribution_base_on_activity};	
}


 async function setup_fuel_distribution_base_on_activity() {
	const ctx = document.getElementById('myChart4').getContext('2d');
	const globalTemps = await fuel_distribution_base_on_activity();
	
	var chartData = {
			labels: globalTemps.data_label.split('|'),
			datasets : globalTemps.departments_fuel_distribution_base_on_activity
	};
	const myChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			title: {
				display: true,
				text: 'Fuel Distribution Base On Activity'
			},
			responsive: true,
			tooltips: {
				mode: 'nearest',
			  callbacks: {
					label: function(tooltipItem, data) {
						var value = tooltipItem.yLabel;
						value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						return data.datasets[tooltipItem.datasetIndex].label+' : '+value;
					}
			  } // end callbacks:
			},
			scales: {
				
				xAxes: [{
					stacked: true // this also..
				}],
				yAxes: [{
					stacked: true, // this should be set to make the bars stacked
					ticks: {
									// Include a dollar sign in the ticks
									callback: function(value, index, values) {
											return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
									}
                }
				}]
			}
		}
	});
}

setup_fuel_distribution_base_on_activity();
</script>

<script>
const api_url_fuel_positive = "<?php echo base_url().'chart/fuel_positive?'.$qeury_url; ?>";

async function fuel_positive() {
	const response = await fetch(api_url_fuel_positive);
	const data = await response.json();
	const data_label = data.storage;
	const data_color = data.color;
	const data_fuel = data.fuel;
	
	return {data_label, data_color, data_fuel};	
}


 async function setup_fuel_positive() {
	const ctx = document.getElementById('myChart6').getContext('2d');
	const globalTemps = await fuel_positive();
	
	const myChart = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: globalTemps.data_label.split(','),
			datasets: [{
				data: globalTemps.data_fuel.split(','),
				backgroundColor: globalTemps.data_color.split(','),
				borderWidth: 3
			}]
		},
		options: {
			title: {
					display: true,
					text: 'Fuel Positive Diference Receiving From Vendor'
				},
			cutoutPercentage: 0,
			responsive: true,
			tooltips: {
			  callbacks: {
					label: function(tooltipItem, data) {
						var value = data.datasets[0].data[tooltipItem.index];
						value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						return data.labels[tooltipItem.index]+' : '+value;
					}
			  } // end callbacks:
			}

		}
	});
	console.log(myChart);
}

setup_fuel_positive();
</script>

<script>
const api_url_fuel_negative = "<?php echo base_url().'chart/fuel_negative?'.$qeury_url; ?>";

var departments_fuel_negative = [];

async function getData_fuel_negative() {
	const response = await fetch(api_url_fuel_negative);
	const data = await response.json();
	const data_label = data.storage;
	for (var department in data.chart) {
		var departmentObject = prepareDepartmentDetails_fuel_negative(data.chart[department].quarter, data.chart[department].quantity, data.chart[department].color);
		departments_fuel_negative.push(departmentObject);
	}
	return {data_label, departments_fuel_negative};	
}


 async function setup() {
	const ctx = document.getElementById('myChart7').getContext('2d');
	const globalTemps = await getData_fuel_negative();
	
	var chartData = {
			labels: globalTemps.data_label.split('|'),
			datasets : globalTemps.departments_fuel_negative
	};
console.log(chartData);
	const myChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			title: {
				display: true,
				text: 'Fuel Negative Diference Base on Distribution'
			},
			responsive: true,
			legend: {
				display: true,
				position: 'top', // place legend on the right side of chart
				align: 'start',
			},
			scales: {
				xAxes: [{
					stacked: false // this should be set to make the bars stacked
				}],
				yAxes: [{
					stacked: false // this also..
				}]
			}
		}
	});
}
	
function prepareDepartmentDetails_fuel_negative(quarter, quantity, color){
    return {
        label : quarter,
        data : quantity.split(','),
        backgroundColor: color,
        borderColor: color
    }
}
 setup();
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
			// text: 'Purchase Order to Vendor'
		// },
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
				// text: 'Fuel Receiving'
			// }
    // },
// });
// var ctx = document.getElementById('myChart3').getContext('2d');
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
				// text: 'Fuel Distribution'
			// }
    // },
// });
// var ctx = document.getElementById('myChart4').getContext('2d');
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
				// text: 'Fuel Distribution'
			// }
    // },
// });
// var ctx = document.getElementById('myChart5').getContext('2d');
// var chart = new Chart(ctx, {
    // // The type of chart we want to create
    // type: 'line',

    // // The data for our dataset
    // data: {
        // labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        // datasets: [{
            // label: 'My First dataset',
            // backgroundColor: 'rgb(255, 99, 132)',
            // borderColor: 'rgb(255, 99, 132)',
            // data: [0, 10, 5, 2, 20, 30, 45]
        // }]
    // },

    // // Configuration options go here
	// options: {
			// title: {
				// display: true,
				// text: 'Fuel Price'
			// }
    // },
// });
// var ctx = document.getElementById('myChart6').getContext('2d');
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
				// text: 'Fuel Positive Diference'
			// }
    // },
// });
// var ctx = document.getElementById('myChart7').getContext('2d');
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
				// text: 'Fuel Negative Diference'
			// }
    // },
// });
</script>