<section class="content-header">
	<h1><?php echo @$title;?> <small><?php echo @$subtitle ?></small></h1>
</section>
<section class="content-header aksi">
	<?php echo anchor(@$link_back, 'Kembali');?>
</section>

<section class="content">
    
    <form class="form" action="<?php echo $form_action ?>" method="post" enctype="multipart/form-data">
        
        <?php echo form_input($input['id_hide']) ?>
		<input type="hidden" name="stat_removecover" class="stat_removecover" value="0">
		
		<div class="row remove-margin-top">
			
			<div class="col-sm-push-8 col-md-push-9 col-md-3 col-sm-4">
				<div class="row">
					<div class="col-xs-12">
		                <label for="kategori" class="control-label">Kategori</label>
		                <?php echo form_select($input['kategori']) ?>
						<a href="<?php echo site_url("berita/kategori/add") ?>" class="btn-add-kategori" style="margin-top: 5px; display: block">Tambah data kategori berita</a>
		            </div>
				</div>
				
				<div class="row">
					<div class="col-xs-12">
		                <label for="status" class="control-label">Status</label>
		                <?php echo form_select($input['status']) ?>
		            </div>
				</div>
				
				<div class="row">
					<div class="col-xs-12">
						<label for="file" class="control-label">Cover Berita</label>
						<input id="file" name="file" type="file" class="file-loading">
						<!-- <div id="errorBlock" class="help-block"></div> -->
						
						<div class="btn-group btn-group-justified" style="margin-bottom: 15px;">
						    <a href="#" class="btn btn-default fileinput-reset hide">Reset</a>
						    <a href="#" class="btn btn-primary fileinput-browse">Browse</a>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-sm-pull-4 col-md-pull-3 col-sm-8 col-md-9">
				<div class="row">
					<div class="col-xs-12">
		                <label for="title" class="control-label">Title</label>
		                <?php echo form_input($input['title']) ?>
		            </div>
		        </div>
				
				<div class="row">
					<div class="col-xs-12">
		                <label for="sinopsis" class="control-label">Sinopsis</label>
		                <?php echo form_textarea($input['sinopsis']) ?>
		            </div>
				</div>
				
				<div class="row">
					<div class="col-xs-12">
		                <label for="content" class="control-label">Isi Berita</label>
		                <?php echo form_textarea($input['content']) ?>
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
			</div>
			
		</div>
        
    </form>
    
</section>

<script type="text/javascript">
	$(document).ready(function() {
		$('.mn-Berita, .mn-Berita .mn-Data').addClass('active');
		
		$(".select2").select2({
			width: "100%"
		});
		
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
			   	nama_pengurus : {required: true},
		   	},
		   	messages: {
			   	nama_pengurus : {required: "Nama pengurus tidak boleh kosong"},
		   	}
	   	});
		
		fileInputInit();
 		   
 	   	$(".form").on('click', '.file-drop-zone', function(event) {
           	 event.preventDefault();
          	  $("#file").trigger('click');
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
		$(".stat_removecover").val(1);
		fileInputInit({
			reset: true
		});
	}
	
	function fileInputInit (conf = {
		reset: false
	}) {
		var imageLink = "<?php echo $cover ?>";
		
		if (imageLink == "" || conf.reset) {
			imageLink = "<?php echo base_url("assets/themes/adminLTE/img/boxed-bg.png") ?>";
			$(".form").find('.fileinput-reset').addClass('hide');
		} else {
			$(".form").find('.fileinput-reset').removeClass('hide');
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
 	   
 	   	$("#file")
 		   	.fileinput(fileInput)
 		   	.on('fileimageloaded', function(event, previewId) {
 			   	$(".form").find('.fileinput-reset').removeClass('hide');
				$(".stat_removecover").val(0);
 		   	})
 		   	.on('fileclear', function(event) {
 			   	$(".form").find('.fileinput-reset').addClass('hide');
 		   	});
	}
</script>