<?php
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}
$category_id=$_GET['category_id'];
$cid=$_GET['cid'];
$tbl_category = "Author";

if (empty($_GET['tipi'])){
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header"><?php print $tbl_category;?> &nbsp;<a href="?menu=author&tipi=add_author&category_id=<?php print $category_id;?>&cid=<?php print $cid;?>" type="button" class="btn btn-outline btn-primary">Add new</a></div>
                <div class="card-body">
                    <div id="response"> </div>
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Ad</th>
                                    <th>Vəzifə</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $news_info = $db_link->get('author');
                                foreach ($news_info as $news) {
                                    $id = stripslashes($news['id']);
                                    $name_az = stripslashes($news['title_az']);
                                    $description_az = stripslashes($news['description_az']);
                                    $img = stripslashes($news['img']);

                                    print "<tr class='odd gradeA' id='arrayorder_$id'>
                                    <td>$name_az</td>
                                    <td>$description_az</td>
                                    <td class='center'>
                                    <a href='?menu=author&tipi=edit_author&category_id=$category_id&cid=$cid&id=$id'><span class='btn btn-outline btn-success fi fi-pencil'></span></a>
                                    <a onclick='Del(\"?menu=author&tipi=delete_author&category_id=$category_id&cid=$cid&id=$id\");' href='JavaScript:;'><span class='btn btn-outline btn-danger fi fi-thrash'></span></a>
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


if ($_GET['tipi']=='delete_author'){
    $id = addslashes($_GET['id']);
    $db_link->where('id',$id)->delete('author');
    $relink="?menu=author";
    echo '<script>document.location.href="'.$relink.'";</script>';
}



if ($_GET['tipi']=='edit_author'){
    $id = addslashes($_GET['id']);
    $news_info = $db_link->where ('id', $id)->getOne('author');

    if(!$_POST['edit']) {
        ?>

        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header"><?php print $tbl_category;?></div>
                <div class="card-body">
                    <div class="row">
                        <form class="col-lg-12" role="form" name="author_edit" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php print $news_info['id']?>" />
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade in show active" id="az">
                                    <div class="form-group">                                   
                                        <label>Title AZ</label><input class="form-control" type="text" name="title_az" size="107" value='<?php print stripslashes($news_info['title_az'])?>'>
                                        <label>Vəzifə AZ</label><input class="form-control" type="text" name="description_az" size="107" value='<?php print stripslashes($news_info['description_az'])?>'>
                                        <!--
                                        <label>Title EN</label><input class="form-control" type="text" name="title_en" size="107" value='<?php print stripslashes($news_info['title_en'])?>'>
                                        <label>Title RU</label><input class="form-control" type="text" name="title_ru" size="107" value='<?php print stripslashes($news_info['title_ru'])?>'>
                                        -->                                        
                                        <label>Image</label> <input class="form-control" type="file" name="sekil" size="42"> <?php print ($news_info['img'])?"<img src='/uploads/".$news_info['img']."' border=0 width=50> /uploads/".$news_info['img']:"";?>
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

        $target_path = "../uploads/"; 
        $img_name = $_FILES['sekil']['name']; 
        $ext = pathinfo($_FILES['sekil']['name'], PATHINFO_EXTENSION);
        if($img_name) {
            $img_name = 'brend_'.$id.'.'.$ext;
            @move_uploaded_file($_FILES['sekil']['tmp_name'], $target_path.$img_name);
            $img=$img_name;
        } else{
            $img=''; 
        } 

        if($img_name){
            $insert_data = array(
                'title_az' => $_POST['title_az'],
                'title_ru' => $_POST['title_ru'],
                'title_en' => $_POST['title_en'],
                'img' => $img,
                'description_az' => $_POST['description_az'],
                'description_ru' => $_POST['description_ru'],
                'description_en' => $_POST['description_en']
            );
        }else{
            $insert_data = array(
                'title_az' => $_POST['title_az'],
                'title_ru' => $_POST['title_ru'],
                'title_en' => $_POST['title_en'],
                'description_az' => $_POST['description_az'],
                'description_ru' => $_POST['description_ru'],
                'description_en' => $_POST['description_en']
            );   
        }        
        $db_link->where('id', $id)->update('author', $insert_data);
        $relink="?menu=author";
        echo '<script>document.location.href="'.$relink.'";</script>';
    }
}

if ($_GET['tipi']=='add_author'){
    if(!$_POST['add']) {
        ?>
        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header"><?php print $tbl_category;?></div>
                <div class="card-body">
                    <div class="row">
                        <form class="col-lg-12" role="form" name="author_edit" action="" method="post" enctype="multipart/form-data">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="az">
                                    <div class="form-group">                                    
                                        <label>Title AZ</label><input class="form-control" type="text" name="title_az" size="107" value='<?php print stripslashes($news_info['title_az'])?>'>
                                        <label>Vəzifə AZ</label><input class="form-control" type="text" name="description_az" size="107" value='<?php print stripslashes($news_info['description_az'])?>'>
                                        <!--
                                        <label>Title EN</label><input class="form-control" type="text" name="title_en" size="107" value='<?php print stripslashes($news_info['title_en'])?>'>
                                        <label>Title RU</label><input class="form-control" type="text" name="title_ru" size="107" value='<?php print stripslashes($news_info['title_ru'])?>'>
                                        --> 
                                        <label>Image</label> <input class="form-control" type="file" name="sekil" size="42"> <?php print ($news_info['img'])?"<img src='/uploads/".$news_info['img']."' border=0 width=50> /uploads/".$news_info['img']:"";?>
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

        $katalog_id = $db_link->getValue ("author", "max(id)")+1; 
        $target_path = "../uploads/"; 
        $img_name = $_FILES['sekil']['name']; 
        $ext = pathinfo($_FILES['sekil']['name'], PATHINFO_EXTENSION);
        if($img_name) {
            $img_name = 'brend_'.$katalog_id.'.'.$ext;
            @move_uploaded_file($_FILES['sekil']['tmp_name'], $target_path.$img_name);
            $img=$img_name;
        } else{
            $img=''; 
        }        

        $insert_data = array(
            'id' => $katalog_id,
            'img' => $img,
            'title_az' => $_POST['title_az'],
            'title_ru' => $_POST['title_ru'],
            'title_en' => $_POST['title_en'],
            'description_az' => $_POST['description_az'],
            'description_ru' => $_POST['description_ru'],
            'description_en' => $_POST['description_en']
        );
        $db_link->insert ('author', $insert_data);
        $relink="?menu=author";
        echo '<script>document.location.href="'.$relink.'";</script>';

    }
}
?>