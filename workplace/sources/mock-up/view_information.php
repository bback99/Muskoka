<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View User Base / Game Information</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="/resources/demos/style.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
		$( function() {
			$( "#tabs" ).tabs();
		} );
	</script>
	<style>
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
			padding: 5px;
			text-align: center;
		}
		tr {
			height: 50px;
		}
		.GameHistoryTR {
			height: 25px;
		}
		input {
			height: 30px;
			width: 70%;
			text-align: center;
		}
		input[type=text]:focus {
    		border: 2px solid #555;
		}
		.btn {
			background: #3498db;
			background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
			background-image: -moz-linear-gradient(top, #3498db, #2980b9);
			background-image: -ms-linear-gradient(top, #3498db, #2980b9);
			background-image: -o-linear-gradient(top, #3498db, #2980b9);
			background-image: linear-gradient(to bottom, #3498db, #2980b9);
			-webkit-border-radius: 28;
			-moz-border-radius: 28;
			border-radius: 28px;
			font-family: Georgia;
			color: #ffffff;
			font-size: 22px;
			padding: 9px 20px 10px 20px;
			text-decoration: none;
			width: 20%;
			height: 45px;
		}

		.btn:hover {
			background: #3cb0fd;
		  	background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
		  	background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
		  	background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
		  	background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
		  	background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
		  	text-decoration: none;
		}
		#div_button {
			display: flex; 
			justify-content: center;
		}

	</style>
</head>

<body>
<?php
    require "db_lib.php";
    
	$user_id = 1;
	$admin_yn = 'N';
	
	$conn = connect_db();
	if($conn->connect_error) {
		die("Connection failed : " .$conn->connect_error);
	}
	
	echo "
	<div id='tabs'>
	<ul>
		<li><a href='#tabs-1'>Basic Information</a></li>
		<li><a href='#tabs-2'>Game Information</a></li>
	</ul>
	<div id='tabs-1'> ";
		// query for basic information
		$row = excute_select_query_by_user_id($conn, get_query_user_select($user_id));
		echo "<form action='update_user_information.php' method='post'>";
		echo "<table style='width:100%'>";
		echo "<tr>";
		echo "<th style='width:35%'> Field </th>";
		echo "<th> Value </th>";
		echo "</tr>";

		echo "<tr><td>user_fname</td><td><input type='text' name='fname' value='" .$row[0]. "'></input></td></tr>";
		echo "<tr><td>user_lname</td><td><input type='text' name='lname' value='" .$row[1]. "'></input></td></tr>";
		echo "<tr><td>user_password</td><td><input type='password' name='password' value='" .$row[2]. "'></input></td></tr>";
		echo "<tr><td>user_email</td><td><input type='text' name='email' value='" .$row[3]. "'></input></td></tr>";
		echo "<tr><td>user_phone_number</td><td><input type='text' name='phone_number' value='" .$row[4]. "'></input></td></tr>";
		echo "<tr><td>user_address</td><td><input type='text' name='address' value='" .$row[5]. "'></input></td></tr>";
		echo "<input type='hidden' name='user_id' value='" .$user_id. "'></input>";
		$admin_yn = $row[6];
		echo "</table>";
		echo "<br><div id='div_button'><input class='btn' type='submit' value='Modify'></input></div>";
		echo "</form>";
			
		echo 
	"</div>
	<div id='tabs-2'>";
		// query for game information
		$row = excute_select_query_by_user_id($conn, get_query_game_information($user_id));
		echo "<table style='width:100%'>";
		echo "<caption> Score </caption>";
		echo "<tr><th> Total </th><th> Best </th><th> Worst </th><th> Average </th></tr>";
		echo "<tr><td>" .$row[0]. "</td><td>" .$row[1]. "</td><td>" .$row[2]. "</td><td>" .$row[3]. "</td></tr>";
		echo "</table>";
		
		// query for game history
		$result = excute_select_query($conn, get_query_game_history($user_id));
		echo "<br><br>";
		echo "<table style='width:100%'>";
		echo "<caption> History </caption>";
		echo "<tr class='GameHistoryTR'>";
		echo "<th> INDEX </th>";
		echo "<th> SCORE </th>";
		echo "<th> STAGE_LEVEL </th>";
		echo "<th> PLAY_DATE </th>";
		echo "</tr>";

		$cnt = 1;
		while($row = mysqli_fetch_array($result)) {
			echo "	<tr class='GameHistoryTR'>
					<td>" .$cnt++. "</td>
					<td>" .$row['score']. "</td>
					<td>" .$row['stage_level']. "</td>
					<td>" .$row['play_date']. "</td></tr>";
		}
		echo "</table>";
	echo "</div>
	</div>";
	
	if ($admin_yn == 'Y') {
		// requst data of 
		echo "<br><br>";
		echo "[Amdin Menu]<br>";
		echo "<br><a href='admin.php'>Go to Admin's Page</a>";
	}
	
	mysqli_close($conn);
?>
</body>
</html>