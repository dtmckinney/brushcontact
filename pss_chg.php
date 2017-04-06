<?php 
function truncate_number( $number, $precision = 2) {
    // Are we negative?
    $negative = $number / abs($number);
    // Cast the number to a positive to solve rounding
    $number = abs($number);
    // Calculate precision number for dividing / multiplying
    $precision = pow(10, $precision);
    // Run the math, re-applying the negative value to ensure returns correctly negative / positive
    return floor( $number * $precision ) / $precision * $negative;
}

$create_date = date("m-d-Y");
$create_date_rev = date("Y-m-d"); 
$create_date_time = date("Y-m-d H:i:s");
$ip = $_SERVER['REMOTE_ADDR'];

$rm = $_REQUEST['rm'];
$data = $_REQUEST['data'];
$type = $_REQUEST['type'];
$msg = "Null";

//echo $text;
//die();
	
if($rm != "") {
	
	include("include/inc_bc.php");
	$rm = mysql_real_escape_string($rm);
	$data = mysql_real_escape_string($data);
	$type = mysql_real_escape_string($type);
	
	$check_rm = @mysql_query("SELECT ip FROM main WHERE rm = '$rm' ");
	$check_rm_num_rows = @mysql_num_rows($check_rm);
	
	if($check_rm_num_rows < 1) {
		$msg = "No Room Exists.";	
	} else {

		if($data != "") {
			$sql = "INSERT INTO table_$rm (
			data,
			type,
			create_date,
			ip) 
			VALUES (
			'$data', 
			'$type',
			'$create_date_time',
			'$ip')";
			mysql_query($sql) or die("Issue creating bb interaction"); 
			
			$msg = "Success ADDED to BB!";
		} else {
			$msg = "NOTHING TO BE ADDED to BB!";
		}
		
	}

	$msgitems[] = array(
		'msg'=>$msg,
		'rm'=>$rm,
		'data'=>$data,
		'type'=>$type,
		'createdate'=>$create_date_time,
	);
	
	echo json_encode(array("msgitems"=>$msgitems));
}
?>