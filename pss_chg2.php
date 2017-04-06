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

$rm = $_REQUEST['rm'];
$lnk = $_REQUEST['lnk'];
$msg = "Null";

//echo $text;
//die();
	
if($rm != "") {
	
	include("include/inc_bc.php");
	$rm = mysql_real_escape_string($rm);
	
	$check_rm = @mysql_query("SELECT ip FROM main WHERE rm = '$rm' ");
	$check_rm_num_rows = mysql_num_rows($check_rm);
	
	if($check_rm_num_rows < 1) {
		$msg = "No BB.";	
	} else {

		$check_rm_tbl = @mysql_query("SELECT * FROM table_$rm ");
		$check_rm_tbl_num_rows = mysql_num_rows($check_rm_tbl);
	
		if($check_rm_tbl_num_rows >= 1) {
			
			$sql = "UPDATE table_$rm SET	lnk = '$lnk' ";
			mysql_query($sql) or die("Issue updating bb interaction"); 
			
			$msg = "Success UPDATED to BB!";
			
		} else {
		
			$sql = "INSERT INTO table_$rm (
			lnk,
			create_date,
			ip) 
			VALUES (
			'$lnk', 
			'$create_date_time',
			'$ip')";
			mysql_query($sql) or die("Issue creating bb interaction"); 
			
			$msg = "Success ADDED to BB!";
		}
	}

	$msgitems[] = array(
		'msg'=>$msg,
		'rm'=>$rm,
		'createdate'=>$create_date_time,
	);
	
	echo json_encode(array("msgitems"=>$msgitems));
}
?>