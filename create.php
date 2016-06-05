<?php
require 'database.php';

//$pos=json_decode('{"name":"qqqq","parent_id":1}',true);
//var_dump($pos["parent_id"]);
//$_POST='{"name":"qqqq","parent_id":1}';

if ( isset( $_POST["data"] ) ) {
	Database::insert( json_decode($_POST["data"], true) );
}

//var_dump($person);

//echo json_encode( Database::returnList() );
//echo Database::returnList();

//header( "Location: index.php" );


