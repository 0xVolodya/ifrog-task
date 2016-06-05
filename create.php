<?php
require 'database.php';


if ( isset( $_POST["data"] ) ) {
	Database::insert( json_decode($_POST["data"], true) );

	$array=array();

	$array["list"]=Database::returnList();
	$array["select"]=Database::returnSelect();

	echo json_encode($array);

}
