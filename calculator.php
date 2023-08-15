<?php 
if(!$security_test) exit;

$thisPage= $db_link->where("id", 12)->getValue ("category", "name_".$lang);
$thisIMG= $db_link->where("id", 12)->getValue ("category", "img1");
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
    <!-- end container -->
</header>
<!-- end page-header -->
<section style="margin-top: 3rem;">
    <div class="container">
        <div class="d-flex-class" style="display: flex">

            <form
                class="calc"
                id="cng_basic"
                method="post"
                enctype="text/plain">
                <fieldset class="first">
                    <label><?php print $litrle; ?><br /><em><?php print $benzin; ?></em></label>
                    <input
                        type="text"
                        id="sp_benzin"
                        value="8,00"
                        onclick="if(this.value=='0') this.value=''"
                        onblur="if(this.value=='') this.value='0'"
                        /><br />
                </fieldset>
                <fieldset>
                    <label><?php print $herlitr; ?><br /><em><?php print $benzz; ?></em></label>
                    <input
                        type="text"
                        id="cena_benzin"
                        value="0,90"
                        onclick="if(this.value=='0') this.value=''"
                        onblur="if(this.value=='') this.value='0'"
                        /><br />
                </fieldset>
                <fieldset>
                    <label><?php print $metr3; ?><br /><em><?php print $cng; ?></em></label>
                    <input
                        type="text"
                        id="sp_cng"
                        value="5,00"
                        onclick="if(this.value=='0') this.value=''"
                        onblur="if(this.value=='') this.value='0'"
                        /><br />
                </fieldset>
                <fieldset>
                    <label
                        ><?php print $herm3; ?></label
                    >
                    <input
                        type="text"
                        id="cena_cng"
                        value="0,45"
                        onclick="if(this.value=='0') this.value=''"
                        onblur="if(this.value=='') this.value='0'"
                        /><br />
                </fieldset>
                <fieldset>
                    <label><?php print $surulen; ?></label>
                    <input
                        type="text"
                        id="kilometry"
                        value="60 000"
                        onclick="if(this.value=='0') this.value=''"
                        onblur="if(this.value=='') this.value='0'"
                        /><br />
                </fieldset>
                <fieldset class="last buttons">
                    <input
                        type="button"
                        class="submit vynulovat"
                        name="akce"
                        value="<?php print $sifirla; ?>"
                        onclick="reset_basic()"
                        />
                    <input
                        type="button"
                        class="submit vypocitat"
                        name="akce"
                        value="<?php print $hesabla; ?>"
                        onclick="calc_basic()"
                        />
                </fieldset>
            </form>

            <div class="vysledky" style="background: white;">
                <h2 class="vysledky"><?php print $neticeler; ?></h2>
                <div class="line">
                    <strong><?php print $yanacaqqiym; ?></strong
                    ><span class="vysledek cislo" id="benzin_rok">0</span><br />
                    <em><?php print $benzman; ?> </em
                    ><span class="vysledek"><?php print $manatil; ?></span>
                </div>
                <hr />
                <div class="line">
                    <strong><?php print $yanacaqqiym; ?></strong
                    ><span class="vysledek cislo" id="benzin_km">0,00</span><br />
                    <em><?php print $benzman; ?></em><span class="vysledek"><?php print $mankm; ?></span>
                </div>
                <hr />
                <div class="line">
                    <strong><?php print $yanacaqqiym; ?></strong
                    ><span class="vysledek cislo" id="cng_rok">0</span><br />
                    <em><?php print $cngmanil; ?></em><span class="vysledek"><?php print $manatil; ?></span>
                </div>
                <hr />
                <div class="line">
                    <strong><?php print $yanacaqqiym; ?></strong
                    ><span class="vysledek cislo" id="cng_km">0,00</span><br />
                    <em><?php print $cngmankm; ?></em><span class="vysledek"><?php print $mankm; ?></span>
                </div>
                <hr />
                <div class="grey line">
                    <strong><?php print $qenaet; ?></strong
                    ><span class="vysledek cislo" id="uspora_rok">0</span><br />
                    <em><?php print $manheril; ?></em><span class="vysledek"><?php print $manatil; ?></span>
                </div>
                <hr />
                <div class="grey line">
                    <strong><?php print $qenaet; ?></strong
                    ><span class="vysledek cislo" id="uspora_km">0,00</span><br />
                    <em><?php print $mankm; ?></em><span class="vysledek"><?php print $mankm; ?></span>
                </div>
            </div>
        </div>
    </div>
</section>