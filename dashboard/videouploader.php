<?php
$output_dir = dirname(dirname(__FILE__)) . "/videos_repository/";
if(isset($_FILES["myVideo"]))
{
	$ret = array();
	$error =$_FILES["myVideo"]["error"];
	if(!is_array($_FILES["myVideo"]["name"])) 
	{
 	 	$fileName = $_FILES["myVideo"]["name"];
 	 	$extension = pathinfo($fileName, PATHINFO_EXTENSION);
 	 	$newFileName = md5(uniqid() . $fileName) . '.' . $extension;
 		move_uploaded_file($_FILES["myVideo"]["tmp_name"], $output_dir.$newFileName);
    	$ret[]= $newFileName;
	}
    echo $newFileName;
 }
 ?>