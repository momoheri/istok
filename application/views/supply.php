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
				<select name="p_period" class="form-control">
				  <option value="daily">Daily</option>
				  <option value="monthly">Monthly</option>
				  <option value="quarterly">Quarterly</option>
				  <option value="yearly">Yearly</option>
				</select>
			</td>
		  </tr>
		  <tr>
			<td>Sub Period</td>
			<td><input type="date" name="p_period_sub" class="form-control" placeholder="Year" value="<?php echo $tahun; ?>" required></td>
		  </tr>
		</table>
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
setTimeout(function() {
  location.reload();
}, 30000);
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