<section class="content-header">
	<h1><?php echo @$title;?> <small><?php echo @$subtitle ?></small></h1>
</section>
<section class="content-header aksi">
	<?php echo anchor(@$link_back, 'Kembali');?>
</section>

<section class="content">
    <form class="form" action="<?php echo $form_action ?>" method="post" enctype="multipart/form-data">
        <?php echo form_input($input['hide_id']) ?>
        
        <div class="row">
            <div class="col-xs-12">
                <label for="level" class="control-label">Level</label>
                <?php echo form_select($input['level']) ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-6">
                <label for="username" class="control-label">Username</label>
                <?php echo form_input($input['username']) ?>
            </div>
            <div class="col-sm-6">
                <label for="password" class="control-label">Password</label>
                <?php echo form_password($input['password']) ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-6">
                <label for="nama" class="control-label">Nama Lengkap</label>
                <?php echo form_input($input['nama']) ?>
            </div>
            <div class="col-sm-6">
                <label for="email" class="control-label">Email</label>
                <?php echo form_input($input['email']) ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12">
                <label for="status" class="control-label">Status</label>
                <?php echo form_select($input['status']) ?>
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
        $('.mn-Setting, .mn-Administrator').addClass('active');
        $(".select2").select2({width: '100%'});
        
        $('.form').validate({
		   ignore: [],
		   errorClass: 'error',
		   rules: {
               username : {required: true},
               password : {
                   required: passwordCallback,
               },
               level : {required: true},
               nama : {required: true},
			   status : {required: true},
		   },
		   messages: {
               username : {required: "Username tidak boleh kosong"},
               password : {required: "Password tidak boleh kosong"},
               level : {required: "Level tidak boleh kosong"},
               nama : {required: "Nama lengkap tidak boleh kosong"},
			   status : {required: "Status tidak boleh kosong"},
		   }
	   });
    });
    
    var passwordCallback = function () {
        var id = $(".hide_id").val();
        if (id != '') {
            return false;
        } else {
            return true;
        }
    }
</script>