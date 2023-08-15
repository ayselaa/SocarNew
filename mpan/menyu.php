<?php
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}

if(!$security_test) exit;


if ($_GET['tip']=='delete_menyu') {
    if ($_SESSION['csrftoken']==$_GET['token']) {
        if (time() >= $_SESSION['csrftoken_expire']) {
            exit("Token expired. Geri qayit.");
        }else {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);   
            $cid=$_GET['cid'];
            $db_link->where('id',$cid)->delete('category');
            echo '<script>document.location.href="?menu=menyu";</script>';
        }  
    }else { 
        exit("INVALID TOKEN"); 
    }     
}


function queryToCombo($table,$comboname,$data1,$data2,$selected=null,$where=null){
    global $db_link;
    if(isset($table)){
        $tbl_data = $db_link->where("sub_id",0)->orderBy("blok","asc")->get('category'); 
        $count1=$db_link->count;

        $combo.="<select name='$comboname' id='$comboname' class='form-control'>";
        $combo.="<option value='0'> - - - - - </option>";
        foreach ($tbl_data as $tbl_datas) {
            if($selected==$tbl_datas[$data1])
                $combo.="<option selected='selected' value='".$tbl_datas[$data1]."'>".$tbl_datas[$data2]."</option>";
            else
                $combo.="<option value='".$tbl_datas[$data1]."'>".$tbl_datas[$data2]."</option>";

            $tbl_data1 = $db_link->where("sub_id",$tbl_datas['id'])->orderBy("blok","asc")->get('category'); 
            foreach ($tbl_data1 as $tbl_datas1) {
                if($selected==$tbl_datas1[$data1])
                    $combo.="<option selected='selected' value='".$tbl_datas1[$data1]."'> - ".$tbl_datas1[$data2]."</option>";
                else
                    $combo.="<option value='".$tbl_datas1[$data1]."'> - ".$tbl_datas1[$data2]."</option>";


                $tbl_data2 = $db_link->where("sub_id",$tbl_datas1['id'])->orderBy("blok","asc")->get('category'); 
                foreach ($tbl_data2 as $tbl_datas2) {
                    if($selected==$tbl_datas2[$data1])
                        $combo.="<option selected='selected' value='".$tbl_datas2[$data1]."'> -  - ".$tbl_datas2[$data2]."</option>";
                    else
                        $combo.="<option value='".$tbl_datas2[$data1]."'> -  - ".$tbl_datas2[$data2]."</option>";
                }

            }

        }
        $combo.="</select>";
        return $combo;
    }
    return false;
}

function queryToCombo1($table,$comboname,$data1,$data2,$selected=null,$where=null){
    global $db_link;
    if(isset($table)){
        $tbl_data = $db_link->where("sub_id",$selected)->orderBy("blok","asc")->get('category'); 
        $count1=$db_link->count;
        foreach ($tbl_data as $tbl_datas) {
            if($selected==$tbl_datas[$data1])
                $combo.="<option selected='selected' value='".$tbl_datas[$data1]."'> - ".$tbl_datas[$data2]."</option>";
            else
                $combo.="<option value='".$tbl_datas[$data1]."'> - ".$tbl_datas[$data2]."</option>";
        }
        return $combo;
    }
    return false;
}

function  buildTreeM($sub_id=0,$lv,$db_link){
    $lv++;
    $dddd=$lv*5;
    $cat_menyus = $db_link->where("sub_id",$sub_id)->orderBy("blok","asc")->get('category'); 
    $count1=$db_link->count;
    if($count1>0) {print "<ol class='dd-list'>"; }

    foreach ($cat_menyus as $row1) {
        $mid1 = stripslashes($row1['id']);
        $blok1 = stripslashes($row1['blok']);
        $name_az1 = stripslashes($row1['name_az']);

        print "<li class='dd-item dd-has-options dd-handle-custom' data-id='$mid1'>
        <div class='dd-content text-truncate'>$name_az1</div>
        <div class='dd-handle fi fi-list'></div>
        <div class='nestable-options'>
        <a href='?menu=menyu&tip=edit_menyu&cid=$mid1' class='nestable-edit'><i class='fi fi-pencil'></i></a>
        <a onclick='return confirm();' href='?menu=menyu&tip=delete_menyu&cid=$mid1&token={$_SESSION['csrftoken']}' class='nestable-edit'><i class='fi fi-thrash'></i></a>
        </div>";

        $count = $db_link->where("sub_id",$mid1)->getValue ("category", "count(*)"); 
        if($count)buildTreeM($mid1,$lv,$db_link);
        print "</li>";  

    }
    if($count1>0) print "</ol>";
}

if (empty($_GET['tip'])){
    ?>

    <div class="col-lg-12">
        <div class="card card-primary mb-3">
            <div class="card-header">
                Menyular   <a href="?menu=menyu&tip=add_menyu" type="button" class="btn btn-outline btn-primary">Yeni menü yarat</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="nestable dd"
                        data-nestable-max-depth="3"
                        data-update-delete-with-childs="false"
                        data-update-delete-with-childs-error="Silmək mümkün deyil. Alt menyuları var!"

                        data-ajax-update-url="updatemenyu.php"
                        data-ajax-update-params="['action','reorder']"

                        data-update-toast-success="Məlumat dəyişdirildi!"
                        data-update-toast-position="bottom-center">
                        <?php buildTreeM(0,0,$db_link);?>
                    </div>            
                </div>
            </div>
        </div>
    </div>            
    <?php
}



if ($_GET['tip']=='edit_menyu'){
    $id = addslashes($_GET['cid']);
    $category_info = $db_link->where("id",$id)->getOne('category');
    $this_count=$db_link->count;

    if(!$_POST['edit']) {
        ?>
        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header">
                    Menyular
                </div>
                <div class="card-body">
                    <div class="row">        
                        <form class="col-lg-12" name="menu_edit" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php print $_SESSION['csrftoken']?>"/>
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Kateqoriya</label>
                                    <?php print queryToCombo("category","category","id","name_az",$category_info['sub_id']);?>                                    
                                </div>
                                <div class="col-md-4">
                                    <label>Image</label>
                                    <input class="form-control"  type="file" name="uploaded" size="48"><?php print $category_info['img1']?>                                    
                                </div>                                
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Title AZ</label>
                                            <input class="form-control" type="text" name="name_az" value="<?php print $category_info['name_az']?>" size="48" />
                                        </div>
                                        <div class="col-md-6">
                                            <label>Link AZ</label>
                                            <input class="form-control" type="text" name="link_az" placeholder='Link' value="<?php print $category_info['link_az']?>" size="48" />
                                        </div>                                    
                                    </div>                                    
                                </div>                                
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Title En</label>
                                            <input class="form-control" type="text" name="name_en" value="<?php print $category_info['name_en']?>" size="48" />
                                        </div>
                                        <div class="col-md-6">
                                            <label>Link En</label>
                                            <input class="form-control" type="text" name="link_en" placeholder='Link' value="<?php print $category_info['link_en']?>" size="48" />
                                        </div>                                    
                                    </div>                                    
                                </div>                                
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Title Ru</label>
                                            <input class="form-control" type="text" name="name_ru" value="<?php print $category_info['name_ru']?>" size="48" />
                                        </div>
                                        <div class="col-md-6">
                                            <label>Link Ru</label>
                                            <input class="form-control" type="text" name="link_ru" placeholder='Link' value="<?php print $category_info['link_ru']?>" size="48" />
                                        </div>                                    
                                    </div>                                    
                                </div>
                                <div class="col-md-4">
                                    <label>Seo title</label>
                                    <input type="text" class="form-control" name="seo_title" value="<?php print $category_info['seo_title']?>" size="48" />
                                </div>
                                <div class="col-md-4">
                                    <label>Seo description</label>
                                    <input type="text" class="form-control" name="seo_desc" value="<?php print $category_info['seo_desc']?>" size="48" />
                                </div>
                                <div class="col-md-4">
                                    <label>Seo tag</label>
                                    <input type="text" class="form-control" name="seo_teg" value="<?php print $category_info['seo_teg']?>" size="48" />
                                </div>                                
                                <div class="col-md-6">
                                    <label>Menyu tipi</label>
                                    <select class="form-control" name = "type">
                                        <option value="pages">Kontent</option>
                                        <option value="articles">Xəbər tipli</option>
                                        <option value="photos">Fotoqalereya</option>
                                        <option value="video">Video</option>
                                        <option value="multimedia">Multimedia</option>
                                    </select><?php print  "<script> menu_edit.type.value='".$category_info['type']."'; </script>"; ?>                                    
                                </div> 
                                <div class="col-md-6">
                                    <label>Status</label>
                                    <select class="form-control" name = "status">
                                        <option value="active">Active</option>
                                        <option value="deactive">Deactive</option>
                                    </select><?php print  "<script> menu_edit.status.value='".$category_info['status']."'; </script>"; ?>                                   
                                </div>  
                                <div class="col-md-12">
                                    <br>
                                </div>  
                                <div class="col-md-12">
                                    <center>
                                        <input class="btn btn-outline btn-primary" name="edit" type="submit" id="edit" value="OK" /> 
                                        <input class="btn btn-outline btn-primary" type=button value="Cancel" onclick="javascript:history.go(-1);">
                                    </center>                                   
                                </div>                                                                    

                            </div>                           
                        </form>
                    </div>
                </div>

            </div>
        </div>          
        <?php
    } elseif($_POST['edit']) {
        if ($_SESSION['csrftoken']==$_POST['token']) {
            if (time() >= $_SESSION['csrftoken_expire']) {
                exit("Token expired. Geri qayit.");
            }else {
                unset($_SESSION['csrftoken']);
                unset($_SESSION['csrftoken_expire']);
                $update_data = array(
                    'sub_id' => $_POST['category'],
                    'name_az' => $_POST['name_az'],
                    'name_en' => $_POST['name_en'],
                    'name_ru' => $_POST['name_ru'],
                    'link_az' => $_POST['link_az'],
                    'link_en' => $_POST['link_en'],
                    'link_ru' => $_POST['link_ru'],                    
                    'alias_az' => url_slug($_POST['name_az']),
                    'alias_en' => url_slug($_POST['name_en']),
                    'alias_ru' => url_slug($_POST['name_ru']),
                    'seo_title' => $_POST['seo_title'],
                    'seo_desc' => $_POST['seo_desc'],
                    'seo_teg' => $_POST['seo_teg'],
                    'type' => $_POST['type'],
                    'status' => $_POST['status']
                );
                $db_link->where('id', $id)->update('category', $update_data);

                $saat=date("YmdHis");
                $target_path = "../uploads/menyu/";
                $ext = pathinfo($_FILES['uploaded']['name'], PATHINFO_EXTENSION);
                $img_name = 'menyu'.$id.'.'.$ext;//$img_name = 'menyu'.$id.'_'.$saat.'.'.$ext;
                $img_type = $_FILES['uploaded']['type'];
                $target_path = $target_path.$img_name;
                if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target_path)){
                    $images=array('img1' => $img_name);
                    $db_link->where('id', $id)->update('category', $images);
                }

                $update_data1 = array(
                    'name_az' => $_POST['name_az'],
                    'name_en' => $_POST['name_en'],
                    'name_ru' => $_POST['name_ru'],
                    'alias_az' => url_slug($_POST['name_az']),
                    'alias_en' => url_slug($_POST['name_en']),
                    'alias_ru' => url_slug($_POST['name_ru']),
                );
                $db_link->where('category_id', $id)->update('content', $update_data1);
                echo '<script>document.location.href="?menu=menyu";</script>';   

            }  
        }else { 
            exit("INVALID TOKEN"); 
        }          

    }
}



if ($_GET['tip']=='add_menyu'){

    if(!$_POST['add']) {
        ?>
        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header">
                    Menyular
                </div>
                <div class="card-body">
                    <div class="row">        
                        <form class="col-lg-12" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php print $_SESSION['csrftoken']?>"/>

                            <div class="row">
                                <div class="col-md-8">
                                    <label>Kateqoriya</label>
                                    <?php print queryToCombo("category","category","id","name_az",$category_info['sub_id']);?>                                    
                                </div>
                                <div class="col-md-4">
                                    <label>Image</label>
                                    <input class="form-control"  type="file" name="uploaded" size="48"><?php print $category_info['img1']?>                                    
                                </div>                                
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Title AZ</label>
                                            <input class="form-control" type="text" name="name_az" value="<?php print $category_info['name_az']?>" size="48" />
                                        </div>
                                        <div class="col-md-6">
                                            <label>Link AZ</label>
                                            <input class="form-control" type="text" name="link_az" placeholder='Link' value="<?php print $category_info['link_az']?>" size="48" />
                                        </div>                                    
                                    </div>                                    
                                </div>                                
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Title En</label>
                                            <input class="form-control" type="text" name="name_en" value="<?php print $category_info['name_en']?>" size="48" />
                                        </div>
                                        <div class="col-md-6">
                                            <label>Link En</label>
                                            <input class="form-control" type="text" name="link_en" placeholder='Link' value="<?php print $category_info['link_en']?>" size="48" />
                                        </div>                                    
                                    </div>                                    
                                </div>                                
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Title Ru</label>
                                            <input class="form-control" type="text" name="name_ru" value="<?php print $category_info['name_ru']?>" size="48" />
                                        </div>
                                        <div class="col-md-6">
                                            <label>Link Ru</label>
                                            <input class="form-control" type="text" name="link_ru" placeholder='Link' value="<?php print $category_info['link_ru']?>" size="48" />
                                        </div>                                    
                                    </div>                                    
                                </div>
                                <div class="col-md-4">
                                    <label>Seo title</label>
                                    <input type="text" class="form-control" name="seo_title" value="<?php print $category_info['seo_title']?>" size="48" />
                                </div>
                                <div class="col-md-4">
                                    <label>Seo description</label>
                                    <input type="text" class="form-control" name="seo_desc" value="<?php print $category_info['seo_desc']?>" size="48" />
                                </div>
                                <div class="col-md-4">
                                    <label>Seo tag</label>
                                    <input type="text" class="form-control" name="seo_teg" value="<?php print $category_info['seo_teg']?>" size="48" />
                                </div>
                                <div class="col-md-6">
                                    <label>Menü tipi</label>
                                    <select class="form-control" name = "type">
                                        <option value="pages">Kontent</option>
                                        <option value="articles">Xəbər tipli</option>
                                        <option value="photos">Fotoqalereya</option>
                                        <option value="video">Video</option>
                                        <option value="multimedia">Multimedia</option>
                                    </select><?php print  "<script> menu_edit.type.value='".$category_info['type']."'; </script>"; ?>                                    
                                </div> 
                                <div class="col-md-6">
                                    <label>Status</label>
                                    <select class="form-control" name = "status">
                                        <option value="active">Active</option>
                                        <option value="deactive">Deactive</option>
                                    </select><?php print  "<script> menu_edit.status.value='".$category_info['status']."'; </script>"; ?>                                   
                                </div>  
                                <div class="col-md-12">
                                    <br>                                  
                                </div>  
                                <div class="col-md-12">
                                    <center>
                                        <input class="btn btn-outline btn-primary" name="add" type="submit" id="add" value="OK" /> 
                                        <input class="btn btn-outline btn-primary" type=button value="Cancel" onclick="javascript:history.go(-1);">
                                    </center>                                   
                                </div>                                                                    

                            </div>                            
                        </form>
                    </div>
                </div>

            </div>
        </div>        
        <?php
    } elseif($_POST['add']) {
        if ($_SESSION['csrftoken']==$_POST['token']) {
            if (time() >= $_SESSION['csrftoken_expire']) {
                exit("Token expired. Geri qayit.");
            }else {
                unset($_SESSION['csrftoken']);
                unset($_SESSION['csrftoken_expire']);        
                $insert_data = array(
                    'sub_id' => $_POST['category'],
                    'name_az' => $_POST['name_az'],
                    'name_en' => $_POST['name_en'],
                    'name_ru' => $_POST['name_ru'],
                    'link_az' => $_POST['link_az'],
                    'link_en' => $_POST['link_en'],
                    'link_ru' => $_POST['link_ru'],                    
                    'alias_az' => url_slug($_POST['name_az']),
                    'alias_en' => url_slug($_POST['name_en']),
                    'alias_ru' => url_slug($_POST['name_ru']),
                    'seo_title' => $_POST['seo_title'],
                    'seo_desc' => $_POST['seo_desc'],
                    'seo_teg' => $_POST['seo_teg'],                     
                    'type' => $_POST['type'],
                    'status' => $_POST['status']
                );
                $newid=$db_link->insert('category', $insert_data);
                //print $db_link->getLastQuery();

                $saat=date("YmdHis");
                $target_path = "../uploads/menyu/";
                $ext = pathinfo($_FILES['uploaded']['name'], PATHINFO_EXTENSION);        
                $img_name = 'menyu'.$newid.'.'.$ext;  //$img_name = 'menyu'.$maxid.'_'.$saat.'.'.$ext;
                $img_type = $_FILES['uploaded']['type'];
                $target_path = $target_path.$img_name;
                if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target_path)){
                    $update_data1 = array('img1' => $img_name);
                    $db_link->where('id', $newid)->update('category', $update_data1);
                }            

                $insert_data1 = array(
                    'category_id' => $newid,
                    'name_az' => $_POST['name_az'],
                    'name_en' => $_POST['name_en'],
                    'name_ru' => $_POST['name_ru'],
                    'alias_az' => url_slug($_POST['name_az']),
                    'alias_en' => url_slug($_POST['name_en']),
                    'alias_ru' => url_slug($_POST['name_ru'])                    
                ); 
                $newid=$db_link->insert('content', $insert_data1);
                //print $db_link->getLastQuery();
                echo '<script>document.location.href="?menu=menyu";</script>';

            }  
        }else { 
            exit("INVALID TOKEN"); 
        } 
    }
}
?>