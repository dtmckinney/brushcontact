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

function create_folder ($dir, $lat, $lon) {
	$create_date = date("m-d-Y");
	$create_date_rev = date("Y-m-d"); 
	$create_date_time = date("Y-m-d H:i:s");
	
	// change the name below for the folder you want
	$dir = $dir; //"new_folder_name";
	
	$file_to_write = $dir . '.txt';
	$content_to_write = "/* " . $dir . " create " . $create_date_time . " */ \r";
	$content_to_write .= "/* lat:" . $lat . " lon:" . $lon . " */";
	
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

$create_date = date("m-d-Y");
$create_date_rev = date("Y-m-d"); 
$create_date_time = date("Y-m-d H:i:s");

$lat = strtolower($_REQUEST['lat']);
$lon = strtolower($_REQUEST['lon']);
$rm = $_REQUEST['rm'];
$data = "none";
$type = "none";	

if($rm != "") {
	include("include/inc_bc.php");
	$rm = mysql_real_escape_string($rm);
	$msg = "Passed rm";
	$rand_id = createRandomId();
	
	$check_rm = @mysql_query("SELECT * FROM main WHERE rm = '$rm' ");
	$check_rm_num_rows1 = mysql_num_rows($check_rm);
    
    $row = mysql_fetch_assoc($check_rm);
    $rmkey = $row['rmkey'];
    if($rmkey){
        $rmkey = "has";
    }
    //die();
	
	if($check_rm_num_rows1 >= 1) {
		$msg = "Already Create BB for Location.";	
		
		$check_table = @mysql_query("SELECT * FROM table_$rm WHERE id != '' ");
		$check_table_num_rows2 = @mysql_num_rows($check_table);
	
		if($check_table_num_rows2 >= 1) {
			$get_info = @mysql_query("SELECT * FROM table_$rm WHERE id != '' ORDER BY create_date ASC");
			while($gi = @mysql_fetch_array($get_info)){
				$data = $gi['data'];
				$type = $gi['type'];
				
				if($type == "link") {
					if (strpos($data, 'http') === false) {
						$data = "http://" . $data;
					}
				}
				
				$msgitems[] = array(
					'msg'=>$msg,
					'lat'=>$lat_trunc,
					'lon'=>$lon_trunc,
					'rm'=>$rm,
					'ri'=>$rand_id,
					'data'=>$data,
					'type'=>$type,
                    'rmkey'=>$rmkey,
					'createdate'=>$create_date_time,
					'num_rows'=>$check_table_num_rows2
				);
			}
		} else {
			$msgitems[] = array(
				'msg'=>$msg,
				'lat'=>$lat_trunc,
				'lon'=>$lon_trunc,
				'rm'=>$rm,
				'ri'=>$rand_id,
				'data'=>$data,
				'type'=>$type,
                'rmkey'=>$rmkey,
				'createdate'=>$create_date_time,
				'num_rows'=>$check_table_num_rows2
			);
		}
		
	}
	echo json_encode(array("msgitems"=>$msgitems));
}	
else if($lat != "" && $lon != "") {
	
	include("include/inc_bc.php");
	$lat = mysql_real_escape_string($lat);
	$lon = mysql_real_escape_string($lon);	
	$lat_trunc = truncate_number($lat,2);
	$lon_trunc = truncate_number($lon,2);
	$lon_00 = str_replace("-","00",$lon_trunc);
	$rm = str_replace(".","",$lat_trunc) . "" . str_replace(".", "", $lon_00);
	
	create_folder($rm, $lat, $lon);
	$rand_id = createRandomId();
	
	$check_rm = @mysql_query("SELECT * FROM main WHERE rm = '$rm' ");
	$check_rm_num_rows = @mysql_num_rows($check_rm);
	
	if($check_rm_num_rows >= 1) {
		$msg = "Already Create BB for Location.";	
		
		$check_table = @mysql_query("SELECT * FROM table_$rm WHERE id != '' ");
		$check_table_num_rows = mysql_num_rows($check_table);
	
		if($check_table_num_rows >= 1) {
			$get_info = @mysql_query("SELECT * FROM table_$rm WHERE id != '' ORDER BY create_date ASC");
			while($gi = @mysql_fetch_array($get_info)){
				$data = $gi['data'];
				$type = $gi['type'];
				
				if($type == "link") {
					if (strpos($data, 'http') === false) {
						$data = "http://" . $data;
					}
				}
				
				$msgitems[] = array(
					'msg'=>$msg,
					'lat'=>$lat_trunc,
					'lon'=>$lon_trunc,
					'rm'=>$rm,
					'ri'=>$rand_id,
					'data'=>$data,
					'type'=>$type,
					'createdate'=>$create_date_time,
					'num_rows'=>$check_rm_num_rows
				);
			}
		} else {
			$msgitems[] = array(
				'msg'=>$msg,
				'lat'=>$lat_trunc,
				'lon'=>$lon_trunc,
				'rm'=>$rm,
				'ri'=>$rand_id,
				'data'=>$data,
				'type'=>$type,
				'createdate'=>$create_date_time,
				'num_rows'=>$check_rm_num_rows
			);
		}
		
	} else {
	
		
		$sql = "INSERT INTO main (
		rand_id,
		lat, 
		lon, 
		rm,
		create_date,
		ip) 
		VALUES (
		'$rand_id',
		'$lat', 
		'$lon', 
		'$rm', 
		'$create_date_time',
		'$ip')";
		mysql_query($sql) or die("Issue creating bb"); 
		
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
		
		$msg = "Success Created New BB!";
        $msgitems[] = array(
            'msg'=>$msg,
            'lat'=>$lat_trunc,
            'lon'=>$lon_trunc,
            'rm'=>$rm,
            'ri'=>$rand_id,
            'data'=>$data,
            'type'=>$type,
            'createdate'=>$create_date_time,
            'num_rows'=>$check_rm_num_rows
        );
	}

	echo json_encode(array("msgitems"=>$msgitems));
}
?>