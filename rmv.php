<?php 
function recursiveRemoveDirectory($directory)
{
    foreach(glob("{$directory}/*") as $file)
    {
        if(is_dir($file)) { 
            recursiveRemoveDirectory($file);
        } else {
            unlink($file);
        }
    }
    if(file_exists($directory)){
        rmdir($directory);
    }
}
$create_date = date("m-d-Y");
$create_date_rev = date("Y-m-d"); 
$create_date_time = date("Y-m-d H:i:s");

$rm = $_REQUEST['rm'];
$type = $_REQUEST['type'];
$msg = "Null";

if($rm != "") {
	
	include("include/inc_bc.php");
	$rm = mysql_real_escape_string($rm);
	$type = mysql_real_escape_string($type);
	
	$check_rm = @mysql_query("SELECT ip FROM main WHERE rm = '$rm' ");
	$check_rm_num_rows = @mysql_num_rows($check_rm);
	
	if($check_rm_num_rows < 1) {
		$msg = "No Room Exists.";	
	} else {

		if($type != "") {
            $sql = "DELETE FROM main WHERE rm='$rm'";
			mysql_query($sql) or die("Issue deleting from main"); 
			$sql2 = "DROP TABLE IF EXISTS table_$rm";
			mysql_query($sql2) or die("Issue deleting bb table"); 
			recursiveRemoveDirectory($rm);
			$msg = "Success DELETED!";
		} else {
			$msg = "NOTHING TO BE DELETED!";
		}
		
	}

	$msgitems[] = array(
		'msg'=>$msg,
		'rm'=>$rm,
		'type'=>$type,
		'createdate'=>$create_date_time,
	);
	
	echo json_encode(array("msgitems"=>$msgitems));
}
?>