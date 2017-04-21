<?php echo $slideshow; ?>
<div class="tm-top-b-box tm-full-width  ">
    <div class="uk-container uk-container-center">
        <section id="tm-top-b" class="tm-top-b uk-grid" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">

            <div class="uk-width-1-1">
                <div class="uk-panel">
					<?php if ($ls_status): ?>
						<div class="va-latest-wrap">
						    <div class="uk-container uk-container-center">
						        <div class="va-latest-top">
						            <h3>Latest <span>Results</span></h3>
						            <div class="tournament">
						                <address><?php echo $ls->alamat;?><br><br></address> </div>
						            <div class="date">
						                <?php echo $ls->match_date;?></div>
						        </div>
						    </div>
						    <div class="va-latest-middle uk-flex uk-flex-middle">
						        <div class="uk-container uk-container-center">
						            <div class="uk-grid uk-flex uk-flex-middle">
						                <div class="uk-width-2-12 center">
						                    <a href="results.html">
						                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/logo-img.png" class="img-polaroid" alt="" title="">
						                    </a>
						                </div>
						                <div class="uk-width-3-12 name uk-vertical-align">
						                    <div class="wrap uk-vertical-align-middle">
						                        <?php echo $my_team['meta_umum_nama_tim'];?> </div>
						                </div>
						                <div class="uk-width-2-12 score">
						                    <div class="title">score</div>
						                    <div class="table">
						                        <div class="left"> <?php echo $ls->match_resultscore1;?></div>
						                        <div class="right"> <?php echo $ls->match_resultscore2;?></div>
						                        <div class="uk-clearfix"></div>
						                    </div>
						                </div>
						                <div class="uk-width-3-12 name alt uk-vertical-align">
						                    <div class="wrap uk-vertical-align-middle">
						                        <?php echo $ls->match_rival;?> </div>
						                </div>
						                <div class="uk-width-2-12 center">
						                    <a href="results.html">
						                       <img src="<?php echo base_url(); ?>assets/themes/kancil/images/club-logo1.png" class="img-polaroid" alt="" title="">
						                    </a>
						                </div>
						            </div>
						        </div>
						    </div>
						    <div class="uk-container uk-container-center">
						        <div class="va-latest-bottom">
						            <div class="uk-grid">
						                <div class="uk-width-8-12 uk-container-center text">
						                    <!-- <p>Vivamus hendrerit, tortor sed luctus maximus, nunc urna hendrerit nibh, sit amet efficitur libero lorem quis mauris. Nunc a pulvinar lectus. Pellentesque aliquam justo ut rhoncus lobortis. In sed venenatis massa. Sed sodales faucibus odio, eget tempus nibh accumsan ut. Fusce tincidunt semper finibus. Nullam consequat non leo interdum pulvinar.</p> -->
						                </div>
						            </div>

						            <div class="uk-grid">
						                <div class="uk-width-1-1">
						                    <div class="btn-wrap uk-container-center">
						                        <a class="read-more" href="results.html">More Info</a>
						                    </div>
						                </div>
						            </div>
						        </div>
						    </div>
						</div>                    
					<?php endif ?>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="tm-top-c-box tm-full-width  home-about">
    <div class="uk-container uk-container-center">
        <section id="tm-top-c" class="tm-top-c uk-grid uk-grid-collapse" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">

            <div class="uk-width-1-1 uk-width-large-1-2">
                <div class="uk-panel">
                    <div class="va-about-wrap clearfix uk-cover-background uk-position-relative">
                        <div class="va-about-text">
                            <div class="title">About <span>Team</span>
                            </div>
                            <p>
                            	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
</p>
                            <a class="read-more" href="about.html">read more</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="uk-width-1-1 uk-width-large-1-2">
                <div style="min-height: 500px;" class="uk-panel">
                    <div class="trainers-module tm-trainers-slider ">
                        <div class="trainer-wrapper">
                            <div >
                                <div class="trainer-top">
                                    <!-- <div class="trainers-btn">
                                        <a href="/" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideset-item="previous"></a>
                                        <a href="/" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideset-item="next"></a>
                                    </div> -->
                                    <h3>Head Coach</h3>
                                </div>
                                <ul class="uk-grid uk-slideset uk-grid-width-1-1">
                                    <li class="uk-active" style="">
                                        <div class="img-wrap"><img src="<?php echo base_url().'assets/upload/images/pengurus/thumb/'.$head_coach->photo;?>" width="268px" alt="">
                                        </div>
                                        <div class="name"><?php echo $head_coach->nama;?>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php if (count($berita_query)>0): ?>
	<div class="tm-top-f-box tm-full-width  va-main-our-news">
	    <div class="uk-container uk-container-center">
	        <section id="tm-top-f" class="tm-top-f uk-grid" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">
	            <div class="uk-width-1-1">
	                <div class="uk-panel">
	                    <div class="uk-container uk-container-center">
	                        <div class="uk-grid uk-grid-collapse" data-uk-grid-match="">
	                            <div class="uk-width-1-1">
	                                <div class="our-news-title">
	                                    <h3>Our <span>News</span></h3>
	                                </div>
	                                <div class="our-news-text">Berita-berita seputar tim futsal Kancil BBK Pontianak<br>Akan tersaji di website resmi ini </div>
	                            </div>

	                            <?php foreach ($berita_query as $berita): ?>
		                            <article class="uk-width-large-1-2 uk-width-medium-1-1 uk-width-small-1-1 our-news-article" data-uk-grid-match="">
		                                <div class="img-wrap uk-cover-background uk-position-relative" style="background-image: url(<?php echo base_url().'assets/upload/images/berita/thumb/'.$berita->cover;?>); min-height: 280px;">
		                                    <a href="news-single.html"></a>
		                                    <img class="uk-invisible" src="<?php echo base_url().'assets/upload/images/berita/thumb/'.$berita->cover;?>" alt="">
		                                </div>
		                                <div style="min-height: 280px;" class="info">
		                                    <div class="date">
		                                    	<?php echo date("Y-m-d", strtotime($berita->datecreate));?>
		                                    </div>
		                                    <div class="name">
		                                        <h4>
		                                        	<?php echo anchor('#', $berita->title);?>
		                                        </h4>
		                                    </div>
		                                    <div class="text">
		                                        <p><?php echo $berita->sinopsis;?></p>
		                                        <div class="read-more"><a href="news-single.html">Read More</a>
		                                        </div>
		                                    </div>
		                                </div>

		                            </article>
	                            	
	                            <?php endforeach ?>

	                        </div>
	                    </div>
	                    <div class="all-news-btn"><a href="news.html"><span>All News</span></a>
	                    </div>

	                </div>
	            </div>
	        </section>
	    </div>
	</div>
<?php endif ?>

<!-- NEXT MATCH -->
<?php if (count($jadwal)>0): ?>
	<div class="tm-top-e-box tm-full-width  va-main-next-match">
	    <div class="uk-container uk-container-center">
	        <section id="tm-top-e" class="tm-top-e uk-grid" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">

	            <div class="uk-width-1-1">
	                <div class="uk-panel">
	                    <div class="uk-container uk-container-center">
	                        <div class="uk-grid uk-grid-collapse">
	                            <div class="uk-width-medium-1-2 uk-width-small-1-1 va-single-next-match">
	                                <div class="va-main-next-wrap">
	                                    <div class="main-next-match-title"><em>Next <span>Match</span></em>
	                                    </div>
	                                    <div class="match-list-single">
	                                        <div class="match-list-item">
	                                            <div class="count">
	                        
	                                                <div id="countdown4">
	                                                    <div class="counter_container">
	                                                    </div>
	                                                </div>

	                                                <div class="clearfix"></div>

	                                            </div>
	                                            <div class="clear"></div>
	                                            <div class="logo">
	                                                <a href="match-single.html">
	                                                    <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava.png" class="img-polaroid">
	                                                </a>
	                                            </div>
	                                            <div class="team-name"><?php echo $my_team['meta_umum_nama_tim'];?> </div>
	                                            <div class="versus">VS</div>

	                                            <div class="team-name"><?php echo $jadwal[0]->match_rival;?> </div>
	                                            <div class="logo">
	                                                <a href="match-single.html">
	                                                    <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava1.png" class="img-polaroid">
	                                                </a>
	                                            </div>
	                                            <div class="clear"></div>
	                                            <div class="date"><?php echo date("Y-m-d", strtotime($jadwal[0]->match_date));?></div>
	                                            <div class="clear"></div>
	                                            <div class="location"><address><?php echo $jadwal[0]->alamat;?><br><br></address> </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="uk-width-medium-1-2 uk-width-small-1-1 va-list-next-match" style="background-color: #2d2525">
	                                <div class="match-list-wrap">

	                                    <?php foreach ($jadwal as $j): ?>
		                                    <div class="match-list-item alt">
		                                        <div class="date"><?php echo date("Y-m-d", strtotime($j->match_date));?> </div>
		                                        <div class="wrapper">
		                                            <!-- <div class="logo">
		                                                <a href="match-single.html">
		                                                	<?php $j_title = $my_team." vs ".$j->match_rival;?>
		                                                    <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava.png" class="img-polaroid" alt="<?php echo $j_title;?>" title="<?php echo $j_title;?>">
		                                                </a>
		                                            </div> -->
		                                            <div class="team-name"><?php echo $my_team['meta_umum_nama_tim'];?> </div>
		                                            <div class="versus">VS</div>

		                                            <div class="team-name"><?php echo $j->match_rival;?> </div>
		                                            <!-- <div class="logo">
		                                                <a href="match-single.html">
		                                                    <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava1.png" class="img-polaroid" alt="<?php echo $j_title;?>" title="<?php echo $j_title;?>">
		                                                </a>
		                                            </div> -->
		                                        </div>
		                                    </div>
	                                    	
	                                    <?php endforeach ?>

	                                </div>
	                            </div>
	                        </div>
	                    </div>

	                </div>
	            </div>
	        </section>
	    </div>
	</div>
	
<?php endif ?>


<!-- GALLERY -->
<div class="tm-top-g-box tm-full-width  ">
    <div class="uk-container uk-container-center">
        <section id="tm-top-g" class="tm-top-g uk-grid" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">
            <div class="uk-width-1-1">
                <div class="uk-panel">
                    <div class="gallery-title">
                        <div class="uk-container uk-container-center tt-gallery-top-main">
                            <div class="uk-grid" data-uk-grid-match="">
                                <div class="uk-width-3-10 title">Gallery</div>
                                <div class="uk-width-7-10 text">“Gambar-gambar yang terbaik adalah gambar yang dapat mempertahankan kekuatannya dan memiliki dampak selama bertahun-tahun, terlepas dari berapa kali gambar itu dilihat.” <b>Anne Geddes</b> </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-sticky-placeholder">
                        <div style="margin: 0px;" class="button-group filter-button-group" data-uk-sticky="{top:70, boundary: true}">
                            <div class="uk-container uk-container-center">
                                <button class="active" data-filter="*">all</button>
                                <button data-filter=".tt_c26e2589e25045ad516b5bc37d18523a">Volleyball</button>
                                <button data-filter=".tt_6081becaf04f5a1455407d73e09bca13">Hockey</button>
                                <button data-filter=".tt_c71a18083d9e74b4a5c5d8d9a17d68d0">Basketball</button>
                                <button data-filter=".tt_449a5f6d01d5f416810d04b4df596b6a">Football</button>
                                <button data-filter=".tt_ea9d8d12fefde9e2f9c4631a76504ce7">Rugby</button>
                            </div>
                        </div>
                    </div>

                    <div id="boundary">

                        <div class="uk-grid uk-grid-collapse grid" data-uk-grid-match="">


                            <div class="uk-width-1-1 uk-width-medium-1-2 uk-width-large-1-4 grid-item article-slider tt_c26e2589e25045ad516b5bc37d18523a ">
                                <div class="uk-slidenav-position" data-uk-slideshow="{height:300}">
                                    <ul class="uk-slideshow">
                                        <li class="uk-active" aria-hidden="false">
                                            <div style="background-image: url(images/1448838000_1662651f7f781a887707a2836033aa63.jpg);" class="uk-cover-background uk-position-cover"></div>
                                            <img style="width: 100%; height: auto; opacity: 0;" class="uk-responsive-height" src="<?php echo base_url(); ?>assets/themes/kancil/images/1448838000_1662651f7f781a887707a2836033aa63.jpg" alt="">
                                            <div class="titles">
                                                <div class="sub-title">
                                                    Donec vel orci sed leo semper viverra </div>
                                            </div>
                                        </li>
                                        <li aria-hidden="true">
                                            <div style="background-image: url(images/1448838000_7e2a4fc5579be1e525f7b338af8bcc4e.jpg);" class="uk-cover-background uk-position-cover"></div>
                                            <img style="width: 100%; height: auto; opacity: 0;" class="uk-responsive-height" src="<?php echo base_url(); ?>assets/themes/kancil/images/1448838000_7e2a4fc5579be1e525f7b338af8bcc4e.jpg" alt="">
                                            <div class="titles">
                                                <div class="sub-title">
                                                    Donec vel orci sed leo semper viverra </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="article-slider-btn">
                                        <a href="/" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
                                        <a href="/" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
                                    </div>
                                </div>
                            </div>

                            <div class="uk-width-1-1 uk-width-medium-1-2 uk-width-large-1-4 grid-item tt_c26e2589e25045ad516b5bc37d18523a ">
                                <div class="gallery-album">
                                    <a href="images/03f1869954e6e557b8ac56b508030a3b.jpg" data-uk-lightbox="{group:'my-group'}" class="img-0">
                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/03f1869954e6e557b8ac56b508030a3b.jpg" alt="">
                                    </a>
                                    <a href="images/6a987145d42263cbfc9724ee737b1d60.jpg" data-uk-lightbox="{group:'my-group'}" class="img-1">
                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/6a987145d42263cbfc9724ee737b1d60.jpg" alt="">
                                    </a>
                                    <div class="titles">
                                        <div class="title">Douglas Payne </div>
                                        <div class="sub-title">Volleyball </div>
                                    </div>
                                </div>
                            </div>

                            <div class="uk-width-1-1 uk-width-medium-1-2 uk-width-large-1-4 grid-item tt_6081becaf04f5a1455407d73e09bca13 ">
                                <div class="gallery-album">
                                    <a href="images/8cc1994dde069571bfe5edf1e7822185.jpg" data-uk-lightbox="{group:'my-group1'}" class="img-0">
                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/8cc1994dde069571bfe5edf1e7822185.jpg" alt="">
                                    </a>
                                    <a href="images/133dc45d6c6a6ee8ace3fd6c18f0c79e.jpg" data-uk-lightbox="{group:'my-group1'}" class="img-1">
                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/133dc45d6c6a6ee8ace3fd6c18f0c79e.jpg" alt="">
                                    </a>
                                    <div class="titles">
                                        <div class="title">Douglas Payne </div>
                                        <div class="sub-title">Hockey </div>
                                    </div>
                                </div>
                            </div>

                            <div class="uk-width-1-1 uk-width-medium-1-2 uk-width-large-1-4 grid-item tt_6081becaf04f5a1455407d73e09bca13 ">
                                <div class="gallery-album">
                                    <a href="images/62448a01125cebccfa3512491a345da9.jpg" data-uk-lightbox="{group:'my-group2'}" class="img-0">
                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/62448a01125cebccfa3512491a345da9.jpg" alt="">
                                    </a>
                                    <a href="images/14f0c92ade7d754a98d2b6ddd4fe560a.jpg" data-uk-lightbox="{group:'my-group2'}" class="img-1">
                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/14f0c92ade7d754a98d2b6ddd4fe560a.jpg" alt="">
                                    </a>
                                    <div class="titles">
                                        <div class="title">Douglas Payne </div>
                                        <div class="sub-title">Hockey </div>
                                    </div>
                                </div>
                            </div>

                            <div class="uk-width-1-1 uk-width-medium-1-2 uk-width-large-1-4 grid-item tt_c71a18083d9e74b4a5c5d8d9a17d68d0 ">
                                <div class="gallery-album">
                                    <a href="images/c9e61645f3f740197afa7fb17bf3d3ad.jpg" data-uk-lightbox="{group:'my-group3'}" class="img-0">
                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/c9e61645f3f740197afa7fb17bf3d3ad.jpg" alt="">
                                    </a>
                                    <a href="images/a46d465cb53412b43c73d9c793083875.jpg" data-uk-lightbox="{group:'my-group3'}" class="img-1">
                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/a46d465cb53412b43c73d9c793083875.jpg" alt="">
                                    </a>
                                    <div class="titles">
                                        <div class="title">Douglas Payne </div>
                                        <div class="sub-title">Basketball </div>
                                    </div>
                                </div>
                            </div>

                            <div class="uk-width-1-1 uk-width-medium-1-2 uk-width-large-1-4 grid-item tt_c71a18083d9e74b4a5c5d8d9a17d68d0 ">
                                <div class="gallery-album">
                                    <a href="images/d5d9d0e4068673aee603250d1eb43af8.jpg" data-uk-lightbox="{group:'my-group4'}" class="img-0">
                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/d5d9d0e4068673aee603250d1eb43af8.jpg" alt="">
                                    </a>
                                    <a href="images/6479eff8244e3eeb793efa29559f45f7.png" data-uk-lightbox="{group:'my-group4'}" class="img-1">
                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/6479eff8244e3eeb793efa29559f45f7.png" alt="">
                                    </a>
                                    <div class="titles">
                                        <div class="title">Douglas Payne </div>
                                        <div class="sub-title">Basketball </div>
                                    </div>
                                </div>
                            </div>

                            <div class="uk-width-1-1 uk-width-medium-1-2 uk-width-large-1-4 grid-item tt_449a5f6d01d5f416810d04b4df596b6a tt_c71a18083d9e74b4a5c5d8d9a17d68d0 tt_ea9d8d12fefde9e2f9c4631a76504ce7 ">
                                <div class="gallery-album">
                                    <a href="images/49633121e88e2125a7069937885d5163.jpg" data-uk-lightbox="{group:'my-group5'}" class="img-0">
                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/49633121e88e2125a7069937885d5163.jpg" alt="">
                                    </a>
                                    <a href="images/4510067e63319389d8587e2cb12d4346.jpg" data-uk-lightbox="{group:'my-group5'}" class="img-1">
                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/4510067e63319389d8587e2cb12d4346.jpg" alt="">
                                    </a>
                                    <div class="titles">
                                        <div class="title">Douglas Payne </div>
                                        <div class="sub-title">Douglas Payne </div>
                                    </div>
                                </div>
                            </div>

                            <div class="uk-width-1-1 uk-width-medium-1-2 uk-width-large-1-4 grid-item tt_c26e2589e25045ad516b5bc37d18523a ">
                                <div class="gallery-album">
                                    <a href="images/fb04791e435ada34da98c5ca40642149.jpg" data-uk-lightbox="{group:'my-group6'}" class="img-0">
                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/fb04791e435ada34da98c5ca40642149.jpg" alt="">
                                    </a>
                                    <a href="images/20e17d247276908ce9c879c785afad72.jpg" data-uk-lightbox="{group:'my-group6'}" class="img-1">
                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/20e17d247276908ce9c879c785afad72.jpg" alt="">
                                    </a>
                                    <div class="titles">
                                        <div class="title">Douglas Payne </div>
                                        <div class="sub-title">Douglas Payne </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
</div>

<!-- AWARD -->
<div class="tm-bottom-a-box tm-full-width  ">
    <div class="uk-container uk-container-center">
        <section id="tm-bottom-a" class="tm-bottom-a uk-grid uk-grid-collapse" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">
            <div class="uk-width-1-1">
                <div class="uk-panel tt-achievments-wrap">
                    <div class="uk-grid uk-grid-collapse">
                        <div class="uk-width-large-4-10 uk-width-medium-1-1 achievments-block">
                            <div class="our-awards-main-wrap">
                                <div class="uk-slidenav-position our-awards" data-uk-slider="{autoplay:true, autoplayInterval:7000}">
                                    <div class="our-awards-main-title">
                                        <h2>Our <span>Awards</span></h2>
                                        <div class="our-awards-btn">
                                            <a draggable="false" href="/" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></a>
                                            <a draggable="false" href="/" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></a>
                                        </div>
                                    </div>
                                    <div class="uk-slider-container">
                                        <ul class="uk-slider uk-grid uk-grid-width-large-1-2">
                                            <li>
                                                <div class="img-wrap"><img draggable="false" src="<?php echo base_url(); ?>assets/themes/kancil/images/award-img.png" alt="">
                                                </div>
                                                <div class="text">2014 world cup champion</div>
                                            </li>
                                            <li>
                                                <div class="img-wrap"><img draggable="false" src="<?php echo base_url(); ?>assets/themes/kancil/images/award-img1.png" alt="">
                                                </div>
                                                <div class="text">2014 world cup champion</div>
                                            </li>
                                            <li>
                                                <div class="img-wrap"><img draggable="false" src="<?php echo base_url(); ?>assets/themes/kancil/images/award-img2.png" alt="">
                                                </div>
                                                <div class="text">2014 world cup champion</div>
                                            </li>
                                            <li>
                                                <div class="img-wrap"><img draggable="false" src="<?php echo base_url(); ?>assets/themes/kancil/images/award-img3.png" alt="">
                                                </div>
                                                <div class="text">2014 world cup champion</div>
                                            </li>
                                            <li>
                                                <div class="img-wrap"><img draggable="false" src="<?php echo base_url(); ?>assets/themes/kancil/images/award-img4.png" alt="">
                                                </div>
                                                <div class="text">2014 world cup champion</div>
                                            </li>
                                            <li>
                                                <div class="img-wrap"><img draggable="false" src="<?php echo base_url(); ?>assets/themes/kancil/images/award-img5.png" alt="">
                                                </div>
                                                <div class="text">2014 world cup champion</div>
                                            </li>
                                            <li>
                                                <div class="img-wrap"><img draggable="false" src="<?php echo base_url(); ?>assets/themes/kancil/images/award-img3.png" alt="">
                                                </div>
                                                <div class="text">2014 world cup champion</div>
                                            </li>
                                            <li>
                                                <div class="img-wrap"><img draggable="false" src="<?php echo base_url(); ?>assets/themes/kancil/images/award-img.png" alt="">
                                                </div>
                                                <div class="text">2014 world cup champion</div>
                                            </li>
                                            <li>
                                                <div class="img-wrap"><img draggable="false" src="<?php echo base_url(); ?>assets/themes/kancil/images/award-img1.png" alt="">
                                                </div>
                                                <div class="text">2014 world cup champion</div>
                                            </li>
                                            <li>
                                                <div class="img-wrap"><img draggable="false" src="<?php echo base_url(); ?>assets/themes/kancil/images/award-img2.png" alt="">
                                                </div>
                                                <div class="text">2014 world cup champion</div>
                                            </li>
                                            <li>
                                                <div class="img-wrap"><img draggable="false" src="<?php echo base_url(); ?>assets/themes/kancil/images/award-img3.png" alt="">
                                                </div>
                                                <div class="text">2014 world cup champion</div>
                                            </li>
                                            <li>
                                                <div class="img-wrap"><img draggable="false" src="<?php echo base_url(); ?>assets/themes/kancil/images/award-img4.png" alt="">
                                                </div>
                                                <div class="text">2014 world cup champion</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-large-5-10 uk-width-medium-1-1 achievments-block uk-push-1-10">
                            <div class="achievments-inner">
                                <div class="our-awards-main-title">
                                    <h2>achievements</h2>
                                </div>
                                <div class="uk-grid">
                                    <div class="uk-width-large-2-4 uk-width-medium-1-2 uk-width-small-1-2">
                                        <div class="item">
                                            <div class="icon"><img src="<?php echo base_url(); ?>assets/themes/kancil/images/stat-icon.png" alt="">
                                            </div>
                                            <div class="info">
                                                <div class="number">35</div>
                                                <div class="text">goals</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-large-2-4 uk-width-medium-1-2 uk-width-small-1-2">
                                        <div class="item">
                                            <div class="icon"><img src="<?php echo base_url(); ?>assets/themes/kancil/images/stat-icon1.png" alt="">
                                            </div>
                                            <div class="info">
                                                <div class="number">12</div>
                                                <div class="text">games played</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-large-2-4 uk-width-medium-1-2 uk-width-small-1-2">
                                        <div class="item">
                                            <div class="icon"><img src="<?php echo base_url(); ?>assets/themes/kancil/images/stat-icon2.png" alt="">
                                            </div>
                                            <div class="info">
                                                <div class="number">13</div>
                                                <div class="text">violations</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-large-2-4 uk-width-medium-1-2 uk-width-small-1-2">
                                        <div class="item">
                                            <div class="icon"><img src="<?php echo base_url(); ?>assets/themes/kancil/images/stat-icon3.png" alt="">
                                            </div>
                                            <div class="info">
                                                <div class="number">8</div>
                                                <div class="text">Awards</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- OUR TEAM -->
<div class="tm-bottom-b-box tm-full-width  ">
    <div class="uk-container uk-container-center">
        <section id="tm-bottom-b" class="tm-bottom-b uk-grid" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">
            <div class="uk-width-1-1">
                <div class="uk-panel">
                    <div class="our-team-main-wrap">
                        <div class="uk-container uk-container-center">
                            <div class="uk-grid" data-uk-grid-match="">
                                <div class="uk-width-medium-8-10 uk-width-small-1-1 uk-push-1-10">
                                    <div class="our-team-wrap">
                                        <div class="our-team-title">
                                            <h3>Our <span>Team</span></h3>
                                        </div>
                                        <div class="our-team-text">
                                            <p><b>Kancil BBK FC Pontianak</b> Tim Futsal Profesional Pertama Dari Pontianak, Kalimantan Barat it's not about win or lose it's not just futsal club it's all about FAMILY.</p>
                                        </div>
                                        <div class="team-read-wrap"><a class="team-read-more" href="#">Read More</a>
                                        </div>
                                    </div>
                                </div>

                                <?php foreach ($pengurus as $peng): ?>
	                                <div class=" uk-width-large-1-4 uk-width-medium-1-3 uk-width-small-1-2 player-item tt_2a195f12da9f3f36da06e6097be7e451">
	                                    <div class="player-article">
	                                        <div class="wrapper">
	                                            <div class="img-wrap">
	                                                <!-- <div class="player-number"><span>21</span>
	                                                </div> -->
	                                                <div class="bio">
	                                                	<span><?php echo anchor('#', 'bio');?></span>
	                                                </div>
	                                                <a href="player.html">
	                                                    <img src="<?php echo base_url().'assets/upload/images/pengurus/thumb/'.$peng->photo;?>" class="img-polaroid" alt="<?php echo $peng->nama;?>" title="<?php echo $peng->nama;?>">
	                                                </a>
	                                                <!-- <ul class="socials">
	                                                    <li class="twitter">
	                                                        <a href="http://twitter.com/" target="_blank" rel="nofollow">
	                                                        </a>
	                                                    </li>
	                                                    <li class="facebook">
	                                                        <a href="http://facebook.com/" target="_blank" rel="nofollow">
	                                                        </a>
	                                                    </li>
	                                                    <li class="google-plus">
	                                                        <a href="https://plus.google.com/" target="_blank" rel="nofollow">
	                                                        </a>
	                                                    </li>
	                                                    <li class="pinterest">
	                                                        <a href="https://www.pinterest.com" target="_blank" rel="nofollow">
	                                                        </a>
	                                                    </li>
	                                                    <li class="linkedin">
	                                                        <a href="https://www.linkedin.com" target="_blank" rel="nofollow">
	                                                        </a>
	                                                    </li>
	                                                </ul> -->
	                                            </div>
	                                            <div class="info">
	                                                <div class="name">
	                                                    <h3>
	                                                    	<?php echo anchor('#', $peng->nama);?>
	                                                    </h3>
	                                                </div>
	                                                <div class="position">
	                                                	<?php 
	                                                	if ($peng->id_jabatan == 0) {
	                                                		echo "Head Coach";
	                                                	}
	                                                	else {
		                                                	echo $peng->jabatan;
	                                                	}
	                                                	?>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>                                	
                                <?php endforeach ?>

                                <!-- PLAYER -->
                                <?php foreach ((array)$pemain as $p): ?>
	                                <div class=" uk-width-large-1-4 uk-width-medium-1-3 uk-width-small-1-2 player-item tt_22c19cd174143e3b4c7ef40ae23c5d1a">
	                                    <div class="player-article">
	                                        <div class="wrapper">
	                                            <div class="img-wrap">
	                                                <div class="player-number"><span><?php echo $p->no_jersey;?> </span>
	                                                </div>
	                                                <div class="bio"><span><a href="player.html">bio</a></span>
	                                                </div>
	                                                <a href="player.html">
	                                                    <img src="<?php echo base_url().'assets/upload/images/pemain/thumb/'.$p->photo;?>" class="img-polaroid" alt="<?php echo $p->nama;?>" title="<?php echo $p->nama;?>">
	                                                </a>
	                                                <!-- <ul class="socials">
	                                                    <li class="twitter">
	                                                        <a href="http://twitter.com/" target="_blank" rel="nofollow">
	                                                        </a>
	                                                    </li>
	                                                    <li class="facebook">
	                                                        <a href="http://facebook.com/" target="_blank" rel="nofollow">
	                                                        </a>
	                                                    </li>
	                                                    <li class="google-plus">
	                                                        <a href="https://plus.google.com/" target="_blank" rel="nofollow">
	                                                        </a>
	                                                    </li>
	                                                    <li class="pinterest">
	                                                        <a href="https://www.pinterest.com" target="_blank" rel="nofollow">
	                                                        </a>
	                                                    </li>
	                                                    <li class="linkedin">
	                                                        <a href="https://www.linkedin.com" target="_blank" rel="nofollow">
	                                                        </a>
	                                                    </li>
	                                                </ul> -->
	                                            </div>
	                                            <div class="info">
	                                                <div class="name">
	                                                    <h3>
	                                                    	<?php echo anchor('#', $p->nama);?>
	                                                    </h3>
	                                                </div>
	                                                <div class="position"><?php echo $p->posisi;?> </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>                                	
                                <?php endforeach ?>


                            </div>
                        </div>

                        <div class="our-team-btn"><a href="players.html"><span>More Info</span></a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
</div>

<!-- SHOP -->
<div class="tm-bottom-c-box tm-full-width  ">
    <div class="uk-container uk-container-center">
        <section id="tm-bottom-c" class="tm-bottom-c uk-grid" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">

            <div class="uk-width-1-1">
                <div class="uk-panel">
                    <div class="shop-main-page-wrap">
                        <div class="container uk-container-center">
                            <div class="uk-grid">
                                <div class="uk-width-1-1">
                                    <div class="shop-title">
                                        <h2>Fun <span>Shop</span></h2>
                                    </div>
                                </div>
                                <div class="uk-width-medium-8-10 uk-width-small-1-1 uk-push-1-10">
                                    <div class="shop-text">Nullam quis eros tellus. Duis sit amet neque nec orci feugiat tincidunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sed turpis aliquet, pharetra enim sit amet, congue erat. </div>
                                </div>
                                <div class="uk-width-1-1 uk-text-center">
                                    <div class="sale-proposal">Save <span>33% OFF</span> for all new orders</div>
                                </div>
                            </div>
                        </div>
                        <div class="latest_products jshop">

                            <div data-uk-slider="{center:true, autoplay:true, pauseOnHover:true, autoplayInterval:5000}">

                                <div class="uk-slider-container">
                                    <ul class="uk-slider uk-grid-width-large-1-6 uk-grid-width-medium-1-4 uk-grid-width-small-1-1  uk-grid uk-grid-medium">

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_Jacket31.jpg" alt="Sportswear outerwear coats">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">Sportswear outerwear coats</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$100</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$151</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a> 
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_Jacket31.jpg" alt="Sportswear outerwear coats">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">Sportswear outerwear coats</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$100</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$151</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a> 
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_jacket24.jpg" alt="Waterproof jackets">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">Waterproof jackets</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$200</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$120</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a> 
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_jacket241.jpg" alt="Waterproof jackets">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">Waterproof jackets</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$200</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$120</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_jacket71.jpg" alt="Thermoball Insulated Jacket">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">Thermoball Insulated Jacket</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$100</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$78</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_jacket711.jpg" alt="Thermoball Insulated Jacket">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">Thermoball Insulated Jacket</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$100</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$78</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_cross142.jpg" alt="High Quality Running Shoes For Women">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">High Quality Running Shoes For Women</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$400</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$350</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_cross121.jpg" alt="High Quality Running Shoes For Women">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">High Quality Running Shoes For Women</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$400</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$350</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item uk-active">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_cross131.jpg" alt="High Quality Running Shoes For Woman">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">High Quality Running Shoes For Woman</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$300</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$250</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_cross111.jpg" alt="High Quality Running Shoes For Women">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">High Quality Running Shoes For Women</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$400</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$350</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="images/img_products/">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_cross102.jpg" alt="High Quality Running Shoes For Woman">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">High Quality Running Shoes For Woman</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$300</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$250</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_cross91.jpg" alt="High Quality Running Shoes For Men">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">High Quality Running Shoes For Men</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$400</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$350</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_cross81.jpg" alt="High Quality Running Shoes For Woman">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">High Quality Running Shoes For Woman</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$190</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$200</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_cross51.jpg" alt="High Quality Running Shoes For Woman">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">High Quality Running Shoes For  Woman</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$190</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$200</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_cross61.jpg" alt="High Quality Running Shoes For Men">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">High Quality Running Shoes For Men</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$200</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$280</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_100-original-New-2015-cross41.jpg" alt="High Quality Running Shoes For Men">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">High Quality Running Shoes For Men</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$250</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$200</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_cross32.jpg" alt="High Quality Running Shoes For Men">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">High Quality Running Shoes For Men</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$190</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$250</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_cross22.jpg" alt="High Quality Running Shoes For Men">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">High Quality Running Shoes For Men</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$190</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$150</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_cross23.jpg" alt="High Quality Running Shoes For Men">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">High Quality Running Shoes For Men</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$250</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$200</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                        <li class="block_item">

                                            <div class="image">
                                                <div class="image_block">
                                                    <a draggable="false" href="product.html">
                                                        <img draggable="false" class="jshop_img" src="<?php echo base_url(); ?>assets/themes/kancil/images/img_products/thumb_jacket63.jpg" alt="High-quality Men's Sport Suit">
                                                    </a>
                                                </div>
                                                <div class="name">
                                                    <a draggable="false" href="product.html">High-quality Men's Sport Suit</a>
                                                </div>
                                            </div>
                                            <div class="actions-wrap">
                                                <div class="price-wrap">
                                                    <div class="old_price"><span>$200</span>
                                                    </div>

                                                    <div class="jshop_price">
                                                        <span>$120</span>
                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <a draggable="false" class="button_buy" href="#">Buy</a>
                                                </div>

                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="fun-shop-btn">
                            <a href="category.html"><span>View all</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- VIDEO -->
<div class="tm-bottom-d-box tm-full-width  ">
    <div class="uk-container uk-container-center">
        <section id="tm-bottom-d" class="tm-bottom-d uk-grid" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">
            <div class="uk-width-1-1">
                <div class="uk-panel">
                    <div class="last-video-wrap">
                        <div class="uk-container uk-container-center">
                            <div class="uk-grid">
                                <div class="uk-width-medium-1-1">
                                    <div class="last-video-title">
                                        <h2>Last <span>Video</span></h2>
                                    </div>
                                </div>
                                <div class="uk-width-medium-8-10 uk-width-small-1-1 uk-push-1-10">
                                    <div class="last-video-text">
                                        Nullam quis eros tellus. Duis sit amet neque nec orci feugiat tincidunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sed turpis aliquet, pharetra enim sit amet, congue erat.
                                    </div>
                                </div>
                                <div class="uk-width-medium-8-10 uk-width-small-1-1 uk-push-1-10">
                                    <iframe src="https://www.youtube.com/embed/aO2q_T7C9bM" allowfullscreen="" height="546" width="970"></iframe>
                                </div>
                                <div class="uk-width-medium-1-1 uk-width-small-1-1 partners-slider">
                                    <div data-uk-slideset="{small: 2, medium: 5, large: 5}">
                                        <div class="uk-slidenav-position">
                                            <ul class="uk-grid uk-slideset uk-grid-width-1-1 uk-grid-width-large-1-5 uk-grid-width-medium-1-5 uk-grid-width-small-1-2">
                                                <li><img src="<?php echo base_url(); ?>assets/themes/kancil/images/partners-img.png" alt="">
                                                </li>
                                                <li><img src="<?php echo base_url(); ?>assets/themes/kancil/images/partners-img1.png" alt="">
                                                </li>
                                                <li><img src="<?php echo base_url(); ?>assets/themes/kancil/images/partners-img2.png" alt="">
                                                </li>
                                                <li><img src="<?php echo base_url(); ?>assets/themes/kancil/images/partners-img3.png" alt="">
                                                </li>
                                                <li><img src="<?php echo base_url(); ?>assets/themes/kancil/images/partners-img4.png" alt="">
                                                </li>
                                                <li><img src="<?php echo base_url(); ?>assets/themes/kancil/images/partners-img.png" alt="">
                                                </li>
                                                <li><img src="<?php echo base_url(); ?>assets/themes/kancil/images/partners-img1.png" alt="">
                                                </li>
                                                <li><img src="<?php echo base_url(); ?>assets/themes/kancil/images/partners-img2.png" alt="">
                                                </li>
                                                <li><img src="<?php echo base_url(); ?>assets/themes/kancil/images/partners-img3.png" alt="">
                                                </li>
                                                <li><img src="<?php echo base_url(); ?>assets/themes/kancil/images/partners-img4.png" alt="">
                                                </li>
                                                <li><img src="<?php echo base_url(); ?>assets/themes/kancil/images/partners-img.png" alt="">
                                                </li>
                                                <li><img src="<?php echo base_url(); ?>assets/themes/kancil/images/partners-img1.png" alt="">
                                                </li>
                                                <li><img src="<?php echo base_url(); ?>assets/themes/kancil/images/partners-img2.png" alt="">
                                                </li>
                                                <li><img src="<?php echo base_url(); ?>assets/themes/kancil/images/partners-img3.png" alt="">
                                                </li>
                                                <li><img src="<?php echo base_url(); ?>assets/themes/kancil/images/partners-img4.png" alt="">
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="uk-slideset-nav uk-dotnav uk-flex-center">
                                           
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- CONTACT US -->
<div class="tm-bottom-e-box tm-full-width  ">
    <div class="uk-container uk-container-center">
        <section id="tm-bottom-e" class="tm-bottom-e uk-grid uk-grid-collapse" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">

            <div class="uk-width-1-1">
                <div class="uk-panel">
                    <div class="map-wrap">

                        <div class="contact-form-wrap uk-flex">
                            <div class="uk-container uk-container-center uk-flex-item-1">
                                <div class="uk-grid  uk-grid-collapse uk-flex-item-1 uk-height-1-1 uk-nbfc">
                                    <div class="uk-width-5-10 contact-left uk-vertical-align contact-left-wrap">
                                        <div class="contact-info-lines uk-vertical-align-middle">
                                        	<?php
                                        	if (isset($my_team['meta_umum_telepon'])) {
	                                            echo '<div class="item phone"><span class="icon"><i class="uk-icon-phone"></i></span>'.$my_team['meta_umum_telepon'].'</div>';
                                        	}
                                        	if (isset($my_team['meta_umum_email'])) {
	                                            echo '<div class="item mail"><span class="icon"><i class="uk-icon-envelope"></i></span><a href="mailto:'.$my_team['meta_umum_email'].'">'.$my_team['meta_umum_email'].'</a></div>';
                                        	}
                                        	if (isset($my_team['meta_umum_alamat'])) {
	                                            echo '<div class="item location"><span class="icon"><i class="uk-icon-map-marker"></i></span>'.$my_team['meta_umum_alamat'].'</div>';
                                        	}
                                        	?>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-5-10 uk-width-small-1-1 contact-right-wrap">
                                        <div class="contact-form uk-height-1-1">
                                            <div class="uk-position-cover uk-flex uk-flex-column uk-flex-center">
                                                <div class="contact-form-title">
                                                    <h2>Get in touch</h2>
                                                </div>
                                                <div id="aiContactSafe_form_1">
                                                    <div class="aiContactSafe" id="aiContactSafe_mainbody_1">
                                                        <div class="contentpaneopen">
                                                            <div id="aiContactSafeForm">
                                                                <form  method="post" id="adminForm_1" name="adminForm_1">
                                                                    <div id="displayAiContactSafeForm_1">
                                                                        <div class="aiContactSafe" id="aiContactSafe_contact_form">
                                                                            <div class="aiContactSafe" id="aiContactSafe_info"></div>
                                                                            <div class="aiContactSafe_row" id="aiContactSafe_row_aics_name">
                                                                                <div class="aiContactSafe_contact_form_field_label_left"><span class="aiContactSafe_label" id="aiContactSafe_label_aics_name"><label for="aics_name">Name</label></span>&nbsp;
                                                                                    <label class="required_field">*</label>
                                                                                </div>
                                                                                <div class="aiContactSafe_contact_form_field_right">
                                                                                    <input name="aics_name" id="aics_name" class="textbox" placeholder="Name" value="" type="text">
                                                                                </div>
                                                                            </div>
                                                                            <div class="aiContactSafe_row" id="aiContactSafe_row_aics_email">
                                                                                <div class="aiContactSafe_contact_form_field_label_left"><span class="aiContactSafe_label" id="aiContactSafe_label_aics_email"><label for="aics_email">E-mail</label></span>&nbsp;
                                                                                    <label class="required_field">*</label>
                                                                                </div>
                                                                                <div class="aiContactSafe_contact_form_field_right">
                                                                                    <input name="aics_email" id="aics_email" class="email" placeholder="Email" value="" type="text">
                                                                                </div>
                                                                            </div>
                                                                            <div class="aiContactSafe_row" id="aiContactSafe_row_aics_message">
                                                                                <div class="aiContactSafe_contact_form_field_label_left"><span class="aiContactSafe_label" id="aiContactSafe_label_aics_message"><label for="aics_message">Message</label></span>&nbsp;
                                                                                    <label class="required_field">*</label>
                                                                                </div>
                                                                                <div class="aiContactSafe_contact_form_field_right">
                                                                                    <textarea name="aics_message" id="aics_message" cols="40" rows="10" class="editbox" placeholder="Message"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <br>
                                                                    <div id="aiContactSafeBtns">
                                                                        <div id="aiContactSafeButtons_center" style="clear:both; display:block; text-align:center;">
                                                                            <table style="margin-left:auto; margin-right:auto;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div id="aiContactSafeSend_loading_1">&nbsp;</div>
                                                                                        </td>
                                                                                        <td id="td_aiContactSafeSendButton">
                                                                                            <input id="aiContactSafeSendButton" value="Send" type="submit">
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>
                                  
                    <div id="map"></div>
                                        
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="bottom-wrapper">
    <div class="tm-bottom-f-box  ">
        <div class="uk-container uk-container-center">
            <section id="tm-bottom-f" class="tm-bottom-f uk-grid" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">

                <div class="uk-width-1-1">
                    <div class="uk-panel">
                        <div class="footer-logo">
                            <a href="/"><img src="<?php echo base_url(); ?>assets/themes/kancil/images/footer-logo-img.png" alt=""><span>Kancil </span>BBK</a>
                        </div>
                        <div class="footer-socials">
                            <div class="social-top">
                                <?php
                                if (isset($my_team['meta_socmed_facebook'])) {
                                	echo '<a href="'.$my_team['meta_socmed_facebook'].'"><span class="uk-icon-small uk-icon-hover uk-icon-facebook"></span></a>';
                                }
                                if (isset($my_team['meta_socmed_twitter'])) {
	                                echo '<a href="'.$my_team['meta_socmed_twitter'].'"><span class="uk-icon-small uk-icon-hover uk-icon-twitter"></span></a>';
                                }
                                if (isset($my_team['meta_socmed_youtube'])) {
	                                echo '<a href="'.$my_team['meta_socmed_youtube'].'"><span class="uk-icon-small uk-icon-hover uk-icon-youtube"></span></a>';
                                }
                                if (isset($my_team['meta_socmed_instagram'])) {
                                	echo '<a href="'.$my_team['meta_socmed_instagram'].'"><span class="uk-icon-small uk-icon-hover uk-icon-instagram"></span></a>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="clear"></div>

                        <p class="footer-about-text">
                            <?php echo @$my_team['meta_umum_deskripsi'];?>
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="tm-bottom-g-box  ">
        <div class="uk-container uk-container-center">
            <section id="tm-bottom-g" class="tm-bottom-f uk-grid" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">

                <div class="uk-width-1-1 uk-width-large-1-2">
                    <div class="uk-panel">
                        <div class="match-list-wrap foot">
                            <div id="carusel-7" class="uk-slidenav-position" data-uk-slideshow="{ height : 37, autoplay:true, animation:'scroll' }">
                                <div class="last-match-top">
                                    <div class="last-match-title">Last match</div>
                                    <div class="footer-slider-btn">
                                        <a href="/" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
                                        <a href="/" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <ul class="uk-slideshow">
                                    <li class="" aria-hidden="true">
                                        <div class="match-list-item alt foot">
                                            <div class="wrapper">
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava.png" class="img-polaroid" alt="England VS Amsterdam (2015-11-14)" title="England VS Amsterdam (2015-11-14)">
                                                    </a>
                                                </div>
                                                <div class="team-name">
                                                    England </div>
                                                <div class="versus">VS</div>

                                                <div class="team-name">
                                                    Amsterdam </div>
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava1.png" class="img-polaroid" alt="England VS Amsterdam (2015-11-14)" title="England VS Amsterdam (2015-11-14)">
                                                    </a>
                                                </div>
                                                <a class="read-more" href="match-single.html">Read More</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="" aria-hidden="true">
                                        <div class="match-list-item alt foot">
                                            <div class="wrapper">
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava2.png" class="img-polaroid" alt="Cambridgehire VS china (2015-11-29)" title="Cambridgehire VS china (2015-11-29)">
                                                    </a>
                                                </div>
                                                <div class="team-name">
                                                    Cambridgehire </div>
                                                <div class="versus">VS</div>

                                                <div class="team-name">
                                                    china </div>
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava3.png" class="img-polaroid" alt="Cambridgehire VS china (2015-11-29)" title="Cambridgehire VS china (2015-11-29)">
                                                    </a>
                                                </div>
                                                <a class="read-more" href="match-single.html">Read More</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="" aria-hidden="true">
                                        <div class="match-list-item alt foot">
                                            <div class="wrapper">
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava4.png" class="img-polaroid" alt="Cambridgehire VS china (2015-11-20)" title="Cambridgehire VS china (2015-11-20)">
                                                    </a>
                                                </div>
                                                <div class="team-name">
                                                    Cambridgehire </div>
                                                <div class="versus">VS</div>

                                                <div class="team-name">
                                                    china </div>
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava5.png" class="img-polaroid" alt="Cambridgehire VS china (2015-11-20)" title="Cambridgehire VS china (2015-11-20)">
                                                    </a>
                                                </div>
                                                <a class="read-more" href="match-single.html">Read More</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="" aria-hidden="true">
                                        <div class="match-list-item alt foot">
                                            <div class="wrapper">
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava.png" class="img-polaroid" alt="England VS Amsterdam (2015-11-14)" title="England VS Amsterdam (2015-11-14)">
                                                    </a>
                                                </div>
                                                <div class="team-name">
                                                    England </div>
                                                <div class="versus">VS</div>

                                                <div class="team-name">
                                                    Amsterdam </div>
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava1.png" class="img-polaroid" alt="England VS Amsterdam (2015-11-14)" title="England VS Amsterdam (2015-11-14)">
                                                    </a>
                                                </div>
                                                <a class="read-more" href="match-single.html">Read More</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li aria-hidden="false">
                                        <div class="match-list-item alt foot">
                                            <div class="wrapper">
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava2.png" class="img-polaroid" alt="Cambridgehire VS china (2015-11-29)" title="Cambridgehire VS china (2015-11-29)">
                                                    </a>
                                                </div>
                                                <div class="team-name">
                                                    Cambridgehire </div>
                                                <div class="versus">VS</div>

                                                <div class="team-name">
                                                    china </div>
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava3.png" class="img-polaroid" alt="Cambridgehire VS china (2015-11-29)" title="Cambridgehire VS china (2015-11-29)">
                                                    </a>
                                                </div>
                                                <a class="read-more" href="match-single.html">Read More</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="" aria-hidden="true">
                                        <div class="match-list-item alt foot">
                                            <div class="wrapper">
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava4.png" class="img-polaroid" alt="King VS china (2015-11-20)" title="King VS china (2015-11-20)">
                                                    </a>
                                                </div>
                                                <div class="team-name">
                                                    King </div>
                                                <div class="versus">VS</div>

                                                <div class="team-name">
                                                    china </div>
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava5.png" class="img-polaroid" alt="King VS china (2015-11-20)" title="King VS china (2015-11-20)">
                                                    </a>
                                                </div>
                                                <a class="read-more" href="match-single.html">Read More</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="" aria-hidden="true">
                                        <div class="match-list-item alt foot">
                                            <div class="wrapper">
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava.png" class="img-polaroid" alt="England VS Amsterdam (2015-11-14)" title="England VS Amsterdam (2015-11-14)">
                                                    </a>
                                                </div>
                                                <div class="team-name">
                                                    England </div>
                                                <div class="versus">VS</div>

                                                <div class="team-name">
                                                    Amsterdam </div>
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava1.png" class="img-polaroid" alt="England VS Amsterdam (2015-11-14)" title="England VS Amsterdam (2015-11-14)">
                                                    </a>
                                                </div>
                                                <a class="read-more" href="match-single.html">Read More</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="" aria-hidden="true">
                                        <div class="match-list-item alt foot">
                                            <div class="wrapper">
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava2.png" class="img-polaroid" alt="Cambridgehire VS china (2015-11-29)" title="Cambridgehire VS china (2015-11-29)">
                                                    </a>
                                                </div>
                                                <div class="team-name">
                                                    Cambridgehire </div>
                                                <div class="versus">VS</div>

                                                <div class="team-name">
                                                    china </div>
                                                <div class="logo">
                                                    <a href="match-single.html">
                                                        <img src="<?php echo base_url(); ?>assets/themes/kancil/images/team-ava3.png" class="img-polaroid" alt="Cambridgehire VS china (2015-11-29)" title="Cambridgehire VS china (2015-11-29)">
                                                    </a>
                                                </div>
                                                <a class="read-more" href="match-single.html">Read More</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>




                        </div>
                    </div>
                </div>

                <div class="uk-width-1-1 uk-width-large-1-2">
                    <div  class="uk-panel">
                        <div class="acymailing_module" id="acymailing_module_formAcymailing54111">
                            <div class="acymailing_fulldiv" id="acymailing_fulldiv_formAcymailing54111">
                                <form id="formAcymailing54111" method="post" name="formAcymailing54111">
                                    <div class="acymailing_module_form">
                                        <div class="mail-title">Newsletters</div>
                                        <div class="acymailing_introtext">Suspendisse sodales, magna at dignissim cursus, velit ex porttitor eros.</div>
                                        <div class="clear"></div>
                                        <div class="space"></div>
                                        <table class="acymailing_form">
                                            <tbody>
                                                <tr>
                                                    <td class="acyfield_email acy_requiredField">
                                                        <span class="mail-wrap">
						                                    <input id="user_email_formAcymailing54111" onfocus="if(this.value == 'Enter your email') this.value = '';" onblur="if(this.value=='') this.value='Enter your email';" class="inputbox" name="user[email]" style="width:80%" value="Enter your email" title="Enter your email" type="text">
                                                    </span>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td class="acysubbuttons">
                                                        <span class="submit-wrap">
                                                            <span class="submit-wrapper">
                                                                <input class="button subbutton btn btn-primary" value="Subscribe" name="Submit" onclick="try{ return submitacymailingform('optin','formAcymailing54111'); }catch(err){alert('The form could not be submitted '+err);return false;}" type="submit">
                                                            </span>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <footer id="tm-footer" class="tm-footer">


        <div class="uk-panel">
            <div class="uk-container uk-container-center">
                <div class="uk-grid">
                    <div class="uk-width-1-1">
                        <div class="footer-wrap">
                            <div class="foot-menu-wrap">
                                <ul class="nav menu">
                                    <li class="item-165"><a href="about.html">About</a>
                                    </li>
                                    <li class="item-166"><a href="players.html">Players</a>
                                    </li>
                                    <li class="item-167"><a href="match-list.html">Match</a>
                                    </li>
                                    <li class="item-168"><a href="results.html">Results</a>
                                    </li>
                                    <li class="item-169"><a href="news.html">News</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="copyrights">Copyright © 2015 <a href="/">Sportak Team</a>. All Rights Reserved.</div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</div>

<div id="offcanvas" class="uk-offcanvas">
    <div class="uk-offcanvas-bar">
        <ul class="uk-nav uk-nav-offcanvas">
            <li class="uk-parent uk-active"><a href="index.html">Home</a>
                <ul class="uk-nav-sub">
                    <li><a class="yellow-scheme" href="../yellow/index.html">Yellow Color Scheme</a>
                    </li>
                    <li><a class="blue-scheme" href="../blue/index.html">Blue Color Scheme</a>
                    </li>
                    <li><a class="red-scheme" href="../red/index.html">Red Color Scheme</a>
                    </li>
                    <li><a href="offline.html">Offline Page</a>
                    </li>
                    <li><a href="404.html">Error Page</a>
                    </li>
                </ul>
            </li>
            <li><a href="about.html">About</a></li>
            <li class="uk-parent"><a href="#">Pages</a>
                <ul class="uk-nav-sub">
                    <li><a href="players.html">Players</a>
                    </li>
                    <li><a href="gallery.html">Gallery</a>
                    </li>
                </ul>
            </li>
            <li class="uk-parent"><a href="match-list.html">Match</a>
                <ul class="uk-nav-sub">
                    <li><a href="results.html">Results</a>
                    </li>
                </ul>
            </li>
            <li><a href="news.html">News</a>
            </li>
            <li><a href="category.html">Shop</a>
            </li>
            <li><a href="contact.html">Contact</a>
            </li>
        </ul>
    </div>
</div>