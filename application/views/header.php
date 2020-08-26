<!DOCTYPE html>
<html lang="en">
<head>
	<title>Istock - Dashboard</title>
	
	<!------ Include the above in your HEAD tag ---------->
	
    <script src="<?php echo base_url(); ?>assets/jquery/jquery-3.4.1.min.js"></script>
	
	<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<!--
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	-->
	<link href="<?php echo base_url(); ?>assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	
	<!------ chart.js ---------->
	<!--
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>	
	-->	
	<script src="<?php echo base_url(); ?>assets/chart.js/Chart.min.js"></script>	
	
	<!------ timer 
	<meta http-equiv="refresh" content="30"/>
	---------->
	
	<link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet" id="bootstrap-css">
</head>
<body>

<!------ Start Header ---------->
<div class="header">
	<nav class="navbar fixed-top navbar-light" style="background-color: #6fad48;">		
		<ul class="nav navbar-nav">
			<li><a class="navbar-brand" href="<?php echo base_url(); ?>home"><img src="<?php echo base_url(); ?>assets/images/logo.png" width="30" height="30" class="d-inline-block align-top" alt=""><font color="white">ISTOCK</font></a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="<?php echo base_url(); ?>home/logout"><font color="white"><span class="fas fa-sign-out-alt"></span> Sign Out</font></a></li>
		</ul>
	</nav>
</div>
<div class="container"></div>
<!------ End Header ---------->

