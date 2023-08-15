<?php
//error_reporting(E_ALL);
ini_set('display_errors', false);
//ini_set('display_startup_errors', true);

session_start();
$security_test=1;
include("config.php");
include("function.php");

if(!is_logged_in()){
    header("Location: login.php");
    exit;
}
$userid=$_SESSION['userid'];
$menu=$_GET['menu'];  

//array_walk($_POST, 'xss_protect');

if($menu=='xeber') $ptitle="Xəbərlər";
elseif($menu=='susers') $ptitle="Sayt istfadəçiləri";
else $ptitle="Admin Panel"; 
?>
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="UTF-8">
        <title><?php print $ptitle;?></title>
        <meta name="description" content="<?php print $ptitle;?>">

        <meta name="viewport" content="width=device-width, maximum-scale=5, initial-scale=1">

        <!-- up to 10% speed up for external res -->
        <link rel="dns-prefetch" href="https://fonts.googleapis.com/">
        <link rel="dns-prefetch" href="https://fonts.gstatic.com/">
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/">
        <!-- preloading icon font is helping to speed up a little bit -->
        <link rel="preload" href="assets/fonts/flaticon/Flaticon.woff2" as="font" type="font/woff2" crossorigin>

        <link rel="stylesheet" href="assets/css/core.min.css">
        <link rel="stylesheet" href="assets/css/vendor_bundle.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap">
        <link rel="shortcut icon" href="favicon.ico">
        <script>
            function open_popup(url)
            {
                var w = 880;
                var h = 570;
                var l = Math.floor((screen.width-w)/2);
                var t = Math.floor((screen.height-h)/2);
                var win = window.open(url, 'ResponsiveFilemanager', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
            }             
            function Pencere(adres){
                window.open(adres,"yeniPen","height=650, width=900,top=10,left=10,scrollbars=yes,toolbar=no,menubar=no,location=no,resizable=no");
            }

            function logout() {
                if (confirm("Are you want logout?"))
                    document.location.href="logout.php";
                return false;
            }

            function Del(url) {
                if (confirm("Are you shure to delete?"))
                    document.location.href=url;
                return false;
            }

            function Change(url) {
                if (confirm("Are you shure to Change?"))
                    document.location.href=url;
                return false;
            }

            function Deluser(id) {
                if (confirm("Are you shure to delete?"))
                    document.location.href="?menu=qeydiyyat&tip=delete_qeydiyyat&cid="+id;
                return false;
            }
        </script>
    </head>
    <body class="layout-admin aside-sticky header-sticky" data-s2t-class="btn-primary btn-sm bg-gradient-default rounded-circle border-0">

        <div id="wrapper" class="d-flex align-items-stretch flex-column">

            <!--  header -->
            <header id="header" class="d-flex align-items-center shadow-xs">

                <!-- Navbar -->
                <div class="container-fluid position-relative">

                    <nav class="navbar navbar-expand-lg navbar-light justify-content-between">
                        <div class="align-items-start">
                            <a href="#aside-main" class="btn-sidebar-toggle h-100 d-inline-block d-lg-none justify-content-center align-items-center p-2">
                                <span>
                                    <svg width="25" height="25" viewBox="0 0 20 20">
                                        <path d="M 19.9876 1.998 L -0.0108 1.998 L -0.0108 -0.0019 L 19.9876 -0.0019 L 19.9876 1.998 Z"></path>
                                        <path d="M 19.9876 7.9979 L -0.0108 7.9979 L -0.0108 5.9979 L 19.9876 5.9979 L 19.9876 7.9979 Z"></path>
                                        <path d="M 19.9876 13.9977 L -0.0108 13.9977 L -0.0108 11.9978 L 19.9876 11.9978 L 19.9876 13.9977 Z"></path>
                                        <path d="M 19.9876 19.9976 L -0.0108 19.9976 L -0.0108 17.9976 L 19.9876 17.9976 L 19.9876 19.9976 Z"></path>
                                    </svg>
                                </span>
                            </a>
                            <a class="navbar-brand d-inline-block d-lg-none mx-2" href="index.html">
                                <img src="/images/logo@4x.png" style="width: 100%;" alt="...">
                            </a>
                        </div>

                        <!-- navbar : navigation -->
                        <div class="collapse navbar-collapse" id="navbarMainNav">
                            <div class="navbar-xs d-none">
                                <button class="navbar-toggler pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
                                    <svg width="20" viewBox="0 0 20 20">
                                        <path d="M 20.7895 0.977 L 19.3752 -0.4364 L 10.081 8.8522 L 0.7869 -0.4364 L -0.6274 0.977 L 8.6668 10.2656 L -0.6274 19.5542 L 0.7869 20.9676 L 10.081 11.679 L 19.3752 20.9676 L 20.7895 19.5542 L 11.4953 10.2656 L 20.7895 0.977 Z"></path>
                                    </svg>
                                </button>
                                <a class="navbar-brand" href="index.html">
                                    <img src="/images/logo@4x.png" style="width: 100%;" alt="...">
                                </a>
                            </div>

                        </div>
                        <!-- /navbar : navigation -->

                        <!-- options -->
                        <ul class="list-inline list-unstyled mb-0 d-flex align-items-end">
                            <li class="list-inline-item mx-1 dropdown">
                                <a href="#" id="dropdownAccountOptions" class="btn btn-sm btn-icon btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                    <span class="small fw-bold"><?php print $_SESSION['username'];?></span>
                                </a>
                                <div aria-labelledby="dropdownAccountOptions" class="dropdown-menu dropdown-menu-clean dropdown-menu-navbar-autopos dropdown-menu-invert dropdown-fadeindown p-0 mt-2 w-300">
                                    <div class="dropdown-header bg-primary bg-gradient rounded rounded-bottom-0 text-white small p-4">
                                        <span class="d-block fw-medium text-truncate"><?php print $_SESSION['username'];?></span>
                                        <span class="d-block smaller"><b>Last Login:</b> <?php print $_SESSION['last_login'];?></span>
                                    </div>
                                    <!--                                    <div class="dropdown-divider mb-3"></div>
                                    <a href="#" class="dropdown-item text-truncate">
                                    <span class="fw-medium">My profile</span>
                                    <small class="d-block text-muted smaller">account settings and more</small>
                                    </a> -->
                                    <div class="dropdown-divider mb-0 mt-3"></div>
                                    <a href="#" onclick="logout();" class="prefix-icon-ignore dropdown-footer dropdown-custom-ignore fw-medium py-3 px-4">
                                        <i class="fi fi-power float-start"></i>
                                        Log Out
                                    </a>
                                </div>

                            </li>
                        </ul>
                        <!-- /options -->

                    </nav>

                </div>
                <!-- /Navbar -->

            </header>
            <!-- /Header -->


            <!-- content -->
            <div id="wrapper_content" class="d-flex flex-fill">

                <!-- sidebar -->
                <aside id="aside-main" class="aside-primary bg-gradient aside-start aside-hide-xs shadow-sm d-flex flex-column px-2 h-auto">
                    <div class="py-2 px-3 mb-3 mt-1"><a href="/index.html"><img src="/images/logo@4x.png" style="width: 100%;" alt="..."></a> </div>

                    <!--link-normal  sidebar : navigation -->
                    <div class="aside-wrapper scrollable-vertical scrollable-styled-light align-self-baseline h-100 w-100">
                        <nav class="nav-deep nav-deep-sm nav-deep-dark">
                            <ul class="nav flex-column">

                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">
                                        <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">  
                                            <path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"></path>  
                                            <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"></path>
                                        </svg>
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                                <?php include "menu.php";?>
                            </ul>
                        </nav>

                    </div>
                    <!-- /sidebar : navigation -->


                    <!-- sidebar : footer -->
                    <div class="d-flex align-self-baseline w-100 borer-top small">
                        <a class="btn btn-sm btn-dark rounded-xl" target="_blank" href="/"> &copy; <?php print strtolower($siteName);?> </a>
                    </div>
                    <!-- /sidebar : footer -->


                </aside>
                <!-- /sidebar -->


                <main id="middle" class="flex-fill mx-auto">
                    <div class="section rounded mb-3">
                        <?php
                        if (empty($_GET['menu'])){
                            echo "<p align='center'><br><br><b>Admin Panelə xoş gəldiniz.</b><br><br>";
                            echo "Son Giriş tarixi <strong>".$_SESSION['last_login']."</strong>, Son Giriş IP-si <strong>".$_SESSION['last_ip']."</strong><br>";
                            echo "<b>İşləmək üçün hər hansı bir bölməni seçin.</b></p>\n"; 
                            //include("main.php");
                        }
                        else {
                            $pages = array('menyu','map', 'menuconfig', 'muraciet', 'siteconfig', 'users','map_category','author','elaqe_form','sened_form','susers', 'xeber','content_photos','multimedia_photos','video','files', 'stext', 'abune','news_photos', 'banner', 'content', 'qeydiyyat', 'multimedia', 'photos','katalog', 'edit_user', 'links', 'bloks', 'banner_player');
                            if( in_array($_GET['menu'], $pages) )
                                include($_GET['menu'].".php");
                            else
                                die("<script>document.location.href='index.php';</script>");
                        }
                        ?> 
                    </div>
                </main>
            </div>

        </div><!-- /#wrapper -->

        <script src="assets/js/core.min.js"></script>
        <script src="assets/js/vendor_bundle.min.js"></script>
        <script src="teditor/tinymce.min.js"></script>
        <script type="text/javascript">
            /*            tinymce.init({
            selector: 'textarea',
            selector : "textarea:not(.mceNoEditor)",
            height: 500,
            menubar: false,
            plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table directionality emoticons paste responsivefilemanager code"
            ],
            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
            toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
            image_advtab: true ,
            relative_urls: false,
            verify_html : false,
            content_css: [
            '/assets/css/core.min.css',
            '/assets/css/vendor_bundle.min.css'
            ],
            external_filemanager_path:"/qpan/filemanager/",
            filemanager_access_key: "<?php print $_SESSION['access_key'];?>",
            filemanager_title:"Filemanager" ,
            external_plugins: { "filemanager" : "/qpan/filemanager/plugin.min.js"}  
            }); */


            tinymce.init({
                selector : 'textarea',
                selector : "textarea:not(.mceNoEditor)",
                height: 500,
                menubar: false,
                verify_html : false,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                    "table directionality emoticons paste code imagetools wordcount"
                ],

                toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
                toolbar2: "link unlink anchor | image media | forecolor backcolor  | print preview code ",                
                image_title: true,
                automatic_uploads: true,
                content_css: [
                    '/css/style.css'
                ],
                file_picker_types: 'image',
                file_picker_callback: function (cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');
                    input.onchange = function () {
                        var file = this.files[0];
                        var reader = new FileReader();
                        reader.onload = function () {
                            var id = 'blobid' + (new Date()).getTime();
                            var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                            var base64 = reader.result.split(',')[1];
                            var blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);
                            cb(blobInfo.blobUri(), { title: file.name });
                        };
                        reader.readAsDataURL(file);
                    };
                    input.click();
                },
            });



            var dataTableExtend = {
                "order": false,
                "bLengthChange" : false,
                "processing": true,
                "serverSide": true,
                select: false,
                rowReorder: false,
                'createdRow': function(row, data, dataIndex){
                    $(row).attr('id', 'row-' + dataIndex);
                }, 
                buttons: [],
                "language": {"url": "Azerbaijan.json"}
            };
        </script>
    </body>
</html>