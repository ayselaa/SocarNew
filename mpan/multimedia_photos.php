<?php
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}
//if(!$security_test) exit;
$category_id=$_GET['category_id'];                   

$desired_dir="../uploads/mediafile/$category_id/";
if(is_dir($desired_dir)==false){
    mkdir($desired_dir, 0755);
} 

$tbl_category = "Fotoqalereya ". $db_link->where("id", $category_id)->getValue ("multimedia", "name_az");


if ($_GET['tip']=='delete_multimedia_photos') {
    if ($_SESSION['csrftoken']==$_GET['token']) {
        if (time() >= $_SESSION['csrftoken_expire']) {
            exit("Token expired. Geri qayit.");
        }else {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);     
            $db_link->where('id',$_GET['id'])->delete('multimedia_file');
            //@unlink($desired_dir.$_GET['fayl']);
            $relink="?menu=multimedia_photos&category_id=".$_GET['category_id'];
            echo '<script>document.location.href="'.$relink.'";</script>';
        }  
    }else { 
        exit("INVALID TOKEN"); 
    }      
}

if($_POST['add']) {
    if ($_SESSION['csrftoken']==$_POST['token']) {
        if (time() >= $_SESSION['csrftoken_expire']) {
            exit("Token expired. Geri qayit.");
        }else {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);
            $insert_data = array(
                'm_id' => $_GET['category_id'],
                'name_az' => $_POST['name_az'],
                'name_en' => $_POST['name_en'],
                'name_ru' => $_POST['name_ru']
            );       
            $cat_id = $db_link->insert ('multimedia_file', $insert_data);    

            $saat=date("YmdHis");
            $target_path = $desired_dir;

            if ($_FILES['uploaded_az']['name']){
                $img_name = $_FILES['uploaded_az']['name'];
                $file_extension =lcfirst(strtolower(get_file_extension($img_name)));
                if(($file_extension=='jpg')or($file_extension=='gif')or($file_extension=='png')){
                    $ext_az = pathinfo($_FILES['uploaded_az']['name'], PATHINFO_EXTENSION);
                    $img_name_az = 'multimedia_file_'.$saat.'.'.$ext_az;
                    $target_path_az = $target_path.$img_name_az;
                    if(move_uploaded_file($_FILES['uploaded_az']['tmp_name'], $target_path_az)){
                        $insert_data = array(
                            'file' => "mediafile/".$category_id."/".$img_name_az
                        );        
                        $db_link->where('id', $cat_id)->update('multimedia_file', $insert_data);  
                    }  
                }  
            }  

            $relink="?menu=multimedia_photos&category_id=".$_GET['category_id'];
            echo '<script>document.location.href="'.$relink.'";</script>';
        }               
    }else { 
        exit("INVALID TOKEN"); 
    }
}


if($_POST['edit']) {
    if ($_SESSION['csrftoken']==$_POST['token']) {
        if (time() >= $_SESSION['csrftoken_expire']) {
            exit("Token expired. Geri qayit.");
        }else {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);     
            $id = addslashes($_GET['id']);
            $saat=date("YmdHis");
            $target_path = $desired_dir;
            $multimedia_info = $db_link->where ('id', $id)->getOne('multimedia_file');

            if ($_FILES['uploaded_az']['name']){
                $img_name = $_FILES['uploaded_az']['name'];
                $file_extension =lcfirst(strtolower(get_file_extension($img_name)));
                if(($file_extension=='jpg')or($file_extension=='gif')or($file_extension=='png')){
                    $ext_az = pathinfo($_FILES['uploaded_az']['name'], PATHINFO_EXTENSION);
                    $img_name_az = 'multimedia_file'.$saat.'.'.$ext_az;
                    $target_path_az = $target_path.$img_name_az;
                    if(move_uploaded_file($_FILES['uploaded_az']['tmp_name'], $target_path_az)){
                        @unlink($target_path.$multimedia_info['file']);
                        $insert_data = array(
                            'file' => "mediafile/".$category_id."/".$img_name_az
                        );        
                        $db_link->where('id', $id)->update('multimedia_file', $insert_data); 

                    }  
                }  
            }  
            /*    $ext_en = pathinfo($_FILES['uploaded_en']['name'], PATHINFO_EXTENSION);
            $img_name_en = 'multimedia_photos'.$_GET['category_id'].'_en_'.$saat.'.'.$ext_en;
            $target_path_en = $target_path.$img_name_en;
            if(move_uploaded_file($_FILES['uploaded_en']['tmp_name'], $target_path_en)){
            @unlink($target_path.$multimedia_info['file_en']);
            $sql = "UPDATE multimedia_photos SET  file_en = '".$img_name_en."' WHERE id = '".$id."'";
            $q = mysql_query($sql);
            }    

            $ext_ru = pathinfo($_FILES['uploaded_ru']['name'], PATHINFO_EXTENSION);            
            $img_name_ru = 'multimedia_photos'.$_GET['category_id'].'_ru_'.$saat.'.'.$ext_ru;
            $target_path_ru = $target_path.$img_name_ru;
            if(move_uploaded_file($_FILES['uploaded_ru']['tmp_name'], $target_path_ru)){
            @unlink($target_path.$multimedia_info['file_ru']);
            $sql = "UPDATE multimedia_photos SET  file_ru = '".$img_name_ru."' WHERE id = '".$id."'";
            $q = mysql_query($sql);
            }*/             

            $insert_data = array(
                'name_az' => $_POST['name_az'],
                'name_en' => $_POST['name_en'],
                'name_ru' => $_POST['name_ru']
            );        
            $db_link->where('id', $id)->update('multimedia_file', $insert_data); 

            $relink="?menu=multimedia_photos&category_id=".$_GET['category_id'];
            echo '<script>document.location.href="'.$relink.'";</script>'; 
        }               
    }else { 
        exit("INVALID TOKEN"); 
    }                   
}

if ($_GET['tip']=='add_multimedia_photos'){
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

                        <div class="form-group">
                            <label>File</label><input class="form-control" name="uploaded_az" type="file" accept="image/png, image/gif, image/jpeg">
                            <label>Title Az</label><input class="form-control" name="name_az" type="text" value="<?php print $multimedia_info['name_az'];?>">
                            <label>Title En</label><input class="form-control" name="name_en" type="text" value="<?php print $multimedia_info['name_en'];?>">
                            <label>Title Ru</label><input class="form-control" name="name_ru" type="text" value="<?php print $multimedia_info['name_ru'];?>">
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

if ($_GET['tip']=='edit_multimedia_photos'){
    $id = addslashes($_GET['id']);
    $multimedia_info = $db_link->where ('id', $id)->getOne('multimedia_file');

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
                        <div class="form-group">
                            <label>File</label><input class="form-control" name="uploaded_az" type="file" accept="image/png, image/gif, image/jpeg"><?php print $multimedia_info['file'];?><br>
                            <label>Title Az</label><input class="form-control" name="name_az" type="text" value="<?php print $multimedia_info['name_az'];?>">
                            <label>Title En</label><input class="form-control" name="name_en" type="text" value="<?php print $multimedia_info['name_en'];?>">
                            <label>Title Ru</label><input class="form-control" name="name_ru" type="text" value="<?php print $multimedia_info['name_ru'];?>">
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
                <div class="card-header"> <?php print $tbl_category; ?>  </div>
                <div class="card-body">

                    <div id="custom-toolbar">
                        <div class="form-inline" role="form">
                            <a href="?menu=multimedia_photos&tip=add_multimedia_photos&category_id=<?php print $category_id;?>" type="button" class="btn btn-outline btn-primary">Add new</a>
                        </div>
                    </div>
                    <br>

                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>File</th>
                                    <th>Title </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $multimedia_photos_info = $db_link->where ('m_id', $category_id)->get('multimedia_file');
                                foreach ($multimedia_photos_info as $multimedia_photos) {                                    
                                    $id=$multimedia_photos['id'];
                                    $file=$multimedia_photos['file'];
                                    $name_az=$multimedia_photos['name_az'];
                                    $name_en=$multimedia_photos['name_en'];
                                    $name_ru=$multimedia_photos['name_ru'];

                                    print "<tr>
                                    <td><img src='../uploads/".$file."' border=0 width=50></td>
                                    <td>$name_az</td>
                                    <td class='center'>
                                    <a href='?menu=multimedia_photos&category_id=$category_id&id=$id&tip=edit_multimedia_photos'><span class='btn btn-sm btn-success fi fi-pencil'></span></a>
                                    <a onclick='Del(\"?menu=multimedia_photos&tip=delete_multimedia_photos&fayl=$file&file_type=image&category_id=$category_id&id=$id&token=$csrftoken\");' href='JavaScript:;'><span class='btn btn-sm btn-danger fi fi-thrash'></span></a>
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