<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>
        <?php echo $title;?>
    </title>
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
        
        .full {
            background: url("assets/themes/adminLTE/img/bg.jpg") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
</head>

<body class="hold-transition login-page full">
    <div class="login-box">
        <div class="login-logo">
            <a href="#">
                <b><?php echo $title;?></b>
            </a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">
                <?php echo $this->session->flashdata('message');?>
            </p>
            <form action="<?php echo $form_action;?>" method="post">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Userid" id="userid" name="userid">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    <span class="help-block"><?php echo form_error('userid');?></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <span class="help-block"><?php echo form_error('password');?></span>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-8"></div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>