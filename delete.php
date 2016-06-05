<?php
require 'database.php';

if ( isset( $_POST["data"] ) ) {
	Database::deleteNode( json_decode($_POST["data"], true) );
}
