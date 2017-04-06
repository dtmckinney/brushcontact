<?php
$create_date = date("m-d-Y");
$create_date_rev = date("Y-m-d"); 
$create_date_time = date("Y-m-d H:i:s");

$rm = $_REQUEST['rm'];

if($rm != "") {
	include("include/inc_bc.php");
	$rm = mysql_real_escape_string($rm);
	
	$check_rm = @mysql_query("SELECT * FROM main WHERE rm = '$rm' ");
	$check_rm_num_rows1 = mysql_num_rows($check_rm);
    
    $row = mysql_fetch_assoc($check_rm);
    $rmkey = $row['rmkey'];
    $msg = "Checking for rmkey";
    if($rmkey){
        $rmkey = "has";
    } else {
        $rmkey = "nothas";
    }
    $msgitems[] = array(
        'msg'=>$msg,
        'rm'=>$rm,
        'rmkey'=>$rmkey
    );
	echo json_encode(array("msgitems"=>$msgitems));
}
?>