<?php 
if(!$security_test) exit;

$thisPage= $db_link->where("id", 3)->getValue ("category", "name_".$lang);
$thisIMG= $db_link->where("id", 3)->getValue ("category", "img1");
if ($thisIMG) {
    $tbl_category_img = "/uploads/menyu/".$thisIMG;
}else{
    $tbl_category_img="/images/slide01.jpg";  
}
?>
<header class="page-header" data-background="<?php print $tbl_category_img;?>" data-stellar-background-ratio="1.15">
    <div class="container">
        <h1><?php print $thisPage;?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><?php print $home;?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#"><?php print $thisPage;?></a></li>
        </ol>
    </div>
</header>
<section class="contact">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="map-sidebar">
                    <div class="map-container">
                        <div id="map" style="height: 650px; margin-bottom: 20px;"></div>
                    </div>
                    <div>
                        <div class="select-options-map" style="display: flex; justify-content: end;">
                            <?php
                            combo_mapCategory($lang,$db_link);
                            ?>
                        </div>
                        <a id="back-icon" class="back-icon" style="float: left;padding: 1rem 1.5rem;display: none;border: none;cursor: pointer;width: 1rem;"><i style="font-size: 1.3rem" class="fas fa-arrow-left"></i></a>
                        <div id="sidebar" class="sidebar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>