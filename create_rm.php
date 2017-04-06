<?php
function createRandomId() {

    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $id = '' ;

    while ($i <= 15) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $id = $id . $tmp;
        $i++;
    }
    return $id;
}
function create_folder ($dir) {
	$create_date = date("m-d-Y");
	$create_date_rev = date("Y-m-d"); 
	$create_date_time = date("Y-m-d H:i:s");
	
	// change the name below for the folder you want
	$dir = $dir; //"new_folder_name";
	
	$file_to_write = $dir . '.txt';
	$content_to_write = "/* " . $dir . " create " . $create_date_time . " */ \r";
	
	if( is_dir($dir) === false )
	{
		mkdir($dir);
	}
	
	$file = fopen($dir . '/' . $file_to_write,"w");
	
	// a different way to write content into
	// fwrite($file,"Hello World.");
	
	fwrite($file, $content_to_write);
	
	// closes the file
	fclose($file);
	
	// this will show the created file from the created folder on screen
	//include $dir . '/' . $file_to_write;
}
$site_root = "/";
$create_date = date("m-d-Y");
$create_date_rev = date("Y-m-d"); 
$create_date_time = date("Y-m-d H:i:s");
$ip = $_SERVER['REMOTE_ADDR'];

$rmkey = $_POST['rm-key'];

if($rmkey != "") {
	include("include/inc_bc.php");
	$rmkey = mysql_real_escape_string($rmkey);
    $rm = createRandomId();
    
    create_folder($rm);
	
	$check_rm = @mysql_query("SELECT * FROM main WHERE rm = '$rm' ");
	$check_rm_num_rows1 = mysql_num_rows($check_rm);
	
	if($check_rm_num_rows1 >= 1) {
		$msg = "Already Create Room.";
        $ref = $site_root ."?rm=$rm";
        header("Location:$ref");
    } else {
        //echo $rmkey . " " . $rm . "<br>";
        
        $sql = "INSERT INTO main (
		rand_id,
		rm,
        is_private,
        rmkey,
		create_date,
		ip) 
		VALUES (
		'$rm', 
		'$rm',
        'yes',
        '$rmkey',
		'$create_date_time',
		'$ip')";
		mysql_query($sql) or die("Issue creating bb..."); 
		
		$query = "SELECT id FROM table_$rm";
		$result = mysql_query($query);
		
		if(empty($result)) {
			$query = "CREATE TABLE table_$rm (
					  id int(255) AUTO_INCREMENT,
					  data LONGTEXT NOT NULL,
					  type VARCHAR(255) NOT NULL,
                      filetype VARCHAR(255) NOT NULL,
					  create_date DATETIME NOT NULL,
					  ip VARCHAR(255) NOT NULL,	  
					  PRIMARY KEY  (id)
					  )";
			$result = mysql_query($query);
		}
		
		$msg = "Success Created New Room!";
        $ref = $site_root ."?rm=$rm";
        header("Location:$ref");
    }
}
?>
