<?php
require 'database.php';

if ( isset( $_POST["data"] ) ) {
	Database::deleteNode( json_decode($_POST["data"], true) );

	$array=array();
//	$array["list"]=json_encode(Database::returnList());
//	$array["select"]=json_encode(Database::returnSelect());

	$array["list"]=Database::returnList();
	$array["select"]=Database::returnSelect();

	echo json_encode($array);
}
