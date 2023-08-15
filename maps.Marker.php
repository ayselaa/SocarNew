<?php
ini_set('display_errors', false);
session_start();
header('Content-Type: application/json');
$security_test=1;
include("mpan/config.php");
include "lang.php";
$lang = $_SESSION['lang'];
print "var markers = [";
$maps = $db_link->get('map');
foreach ($maps as $line) {
    $mapCategory="";
    $id = $line["id"];
    $ad = stripslashes($line["title_".$lang]);
    $description = stripslashes($line["description_".$lang]);
    $cids = explode(",", $line["category"]);
    $categ_ad=array();
    $category = $db_link->where('id',$cids, 'IN')->get("map_category");
    foreach ($category as $line1) {
        $categ_ad[] = stripslashes($line1["title_".$lang]);
    }
    $mapCategory = implode(",", $categ_ad); 
    print "new google.maps.Marker({ id: $id,position: { lat: ".$line['position_lat'].", lng: ".$line['position_lng']." },title: \"$ad\",map: map,description: \"$description\",category: \"$mapCategory\", icon: {url: \"data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>\",scaledSize: new google.maps.Size(40, 40),origin: new google.maps.Point(0, 0),anchor: new google.maps.Point(20, 40),},}),";    
}
print "];";   
exit;
?>