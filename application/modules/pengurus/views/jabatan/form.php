<?php echo $this->session->flashdata('message');?>
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
                <label for="jabatan" class="control-label">Jabatan Staf</label>
                <?php echo form_select($input['jabatan']) ?>
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
		$('.mn-Berita, .mn-Berita .mn-Kategori').addClass('active');
		
		$('.jabatan').select2({
			placeholder        : '',
		    minimumInputLength : 2,
		    width: '100%',
			 	ajax: {
			    url      : '<?php echo base_url("$moduleLink/checkJumlahRow") ?>',
			    dataType : 'json',
			    type     : 'POST',
			    delay    : 250,
			    data: function (params) {
				    return {
				        q : params.term
				    };
		    	},
			    processResults: function (json) {
				    return {
				       	results: json
				    };
			    },
			    cache: false,
			    initSelection: function(element, callback) {
	            	if (result) {
	            		return callback({id: result, text: result});
	            	}
	            }
			 	}
		});
		
		$('.form').validate({
		   ignore: [],
		   errorClass: 'error',
		   rules: {
			   jabatan : {required: true},
		   },
		   messages: {
			   jabatan : {required: "Nama pengurus tidak boleh kosong"},
		   }
	   });
	});
</script>