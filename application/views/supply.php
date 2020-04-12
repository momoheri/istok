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
		<?php echo form_open("supply", array('method'=>'get')); ?>
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
	$("#p_period_sub_date_text").show();
	$("#p_period_sub_date").show();
	$("#p_year_text").hide();
	$("#p_year").hide();
	$("#p_period_text").show();
	$("#p_period_sub_text").show();	
	$("#p_period_sub_month").hide();
	$("#p_period_sub_quarter").hide();
		var queryString = window.location.search;
		var urlParams = new URLSearchParams(queryString);
		var status = urlParams.get('p_period');
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
});
</script>

<script>
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',
    // The data for our dataset
    data: {
        labels: ['AKR', 'PTM', 'PAN'],
        datasets: [{
            label: '9001 Target Memuaskan',
            backgroundColor: 'blue',
            borderColor: 'rgb(255, 99, 132)',
            data: [32, 32, 12]
        }, {
            label: '9002 Memuaskan',
            backgroundColor: 'orange',
            borderColor: 'rgb(255, 99, 132)',
            data: [8, 1, 11]
		}, {
            label: '9003 Cukup Memuaskan',
            backgroundColor: 'grey',
            borderColor: 'rgb(255, 99, 132)',
            data: [5, 12, 22]
		}, {
            label: '9004 Tidak Memuaskan',
            backgroundColor: 'yellow',
            borderColor: 'rgb(255, 99, 132)',
            data: [5, 12, 22]
		}, {
            label: '9005 Sangat Buruk',
            backgroundColor: 'green',
            borderColor: 'rgb(255, 99, 132)',
            data: [5, 12, 22]
		}]
    },
	
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
</script>

<script>
var ctx = document.getElementById('myChart2').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',
    // The data for our dataset
    data: {
        labels: ['TBS', 'BRK', 'AKR', 'WRK'],
        datasets: [{
            label: '9001 Target Memuaskan',
            backgroundColor: 'blue',
            borderColor: 'rgb(255, 99, 132)',
            data: [25, 18, 12, 7]
        }, {
            label: '9002 Memuaskan',
            backgroundColor: 'orange',
            borderColor: 'rgb(255, 99, 132)',
            data: [8, 1, 11, 2]
		}, {
            label: '9003 Cukup Memuaskan',
            backgroundColor: 'grey',
            borderColor: 'rgb(255, 99, 132)',
            data: [5, 12, 15, 8]
		}, {
            label: '9004 Tidak Memuaskan',
            backgroundColor: 'yellow',
            borderColor: 'rgb(255, 99, 132)',
            data: [5, 12, 16, 10]
		}, {
            label: '9005 Sangat Buruk',
            backgroundColor: 'green',
            borderColor: 'rgb(255, 99, 132)',
            data: [5, 12, 22, 12]
		}]
    },
	
	options: {
			title: {
				display: true,
				text: 'Transporter CSI Performance'
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
</script>

<script>
var ctx = document.getElementById('myChart3').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',
    // The data for our dataset
    data: {
        labels: ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'oct', 'nov', 'dec'],
        datasets: [{
            label: 'SUM of Average Inventory',
            backgroundColor: 'green',
            borderColor: 'green',
            data: [5000000, 5200000, 5300000, 5100000, 4800000, 5000000, 5000000, 4500000, 5000000, 5200000, 5000000, 5100000],
			fill: false,
		}, {
            label: 'SUM of Max Baseline',
            backgroundColor: 'blue',
            borderColor: 'blue',
            data: [4000000, 4500000, 3300000, 3100000, 2800000, 5000000, 3000000, 4500000, 3000000, 3800000, 3000000, 4100000],
			fill: false,
		}, {
            label: 'SUM of Min Baseline',
            backgroundColor: 'red',
            borderColor: 'red',
            data: [3000000, 3200000, 3300000, 3100000, 2800000, 3000000, 3000000, 2500000, 3000000, 3200000, 3000000, 3100000],
			fill: false,
		}]
    },
	
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
</script>

<script>
var ctx = document.getElementById('myChart4').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',
    // The data for our dataset
    data: {
        labels: ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'oct', 'nov', 'dec'],
        datasets: [{
            label: 'SUM of Average Inventory',
            backgroundColor: 'green',
            borderColor: 'green',
            data: [5000000, 5200000, 5300000, 5100000, 4800000, 5000000, 5000000, 4500000, 5000000, 5200000, 5000000, 5100000],
			fill: false,
		}, {
            label: 'SUM of Max Baseline',
            backgroundColor: 'blue',
            borderColor: 'blue',
            data: [4000000, 4500000, 3300000, 3100000, 2800000, 5000000, 3000000, 4500000, 3000000, 3800000, 3000000, 4100000],
			fill: false,
		}, {
            label: 'SUM of Min Baseline',
            backgroundColor: 'red',
            borderColor: 'red',
            data: [3000000, 3200000, 3300000, 3100000, 2800000, 3000000, 3000000, 2500000, 3000000, 3200000, 3000000, 3100000],
			fill: false,
		}]
    },
	
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
</script>

<script>
var ctx = document.getElementById('myChart5').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',
    // The data for our dataset
    data: {
        labels: ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agt', 'sep', 'oct', 'nov', 'dec'],
        datasets: [{
            label: 'SUM of Average Inventory',
            backgroundColor: 'green',
            borderColor: 'green',
            data: [5000000, 5200000, 5300000, 5100000, 4800000, 5000000, 5000000, 4500000, 5000000, 5200000, 5000000, 5100000],
			fill: false,
		}, {
            label: 'SUM of Max Baseline',
            backgroundColor: 'blue',
            borderColor: 'blue',
            data: [4000000, 4500000, 3300000, 3100000, 2800000, 5000000, 3000000, 4500000, 3000000, 3800000, 3000000, 4100000],
			fill: false,
		}, {
            label: 'SUM of Min Baseline',
            backgroundColor: 'red',
            borderColor: 'red',
            data: [3000000, 3200000, 3300000, 3100000, 2800000, 3000000, 3000000, 2500000, 3000000, 3200000, 3000000, 3100000],
			fill: false,
		}]
    },
	
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