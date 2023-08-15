<?php
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}

//if ($_GET['tip']==) $news_date=$news_info['news_date']; else $news_date=date('Y-m-d');
$category_id=$_GET['category_id'];


$desired_dir="../uploads/articles/$category_id/";
if(is_dir($desired_dir)==false){
    mkdir($desired_dir, 0755);
}
$tbl_category = $db_link->where("id", $category_id)->getValue ("category", "name_az");

if (empty($_GET['tip'])){
    $news_info = $db_link->orderBy("sira","asc")->where ('category_id', $category_id)->get('news');
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header"> <?php print $tbl_category; ?>  
                    <a style="float: right;" href="?menu=xeber&tip=add_xeber&category_id=<?php print $category_id;?>" type="button" class="btn btn-sm btn-primary">Yenisini daxil et</a></div>
                <div class="card-body">
                    <!--
                    <div id="custom-toolbar">
                    <div class="form-inline" role="form">
                    <a href="?menu=xeber&tip=add_xeber&category_id=<?php print $category_id;?>" type="button" class="btn btn-outline btn-primary">Add new</a>
                    </div>
                    </div>
                    <br>-->
                    <div id="response"> </div>
                    <div class="dataTable_wrapper">
                        <table class="table-datatable table table-bordered table-hover border-primary table-striped" data-ajax="xeber_datatable.php?category_id=<?php print $category_id;?>"><!-- data-buttons='["excel", "pdf", "print"]'--> 
                            <thead>
                                <tr>                                       
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>    

    <?php
}


if ($_GET['tip']=='delete_xeber'){
    if ($_SESSION['csrftoken']==$_GET['token']) {
        if (time() >= $_SESSION['csrftoken_expire']) {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);
            exit("Token expired. Geri qayit.");
        }else {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);    
            $id = addslashes($_GET['cid']);
            $news_img = $db_link->where("id", $id)->getValue ("news", "img");
            //$news_info = mysql_fetch_array($q);
            @unlink($desired_dir.$news_img);

            $db_link->where('id',$id)->delete('news');
            echo '<script>document.location.href="?menu=xeber&category_id='.$category_id.'";</script>';
        }  
    }else { 
        unset($_SESSION['csrftoken']);
        unset($_SESSION['csrftoken_expire']);
        exit("INVALID TOKEN"); 
    }    
}



if ($_GET['tip']=='edit_xeber'){
    $id = addslashes($_GET['cid']);
    $news_info = $db_link->where ('id', $id)->getOne('news');
    if(!$_POST['edit']) {
        ?>

        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header">
                    <?php print $tbl_category; ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form class="col-lg-12" role="form" name="xeber_edit" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php print $_SESSION['csrftoken']?>"/>
                            <input type="hidden" name="id" value="<?php print $news_info['id']?>" />                    
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#az"  id="az-tab" data-bs-toggle="tab" role="tab" aria-controls="az" aria-selected="true">Azerbaijani</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#en"  id="en-tab" data-bs-toggle="tab" role="tab" aria-controls="en" aria-selected="false">English</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#ru"  id="ru-tab" data-bs-toggle="tab" role="tab" aria-controls="ru" aria-selected="false">Russian</a>
                                </li>    
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade in show active" id="az" role="tabpanel" aria-labelledby="az-tab">
                                    <div class="form-group">
                                        <label>Title</label><input class="form-control" type="text" name="title_az" size="107" value='<?php print stripslashes($news_info['title_az'])?>'>
                                        <label>Kiçik content</label><textarea style="height: 60px;" class="form-control mceNoEditor" id="content_s_az" name="content_s_az" rows="15" cols="80"><?php print stripcslashes($news_info['content_s_az'])?></textarea>
                                        <label>Content</label><textarea class="form-control" id="content_az" name="content_az" rows="15" cols="80"><?php print stripcslashes($news_info['content_az'])?></textarea>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                                    <label>Title</label><input class="form-control" type="text" name="title_en" size="107" value='<?php print stripslashes($news_info['title_en'])?>'>
                                    <label>Kiçik content</label><textarea style="height: 60px;" class="form-control mceNoEditor" id="content_s_en" name="content_s_en" rows="15" cols="80"><?php print stripcslashes($news_info['content_s_en'])?></textarea>
                                    <label>Content</label><textarea class="form-control" id="content_en" name="content_en" rows="15" cols="80"><?php print stripcslashes($news_info['content_en'])?></textarea>
                                </div>

                                <div class="tab-pane fade" id="ru" role="tabpanel" aria-labelledby="ru-tab">
                                    <label>Title</label><input class="form-control" type="text" name="title_ru" size="107" value='<?php print stripslashes($news_info['title_ru'])?>'>
                                    <label>Kiçik content</label><textarea style="height: 60px;" class="form-control mceNoEditor" id="content_s_ru" name="content_s_ru" rows="15" cols="80"><?php print stripcslashes($news_info['content_s_ru'])?></textarea>                                   
                                    <label>Content</label><textarea class="form-control" id="content_ru" name="content_ru" rows="15" cols="80"><?php print stripcslashes($news_info['content_ru'])?></textarea>
                                </div> 


                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Date</label><input class="form-control" type="text" name="news_date" size="22" value='<?php print addslashes($news_info['news_date'])?>'>
                                    </div>  

                                    <div class="col-md-3">
                                        <label>Image</label> <input class="form-control" type="file" name="sekil" accept="image/png, image/gif, image/jpeg" size="42"> <?php print ($news_info['img'])?"<img src='/uploads/articles/$category_id/".$news_info['img']."' border=0 width=50> /uploads/articles/$category_id".$news_info['img']:"";?>
                                    </div>
                                </div>  
                            </div>

                            <br><center>
                                <input class="btn btn-primary" name="edit" type="submit" id="edit" value="Ok"> <input  class="btn btn-primary" type=button value="Cancel" onclick="javascript:history.go(-1);">
                            </center>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <?php
    } 
    elseif($_POST['edit']) {
        if ($_SESSION['csrftoken']==$_POST['token']) {
            if (time() >= $_SESSION['csrftoken_expire']) {
                unset($_SESSION['csrftoken']);
                unset($_SESSION['csrftoken_expire']);
                exit("Token expired. Geri qayit."); 
            }else {
                unset($_SESSION['csrftoken']);
                unset($_SESSION['csrftoken_expire']);

                $img_name = $_FILES['sekil']['name'];
                $file_extension =lcfirst(strtolower(get_file_extension($img_name)));
                if(($file_extension=='jpg')or($file_extension=='gif')or($file_extension=='png')){
                    $target_path = "../uploads/articles/$category_id/"; 
                    $ext = pathinfo($_FILES['sekil']['name'], PATHINFO_EXTENSION);
                    if ($img_name){
                        $img_name = 'news_'.$_GET['category_id'].'_'.$id.'_1.jpg';
                        @move_uploaded_file($_FILES['sekil']['tmp_name'], $target_path.$img_name);
                        $img=$img_name;
                        /*$imgg = new abeautifulsite\SimpleImage($target_path.$img_name);
                        $imgg->best_fit(600, 600)->save($target_path.$img_name);  */
                    } else{
                        $img=''; 
                    }
                }

                $insert_data = array(
                    'news_date' => $_POST['news_date'],
                    'title_az' => $_POST['title_az'],
                    'title_ru' => $_POST['title_ru'],
                    'title_en' => $_POST['title_en'],
                    'content_s_az' => $_POST['content_s_az'],
                    'content_s_ru' => $_POST['content_s_ru'],
                    'content_s_en' => $_POST['content_s_en'],            
                    'content_az' => $_POST['content_az'],
                    'content_ru' => $_POST['content_ru'],
                    'content_en' => $_POST['content_en'],            
                    'description_az' => $_POST['description_az'],
                    'description_ru' => $_POST['description_ru'],
                    'description_en' => $_POST['description_en'],
                    'alias_az' => url_slug($_POST['title_az']),
                    'alias_en' => url_slug($_POST['title_en']),
                    'alias_ru' => url_slug($_POST['title_ru'])
                );       
                $db_link->where('id', $id)->update('news', $insert_data);

                ///print $db_link->getLastQuery(); 

                if($img_name){
                    $insert_data = array(
                        'img' => $img
                    );       
                    $db_link->where('id', $id)->update('news', $insert_data);   
                }

                echo '<script>document.location.href="?menu=xeber&category_id='.$category_id.'";</script>';

            }  
        }else { 
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);
            exit("INVALID TOKEN"); 
        }         
    }
}

if ($_GET['tip']=='add_xeber'){
    if(!$_POST['add']) {
        ?>
        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header">
                    <?php print $tbl_category; ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form class="col-lg-12" role="form" name="xeber_edit" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php print $_SESSION['csrftoken']?>"/>
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#az"  id="az-tab" data-bs-toggle="tab" role="tab" aria-controls="az" aria-selected="true">Azerbaijani</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#en"  id="en-tab" data-bs-toggle="tab" role="tab" aria-controls="en" aria-selected="false">English</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#ru"  id="ru-tab" data-bs-toggle="tab" role="tab" aria-controls="ru" aria-selected="false">Russian</a>
                                </li>    
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade in show active" id="az" role="tabpanel" aria-labelledby="az-tab">
                                    <div class="form-group">
                                        <label>Title</label><input class="form-control" type="text" name="title_az" size="107" value='<?php print stripslashes($news_info['title_az'])?>'>
                                        <label>Kiçik content</label><textarea style="height: 60px;" class="form-control mceNoEditor" id="content_s_az" name="content_s_az" rows="15" cols="80"><?php print stripcslashes($news_info['content_s_az'])?></textarea>
                                        <label>Content</label><textarea class="form-control" id="content_az" name="content_az" rows="15" cols="80"><?php print stripcslashes($news_info['content_az'])?></textarea>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                                    <label>Title</label><input class="form-control" type="text" name="title_en" size="107" value='<?php print stripslashes($news_info['title_en'])?>'>
                                    <label>Kiçik content</label><textarea style="height: 60px;" class="form-control mceNoEditor" id="content_s_en" name="content_s_en" rows="15" cols="80"><?php print stripcslashes($news_info['content_s_en'])?></textarea>
                                    <label>Content</label><textarea class="form-control" id="content_en" name="content_en" rows="15" cols="80"><?php print stripcslashes($news_info['content_en'])?></textarea>
                                </div>

                                <div class="tab-pane fade" id="ru" role="tabpanel" aria-labelledby="ru-tab">
                                    <label>Title</label><input class="form-control" type="text" name="title_ru" size="107" value='<?php print stripslashes($news_info['title_ru'])?>'>
                                    <label>Kiçik content</label><textarea style="height: 60px;" class="form-control mceNoEditor" id="content_s_ru" name="content_s_ru" rows="15" cols="80"><?php print stripcslashes($news_info['content_s_ru'])?></textarea>                                   
                                    <label>Content</label><textarea class="form-control" id="content_ru" name="content_ru" rows="15" cols="80"><?php print stripcslashes($news_info['content_ru'])?></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Date</label><input class="form-control" type="text" name="news_date" size="22" value='<?php print date('Y-m-d')?>'>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Image</label> <input class="form-control" type="file" name="sekil" accept="image/png, image/gif, image/jpeg" size="42"> <?php print ($news_info['img'])?"<img src='/uploads/images/".$news_info['img']."' border=0 width=50> /uploads/images/".$news_info['img']:"";?>
                                    </div>
                                    <!--
                                    <div class="form-group col-md-3">
                                    <label>Image2</label> <input class="form-control" type="file" name="sekil1" size="42"> <?php print ($news_info['img1'])?"<img src='/uploads/images/".$news_info['img1']."' border=0 width=50> /uploads/images/".$news_info['img1']:"";?>
                                    </div>
                                    <div class="form-group col-md-3">
                                    <label>Image3</label> <input class="form-control" type="file" name="sekil2" size="42"> <?php print ($news_info['img2'])?"<img src='/uploads/images/".$news_info['img2']."' border=0 width=50> /uploads/images/".$news_info['img2']:"";?>
                                    </div>
                                    <div class="form-group col-md-3">
                                    <label>Image4</label> <input class="form-control" type="file" name="sekil3" size="42"> <?php print ($news_info['img3'])?"<img src='/uploads/images/".$news_info['img3']."' border=0 width=50> /uploads/images/".$news_info['img3']:"";?>
                                    </div>
                                    <div class="form-group col-md-3">
                                    <label>Image5</label> <input class="form-control" type="file" name="sekil4" size="42"> <?php print ($news_info['img4'])?"<img src='/uploads/images/".$news_info['img4']."' border=0 width=50> /uploads/images/".$news_info['img4']:"";?>
                                    </div> -->                               
                                </div>                                
                            </div>

                            <br>
                            <center>
                                <input class="btn btn-primary" name="add" type="submit" id="edit" value="Ok"> <input  class="btn btn-primary" type=button value="Cancel" onclick="javascript:history.go(-1);">
                            </center>
                        </form>
                    </div>
                </div>

            </div>
        </div>       
        <?php
    } 
    elseif($_POST['add']) {
        if ($_SESSION['csrftoken']==$_POST['token']) {
            if (time() >= $_SESSION['csrftoken_expire']) {
                unset($_SESSION['csrftoken']);
                unset($_SESSION['csrftoken_expire']);                
                exit("Token expired. Geri qayit."); 
            }else {
                unset($_SESSION['csrftoken']);
                unset($_SESSION['csrftoken_expire']);

                $news_id = $db_link->where("category_id", $category_id)->getValue ("news", "max(id)")+1;          
                $target_path = "../uploads/articles/$category_id/"; 

                $img_name = $_FILES['sekil']['name'];
                $file_extension =lcfirst(strtolower(get_file_extension($img_name)));
                if(($file_extension=='jpg')or($file_extension=='gif')or($file_extension=='png')){ 
                    $ext = pathinfo($_FILES['sekil']['name'], PATHINFO_EXTENSION);
                    if ($img_name){
                        $img_name = 'news_'.$_GET['category_id'].'_'.$news_id.'_1.'.$ext;
                        @move_uploaded_file($_FILES['sekil']['tmp_name'], $target_path.$img_name);
                        $img=$img_name;
                        /*$imgg = new abeautifulsite\SimpleImage($target_path.$img_name);
                        $imgg->best_fit(600, 600)->save($target_path.$img_name);*/
                    } else{
                        $img=''; 
                    }
                }

                $insert_data = array(
                    'news_date' => $_POST['news_date'],
                    'title_az' => $_POST['title_az'],
                    'title_ru' => $_POST['title_ru'],
                    'title_en' => $_POST['title_en'],
                    'content_s_az' => $_POST['content_s_az'],
                    'content_s_ru' => $_POST['content_s_ru'],
                    'content_s_en' => $_POST['content_s_en'],
                    'content_az' => $_POST['content_az'],
                    'content_ru' => $_POST['content_ru'],
                    'content_en' => $_POST['content_en'],
                    'description_az' => $_POST['description_az'],
                    'description_ru' => $_POST['description_ru'],
                    'description_en' => $_POST['description_en'],            
                    'alias_az' => url_slug($_POST['title_az']),
                    'alias_en' => url_slug($_POST['title_en']),
                    'alias_ru' => url_slug($_POST['title_ru']),
                    'category_id' => $_GET['category_id'],
                    'img' => $img                    
                );       
                $db_link->insert ('news', $insert_data); 
                //print $db_link->getLastQuery();
                echo '<script>document.location.href="?menu=xeber&category_id='.$category_id.'";</script>';

            }  
        }else { 
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);
            exit("INVALID TOKEN"); 
        }         

    }
}
?>