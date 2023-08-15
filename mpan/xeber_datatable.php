<?php
ini_set('display_errors', false);
session_start();
$security_test=1;
header('Content-type:application/json;charset=utf-8');
include("config.php");
include("function.php");
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}

$userid=$_SESSION['userid'];

$category_id=$_GET['category_id'];
$length=$_GET['length'];
$start=$_GET['start'];
$draw=$_GET['draw'];
$search=$_GET['search'];
$searchValue=$search['value'];
if($searchValue){
    $db_link->orWhere ('title_az', "%$search%",'LIKE');  
} 

$news_info = $db_link->withTotalCount()->orderBy("id","desc")->where ('category_id', $category_id)->get('news',array($start,$length));
$total_count=$db_link->totalCount; 
$this_count=$db_link->count;
print '{"draw": '.$draw.',"recordsTotal": '.$total_count.', "recordsFiltered": '.$total_count.',"data":';  
$news_arrays=array();
foreach ($news_info as $news) {
    $id = stripslashes($news['id']);
    $news_date = stripslashes($news['news_date']);
    $name_az = stripslashes($news['title_az']);
    $sira = stripslashes($news['sira']);
    //if($fond_id) $fond_name=$db_arxiv->where('id', $fond_id)->getValue("ek_arxiv_fond", "name");
    $linkdel="onclick='return confirm();'"; 
    //$sekil="<a rel=tooltip title='REDAKTƏ ET' href='?menu=news_photos&category_id=$id&catid=$category_id'><span class='btn btn-sm btn-primary fi fi-image'></span></a>";
    $red="<a rel=tooltip title='REDAKTƏ ET' href='?menu=xeber&tip=edit_xeber&category_id=$category_id&cid=$id'><span class='btn btn-sm btn-success fi fi-pencil'></span></a>";
    $sil="<a rel=tooltip title='REDAKTƏ ET' $linkdel href='?menu=xeber&tip=delete_xeber&category_id=$category_id&cid=$id&token=$csrftoken'><span class='btn btn-sm btn-danger fi fi-thrash'></span></a>";

    $news_array=array($id,$news_date,$name_az,$sekil.' '.$sil.' '.$red);  
    array_push($news_arrays, $news_array);
} 

echo json_encode($news_arrays);
print "}";


?> 

