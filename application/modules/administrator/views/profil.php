<?php echo $this->session->flashdata('message');?>
<section class="content-header">
    <h1><?php echo $nama;?></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table class="table">
                        <tr>
                            <td width="200px">Nama</td>
                            <td><?php echo $nama;?></td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td><?php echo $username;?></td>
                        </tr>
                        <tr>
                            <td>Level</td>
                            <td><?php echo $level;?></td>
                        </tr>
                        <tr>
                            <td>email</td>
                            <td><?php echo $email;?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><?php echo $status;?></td>
                        </tr>
                        <tr>
                            <td>Foto</td>
                            <td>
                                <?php
                                if ($foto) {
                                    echo '<img src="'.base_url("assets/admin_foto/thumb").'/'.$foto.'" class="img img-thumbnail" />';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan><?php echo anchor('administrator/profil/edit', 'Edit', 'class="btn btn-primary"');?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>