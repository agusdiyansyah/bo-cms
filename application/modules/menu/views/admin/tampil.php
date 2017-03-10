<ul class="sidebar-menu">
    <li class="header">MENU UTAMA</li>
    <li>
      <a href="#">
        <i class="fa fa-dashboard"></i> <span>Dashboard level : <?php echo $this->session->userdata('level');?></span>
      </a>
    </li>
    <?php
      if ($this->session->userdata('level') > 10) {
        if (count($menu)>0) {
          foreach ($menu as $m) {
            echo "<li>";
              $link_name = "<i class='".$m->icon."'></i><span>".$m->name."</span>";
              echo anchor($m->link, $link_name);
            echo "</li>";
          }
        }
      }
      else {
        echo "<li>";
          echo anchor('pegawai/detil/'.$this->session->userdata('userid'), '<i class="fa fa-user"></i> <span>Data Saya</span>');
        echo "</li>";
      }
    ?>
</ul>