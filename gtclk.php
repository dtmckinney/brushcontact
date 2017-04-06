<?php
$rm = $_REQUEST['rm'];

if($rm != "") {
	include("include/inc_bc.php");
	$rm = mysql_real_escape_string($rm);
	$msg = "Passed rm";
	
	$check_rm = @mysql_query("SELECT ip FROM main WHERE rm = '$rm' ");
	$check_rm_num_rows = mysql_num_rows($check_rm);
	
	if($check_rm_num_rows < 1) {
		$msg = "No BB.";	
	} else {
		$get_info = @mysql_query("SELECT * FROM main WHERE rm = '$rm'");
		while($gi = @mysql_fetch_array($get_info)){
			$cd = $gi['countdown'];
			$msgitems[] = array(
				'msg'=>$msg,
				'cd'=>$cd
			);
		}
	}
	echo json_encode(array("msgitems"=>$msgitems));
}
?>