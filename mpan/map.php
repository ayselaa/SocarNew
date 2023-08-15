<?php
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}
$category_id=$_GET['category_id'];
$cid=$_GET['cid'];
$tbl_category = "Map";

if (empty($_GET['tipi'])){
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header"><?php print $tbl_category;?> &nbsp;<a href="?menu=map&tipi=add_map&category_id=<?php print $category_id;?>&cid=<?php print $cid;?>" type="button" class="btn btn-outline btn-primary">Add new</a></div>
                <div class="card-body">
                    <div id="response"> </div>
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $news_info = $db_link->get('map');
                                foreach ($news_info as $news) {
                                    $id = stripslashes($news['id']);
                                    $name_az = stripslashes($news['title_az']);
                                    $description_az = stripslashes($news['description_az']);
                                    $img = stripslashes($news['img']);

                                    print "<tr class='odd gradeA' id='arrayorder_$id'>
                                    <td>$name_az</td>
                                    <td>$description_az</td>
                                    <td class='center'>
                                    <a href='?menu=map&tipi=edit_map&category_id=$category_id&cid=$cid&id=$id'><span class='btn btn-outline btn-success fi fi-pencil'></span></a>
                                    <a onclick='Del(\"?menu=map&tipi=delete_map&category_id=$category_id&cid=$cid&id=$id\");' href='JavaScript:;'><span class='btn btn-outline btn-danger fi fi-thrash'></span></a>
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


if ($_GET['tipi']=='delete_map'){
    $id = addslashes($_GET['id']);
    $db_link->where('id',$id)->delete('map');
    $relink="?menu=map";
    echo '<script>document.location.href="'.$relink.'";</script>';
}



if ($_GET['tipi']=='edit_map'){
    $id = addslashes($_GET['id']);
    $news_info = $db_link->where ('id', $id)->getOne('map');

    if(!$_POST['edit']) {
        ?>

        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header"><?php print $tbl_category;?></div>
                <div class="card-body">
                    <div class="row">
                        <form class="col-lg-12" role="form" name="map_edit" action="" method="post" enctype="multipart/form-data">
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
                                <div class="tab-pane fade in show active" id="az">
                                    <div class="form-group">                                   
                                        <label>Title</label><input class="form-control" type="text" name="title_az" size="107" value='<?php print stripslashes($news_info['title_az'])?>'>
                                        <label>Description</label><input class="form-control" type="text" name="description_az" size="107" value='<?php print stripslashes($news_info['description_az'])?>'>                                        
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="en">
                                    <div class="form-group">                                   
                                        <label>Title</label><input class="form-control" type="text" name="title_en" size="107" value='<?php print stripslashes($news_info['title_en'])?>'>
                                        <label>Description</label><input class="form-control" type="text" name="description_en" size="107" value='<?php print stripslashes($news_info['description_en'])?>'>                                        
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="ru">
                                    <div class="form-group">                                   
                                        <label>Title</label><input class="form-control" type="text" name="title_ru" size="107" value='<?php print stripslashes($news_info['title_ru'])?>'>
                                        <label>Description</label><input class="form-control" type="text" name="description_ru" size="107" value='<?php print stripslashes($news_info['description_ru'])?>'>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Position lat</label> <input class="form-control" type="text" name="position_lat" size="42" value="<?php print stripslashes($news_info['position_lat'])?>"> 
                                <label>Position lng</label> <input class="form-control" type="text" name="position_lng" size="42" value="<?php print stripslashes($news_info['position_lng'])?>"> 
                                <label>Kategoriya</label>
                                <div class="form-check mb-2">
                                    <input data-checkall-container="#checkall-list" class="form-check-input form-check-input-default" type="checkbox" value="" id="checkall-top">
                                    <label class="form-check-label" for="checkall-top">Check All</label>
                                </div>
                                <div id="checkall-list" class="p-3">
                                    <?php
                                    chekb_mapCategory($news_info['category'],$db_link);
                                    ?>
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
        $mapCategory = implode(",", $_POST['mapCategory']);
        $insert_data = array(
            'category' => $mapCategory,
            'title_az' => $_POST['title_az'],
            'title_ru' => $_POST['title_ru'],
            'title_en' => $_POST['title_en'],
            'description_az' => $_POST['description_az'],
            'description_ru' => $_POST['description_ru'],
            'description_en' => $_POST['description_en'],
            'position_lat' => $_POST['position_lat'],
            'position_lng' => $_POST['position_lng']
        );   
        $db_link->where('id', $id)->update('map', $insert_data);
        $relink="?menu=map";
        echo '<script>document.location.href="'.$relink.'";</script>';
    }
}

if ($_GET['tipi']=='add_map'){
    if(!$_POST['add']) {
        ?>
        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header"><?php print $tbl_category;?></div>
                <div class="card-body">
                    <div class="row">
                        <form class="col-lg-12" role="form" name="map_edit" action="" method="post" enctype="multipart/form-data">
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
                                <div class="tab-pane fade in show active" id="az">
                                    <div class="form-group">                                   
                                        <label>Title</label><input class="form-control" type="text" name="title_az" size="107" value='<?php print stripslashes($news_info['title_az'])?>'>
                                        <label>Description</label><input class="form-control" type="text" name="description_az" size="107" value='<?php print stripslashes($news_info['description_az'])?>'>                                        
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="en">
                                    <div class="form-group">                                   
                                        <label>Title</label><input class="form-control" type="text" name="title_en" size="107" value='<?php print stripslashes($news_info['title_en'])?>'>
                                        <label>Description</label><input class="form-control" type="text" name="description_en" size="107" value='<?php print stripslashes($news_info['description_en'])?>'>                                        
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="ru">
                                    <div class="form-group">                                   
                                        <label>Title</label><input class="form-control" type="text" name="title_ru" size="107" value='<?php print stripslashes($news_info['title_ru'])?>'>
                                        <label>Description</label><input class="form-control" type="text" name="description_ru" size="107" value='<?php print stripslashes($news_info['description_ru'])?>'>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Position lat</label> <input class="form-control" type="text" name="position_lat" size="42" value="<?php print stripslashes($news_info['position_lat'])?>"> 
                                <label>Position lng</label> <input class="form-control" type="text" name="position_lng" size="42" value="<?php print stripslashes($news_info['position_lng'])?>"> 
                                <label>Kategoriya</label>
                                <div class="form-check mb-2">
                                    <input data-checkall-container="#checkall-list" class="form-check-input form-check-input-default" type="checkbox" value="" id="checkall-top">
                                    <label class="form-check-label" for="checkall-top">Check All</label>
                                </div>

                                <div id="checkall-list" class="p-3">
                                    <?php
                                    chekb_mapCategory($category_id,$db_link);
                                    ?>
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

        $mapCategory = implode(",", $_POST['mapCategory']);
        $insert_data = array(
            'category' => $mapCategory,
            'title_az' => $_POST['title_az'],
            'title_ru' => $_POST['title_ru'],
            'title_en' => $_POST['title_en'],
            'description_az' => $_POST['description_az'],
            'description_ru' => $_POST['description_ru'],
            'description_en' => $_POST['description_en'],
            'position_lat' => $_POST['position_lat'],
            'position_lng' => $_POST['position_lng']
        );
        $db_link->insert ('map', $insert_data);
        $relink="?menu=map";
        echo '<script>document.location.href="'.$relink.'";</script>';

    }
}
?>