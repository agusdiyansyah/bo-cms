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
		?>
		<input type="hidden" name="submodule" value="<?php echo @$submodule ?>">
		
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
							<label class="control-label">Bermain Sebagai</label>
						</div>
						<div class="">
							<a href="#" class="btn btn-default ha home" data-value="home">Tuan Rumah</a>
							<a href="#" class="btn btn-default ha away" data-value="away">Lawan</a>
						</div>
						<?php echo form_input($input['hide']['match_homeaway']); ?>
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
		$('.mn-Pertandingan, .mn-Pertandingan .mn-Jadwal').addClass('active');
		
		setHomeAway();
		
		$(".match_rival").easyAutocomplete({
			url: function(phrase) {
				return "<?php echo base_url("$moduleLink/srcRival") ?>";
			},

			getValue: function(element) {
				return element.name;
			},

			ajaxSettings: {
				dataType: "json",
				method: "POST",
				data: {
					dataType: "json"
				}
			},

			preparePostData: function(data) {
				data.phrase = $(".match_rival").val();
				return data;
			},

			// getValue: "name",
		});
		
		$(".ha").click(function(e) {
			e.preventDefault();
			
			$(".ha.btn-primary").removeClass("btn-primary").addClass("btn-default");
    		$(this).removeClass("btn-default").addClass("btn-primary");
			
			var data = $(this).data("value");
			
			$(".match_homeaway").val(data);
		});
		
		$('.match_date').bootstrapMaterialDatePicker({
            format : 'YYYY-MM-DD HH:mm',
            lang : 'en',
            weekStart : 0,
            time: true,
            cancelText : 'Kembali'
        });
		
		$('.form').validate({
		   	ignore: [],
			errorClass: 'error',
		 	rules: {
				match_rival : {required: true},
				match_date : {required: true},
				match_homeaway : {required: true},
			},
			messages: {
				match_rival : {required: "Rival tidak boleh kosong"} ,
				match_date : {required: "Tanggal main tidak boleh kosong"},
				match_homeaway : {required: "Bermain sebagai harus di pilih"},
			},
	   	});
	});
	
	function setHomeAway () {
		var data = $(".match_homeaway").val();
		switch (data) {
			case "home":
				$(".ha.home").removeClass('btn-default').addClass('btn-primary');
			break;
			case "away":
				$(".ha.away").removeClass('btn-default').addClass('btn-primary');
			break;
			default:
				
		}
	}
</script>