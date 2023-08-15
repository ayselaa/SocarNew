<?php
ini_set('display_errors', false);
session_start();
$security_test=1;
//include_once("sqlinj.php");
//$sqlyoxlama=new sqlinj;
//$sqlyoxlama->basla("aio","all");

if($_GET['lang']=='ru') 
    $_SESSION['lang'] = 'ru';
elseif($_GET['lang']=='en') 
    $_SESSION['lang'] = 'en';
else $_SESSION['lang'] = 'az';

$lang = $_SESSION['lang'];
$_SESSION['SendMailMessage']='sendno';
$page = $_GET['page'];
$alias = $_GET['alias'];
if(empty($page)) $page='main';
$subid = (int)$_GET['subid'];
if($_GET['seh']) $seh=(int)$_GET['seh']; else $seh = 1;
$cid = (int)$_GET['cid'];
$type = $_GET['type'];
include("mpan/config.php");
include "lang.php";
include "function.php";
array_walk($_POST, 'xss_protect');
array_walk($_GET, 'xss_protect');

if ($page == 'pages') $home_title = $db_link->where("alias_".$lang, $type)->getValue("category", "name_".$lang);
elseif ($page == 'articles'){ 
	$home_title = $db_link->where("alias_".$lang, $type)->getValue("category", "name_".$lang);
	if ($cid){ 
		$home_title = $home_title." ".$db_link->where('id', $cid)->getValue("news", "title_".$lang);
		$create_date = $db_link->where('id', $cid)->getValue("news", "news_date");
	}
}elseif ($page == 'multimedia') $home_title = $db_link->where("alias_".$lang, $type)->getValue("category", "name_".$lang);
elseif ($page == 'video') $home_title = $db_link->where("alias_".$lang, $type)->getValue("category", "name_".$lang);
else $home_title = "Socar Petroleum";

if (!($_SESSION['sessionid'])) $_SESSION['sessionid'] = date('Ymdhis') . yazi();
$sessionid = $_SESSION['sessionid'];
$home_title = str_replace('"', "", $home_title);
$home_title_meta = str_replace(" ", ",", $home_title);

if($create_date) $create_date=$create_date; else $create_date='2023-05-31 21:00:00';

$telefon=siteConfig("telefon");
$email=siteConfig("email");
$facebook=siteConfig("facebook");
$youtube=siteConfig("youtube");
$instagram=siteConfig("instagram");
$curPageName= "https://".$_SERVER['HTTP_HOST']."".$_SERVER['REQUEST_URI'];   

?>
<!doctype html>
<html lang="az">
<script src="/slep/jquery.js"></script>
<script src="/slep/uhpv-hover-full.min.js"></script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="format-detection" content="telephone=no">
        <meta name="theme-color" content="#282828"/>
        <title><?php print $home_title;?></title>
        <meta name="author" content="<?php print $siteName;?>">
        <meta name="description" content="<?php print $home_title;?>">
        <meta name="keywords" content="<?php print $home_title_meta;?>">
        <script src="https://kit.fontawesome.com/c6307aff81.js" crossorigin="anonymous"></script>

        <!-- SOCIAL MEDIA META -->
        <meta property="og:description" content="<?php print $home_title;?>">
        <meta property="og:image" content="#">
        <meta property="og:site_name" content="<?php print $home_title;?>">
        <meta property="og:title" content="<?php print $home_title;?>">
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php print $curPageName;?>">

        <!-- TWITTER META -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@<?php print $siteName;?>">
        <meta name="twitter:creator" content="@<?php print $siteName;?>">
        <meta name="twitter:title" content="<?php print $home_title;?>">
        <meta name="twitter:description" content="<?php print $home_title;?>">
        <meta name="twitter:image" content="#">

        <!-- FAVICON FILES -->
        <link href="/ico/apple-touch-icon-144-precomposed.png" rel="apple-touch-icon" sizes="144x144">
        <link href="/ico/apple-touch-icon-114-precomposed.png" rel="apple-touch-icon" sizes="114x114">
        <link href="/ico/apple-touch-icon-72-precomposed.png" rel="apple-touch-icon" sizes="72x72">
        <link href="/ico/apple-touch-icon-57-precomposed.png" rel="apple-touch-icon">
        <link href="/ico/favicon.png" rel="shortcut icon">

        <!-- CSS FILES -->
        <link rel="stylesheet" href="/css/animate.min.css">
        <link rel="stylesheet" href="/css/fancybox.min.css">
        <link rel="stylesheet" href="/css/odometer.min.css">
        <link rel="stylesheet" href="/css/swiper.min.css">
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/map.css" />
        <link rel="stylesheet" href="/css/calc.css" />
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD57wRcrfko48s1TmFWjhT5TH9fTMgLzOY"></script>
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "NewsArticle",
                "headline": "<?php print $home_title; ?>",
                "datePublished": "<?php print date(DATE_ATOM, strtotime($create_date));?>"
            }
        </script>
    </head>
    <body>

        <?php
        include "header.php";

        if (empty($page)){
            include "main.php";
        }

        if ($page=='main'){
            include "main.php";
        }

        if ($page=="notpage"){                                                    
            print "<script> window.location.href = '/404.html'; </script>";
            exit;
        }
        if ($page=='video'){                                                    
            videos($type,$seh,$lang,$db_link);  
        }

        if ($page=='multimedia'){                                                    
            if ($cid){
                multimedia_ac($cid,$lang,$db_link);
            }else{
                multimedia($type,$seh,$lang,$db_link);  
            }
        }

        if ($page=='articles'){                                                    
            if ($cid){
                xeber_ac($cid,$lang,$db_link);
            }else{
                xeberler($type,$seh,$lang,$db_link);  
            }
        }

        if ($page=='pages'){ 
            $page_id=$db_link->where("type", "pages")->where("alias_".$lang, $type)->getValue ("category", "id");
            //print $db_link->getLastQuery();
            if($page_id==3){
                include "map.php";
            }elseif($page_id==7){
                include "contact.php";
            }elseif($page_id==12){
                include "calculator.php";
            }elseif($page_id==20){
                include "onlineMuraciet.php";
            }else{
                content($type,$lang,$db_link);
            }             
        }             

        if ($page=="search")                                                    
            search($_POST['search_text'],$lang,$seh,$db_link);

        ?>

        <!-- start footer --> 
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.05s"> <img src="/images/logo@4x.png" alt="Socar logo" class="logo">
                        <p><?php home_content_s(28, $lang, $db_link); ?></p>
                    </div>
                    <!-- end col-2 -->
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.20s">
                        <div class="contact-box">
                            <h5><?php print $b_contact; ?></h5>
                            <h3>+994(12) 570-09-01</h3>
                            <p><a href="mailto:office@socar-petroleum.az">office@socar-petroleum.az</a></p>
                            <ul>
                                <li><a href="https://www.facebook.com/pages/SOCAR-Petroleum-QSC/695389580579254?fref=ts"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://www.instagram.com/socarpetroleum/?utm_source=ig_profile_share&igshid=rbeak0akg43j&fbclid=IwAR2gQZmtReTEuZZnXENkBtxyA-Z7_PPO3uKPhwl_US7AqNNRCuGlx794nng"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="https://www.linkedin.com/company/socar-petroleum/"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="https://www.youtube.com/channel/UCCJ-JVR7ZoHRKzfP9lleK_g"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                        <!-- end contact-box --> 
                    </div>
                    <!-- end col-4 -->
                    <div class="col-12"> <span class="copyright">© 2023 Socar Petroleum | Bütün hüquqları qorunur</span> <span class="creation">Site created by <a href="#"></a></span> </div>
                    <!-- end col-12 --> 
                </div>
                <!-- end row --> 
            </div>
            <!-- end container --> 
        </footer>
        <!-- end footer --> 

        <!-- JS FILES --> 
        <script src="/js/jquery.min.js"></script> 
        <script src="/js/popper.min.js"></script> 
        <script src="/js/bootstrap.min.js"></script> 
        <script src="/js/swiper.min.js"></script> 
        <script src="/js/fancybox.min.js"></script> 
        <script src="/js/odometer.min.js"></script> 
        <script src="/js/wow.min.js"></script> 
        <script src="/js/text-rotater.js"></script> 
        <script src="/js/jquery.stellar.js"></script> 
        <script src="/js/isotope.min.js"></script> 
        <script src="/js/scripts.js"></script>
        <script src="/maps.Marker.js"></script>
        <script src="/js/map.js"></script>
        <script src="/js/scripts2.js"></script>        
    </body>
</html>