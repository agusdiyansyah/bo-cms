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
        	
			<div class="col-sm-4 col-md-3 col-sm-push-8 col-md-push-9">
				<div class="row">
					<div class="col-xs-12">
						<label for="file" class="control-label">Photo</label>
						<input id="file" name="file" type="file" class="file-loading">
						<!-- <div id="errorBlock" class="help-block"></div> -->
						
						<div class="btn-group btn-group-justified" style="margin-bottom: 15px;">
							<!-- <a href="#" class="btn btn-default fileinput-reset hide">Reset</a> -->
							<a href="#" class="btn btn-primary fileinput-browse">Browse</a>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-sm-8 col-md-9 col-sm-pull-4 col-md-pull-3">
				<div class="row">
					<div class="col-xs-12">
						<label for="nama" class="control-label">Nama</label>
						<?php echo form_input($input['nama']) ?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-12">
						<label for="no_jersey" class="control-label">Nomor Jersey</label>
						<?php echo form_input($input['no_jersey']) ?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-12">
						<label for="jabatan" class="control-label">Posisi</label>
						<?php echo form_select($input['posisi']) ?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-12">
						<label for="kota_kelahiran" class="control-label">Kota Kelahiran</label>
						<?php echo form_input($input['kota_kelahiran']) ?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-12">
						<label for="tanggal_lahir" class="control-label">Tanggal Lahir</label>
						<?php echo form_input($input['tanggal_lahir']) ?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-12">
						<span>Link Social Media</span>
						<?php foreach ($input['socmed'] as $key => $data): ?>
							<div class="row">
								<div class="col-xs-12">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1"><i style="min-width: 15px" class="<?php echo $data['icon'] ?>"></i></span>
										<?php echo form_input($data['item']) ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-12">
						<label for="biografi" class="control-label">Biografi</label>
						<?php echo form_textarea($input['biografi']) ?>
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
		$('.mn-Pemain').addClass('active');
		
		$(".select2").select2({
			width: "100%"
		});
		
		$('.tanggal_lahir').bootstrapMaterialDatePicker({
            format : 'YYYY-MM-DD',
            lang : 'en',
            weekStart : 0,
            time: false,
            cancelText : 'Kembali'
        });
		
		$('.form').validate({
		   	ignore: [],
		  	errorClass: 'error',
		 	rules: {
				nama : {required: true},
				jabatan : {required: true},
			},
			messages: {
				nama : {required: "Nama tidak boleh kosong"} ,
				jabatan : {required: "Jabatan tidak boleh kosong"} ,
		   	}
	   	});
		
		$(".biografi").ckeditor({
	        filebrowserBrowseUrl: '<?php echo base_url("media/editor") ?>',
	    	height: 400,
	    	wordcount:{
	    		showParagraphs: false,
	    		showCharCount: true
	    	}
	    }).on( 'dialogDefinition', function( ev ) {
	        ev.data.definition.resizable = CKEDITOR.DIALOG_RESIZE_NONE;
	    });
		
		fileInputInit();
        
        $(".form").on('click', '.fileinput-browse', function(event) {
        	event.preventDefault();
          	$("#file").trigger('click');
     	});
	});
	
	function fileInputInit (conf = {
		reset: false
	}) {
		var imageLink = "<?php echo $photo ?>";
		
		if (imageLink == "" || conf.reset) {
			imageLink = "<?php echo base_url("assets/themes/adminLTE/img/boxed-bg.png") ?>";
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
 		   	.fileinput(fileInput);
	}
</script>