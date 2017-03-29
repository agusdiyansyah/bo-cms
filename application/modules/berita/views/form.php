<section class="content-header">
	<h1><?php echo @$title;?> <small><?php echo @$subtitle ?></small></h1>
</section>
<section class="content-header aksi">
	<?php echo anchor(@$link_back, 'Kembali');?>
</section>

<section class="content">
    
    <form class="form" action="<?php echo $form_action ?>" method="post">
        
        <?php echo form_input($input['id_hide']) ?>
		
		<div class="row">
			<div class="col-sm-6">
                <label for="kategori" class="control-label">Kategori</label>
                <?php echo form_select($input['kategori']) ?>
				<a href="#" class="btn-add-kategori" style="margin-top: 5px; display: block">Tambah data kategori berita</a>
            </div>
			
			<div class="col-sm-6">
                <label for="status" class="control-label">Status</label>
                <?php echo form_select($input['status']) ?>
            </div>
        </div>
        
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
		            <button type="submit" class="btn btn-primary">Tambah Data</button>
		            <a href="<?php echo @$link_back ?>" class="btn btn-default">Kembali</a>
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
	});
</script>