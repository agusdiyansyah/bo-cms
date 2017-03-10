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
            <div class="col-xs-12">
                <label for="nama_pengurus" class="control-label">Nama Pengurus</label>
                <?php echo form_input($input['nama_pengurus']) ?>
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
		$('.mn-Pengurus').addClass('active');
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