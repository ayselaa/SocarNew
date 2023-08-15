<?php
if(!$security_test) exit;
use PHPMailer\PHPMailer\PHPMailer;

function site_is_logged_in(){
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['project'] == 'sayt'){
        return true;
    }else{
        return false;  
    }
}

if($_POST['gonderICS']) {
    if(isset($_POST['g-recaptcha-response'])){
        $captcha=$_POST['g-recaptcha-response'];
    }
    if(!GoogleRecaptcha($captcha)){
        $_SESSION['loggedin']=false;
        $RegError = "Bütün bölmələri doldurun";
    }else{

        if($_POST['email']){  
            require 'PHPMailer/src/Exception.php';
            require 'PHPMailer/src/PHPMailer.php';
            require 'PHPMailer/src/SMTP.php';
            $successss="";
            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                require 'ics.php';
                $tbl_content = $db_link->where ('id', $cid)->get('tedbir');
                foreach ($tbl_content as $line) {
                    $nomre = $line["id"];
                    $read_count = stripslashes($line["read_count"]);
                    $category_id = $line["category_id"];
                    $news_title = strip_tags(stripslashes($line["title_" . $lang]));
                    $content = stripslashes($line["content_" . $lang]);
                    $spiker = stripslashes($line["spiker_" . $lang]);
                    $unvan = stripslashes($line["unvan_" . $lang]);
                    $map = stripslashes($line["map"]);
                    $img = stripslashes($line["img"]);
                    $create_date1 = date('Ymd\THis\Z', strtotime($line["ilk_date"]));
                    $create_date2 = date('Ymd\THis\Z', strtotime($line["son_date"]));
                    if ($img) $img = "/imageg_750_500_" . $img . "_tedbir_" . $category_id . ".jpg";
                    $catname = $db_link->where('id', $category_id)->getValue("category", "name_$lang");
                }        

                $ics = new ICS(array(
                    'location' => $map,
                    'description' => $content,
                    'dtstart' => $create_date1,
                    'dtend' => $create_date2,
                    'summary' => $news_title,
                    'url' => "http://$siteName/$lang/opentedbir/$cid.html"
                ));

                file_put_contents("organicfood.ics", $ics->to_string()); 

                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                $mail->isSendmail();                                   
                $mail->CharSet = 'utf-8';                                   // TCP port to connect to

                //Recipients
                $mail->setFrom('araz.yusifoglu@gmail.com', 'Aqroservis ASC');
                $mail->addAddress($_POST['email'], 'Aqroservis ASC');     // Add a recipient

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Aqroservis ASC';
                $mail->Body = "Tədbirin adı: $news_title<br> Ünvan: $unvan<br> Tarix: {$line['ilk_date']} - {$line['son_date']}<br>"; 
                $mail->AddAttachment('organicfood.ics' , 'organicfood.ics', 'base64', 'text/calendar'); 
                //$mail->addStringAttachment($icscontent, 'organicfood.ics');
                $mail->send();
                //echo 'Message has been sent';

                $successss= "Sorğunuz göndərildi.<br>";


            } catch (Exception $e) {
                $RegError='Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            }        
        }else{
            $RegError="Bütün bölmələri doldurun"; 
        }
    }

}

function siteConfig($name){
    global $db_link,$seo,$seo1,$cid,$lang;
    return $db_link->where("title", $name)->getValue("siteconfig", "value");  
}

function ip_to_country($db_link){
    $ip=ip2long($_SERVER['REMOTE_ADDR']); 
    $db_link->where ('IP_FROM', $ip,"<=");
    $db_link->where ('IP_TO', $ip,">="); 
    return $db_link->getValue("ip_to_country", "CTRY");
}

function token_aktive_user($token) {
    global $lang;
    if($token){
        $db_link->where ("aktive_token", $token);
        $userinfo = $db_link->getOne ("channels");
        if($db_link->count>0) { 
            $_SESSION['access_key']=md5(yazi(25));
            $_SESSION['username'] = $userinfo['email'];
            $_SESSION['global_flag'] = $userinfo['global_flag'];
            $_SESSION['privilege'] = $userinfo['privilege'];
            $_SESSION['name'] = $userinfo['name'];
            $_SESSION['logo'] = $userinfo['logo'];
            $_SESSION['description'] = $userinfo['description'];
            $_SESSION['userid'] = $userinfo['id'];
            $_SESSION['machine'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['loggedin']=true;
            $_SESSION['project']='sayt';

            $data = Array (
                'last_enter' => $userinfo['now_enter'],
                'last_ip' => $userinfo['now_ip'],
                'now_enter' => $db_link->now(),
                'now_ip' => $_SESSION['machine']
            );

            $db_link->where ('id', $userinfo['id']); 
            $db_link->update('channels',$data);
            echo "<script>window.location.href='/$lang/main/index.html';</script>";
            exit;
        }
    }
}

function change_lang($new_lang) {
    global $lang,$page;
    if($page=='main')
        return "/$new_lang/main/";    
    else
        return str_replace('/'.$lang.'/','/'.$new_lang.'/',$_SERVER['REQUEST_URI']);
}

function update_menyu($db_link,$lang){
    /*$cat_menyus = $db_link->get('category');
    foreach ($cat_menyus as $line) {
    $id = $line["id"];
    $ad = stripslashes($line["name_".$lang]);
    $update_data = array(
    'seo' => url_slug($ad),
    );       
    $db_link->where ('id', $id)->update ('category', $update_data);
    }

    $cat_menyus = $db_link->get('vimeo');
    foreach ($cat_menyus as $line) {
    $id = $line["id"];
    $ad = stripslashes($line["name"]);
    $update_data = array(
    'seo' => url_slug($ad),
    );       
    $db_link->where ('id', $id)->update ('vimeo', $update_data);
    } */

    $cat_menyus = $db_link->get('channels');
    foreach ($cat_menyus as $line) {
        $id = $line["id"];
        $ad = stripslashes($line["name"]);
        $update_data = array(
            'seo' => url_slug($ad),
        );       
        $db_link->where ('id', $id)->update ('channels', $update_data);
    }
}
//update_menyu($db_link,$lang);

function combo_mapCategory($lang,$db_link){
    global $cl_showall;
    $cat_menyus = $db_link->get('map_category');
    print "<select class='form-select form-select-lg mb-3' id='my-select' aria-label='.form-select-lg example' style='width: 100%; margin: 0 0 30px 30px !important;
    padding: 10px;'><option value='all'> $cl_showall</option>";    
    foreach ($cat_menyus as $line) {
        $id = $line["country_id"];
        $ad = stripslashes($line["title_".$lang]);
        print "<option value='$ad'>$ad</option>";
    } 
    print "</select>";     
}

function combo_menyu($cid,$category_id,$lang,$db_link){
    global $b_read_more;
    $db_link->where ('sub_id', $cid);
    $db_link->where ('status', 'active');
    $db_link->orderby ('blok', 'asc');
    $cat_menyus = $db_link->get('category');
    foreach ($cat_menyus as $line) {
        $id = $line["id"];
        $ad = stripslashes($line["name_".$lang]);
        $i++;     if($i==1) $col=" in"; else $col=""; 
        $content = $db_link->where("category_id", $id)->getValue ("content", "content_".$lang);
        $content = explode("<!-- pagebreak -->", $content);
        print "<div class='panel panel-default'>
        <div class='panel-heading'>
        <div class='panel-title'>
        <a data-toggle='collapse' data-parent='#accordionTwo' href='#collapseTwo$i' class='btn btn-block accord uk-text-left'><h4 class='accord-title'> $ad </h4></a>
        </div>
        </div>
        <div id='collapseTwo$i' class='panel-collapse collapse $col'>
        <div class='panel-body'>
        <p>{$content[0]}</p>
        <div><a class='uk-button uk-button-primary' href='/$lang/content/$id.html'>$b_read_more</a></div>
        </div>
        </div>
        </div>";
    } 

}

function chek_menyu($cid,$category_id,$lang,$db_link){
    $db_link->where ('sub_id', $cid);
    $db_link->where ('status', 'active');
    $db_link->orderby ('blok', 'asc');
    $cat_menyus = $db_link->get('category');
    $cids = explode(",", $category_id);
    foreach ($cat_menyus as $line) {
        print "<div class='col-lg-2'><div class='checkbox'><label><label class='checkbox'>";
        $id = $line["id"];
        $ad = stripslashes($line["name_".$lang]);
        if (in_array($id, $cids))
            print "<input class='form-control' name='category[]' type='checkbox' value='$id' checked>";
        else
            print "<input class='form-control' name='category[]' type='checkbox' value='$id'>";
        print "<span class='arrow'></label></span>$ad </label></div></div>";    
    }


} 

function top_menyu($top,$lang,$db_link){
    $db_link->where ('ust', 1);
    $db_link->where ('status', 'active');
    $db_link->orderby ('blok', 'asc');
    $cat_menyus = $db_link->get('category');

    foreach ($cat_menyus as $line) {
        $id = $line["id"];
        $ad = $line["name_".$lang];
        $seo = $line["seo"];
        $m_type = $line["type"];
        $slinks ="/$lang/content/$id/$seo.html";

        if($top==1) print "<a href='$slinks' class='haqq'>$ad</a>";
        else print "<li><a href='$slinks'>$ad</a></li>";
    }
} 

function mobil_menyu($lang,$db_link){
    global $cid;
    global $home;
    $db_link->where ('sub_id', 0);
    $db_link->where ('status', 'active');
    $db_link->orderby ('blok', 'asc');
    $cat_menyus = $db_link->get('category');
    //if(empty($cid)) $hom="active";
    //print "<li class='menu-item $hom'> <a href='/'>$home</a> </li>";
    foreach ($cat_menyus as $line) {
        $id = $line["id"];
        $ad = $line["name_".$lang];
        $m_type = $line["type"];
        $slinks ="/$lang/$m_type/$id.html";
        $sub=$db_link->where ('sub_id', $id)->where ('status', 'active')->getValue ("category", "count(id)");
        if($id==$cid) $hom="current"; else $hom="";
        if($sub){
            print "<li class='active deeper parent $hom'><a href='javascript:void(0);'>$ad</a>";
            print "<ul class=\"nav-child unstyled small\">";
            sub_menyu($id,$lang,$db_link);
            print "</ul></li>";
        }else{
            print "<li class='active deeper parent $hom'><a href='$slinks'>$ad</a></li>";
        }
    }
}

function mobil_ust_menyu($lang, $db_link){
    global $cid,$home,$dil;
    $db_link->where('sub_id', 0);
    $db_link->where('status', 'active');
    $db_link->orderby('blok', 'asc');
    $cat_menyus = $db_link->get('category');
    if (empty($cid)) $hom = "active";

    foreach ($cat_menyus as $line) {
        $id = $line["id"];
        $ad = $line["name_" . $lang];
        $link = $line["link_" . $lang];
        $m_type = $line["type"];
        if($link) $slinks=$link; else $slinks = "/$lang/$m_type/$id.html";
        $sub = $db_link->where('sub_id', $id)->where('status', 'active')->getValue("category", "count(id)");
        if ($id == $cid) $hom = "active"; else $hom = "";
        if ($sub) {
            print "<li class='menu-icon'><a href='#' id='navbarDropdown$id'>$ad</a>";
            mobil_sub_menyu($id, $lang, $db_link);
            print "</li>";
        } else { 
            print "<li><a href='$slinks'>$ad</a></li>";
        }
    }

}

function mobil_sub_menyu($cid, $lang, $db_link){
    $cat_menyus = $db_link->where('sub_id', $cid)->where('status', 'active')->orderby('blok', 'asc')->get("category");
    print "<ul class='sub-menu'>";
    foreach ($cat_menyus as $line) {
        $id = $line["id"];
        $ad = $line["name_" . $lang];
        $m_type = $line["type"];
        $link = $line["link_" . $lang];
        if($link) $slinks=$link; else $slinks = "/$lang/$m_type/$id.html";
        $sub=$db_link->where ('sub_id', $id)->where ('status', 'active')->getValue ("category", "count(id)");

        if($sub){
            print "<li><a href='#'>$ad</a>";
            sub_sub_menyu($id,$lang,$db_link);
            print "</li>";
        }else
            print "<li><a href='$slinks'>$ad</a></li>";        

        //print "<li><a href='$slinks' >$ad</a></li>";
    }
    print "</ul>";
}

function alt_menyu($lang, $db_link){
    global $cid,$home,$dil;
    $db_link->where('sub_id', 0);
    $db_link->where('status', 'active');
    $db_link->where('type', 'katalog','<>');
    $db_link->orderby('blok', 'asc');
    $cat_menyus = $db_link->get('category');
    if (empty($cid)) $hom = "active";
    print "<ul class='footer_main-block_nav'>";
    foreach ($cat_menyus as $line) {
        $id = $line["id"];
        $ad = $line["name_" . $lang];
        $m_type = $line["type"];
        $slinks = "/$lang/$m_type/$id.html";
        print "<li class='list-item'><a class='nav-link link' href='$slinks'>$ad</a></li>";
    }
    print "</ul>";
}

function ust_menyu($lang,$db_link){
    global $cid;
    global $home;
    $db_link->where ('sub_id', 0);
    $db_link->where ('status', 'active');
    $db_link->orderby ('blok', 'asc');
    $cat_menyus = $db_link->get('category');
    //if(empty($cid)) $hom="active";
    //print "<li class='menu-item $hom'> <a href='/'>$home</a> </li>";
    foreach ($cat_menyus as $line) {
        $id = $line["id"];
        $ad = $line["name_".$lang];
        $link = $line["link_".$lang];
        $alias = $line["alias_".$lang];
        $m_type = $line["type"];
        if($link) $slinks=$link; else $slinks ="/$lang/$m_type/$alias";
        $sub=$db_link->where ('sub_id', $id)->where ('status', 'active')->getValue ("category", "count(id)");

        if($sub){
            print "<li class='dropdown'><a href='#'>$ad</a>";
            sub_menyu($id,$lang,$db_link);
            print "</li>";
        }else{
            print "<li><a href='$slinks'>$ad</a></li>";
        }
    }
}

function sub_menyu($cid,$lang,$db_link){
    global $home,$subid;
    $db_link->where ('sub_id', $cid);
    $db_link->orderby ('blok', 'asc');
    $cat_menyus = $db_link->get('category');
    print "<ul>";
    foreach ($cat_menyus as $line) {
        $id = $line["id"];
        $ad = $line["name_".$lang];
        $m_type = $line["type"];
        $alias = $line["alias_".$lang];
        $link = $line["link_".$lang];       
        if($link) $slinks=$link; else $slinks ="/$lang/$m_type/$alias";

        print "<li><a href='$slinks'> $ad </a></li>";
    }
    print "</ul>";
}

function sub_menyu_news($cid,$lang,$db_link){
    global $home,$subid;
    $db_link->where ('category_id', $cid);
    $db_link->where ('status', 'active');
    $db_link->orderby ('sira', 'asc');
    $cat_menyus = $db_link->get('news');
    print "<div class='dropdown-menu collapse' id='pages$cid'><ul class='dropdown-list'>";
    foreach ($cat_menyus as $line) {
        $id = $line["id"];
        $ad = $line["title_".$lang];
        $m_type = $line["type"];
        $nlink="/$lang/opennews/$id.html";
        print "<li class='list-item'><a class='dropdown-item nav-item' href='$nlink'> $ad </a></li>";
    }
    print "</ul></div>";
}  

function home_content_menyu($cid,$lang,$db_link){
    $catname=$db_link->where ('id', $cid)->getValue ("category", "name_$lang");
    $sub = $db_link->subQuery();
    $sub->where("sub_id", $cid)->where ('status', 'active');
    $sub->get ("category", null, 'id');
    $db_link->where ('category_id', $sub,'in');
    $cat_menyus = $db_link->get('content');
    $tbl_category_img = $db_link->where("id", $cid)->getValue ("category", "img1");
    if($tbl_category_img) $tbl_category_img="/uploads/menyu/$tbl_category_img"; else $tbl_category_img="/images/background/1.jpg"; 
    //print $db_link->getLastQuery();
    print "<section class='services-section' style='margin-bottom: 80px;background-image: url($tbl_category_img);'>
    <div class='auto-container'>
    <div class='sec-title light'>
    <h2>$catname</h2>
    </div>

    <div class='services-carousel owl-carousel owl-theme'>";
    foreach ($cat_menyus as $line) {
        $id = $line["id"];
        $ad = $line["name_".$lang];
        $p_title = $line["p_title"];
        $content =  strip_tags(substr(strip_tags(stripslashes($line["content_".$lang])),0,70)) ;
        $slinks ="/$lang/content/$id.html";
        $img = stripslashes($line["img"]);
        if($img)$img="/uploads/content/$img"; else $img="/no_image.png";

        print "<div class='service-block'>
        <div class='inner-box'>
        <div class='image-box'>
        <figure><img src='$img' alt='$ad'></figure>
        <div class='overlay-box'>
        <a href='$slinks'><div class='text'>$p_title </div></a>

        </div>
        </div>
        <div class='caption-box'>
        <div class='caption'>
        <h3><a href='$slinks'>$ad</a></h3>
        </div>
        </div>
        </div>
        </div>";

    }
    print "</div>
    </div>
    </section>";
}  

function home_tur($category_id,$lang,$db_link){
    global $starts;
    $catname=$db_link->where ('id', $category_id)->getValue ("category", "alias_$lang");
    $tbl_news = $db_link->where('category_id', $category_id)->orderBy("id","desc")->get('news',array(0,5));
    foreach ($tbl_news as $line) {  
        $nomre = $line["id"];
        $alias = $line["alias_".$lang];
        $date = $line["date_".$lang];
        $content_s= $line["content_s_".$lang];
        $category_id = $line["category_id"];
        $price = $line["price"];
        $create_date = $line["news_date"];
        if($create_date=="0000-00-00")
            $create_date="";
        else  
            $create_date = getTheDay($create_date);

        $basliq = stripslashes($line["title_".$lang]);
        $read_count = stripslashes($line["read_count"]);
        $nlink="/$lang/category/$catname/$nomre/$alias";
        $img = stripslashes($line["img"]);
        if($img)$img="/imageg_350_400_".$img."_news_".$category_id.".jpg"; else $img="/no_image.png";

        print "<div class='package-block'>
        <div class='inner-box'>
        <div class='image-box'>
        <div class='image'><a href='$nlink'><img src='$img' alt='$basliq'></a></div>
        </div>
        <div class='lower-box'>
        <div class='location'>$basliq</div>
        <h5><a href='$nlink'>$content_s</a></h5>
        <div class='info clearfix'>
        <div class='duration'><i class='fa fa-clock'></i> $date</div>
        </div>
        <div class='bottom-box clearfix'>
        <div class='price'>$starts &ensp;<span class='amount'>$price</span></div>
        </div>
        </div>
        </div>
        </div>";
    }
}

function home_news($category_id,$lang,$db_link){
    $catname=$db_link->where ('id', $category_id)->getValue ("category", "alias_$lang");
    $tbl_news = $db_link->where('category_id', $category_id)->orderBy("id","desc")->get('news',array(0,3));
    foreach ($tbl_news as $line) {  
        $i++;
        $contents="";
        $nomre = $line["id"];
        $alias = $line["alias_".$lang];
        $content_s= $line["content_s_".$lang];
        $category_id = $line["category_id"];
        $create_date = $line["news_date"];
        if($create_date=="0000-00-00")
            $create_date="";
        else  
            $create_date = getTheDay($create_date);

        $basliq = stripslashes($line["title_".$lang]);
        $read_count = stripslashes($line["read_count"]);
        $nlink="/$lang/articles/$catname/$nomre/$alias";
        $img = stripslashes($line["img"]);
        if($img)$img="/imageg_350_400_".$img."_articles_".$category_id.".jpg"; else $img="/no_image.png";

        print "<div class='col-lg-4 wow fadeInUp' data-wow-delay='0s'>
        <div class='post-box'>
        <figure> <a href='$nlink'><img src='$img' class='bloqsekil' alt='Image'></a> </figure>
        <span>$create_date</span>
        <h6><a href='$nlink'>$basliq</a></h6>
        <p>$content_s</p>
        </div>
        </div>";
    }
}

function getFileType($file){
    if (function_exists('finfo_open')) {
        if ($info = finfo_open(defined('FILEINFO_MIME_TYPE') ? FILEINFO_MIME_TYPE : FILEINFO_MIME)) {
            $mimeType = finfo_file($info, $file);
        }
    } elseif (function_exists('mime_content_type')) {
        $mimeType = mime_content_type($file);
    }
    if (strstr($mimeType, 'image/')) {
        return 'image';
    } else if (strstr($mimeType, 'video/')) {
        return 'video';
    } else if (strstr($mimeType, 'audio/')) {
        return 'audio';
    } else if (strstr($mimeType, 'application/msword')) {
        return 'word';
    } else if (strstr($mimeType, 'application/vnd.ms-excel')) {
        return 'excel';
    } else if (strstr($mimeType, 'application/vnd.ms-powerpoint')) {
        return 'powerpoint';
    } else if (strstr($mimeType, 'application/pdf')) {
        return 'pdf';
    } else {
        return null;
    }
}

if(!function_exists('mime_content_type')) {
    function mime_content_type($filename) {
        $mime_types = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
}

function files($category_id,$seh,$lang,$db_link){
    global $siteName,$home; 
    $catname=$db_link->where ('id', $category_id)->getValue ("category", "name_$lang");
    print "
    <section class='title'><div class='container'><h1 class='wow fadeIn' data-wow-delay='0.1s'>$catname</h1></div></section>
    <section id='pdf'><div class='container'><div class='row'>
    ";
    $db_link->pageLimit = 8;
    $tbl_news = $db_link->arraybuilder()->where('m_id', $category_id)->orderBy("id","desc")->paginate("files", $seh);
    $totalpage=$db_link->totalPages;    

    foreach ($tbl_news as $line) {  
        $i++;
        $nomre = $line["id"];
        $create_date = getTheDay($line["news_date"]);
        $basliq = stripslashes($line["name_".$lang]);
        $read_count = stripslashes($line["read_count"]);
        $file = stripslashes($line["file_az"]);
        $content =  strip_tags(substr(strip_tags(stripslashes($line["content_".$lang])),0,300)) ;
        $nlink="http://$siteName/uploads/files/$category_id/$file";
        $FileType=getFileType("uploads/files/$category_id/$file");
        $gview="https://docs.google.com/gview?url=";
        if($nlink) $nlink=$gview.$nlink."&embedded=true"; 

        $img = stripslashes($line["img"]);
        if($img)$img="/imageg_300_200_".$img."_news_".$category_id.".jpg"; else $img="/no_image.png";

        print "<div class='col-md-4 wow fadeInUp' data-wow-delay='0.".$i."s'><a target='_blank' href='$nlink'><div class='hovicon effect-8 icon-pdf'><span>$basliq</span></div></a></div>";
    }
    print "</div>";
    print "</div>";
    print "</section>";

}


function next_news_blok($cid, $lang, $db_link){
    global $b_read_more;
    $catname=$db_link->where ('id', $cid)->getValue ("category", "name_$lang");
    print "<section class='home-projects'>
    <div class='container'>
    <div class='section-title d-flex flex-wrap align-items-center '>
    <h2 class='mb-3 mr-4'>$catname</h2>
    <a href='/$lang/news/$cid.html' class='btn btn-primary mb-3'>Bütün xəbərlər <i class='icomoon-right-arrow-long'></i></a>
    </div>
    <div class='row'>
    ";

    $tbl_news = $db_link->where('category_id', $cid)->orderBy("RAND ()")->get('news', array(0, 3));
    foreach ($tbl_news as $line) {
        $nomre = $line["id"];
        $create_date = getTheDay($line["news_date"]);
        $basliq = stripslashes($line["title_" . $lang]);
        $content = explode("<!-- pagebreak -->", $line["content_" . $lang]);
        $read_count = stripslashes($line["read_count"]);
        $nlink = "/$lang/opennews/$nomre.html";
        $img = stripslashes($line["img"]);
        $category_id = stripslashes($line["category_id"]);
        if ($img) $img = "/imageg_420_330_" . $img . "_news_" . $category_id . ".jpg"; else $img = "/no_image.png";
        $catname = $db_link->where('id', $category_id)->getValue("category", "name_$lang");

        print "<div class='col-md-4 project-item'>
        <div class='slide-image-wrap'>
        <a href='$nlink' class='project-item__img-link'><img src='$img' alt='' class='project-item__img'></a>
        </div>
        <h4 class='project-item__title'><a href='$nlink'>$basliq</a></h4>
        <div class='project-item__loc'>$create_date</div>
        </div>";
    }

    print "</div>
    </div>
    </section>";
}

function xeberler($cid,$page,$lang,$db_link){
    global $b_read_more,$home,$subid;
    $tbl_category = $db_link->where("alias_" . $lang, $cid)->getOne('category'); 
    //print $db_link->getLastQuery();
    if ($tbl_category["img1"]) {
        $tbl_category_img = "/uploads/menyu/".$tbl_category["img1"];
        $bg_style=" style='background: url($tbl_category_img) top left no-repeat; background-repeat: no-repeat; background-size: 100%;'";
    }else{
        $tbl_category_img="/images/slide01.jpg";
        $bg_style="";
    }

    print "<header class='page-header' data-background='$tbl_category_img' data-stellar-background-ratio='1.15'>
    <div class='container'>
    <h1>{$tbl_category["name_" . $lang]}</h1>
    <ol class='breadcrumb'>
    <li class='breadcrumb-item'><a href='/'>$home</a></li>
    <li class='breadcrumb-item'><a href='#'>{$tbl_category["name_" . $lang]}</a></li>
    </ol>
    </div>
    </header>";

    print "<section class='recent-posts'>
    <div class='container'>
    <div class='row'>";

    print "<div class='col-12 wow fadeInUp'><h4><span>{$tbl_category["name_" . $lang]}</span></h4></div>";
    $pageLimit=8;
    $db_link->pageLimit = $pageLimit;
    $tbl_news = $db_link->withTotalCount()->arraybuilder()->where('category_id', $tbl_category["id"])->orderBy("sira","asc")->paginate("news", $page);

    $totalpage=$db_link->totalPages;
    $total_records = $db_link->totalCount;
    foreach ($tbl_news as $line) {  
        $i++;
        $contents="";
        $nomre = $line["id"];
        $date = $line["date_".$lang];
        $alias = $line["alias_".$lang];
        $content_s= $line["content_s_".$lang];
        $category_id = $line["category_id"];
        $create_date = $line["news_date"];
        if($create_date=="0000-00-00")
            $create_date="";
        else  
            $create_date = getTheDay($create_date);

        $basliq = stripslashes($line["title_".$lang]);
        $read_count = stripslashes($line["read_count"]);
        $nlink="/$lang/articles/$cid/$nomre/$alias";
        $img = stripslashes($line["img"]);
        if($img)$img="/imageg_350_400_".$img."_articles_".$category_id.".jpg"; else $img="/no_image.png";

        print "<div class='col-lg-4 wow fadeInUp' data-wow-delay='0.10s'>
        <div class='post-box'>
        <figure> <a href='$nlink'><img src='$img' class='bloqsekil' alt='Image'></a> </figure>
        <span>$create_date</span>
        <h6><a href='$nlink'>$basliq</a></h6>
        <p>$content_s</p>
        </div>
        </div>";

    }


    print "</div>";
    if($totalpage>1){
        print "<div class='styled-pagination centered'>";
        print pagination($total_records, $pageLimit, $page, "/$lang/news/$category_id/%d.html");
        print "</div>";
    }
    /*    
    <ul class='clearfix'>
    <li class='active'><a href='#'>1</a></li>
    <li><a href='#'>2</a></li>
    <li><a href='#'>3</a></li>
    <li><a href='#'><i class='fa fa-angle-right'></i></a></li>
    </ul>  */
    print "
    </div>
    </div>
    </section>";
}




function home_multimedia($cid,$lang,$db_link){
    global $b_read_more,$home,$subid;
    $tbl_news = $db_link->arraybuilder()->where('category_id', $cid)->orderBy("sira","asc")->get("multimedia", $page);
    foreach ($tbl_news as $line) {  
        $i++;
        $contents="";
        $nomre = $line["id"];
        $category_id = $line["category_id"];
        $alias = stripslashes($line["alias_".$lang]);
        $basliq = stripslashes($line["name_".$lang]);
        $read_count = stripslashes($line["read_count"]);
         $catname=$db_link->where ('id', $cid)->getValue ("category", "alias_$lang");
        $nlink="/$lang/multimedia/$catname/$nomre/$alias";
        $img = stripslashes($line["img"]);
        if($img)$img="/uploads/$img"; else $img="/no_image.png";

        print "<div class='col-md-3 wow fadeInUp' data-wow-delay='0s'>
        <figure  ><a href='$nlink' class='imghov' ><img src='$img' alt='Image'>
        <p class='gallerytext'>$basliq</p></a></figure>
        </div>";
    }
}


function multimedia($cid,$page,$lang,$db_link){
    global $b_read_more,$home,$subid;
    $tbl_category = $db_link->where("alias_" . $lang, $cid)->getOne('category');
    if ($tbl_category["img1"]) {
        $tbl_category_img = "/uploads/menyu/".$tbl_category["img1"];
        $bg_style=" style='background: url($tbl_category_img) top left no-repeat; background-repeat: no-repeat; background-size: 100%;'";
    }else{
        $tbl_category_img="/images/slide01.jpg";
        $bg_style="";
    }

    print "<header class='page-header' data-background='$tbl_category_img' data-stellar-background-ratio='1.15'>
    <div class='container'>
    <h1>{$tbl_category["name_" . $lang]}</h1>
    <ol class='breadcrumb'>
    <li class='breadcrumb-item'><a href='/'>$home</a></li>
    <li class='breadcrumb-item'><a href='#'>{$tbl_category["name_" . $lang]}</a></li>
    </ol>
    </div>
    </header>";

    print "<section class='recent-gallery'>
    <div class='container'>
    <div class='row align-items-center'  style='justify-content: center;'>";

    print "<div class='col-lg-12'><div class='row inner' style='row-gap: 2rem;'>";
    $pageLimit=8;
    $db_link->pageLimit = $pageLimit;
    $tbl_news = $db_link->withTotalCount()->arraybuilder()->where('category_id', $tbl_category["id"])->orderBy("sira","asc")->paginate("multimedia", $page);
    $totalpage=$db_link->totalPages;
    $total_records = $db_link->totalCount;
    foreach ($tbl_news as $line) {  
        $i++;
        $contents="";
        $nomre = $line["id"];
        $category_id = $line["category_id"];
        $alias = stripslashes($line["alias_".$lang]);
        $basliq = stripslashes($line["name_".$lang]);
        $read_count = stripslashes($line["read_count"]);
        $nlink="/$lang/multimedia/$cid/$nomre/$alias";
        $img = stripslashes($line["img"]);
        if($img)$img="/uploads/$img"; else $img="/no_image.png";

        print "<div class='col-md-3 col-6 wow fadeInUp' data-wow-delay='0s'>
        <figure ><a href='$nlink' class='imghov' >
        <img src='$img' alt='Image'>
        <p class='gallerytext'>$basliq</p></a></figure>
        </div>";
    }


    print "</div>";
    print "</div>";
    if($totalpage>1){
        print "<div class='styled-pagination centered'>";
        print pagination($total_records, $pageLimit, $page, "/$lang/news/$category_id/%d.html");
        print "</div>";
    }
    /*    
    <ul class='clearfix'>
    <li class='active'><a href='#'>1</a></li>
    <li><a href='#'>2</a></li>
    <li><a href='#'>3</a></li>
    <li><a href='#'><i class='fa fa-angle-right'></i></a></li>
    </ul>  */
    print "
    </div>
    </section>";
}

function multimedia_ac($cid,$lang,$db_link){
    global $b_read_more,$home,$subid;
    $tbl_multimedia = $db_link->where("id", $cid)->getOne('multimedia');
    $tbl_category = $db_link->where("id", $tbl_multimedia['category_id'])->getOne('category');
    if ($tbl_category["img1"]) {
        $tbl_category_img = "/uploads/menyu/".$tbl_category["img1"];
        $bg_style=" style='background: url($tbl_category_img) top left no-repeat; background-repeat: no-repeat; background-size: 100%;'";
    }else{
        $tbl_category_img="/images/slide01.jpg";
        $bg_style="";
    }

    print "<header class='page-header' data-background='$tbl_category_img' data-stellar-background-ratio='1.15'>
    <div class='container'>
    <h1>{$tbl_multimedia["name_" . $lang]}</h1>
    <ol class='breadcrumb'>
    <li class='breadcrumb-item'><a href='/'>$home</a></li>
    <li class='breadcrumb-item'><a href='#'>{$tbl_category["name_" . $lang]}</a></li>
    <li class='breadcrumb-item'><a href='#'>{$tbl_multimedia["name_" . $lang]}</a></li>
    </ol>
    </div>
    </header>";

    print "<section class='recent-gallery'>
    <div class='container'>
    <div class='row align-items-center'  style='justify-content: center;'>";

    print "<div class='col-lg-12'><div class='row inner' style='row-gap: 2rem;'>";
    $tbl_news = $db_link->where('m_id', $cid)->orderBy("sira","asc")->get("multimedia_file");
    //print $db_link->getLastQuery();
    foreach ($tbl_news as $line) {  
        $i++;
        $contents="";
        $nomre = $line["id"];
        $category_id = $line["category_id"];
        $alias = stripslashes($line["alias_".$lang]);
        $basliq = stripslashes($line["name_".$lang]);
        $nlink="/$lang/multimedia/$cid/$nomre/$alias";
        $img = stripslashes($line["file"]);
        if($img)$img="/uploads/$img"; else $img="/no_image.png";

        print "<div class='one col-md-3'>
        <a href='' data-toggle='modal' data-target='#largeModal'>
        <img src='$img' alt='Image'/></a></div>";
    }

    print "<div class='modal fade' id='largeModal' tabindex='-1' role='dialog' aria-labelledby='basicModal' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
    <div class='modal-content' style='background: none; border: none;'>
    <div class='modal-body'>
    <div id='carousel' class='carousel slide' data-ride='carousel'>

    <div class='carousel-inner'>";
    foreach ($tbl_news as $line) {  
        $i++;
        $img = stripslashes($line["file"]);
        if($img)$img="/uploads/$img"; else $img="/no_image.png";
        print "<div class='carousel-item'>
        <img class='img-size' src='$img' alt='First slide' />
        </div>";
    }
    print "</div>
    <a class='carousel-control-prev' href='#carousel' role='button' data-slide='prev' >
    <span class='carousel-control-prev-icon'aria-hidden='true'></span>
    <span class='sr-only'>Previous</span>
    </a>
    <a
    class='carousel-control-next' href='#carousel' role='button' data-slide='next' >
    <span     class='carousel-control-next-icon'     aria-hidden='true'     ></span>
    <span class='sr-only'>Next</span>
    </a>
    </div>
    </div>

    </div>
    </div>
    </div>";


    print "</div>";
    print "</div>";


    print "
    </div>
    </section>";
}

function blok_news($category_id,$cid,$lang,$db_link){
    $catname=$db_link->where ('id', $category_id)->getValue ("category", "name_$lang");
    $tbl_news = $db_link->where('id', $cid,'<>')->where('category_id', $category_id)->orderBy("id","desc")->get('news',array(0,3));
    foreach ($tbl_news as $line) {  
        $nomre = $line["id"];
        $create_date = getTheDay($line["news_date"]);
        $basliq = stripslashes($line["title_".$lang]);
        $content =  stripslashes($line["content_s_".$lang]);
        $alias = $line["alias_".$lang];
        $category_id = $line["category_id"];

        $basliq = stripslashes($line["title_".$lang]);
        $read_count = stripslashes($line["read_count"]);
        $nlink="/$lang/articles/$cid/$nomre/$alias";

        $img = stripslashes($line["img"]);
        if($img)$img="/imageg_500_300_".$img."_articles_".$category_id.".jpg"; else $img="/no_image.png";
        print "<div class='col-lg-12 row wow fadeInUp' data-wow-delay='0.10s'>
        <div class='post-box'>
        <figure> <img src='$img' class='bloqsekil' alt='Image'> </figure>
        <span class='diger'>$create_date</span>
        <h6><a href='$nlink' class='digera'>$basliq</a></h6>
        <p>$content</p>
        </div>
        </div>";
    }
}

function xeber_ac($cid,$lang,$db_link){
    global $home,$security_test,$alias,$other,$sonxeber;

    $tbl_content = $db_link->where ('id', $cid)->where ('alias_'.$lang, $alias)->getOne('news');
    $nomre = $tbl_content["id"];
    if (!$nomre) {
        print "<meta http-equiv=\"refresh\" content=\"1; url='/404.html'\" />"; exit;
    }
    $create_date = getTheDay($tbl_content["news_date"]);
    $tbl_category_id = $tbl_content["category_id"];

    $tbl_category = $db_link->where("id", $tbl_category_id)->getValue ("category", "name_".$lang);
    $tbl_category_img = $db_link->where("id", $tbl_category_id)->getValue ("category", "img1");
    if($tbl_category_img) $tbl_category_img="/uploads/menyu/$tbl_category_img"; else $tbl_category_img="/img/placeholder.jpg";
    if($tbl_content["img"])$img="/imageg_900_900_".$tbl_content["img"]."_articles_".$tbl_category_id.".jpg"; else $img="/no_image.png";

    print "<header class='page-header' data-background='$tbl_category_img' data-stellar-background-ratio='1.15'>
    <div class='container'>
    <h1>{$tbl_category}</h1>
    <ol class='breadcrumb'>
    <li class='breadcrumb-item'><a href='/'>$home</a></li>
    <li class='breadcrumb-item'><a href='#'>{$tbl_category}</a></li>
    </ol>
    </div>
    </header>";    

    print "<section class='blog'>
    <div class='container'>
    <div class='row'>
    <div class='col-lg-8'>";

    print "<div class='post'>
    <figure class='post-image'>
    <img src='$img' alt='Image'>
    </figure>
    <div class='post-content single'>
    <h2 class='post-title'>{$tbl_content["title_" . $lang]}</h2>

    {$tbl_content["content_" . $lang]}
    </div>
    </div>";             
    print "</div>";



    print "<div class='col-lg-4'>
    <aside class='sidebar' style='height: auto; overflow-y: auto;'>
    <div class='widget'>
    <h4 class='title'>$sonxeber</h4>";

    blok_news($tbl_category_id,$cid,$lang,$db_link);

    print "<div class='widget'>
    </aside>
    </div>";   


    /*
    print "<header class='page primary-bg'>
    <div class='container'>
    <div class='section_header'>
    <span class='subtitle subtitle--extended'>$tbl_category</span>
    <h1 class='title'>{$tbl_content["title_" . $lang]}</h1>
    <ul class='breadcrumbs'>
    <li class='breadcrumbs_item'><a href='/'>$home</a></li>
    <li class='breadcrumbs_item breadcrumbs_item--current'><span>$tbl_category</span></li>
    </ul>
    </div>
    </div>
    <div class='media'>
    <picture>
    <source data-srcset='$tbl_category_img' srcset='$tbl_category_img' type='image/webp' />
    <img class='lazy' data-src='$tbl_category_img' src='$tbl_category_img' alt='media' />
    </picture>
    </div>
    </header>"; */

    /*    print "<section class='features section post'>
    <div class='container'>
    <p class='spots_info-text'>{$tbl_content["content_" . $lang]}</p>
    </div>
    <div class='project-single__gallery js-gallery fade-from-top-children'>";
    $catname = $db_link->where('id', $category_id)->getValue("category", "name_$lang");
    $tbl_news_photos = $db_link->withTotalCount()->where('m_id', $nomre)->get('news_photos');
    $totalCount=$db_link->totalCount;   
    if($totalCount>0){
    foreach ($tbl_news_photos as $photos) {
    $file = stripslashes($photos["file"]);
    $file = "/imageg_1200_1200_" . $file . "_newsphotos_" . $nomre . ".jpg";
    print "<a class='grid-item' href='$file'><div class='slide-image-wrap'><img src='$file' alt=''></div></a>";
    }
    }else{
    print "<a class='grid-item' href='$file'><div class='slide-image-wrap'><img src='$file' alt=''></div></a>";
    } 
    print "</div></section>";*/    

    $db_link->where('id', $cid)->update('news', array( 'read_count' => $db_link->inc(1)));

    print "
    </div>
    </div>
    </section>";

    //home_content_s(12,$lang,$db_link);

}

function home_content($cid,$lang,$db_link){
    global $home,$subid;
    $tbl_content = $db_link->where ('id', $cid)->get('content');
    foreach ($tbl_content as $content) {
        $id = $content["id"];
        $name = $content["name_".$lang];
        $text = strip_tags(stripslashes($content["content_".$lang]));
        print "$text";

    }
}

function home_content_s($cid, $lang, $db_link){
    global $home, $subid;
    $tbl_content = $db_link->where('id', $cid)->get('content');
    foreach ($tbl_content as $content) {
        $id = $content["id"];
        $contents = $content["content_" . $lang];
        print $contents;

    }
}

function content($cid,$lang,$db_link){  
    global $home, $subid;
    $tbl_category = $db_link->where("alias_" . $lang, $cid)->getOne('category');
    $tbl_content = $db_link->where('id', $tbl_category["id"])->getOne('content');
    if ($tbl_category["img1"]) {
        $tbl_category_img = "/uploads/menyu/".$tbl_category["img1"];
        $bg_style=" style='background: url({$tbl_category["img1"]}) top left no-repeat; background-repeat: no-repeat; background-size: 100%;'";
    }else{
        $tbl_category_img="/images/slide01.jpg";  
        $bg_style="";
    }
    print "<header class='page-header' data-background='$tbl_category_img' data-stellar-background-ratio='1.15'>
    <div class='container'>
    <h1>{$tbl_category["name_" . $lang]}</h1>
    <ol class='breadcrumb'>
    <li class='breadcrumb-item'><a href='/'>$home</a></li>
    <li class='breadcrumb-item'><a href='#'>{$tbl_category["name_" . $lang]}</a></li>
    </ol>
    </div>
    </header>";



    print "<section class='about-content'>
    <div class='container'>
    <div class='row'>
    <div class='col-12'>{$tbl_content["content_" . $lang]}</div>
    </div>
    </div>
    </section>";
}

function home_slider_photos($category_id,$lang,$db_link){
    global $siteName,$home; 
    print "<section class='hero' data-bgColorStart='204, 179, 157' data-bgColorEnd='209, 209, 209'>
    <div class='hero-slider d-flex flex-column'>
    <div class='js-hero-slider'>";
    $db_link->pageLimit = 15;
    $tbl_news = $db_link->arraybuilder()->where('m_id', $category_id)->orderBy("sira","desc")->paginate("photos", 1);
    $totalpage=$db_link->totalPages;    
    //print $db_link->getLastQuery();
    foreach ($tbl_news as $line) {
        $i++;  
        $id = $line["id"];
        $file = stripslashes($line["file_az"]);
        $link = stripslashes($line["link_az"]);
        $name = stripslashes($line["name_az"]);
        if($file)$img="/uploads/photos/$category_id/$file"; else $img="/no_image.png";

        print "<div class='hero-slide' style='background-image: url(\"$img\")'>
        <div class='container hero-slide-inner full-height'>
        <h1 class='hero-title'>$name</h1>
        </div>
        </div>";
    }
    print "</div>
    <div class='mt-auto slick-count js-slick-count'></div>
    </div>
    </section>";
}

function home_slider_video($category_id,$lang,$db_link){
    global $siteName,$home,$b_read_more; 
    $db_link->pageLimit = 3;
    $tbl_news = $db_link->arraybuilder()->where('m_id', $category_id)->orderBy("sira","desc")->paginate("photos", 1);
    $totalpage=$db_link->totalPages;    
    foreach ($tbl_news as $line) {
        $i++;  
        $id = $line["id"];
        $file = $line["file"];
        $link = stripslashes($line["link_".$lang]);
        $name = stripslashes($line["name_".$lang]);
        $content = stripslashes($line["content_".$lang]);
        if($file)$img="/uploads/$file"; else $img="/no_image.png";

        print "<div class='swiper-slide' data-background='/images/slide03.jpg' data-stellar-background-ratio='1.15'>
        <div class='container'>
        <h1>$name</h1>
        <h2>$content</h2>
        <a href='$link'>$b_read_more<i class='fas fa-caret-right'></i></a>
        </div>
        <div class='video-bg'>
        <video src='$img' loop autoplay muted></video>
        </div>
        </div>";
    }
}

function team_photos($category_id,$lang,$db_link){
    global $siteName,$home; 
    //print "<div class='col-md-8 offset-md-2'><div class='row'>";
    $db_link->pageLimit = 15;
    $tbl_news = $db_link->arraybuilder()->where('m_id', $category_id)->orderBy("id","desc")->paginate("photos", 1);
    $totalpage=$db_link->totalPages;    
    //print $db_link->getLastQuery();
    foreach ($tbl_news as $line) {
        $i++;  
        $id = $line["id"];
        $file = stripslashes($line["file_az"]);
        $link = stripslashes($line["link_az"]);
        $name = stripslashes($line["name_az"]);
        if($file)$img="/uploads/photos/$category_id/$file"; else $img="/no_image.png";
        print "<div class='team-block col-lg-3 col-md-6 col-sm-12'>
        <div class='inner-box'>
        <div class='image-box'>
        <div class='image'><a href='$img' class='lightbox-image' data-fancybox='gallery'><img src='$img' alt='$name'></a></div>
        </div>
        <div class='info-box'>
        <h4 class='name'><a href='team.html'>$name</a></h4>
        <span class='designation'>$link</span>
        </div>
        </div>
        </div>";



    }
}

function videos($cid,$page,$lang,$db_link){
    global $b_read_more,$home,$subid;
    $tbl_category = $db_link->where("alias_" . $lang, $cid)->getOne('category');
    if ($tbl_category["img1"]) {
        $tbl_category_img = "/uploads/menyu/$tbl_category_img";
        $bg_style=" style='background: url($tbl_category_img) top left no-repeat; background-repeat: no-repeat; background-size: 100%;'";
    }else{
        $tbl_category_img="/images/slide01.jpg";
        $bg_style="";
    }

    print "<header class='page-header' data-background='$tbl_category_img' data-stellar-background-ratio='1.15'>
    <div class='container'>
    <h1>{$tbl_category["name_" . $lang]}</h1>
    <ol class='breadcrumb'>
    <li class='breadcrumb-item'><a href='/'>$home</a></li>
    <li class='breadcrumb-item'><a href='#'>{$tbl_category["name_" . $lang]}</a></li>
    </ol>
    </div>
    </header>";

    print "<section class='recent-gallery'>
    <div class='container'>
    <div class='row align-items-center'  style='justify-content: center;'>";

    print "<div class='col-lg-12'><div class='row inner' style='row-gap: 2rem;'>";
    $pageLimit=18;
    $db_link->pageLimit = $pageLimit;

    $tbl_news = $db_link->withTotalCount()->arraybuilder()->where('m_id', $tbl_category["id"])->orderBy("sira","desc")->paginate("video", $page);
    $totalpage=$db_link->totalPages;
    $total_records = $db_link->totalCount;
    foreach ($tbl_news as $line) {  
        $i++;
        $contents="";
        $nomre = $line["id"];
        $basliq = stripslashes($line["name_".$lang]);
        $ytid = stripslashes($line["ytid"]);
        $nlink="https://www.youtube.com/embed/$ytid?autoplay=1";
        $img="https://img.youtube.com/vi/$ytid/sddefault.jpg";

        /*        print "<div class='col-lg-4'>
        <div class='ltn__blog-item ltn__blog-item-3'>
        <div class='ltn__blog-img'>
        <a href='$nlink' data-rel='lightcase:myCollection'><img src='$img' alt='$basliq'></a>
        </div>
        <div class='ltn__blog-brief'>                                                                                   
        <h3 class='ltn__blog-title'><a href='$nlink'>$basliq</a></h3>
        </div>
        </div>
        </div>"; */

        print "<div class='one col-md-3'>
        <a href='$nlink' data-toggle='modal' data-target='#largeModal$i'>
        <img src='$img' alt='Image'/></a>

        <div class='modal fade' id='largeModal$i' tabindex='-1' role='dialog' aria-labelledby='basicModal' aria-hidden='true'>
        <div class='modal-dialog modal-lg'>
        <div class='modal-content' style='background: none;'>
        <div class='modal-body'>
        <div id='carousel$i' class='carousel slide' data-ride='carousel'>

        <div class='carousel-inner'>
        <div class='carousel-item active'>
        <iframe src='$nlink' frameborder='0' style='overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:100%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px' height='640' width='480'></iframe>
        </div>
        </div>
        </div>
        </div>
        <div class='modal-footer' style='border:none;'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
        </div>
        </div>
        </div>
        </div>       

        </div>";
    }



    print "</div>";
    print "</div>";
    if($totalpage>1){
        print "<div class='styled-pagination centered'>";
        print pagination($total_records, $pageLimit, $page, "/$lang/news/$category_id/%d.html");
        print "</div>";
    }

    print "
    </div>
    </section>";
}

function youtube___($category_id,$page,$lang,$db_link){
    global $siteName,$home; 
    $catname=$db_link->where ('id', $category_id)->getValue ("category", "name_$lang");
    print "<div class='ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image '  data-bs-bg='$tbl_category_img'>
    <div class='container'>
    <div class='row'>
    <div class='col-lg-12'>
    <div class='ltn__breadcrumb-inner'>
    <h1 class='page-title'>$tbl_category</h1>
    <div class='ltn__breadcrumb-list'>
    <ul>
    <li><a href='/' style='color: black;'><span class='ltn__secondary-color'><i class='fas fa-home'></i></span> $home</a></li>
    <li>$tbl_category</li>
    </ul>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>";   

    print "<section class='main-body'><div class='container'><div class='row'><div class='col-sm-12 col-md-12'>";
    print "<article class='item item-page' itemscope='' itemtype='http://schema.org/Article'><meta itemprop='inLanguage' content='en-GB'>
    <div itemprop='articleBody'><div data-uk-grid-margin='' class='uk-grid uk-grid-width-medium-1-4'>";
    $db_link->pageLimit = 12;
    $tbl_news = $db_link->arraybuilder()->where('m_id', $category_id)->orderBy("id","desc")->paginate("youtube", $page);
    $totalpage=$db_link->totalPages;    
    //print $db_link->getLastQuery();
    foreach ($tbl_news as $line) {
        $i++;  
        $id = $line["id"];
        $file = stripslashes($line["file_az"]);
        $link = stripslashes($line["link_".$lang]);
        $name = stripslashes($line["name_".$lang]);
        //if($file)$img="/imageg_1000_1000_".$file."_photos_".$category_id.".jpg"; else $img="/no_image.png";
        $ytdId=get_youtube_id_from_url($file);
        $img="https://img.youtube.com/vi/$ytdId/hqdefault.jpg";
        print "<div>
        <a title='$name' data-uk-lightbox=\"{group:'group1'}\" href='$file'>
        <img alt='$name' src='$img' height='400' width='600'>
        <h5>$name<h5>
        </a>
        </div>";
    }
    print "</div>
    </div>                            
    </article>
    </div>
    </div>
    </div>
    </section>"; 

    if($totalpage>1){
        print "<div class='course-pagination text-center'>
        <ul class='pagination'>"; 
        if($page) $page=$page; else $page=1;
        for ($pn = 1; $pn <= $totalpage; $pn++) {
            //print "<li class='tg-prevpage'><a href='#'><i class='fa fa-angle-left'></i></a></li>";
            if($page==$pn)
                print "<li class='page-item active'><a class='page-link' href='/$lang/youtube/$category_id/$pn.html'>$pn</a></li>";
            else
                print "<li class='page-item'><a class='page-link' href='/$lang/youtube/$category_id/$pn.html'>$pn</a></li>";
            //print "<li class='tg-nextpage'><a href='#'><i class='fa fa-angle-right'></i></a></li>"; 
        }
        print "</ul>
        </div></div></section>"; 
    }        
}

function photos($category_id,$page,$lang,$db_link){
    global $siteName,$home; 
    $catname=$db_link->where ('id', $category_id)->getValue ("category", "name_$lang");

    print "<div class='ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image '  data-bs-bg='$tbl_category_img'>
    <div class='container'>
    <div class='row'>
    <div class='col-lg-12'>
    <div class='ltn__breadcrumb-inner'>
    <h1 class='page-title'>$catname</h1>
    <div class='ltn__breadcrumb-list'>
    <ul>
    <li><a href='/' style='color: black;'><span class='ltn__secondary-color'><i class='fas fa-home'></i></span> $home</a></li>
    <li>$catname</li>
    </ul>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>";   

    print "<section class='main-body'><div class='container'><div class='row'><div class='col-sm-12 col-md-12'>";
    print "<article class='item item-page' itemscope='' itemtype='http://schema.org/Article'><meta itemprop='inLanguage' content='en-GB'>
    <div itemprop='articleBody'><div data-uk-grid-margin='' class='uk-grid uk-grid-width-medium-1-4'>";
    $db_link->pageLimit = 12;
    $tbl_news = $db_link->arraybuilder()->where('m_id', $category_id)->orderBy("id","desc")->paginate("photos", $page);
    $totalpage=$db_link->totalPages;    
    //print $db_link->getLastQuery();
    foreach ($tbl_news as $line) {
        $i++;  
        $id = $line["id"];
        $file = stripslashes($line["file_az"]);
        $link = stripslashes($line["link_".$lang]);
        $name = stripslashes($line["name_".$lang]);
        if($file)$img="/imageg_1000_1000_".$file."_photos_".$category_id.".jpg"; else $img="/no_image.png";

        print "<div>
        <a title='$name' data-uk-lightbox=\"{group:'group1'}\" href='$img'>
        <img alt='$name' src='$img' style='width: 100%;
        height: 260px;
        object-fit: cover;padding-bottom: 20px;'>
        </a>
        </div>";
    }
    print "</div>
    </div>                            
    </article>
    </div>
    </div>
    </div>
    </section>"; 

    if($totalpage>1){
        print "<div class='course-pagination text-center'>
        <ul class='pagination'>"; 
        if($page) $page=$page; else $page=1;
        for ($pn = 1; $pn <= $totalpage; $pn++) {
            //print "<li class='tg-prevpage'><a href='#'><i class='fa fa-angle-left'></i></a></li>";
            if($page==$pn)
                print "<li class='page-item active'><a class='page-link' href='/$lang/photos/$category_id/$pn.html'>$pn</a></li>";
            else
                print "<li class='page-item'><a class='page-link' href='/$lang/photos/$category_id/$pn.html'>$pn</a></li>";
            //print "<li class='tg-nextpage'><a href='#'><i class='fa fa-angle-right'></i></a></li>"; 
        }
        print "</ul>
        </div></div></section>"; 
    }        
}

function multimedia____($cid,$seh,$lang,$db_link){
    print "<div class='container gallery-container'><div class='tz-gallery'><div class='row'>";
    $i=0;
    $tbl_news = $db_link->where('category_id', $cid)->orderBy("id","desc")->get('multimedia');
    foreach ($tbl_news as $line) {    
        $i++;
        $nomre = $line["id"];                               
        $name = stripslashes($line["name_".$lang]);
        $type = $line["file_type"];

        if($type=='youtube'){
            $file=$db_link->where ('m_id', $nomre)->getValue ("multimedia_file", "file");
            $img="http://img.youtube.com/vi/$file/0.jpg";
            $rel=" class='video'";
            $link="http://www.youtube.com/watch?v=$file";
        }else{ 
            $img=$db_link->where ('m_id', $nomre)->where ('cover', 1)->getValue ("multimedia_file", "file");
            if($img)$img="/imageg_400_300_".$img."_multimedia_".$nomre.".jpg"; else $img="/no_image.png";
            $rel="";
            $link="/$lang-multimedia/$type-$nomre.html";
        }

        print "<div class='col-sm-6 col-md-4'>
        <div class='thumbnail'> <a $rel href='$link'> <img src='$img' alt=''> </a>
        <div class='caption'>
        <h3>$name</h3>
        </div>
        </div>
        </div>";
    }
    print "</div></div></div>";

    /*if($totalpage>1){
    print "<div class='course-pagination'>
    <ul class='pagination'>"; 
    if($page) $page=$page; else $page=1;
    for ($pn = 1; $pn <= $totalpage; $pn++) {
    //print "<li class='tg-prevpage'><a href='#'><i class='fa fa-angle-left'></i></a></li>";
    if($page==$pn)
    print "<li class='page-item active'><a class='page-link' href='/$lang/news/$category_id/$pn.html'>$pn</a></li>";
    else
    print "<li class='page-item'><a class='page-link' href='/$lang/news/$category_id/$pn.html'>$pn</a></li>";
    //print "<li class='tg-nextpage'><a href='#'><i class='fa fa-angle-right'></i></a></li>"; 
    }
    print "</ul>
    </div>"; 
    }*/
} 

function image($m_id,$seh,$lang,$db_link){ 
    print "<div class='container gallery-container'><div class='tz-gallery'><div class='row'>";
    $i=0;
    $tbl_news = $db_link->where('m_id', $m_id)->orderBy("id","desc")->get('multimedia_file');
    foreach ($tbl_news as $line) { 
        $id = $line["id"];
        $file = stripslashes($line["file"]);
        $name = stripslashes($line["name_".$lang]);   
        if($file)$img="/imageg_400_300_".$file."_multimedia_".$m_id.".jpg"; else $img="/no_image.png";
        if($file)$img1="/imageg_1000_1000_".$file."_multimedia_".$m_id.".jpg"; else $img1="/no_image.png";
        print "<div class='col-sm-6 col-md-4'>
        <div class='thumbnail'> <a class='lightbox' href='$img1'> <img src='$img' alt=''> </a>
        <div class='caption'>
        <h3>$name</h3>
        </div>
        </div>
        </div>";
    }
    print "</div></div></div>";    
}

function search($search_text,$seh,$lang,$db_link){
    global $b_read_more, $home, $subid,$lang, $project,$searchtext1,$searchtext2,$searchtext3;

    print "<div class='ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image ' style='height:auto!important'  data-bs-bg='$tbl_category_img'>
    <div class='container'>
    <div class='row'>
    <div class='col-lg-12'>
    <div class='ltn__breadcrumb-inner'>
    <h1 class='page-title'>$searchtext1</h1>
    <div class='ltn__breadcrumb-list'>
    <ul>
    <li><a href='/' style='color: black;'><span class='ltn__secondary-color'><i class='fas fa-home'></i></span> $home</a></li>
    <li>$searchtext1</li>
    </ul>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>";   

    print "<div class='ltn__gallery-area mb-120' style='min-height: calc(100vh - 672px);'>
    <div class='container'>
    <div class='ltn__gallery-active row ltn__gallery-style-1'>
    <div class='ltn__gallery-sizer col-1'></div>";

    if (strlen($search_text) > 2) {
        $page=1;
        $db_link->pageLimit = 32;
        $db_link->where("name_$lang", "%$search_text%", 'LIKE');
        $db_link->orWhere("content_$lang", "%$search_text%", 'LIKE');       
        $tbl_search = $db_link->arraybuilder()->orderBy("id", "asc")->paginate("content", $page);        
        $totalCount = $db_link->totalCount;

        $_SESSION['search_text'] = $search_text;
        foreach ($tbl_search as $line) {
            $i++;
            $sale = 0;
            $nomre = $line["id"];
            $category_id = $line["category_id"];
            $create_date = getTheDay($line["news_date"]);
            $basliq = stripslashes($line["name_" . $lang]);
            $price1 = stripslashes($line["price1"]);
            $price2 = stripslashes($line["price2"]);
            if($price1) $price1=$price1; elseif($price2) $price1=$price2; else $price1=$price3;
            $read_count = stripslashes($line["read_count"]);
            $sale = stripslashes($line["sale"]);
            if($sale) $priceSale1=$price1-round(($price1/100)*$sale); else $priceSale1=0;
            $content = strip_tags(substr(strip_tags(stripslashes($line["content_" . $lang])), 0, 150)) . "...";
            $nlink = "/$lang/content/$nomre.html";
            $img1 = stripslashes($line["img1"]);
            if ($img1) $img1 = "/imageg_350_400_" . $img1 . "_content_" . $category_id . ".jpg"; else $img1 = "/no_image.png";

            print "<div class='ltn__gallery-item filter_category_3 col-md-4 col-sm-6 col-12'>
            <div class='ltn__gallery-item-inner'>
            <div class='ltn__gallery-item-info'>
            <h4><a href='$nlink'>$basliq </a></h4>
            </div>
            </div>
            </div>";           


        }


        $page=1;
        $db_link->pageLimit = 32;
        $db_link->where("title_$lang", "%$search_text%", 'LIKE');
        $db_link->orWhere("content_$lang", "%$search_text%", 'LIKE');       
        $tbl_search = $db_link->arraybuilder()->orderBy("id", "asc")->paginate("news", $page);        
        $totalCount = $db_link->totalCount;

        $_SESSION['search_text'] = $search_text;
        foreach ($tbl_search as $line) {
            $i++;
            $sale = 0;
            $nomre = $line["id"];
            $category_id = $line["category_id"];
            $create_date = getTheDay($line["news_date"]);
            $basliq = stripslashes($line["title_" . $lang]);
            $price1 = stripslashes($line["price1"]);
            $price2 = stripslashes($line["price2"]);
            if($price1) $price1=$price1; elseif($price2) $price1=$price2; else $price1=$price3;
            $read_count = stripslashes($line["read_count"]);
            $sale = stripslashes($line["sale"]);
            if($sale) $priceSale1=$price1-round(($price1/100)*$sale); else $priceSale1=0;
            $content = strip_tags(substr(strip_tags(stripslashes($line["content_" . $lang])), 0, 150)) . "...";
            $nlink = "/$lang/opennews/$nomre.html";
            $img1 = stripslashes($line["img"]);
            if ($img1) $img1 = "/imageg_350_400_" . $img1 . "_news_" . $category_id . ".jpg"; else $img1 = "/no_image.png";

            print "<div class='ltn__gallery-item filter_category_3 col-md-4 col-sm-6 col-12'>
            <div class='ltn__gallery-item-inner'>
            <div class='ltn__gallery-item-info'>
            <h4><a href='$nlink'>$basliq </a></h4>
            </div>
            </div>
            </div>";           


        }        

        if ($totalCount == 0) {
            print "<section class=history-section clearfix>
            <div class=container>
            <div class=row>
            <div class=col-lg-12 col-sm-12>
            $searchtext2
            </div>
            </div>
            </div>
            </section>";             
        }

    } else {
        print "<section class=history-section clearfix>
        <div class=container>
        <div class=row>
        <div class=col-lg-12 col-sm-12>
        $searchtext3
        </div>
        </div>
        </div>
        </section>";        
    }

    print "
    </div>
    </div>
    </div>";
}

function get_next_id($tbl){
    global $db_link,$dbname;
    $VAID = $db_link->rawQueryOne("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '$tbl'");
    return $VAID['AUTO_INCREMENT'];
}

function substr_unicode($str, $s, $l = null) {
    return join("", array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
} 

function get_date($s){
    $s = explode(" ", $s);
    if ($s[0]) {
        $myarray = explode("-", $s[0]);
        if ($myarray[1]==0){ return "";}
        return $myarray[2].".".$myarray[1].".".$myarray[0];              
    }
    return "";
}

function get_date1($s){
    $myarray = explode("-", $s[0]);
    if ($myarray[1]==0){ return "";}
    return $myarray[2].".".$myarray[1].".".$myarray[0];              
}

function get_hour($s){
    if ($s) {
        $myarray = explode(":", $s);
        //if ($myarray[1]==0){ return "";}
        return $myarray[0].":".$myarray[1];              
    }
    return "";
}    

function aylar($mon,$lang){
    if($lang=='az'){
        if($mon=="01"){return "Yanvar";}
        if($mon=="02"){return "Fevral";}
        if($mon=="03"){return "Mart";}
        if($mon=="04"){return "Aprel";}
        if($mon=="05"){return "May";}
        if($mon=="06"){return "Iyun";}
        if($mon=="07"){return "Iyul";}
        if($mon=="08"){return "Avqust";}
        if($mon=="09"){return "Senyabr";}
        if($mon=="10"){return "Oktyabr";}
        if($mon=="11"){return "Noyabr";}
        if($mon=="12"){return "Dekabr";}  
    }
    if($lang=='ru'){
        if($mon=="01"){return "Январь";}
        if($mon=="02"){return "Февраль";}
        if($mon=="03"){return "Март";}
        if($mon=="04"){return "Апрель";}
        if($mon=="05"){return "Май";}
        if($mon=="06"){return "Июнь";}
        if($mon=="07"){return "Июль";}
        if($mon=="08"){return "Август";}
        if($mon=="09"){return "Сентябрь";}
        if($mon=="10"){return "Октябрь";}
        if($mon=="11"){return "Ноябрь";}
        if($mon=="12"){return "Декабрь";}            
    }
    if($lang=='en'){
        if($mon=="01"){return "January";}
        if($mon=="02"){return "February";}
        if($mon=="03"){return "March";}
        if($mon=="04"){return "April";}
        if($mon=="05"){return "May";}
        if($mon=="06"){return "June";}
        if($mon=="07"){return "July";}
        if($mon=="08"){return "August";}
        if($mon=="09"){return "September";}
        if($mon=="10"){return "October";}
        if($mon=="11"){return "November";}
        if($mon=="12"){return "December";}           
    } 
}

function file_size($file, $path = "") {
    define("DOCUMENT_ROOT", dirname(__FILE__));
    $bytes = array("B", "KB", "MB", "GB", "TB", "PB");
    $file_with_path = DOCUMENT_ROOT."/".$path."/".$file;
    $file_with_path = str_replace("//", "/", $file_with_path);
    $size = filesize($file_with_path);
    $i = 0;
    while ($size >= 1024) { $size = $size/1024; $i++; }
    if ($i > 1) {
        return round($size,1)." ".$bytes[$i];
    } else {
        return round($size,0)." ".$bytes[$i];
    }

    //echo file_size("example.txt", "myFolder");
}

function get_file_extension($file_name) {
    return substr(strrchr($file_name,'.'),1);
}

function valid_email($str){
    return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

function valid_reg_email($str){
    global $db_link;
    //$email=@mysql_result(mysql_query("SELECT `email` FROM qeydiyyat where `Email`='$str'",$db_link), 0, 0);
    return ($email)? FALSE : TRUE;
}

function tarix($vaxt) {
    $gunler_az = array('Bazar', 'Bazar ertəsi', 'Çərşənbə axşamı', 'Çərşənbə', 'Cümə axşamı', 'Cümə', 'Şənbə');
    $aylar_az  = array('', 'Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'İyun', 'İyul', 'Ağustos', 'Sentyabr', 'Oktyabr', 'Noyabr', 'Dekabr');
    return date("d ", $vaxt).$aylar_az[date("n", $vaxt)].' '.$gunler_az[date("w", $vaxt)];
}
function tarixen($vaxt) {
    $gunler_en = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    $aylar_en = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    return date("d ", $vaxt).$aylar_en[date("n", $vaxt)].' '.$gunler_en[date("w", $vaxt)];
}
function tarixru($vaxt) {
    $gunler_ru = array('Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота');
    $aylar_ru = array('', 'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
    return date("d ", $vaxt).$aylar_ru[date("n", $vaxt)].' '.$gunler_ru[date("w", $vaxt)];
}

function get_day_wo_zero($str){
    $str = ltrim($str, '0');
    return $str;
}

function conv2utf8($encoding,$str){
    $strutf8 = iconv("windows-1251","utf-8",$encoding);
}

function isMobile() {
    return preg_match("/(android|iPhone|iphone|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|palm|phone|pie|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function getTheDay ( $date){
    global $bugun,$dunen,$gunevvel;
    $datetime = date('Y-m-d H:i:s', strtotime($date));
    list ( $date, $time ) = explode ( ' ', $datetime );
    $time = substr( $time, 0, 5);
    list ( $hour, $minute ) = explode (':', $time);
    //$return = ' ' . $hour . ':' . $minute;

    list ($year, $month, $day) = explode ( '-', $date );
    list ($year2, $month2, $day2) = explode (' ', date('Y m d'));

    if ($year == $year2 && $month == $month2 && $day == $day2){
        return $bugun.' ' . $return;
    }
    if ($year == $year2 && $month == $month2 && $day == $day2 - 1){
        return $dunen.' ' . $return;
    }
    if ($year == $year2 && $month == $month2 && $day == $day2 - 2){
        return $gunevvel.' ' . $return;
    }
    /*    if ($year == $year2 && $month == $month2 && $day == $day2 - 3){
    return '3 gün əvvəl ' . $return;
    }*/

    $s = explode(" ", $date);
    if($s[1]){
        $ms = explode(":", $s[1]);
        $msaat=$ms[0].":".$ms[1];   
    }

    if ($s[0]) {
        $myarray = explode("-", $s[0]);
        if ($myarray[1]==0){ return "";}
        return $myarray[2].".".$myarray[1].".".$myarray[0]." ".$msaat;              
    }else{
        return "";   
    }
    //return $date . ' ' . $return;
} 

function pagination($item_count, $limit, $cur_page, $link)
{
    $page_count = ceil($item_count/$limit);
    $current_range = array(($cur_page-2 < 1 ? 1 : $cur_page-2), ($cur_page+2 > $page_count ? $page_count : $cur_page+2));

    // First and Last pages
    $first_page = $cur_page > 3 ? '<li><a href="'.sprintf($link, '1').'">1</a></li>'.($cur_page < 5 ? ' ' : ' ') : null;
    $last_page = $cur_page < $page_count-2 ? ($cur_page > $page_count-4 ? ' ' : ' ').'<li><a href="'.sprintf($link, $page_count).'">'.$page_count.'</a></li>' : null;

    // Previous and next page
    $previous_page = $cur_page > 1 ? '<li><a href="'.sprintf($link, ($cur_page-1)).'">Əvvəlki</a></li>  ' : null;
    $next_page = $cur_page < $page_count ? ' <li><a href="'.sprintf($link, ($cur_page+1)).'">Sonrakı</a></li>' : null;

    // Display pages that are in range
    for ($x=$current_range[0];$x <= $current_range[1]; ++$x)
        $pages[] = '<li '.($x == $cur_page ? 'class="active"' : 'class="next"').'><a href="'.sprintf($link, $x).'" >'.$x.'</a></li>';

    if ($page_count > 1)
        return '<ul class="pagination"> '.$previous_page.$first_page.implode(' ', $pages).$last_page.$next_page.'</ul>';
}

function _bot_detected() {
    return (isset($_SERVER['HTTP_USER_AGENT'])
        && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])
    );
} 

function get_youtube_id_from_url($url){
    if (stristr($url,'youtu.be/'))
        {preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $final_ID); return $final_ID[4]; }
    else 
        {@preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $IDD); return $IDD[5]; }
}

?>