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
									<div class="col-xs-12">
										<label for="match_rival" class="control-label">Rival</label>
										<?php echo form_input($input['match_rival']) ?>
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
							<th>Rival</th>
							<th>Tanggal Main</th>
                            <th>Tempat Tanding</th>
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

        $('.mn-Pertandingan, .mn-Pertandingan .mn-Jadwal').addClass('active');
		
		$(".filter").on('click', '.btn-cari', function(event) {
			event.preventDefault();
			$(".filter").submit();
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
					d.match_rival = $(".filter").find('.match_rival').val();
                }, 
				"beforeSend": function () {
					Pace.restart();
				}
            },
            "displayLength": 50,
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
		
		$(".table").on('click', '#btn-selesai', function() {
	        var data = {
				id: $(this).data("id"),
				rival: $(this).parents("tr").find("td").eq(2).html(),
				tanggal_main: $(this).parents("tr").find("td").eq(3).html(),
				tempat_main: $(this).parents("tr").find("td").eq(4).html(),
			}
			
	        selesai(data);
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
	                data: {
	                    id: id
	                },
	                success: function () {
						refreshTable();
	                }
	            });
	        });
	    }
	}
	
	function selesai (data) {
	    if (data.id > 0) {
	        var modal = $("#modal");
			var form  = "";
			
			form += '<form class="form-modal">';
			form += '    <input type="hidden" name="id" value="'+ data.id +'">';
			form += '    <div class="row">';
			form += '        <div class="col-sm-6">';
			form += '            <label for="match_resultscore1" class="control-label">Skor Tim Anda</label>';
			form += '            <input type="number" name="match_resultscore1" class="form-control match_resultscore1" value="0" min="0" required autofocus>';
			form += '        </div>';
			form += '        <div class="col-sm-6">';
			form += '            <label for="match_resultscore2" class="control-label">'+ data.rival +'</label>';
			form += '            <input type="number" name="match_resultscore2" class="form-control match_resultscore2" value="0" min="0" required>';
			form += '        </div>';
			form += '    </div>';
			form += '	 <div className="row">'
			form += '	 	<br />'
			form += '	 	<div className="col-xs-12">'
			form += '	 		<table class="table table-striped table-hover">'
			form += '	 			<tr>'
			form += '	 				<td>Tanggal dan Jam</td>'
			form += '	 				<td>'+ data.tanggal_main +'</td>'
			form += '	 			</tr>'
			form += '	 			<tr>'
			form += '	 				<td>Tempat</td>'
			form += '	 				<td>'+ data.tempat_main +'</td>'
			form += '	 			</tr>'
			form += '	 		</table>'
			form += '	 	</div>'
			form += '	 </div>'
			form += '</form>';
			
	        modal.find('.modal-title').html("HASIL PERTANDINGAN");
	        modal.find('.modal-body').html(form);
	        modal.find('.modal-confirm').html("Proses");

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

	            $.ajax({
	                url: '<?php echo base_url("$moduleLink/selesai") ?>',
					cache: false,
	                type: 'POST',
					dataType: 'json',
	                data: $(".form-modal").serialize(),
	                success: function (json) {
						if (json.stat) {
							$(".form-modal").remove();
							refreshTable();
							
							var conf = {
								tipe: "success",
								title: "Berhasil",
								msg: "Data berhasil di proses"
							};
						} else {
							var conf = {
								tipe: "warning",
								title: "Gagal",
								msg: "Data gagal di proses"
							};
						}
						notification(conf);
	                }
	            });
				
				$.magnificPopup.close();
	            modal.off();
	        });
	    }
	}
	
	function notification (data) {
        var content = $(".msg");
        var notif    = "";
        
        notif += '<div class="alert alert-' + data.tipe + ' alert-dismissable js-notif" style="border-radius: 0px;">';
        notif += '    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
        notif += '    <h4><i class="icon fa fa-check"></i> ' + data.title + '</h4>';
        notif += '    ' + data.msg;
        notif += '</div>';
		
        var timeout = 2500;
        
        content.html(notif)
        
        setTimeout(function(){ 
            content.html("");
        }, timeout);
    }

</script>
