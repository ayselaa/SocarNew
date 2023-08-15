<?php
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}
if(!$security_test) exit;
$category_id=$_GET['category_id'];                   

$desired_dir="../uploads/video/$category_id/";
if(is_dir($desired_dir)==false){
    mkdir($desired_dir, 0755);
} 

$tbl_category = $db_link->where("id", $category_id)->getValue ("category", "name_az");

?>                                            
<?php
if ($_GET['tip']=='delete_video') {
    if ($_SESSION['csrftoken']==$_GET['token']) {
        if (time() >= $_SESSION['csrftoken_expire']) {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);
            exit("Token expired. Geri qayit.");
        }else {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']); 
            $db_link->where('id',$_GET['id'])->delete('video');
            @unlink($desired_dir.$_GET['fayl']);
            $relink="?menu=video&category_id=".$_GET['category_id'];           
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
                'link' => $_POST['link'],
                'ytid' => getYTID($_POST['link']),
                'name_az' => $_POST['name_az'],
                'name_en' => $_POST['name_en'],
                'name_ru' => $_POST['name_ru']
            );       
            $cat_id = $db_link->insert ('video', $insert_data);    

/*            $saat=date("YmdHis");
            $target_path = $desired_dir;
            if ($_FILES['uploaded_az']['name']){
                $ext_az = pathinfo($_FILES['uploaded_az']['name'], PATHINFO_EXTENSION);
                $img_name_az = 'video'.$_GET['category_id'].'_az_'.$saat.'.jpg';
                $target_path_az = $target_path.$img_name_az;
                if(move_uploaded_file($_FILES['uploaded_az']['tmp_name'], $target_path_az)){
                    $insert_data = array(
                        'file_az' => $img_name_az
                    );        
                    $db_link->where('id', $cat_id)->update('video', $insert_data);  
                }  
            }*/  

            $relink="?menu=video&category_id=".$_GET['category_id'];
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
            /*$saat=date("YmdHis");
            $target_path = $desired_dir;
            $multimedia_info = $db_link->where ('id', $id)->getOne('video');
            if ($_FILES['uploaded_az']['name']){
                $ext_az = pathinfo($_FILES['uploaded_az']['name'], PATHINFO_EXTENSION);
                $img_name_az = 'video'.$_GET['category_id'].'_az_'.$saat.'.jpg';
                $target_path_az = $target_path.$img_name_az;
                if(move_uploaded_file($_FILES['uploaded_az']['tmp_name'], $target_path_az)){
                    @unlink($target_path.$multimedia_info['file_az']);
                    $insert_data = array(
                        'file_az' => $img_name_az
                    );        
                    $db_link->where('id', $id)->update('video', $insert_data); 

                } 
            }*/            

            $insert_data = array(
                'name_az' => $_POST['name_az'],
                'name_en' => $_POST['name_en'],
                'name_ru' => $_POST['name_ru'],
                'link' => $_POST['link'],
                'ytid' => getYTID($_POST['link'])
            );        
            $db_link->where('id', $id)->update('video', $insert_data); 

            $relink="?menu=video&category_id=".$_GET['category_id'];
            echo '<script>document.location.href="'.$relink.'";</script>'; 
        }  
    }else { 
        unset($_SESSION['csrftoken']);
        unset($_SESSION['csrftoken_expire']);
        exit("INVALID TOKEN"); 
    }
}

if ($_GET['tip']=='add_video'){
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
                            <!--<label>File</label><input class="form-control" name="uploaded_az" type="file">-->
                            <label>Title Az</label><input class="form-control" name="name_az" type="text" value="<?php print $multimedia_info['name_az'];?>">
                            <label>Title En</label><input class="form-control" name="name_en" type="text" value="<?php print $multimedia_info['name_az'];?>">
                            <label>Title Ru</label><input class="form-control" name="name_ru" type="text" value="<?php print $multimedia_info['name_az'];?>">
                            <label>Link</label><input class="form-control" name="link" type="text" value="<?php print $multimedia_info['link'];?>">
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

if ($_GET['tip']=='edit_video'){
    $id = addslashes($_GET['id']);
    $multimedia_info = $db_link->where ('id', $id)->getOne('video');

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
                            <!--<label>File</label><input class="form-control" name="uploaded_az" type="file"><?php print $multimedia_info['file_az'];?><br>-->
                            <label>Title Az</label><input class="form-control" name="name_az" type="text" value="<?php print $multimedia_info['name_az'];?>">
                            <label>Title En</label><input class="form-control" name="name_en" type="text" value="<?php print $multimedia_info['name_en'];?>">
                            <label>Title Ru</label><input class="form-control" name="name_ru" type="text" value="<?php print $multimedia_info['name_ru'];?>">
                            <label>Link</label><input class="form-control" name="link" type="text" value="<?php print $multimedia_info['link'];?>">
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
                            <a href="?menu=video&tip=add_video&category_id=<?php print $category_id;?>" type="button" class="btn btn-outline btn-primary">Add new</a>
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
                                $video_info = $db_link->where ('m_id', $category_id)->get('video');
                                foreach ($video_info as $video) {                                    
                                    $id=$video['id'];
                                    $ytid=$video['ytid'];
                                    $name_az=$video['name_az'];
                                    $name_en=$video['name_en'];
                                    $name_ru=$video['name_ru'];

                                    print "<tr class='odd gradeA'>
                                    <td><img src='https://img.youtube.com/vi/$ytid/sddefault.jpg' width='70'></td>
                                    <td>$name_az</td>
                                    <td class='center'>
                                    <a href='?menu=video&category_id=$category_id&id=$id&tip=edit_video'><span class='btn btn-sm btn-success fi fi-pencil'></span></a>
                                    <a onclick='Del(\"?menu=video&tip=add_video_file&fayl=$file&file_type=image&category_id=$category_id&id=$id&tip=delete_video&token=$csrftoken\");' href='JavaScript:;'><span class='btn btn-sm btn-danger fi fi-thrash'></span></a>
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