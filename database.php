<?php

class Database {

	private static $dbHost = 'localhost';
	private static $dbUser = 'root';
	private static $dbPass = '';
	private static $dbName = 'testtask';
	private static $connection = null;


	public function __construct() {
		die();
	}

	public static function connect() {
		if ( self::$connection == null ) {
			try {
				self::$connection = new PDO( "mysql:host=" . self::$dbHost . ";" .
				                             "dbname=" . self::$dbName, self::$dbUser, self::$dbPass );

			} catch ( PDOException $e ) {
				die( $e->getMessage() );
			}
		}

		return self::$connection;
	}

	public static function disconnect() {
		self::$connection = null;
	}

	public static function insert( $data ) {
		$pdo = Database::connect();
		Database::isTableExists( $pdo, 'table_list' );
		Database::ifEmptyInit( $pdo, 'table_list' );

		$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		$name      = $data['name'];
		$parent_id = $data['parent_id'];

		$stmt = $pdo->prepare( 'SELECT rgt from table_list WHERE id=?' );
		$stmt->execute( array( $parent_id ) );
		$stmt = $stmt->fetch();

		$myRight = intval( $stmt["rgt"] ) - 1;
//		var_dump( $myRight );
		$stmt = $pdo->prepare( 'UPDATE table_list SET rgt=rgt+2 where rgt> ?' );
		$stmt->execute( array( $myRight ) );

		$stmt = $pdo->prepare( 'UPDATE table_list SET lft=lft+2 where lft> ?' );
		$stmt->execute( array( $myRight ) );

//
//		$stmt = $pdo->prepare( 'INSERT INTO table_list(`user_name`,`parent_id`) VALUES (?)' );
//		$stmt->execute( array( $data['name'], $data['parent_id']) );

		$stmt = $pdo->prepare( 'INSERT INTO table_list(`user_name`,`lft`,`rgt`,`parent_id`) VALUES(?,?,?,?)' );
		$stmt->execute( array( $name, $myRight + 1, $myRight + 2, $parent_id ) );


		Database::disconnect();
	}

	public static function returnList() {
		$pdo = Database::connect();

		Database::isTableExists( $pdo, 'table_list' );

		Database::ifEmptyInit( $pdo, 'table_list' );

		$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );


		$rows = $pdo->query( 'SELECT node.id,(COUNT(parent.user_name)-1) as depth, node.user_name
FROM table_list as node,table_list as parent
WHERE node.lft BETWEEN parent.lft and parent.rgt
GROUP BY node.user_name
ORDER BY node.lft' );

		$result[] = "<ul>";
		$prev     = 1;
		$current  = 0;

		foreach ( $rows as $row ) {
			$current = intval( $row['depth'] );
//			echo '<pre>' . var_dump( $prev, $current, $row["user_name"] ) . '</pre>';
			if ( $current == 0 ) {
				continue;
			}
			if ( $current > $prev ) {

				$result[] = '<li>';
				$result[] = '<ul >';
				$result[] = '<li class="li_comment li_comment_' . $row['id'] . '">';
				$result[] = '<p class=" li_comment-text">' . $row["user_name"] . '</p>';
				$result[] = "<a href=\"\" class=\"reply_button\" id=\"{$row['id']}\">вставить</a>";
				$result[] = "</li>";


			} else if ( $current == $prev ) {
				$result[] = '<li class="li_comment li_comment_' . $row['id'] . '">';
				$result[] = '<p class=" li_comment-text">' . $row["user_name"] . '</p>';
				$result[] = "<a href=\"\" class=\"reply_button\" id=\"{$row['id']}\">вставить</a>";
				$result[] = "</li>";


			} else {
				$i = $current;
				$j = $prev;
				while ( $i < $j ) {
					$result[] = "</ul>";
					$result[] = "</li>";
					$i ++;
				}
				$result[] = '<li class="li_comment li_comment_' . $row['id'] . '">';
				$result[] = '<p class=" li_comment-text">' . $row["user_name"] . '</p>';
				$result[] = "<a href=\"\" class=\"reply_button\" id=\"{$row['id']}\">вставить</a>";
				$result[] = "</li>";

			}
			$prev = $current;
		}
		$result[] = "</ul>";

		if ( $current != 1 ) {
			$i = $current;
			while ( $i > 1 ) {
				$result[] = "</ul>";
				$result[] = "</li>";
				$i --;
			}
		}


		$list = implode( "\n", $result );

		Database::disconnect();

		return $list;

	}

	public static function deleteNode( $data ) {
		$id  = $data['id'];
		$pdo = Database::connect();
		Database::ifEmptyInit( $pdo, 'table_list' );


		Database::isTableExists( $pdo, 'table_list' );
		Database::ifEmptyInit( $pdo, 'table_list' );

		$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		$stmt = $pdo->prepare( 'SELECT rgt from table_list WHERE id=?' );
		$stmt->execute( array( $id ) );
		$stmt    = $stmt->fetch();
		$myRight = intval( $stmt['rgt'] );

		$stmt = $pdo->prepare( 'SELECT lft from table_list WHERE id=?' );
		$stmt->execute( array( $id ) );
		$stmt   = $stmt->fetch();
		$myLeft = intval( $stmt['lft'] );

		$width = $myRight - $myLeft + 1;
//		var_dump($id, $myLeft, $myRight ,$width);

		$stmt = $pdo->prepare( 'DELETE from table_list where lft BETWEEN ? and ?' );
		$stmt->execute( array( $myLeft, $myRight ) );

		$stmt = $pdo->prepare( 'UPDATE table_list SET rgt=rgt-? where rgt> ?' );
		$stmt->execute( array( $width, $myRight ) );

		$stmt = $pdo->prepare( 'UPDATE table_list SET lft=lft-? where lft> ?' );
		$stmt->execute( array( $width, $myRight ) );


		Database::disconnect();
	}

	public static function returnSelect() {
		$pdo = Database::connect();

		Database::isTableExists( $pdo, 'table_list' );

		Database::ifEmptyInit( $pdo, 'table_list' );

		$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );


		$rows = $pdo->query( 'SELECT node.id,(COUNT(parent.user_name)-1) as depth, node.user_name
FROM table_list as node,table_list as parent
WHERE node.lft BETWEEN parent.lft and parent.rgt
GROUP BY node.user_name
ORDER BY node.lft' );

		$result[] = "<select size='3' name='Blabla'><option selected='selected' value=''>Выберите имя для удаления</option>";

		foreach ( $rows as $row ) {
			if ( intval( $row['depth'] ) == 0 ) {
				continue;
			}
			$result[] = '<option value="' . $row['id'] . '">' . $row['user_name'] . '</option>';


		}
		$result[] = "</select>";

		$list = implode( "\n", $result );


		Database::disconnect();

		return $list;
	}

	private static function isTableExists( $dbh, $name ) {
		$results = $dbh->query( "SHOW TABLES LIKE '$name'" );
		if ( ! $results ) {
			die( print_r( $dbh->errorInfo(), true ) );
		}
		if ( $results->rowCount() > 0 ) {
//			echo 'table exists';
		}
	}

	private static function ifEmptyInit( $pdo, $name ) {
		$stmt = $pdo->prepare( 'SELECT * FROM ' . $name );
		$stmt->execute();

		$row = $stmt->fetch( PDO::FETCH_ASSOC );

		if ( ! $row ) {
			$stmt = $pdo->prepare( 'INSERT INTO table_list(`id`,`user_name`,`lft`,`rgt`,`parent_id`) VALUES(?,?,?,?,?)' );
			$stmt->execute( array( 1, 'root', 1, 2, 0 ) );
		} else{
//			echo 'table is not empty';
		}
	}

}
