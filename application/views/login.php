<!DOCTYPE html>
<html lang="en">
<head>
	<title>Istok - Dashboard</title>

	<!------ Include the above in your HEAD tag ---------->
	<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/jquery/jquery-3.4.1.min.js"></script>
	
	<style>
		body {
			font-family: "Lato", sans-serif;
		}



		.main-head{
			height: 100px;
			background: #FFF;
		   
		}

		.sidenav {
			height: 100%;
			background-color: #000;
			overflow-x: hidden;
			padding-top: 20px;
		}


		.main {
			padding: 0px 10px;
		}

		@media screen and (max-height: 450px) {
			.sidenav {padding-top: 15px;}
		}

		@media screen and (max-width: 450px) {
			.login-form{
				margin-top: 10%;
			}

			.register-form{
				margin-top: 10%;
			}
		}

		@media screen and (min-width: 768px){
			.main{
				margin-left: 40%; 
			}

			.sidenav{
				width: 40%;
				position: fixed;
				z-index: 1;
				top: 0;
				left: 0;
			}

			.login-form{
				margin-top: 80%;
			}

			.register-form{
				margin-top: 20%;
			}
		}


		.login-main-text{
			margin-top: 20%;
			padding: 60px;
			color: #fff;
		}

		.login-main-text h2{
			font-weight: 300;
		}

		.btn-black{
			background-color: #000 !important;
			color: #fff;
		}
	</style>	
</head>
<body>

<div class="sidenav">
         <div class="login-main-text">
            <h2>Application<br> Login Page</h2>
            <p>Login from here to access.</p>
         </div>
      </div>
      <div class="main">
         <div class="col-md-6 col-sm-12">
            <div class="login-form">
			   <!--<form action="<?php echo base_url('login/aksi_login'); ?>" method="post">-->
                  <div class="form-group">
                     <label>User Name</label>
                     <input type="text" class="form-control" id="email" name="email" placeholder="User ID" required autofocus>
                  </div>
                  <div class="form-group">
                     <label>Password</label>
                     <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                  </div>
                  <button type="submit" class="login btn btn-black">Login</button>
               <!--</form>-->
            </div>
         </div>
      </div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>

<script>
    $('.login').click(function () {
      var email = document.getElementById('email').value;
      var password = document.getElementById('password').value;

      $.ajax({
        url: '<?php echo base_url() ?>index.php/login/aksi_login/',
        type: 'post',
        data: {email:email,password:password},
        dataType: 'json',
        success: function(result){
          
          if(result.toString() == "Success")
          {
            window.location.replace("<?php echo base_url() ?>home");
          }else{
            alert(result.toString());
          }
          
        }
      });
    });
  </script>
</body>
</html>
