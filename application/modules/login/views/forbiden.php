<?php echo $this->session->flashdata('message');?>
<section class="content-header">
  <h1>
    <?php echo $title;?>
    <small><?php echo $subtitle;?></small>
  </h1>
</section>

<section class="content">
    <div class="row">
    	<div class="col-md-12">
    		<div class="box box-primary">
				<div class="box-header with-border">
    				<h3 class="box-title"><?php echo $subtitle;?> </h3>
    			</div>
    			<div class="box-body">
    				<div class="row">
    					<div class="col-md-12">
    						<span>Anda tidak berhak mengakses halaman ini !!!</span>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</section>