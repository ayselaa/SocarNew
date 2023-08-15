<?php
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}
if(!$security_test) exit;
$category_id=$_GET['category_id'];                   

$desired_dir="../uploads/photos/$category_id/";
if(is_dir($desired_dir)==false){
    mkdir($desired_dir, 0755);
} 

$tbl_category = $db_link->where("id", $category_id)->getValue ("category", "name_az");

?>                                            
<?php
if ($_GET['tip']=='delete_photos') {
    if ($_SESSION['csrftoken']==$_GET['token']) {
        if (time() >= $_SESSION['csrftoken_expire']) {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);
            exit("Token expired. Geri qayit.");
        }else {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']); 
            $db_link->where('id',$_GET['id'])->delete('photos');
            //@unlink("../uploads/".$_GET['fayl']);
            $relink="?menu=photos&category_id=".$_GET['category_id'];           
            echo '<script>document.location.href="'.$relink.'";</script>';
        }  
    }else { 
        unset($_SESSION['csrftoken']);
        unset($_SESSION['csrftoken_expire']);
        exit("INVALID TOKEN"); 
    }
}

if($_POST['add']) {
    if ($_SESSION['csrftoken']==$_POST['token']) {
        if (time() >= $_SESSION['csrftoken_expire']) {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);
            exit("Token expired. Geri qayit.");
        }else {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']); 
            $insert_data = array(
                'm_id' => $_GET['category_id'],
                'name_az' => $_POST['name_az'],
                'name_en' => $_POST['name_en'],
                'name_ru' => $_POST['name_ru'],
                'content_az' => $_POST['content_az'],
                'content_en' => $_POST['content_en'],
                'content_ru' => $_POST['content_ru'],
                'link_az' => $_POST['link_az'],
                'link_en' => $_POST['link_en'],
                'link_ru' => $_POST['link_ru']        
            );       
            $cat_id = $db_link->insert ('photos', $insert_data);    

            $saat=date("YmdHis");
            $target_path = $desired_dir;

            $img_name = $_FILES['uploaded_az']['name'];
            $file_extension =lcfirst(strtolower(get_file_extension($img_name)));
            if(($file_extension=='jpg')or($file_extension=='gif')or($file_extension=='png')or($file_extension=='mp4')){
                if ($_FILES['uploaded_az']['name']){
                    $ext_az = pathinfo($_FILES['uploaded_az']['name'], PATHINFO_EXTENSION);
                    $img_name_az = 'photos'.$_GET['category_id'].'_az_'.$saat.'.'.$ext_az;
                    $target_path_az = $target_path.$img_name_az;
                    if(move_uploaded_file($_FILES['uploaded_az']['tmp_name'], $target_path_az)){
                        $insert_data = array(
                            'file' => "photos/".$_GET['category_id']."/".$img_name_az
                        );        
                        $db_link->where('id', $cat_id)->update('photos', $insert_data);  
                    }  
                }  
            }  
            $relink="?menu=photos&category_id=".$_GET['category_id'];
            echo '<script>document.location.href="'.$relink.'";</script>';               
        }  
    }else { 
        unset($_SESSION['csrftoken']);
        unset($_SESSION['csrftoken_expire']);
        exit("INVALID TOKEN"); 
    }
}

if($_POST['edit']) {
    if ($_SESSION['csrftoken']==$_POST['token']) {
        if (time() >= $_SESSION['csrftoken_expire']) {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);
            exit("Token expired. Geri qayit.");
        }else {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']); 
            $id = addslashes($_GET['id']);
            $saat=date("YmdHis");
            $target_path = $desired_dir;
            $multimedia_info = $db_link->where ('id', $id)->getOne('photos');

            $img_name = $_FILES['uploaded_az']['name'];
            $file_extension =lcfirst(strtolower(get_file_extension($img_name)));
            if(($file_extension=='jpg')or($file_extension=='gif')or($file_extension=='png')or($file_extension=='mp4')){
                if ($_FILES['uploaded_az']['name']){
                    $ext_az = pathinfo($_FILES['uploaded_az']['name'], PATHINFO_EXTENSION);
                    $img_name_az = 'photos'.$_GET['category_id'].'_az_'.$saat.'.'.$ext_az;
                    $target_path_az = $target_path.$img_name_az;
                    if(move_uploaded_file($_FILES['uploaded_az']['tmp_name'], $target_path_az)){
                        @unlink($target_path.$multimedia_info['file_az']);
                        $insert_data = array(
                            'file' => "photos/".$_GET['category_id']."/".$img_name_az
                        );        
                        $db_link->where('id', $id)->update('photos', $insert_data); 

                    } 
                } 
            } 

            $insert_data = array(
                'name_az' => $_POST['name_az'],
                'name_en' => $_POST['name_en'],
                'name_ru' => $_POST['name_ru'],
                'content_az' => $_POST['content_az'],
                'content_en' => $_POST['content_en'],
                'content_ru' => $_POST['content_ru'],				
                'link_az' => $_POST['link_az'],
                'link_en' => $_POST['link_en'],
                'link_ru' => $_POST['link_ru']
            );        
            $db_link->where('id', $id)->update('photos', $insert_data); 

            $relink="?menu=photos&category_id=".$_GET['category_id'];
            echo '<script>document.location.href="'.$relink.'";</script>'; 
        }  
    }else { 
        unset($_SESSION['csrftoken']);
        unset($_SESSION['csrftoken_expire']);
        exit("INVALID TOKEN"); 
    }
}

if ($_GET['tip']=='add_photos'){
    ?>
    <div class="col-lg-12">
        <div class="card card-primary mb-3">
            <div class="card-header">
                <?php print $tbl_category; ?>
            </div>
            <div class="card-body">
                <div class="row">
                    <form class="col-lg-12" role="form" name="file_edit" action="" method="post" enctype="multipart/form-data">
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
                            <div class="tab-pane fade show active" id="az" role="tabpanel" aria-labelledby="az-tab">
                                <label>Title</label><input class="form-control" name="name_az" type="text" value="<?php print $multimedia_info['name_az'];?>"><br>
                                <label>Content</label><input class="form-control" name="content_az" type="text" value="<?php print $multimedia_info['content_az'];?>">                            
                                <label>Link</label><input class="form-control" name="link_az" type="text" value="<?php print $multimedia_info['link_az'];?>">
                            </div>
                            <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                                <label>Title</label><input class="form-control" name="name_en" type="text" value="<?php print $multimedia_info['name_en'];?>"><br>
                                <label>Content</label><input class="form-control" name="content_en" type="text" value="<?php print $multimedia_info['content_en'];?>">                            
                                <label>Link</label><input class="form-control" name="link_en" type="text" value="<?php print $multimedia_info['link_en'];?>">
                            </div>
                            <div class="tab-pane fade" id="ru" role="tabpanel" aria-labelledby="ru-tab">
                                <label>Title</label><input class="form-control" name="name_ru" type="text" value="<?php print $multimedia_info['name_ru'];?>"><br>
                                <label>Content</label><input class="form-control" name="content_ru" type="text" value="<?php print $multimedia_info['content_ru'];?>">							
                                <label>Link</label><input class="form-control" name="link_ru" type="text" value="<?php print $multimedia_info['link_ru'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>File</label><input class="form-control" name="uploaded_az" type="file" accept="image/png, image/gif, image/jpeg, video/mp4">
                        </div>
                        <br><center>
                            <input class="btn btn-primary" name="add" type="submit" id="edit" value="OK"> <input  class="btn btn-primary" type=button value="Cancel" onclick="javascript:history.go(-1);">
                        </center>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <?php
}

if ($_GET['tip']=='edit_photos'){
    $id = addslashes($_GET['id']);
    $multimedia_info = $db_link->where ('id', $id)->getOne('photos');

    ?>
    <div class="col-lg-12">
        <div class="card card-primary mb-3">
            <div class="card-header">
                <?php print $tbl_category; ?>
            </div>
            <div class="card-body">
                <div class="row">
                    <form class="col-lg-12" role="form" name="file_edit" action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="token" value="<?php print $_SESSION['csrftoken']?>"/>
                        <input type="hidden" name="id" value="<?php print $multimedia_info['id']?>" />                    
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
                            <div class="tab-pane fade show active" id="az" role="tabpanel" aria-labelledby="az-tab">
                                <label>Title</label><input class="form-control" name="name_az" type="text" value="<?php print $multimedia_info['name_az'];?>"><br>
                                <label>Content</label><input class="form-control" name="content_az" type="text" value="<?php print $multimedia_info['content_az'];?>">                            
                                <label>Link</label><input class="form-control" name="link_az" type="text" value="<?php print $multimedia_info['link_az'];?>">
                            </div>
                            <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                                <label>Title</label><input class="form-control" name="name_en" type="text" value="<?php print $multimedia_info['name_en'];?>"><br>
                                <label>Content</label><input class="form-control" name="content_en" type="text" value="<?php print $multimedia_info['content_en'];?>">                            
                                <label>Link</label><input class="form-control" name="link_en" type="text" value="<?php print $multimedia_info['link_en'];?>">
                            </div>
                            <div class="tab-pane fade" id="ru" role="tabpanel" aria-labelledby="ru-tab">
                                <label>Title</label><input class="form-control" name="name_ru" type="text" value="<?php print $multimedia_info['name_ru'];?>"><br>
                                <label>Content</label><input class="form-control" name="content_ru" type="text" value="<?php print $multimedia_info['content_ru'];?>">                            
                                <label>Link</label><input class="form-control" name="link_ru" type="text" value="<?php print $multimedia_info['link_ru'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>File</label><input class="form-control" name="uploaded_az" type="file" accept="image/png, image/gif, image/jpeg ,video/mp4">
                        </div>
                        <br><center>
                            <input class="btn btn-primary" name="edit" type="submit" id="edit" value="OK"> <input  class="btn btn-primary" type=button value="Cancel" onclick="javascript:history.go(-1);">
                        </center>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <?php
}

if (empty($_GET['tip'])){
    ?>    
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header"> <?php print $tbl_category; ?>  <a style="float: right" href="?menu=photos&tip=add_photos&category_id=<?php print $category_id;?>" type="button" class="btn btn-sm btn-primary">Add new</a></div>
                <div class="card-body">
                    <div id="response"> </div>
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="listPhotos">
                            <thead>
                                <tr>
                                    <th>File</th>
                                    <th>Title </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $photos_info = $db_link->orderBy("sira","asc")->where ('m_id', $category_id)->get('photos');
                                foreach ($photos_info as $photos) {                                    
                                    $id=$photos['id'];
                                    $file=$photos['file'];
                                    $name_az=$photos['name_az'];

                                    print "<tr class='odd gradeA' id='arrayorder_$id'>
                                    <td style='cursor:move'>$file</td>
                                    <td>$name_az</td>
                                    <td class='center'>
                                    <a href='?menu=photos&category_id=$category_id&id=$id&tip=edit_photos'><span class='btn btn-outline btn-primary fi fi-pencil'></span></a>
                                    <a onclick='Del(\"?menu=photos&tip=add_photos_file&fayl=$file&file_type=image&category_id=$category_id&id=$id&tip=delete_photos&token=$csrftoken\");' href='JavaScript:;'><span class='btn btn-outline btn-danger fi fi-thrash'></span></a>
                                    </td>
                                    </tr>";
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <?php
}
?>