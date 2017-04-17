<?php echo $this->session->flashdata('message');?>
<section class="content-header">
	<h1><?php echo @$title;?></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="tab active tab-umum">
                        <a href="#tab_1" data-toggle="tab" aria-expanded="true">Konfigurasi Website</a>
                    </li>
                    <li class="tab tab-image">
                        <a href="#tab_2" data-toggle="tab" aria-expanded="false">Image</a>
                    </li>
                    <li class="tab tab-socmed">
                        <a href="#tab_3" data-toggle="tab" aria-expanded="false">Link Social Media</a>
                    </li>
                    <li class="pull-right">
                        <a href="#" class="text-muted">
                            <i class="fa fa-gear"></i>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane tab-pane-umum active" id="tab_1">
                        <form class="form form_umum" action="<?php echo @$aksi['umum'] ?>" method="post">
                    		
                    		<div class="row remove-margin-top">
                    			<div class="col-xs-12">
                    				
                    				<div class="row">
                    		            <div class="col-xs-12">
                    		                <label for="nama_tim" class="control-label">Nama Tim<sup class="text-danger" style="font-size: 18px; top: -0.1em">*</sup></label>
                    		                <?php echo form_input($form_umum['nama_tim']) ?>
                    		            </div>
                    		        </div>
                                    
                                    <div class="row">
                                        <div class="col-xs-12">
                    		                <label for="keyword" class="control-label">Keyword</label>
                                            <p>
                                                <small>
                                                    Pisahkan kata kunci/keyword dengan koma
                                                </small>
                                            </p>
                    		                <?php echo form_input($form_umum['keyword']) ?>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-xs-12">
                    		                <label for="email" class="control-label">Email</label>
                    		                <?php echo form_input($form_umum['email']) ?>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-xs-12">
                    		                <label for="telepon" class="control-label">Telepon</label>
                    		                <?php echo form_input($form_umum['telepon']) ?>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-xs-12">
                    		                <label for="fax" class="control-label">Fax</label>
                    		                <?php echo form_input($form_umum['fax']) ?>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-xs-12">
                    		                <label for="alamat" class="control-label">Head Quarter</label>
                                            <p>
                                                <small>
                                                    Alamat/Home Base tim anda
                                                </small>
                                            </p>
                    		                <?php echo form_textarea($form_umum['alamat']) ?>
                                        </div>
                                    </div>
                    		        
                    		        <div class="row">
                    		            <div class="col-xs-12">
                    		                <label for="deskripsi" class="control-label">Deskripsi</label>
                                            <p>
                                                <small>
                                                    300 kata yang menggambarkan secara singkat tentang tim anda
                                                </small>
                                            </p>
                    		                <?php echo form_textarea($form_umum['deskripsi']) ?>
                    		            </div>
                    		        </div>
                    				
                    				<div class="row">
                    		            <div class="col-xs-12">
                    		                <div style="text-align: right">
                    		                    <button type="submit" class="btn btn-primary">Proses</button>
                    		                </div>
                    		            </div>
                    		        </div>
                    				
                    			</div>
                    		</div>
                            
                        </form>
                    </div>
                    <div class="tab-pane tab-pane-image" id="tab_2">
                        <form class="form form_image" action="<?php echo @$aksi['image'] ?>" method="post" enctype="multipart/form-data">
                    		
                    		<div class="row remove-margin-top">
                    			<div class="col-xs-12">
                    				
                                    <div class="row">
										<div class="col-sm-2">
                    						<label for="file" class="control-label">Logo Tim</label>
                    						<input id="logo" name="logo" type="file" class="logo file-loading">
                    						<input type="text" name="remove-logo" class="hide remove-logo" value="0">
											
                    						<div class="btn-group btn-group-justified" style="margin-bottom: 15px;">
                    						    <a href="#" class="btn btn-default fileinput-reset hide reset-logo" data-tipe="logo">Reset</a>
                    						    <a href="#" class="btn btn-primary fileinput-browse browse-logo" data-tipe="logo">Browse</a>
                    						</div>
                    					</div>
										
										<div class="col-sm-10">
                    						<label for="file" class="control-label">Cover</label>
                    						<input id="cover" name="cover" type="file" class="cover file-loading">
											<input type="text" name="remove-cover" class="hide remove-cover" value="0">
                    						
                    						<div class="btn-group btn-group-justified" style="margin-bottom: 15px;">
                    						    <a href="#" class="btn btn-default fileinput-reset hide reset-cover" data-tipe="cover">Reset</a>
                    						    <a href="#" class="btn btn-primary fileinput-browse browse-cover" data-tipe="cover">Browse</a>
                    						</div>
                    					</div>
                    				</div>
                    				
                    				<div class="row">
                    		            <div class="col-xs-12">
                    		                <div style="text-align: right">
                    		                    <button type="submit" class="btn btn-primary">Proses</button>
                    		                </div>
                    		            </div>
                    		        </div>
                    				
                    			</div>
                    		</div>
                            
                        </form>
                    </div>
                    <div class="tab-pane tab-pane-socmed" id="tab_3">
                        <form class="form form_socmed" action="<?php echo @$aksi['socmed'] ?>" method="post">
                    		
                    		<div class="row remove-margin-top">
                    			<div class="col-xs-12">
                    				
                    				<div class="row">
                    		            <div class="col-xs-12">
                    		                <label for="facebook" class="control-label">Facebook</label>
                    		                <?php echo form_input($form_socmed['facebook']) ?>
                    		            </div>
                    		        </div>
                                    
                                    
                                    <div class="row">
                    		            <div class="col-xs-12">
                    		                <label for="twitter" class="control-label">Twitter</label>
                    		                <?php echo form_input($form_socmed['twitter']) ?>
                    		            </div>
                    		        </div>
                                    
                                    <div class="row">
                    		            <div class="col-xs-12">
                    		                <label for="instagram" class="control-label">Instagram</label>
                    		                <?php echo form_input($form_socmed['instagram']) ?>
                    		            </div>
                    		        </div>
                                    
                                    <div class="row">
                    		            <div class="col-xs-12">
                    		                <label for="google_plus" class="control-label">Google Plus</label>
                    		                <?php echo form_input($form_socmed['google_plus']) ?>
                    		            </div>
                    		        </div>
                                    
                                    <div class="row">
                    		            <div class="col-xs-12">
                    		                <label for="bloglovin" class="control-label">Bloglovin</label>
                    		                <?php echo form_input($form_socmed['bloglovin']) ?>
                    		            </div>
                    		        </div>
                                    
                                    <div class="row">
                    		            <div class="col-xs-12">
                    		                <label for="pinterest" class="control-label">Pinterest</label>
                    		                <?php echo form_input($form_socmed['pinterest']) ?>
                    		            </div>
                    		        </div>
                                    
                                    <div class="row">
                    		            <div class="col-xs-12">
                    		                <label for="youtube" class="control-label">Youtube</label>
                    		                <?php echo form_input($form_socmed['youtube']) ?>
                    		            </div>
                    		        </div>
                                    
                                    <div class="row">
                    		            <div class="col-xs-12">
                    		                <label for="tumblr" class="control-label">Tumblr</label>
                    		                <?php echo form_input($form_socmed['tumblr']) ?>
                    		            </div>
                    		        </div>
                    				
                    				<div class="row">
                    		            <div class="col-xs-12">
                    		                <div style="text-align: right">
                    		                    <button type="submit" class="btn btn-primary">Proses</button>
                    		                </div>
                    		            </div>
                    		        </div>
                    				
                    			</div>
                    		</div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        var tabSelected = "<?php echo $tabSelected ?>";
        $(".mn-ProfilTeam, .mn-ProfilTeam .mn-InformasiUmum").addClass("active");
        
        switch (tabSelected) {
            case "image":
				$(".tab").removeClass("active");
				$(".tab-pane").removeClass("active");
				$(".tab-image").addClass("active");
				$(".tab-pane-image").addClass("active");
                // getDataMetaImage();
            break;
            
            case "socmed":
                $(".tab").removeClass("active");
                $(".tab-pane").removeClass("active");
                $(".tab-socmed").addClass("active");
                $(".tab-pane-socmed").addClass("active");
                getDataMetaSocmed();
            break;
            
            default:
                getDataMetaUmum();
        }
        
        $(".tab-umum").click(function(event) {
            getDataMetaUmum();
        });
        
        $(".tab-image").click(function(event) {
            // getDataMetaImage();
        });
        
        $(".tab-socmed").click(function(event) {
            getDataMetaSocmed();
        });
        
        $('.form_umum').validate({
 		   	ignore: [],
 		   	errorClass: 'error',
 		   	rules: {
 			   	nama_tim : {required: true},
 		   	},
 		   	messages: {
 			   	nama_tim : {required: "Nama tim tidak boleh kosong"},
 		   	}
        });
		
		fileInputInit({
			target: "cover"
		});
		
		fileInputInit({
			target: "logo"
		});
        
		$(".form_image").on('click', '.fileinput-browse', function(event) {
        	event.preventDefault();
			var tipe = $(this).data("tipe");
          	$("#" + tipe).trigger('click');
     	});
        
		$(".form_image").on('click', '.fileinput-reset', function(event) {
        	event.preventDefault();
			var tipe = $(this).data("tipe");
 			fileInputReset(tipe);
 		});
    });
    
    function getDataMetaUmum () {
        $.ajax({
            url: "<?php echo $data['umum'] ?>",
            type: "post",
            dataType: "json",
            data: {
                ac: "umum"
            },
            success: function (json) {
                $(".nama_tim").val(json.nama_tim);
                $(".deskripsi").val(json.deskripsi);
                $(".keyword").val(json.keyword);
                $(".email").val(json.email);
                $(".telepon").val(json.telepon);
                $(".fax").val(json.fax);
                $(".alamat").val(json.alamat);
            }
        });
    }
    
    function getDataMetaSocmed () {
        $.ajax({
            url: "<?php echo $data['socmed'] ?>",
            type: "post",
            dataType: "json",
            data: {
                ac: "socmed"
            },
            success: function (json) {
                $(".facebook").val(json.facebook);
                $(".twitter").val(json.twitter);
                $(".instagram").val(json.instagram);
                $(".google_plus").val(json.google_plus);
                $(".bloglovin").val(json.bloglovin);
                $(".pinterest").val(json.pinterest);
                $(".youtube").val(json.youtube);
                $(".tumblr").val(json.tumblr);
            }
        });
    }
	
	function fileInputReset (target) {
		$("#" + target).fileinput('destroy');
		$(".remove_" + target).val(1);
		fileInputInit({
			reset: true,
			target: target
		});
	}
	
	function fileInputInit (conf = {
		reset: false,
		target: ""
	}) {
		var imageLink = "<?php echo @$cover ?>";
		
		if (imageLink == "" || conf.reset) {
			imageLink = "<?php echo base_url("assets/themes/adminLTE/img/boxed-bg.png") ?>";
			$(".form_image").find('.fileinput-reset.reset-'+conf.target).addClass('hide');
		} else {
			$(".form_image").find('.fileinput-reset.reset-'+conf.target).removeClass('hide');
		}
		
		var fileInput = {
 		   maxFilePreviewSize: 10240,
 		   autoReplace     : true,
 		   showUpload      : false,
 		   showCaption     : false,
 		   showBrowse      : true,
 		   showCancel      : false,
 		   browseLabel     : "Browse",
 		   previewSettings : {
 			   image: { width: "98.5%", height: "auto" },
 		   },
 		   initialPreview: [
 			   "<img src='"+ imageLink +"' class='file-preview-image' style='width: 100%; height: auto' alt='Default Image' title='Default Image'>",
 		   ]
 	   };
 	   
 	   	$("#" + conf.target)
 		   	.fileinput(fileInput)
 		   	.on('fileimageloaded', function(event, previewId) {
 			   	$(".form_image").find('.fileinput-reset.reset-'+conf.target).removeClass('hide');
				$(".remove_" + conf.target).val(0);
 		   	})
 		   	.on('fileclear', function(event) {
 			   	$(".form_image").find('.fileinput-reset.reset-'+conf.target).addClass('hide');
 		   	});
	}
</script>