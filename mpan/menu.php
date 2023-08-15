<?php
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}

if(!$security_test) exit;
if($_SESSION['flag'] & CUST_SUPERUSER){
    ?>
    <li class="nav-item">
        <a class="nav-link" href="#"><i class="fi fi-cogs"></i><span> Settings </span>                                                 
            <span class="group-icon float-end"><i class="fi fi-arrow-end"></i><i class="fi fi-arrow-down"></i></span>
        </a>
        <ul class="nav flex-column"> 
            <li class="nav-item"><a class="nav-link" href='?menu=menyu'><span> Menu</span></a></li>
            <li class="nav-item"><a class="nav-link" href='?menu=siteconfig'><span> Sosail linkler</span></a></li>
            <li class="nav-item"><a class="nav-link" href='?menu=map'><span> Map</span></a></li>
            <li class="nav-item"><a class="nav-link" href='?menu=map_category'><span>Map category</span></a></li>
            <li class="nav-item"><a class="nav-link" href='?menu=sened_form'><span>Onlayn müraciət</span></a></li>
            <li class="nav-item"><a class="nav-link" href='?menu=elaqe_form'><span>Əlaqə</span> </a></li>
            <li class="nav-item"><a class="nav-link" href='?menu=users'><span> Users</span></a></li>                   
        </ul>
    </li>
    <?php
}

function buildTree($sub_id,$db_link) {
    global $category_id;
    if($_SESSION['flag'] & CUST_SUPERUSER){
        $cat_menyus = $db_link->where("sub_id",$sub_id)->orderBy("blok","asc")->get('category');
        foreach ($cat_menyus as $cat_menyu) {
            $menyuico="bookmark";
            $cat_menyu_id=$cat_menyu['id'];  

            if($cat_menyu['type']=='articles') 
                $menyulink="?menu=xeber&category_id=".$cat_menyu['id'];

            if($cat_menyu['type']=='pages')
                $menyulink="?menu=content&tip=edit_content&cid=".$cat_menyu['id'];

            if($cat_menyu['type']=='photos')
                $menyulink="?menu=photos&category_id=".$cat_menyu['id'];
                
            if($cat_menyu['type']=='video')
                $menyulink="?menu=video&category_id=".$cat_menyu['id'];

            if($cat_menyu['type']=='katalog')
                $menyulink="?menu=katalog&category_id=".$cat_menyu['id'];

            if($cat_menyu['type']=='multimedia')
                $menyulink="?menu=multimedia&category_id=".$cat_menyu['id'];

            if($cat_menyu_id==$category_id) 
                $cat_menyu_b="<b>".$cat_menyu['name_az']."</b>"; 
            else 
                $cat_menyu_b=$cat_menyu['name_az']; 

            $count = $db_link->where("sub_id",$cat_menyu_id)->getValue ("category", "count(*)");

            if($sub_id){
                if($count>0){
                    print "<li class='nav-item'>
                    <a class='nav-link' href='JavaScript:;'><span>$cat_menyu_b</span>
                    <span class='group-icon float-end'><i class='fi fi-arrow-end'></i><i class='fi fi-arrow-down'></i></span></a><ul class='nav flex-column'>"; 
                    buildTree($cat_menyu_id,$db_link);
                    print "</ul></li>";
                }else{
                    print "<li class='nav-item'><a class='nav-link' href='$menyulink'> <span>$cat_menyu_b</span></a>";
                    print "</li>"; 
                }                
            }else{
                if($count>0){
                    print "<li class='nav-item'>
                    <a class='nav-link' href='JavaScript:;'><i class='fi fi-$menyuico'></i> <span>$cat_menyu_b</span>
                    <span class='group-icon float-end'><i class='fi fi-arrow-end'></i><i class='fi fi-arrow-down'></i></span></a><ul class='nav flex-column'>"; 
                    buildTree($cat_menyu_id,$db_link);
                    print "</ul></li>";
                }else{
                    print "<li class='nav-item'><a class='nav-link' href='$menyulink'><i class='fi fi-$menyuico'></i> <span>$cat_menyu_b</span></a>";
                    print "</li>"; 
                }                
            }

        }
    }
}

buildTree(0,$db_link);
?>