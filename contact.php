<?php  
if(!$security_test) exit;
if($_POST['gonder']) {
    if(isset($_POST['g-recaptcha-response'])){
        $captcha=$_POST['g-recaptcha-response'];
    }
    if(!GoogleRecaptcha($captcha)){
        $_SESSION['loggedin']=false;
        $RegError = $cdoldurun;
    }else{
        if(($_POST['adsoyad'])and($_POST['email'])and($_POST['message'])){
            $insert_data = array(
                'adsoyad' => $_POST['adsoyad'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'metn' => $_POST['message'] 
            );       
            $db_link->insert('elaqe_form', $insert_data);
            $successss= $cgonderildi;
        }else{
            $RegError=$cdoldurun; 
        }
    }
}else{
    $RegError="";
}

$thisPage= $db_link->where("id", 7)->getValue ("category", "name_".$lang);
$thisIMG= $db_link->where("id", 7)->getValue ("category", "img1");
if ($thisIMG) {
    $tbl_category_img = "/uploads/menyu/".$thisIMG;
}else{
    $tbl_category_img="/images/slide01.jpg";  
}
?>  
<header class="page-header" data-background="<?php print $tbl_category_img;?>" data-stellar-background-ratio="1.15">
    <div class="container">
        <h1><?php print $thisPage; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><?php print $home; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#"><?php print $thisPage; ?></a></li>
        </ol>
    </div>
</header>

<section class="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <?php
                home_content_s(7,$lang,$db_link);
                ?>

            </div>
            <div class="formbold-main-wrapper col-lg-6 col-md-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <div class="formbold-form-wrapper">
                    <?php
                    if(isset($successss)){
                        print "<h3>$successss</h3>"; 
                    }else{
                        print "<h4>$RegError</h4>";
                        ?>
                        <form action="" method="POST">                      

                            <div class="formbold-input">
                                <div> <input type="text" name="adsoyad" id="adsoyad" placeholder="<?php print $cl_namesurname; ?>" class="formbold-form-input" />
                                </div>
                            </div>

                            <div class="formbold-input-flex">
                                <div> <input type="email" name="email" id="email" placeholder="<?php print $qeyd_email; ?>" class="formbold-form-input" />
                                </div>
                                <div> <input type="text" name="phone" id="phone" placeholder="<?php print $qeyd_phone; ?>" class="formbold-form-input" />
                                </div>
                            </div>

                            <div class="formbold-textarea">
                                <textarea rows="6" name="message" id="message" placeholder="<?php print $qeyd_comment; ?>" class="formbold-form-input" ></textarea>
                            </div>
                            <div class="formbold-textarea"> 
                                <div class="g-recaptcha" data-sitekey="6LdoQQoTAAAAAAgisMNXjhvX_0EUclC8hlipimec"></div>
                            </div>
                            <button  type="submit" class="formbold-btn" name="gonder" value="gonder"> <?php print $csend; ?> </button>
                        </form>
                        <?php
                    }
                    ?>                    
                </div>
            </div>
        </div>
    </div>
</section>



