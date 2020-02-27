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
		<?php echo form_open("monitoring/cari"); ?>
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
		</table>
		<?php echo form_close(); ?>
		<?php echo $filter_result; ?>
	</div>
	<div class="leftmenufilter"><canvas id="myChart"></canvas></div>	
	<div class="leftmenufilter"><center>
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
	</div>
	<div class="leftmenufilter card shadow" style="font-size: small;">
		<div>Resume</div>
		<div>Yearly - 2019</div>
		<div>- The biggest purchase from : PT PAN</div>
		<div>- The most frequent fuel transporter : PT WRA</div>
		<div>- The cheapest av. fuel price : PT. PTM</div>
		<div>- The biggest supply to : PT BUMA</div>
		<div>- The most usage activity : Overburden</div>
		<div>- The most Positive Difference : LMO</div>
		<div>- The most Negative Difference : SUR</div>
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
        labels: ['PAN', 'PTM', 'AKR'],
        datasets: [{
            label: 'SMO',
            backgroundColor: 'orange',
            borderColor: 'rgb(255, 99, 132)',
            data: [5000000, 6000000, 7000000]
        }, {
            label: 'SUR',
            backgroundColor: 'green',
            borderColor: 'rgb(255, 99, 132)',
            data: [13000000, 11000000, 11000000]
		}, {
            label: 'LMO',
            backgroundColor: 'blue',
            borderColor: 'rgb(255, 99, 132)',
            data: [12000000, 11000000, 10000000]
		}]
    },
	
	options: {
			title: {
				display: true,
				text: 'Purchase Order to Vendor'
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
    type: 'horizontalBar',
    // The data for our dataset
    data: {
        labels: ['PAN', 'PTM', 'AKR'],
        datasets: [{
            label: 'SMO',
            backgroundColor: 'orange',
            borderColor: 'rgb(255, 99, 132)',
            data: [5000000, 6000000, 7000000]
        }, {
            label: 'SUR',
            backgroundColor: 'green',
            borderColor: 'rgb(255, 99, 132)',
            data: [13000000, 11000000, 11000000]
		}, {
            label: 'LMO',
            backgroundColor: 'blue',
            borderColor: 'rgb(255, 99, 132)',
            data: [12000000, 11000000, 10000000]
		}]
    },
	
	options: {
			title: {
				display: true,
				text: 'Fuel Receiving'
			},
		responsive: true,
		// legend: {
			// display: false,
			// position: 'right' // place legend on the right side of chart
		// },
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
var ctx = document.getElementById('myChart3').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',
    // The data for our dataset
    data: {
        labels: ['Mining BMO', 'Mining LMO', 'Mining SMO'],
        datasets: [{
            label: 'BUMA',
            backgroundColor: 'Blue',
            borderColor: 'rgb(255, 99, 132)',
            data: [1200000, 1300000, 0]
        }, {
            label: 'PAMA',
            backgroundColor: 'Red',
            borderColor: 'rgb(255, 99, 132)',
            data: [1500000, 0, 0]
		}, {
            label: 'RBA',
            backgroundColor: 'Green',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 600000, 300000]
		}, {
            label: 'SIS',
            backgroundColor: 'Yellow',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 0, 800000]
		}]
    },
	
	options: {
			title: {
				display: true,
				text: 'Fuel Distribution to Mining Contractor'
			},
		responsive: true,
		// legend: {
			// display: false,
			// position: 'right' // place legend on the right side of chart
		// },
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
var ctx = document.getElementById('myChart4').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',
    // The data for our dataset
    data: {
        labels: ['A2B Operation', 'Barging', 'Coal Getting', 'Genset Operation', 'Over Borden', 'Non Operation'],
        datasets: [{
            label: 'BMO',
            backgroundColor: 'Blue',
            borderColor: 'rgb(255, 99, 132)',
            data: [400000, 0, 500000, 400000, 2200000, 0]
        }, {
            label: 'HO',
            backgroundColor: 'Orange',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 0, 0, 0, 0, 0]
		}, {
            label: 'LMO',
            backgroundColor: 'Green',
            borderColor: 'rgb(255, 99, 132)',
            data: [350000, 900000, 200000, 350000, 350000, 0]
		}, {
            label: 'SMO',
            backgroundColor: 'Yellow',
            borderColor: 'rgb(255, 99, 132)',
            data: [300000, 0, 350000, 300000, 750000, 0]
		}, {
            label: 'SUR',
            backgroundColor: 'Purple',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 1000000, 0, 0, 0, 0]
		}]
    },
	
	options: {
			title: {
				display: true,
				text: 'Fuel Distribution base on Activity'
			},
		responsive: true,
		// legend: {
			// display: false,
			// position: 'right' // place legend on the right side of chart
		// },
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
var ctx = document.getElementById('myChart5').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'PTM',
            backgroundColor: 'red',
            borderColor: 'rgb(255, 99, 132)',
            data: [10, 20, 5, 10, 10, 20, 35],
            type: 'line',
			fill: false,
            // this dataset is drawn on top
            order: 1
        }, {
            label: 'AKR',
            backgroundColor: 'green',
            borderColor: 'green',
            data: [5, 0, 15, 15, 25, 20, 40],
            type: 'line',
			fill: false,
            // this dataset is drawn on top
            order: 2
        }, {
            label: 'PAN',
            backgroundColor: 'blue',
            borderColor: 'blue',
            data: [10, 13, 5, 3, 7, 10, 25],
            type: 'line',
			fill: false,
            // this dataset is drawn on top
            order: 3
        }, {
            label: 'Average Price',
            backgroundColor: 'Yellow',
            borderColor: 'Yellow',
            data: [0, 10, 5, 2, 20, 30, 45],
			// this dataset is drawn below
            order: 4
        }]
    },

    // Configuration options go here
	options: {
			title: {
				display: true,
				text: 'Fuel Price by Purchase Order History'
			}
    },

});
</script>

<script>
var ctx = document.getElementById('myChart6').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',
    // The data for our dataset
    data: {
        labels: ['Mining BMO', 'Mining LMO', 'Mining SMO'],
        datasets: [{
            label: 'LMO',
            backgroundColor: 'Blue',
            borderColor: 'rgb(255, 99, 132)',
            data: [1200000, 1300000, 0]
        }, {
            label: 'PAMA',
            backgroundColor: 'Red',
            borderColor: 'rgb(255, 99, 132)',
            data: [1500000, 0, 0]
		}, {
            label: 'RBA',
            backgroundColor: 'Green',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 600000, 300000]
		}, {
            label: 'SIS',
            backgroundColor: 'Yellow',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 0, 800000]
		}]
    },
	
	options: {
			title: {
				display: true,
				text: 'Fuel Positive Diference Receiving From Vendor'
			},
		responsive: true,
		// legend: {
			// display: false,
			// position: 'right' // place legend on the right side of chart
		// },
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
var ctx = document.getElementById('myChart7').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',
    // The data for our dataset
    data: {
        labels: ['Mining BMO', 'Mining LMO', 'Mining SMO'],
        datasets: [{
            label: 'LMO',
            backgroundColor: 'Blue',
            borderColor: 'rgb(255, 99, 132)',
            data: [1200000, 1300000, 0]
        }, {
            label: 'PAMA',
            backgroundColor: 'Red',
            borderColor: 'rgb(255, 99, 132)',
            data: [1500000, 0, 0]
		}, {
            label: 'RBA',
            backgroundColor: 'Green',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 600000, 300000]
		}, {
            label: 'SIS',
            backgroundColor: 'Yellow',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 0, 800000]
		}]
    },
	
	options: {
			title: {
				display: true,
				text: 'Fuel Negative Diference Base on Distribution'
			},
		responsive: true,
		// legend: {
			// display: false,
			// position: 'right' // place legend on the right side of chart
		// },
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