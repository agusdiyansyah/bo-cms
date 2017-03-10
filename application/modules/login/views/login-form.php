<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	    <title><?php echo $title;?></title>
	    <link rel="shortcut icon" href="<?php echo base_url();?>assets/themes/adminLTE/img/doc.ico">
	    <link href="<?php echo base_url(); ?>assets/themes/adminLTE/css/bootstrap.min.css" rel="stylesheet">
	    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->
	    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
	    <link href="<?php echo base_url(); ?>assets/themes/adminLTE/css/font-awesome.css" rel="stylesheet">
	    <link href="<?php echo base_url(); ?>assets/themes/adminLTE/css/ionicons.min.css" rel="stylesheet">
	    <link href="<?php echo base_url(); ?>assets/themes/adminLTE/css/AdminLTE.min.css" rel="stylesheet">
	    <link href="<?php echo base_url(); ?>assets/themes/adminLTE/css/skins/_all-skins.min.css" rel="stylesheet">
	    <script src="<?php echo base_url();?>assets/themes/adminLTE/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/adminLTE/js/bootstrap.min.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/adminLTE/js/app.min.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/adminLTE/js/demo.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/adminLTE/plugins/fastclick/fastclick.min.js"></script>
	    <script src="<?php echo base_url();?>assets/themes/adminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
	    <script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
	    <style type="text/css">
	      body {
	        margin-top: 50px;
	        margin-bottom: 50px;
	        background: none;
	      }
	      body{					
				background-image: url("<?php echo base_url();?>assets/themes/adminLTE/img/bg.jpg");
				background-size: cover;
				background-repeat: repeat, no-repeat;
				background-position: 0px -150px;
			}

			.col-null{
				padding-left: 0;
				padding-right: 0
			}

			.title{
				position: absolute;
				top: 10px;
				right: -15px;
				z-index: 999;
			}

			.title h3{
				background: #3B5998;
				color: white;
				font-weight: bold;
				padding: 15px 20px;
				padding-right: 350px;
			}

			.title img{
				height: 100px;
				position: absolute;
				bottom: -10px;
				right: 0;
			}

			.describe{
				background: rgba(255,255,255, .8);
				padding: 150px 20px;
				color: #114479;
				text-align: right;
			}

			.describe h3{
				margin: 17px 0 21px;
				font-weight: bold;
			}

			.login-body{
				height: 435px;
			}

			.login{
				background: #3B5998;
				padding: 20px;
				color: #fff;
				position: absolute;
				left: 0;
				bottom: 0;
			}

			.login h4{
				font-size: 26px;
				font-weight: bold;
				margin-top: 0;
			}

			.login form{
				margin-top: 30px;
				margin-bottom: 10px;
				text-align: left;
			}

			.login input{
				width: 100%;
				margin-bottom: 15px;
				padding: 10px 15px;
				color: #333;
				background: #fff;
				transition: background ease .8s;
				border: 0;
			}

			.login input:hover{
				background: #bcbcbc;
			}

			.login input:focus{
				background: #333;
				color: #fff;
				border: 0;
			}

			.login button{
				border: 0;
				background: #f7931c;
				padding: 10px 20px;
				font-weight: bold;
				border-radius: 0;
				transition: border-radius ease 1s;
			}

			.login button:hover{
				border-radius: 50px;
			}

			.login a{
				color: #ffca01;
				text-decoration: underline;
				display: block;
				margin-top: 20px;
				transition: color ease .5s;
			}

			.login a:hover{
				color: #fff;
			}

			.copyright{
				color: #114479;
				position: absolute;
				bottom: 10px;
				right: 30px;	
			}


			@media (min-width: 992px) and (max-width: 1199px) {
				.login-body{
					height: 455px;
				}

				.login form{
					text-align: left;
					margin-bottom: 0px;
				}

				.login a{
					margin-top: 20px;
					display: block;
					margin-bottom: 0;
				}
			}

			@media (min-width: 768px) and (max-width: 991px) {
				body{
					background-position: 0px 0px;
				}
				
				.describe{
					padding: 170px 25px;
				}

				.login form{
					text-align: left;
					margin-bottom: 0px;
				}

				.login a{
					margin-top: 20px;
					display: block;
					margin-bottom: 0;
				}
			}

			@media (max-width: 767px) {
				body{
					background-position: 0px 0px;
				}

				.copyright{
					left: 35px;
				}

				.describe{
					padding-bottom: 50px;
					text-align: left;
				}

				.login-body{
					height: 350px;
				}

				.login{
					margin-top: 30px;
					position: static;
				}

				.login form{
					text-align: left;
					margin-bottom: 0px;
				}

				.login a{
					margin-top: 20px;
					display: block;
					margin-bottom: 0;
				}
			}
	    </style>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6"></div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<div class="col-md-12 col-sm-12 col-xs-12 col-null">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="title">
								<h3>BKKBN</h3>
								<img src="<?php echo base_url();?>assets/themes/adminLTE/img/logo-bkkbn.png">
							</div>
						</div>
						<div class="col-md-5 col-sm-6 col-xs-12">
							<div class="describe">
								<h3>"ARSIP DIGITAL"</h3>
								<p>Digitalisasi Arsip Pegawai BKKN Kota Pontianak</p>
								<hr>
							</div>
						</div>
						<div class="col-md-5 col-sm-6 col-xs-12 login-body">
							<div class="login">
								<h4>User Login</h4>
								<?php echo $this->session->flashdata('message');?>
								<?php echo form_open($form_action, 'id="formlogin"');?>
									<input name="userid" type="text" placeholder="Masukkan Username" id="userid">
									<span class="help-block"><?php echo form_error('userid');?></span>
									<input name="password" type="password" placeholder="Masukkan Password" id="password">
									<span class="help-block"><?php echo form_error('password');?></span>
									<div class="radio">
						                <label>
						                  <input type="radio" name="type" value="admin" checked> Admin  
						                </label>
						                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						                <label>
						                  <input type="radio" name="type" value="pegawai"> Pegawai
						                </label>
						            </div>
									<button type="submit">ENTER</button>
								<?php echo form_close();?>					
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>