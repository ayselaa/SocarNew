<?php
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}
if(!$security_test) exit;
$id = addslashes($_GET['cid']);
if (empty($_GET['tip'])){
    $tbl_siteconfig = $db_link->get('siteconfig');
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header"> siteconfig </div>
                <div class="card-body">

                    <!--                    <div id="custom-toolbar">
                    <div class="form-inline" role="form">
                    <a href="?menu=siteconfig&tip=add_siteconfig" type="button" class="btn btn-outline btn-primary">Add new</a>
                    </div>
                    </div>-->
                    <br>
                    <div class="dataTable_wrapper">
                        <table class="table table-hover table-striped table-bordered" data-custom-config='{"serverSide":false, "searching":false}'>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Value</th> 
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($tbl_siteconfig as $siteconfig) {
                                    $id = stripslashes($siteconfig['id']);
                                    $name = stripslashes($siteconfig['title']);
                                    $value = stripslashes($siteconfig['value']);

                                    print "<tr class='odd gradeA' id='arrayorder_$id'>
                                    <td>$name</td>
                                    <td>$value</td>
                                    <td class='center'>
                                    <a href='?menu=siteconfig&tip=edit_siteconfig&cid=$id'><span class='btn btn-outline btn-primary fi fi-pencil'></span></a>
                                    <!--<a onclick='Del(\"?menu=siteconfig&tip=delete_siteconfig&cid=$id&token=$csrftoken\");' href='JavaScript:;'><span class='fi fi--trash'></span></a>-->
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


if ($_GET['tip']=='delete_siteconfig'){
    if ($_SESSION['csrftoken']==$_GET['token']) {
        if (time() >= $_SESSION['csrftoken_expire']) {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);            
            exit("Token expired. Geri qayit.");
        }else {
            unset($_SESSION['csrftoken']);
            unset($_SESSION['csrftoken_expire']);
            $db_link->where('id',$id)->delete('siteconfig');
            echo '<script>document.location.href="?menu=siteconfig";</script>';
        }  
    }else { 
        exit("INVALID TOKEN"); 
    }
}



if ($_GET['tip']=='edit_siteconfig'){
    $siteconfig_info = $db_link->where ('id', $id)->getOne('siteconfig');
    if(!$_POST['edit']) {
        ?>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    siteconfig
                </div>
                <div class="card-body">
                    <div class="row">
                        <form role="form" name="siteconfig_edit" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php print $_SESSION['csrftoken']?>"/>
                            <input type="hidden" name="id" value="<?php print $siteconfig_info['id']?>" />                    
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Title</label><input readonly="readonly" class="form-control" type="text" name="name" size="107" value='<?php print stripslashes($siteconfig_info['title'])?>'>
                                </div>                      
                                <div class="col-md-6">
                                    <label>Value</label><input class="form-control" type="text" name="value" size="107" value='<?php print stripslashes($siteconfig_info['value'])?>'>
                                </div>                    
                                <div class="form-group col-lg-12">
                                    <br>
                                    <center>
                                        <input class="btn btn-primary" name="edit" type="submit" id="edit" value="Ok"> <input  class="btn btn-primary" type=button value="Cancel" onclick="javascript:history.go(-1);">
                                    </center>
                                </div>
                            </div>
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
                $update_data = array(                       
                    'value' => $_POST['value']
                );       
                $db_link->where ('id', $id)->update ('siteconfig', $update_data);
                echo '<script>document.location.href="?menu=siteconfig";</script>';

            }  
        }else { 
            exit("INVALID TOKEN"); 
        }
    }
}

if ($_GET['tip']=='add_siteconfig'){
    if(!$_POST['add']) {
        ?>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-heading">
                    siteconfig
                </div>
                <div class="card-body">
                    <div class="row">
                        <form role="form" name="siteconfig_edit" action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php print $_SESSION['csrftoken']?>"/>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Title</label><input class="form-control" type="text" name="name" size="107" value='<?php print stripslashes($siteconfig_info['title'])?>'>
                                </div>                      
                                <div class="col-md-6">
                                    <label>Value</label><input class="form-control" type="text" name="value" size="107" value='<?php print stripslashes($siteconfig_info['value'])?>'>
                                </div> 
                                <div class="form-group col-lg-12">
                                    <br>
                                    <center>
                                        <input class="btn btn-primary" name="add" type="submit" id="edit" value="Ok"> <input  class="btn btn-primary" type=button value="Cancel" onclick="javascript:history.go(-1);">
                                    </center>
                                </div>
                            </div>
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
                $insert_data = array(
                    'name' => $_POST['title'],                        
                    'value' => $_POST['value']
                );       
                $db_link->insert('siteconfig', $insert_data);
                //print $db_link->getLastQuery();
                echo '<script>document.location.href="?menu=siteconfig&category_id='.$category_id.'";</script>';
            }  
        }else { 
            exit("INVALID TOKEN"); 
        }
    }
}
?>