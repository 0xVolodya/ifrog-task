<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Awesome test task</title>
	<link rel="stylesheet" href="css/style.css">


</head>
<body>
<h1 class="heading">Awesome test task</h1>
<div class="list_wrapper">
	<?php
	require_once( "list.php" );
	echo $list;
	?>
</div>
<div class="form_wrapper">
	<form action="" id="form" class="form">
		<input type="hidden" id="input1">
		<input type="button" id="button1" value="Кнопка 1">
		<input type="button" id="button2" value="Кнопка 2">
		<input type="button" id="button3" value="Кнопка 3">

		<input type="hidden" name="reply_id" class="reply_id" value="">

	</form>
</div>

<div class="select_wrapper">
	<?php
	echo $select;
	?>
</div>

<script src="js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/script.js">
</script>
</body>
</html>


