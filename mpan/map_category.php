<?php
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}
$category_id=$_GET['category_id'];
$cid=$_GET['cid'];
$tbl_category = "Map category";

if (empty($_GET['tipi'])){
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header"><?php print $tbl_category;?> &nbsp;<a href="?menu=map_category&tipi=add_map_category&category_id=<?php print $category_id;?>&cid=<?php print $cid;?>" type="button" class="btn btn-outline btn-primary">Add new</a></div>
                <div class="card-body">
                    <div id="response"> </div>
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $news_info = $db_link->get('map_category');
                                foreach ($news_info as $news) {
                                    $id = stripslashes($news['id']);
                                    $name_az = stripslashes($news['title_az']);
                                    $img = stripslashes($news['img']);

                                    print "<tr class='odd gradeA' id='arrayorder_$id'>
                                    <td>$name_az</td>
                                    <td class='center'>
                                    <a href='?menu=map_category&tipi=edit_map_category&category_id=$category_id&cid=$cid&id=$id'><span class='btn btn-outline btn-success fi fi-pencil'></span></a>
                                    <a onclick='Del(\"?menu=map_category&tipi=delete_map_category&category_id=$category_id&cid=$cid&id=$id\");' href='JavaScript:;'><span class='btn btn-outline btn-danger fi fi-thrash'></span></a>
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


if ($_GET['tipi']=='delete_map_category'){
    $id = addslashes($_GET['id']);
    $db_link->where('id',$id)->delete('map_category');
    $relink="?menu=map_category";
    echo '<script>document.location.href="'.$relink.'";</script>';
}



if ($_GET['tipi']=='edit_map_category'){
    $id = addslashes($_GET['id']);
    $news_info = $db_link->where ('id', $id)->getOne('map_category');

    if(!$_POST['edit']) {
        ?>

        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header"><?php print $tbl_category;?></div>
                <div class="card-body">
                    <div class="row">
                        <form class="col-lg-12" role="form" name="map_category_edit" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php print $news_info['id']?>" />
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade in show active" id="az">
                                    <div class="form-group">                                   
                                        <label>Title AZ</label><input class="form-control" type="text" name="title_az" size="107" value='<?php print stripslashes($news_info['title_az'])?>'>
                                        <label>Title EN</label><input class="form-control" type="text" name="title_en" size="107" value='<?php print stripslashes($news_info['title_en'])?>'>
                                        <label>Title RU</label><input class="form-control" type="text" name="title_ru" size="107" value='<?php print stripslashes($news_info['title_ru'])?>'>
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
        $insert_data = array(
            'title_az' => $_POST['title_az'],
            'title_ru' => $_POST['title_ru'],
            'title_en' => $_POST['title_en']
        );   
        $db_link->where('id', $id)->update('map_category', $insert_data);
        $relink="?menu=map_category";
        echo '<script>document.location.href="'.$relink.'";</script>';
    }
}

if ($_GET['tipi']=='add_map_category'){
    if(!$_POST['add']) {
        ?>
        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header"><?php print $tbl_category;?></div>
                <div class="card-body">
                    <div class="row">
                        <form class="col-lg-12" role="form" name="map_category_edit" action="" method="post" enctype="multipart/form-data">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="az">
                                    <div class="form-group">                                    
                                        <label>Title AZ</label><input class="form-control" type="text" name="title_az" size="107" value='<?php print stripslashes($news_info['title_az'])?>'>
                                        <label>Title EN</label><input class="form-control" type="text" name="title_en" size="107" value='<?php print stripslashes($news_info['title_en'])?>'>
                                        <label>Title RU</label><input class="form-control" type="text" name="title_ru" size="107" value='<?php print stripslashes($news_info['title_ru'])?>'>
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
        $insert_data = array(
            'title_az' => $_POST['title_az'],
            'title_ru' => $_POST['title_ru'],
            'title_en' => $_POST['title_en']
        );
        $db_link->insert ('map_category', $insert_data);
        $relink="?menu=map_category";
        echo '<script>document.location.href="'.$relink.'";</script>';

    }
}
?>