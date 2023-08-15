<?php 
if(!$security_test) exit;

//home_news(4,$lang,$db_link);

//home_content_menyu(2,$lang,$db_link);
//home_content(8,$lang,$db_link);
//print $db_link->where("id", 16)->getValue ("category", "name_".$lang);

//team_photos(16,$lang,$db_link);
///home_photos(7,$lang,$db_link);
//$db_link->where("id", 7)->getValue ("category", "name_".$lang);
//home_slider_photos(13,$lang,$db_link); 
///print $db_link->where("id", 14)->getValue ("category", "name_".$lang);

//home_news_slider2(14,0,$lang,$db_link);

//home_photos2(17,$lang,$db_link);

//home_slider_photos(5,$lang,$db_link);
//home_content_s(6,$lang,$db_link);

//home_slider_video(6,$lang,$db_link);

//home_content_s(9,$lang,$db_link); ?>

<header class="slider">
    <div class="slider-container">
        <div class="swiper-wrapper">
            <?php home_slider_video(26,$lang,$db_link);?>
        </div>
        <div class="inner-elements">
            <div class="container">
                <div class="pagination"></div>
                <div class="button-prev"><?php print $cl_prev; ?></div>
                <div class="button-next"><?php print $cl_next; ?></div>
            </div>
        </div>
    </div>
</header>
<?php home_content_s(24,$lang,$db_link); ?>
<?php home_content_s(25,$lang,$db_link); ?>
<section class="recent-posts">
    <div class="container">
        <div class="row">
            <div class="col-12 wow fadeInUp">
                <h4><span><?php print $db_link->where("id", 23)->getValue ("category", "name_".$lang);?></span></h4>
            </div>
            <?php home_news(23,$lang,$db_link);?>
        </div>
    </div>
</section>
<?php home_content_s(29,$lang,$db_link); ?>
<div class="divider"></div>
<section class="recent-gallery">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 wow fadeInUp">
                <h4><span><?php print $db_link->where("id", 21)->getValue ("category", "name_".$lang);?></span></h4>
            <a href="/az/multimedia/foto-qalereya" class="link">BÜTÜN QALEREYALAR</a> </div>
            <div class="col-lg-8">
                <div class="row inner">
                    <?php home_multimedia(21,$lang,$db_link);?> 
                </div>
            </div>
        </div>
    </div>
</section>

<div class="divider"></div>
<section class="recent-posts">
    <div class="container">
        <div class="row">
            <div class="col-12 wow fadeInUp">
                <h4><span><?php print $db_link->where("id", 10)->getValue ("category", "name_".$lang);?></span></h4>
            </div>
            <?php home_news(10,$lang,$db_link);?>
        </div>
    </div>
</section>

