<?php 
ini_set('display_errors', false);
session_start();
$security_test=1;
include("config.php");
include("function.php");

if(!is_logged_in()){
    header("Location: login.php");
    exit;
}
$serialized = json_decode($_POST['serialized'], true);
$count = 1;
foreach ($serialized as $value) {
    $count ++;
    $menyuID=$value['id'];
    $update_data = array('blok' => $count,'sub_id' => 0);
    $db_link->where('id', $menyuID)->update('category', $update_data);
    $menyuChild=$value['children'];

    $count1 = 1;
    foreach ($menyuChild as $value1) {
        $count1 ++;
        $menyuID1=$value1['id'];
        $update_data1 = array('blok' => $count1,'sub_id' => $menyuID);
        $db_link->where('id', $menyuID1)->update('category', $update_data1);
        $menyuChild1=$value1['children'];

        $count2 = 0;
        foreach ($menyuChild1 as $value2) {
            $count2 ++;
            $menyuID2=$value2['id'];
            $update_data2 = array('blok' => $count2,'sub_id' => $menyuID1);
            $db_link->where('id', $menyuID2)->update('category', $update_data2);
            $menyuChild2=$value2['children'];

            $count3 = 0;
            foreach ($menyuChild2 as $value3) {
                $count3 ++;
                $menyuID3=$value3['id'];
                $update_data3 = array('blok' => $count3,'sub_id' => $menyuID2);
                $db_link->where('id', $menyuID3)->update('category', $update_data3);
                $menyuChild3=$value3['children'];


                $count4 = 0;
                foreach ($menyuChild3 as $value4) {
                    $count4 ++;
                    $menyuID4=$value4['id'];
                    $update_data4 = array('blok' => $count4,'sub_id' => $menyuID3);
                    $db_link->where('id', $menyuID4)->update('category', $update_data4);
                    //$menyuChild4=$value4['children'];


                } 
            }            


        }         

    }    


}
echo 'Məlumat dəyişdirildi';
exit;
  
?>