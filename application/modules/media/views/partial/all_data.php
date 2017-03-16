<section class="file">
    <div class="container-fluid galeri-wrapper">
        <div class="row">
            <div class="col-xs-12">
                <h4><i class="fa fa-folder-open-o"></i> Galeri</h4>
                <div class="galeri-content">
                    <div class="row galeri-list"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <h4><i class="fa fa-image"></i> <span class="galeri-title">Uncategories</span></h4>
                <div class="file-content">
                    <div class="row image-list"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        setGaleriList();
        setImageList();
        
        $(".galeri-wrapper").on('click', '.galeri-item > .icon, .galeri-item > .title', function() {
            var id = $(this).parents('.galeri-item').data('id');
            var title = $(this).parents('.galeri-item').data('title');
            $(".subtitle").removeClass('hide').html(title);
            $(".galeri-title").html(title);
            $(".id_galeri").val(id);
            setGaleriList();
            setImageList();
        });
    });
    
    function setGaleriList () {
        var id = $(".id_galeri").val();
        $.ajax({
            url: '<?php echo base_url() ?>media/getDataGaleri',
            type: 'POST',
            dataType: 'json',
            data: {id: id},
            success: function (json) {
                if (json.stat) {
                    var html = "";
                    $.each(json.data, function(index, val) {
                        var data = {
                            title: val.title,
                            id_galeri: val.id_galeri,
                            status: (val.status == 0) ? 'unpublish' : '',
                        };
                        html += htmlGaleri(data);
                    });
                    $(".galeri-list").html(html);
                } else {
                    var conf = {
                        tipe: 'warning',
                        title: 'Not Found',
                        msg: 'Tidak terdapat data galeri, harap menginputkan data galeri terlebih dahulu'
                    };
                    notification(conf);
                    $(".galeri-list").html("");
                }
            }
        });
        
    }
    
    function setImageList () {
        var id_galeri = $(".id_galeri").val();
        $.ajax({
            url: '<?php echo base_url('media/getDataImage') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id_galeri
            },
            success: function (json) {
                if (json.stat) {
                    var html = "";
                    $.each(json.data, function(index, val) {
                        var data = {
                            id_file: val.id_file,
                            title: val.title,
                            file: val.file
                        };
                        html += htmlImage(data);
                    });
                    $(".image-list").html(html);
                    
                    var image = $(".image-list").find(".image-item .image");
                    var imageWidth = image.width();
                    var imageHeight = ratio(imageWidth);
                    image.css('height', imageHeight);
                    
                    checkEditor();
                } else {
                    if (id_galeri != '') {
                        var conf = {
                            tipe: 'warning',
                            title: 'Not Found',
                            msg: 'Data image tidak di temukan'
                        };
                        notification(conf);
                    }
                    $(".image-list").html("");
                }
            }
        });
        
    }
    
    function htmlImage (data) {
        var image = '';
        var url = "<?php echo base_url('assets/upload/images/thumb') ?>/";
        
        image += '<div class="col-md-3 col-sm-4 col-lg-2">';
        image += '    <div class="image-item">';
        image += '        <div class="icon image" style="background-image: url(\''+url+data.file+'\')"></div>';
        image += '        <div class="title">';
        image += '            ' + data.title;
        image += '        </div>';
        image += '        <div class="aksi text-right">';
        image += '            <div class="btn-group">';
        image += '                <a href="#" class="btn btn-default btn-gunakan">Gunakan</a>';
        image += '                <a href="#" class="btn btn-default btn-ubah" data-id="'+data.id_file+'"><i class="fa fa-edit"></i></a>';
        image += '                <a href="#" class="btn btn-default btn-hapus" data-id="'+data.id_file+'"><i class="fa fa-trash"></i></a>';
        image += '            </div>';
        image += '        </div>';
        image += '    </div>';
        image += '</div>';
        
        return image;
    }
    
    function htmlGaleri (data) {
        var galeri = '';
        
        galeri += '<div class="col-md-3 col-sm-4 col-lg-2">';
        galeri += '    <div class="galeri-item '+data.status+'" data-id="'+data.id_galeri+'" data-title="'+data.title+'">';
        galeri += '        <div class="icon" style="background-image: url(\'<?php echo base_url() ?>assets/themes/adminLTE/img/002-folder.svg\')"></div>';
        galeri += '        <div class="title">';
        galeri += '            ' + data.title;
        galeri += '        </div>';
        galeri += '        <div class="aksi text-right">';
        galeri += '            <div class="btn-group">';
        galeri += '                <a href="#" class="btn btn-default btn-edit" data-id="'+data.id_galeri+'"><i class="fa fa-edit"></i></a>';
        galeri += '                <a href="#" class="btn btn-default btn-hapus" data-id="'+data.id_galeri+'"><i class="fa fa-trash"></i></a>';
        galeri += '            </div>';
        galeri += '        </div>';
        galeri += '    </div>';
        galeri += '</div>';
        
        return galeri;
    }
</script>