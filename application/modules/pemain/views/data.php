<div class="msg">
	<?php echo $this->session->flashdata('message');?>
</div>
<section class="content-header">
	<h1><?php echo @$title;?> <small><?php echo @$subtitle ?></small></h1>
</section>
<section class="content-header aksi">
	<?php echo anchor(@$link_add, 'Tambah Pemain');?>
</section>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
		    <div class="row">
				<?php foreach ($pemain as $data): ?>
					<?php 
					$photo = empty($data->photo) ? "assets/themes/adminLTE/img/boxed-bg.png" : "{$ImageUploadPath}thumb/$data->photo"
					?>
					<div class="col-sm-4 col-md-3 col-lg-2 data-pemain-<?php echo $data->id_pemain ?>" style="margin-bottom: 15px">
						<div class="pengurus-wrapper">
			        		<div class="photo" style="background-image: url('<?php echo base_url("$photo") ?>')"></div>
							<div class="info">
								<p class="name">
									<?php echo $data->nama ?>
								</p>
								<p>
									<?php echo $getPosisiName[$data->posisi] ?>
								</p>
							</div>
							<div class="aksi">
								<div class="btn-group btn-group-justified">
									<a href="<?php echo base_url("pemain/edit/$data->id_pemain") ?>" class="btn btn-default btn-ubah">Ubah</a>
									<a href="#" class="btn btn-default btn-hapus" data-id="<?php echo $data->id_pemain ?>">Hapus</a>
								</div>
							</div>
			        	</div>
			        </div>
				<?php endforeach; ?>
		    </div>
		</div>
	</div>
</section>

<div id="modal" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Default Modal</h4>
			</div>
			<div class="modal-body">
				<p>One fine body…</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left modal-dismiss" data-dismiss="modal">Kembali</button>
				<button type="button" class="btn btn-primary modal-confirm">Save changes</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		var base_url = "<?php echo base_url();?>";
		
		var width = $(".photo").width();
		$(".photo").css('height', ratio(width));

        $('.mn-Pemain').addClass('active');
		
		$(".pengurus-wrapper").on('click', '.btn-hapus', function(event) {
			event.preventDefault();
			var id = $(this).data("id");
			hapus(id);
		});

	});
	
	function hapus (id = 0) {
	    if (id > 0) {
	        var modal = $("#modal");

	        modal.find('.modal-title').html("HAPUS DATA");
	        modal.find('.modal-body').html("Apakah anda yakin akan menghapus data ini");
	        modal.find('.modal-confirm').html("Hapus data");

	        $.magnificPopup.open({
	            items: {
			    	src             : '#modal',
			    	type            : 'inline',
					fixedContentPos : false,
					fixedBgPos      : true,
					overflowY       : 'auto',
					closeBtnInside  : true,
					preloader       : false,
					midClick        : true,
					removalDelay    : 300,
					mainClass       : 'my-mfp-slide-bottom',
					modal           : true
			  	}
	        });

	        modal.on('click', '.modal-dismiss', function(event) {
	            event.preventDefault();
	            $.magnificPopup.close();
	            modal.off();
	        });

	        modal.on('click', '.modal-confirm', function(event) {
	            event.preventDefault();
	            $.magnificPopup.close();
	            modal.off();

	            $.ajax({
	                url: '<?php echo base_url("$moduleLink/delete_proses") ?>',
					cache: false,
	                type: 'POST',
					dataType: "json",
	                data: {
	                    id: id
	                },
	                success: function (json) {
						if (json.stat) {
							conf = {
								tipe: "success",
								title: "Berhasil",
								msg: "Data berhasil di proses",
							}
							$(".data-pemain-" + id).remove();
						} else {
							conf = {
								tipe: "warning",
								title: "Gagal",
								msg: "Data gagal di proses",
							}
						}
						
						notification(conf);
	                }
	            });
	        });
	    }
	}
	
	function ratio (width) {
        return (1)*width;
    }
	
	function notification (data) {
        var content = $(".msg");
        var html    = "";
        
        html += '<div class="alert alert-' + data.tipe + ' alert-dismissable js-notif" style="border-radius: 0px;">';
        html += '    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
        html += '    <h4><i class="icon fa fa-check"></i> ' + data.title + '</h4>';
        html += '    ' + data.msg;
        html += '</div>';
        var timeout = 2500;
        if ($(".msg").find('.js-notif').hasClass('alert')) {
            $(".msg").find('.js-notif').remove();
            timeout = 0;
        }
        content.html(html);
        setTimeout(function(){ 
            $(".msg").find('.js-notif').remove();
        }, timeout);
    }
</script>
