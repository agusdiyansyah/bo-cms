<div class="container">
	<div class="row">
		<nav class="navbar navbar-default navbar-custom">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="col-md-12">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li id="menu-beranda">
							<?php echo anchor('beranda', 'BERANDA');?>
						</li>
						<li id="menu-profil" class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">PROFIL <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<?php
								echo "<li>".anchor('profil/struktur-organisasi', 'STRUKTUR ORGANISASI')."</li>";
								echo "<li>".anchor('profil/visi-dan-misi', 'VISI MISI')."</li>";
								echo "<li>".anchor('profil/tupoksi', 'TUPOKSI')."</li>";
								?>
							</ul>
						</li>
						<?php echo "<li id='menu-unitkerja'>".anchor('unit-kerja', 'UNIT KERJA')."</li>";?>
						</li>
						<li id="menu-berita">
							<?php echo anchor('berita', 'BERITA');?>
						</li>
						<li id="menu-galeri">
							<?php echo anchor('galeri', 'GALERI');?>
						</li>
						<li id="menu-produk-hukum"><?php echo anchor('produk-hukum', 'PRODUK HUKUM');?></li>
						<li id="menu-informasi"><?php echo anchor('informasi', 'PERMOHONAN INFORMASI');?></li>
						<li id="menu-kontak-kami"><?php echo anchor('kontak-kami', 'KONTAK KAMI');?></li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
</div>