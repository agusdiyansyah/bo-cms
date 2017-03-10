<?php echo $this->session->flashdata('message');?>
<section class="content-header">
    <h1><?php echo $title.' <small>'.$subtitle.'</small>';?></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <?php echo form_open_multipart($action, 'class="form"');?>
                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>" />
                        <div class="form-group">
                            <label for="textinput">Level</label>
                                <?php echo $level;?>
                        </div>
                        <div class="form-group">
                            <label for="textinput">Username</label>
                            <input type="text" class="form-control input-lg" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>" />
                            <span class="help-block"><?php echo form_error('username');?></span>
                        </div>
                        <div class="form-group">
                            <label for="textinput">Password</label>
                            <input type="password" class="form-control input-lg" name="password" id="password" />
                            <span class="help-block"><?php echo form_error('password');?></span>
                            <?php
                                if ($mode == "edit") {
                                    echo '<div class="alert alert-info">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <strong>Perubahan Password</strong> Kosongkan jika password tidak diganti
                                    </div>';
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="textinput">Nama</label>
                            <input type="text" class="form-control input-lg" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
                            <span class="help-block"><?php echo form_error('nama');?></span>
                        </div>
                        <div class="form-group">
                            <label for="textinput">Email</label>
                            <input type="email" class="form-control input-lg" name="email" id="email" placeholder="email" value="<?php echo $email; ?>" />
                            <span class="help-block"><?php echo form_error('email');?></span>
                        </div>
                        <div class="form-group">
                            <label for="textinput">Status</label>
                            <?php echo $status;?>
                        </div>
                        <div class="form-group">
                            <label for="textinput">Foto</label>
                                <input type="file" class="form-control" name="foto" id="foto" />
                                <span class="help-block">Hanya tipe file .jpg, .png, .jpeg, .gif yang bisa di upload dan maksimal 2mb <?php echo form_error('foto');?></span>
                                <?php
                                    if ($foto) {
                                        echo '<img src="'.base_url().'assets/admin_foto/thumb/'.$foto.'" class="img-responsive img-thumbnail"/>';
                                    }
                                ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><?php echo $button;?></button>
                            <a href="<?php echo site_url('administrator/profil') ?>" class="btn btn-default">Cancel</a>
                        </div>
                        
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</section>