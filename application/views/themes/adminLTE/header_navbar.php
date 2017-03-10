<ul class="nav navbar-nav">
  <!-- User Account: style can be found in dropdown.less -->
  <li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <?php
      $user_image = base_url().'assets/themes/adminLTE/img/avatar.png';
      if ($this->session->userdata('level')>10) {
          if ($this->session->userdata('foto') != "") {
            $user_image = base_url().'assets/admin_foto/thumb/'.$this->session->userdata('foto');
          }
      }
      ?>
      <img src="<?php echo $user_image;?>" class="user-image" alt="User Image">
      <span class="hidden-xs"><?php echo $this->session->userdata('nama');?></span>
    </a>
    <ul class="dropdown-menu">
      <!-- User image -->
      <li class="user-header">
        <?php
        if ($this->session->userdata('level')>10) {
          if ($this->session->userdata('foto') != "") {
            echo '<img src="'.base_url().'assets/admin_foto/thumb/'.$this->session->userdata('foto').'" class="img-circle" alt="User Image">';
          }
          else {
            echo '<img src="'.base_url().'assets/themes/adminLTE/img/avatar.png" class="img-circle" alt="User Image">';
          }
        }
        else {
          echo '<img src="'.base_url().'assets/themes/adminLTE/img/avatar.png" class="img-circle" alt="User Image">';
        }
        ?>
        <p>
          <?php echo $this->session->userdata('nama');?>
        </p>
      </li>
      <!-- Menu Footer-->
      <li class="user-footer">
        <?php if ($this->session->userdata('level')>10) { ?>
          <div class="pull-left">
            <?php echo anchor('administrator/profil', 'Profil', 'class="btn btn-default btn-flat"');?>
          </div>
          <div class="pull-right">
            <?php echo anchor('login/logout', 'Keluar', 'class="btn btn-default btn-flat"');?>
          </div>
        <?php }
          else { ?>
          <div class="pull-right">
            <?php echo anchor('login/logout', 'Keluar', 'class="btn btn-default btn-flat"');?>
          </div>
        <?php } ?>
      </li>
    </ul>
  </li>
</ul>
