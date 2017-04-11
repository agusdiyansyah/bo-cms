<?php echo $this->session->flashdata('message');?>
<section class="content-header">
	<h1><?php echo @$title;?> <small><?php echo @$subtitle ?></small></h1>
</section>
<section class="content-header aksi">
	<?php echo anchor(@$link_back, 'Kembali');?>
</section>

<section class="content">
    
    <form class="form" action="<?php echo $form_action ?>" method="post">
        
        <?php 
			echo form_input($input['hide']['id']);
			echo form_input($input['hide']['match_homeaway']);
		?>
		
		<div class="row remove-margin-top">
			<div class="col-xs-12">
				
				<div class="row">
		            <div class="col-xs-12">
		                <label for="match_rival" class="control-label">Rival</label>
		                <?php echo form_input($input['match_rival']) ?>
		            </div>
		        </div>
		        
				<div class="row">
		            <div class="col-xs-12">
		                <label for="match_date" class="control-label">Tanggal Main</label>
		                <?php echo form_input($input['match_date']) ?>
		            </div>
		        </div>
				
				<div class="row">
		            <div class="col-xs-12">
						<div class="">
							<label for="match_date" class="control-label">Bermain Sebagai</label>
						</div>
						<a href="#" class="btn btn-default ha home">Tuan Rumah</a>
						<a href="#" class="btn btn-default ha away">Lawan</a>
		            </div>
		        </div>
				
				<div class="row">
		            <div class="col-xs-12">
		                <label for="alamat" class="control-label">Alamat Lapangan</label>
		                <?php echo form_textarea($input['alamat']) ?>
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
		$('.mn-ProfilTeam, .mn-ProfilTeam .mn-Trophy').addClass('active');
		
		$(".match_date").datepicker({
			format: "yyyy-mm-dd",
			autoclose: true
		});
		
		$('.form').validate({
		   	ignore: [],
		  	errorClass: 'error',
		 	rules: {
				nama_pengurus : {required: true},
			},
			messages: {
				nama_pengurus : {required: "Nama pengurus tidak boleh kosong"}	,
			}
	   	});
	   
	});
</script>