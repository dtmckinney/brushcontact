<?
//SET SOME IMPORTANT VARIABLES
$create_date = date("m-d-Y");
$create_date_rev = date("Y-m-d"); 
$create_date_time = date("Y-m-d H:i:s");
$todaytime_under = date("Y_m_d_H_i_s");
$ip = $_SERVER['REMOTE_ADDR'];

$rm = $_POST['rm'];
$type = "path";

$fileName = $_FILES[file]['name'];
$fileType = $_FILES[file]['type'];
$fileError = $_FILES[file]['error'];
//$fileContent = file_get_contents($_FILES[file]['tmp_name']);

$data = "File Info: " . $fileName . " -- " . $fileError;
//CHECK THAT FORM WAS POSTED
if(!$_POST) exit;

include("include/inc_bc.php");
$rm = mysql_real_escape_string($rm);

ini_set('memory_limit', '500M');

if(isset($_FILES[file]['name'])){
		  
	while(list($key, $value) = each($_FILES[file][name])){
          if(!empty($value)){   // this will check if any blank field is entered
		    			

            if (isset ($_FILES['file'])){
					
				$idoc1 = str_replace(' ','_',$_FILES['file']['name'][$key]);
				$idoc2 = str_replace('#','_',$idoc1);
				$idoc3 = str_replace('$','_',$idoc2);
				$idoc4 = str_replace('&','_',$idoc3);
				$idoc5 = str_replace(':','_',$idoc4);
				$idoc6 = str_replace(';','_',$idoc5);
				$idoc7 = str_replace('!','_',$idoc6);
				$idoc8 = str_replace('?','_',$idoc7);
				$idoc9 = str_replace('@','_',$idoc8);
				$idoc10 = str_replace('%','_',$idoc9);
				$idoc11 = str_replace('^','_',$idoc10);
				$idoc12 = str_replace('*','_',$idoc11);
				$idoc13 = str_replace('(','_',$idoc12);
				$idoc14 = str_replace(')','_',$idoc13);
				$idoc15 = str_replace('-','_',$idoc14);
				$idoc16 = str_replace(',','_',$idoc15);
				$idoc17 = str_replace('~','_',$idoc16);
				$idoc18 = str_replace('/','_',$idoc17);
				$idoc19 = str_replace('{','_',$idoc18);
				$idoc20 = str_replace('}','_',$idoc19);
				
				$idoc_final = $idoc20;		
				
				$up_file_name = $todaytime_under . '_' . $idoc_final;
				
				$source = $_FILES['file']['tmp_name'][$key];
				$target = $rm ."/".$up_file_name;
				move_uploaded_file($source, $target);
				
				$file_path = $rm . "/" . $up_file_name; //This is the new file you saving	
				$file_name = $rm . '_bc_' . $todaytime_under;
				  
				//echo "File Path: <a hfef=\"$rm/$file_path\">$file_path</a><br /><br />";
				
				$sql = "INSERT INTO table_$rm (
				data,
				type,
                filetype,
				create_date,
				ip) 
				VALUES (
				'$file_path', 
				'path',
                '$fileType',
				'$create_date_time',
				'$ip')";
				mysql_query($sql) or die("Issue creating bb interaction"); 
	
				$msg = "Uploaded Successfully!";
		  	}
		
	     }
		 else{
				$msg = "Missing file!";
		 }
	
	}	
	
	$msgitems[] = array(
		'msg'=>$msg,
		'rm'=>$rm,
		'data'=>$file_path,
		'type'=>$type,
        'filetype'=>$fileType,
		'createdate'=>$create_date_time,
	);
	echo json_encode(array("msgitems"=>$msgitems));

    //$ref = "http://www.brushcontact.com/?e=y&msg=$msg";
    //header("Location:$ref");
} else {
    $msgitems[] = array(
		'msg'=>'No submit',
		'rm'=>'',
		'data'=>$data,
		'type'=>'',
		'createdate'=>$create_date_time,
	);
	echo json_encode(array("msgitems"=>$msgitems));
}

?>