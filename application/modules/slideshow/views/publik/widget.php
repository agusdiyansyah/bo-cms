<div class="tm-top-a-box tm-full-width  ">
    <div class="uk-container uk-container-center">
        <section id="tm-top-a" class="tm-top-a uk-grid uk-grid-collapse" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin="">

            <div class="uk-width-1-1">
                <div class="uk-panel">
                    <div class="akslider-module ">
                        <div class="uk-slidenav-position" data-uk-slideshow="{height: 'auto', animation: 'swipe', duration: '500', autoplay: false, autoplayInterval: '7000', videoautoplay: true, videomute: true, kenburns: false}">
                            <ul class="uk-slideshow uk-overlay-active">
                                <?php foreach ($result as $r) { ?>
                                    <li aria-hidden="false" class="uk-height-viewport uk-active">
                                        <div style="background-image: url(<?php echo base_url().'assets/upload/images/slideshow/'.$r->cover.'';?>);" class="uk-cover-background uk-position-cover"></div>
                                        <img style="width: 100%; height: auto; opacity: 0;" class="uk-invisible" src="<?php echo base_url().'assets/upload/images/slideshow/'.$r->cover.'';?>" alt="">
                                        <?php if ($r->title != ""): ?>
                                            <div class="uk-position-cover uk-flex-middle">
                                                <div class="uk-container uk-container-center uk-position-cover">
                                                    <div class="va-promo-text uk-width-6-10 uk-push-4-10">
                                                        <h3><?php echo $r->title;?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </li>                                
                                <?php } ?>
                            </ul>
                            <a href="/" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
                            <a href="/" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
                            <ul class="uk-dotnav uk-dotnav-contrast uk-position-bottom uk-text-center">
                                <?php 
                                $i = 0;
                                foreach ($result as $r1) {
                                    $ukactive = ($i == 0) ? "uk-active" : "" ;
                                    echo '<li class="'.$ukactive.'" data-uk-slideshow-item="'.$i.'"><a href="/">'.$i.'</a></li>';
                                    $i++;
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>