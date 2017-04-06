<?php

$rm = $_REQUEST['rm'];
$rmkey = $_REQUEST['rmkey'];

if($rm!=""){
    include("include/inc_bc.php");
	$rm = mysql_real_escape_string($rm);
    $rmkey = mysql_real_escape_string($rmkey);
	
	$check_rm = @mysql_query("SELECT * FROM main WHERE rm = '$rm' && rmkey = '$rmkey' ");
	$check_rm_num_rows1 = mysql_num_rows($check_rm);
    
    if($check_rm_num_rows1 >= 1) {
        $iswhat = "Pass";
    } else {
        $iswhat = "Fail";
    }
    
    $msgitems[] = array(
        'msg'=>$msg,
        'rm'=>$rm,
        'rmkey'=>$iswhat
    ); 
    echo json_encode(array("msgitems"=>$msgitems));
}
?>