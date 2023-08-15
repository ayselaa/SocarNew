<?php
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}

//if ($_GET['tip']==) $multimedia_date=$multimedia_info['multimedia_date']; else $multimedia_date=date('Y-m-d');
$category_id=$_GET['category_id'];


$desired_dir="../uploads/media/$category_id/";
if(is_dir($desired_dir)==false){
    mkdir($desired_dir, 0755);
}
$tbl_category = $db_link->where("id", $category_id)->getValue ("category", "name_az");

if (empty($_GET['tip'])){

    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header"> <?php print $tbl_category; ?>  </div>
                <div class="card-body">

                    <div id="custom-toolbar">
                        <div class="form-inline" role="form">
                            <a href="?menu=multimedia&tip=add_multimedia&category_id=<?php print $category_id;?>" type="button" class="btn btn-outline btn-primary">Add new</a>
                        </div>
                    </div>
                    <br>
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $multimedia_info = $db_link->orderBy("id","desc")->where ('category_id', $category_id)->get('multimedia');
                                foreach ($multimedia_info as $multimedia) {
                                    $id = stripslashes($multimedia['id']);
                                    $file = stripslashes($multimedia['img']);
                                    $name_az = stripslashes($multimedia['name_az']);

                                    print "<tr>
                                    <td><img src='../uploads/".$file."' border=0 width=50></td>
                                    <td>$name_az</td>
                                    <td class='center'>
                                    <a href='?menu=multimedia_photos&category_id=$id'><span class='btn btn-sm btn-primary fi fi-image'></span></a>
                                    <a href='?menu=multimedia&tip=edit_multimedia&category_id=$category_id&cid=$id'><span class='btn btn-sm btn-success fi fi-pencil'></span></a>
                                    <a onclick='Del(\"?menu=multimedia&tip=delete_multimedia&category_id=$category_id&cid=$id&token=$csrftoken\");' href='JavaScript:;'><span class='btn btn-sm btn-danger fi fi-thrash'></span></a>
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


if ($_GET['tip']=='delete_multimedia'){
    if ($_SESSION['csrftoken']==$_GET['token']) {
        if (time() >= $_SESSION['csrftoken_expire']) {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);
            exit("Token expired. Geri qayit.");
        }else {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);    
            $id = addslashes($_GET['cid']);
            $multimedia_img = $db_link->where("id", $id)->getValue ("multimedia", "img");
            @unlink($desired_dir.$multimedia_img);
            $db_link->where('id',$id)->delete('multimedia');
            echo '<script>document.location.href="?menu=multimedia&category_id='.$category_id.'";</script>';
        }  
    }else { 
        unset($_SESSION['csrftoken']);
        unset($_SESSION['csrftoken_expire']);
        exit("INVALID TOKEN"); 
    }    
}



if ($_GET['tip']=='edit_multimedia'){
    $id = addslashes($_GET['cid']);
    $multimedia_info = $db_link->where ('id', $id)->getOne('multimedia');

    if(!$_POST['edit']) {
        ?>

        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header">
                    <?php print $tbl_category; ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form class="col-lg-12" role="form" name="multimedia_edit" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php print $_SESSION['csrftoken']?>"/>
                            <input type="hidden" name="id" value="<?php print $multimedia_info['id']?>" />                    
                            <div class="tab-content" id="myTabContent">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Title Az</label> <input class="form-control" type="text" name="name_az" size="107" value='<?php print stripslashes($multimedia_info['name_az'])?>'>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Title En</label> <input class="form-control" type="text" name="name_en" size="107" value='<?php print stripslashes($multimedia_info['name_en'])?>'>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Title Ru</label> <input class="form-control" type="text" name="name_ru" size="107" value='<?php print stripslashes($multimedia_info['name_ru'])?>'>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Image</label> <input class="form-control" type="file" name="sekil" size="42" accept="image/png, image/gif, image/jpeg"> <?php print ($multimedia_info['img'])?"<img src='/uploads/".$multimedia_info['img']."' border=0 width=50> /uploads/".$multimedia_info['img']:"";?>
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

                $target_path = "../uploads/media/$category_id/"; 
                $img_name = $_FILES['sekil']['name'];
                $file_extension =lcfirst(strtolower(get_file_extension($img_name)));
                if(($file_extension=='jpg')or($file_extension=='gif')or($file_extension=='png')){
                    $ext = pathinfo($_FILES['sekil']['name'], PATHINFO_EXTENSION);
                    if ($img_name){
                        $img_name = 'multimedia_cover_'.$multimedia_id.'.'.$ext;
                        @move_uploaded_file($_FILES['sekil']['tmp_name'], $target_path.$img_name);
                        $img=$img_name;
                    } else{
                        $img=''; 
                    }
                }

                $insert_data = array(
                    'name_az' => $_POST['name_az'],
                    'name_ru' => $_POST['name_ru'],
                    'name_en' => $_POST['name_en'],
                    'alias_az' => url_slug($_POST['name_az']),
                    'alias_en' => url_slug($_POST['name_en']),
                    'alias_ru' => url_slug($_POST['name_ru']),                    
                    'category_id' => $category_id
                );       
                $db_link->where('id', $id)->update('multimedia', $insert_data); 

                if($img_name){
                    $insert_data = array(
                        'img' => "media/".$category_id."/".$img
                    );       
                    $db_link->where('id', $id)->update('multimedia', $insert_data);   
                }

                echo '<script>document.location.href="?menu=multimedia&category_id='.$category_id.'";</script>';

            }  
        }else { 
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);
            exit("INVALID TOKEN"); 
        }         
    }
}

if ($_GET['tip']=='add_multimedia'){
    if(!$_POST['add']) {
        ?>
        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header">
                    <?php print $tbl_category; ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form class="col-lg-12" role="form" name="multimedia_edit" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php print $_SESSION['csrftoken']?>"/>
                            <div class="tab-content" id="myTabContent">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Title Az</label> <input class="form-control" type="text" name="name_az" size="107" value='<?php print stripslashes($multimedia_info['name_az'])?>'>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Title En</label> <input class="form-control" type="text" name="name_en" size="107" value='<?php print stripslashes($multimedia_info['name_en'])?>'>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Title Ru</label> <input class="form-control" type="text" name="name_ru" size="107" value='<?php print stripslashes($multimedia_info['name_ru'])?>'>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Image</label> <input class="form-control" type="file" name="sekil" size="42" accept="image/png, image/gif, image/jpeg"> <?php print ($multimedia_info['img'])?"<img src='/uploads/media/$category_id/".$multimedia_info['img']."' border=0 width=50> /uploads/media/$category_id".$multimedia_info['img']:"";?>
                                    </div>
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

                $multimedia_id = $db_link->where("category_id", $category_id)->getValue ("multimedia", "max(id)")+1;          
                $target_path = "../uploads/media/$category_id/"; 

                $img_name = $_FILES['sekil']['name'];
                $file_extension =lcfirst(strtolower(get_file_extension($img_name)));
                if(($file_extension=='jpg')or($file_extension=='gif')or($file_extension=='png')){
                    $ext = pathinfo($_FILES['sekil']['name'], PATHINFO_EXTENSION);
                    if ($img_name){
                        $img_name = 'multimedia_cover_'.$multimedia_id.'.'.$ext;
                        @move_uploaded_file($_FILES['sekil']['tmp_name'], $target_path.$img_name);
                        $img=$img_name;
                    } else{
                        $img=''; 
                    }
                }

                $insert_data = array(
                    'name_az' => $_POST['name_az'],
                    'name_ru' => $_POST['name_ru'],
                    'name_en' => $_POST['name_en'],
                    'alias_az' => url_slug($_POST['name_az']),
                    'alias_en' => url_slug($_POST['name_en']),
                    'alias_ru' => url_slug($_POST['name_ru']),                    
                    'category_id' => $category_id,
                    'img' => "media/".$category_id."/".$img
                );       
                $db_link->insert ('multimedia', $insert_data); 
                echo '<script>document.location.href="?menu=multimedia&category_id='.$category_id.'";</script>';

            }  
        }else { 
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);
            exit("INVALID TOKEN"); 
        }         

    }
}
?>