<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View User Base / Game Information</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="css/view_user_info.css"/>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="js/view_user_info.js"></script>
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
?>
	<div id='tabs'>
	<ul>
		<li><a href='#tabs-1'>Basic Information</a></li>
		<li><a href='#tabs-2'>Game Information</a></li>
	</ul>
		<div id='tabs-1'>
			<!--query for basic information-->
			<?php $row = excute_select_query_for_one($conn, get_query_user_select($user_id)); ?>
			<table style='width:100%'>
			<tr>
			<th style='width:35%'> Field </th>
			<th> Value </th>
			</tr>

			<?php echo "<tr><td>First Name</td><td><input type='text' id='fname' value='" .$row[0]. "'></input></td></tr>";
			echo "<tr><td>Last Name</td><td><input type='text' id='lname' value='" .$row[1]. "'></input></td></tr>";
			echo "<tr><td>Password</td><td><input type='password' id='password' value='" .$row[2]. "'></input></td></tr>";
			echo "<tr><td>Email</td><td><input type='text' id='email' value='" .$row[3]. "'></input></td></tr>";
			echo "<tr><td>PhoneNumber</td><td><input type='text' id='phone_number' value='" .$row[4]. "'></input></td></tr>";
			echo "<tr><td>Address</td><td><input type='text' id='address' value='" .$row[5]. "'></input></td></tr>";
			echo "<tr><td>Registration Date</td><td><input type='text' name='regdate' value='" .$row[6]. "' readonly></input></td></tr>";
			echo "<tr><td>Last SignIn Date</td><td><input type='text' name='lastsignindate' value='" .$row[7]. "' readyonly></input></td></tr>";
			echo "<input type='hidden' id='user_id' value='" .$user_id. "'></input>";
			$admin_yn = $row[8];
			echo "</table>";
			echo "<br><div id='div_button'><button id='btn_modify' value='Modify'>Modify</button></div>";
			?>		
		</div>
		<div id='tabs-2'>
			<!--query for game information-->
			<?php $row = excute_select_query_for_one($conn, get_query_game_information($user_id)); ?>
			<table style='width:100%'>
				<caption> Score </caption>
				<tr><th> Total </th><th> Best </th><th> Worst </th><th> Average </th></tr>
			<?php echo "<tr><td>" .$row[0]. "</td><td>" .$row[1]. "</td><td>" .$row[2]. "</td><td>" .$row[3]. "</td></tr>"; ?>
			</table> 
			
			<!--query for game history-->
			<?php $result = excute_select_query_for_multi($conn, get_query_game_history($user_id)); ?>
			<br><br>
			<table style='width:100%'>
				<caption> History </caption>
				<tr class='GameHistoryTR'>
				<th> INDEX </th>
				<th> SCORE </th>
				<th> STAGE_LEVEL </th>
				<th> PLAY_DATE </th>
				</tr>
			<?php
				$cnt = 1;
				while($row = mysqli_fetch_array($result)) {
					echo "	<tr class='GameHistoryTR'>
							<td>" .$cnt++. "</td>
							<td>" .$row['score']. "</td>
							<td>" .$row['stage_level']. "</td>
							<td>" .$row['play_date']. "</td></tr>";
				}?>
			</table>
		</div>
	</div>
	
	<?php
		if ($admin_yn == 'Y') {
			// requst data of 
			echo "<br><br>";
			echo "<div id='result'></div>";
			echo "[Amdin Menu]<br>";
			echo "<br><a href='admin.php'>Go to Admin's Page</a>";
		}
		mysqli_close($conn);
	?>
</body>
</html>