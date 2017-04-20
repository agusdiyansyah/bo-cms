<?php echo $this->session->flashdata('message');?>
<section class="content-header">
	<h1><?php echo @$title;?> <small><?php echo @$subtitle ?></small></h1>
</section>
<section class="content-header aksi">
	<?php echo anchor(@$link_back, 'Kembali');?>
</section>

<section class="content">
    
    <form class="form" action="<?php echo $form_action ?>" method="post" enctype="multipart/form-data">
        
        <?php echo form_input($input['hide']['id']) ?>
		
		<div class="row remove-margin-top">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-xs-12">
						<label for="file" class="control-label">Cover</label>
						<input id="file" name="file" type="file" class="file-loading">
						<input type="hidden" name="remove-cover" class="remove-cover" value="0">
						
						<div class="btn-group btn-group-justified" style="margin-bottom: 15px;">
						    <!-- <a href="#" class="btn btn-default fileinput-reset hide">Reset</a> -->
						    <a href="#" class="btn btn-primary fileinput-browse">Browse</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="row">
                	<div class="col-xs-12">
						<label for="title" class="control-label">Title</label>
		                <?php echo form_input($input['title']) ?>
                	</div>
                </div>
				
				<div class="row">
                	<div class="col-xs-12">
						<label for="content" class="control-label">Keterangan</label>
		                <?php echo form_textarea($input['content']) ?>
                	</div>
                </div>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-xs-12">
				<div style="text-align: right">
		            <button type="submit" class="btn btn-primary">Proses</button>
		            <a href="<?php echo @$link_back ?>" class="btn btn-default">Kembali</a>
		        </div>
        	</div>
        </div>
        
    </form>
    
</section>

<script type="text/javascript">
	$(document).ready(function() {
		$('.mn-Slideshow').addClass('active');
		
		$("#content").ckeditor({
	        filebrowserBrowseUrl: '<?php echo base_url("media/editor") ?>',
	    	height: 400,
	    	wordcount:{
	    		showParagraphs: false,
	    		showCharCount: true
	    	}
	    }).on( 'dialogDefinition', function( ev ) {
	        ev.data.definition.resizable = CKEDITOR.DIALOG_RESIZE_NONE;
	    });
		
		$('.form').validate({
		   ignore: [],
		   errorClass: 'error',
		   rules: {
			   title : {required: true},
		   },
		   messages: {
			   title : {required: "Nama pengurus tidak boleh kosong"},
		   }
	   });
	   
	   fileInputInit({
		   imageLink: "<?php echo $cover ?>"
	   });
	   
	   $(".form").on('click', '.fileinput-browse', function(event) {
		   event.preventDefault();
		   $("#file").trigger('click');
	   });
	   
	   $(".form").on('click', '.fileinput-reset', function(event) {
		   event.preventDefault();
		   fileInputReset();
	   });
	});
	
	function fileInputReset () {
		$("#file").fileinput('destroy');
		$(".remove-cover").val(1);
		fileInputInit({
			reset: true
		});
	}
	
	function fileInputInit (conf = {
		reset: false
	}) {
		var imageLink = "";
		if (typeof conf.imageLink === "undefined" || !conf.imageLink || conf.imageLink == "") {
			imageLink = "<?php echo base_url("assets/themes/adminLTE/img/boxed-bg.png") ?>";
		} else {
			imageLink = conf.imageLink;
		}
		
		// if (conf.reset) {
		// 	$(".form").find('.fileinput-reset').addClass('hide');
		// } else {
		// 	$(".form").find('.fileinput-reset').removeClass('hide');
		// }
		
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
 	   
 	   	$("#file")
 		   	.fileinput(fileInput)
			//    	.on('fileimageloaded', function(event, previewId) {
 		// 	   	$(".form").find('.fileinput-reset').removeClass('hide');
			// 	$(".remove-cover").val(0);
			//    	})
			//    	.on('fileclear', function(event) {
 		// 	   	$(".form").find('.fileinput-reset').addClass('hide');
			//    	});
	}
</script>