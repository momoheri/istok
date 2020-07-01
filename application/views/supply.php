<div class="container-fluid" >
<div class="row">
  <!------ Start Menu Left ---------->
  <div class="col-md-3" style="clear: both; padding: 0; margin: 0;">
	<nav class="leftmenu">
	  <ul class="navbar-nav">
		<li class="nav-item">
		  <a class="nav-link" href="<?php echo base_url(); ?>supply"><img src="<?php echo base_url(); ?>assets/images/menu-sup.png"><div class="menu-satu">Supply Chain Performance</div></a>
		</li>
	  </ul>
	</nav>
	
<div class="leftmenufilter card shadow">
	<div class="leftmenufilter"><center>
		<?php echo form_open("supply", array('method'=>'post')); ?>
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
	<div class="leftmenufilter"><canvas id="myChart" height="300"></canvas></div>	
	<div class="leftmenufilter"><canvas id="myChart2" height="300"></canvas></div>
</div>
 </div>
  <!------ End Menu Left ---------->

  <!------ Start content ---------->
  <div class="col-md-9">

<div class="col-md-12">
	<div class="row">
		<div class="col-md-4 card shadow">
			<div class=""><canvas id="myChart3" height="300"></canvas></div>
			<div class=""><canvas id="myChart4" height="300"></canvas></div>
			<div class=""><canvas id="myChart5" height="300"></canvas></div>
		</div>
		
		<div class="col-md-4 card shadow">
			<div class=""><canvas id="myChart6" height="300"></canvas></div>
			<div class=""><canvas id="myChart7" height="300"></canvas></div>
			<div class=""><canvas id="myChart8" height="300"></canvas></div>
		</div>
		
		<div class="col-md-4">
			<div class="card shadow"><canvas id="myChart9" height="300"></canvas></div>
			<div class="card shadow"><canvas id="myChart10" height="300"></canvas></div>
			<div class="card shadow"><canvas id="myChart11" height="300"></canvas></div>
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
		
});
</script>

<script>
const api_url_vendor_performance = "<?php echo base_url().'chart/vendor_performance?'.$qeury_url; ?>";

var departments_vendor_performance = [];

async function getData_vendor_performance() {
	const response = await fetch(api_url_vendor_performance);
	const data = await response.json();
	const data_label = data.vendor;
	for (var department in data.chart) {
		var departmentObject = prepareDepartmentDetails_vendor_performance(data.chart[department].movement_reason_name, data.chart[department].total, data.chart[department].color);
		departments_vendor_performance.push(departmentObject);
	}
	return {data_label, departments_vendor_performance};	
}


 async function setup() {
	const ctx = document.getElementById('myChart').getContext('2d');
	const globalTemps = await getData_vendor_performance();
	
	var chartData = {
			labels: globalTemps.data_label.split('|'),
			datasets : globalTemps.departments_vendor_performance
	};
console.log(chartData);
	const myChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			title: {
				display: true,
				text: 'Vendor CSI Performance'
			},
			responsive: true,
			legend: {
				display: true,
				position: 'bottom', // place legend on the right side of chart
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
	
function prepareDepartmentDetails_vendor_performance(movement_reason_name, total, color){
    return {
        label : movement_reason_name,
        data : total.split(','),
        backgroundColor: color,
        borderColor: 'rgb(255, 99, 132)'
    }
}
 setup();
</script>

<script>
const api_url_transporter_performance = "<?php echo base_url().'chart/transporter_performance?'.$qeury_url; ?>";

var departments_transporter_performance = [];

async function getData_transporter_performance() {
	const response = await fetch(api_url_transporter_performance);
	const data = await response.json();
	const data_label = data.transporter;
	for (var department in data.chart) {
		var departmentObject = prepareDepartmentDetails_vendor_performance(data.chart[department].movement_reason_name, data.chart[department].total, data.chart[department].color);
		departments_transporter_performance.push(departmentObject);
	}
	return {data_label, departments_transporter_performance};	
}


 async function setup_chart2() {
	const ctx = document.getElementById('myChart2').getContext('2d');
	const globalTemps = await getData_transporter_performance();
	
	var chartData = {
			labels: globalTemps.data_label.split('|'),
			datasets : globalTemps.departments_transporter_performance
	};
console.log(chartData);
	const myChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			title: {
				display: true,
				text: 'transporter CSI Performance'
			},
			responsive: true,
			legend: {
				display: true,
				position: 'bottom', // place legend on the right side of chart
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

setup_chart2();
</script>

<script>
const api_url_invenory_1 = "<?php echo base_url().'chart/inventory_performance/1?'.$qeury_url; ?>";

var departments_inventory_1 = [];

async function getData_inventory_1() {
	const response = await fetch(api_url_invenory_1);
	const data = await response.json();
	const data_label = data.labels;
	
	for (var department in data.chart) {
		var departmentObject = prepare_inventory_data(data.chart[department].label, data.chart[department].datas, data.chart[department].color);
		departments_inventory_1.push(departmentObject);
	}
	
	for (var department_fill in data.chart_fill) {
		var departmentObject_fill = prepare_inventory_data_fill(data.chart_fill[department_fill].label, data.chart_fill[department_fill].datas, data.chart_fill[department_fill].color, data.chart_fill[department_fill].fill);
		departments_inventory_1.push(departmentObject_fill);
	}
	
	return {data_label, departments_inventory_1};	
}


 async function setup_lati() {
	const ctx = document.getElementById('myChart3').getContext('2d');
	const globalTemps = await getData_inventory_1();
	
	var chartData = {
			labels: globalTemps.data_label.split(','),
			datasets : globalTemps.departments_inventory_1
	};
	const myChart = new Chart(ctx, {
		type: 'line',
		data: chartData,
		options: {
				title: {
					display: true,
					text: 'Inventory Performance Lati Storage'
				},
			responsive: true,
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

function prepare_inventory_data(label, datas, color){
	return {
			label : label,
			data : datas.split(','),
			backgroundColor: color,
			fill: false,
			borderColor: color
	}
}

function prepare_inventory_data_fill(label, datas, color, fill){
	return {
			label : label,
			data : datas.split(','),
			backgroundColor: color,
			fill: fill,
			borderColor: color,
			pointRadius: 0
	}
}
setup_lati();
</script>

<script>
const api_url_invenory_2 = "<?php echo base_url().'chart/inventory_performance/2?'.$qeury_url; ?>";

var departments_inventory_2 = [];

async function getData_inventory_2() {
	const response = await fetch(api_url_invenory_2);
	const data = await response.json();
	const data_label = data.labels;
	
	for (var department in data.chart) {
		var departmentObject = prepare_inventory_data(data.chart[department].label, data.chart[department].datas, data.chart[department].color);
		departments_inventory_2.push(departmentObject);
	}
	
	for (var department_fill in data.chart_fill) {
		var departmentObject_fill = prepare_inventory_data_fill(data.chart_fill[department_fill].label, data.chart_fill[department_fill].datas, data.chart_fill[department_fill].color, data.chart_fill[department_fill].fill);
		departments_inventory_2.push(departmentObject_fill);
	}
	
	return {data_label, departments_inventory_2};	
}


 async function setup_suaran() {
	const ctx = document.getElementById('myChart4').getContext('2d');
	const globalTemps = await getData_inventory_2();
	
	var chartData = {
			labels: globalTemps.data_label.split(','),
			datasets : globalTemps.departments_inventory_2
	};
console.log(globalTemps);
	const myChart = new Chart(ctx, {
		type: 'line',
		data: chartData,
		options: {
				title: {
					display: true,
					text: 'Inventory Performance Suaran Storage'
				},
			responsive: true,
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

setup_suaran();
</script>

<script>

const api_url_invenory_3 = "<?php echo base_url().'chart/inventory_performance/3?'.$qeury_url; ?>";

var departments_inventory_3 = [];

async function getData_inventory_3() {
	const response = await fetch(api_url_invenory_3);
	const data = await response.json();
	const data_label = data.labels;
	
	for (var department in data.chart) {
		var departmentObject = prepare_inventory_data(data.chart[department].label, data.chart[department].datas, data.chart[department].color);
		departments_inventory_3.push(departmentObject);
	}
	
	for (var department_fill in data.chart_fill) {
		var departmentObject_fill = prepare_inventory_data_fill(data.chart_fill[department_fill].label, data.chart_fill[department_fill].datas, data.chart_fill[department_fill].color, data.chart_fill[department_fill].fill);
		departments_inventory_3.push(departmentObject_fill);
	}
	
	return {data_label, departments_inventory_3};	
}


 async function setup_sambarata() {
	const ctx = document.getElementById('myChart5').getContext('2d');
	const globalTemps = await getData_inventory_3();
	
	var chartData = {
			labels: globalTemps.data_label.split(','),
			datasets : globalTemps.departments_inventory_3
	};
console.log(globalTemps);
	const myChart = new Chart(ctx, {
		type: 'line',
		data: chartData,
		options: {
				title: {
					display: true,
					text: 'Inventory Performance Sambarata Storage'
				},
			responsive: true,
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

setup_sambarata();
</script>

<script>
var ctx = document.getElementById('myChart6').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',
    // The data for our dataset
    data: {
        labels: ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'oct', 'nov', 'dec'],
        datasets: [{
            label: 'Total day of over stock',
            backgroundColor: 'blue',
            borderColor: 'rgb(255, 99, 132)',
            data: [5, 7, 9, 5, 3, 6, 2, 4, 7, 6, 5, 6],
			fill: false,
		}, {
            label: 'Total day of near miss stock',
            backgroundColor: 'orange',
            borderColor: 'rgb(255, 99, 132)',
            data: [2, 3, 0, 4, 3, 2, 3, 1, 0, 4, 2, 4],
			fill: false,
		}]
    },
	
	options: {
			title: {
				display: true,
				text: 'Availability Performance Lati Storage'
			},
		responsive: true,
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
</script>

<script>
var ctx = document.getElementById('myChart7').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',
    // The data for our dataset
    data: {
        labels: ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'oct', 'nov', 'dec'],
        datasets: [{
            label: 'Total day of over stock',
            backgroundColor: 'blue',
            borderColor: 'rgb(255, 99, 132)',
            data: [5, 7, 9, 5, 3, 6, 2, 4, 7, 6, 5, 6],
			fill: false,
		}, {
            label: 'Total day of near miss stock',
            backgroundColor: 'orange',
            borderColor: 'rgb(255, 99, 132)',
            data: [2, 3, 0, 4, 3, 2, 3, 1, 0, 4, 2, 4],
			fill: false,
		}]
    },
	
	options: {
			title: {
				display: true,
				text: 'Availability Performance Suaran Storage'
			},
		responsive: true,
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
</script>

<script>
var ctx = document.getElementById('myChart8').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',
    // The data for our dataset
    data: {
        labels: ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'oct', 'nov', 'dec'],
        datasets: [{
            label: 'Total day of over stock',
            backgroundColor: 'blue',
            borderColor: 'rgb(255, 99, 132)',
            data: [5, 7, 9, 5, 3, 6, 2, 4, 7, 6, 5, 6],
			fill: false,
		}, {
            label: 'Total day of near miss stock',
            backgroundColor: 'orange',
            borderColor: 'rgb(255, 99, 132)',
            data: [2, 3, 0, 4, 3, 2, 3, 1, 0, 4, 2, 4],
			fill: false,
		}]
    },
	
	options: {
			title: {
				display: true,
				text: 'Availability Performance Sambarata Storage'
			},
		responsive: true,
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
</script>

<script>
var ctx = document.getElementById('myChart9').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',
    // The data for our dataset
    data: {
        labels: ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'oct', 'nov', 'dec'],
        datasets: [{
            label: 'MTBA-LMO',
            backgroundColor: 'green',
            borderColor: 'green',
            data: [5, 7, 9, 5, 3, 6, 2, 4, 7, 6, 5, 6],
			fill: true,
			order: 1
		}, {
            label: 'MTBA-SUR',
            backgroundColor: 'yellow',
            borderColor: 'yellow',
            data: [2, 3, 0, 4, 3, 2, 3, 1, 0, 4, 2, 4],
			fill: true,
			order: 2
		}, {
            label: 'MTBA-SMO',
            backgroundColor: 'red',
            borderColor: 'red',
            data: [2, 3, 0, 4, 3, 2, 3, 1, 0, 4, 2, 4],
			fill: true,
			order: 3
		}]
    },
	
	options: {
			title: {
				display: true,
				text: 'Schedule Performance average of mean between cargo arrival'
			},
		responsive: true,
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
</script>

<script>
var ctx = document.getElementById('myChart10').getContext('2d');
var myChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ['LMO', 'SUR', 'SMO'],
    datasets: [{
      label: '# of Tomatoes',
      data: [3.20, 2.60, 4.70],
      backgroundColor: [
        'blue',
        'red',
        'green'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)'
      ],
      borderWidth: 1
    }]
  },
  options: {
   	cutoutPercentage: 40,
    responsive: false,

  }
});
</script>

<script>
var ctx = document.getElementById('myChart11').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',
    // The data for our dataset
    data: {
        labels: ['AKR', 'PTM', 'PAN'],
        datasets: [{
            label: 'Number of delay time',
            backgroundColor: 'green',
            borderColor: 'green',
            data: [4, 5, 2]
        }, {
            label: 'Sum of delay time',
            backgroundColor: 'red',
            borderColor: 'red',
            data: [7, 9, 4]
		}]
    },
	
	options: {
			title: {
				display: true,
				text: 'Number of delay Time'
			},
		responsive: true,
		legend: {
			display: true,
			position: 'bottom', // place legend on the right side of chart
			align: 'start',
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
				// text: 'Vendor CSI Performance'
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
				// text: 'Transporter CSI Performance'
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
				// text: 'Inventory Performance'
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
				// text: 'Availability Performance'
			// }
    // },
// });

// var ctx = document.getElementById('myChart5').getContext('2d');
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
				// text: 'Inventory Performance'
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
				// text: 'Inventory Performance'
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
				// text: 'Inventory Performance'
			// }
    // },
// });

// var ctx = document.getElementById('myChart8').getContext('2d');
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
				// text: 'Inventory Performance'
			// }
    // },
// });

// var ctx = document.getElementById('myChart9').getContext('2d');
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
				// text: 'Schedule Performance'
			// }
    // },
// });

// var ctx = document.getElementById('myChart10').getContext('2d');
// var chart = new Chart(ctx, {
    // // The type of chart we want to create
    // type: 'doughnut',

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
				// text: 'Fuel Bunkering Performance'
			// }
    // },
// });

// var ctx = document.getElementById('myChart11').getContext('2d');
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
				// text: 'Time Arrival Performance'
			// }
    // },
// });

</script>