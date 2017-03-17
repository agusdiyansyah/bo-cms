<?php if ($editor > 0): ?>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/themes/adminLTE/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/themes/adminLTE/css/font-awesome.css">
    <link href="<?php echo base_url(); ?>assets/themes/adminLTE/css/AdminLTE.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/adminLTE/css/skins/_all-skins.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/adminLTE/css/skins/custom-skin.css" rel="stylesheet">
    
    <script src="<?php echo base_url() ?>assets/themes/adminLTE/plugins/jQuery/jQuery-2.1.4.min.js" charset="utf-8"></script>
    <script src="<?php echo base_url();?>assets/themes/adminLTE/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/themes/adminLTE/js/app.min.js"></script>
<?php endif; ?>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/themes/adminLTE/css/file-manager.css">

<!-- select2 -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/themes/adminLTE/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/themes/adminLTE/plugins/select2/select2-bootstrap.css">
<script src="<?php echo base_url() ?>assets/themes/adminLTE/plugins/select2/select2.min.js" charset="utf-8"></script>

<!-- file input -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/themes/adminLTE/plugins/file-input/fileinput.min.css">
<script src="<?php echo base_url() ?>assets/themes/adminLTE/plugins/file-input/fileinput.min.js" charset="utf-8"></script>

<!-- magnific popup -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/themes/adminLTE/plugins/magnific-popup/magnific-popup.css">
<script src="<?php echo base_url() ?>assets/themes/adminLTE/plugins/magnific-popup/magnific-popup.js" charset="utf-8"></script>

<!-- validate -->
<script src="<?php echo base_url() ?>assets/themes/adminLTE/plugins/jquery-validation/jquery.validate.js" charset="utf-8"></script>
<script src="<?php echo base_url() ?>assets/themes/adminLTE/plugins/jquery-validation/localization/messages_id.js" charset="utf-8"></script>

<div class="hide">
    <input type="text" name="editor" class="editor" value="<?php echo $editor ?>">
    <input type="text" name="id_galeri" class="id_galeri" value="">
</div>

<div class="media-wrapper">
    <section class="action">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 col-sm-push-6">
                    <div class="action-btn-wrapper text-right">
                        <a href="#" class="btn btn-default btn-upload-image"><i class="fa fa-upload"></i> Upload</a>
                        <a href="#" class="btn btn-default btn-tambah-galeri"><i class="fa fa-bookmark"></i> Tambah Galeri</a>
                    </div>
                </div>
                <div class="col-sm-6 col-sm-pull-6">
                    <ol class="breadcrumb">
                        <li><a href="#" class="title">Media</a></li>
                        <li class="active hide subtitle"></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    
    <?php $this->load->view($content['view'], @$content['data']); ?>
    
</div>

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

<script type="text/javascript">
    $(document).ready(function() {
        $(".mn-ProfilTeam, .mn-Galeri").addClass('active');
        
        $(".btn-tambah-galeri").click(function() {
            tambahGaleri();
        });
        
        $(".btn-upload-image").click(function() {
            uploadImage();
        });
        
        $(".galeri-list").on('click', '.galeri-item .btn-edit', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            ubahGaleri(id);
        });
        
        $(".galeri-list").on('click', '.galeri-item .btn-hapus', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            hapusGaleri(id);
        });
        
        $(".image-list").on('click', '.image-item .btn-hapus', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            hapusImage(id);
        });
        
        $(".image-list").on('click', '.image-item .btn-ubah', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: '<?php echo base_url('media/image/getDataById') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id
                }, 
                success: function (json) {
                    if (json.stat) {
                        ubahImage(json.data);
                    }
                }
            });
        });
        
        $(".title").click(function(event) {
            event.preventDefault();
            $(".id_galeri").val("");
            $(".subtitle").addClass('hide').html('');
            $(".galeri-title").html("Uncategories");
            setGaleriList();
            setImageList();
        });
    });
    
    function uploadImage () {
        var modal = $("#modal");
        var formImage = "";
        
        formImage += "<form enctype='multipart/form-data' class='form-image' id='form-image'>";
        formImage += '    <label class="control-label"><b>Select File</b></label>';
        formImage += '    <input id="file" name="file" type="file" class="file-loading">';
        formImage += '    <div id="errorBlock" class="help-block"></div>';
        
        formImage += '    <div class="btn-group btn-group-justified" style="margin-bottom: 15px;">';
        formImage += '        <a href="#" class="btn btn-default fileinput-reset hide">Reset</a>';
        formImage += '        <a href="#" class="btn btn-primary fileinput-browse">Browse</a>';
        formImage += '    </div>';
        
        formImage += "    <div class='form-group'>";
        formImage += "        <label for='galeri'>Pilih Galeri</label>";
        formImage += "        <select name='galeri' id='galeri' class='galeri form-control'></select>";
        formImage += "    </div>";
        formImage += "    <div class='form-group'>";
        formImage += "        <label for='title'>Title Image</label>";
        formImage += "        <input type='text' class='title form-control' name='title' id='title' />";
        formImage += "        <small><p class='err-title text-danger'></p></small>";
        formImage += "    </div>";
        formImage += "    <div class='form-group'>";
        formImage += "        <label for='keterangan'>Keterangan</label>";
        formImage += "        <textarea name='keterangan' id='keterangan' class='form-control keterangan'></textarea>";
        formImage += "    </div>";
        formImage += "</form>";
        
        modal.find('.modal-title').html("UPLOAD IMAGE");
        modal.find('.modal-body').html(formImage);
        modal.find('.modal-confirm').html("Proses");
        
        $(".form-image").on('click', '.file-drop-zone', function(event) {
            event.preventDefault();
            $("#file").trigger('click');
        });
        
        $(".form-image").on('click', '.fileinput-browse', function(event) {
            event.preventDefault();
            $("#file").trigger('click');
        });
        
        $(".form-image").on('click', '.fileinput-reset', function(event) {
            event.preventDefault();
            $("#file").fileinput('clear');
        });
        
        $.ajax({
            url: '<?php echo base_url('media/getDataGaleri') ?>',
            type: 'POST',
            dataType: 'json',
            data: {id: ''},
            success: function (json) {
                if (json.stat) {
                    var opt = '<option value="0">Undefined</option>';
                    $.each(json.data, function(index, data) {
                        opt += '<option value="'+data.id_galeri+'">'+data.title+'</option>';
                    });
                    $(".form-image").find('.galeri').html(opt);
                    $(".form-image").find('.galeri').select2({width: '100%'});
                }
            }
        });
        
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
        };
        
        $("#file")
            .fileinput(fileInput)
            .on('fileimageloaded', function(event, previewId) {
                $(".form-image").find('.fileinput-reset').removeClass('hide');
            })
            .on('fileclear', function(event) {
                $(".form-image").find('.fileinput-reset').addClass('hide');
            });
        
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
            $(".form-image").submit();
        });
        
        $('.form-image').validate({
			ignore: [],
			errorClass : 'error',
	  		submitHandler  : function(form) {
                var title = $(".form-image").find('.title').val();
                var galeri = $(".form-image").find('.galeri').val();
                var formData = new FormData(document.getElementById("form-image"));
                
                if (title == '') {
                    $(".form-image").find('.err-title').html("Title image tidak boleh kosong");
                } else {
                    $.ajax({
            			url: "<?php echo base_url("media/image/tambahProses") ?>",
            			type: 'POST',
            			dataType: 'json',
            			mimeType: 'multipart/form-data',
                        data: formData,
            			contentType: false,
            	    	cache: false,
            			processData:false,
            			success:function(json){
                            if (json.stat) {
                                var conf = {
                                    tipe: 'success',
                                    title: 'Berhasil',
                                    msg: json.msg
                                };
                                $(".id_galeri").val(galeri);
                                setGaleriList();
                                setImageList();
                                $.magnificPopup.close();
                                modal.off();
                            } else {
                                var conf = {
                                    tipe: 'warning',
                                    title: 'Gagal',
                                    msg: json.msg
                                };
                                $.magnificPopup.close();
                                modal.off();
                            }
                            notification(conf);
                        }
                    });
                }
	  		}
		});
    }
    
    function ubahImage (data) {
        var modal = $("#modal");
        var formImage = "";
        
        formImage += "<form enctype='multipart/form-data' class='form-image' id='form-image'>";
        formImage += '    <input id="id" name="id" type="hidden" class="id" value="'+data.id_file+'">';
        
        formImage += '    <label class="control-label"><b>Select File</b></label>';
        formImage += '    <input id="file" name="file" type="file" class="file-loading">';
        formImage += '    <div id="errorBlock" class="help-block"></div>';
        
        formImage += '    <div class="btn-group btn-group-justified" style="margin-bottom: 15px;">';
        formImage += '        <a href="#" class="btn btn-default fileinput-reset hide">Reset</a>';
        formImage += '        <a href="#" class="btn btn-primary fileinput-browse">Browse</a>';
        formImage += '    </div>';
        
        formImage += "    <div class='form-group'>";
        formImage += "        <label for='galeri'>Pilih Galeri</label>";
        formImage += "        <select name='galeri' id='galeri' class='galeri form-control'></select>";
        formImage += "    </div>";
        formImage += "    <div class='form-group'>";
        formImage += "        <label for='title'>Title Image</label>";
        formImage += "        <input type='text' class='title form-control' name='title' id='title' value='"+data.title+"'/>";
        formImage += "        <small><p class='err-title text-danger'></p></small>";
        formImage += "    </div>";
        formImage += "    <div class='form-group'>";
        formImage += "        <label for='keterangan'>Keterangan</label>";
        formImage += "        <textarea name='keterangan' id='keterangan' class='form-control keterangan'>"+data.keterangan+"</textarea>";
        formImage += "    </div>";
        formImage += "</form>";
        
        modal.find('.modal-title').html("UPLOAD IMAGE");
        modal.find('.modal-body').html(formImage);
        modal.find('.modal-confirm').html("Proses");
        
        $(".form-image").on('click', '.file-drop-zone', function(event) {
            event.preventDefault();
            $("#file").trigger('click');
        });
        
        $(".form-image").on('click', '.fileinput-browse', function(event) {
            event.preventDefault();
            $("#file").trigger('click');
        });
        
        $(".form-image").on('click', '.fileinput-reset', function(event) {
            event.preventDefault();
            $("#file").fileinput('clear');
        });
        
        $.ajax({
            url: '<?php echo base_url('media/getDataGaleri') ?>',
            type: 'POST',
            dataType: 'json',
            data: {id: ''},
            success: function (json) {
                if (json.stat) {
                    var opt = '<option value="0">Undefined</option>';
                    $.each(json.data, function(index, data) {
                        opt += '<option value="'+data.id_galeri+'">'+data.title+'</option>';
                    });
                    $(".form-image").find('.galeri').html(opt);
                    $(".form-image").find('.galeri').select2({width: '100%'});
                    
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
                    };
                    
                    if (data.file != '') {
                        var link = '<?php echo base_url('assets/upload/images') ?>/' + data.file;
                        
                        $(".form-image").find('.fileinput-reset').removeClass('hide');
                        
                        var image = {
                            initialPreview: [
                                "<img src='"+ link +"' class='file-preview-image' style='width: 100%; height: auto' alt='"+ data.title +"' title='"+ data.title +"'>",
                            ]
                        };
                        
                        $.extend(fileInput, image);
                    }
                    
                    $("#file")
                        .fileinput(fileInput)
                        .on('fileimageloaded', function(event, previewId) {
                            $(".form-image").find('.fileinput-reset').removeClass('hide');
                        })
                        .on('fileclear', function(event) {
                            $(".form-image").find('.fileinput-reset').addClass('hide');
                        });
                        
                    $(".form-image").find('.galeri').select2('val', data.id_galeri);
                    // $(".form-image").find('.title').val(json.data.title);
                    // $(".form-image").find('.keterangan').html(json.data.keterangan);
                }
            }
        });
        
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
            $(".form-image").submit();
        });
        
        $('.form-image').validate({
			ignore: [],
			errorClass : 'error',
	  		submitHandler  : function(form) {
                var title = $(".form-image").find('.title').val();
                var galeri = $(".form-image").find('.galeri').val();
                var formData = new FormData(document.getElementById("form-image"));
                
                if (title == '') {
                    $(".form-image").find('.err-title').html("Title image tidak boleh kosong");
                } else {
                    $.ajax({
            			url: "<?php echo base_url("media/image/ubahProses") ?>",
            			type: 'POST',
            			dataType: 'json',
            			mimeType: 'multipart/form-data',
                        data: formData,
            			contentType: false,
            	    	cache: false,
            			processData:false,
            			success:function(json){
                            if (json.stat) {
                                var conf = {
                                    tipe: 'success',
                                    title: 'Berhasil',
                                    msg: json.msg
                                };
                                galeri = (galeri == 0) ? '' : galeri;
                                $(".id_galeri").val(galeri);
                                setGaleriList();
                                setImageList();
                                $.magnificPopup.close();
                                modal.off();
                            } else {
                                var conf = {
                                    tipe: 'warning',
                                    title: 'Gagal',
                                    msg: json.msg
                                };
                                $.magnificPopup.close();
                                modal.off();
                            }
                            notification(conf);
                        }
                    });
                }
	  		}
		});
    }
    
    function hapusImage (id) {
        var modal = $("#modal");
        modal.find('.modal-title').html("HAPUS IMAGE");
        modal.find('.modal-body').html("<div class='text-danger'>Anda yakin akan menghapus data ini</div>");
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
                url: '<?php echo base_url("media/image/hapus") ?>',
                cache: false,
                type: 'POST',
                dataType: 'json',
                data: {id: id},
                success: function (json) {
                    if (json.stat) {
                        $.magnificPopup.close();
                        modal.off();
                        var notif = {
                            tipe: 'success',
                            title: 'Success',
                            msg: json.msg
                        };
                        setTimeout(function () { setImageList(); }, 2500);
                    } else {
                        var notif = {
                            tipe: 'warning',
                            title: 'Gagal',
                            msg: json.msg
                        };
                    }
                    notification(notif);
                }
            });
        });
    }
    
    function tambahGaleri () {
        var modal = $("#modal");
        var formGaleri = "";
        
        formGaleri += "<form class='form-galeri'>";
        formGaleri += "    <div class='form-group'>";
        formGaleri += "        <label for='title'>Nama Galeri</label>";
        formGaleri += "        <input type='text' class='form-control title' id='title' name='title'/>";
        formGaleri += "        <small><p class='err-title text-danger'></p></small>";
        formGaleri += "    </div>";
        formGaleri += "    <div class='form-group'>";
        formGaleri += "        <label for='status'>Status</label>";
        formGaleri += "        <div>";
        formGaleri += "            <label class='radio-inline'>";
        formGaleri += "                <input type='radio' name='publish' id='rd-publish' value='1' checked> PUBLISH";
        formGaleri += "            </label>";
        formGaleri += "            <label class='radio-inline'>";
        formGaleri += "                <input type='radio' name='publish' id='rd-un-publish' value='0'> UN-PUBLISH";
        formGaleri += "            </label>";
        formGaleri += "        </div>";
        formGaleri += "    </div>";
        formGaleri += "    <div class='form-group'>";
        formGaleri += "        <label for='keterangan'>Keterangan</label>";
        formGaleri += "        <textarea name='keterangan' id='keterangan' class='form-control keterangan'></textarea>";
        formGaleri += "    </div>";
        formGaleri += "</form>";
        
        modal.find('.modal-title').html("TAMBAH GALERI");
        modal.find('.modal-body').html(formGaleri);
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
            $(".form-galeri").submit();
        });
        
        $('.form-galeri').validate({
			ignore: [],
			errorClass : 'error',
	  		submitHandler  : function(form) {
                var title = $(".form-galeri").find('.title').val();
                if (title == '') {
                    $(".form-galeri").find('.err-title').html("Nama galeri tidak boleh kosong");
                } else {
                    $.ajax({
                        url: '<?php echo base_url("media/galeri/tambahProses") ?>',
                        cache: false,
                        type: 'POST',
                        dataType: 'json',
                        data: $(".form-galeri").serialize(),
                        success: function (json) {
                            if (json.stat) {
                                $.magnificPopup.close();
                                modal.off();
                                var notif = {
                                    tipe: 'success',
                                    title: 'Success',
                                    msg: json.msg
                                };
                                setGaleriList();
                            } else {
                                var notif = {
                                    tipe: 'warning',
                                    title: 'Gagal',
                                    msg: json.msg
                                };
                            }
                            notification(notif);
                        }
                    });
                }    
	  		}
		});
    }
    
    function ubahGaleri (id) {
        $.ajax({
            url: '<?php echo base_url("media/galeri/getDataById") ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id
            },
            success: function (json) {
                if (json.stat) {
                    var modal = $("#modal");
                    var formGaleri = "";
                    var publish = '', unPublish = '';
                    
                    if (json.data.status == 1) {
                        publish = 'checked';
                    }
                    
                    if (json.data.status == 0) {
                        unPublish = 'checked';
                    }
                    
                    formGaleri += "<form class='form-galeri'>";
                    formGaleri += "    <input type='hidden' name='id' value='"+id+"' />";
                    formGaleri += "    <div class='form-group'>";
                    formGaleri += "        <label for='title'>Nama Galeri</label>";
                    formGaleri += "        <input type='text' class='form-control title' id='title' name='title' value='"+json.data.title+"'/>";
                    formGaleri += "        <small><p class='err-title text-danger'></p></small>";
                    formGaleri += "    </div>";
                    formGaleri += "    <div class='form-group'>";
                    formGaleri += "        <label for='status'>Status</label>";
                    formGaleri += "        <div>";
                    formGaleri += "            <label class='radio-inline'>";
                    formGaleri += "                <input type='radio' name='publish' id='rd-publish' value='1' "+publish+"> PUBLISH";
                    formGaleri += "            </label>";
                    formGaleri += "            <label class='radio-inline'>";
                    formGaleri += "                <input type='radio' name='publish' id='rd-un-publish' value='0' "+unPublish+"> UN-PUBLISH";
                    formGaleri += "            </label>";
                    formGaleri += "        </div>";
                    formGaleri += "    </div>";
                    formGaleri += "    <div class='form-group'>";
                    formGaleri += "        <label for='keterangan'>Keterangan</label>";
                    formGaleri += "        <textarea name='keterangan' id='keterangan' class='form-control keterangan'>"+json.data.keterangan+"</textarea>";
                    formGaleri += "    </div>";
                    formGaleri += "</form>";
                    
                    modal.find('.modal-title').html("TAMBAH GALERI");
                    modal.find('.modal-body').html(formGaleri);
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
                        
                        var title = $(".form-galeri").find('.title').val();
                        if (title == '') {
                            $(".form-galeri").find('.err-title').html("Nama galeri tidak boleh kosong");
                        } else {
                            $.ajax({
                                url: '<?php echo base_url("media/galeri/ubahProses") ?>',
                                cache: false,
                                type: 'POST',
                                dataType: 'json',
                                data: $(".form-galeri").serialize(),
                                success: function (json) {
                                    if (json.stat) {
                                        $.magnificPopup.close();
                                        modal.off();
                                        var notif = {
                                            tipe: 'success',
                                            title: 'Success',
                                            msg: json.msg
                                        };
                                        setGaleriList();
                                    } else {
                                        var notif = {
                                            tipe: 'warning',
                                            title: 'Gagal',
                                            msg: json.msg
                                        };
                                    }
                                    notification(notif);
                                }
                            });
                        }
                    });
                } else {
                    var notif = {
                        tipe: 'warning',
                        title: 'Gagal',
                        msg: 'Data tidak di temukan'
                    };
                    notification(notif);
                }
            }
        });
    }
    
    function hapusGaleri (id) {
        var modal = $("#modal");
        modal.find('.modal-title').html("HAPUS GALERI");
        modal.find('.modal-body').html("<div class='text-danger'>Anda yakin akan menghapus data ini</div>");
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
                url: '<?php echo base_url("media/galeri/hapus") ?>',
                cache: false,
                type: 'POST',
                dataType: 'json',
                data: {id: id},
                success: function (json) {
                    if (json.stat) {
                        $.magnificPopup.close();
                        modal.off();
                        var notif = {
                            tipe: 'success',
                            title: 'Success',
                            msg: json.msg
                        };
                        setGaleriList();
                    } else {
                        var notif = {
                            tipe: 'warning',
                            title: 'Gagal',
                            msg: json.msg
                        };
                    }
                    notification(notif);
                }
            });
        });
    }
    
    function checkEditor () {
        var editor = $('.editor').val();
        if (editor == 0) {
            var image = $(".image-list").find(".image-item");
            image.find('.btn-gunakan').addClass('hide');
        }
    }
    
    function ratio (width) {
        return (600/800)*width;
    }
    
    function notification (data) {
        var content = $(".action");
        var html    = "";
        
        html += '<div class="alert alert-' + data.tipe + ' alert-dismissable js-notif" style="border-radius: 0px;">';
        html += '    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
        html += '    <h4><i class="icon fa fa-check"></i> ' + data.title + '</h4>';
        html += '    ' + data.msg;
        html += '</div>';
        
        var notif = $(".media-wrapper").find('.js-notif');
        if (!notif.hasClass('alert')) {
            content.after(html);
        }
        
        setTimeout(function(){ 
            notif.remove();
        }, 2500);
    }
</script>