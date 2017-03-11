<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<link rel="shortcut icon" href="<?php echo base_url();?>assets/themes/adminLTE/img/doc.ico">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link href="<?php echo base_url(); ?>assets/themes/adminLTE/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/themes/adminLTE/plugins/Font-Awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/themes/adminLTE/css/ionicons.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/themes/adminLTE/css/AdminLTE.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/themes/adminLTE/css/skins/_all-skins.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/themes/adminLTE/css/skins/custom-skin.css" rel="stylesheet">

	<script src="<?php echo base_url();?>assets/themes/adminLTE/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="<?php echo base_url();?>assets/themes/adminLTE/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/themes/adminLTE/plugins/fastclick/fastclick.min.js"></script>
	<script src="<?php echo base_url();?>assets/themes/adminLTE/plugins/pace/pace.js"></script>
	<script src="<?php echo base_url();?>assets/themes/adminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url();?>assets/themes/adminLTE/js/app.min.js"></script>
	<script src="<?php echo base_url();?>assets/themes/adminLTE/js/demo.js"></script>
	
	<link href="<?php echo base_url(); ?>assets/themes/adminLTE/plugins/pace/pace.css" rel="stylesheet">

	<?php
		if(!empty($meta))
		foreach($meta as $name=>$content){
			echo "\n\t\t";
			?><meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" /><?php
				 }
		echo "\n";

		if(!empty($canonical))
		{
			echo "\n\t\t";
			?><link rel="canonical" href="<?php echo $canonical?>" /><?php

		}
		echo "\n\t";

		foreach($css as $file){
		 	echo "\n\t\t";
			?><link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" /><?php
		}
		echo "\n\t";

		foreach($js as $file){
				echo "\n\t\t";
				?><script src="<?php echo $file; ?>"></script><?php
		}
		echo "\n\t";

	?>

	<link href="<?php echo base_url(); ?>assets/themes/adminLTE/css/custom.css" rel="stylesheet">

	<script src="<?php echo base_url();?>assets/themes/adminLTE/js/custom.js"></script>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-black sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
		    <!-- Logo -->
		    <a href="#" class="logo">
		      <span class="logo-mini"><small><b>BKD</b></small></span>
		      <span class="logo-lg"><b><i>PESAT</i></b></span>
		    </a>

		    <!-- Header Navbar -->
		    <nav class="navbar navbar-static-top" role="navigation">
		      <!-- Sidebar toggle button-->
		      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </a>
		      <div class="navbar-custom-menu">
		      	<?php
			      	if($this->load->get_section('header_navbar') == "") {
			      		$this->load->view('themes/adminLTE/header_navbar');
		        	}
		        	else {
		        		echo $this->load->get_section('header_navbar');
		        	}
		        ?>
		      </div>
		    </nav>
		</header>

		<!-- Left side column. contains the sidebar -->
	    <aside class="main-sidebar">
	        <!-- sidebar: style can be found in sidebar.less -->
	        <section class="sidebar">
	          <!-- Sidebar user panel -->
	        	<!-- <div class="user-panel">
		            <div class="pull-left image">
		            	<?php
		            		$user_image = base_url().'assets/themes/adminLTE/img/logo.png';
					    ?>
		              	<img src="<?php echo $user_image;?>" class="img" width="150px" alt="User Image">
		            </div>
		            <div class="pull-left info">
		              <p>BADAN KEPEGAWAIAN <br> DAERAH</p>
		              <small>Pemerintah Kota Pontianak</small>
		            </div>
	        	</div> -->
        		<!-- sidebar menu -->
        		<?php
        		if($this->load->get_section('sidebar_menu') == ""){
        			echo Modules::run("menu/admin/tampil");
        		}
        		else {
        			echo $this->load->get_section('sidebar_menu');
        		}

        		?>
	        </section>
	        <!-- /.sidebar -->
	    </aside>

		<div class="content-wrapper">

			<?php echo $output;?>

		</div>

	</div>
</body>
</html>
