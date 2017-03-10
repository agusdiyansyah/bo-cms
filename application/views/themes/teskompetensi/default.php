<!DOCTYPE html>
<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tes Kompetensi">
    <meta name="keywords" content="">
    <title>BKD Kota Pontianak - Tes Kompetensi</title>
    <!--pageMeta-->
    <!-- Loading Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/themes/teskompetensi/css/bootstrap.css" rel="stylesheet">
    <!-- Loading Elements Styles -->
    <link href="<?php echo base_url(); ?>assets/themes/teskompetensi/css/style.css" rel="stylesheet">
    <!-- Loading Magnific-Popup Styles -->
    <link href="<?php echo base_url(); ?>assets/themes/teskompetensi/css/magnific-popup.css" rel="stylesheet">
    <!-- Loading Font Styles -->
    <link href="<?php echo base_url(); ?>assets/themes/teskompetensi/css/iconfont-style.css" rel="stylesheet">
    <!-- WOW Animate-->
    <link href="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/animations/animate.css" rel="stylesheet">
    <!-- Datepicker Styles -->
    <link href="<?php echo base_url(); ?>assets/themes/teskompetensi/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/teskompetensi/plugins/jQuery-Simple-Timer/examples/style.css" rel="stylesheet">
    <!-- Favicons -->
    <link rel="icon" href="<?php echo base_url(); ?>assets/themes/teskompetensi/images/favicons/favicon.png">
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/themes/teskompetensi/images/favicons/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>assets/themes/teskompetensi/images/favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>assets/themes/teskompetensi/images/favicons/apple-touch-icon-114x114.png">
    
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="scripts/html5shiv.js"></script>
      <script src="scripts/respond.min.js"></script>
    <![endif]-->
    <!--headerIncludes-->
    <!-- JavaScript -->
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/jquery-1.11.2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/smoothscroll.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/jquery.smooth-scroll.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/placeholders.jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/jquery.counterup.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/waypoints.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/video.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/bigvideo.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/animations/wow.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/jquery.jCounter-0.1.4.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/audio.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/goodshare.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/teskompetensi/scripts/custom.js"></script>
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
</head>

<body data-spy="scroll" data-target=".navMenuCollapse">
    
    <div id="wrap">
    <!-- NAVIGATION -->
		<nav class="navbar bg-color3">
			<div class="container"> 
				<a class="navbar-brand goto" href="#">BKD Kota Pontianak</a>
				<button class="round-toggle navbar-toggle menu-collapse-btn collapsed" data-toggle="collapse" data-target=".navMenuCollapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<div class="collapse navbar-collapse navMenuCollapse">
					<ul class="nav">
                        <li><?php echo anchor('teskompetensi', 'Beranda');?></li>
						<li><?php echo anchor('teskompetensi', 'Kategori Kompetensi');?></li>
						<?php
						if ($this->session->userdata('peserta_nama')) {
							echo '<li>'.anchor('teskompetensi/peserta/', $this->session->userdata('peserta_nama')).'</li>';
						}
						?>
						
					</ul>
				</div>
			</div>
		</nav>
		<?php echo $output;?>

	</div>
    <!-- /#wrap -->
</body></html>