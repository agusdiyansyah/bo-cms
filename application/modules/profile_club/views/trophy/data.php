<div class="msg">
	<?php echo $this->session->flashdata('message');?>
</div>
<section class="content-header">
	<h1><?php echo @$title;?> <small><?php echo @$subtitle ?></small></h1>
</section>
<section class="content-header aksi">
	<?php echo anchor(@$link_add, 'Tambah Data');?>
</section>

<section class="pencarian">
	<div class="row">
		<div class="col-xs-12">
			<div class="box-group" id="accordion">
		    	<div class="panel">
					<div class="box-header with-border collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false">
			        	<h4 class="box-title pull-right">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">
			            	Pencarian Rinci
			          		</a>
			        	</h4>
			      	</div>
					<div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 1px;">
						<form class="filter">

				        	<div class="box-body">
								<!-- form field -->
								<div class="row">
									<div class="col-sm-6">
										<label for="nama_trophy" class="control-label">Nama Trophy</label>
										<?php echo form_input($input['nama_trophy']) ?>
									</div>
									
									<div class="col-sm-6">
										<label for="tahun" class="control-label">Tahun</label>
										<?php echo form_input($input['tahun']) ?>
									</div>
								</div>
							</div>
                            
							<div class="box-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<a href="#" class="btn btn-default btn-reset">Reset Pencarian</a>
										<button type="button" class="btn btn-primary btn-cari" id="submit">Cari</button>
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

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="2%">No</th>
                            <th width="2%">Aksi</th>
							<th>Nama Trophy</th>
                            <th>Tahun</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<div id="modal" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
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

        $('.mn-ProfilTeam, .mn-ProfilTeam .mn-Trophy').addClass('active');
		
		$(".filter").on('click', '.btn-cari', function(event) {
			event.preventDefault();
			$(".filter").submit();
		});
		
		$(".tahun").datepicker({
			format: "yyyy",
			minViewMode: "years",
			autoclose: true
		});

	    // DataTable
        $('.table').DataTable({
            'dom': "<'row'<'col-xs-12 data-info'lf<'pull-right'>>><'row'<'col-xs-12'<'table-responsive't>>><'row'<'col-xs-12'<'pull-left'i><'pull-right'p>>>",
            "processing": true,
            "serverSide": true,
            "bFilter" : false,
            "bLengthChange": false,
            'ordering'    : false,
            "ajax": {
                "url": "<?php echo base_url("$moduleLink/data");?>",
                "type": "POST",
                "data": function ( d ) {
					d.nama_pengurus = $(".filter").find('.nama_pengurus').val();
                }, 
				"beforeSend": function () {
					Pace.restart();
				}
            },
            "displayLength": 50,
            // "order": [[ 5, "desc" ]]
        });

        $(".filter").submit(function(event) {
	    	event.preventDefault();
	    	refreshTable();
	    });

        $(".btn-reset").click(function(e) {
            $('input').val('');

	    	refreshTable();
	    });
		
		$(".table").on('click', '#btn-hapus', function() {
	        var id = $(this).data('id');
	        hapus(id);
	    });

	});
    
    function refreshTable () {
        var dtable = $(".table").DataTable();
        dtable.draw();
    }
	
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
							refreshTable();
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
