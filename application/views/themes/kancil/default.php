<!DOCTYPE html>
<html lang="en-gb">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <link href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/themes/kancil/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <link href="<?php echo base_url(); ?>assets/themes/kancil/css/akslider.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/themes/kancil/css/donate.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/themes/kancil/css/theme.css" rel="stylesheet" type="text/css" />
    <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/mootools/1.3.1/mootools-yui-compressed.js'></script>

</head>

<body class="tm-isblog">

    <div class="preloader">
        <div class="loader"></div>
    </div>


    <div class="over-wrap">
        <div class="toolbar-wrap">
            <div class="uk-container uk-container-center">
                <div class="tm-toolbar uk-clearfix uk-hidden-small">


                    <div class="uk-float-right">
                        <div class="uk-panel">
                            <div class="social-top">
                                <a href="#"><span class="uk-icon-small uk-icon-hover uk-icon-facebook"></span></a>
                                <a href="#"><span class="uk-icon-small uk-icon-hover uk-icon-twitter"></span></a>
                                <a href="#"><span class="uk-icon-small uk-icon-hover uk-icon-google"></span></a>
                                <a href="#"><span class="uk-icon-small uk-icon-hover uk-icon-youtube"></span></a>
                                <a href="#"><span class="uk-icon-small uk-icon-hover uk-icon-instagram"></span></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <?php echo Modules::run('menu');?>

        <?php echo $output;?>
    </div>

    

<script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/kancil/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/kancil/js/uikit.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/kancil/js/SimpleCounter.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/kancil/js/components/grid.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/kancil/js/components/slider.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/kancil/js/components/slideshow.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/kancil/js/components/slideset.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/kancil/js/components/sticky.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/kancil/js/components/lightbox.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/kancil/js/isotope.pkgd.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/kancil/js/theme.js"></script>
<script type="text/javascript">
    new SimpleCounter("countdown4", 1447448400, {
      'continue': 0,
      format: '{D} {H} {M} {S}',
      lang: {
          d: {
              single: 'day',
              plural: 'days'
          }, //days
          h: {
              single: 'hr',
              plural: 'hrs'
          }, //hours
          m: {
              single: 'min',
              plural: 'min'
          }, //minutes
          s: {
              single: 'sec',
              plural: 'sec'
          } //seconds
      },
      formats: {
          full: "<span class='countdown_number' style='color:  '>{number} </span> <span class='countdown_word' style='color:  '>{word}</span> <span class='countdown_separator'>:</span>", //Format for full units representation
          shrt: "<span class='countdown_number' style='color:  '>{number} </span>" //Format for short unit representation
      }
  });
</script>

</body>

</html>