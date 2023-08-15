<?php
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}
if (empty($_GET['tip'])){
    $elaqe_info = $db_link->orderBy("id","desc")->get('elaqe_form');
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary mb-3">
                <div class="card-header"> Əlaqə  </div>
                <div class="card-body">
                    <br>
                    <div id="response"> </div>
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="listKatalog">
                            <thead>
                                <tr>
                                    <th>Tarix</th>
                                    <th>Ad, soyad</th>
                                    <th>E-mail / Telefon</th>
                                    <th>Məktub mətni</th> 
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($elaqe_info as $elaqe) {
                                    $id = stripslashes($elaqe['id']);
                                    $sid = stripslashes($elaqe['sid']);
                                    //$sname = $db_link->where('id', $sid)->getValue("elaqe", "title_az");
                                    $adsoyad = stripslashes($elaqe['adsoyad']);
                                    $email = stripslashes($elaqe['email']);
                                    $phone = stripslashes($elaqe['phone']);  
                                    $tarix = stripslashes($elaqe['tarix']);  
                                    $metn = stripslashes($elaqe['metn']);  

                                    print "<tr class='odd gradeA' id='arrayorder_$id'>
                                    <td style='cursor:move'>$tarix</td>
                                    <td>$adsoyad</td>
                                    <td>$email <br> $phone</td>
                                    <td>$metn</td>
                                    <td class='center'>
                                    <a onclick='Del(\"?menu=elaqe_form&tip=delete_elaqe&cid=$id\");' href='JavaScript:;'><span class='btn btn-sm btn-danger fi fi-thrash'></span></a>
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


if ($_GET['tip']=='delete_elaqe'){
    $db_link->where('id',$_GET['cid'])->delete('elaqe_form');
    echo '<script>document.location.href="?menu=elaqe_form";</script>';
}

?>