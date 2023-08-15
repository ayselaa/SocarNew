<?php
ini_set('display_errors', false);
session_start();
include("config.php");
include("function.php");
if (isset($_POST['giris'])) {
    /*if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
    }
    if(!GoogleRecaptcha($captcha)){
    $_SESSION['loggedin']=false;
    $error = "Bütün bölmələri doldurun";
    }else{*/
    unset($_SESSION['machine']);
    unset($_SESSION['username']);
    unset($_SESSION['userid']);
    unset($_SESSION['password']);
    unset($_SESSION['loggedin']);
    unset($_SESSION['project']);

    $username = addslashes($_POST['user']);
    $pass = addslashes($_POST['pass']);
    $hash = 'lehlulu';
    $pass2encrypt = $hash.$pass;
    $password = md5($pass2encrypt);

    $db_link->where ("username", $username);
    $db_link->where ("password", $password);
    $userinfo = $db_link->getOne ("users");
    if($db_link->count>0) { 
        $_SESSION['flag'] = $userinfo['global_flag'];
        if($_SESSION['flag'] & CUST_DISABLED){
            $_SESSION['loggedin']=false;
            $error = "Sizin bu b&ouml;lm&#601;y&#601; <br>girm&#601;y&#601; haqq&#305;n&#305;z yoxdur";
        }else{
            $_SESSION['access_key']=md5(yazi(25));
            $_SESSION['username'] = $userinfo['username'];
            $_SESSION['userid'] = $userinfo['id'];
            $_SESSION['last_login'] = $userinfo['last_enter'];
            $_SESSION['last_ip'] = $userinfo['last_ip'];
            $_SESSION['machine'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['loggedin']=true;
            $_SESSION['project']='admin';

            //$data = array('LAST_LOGIN' => date('Y-m-d H:i:s'));

            $data = Array (
                'last_enter' => $userinfo['now_enter'],
                'last_ip' => $userinfo['now_ip'],
                'now_enter' => $db_link->now(),
                'now_ip' => $_SESSION['machine']
            );

            $db_link->where ('id', $userinfo['id']); 
            $db_link->update('users',$data);

            //print $db_link->getLastQuery(); 
            header("Location: index.php");
        }
    } else {
        $_SESSION['loggedin']=false;
        $error = "Username and/or <br> password is wrong";
    }
    /*    }
    }else{
    $_SESSION['loggedin']=false;   */
} 

?>

<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <meta name="description" content="...">
        <meta name="viewport" content="width=device-width, maximum-scale=5, initial-scale=1">
        <link rel="dns-prefetch" href="https://fonts.googleapis.com/">
        <link rel="dns-prefetch" href="https://fonts.gstatic.com/">
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/">
        <link rel="preload" href="assets/fonts/flaticon/Flaticon.woff2" as="font" type="font/woff2" crossorigin>
        <link rel="stylesheet" href="assets/css/core.min.css">
        <link rel="stylesheet" href="assets/css/vendor_bundle.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap">
        <link rel="shortcut icon" href="favicon.ico">
    </head>
    <body>
        <div class="section">
            <div class="container">
                <div class="text-center mb-5"><h1 class="display-5 fw-bold">Admin Panel</h1></div>
                <div class="col-md-9 col-lg-6 mx-auto">
                    <form novalidate action="" method="POST" class="bs-validate p-4 p-md-5 card rounded-xl">
                        <?php if(isset($error)) print '<p class="text-danger"><b>Error!</b> '.$error.'</p>';?>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="user" name="user" required placeholder="İstifadəçi adı">
                            <label for="user">İstifadəçi adı</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" placeholder="Şifrə" id="pass" data-minlength="6" name="pass" required />
                            <label for="pass">Şifrə</label>
                        </div>
                        <div class="form-floating mb-3">
                            <div class="g-recaptcha" data-sitekey="6Lf5ClkhAAAAAO-TYRDn2NQOi4tibxYxFl1wPiFz"></div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="submit" class="btn btn-primary w-100 fw-medium" value="Giriş" name="giris" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="assets/js/core.min.js"></script>
        <script src="assets/js/vendor_bundle.min.js"></script>
    </body>
</html>