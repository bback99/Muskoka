<?php
    include_once 'header.php';

	$conn = connect_db();
	if($conn->connect_error) {
		die("Connection failed : " .$conn->connect_error);
	}
	
	if (login_check($mysqli) == true) :
		include_once 'menu.php';

	$user_id = $_SESSION['user_id'];
	$admin_yn = 'N';
?>

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
	<table style="width:100%">
	<tr>
		<td style="width:30%"></td>
		<td>
			<div id='tabs'>
			<ul>
				<li><a href='#tabs-1'>Basic Information</a></li>
				<li><a href='#tabs-2'>Game Information</a></li>
			</ul>
				<div id='tabs-1'>
					<!--query for basic information-->
					<?php $row = excute_select_query_for_one($conn, get_query_user_select($user_id)); ?>
					<table id='table_basic' style='width:100%'>
					<caption>Basic Information</caption>
					<?php echo "<tr><td><label>First Name</label></td><td><input type='text' id='fname' value='" .$row[0]. "'></input></td></tr>";
					echo "<tr><td><label>Last Name</label></td><td><input type='text' id='lname' value='" .$row[1]. "'></input></td></tr>";
					echo "<tr><td><label>Password</label></td><td><input type='password' id='password' value='" .$row[2]. "'></input></td></tr>";
					echo "<tr><td><label>Email</label></td><td><input type='text' id='email' value='" .$row[3]. "'></input></td></tr>";
					echo "<tr><td><label>PhoneNumber</label></td><td><input type='text' id='phone_number' value='" .$row[4]. "'></input></td></tr>";
					echo "<tr><td><label>Address</label></td><td><textarea id='address' cols='33' rows='4'>".$row[5]."</textarea></td></tr>";
					echo "<tr><td><label>Registration Date</label></td><td><input type='text' name='regdate' value='" .$row[6]. "' readonly></input></td></tr>";
					echo "<tr><td><label>Last LogOn Date</label></td><td><input type='text' name='lastsignindate' value='" .$row[7]. "' readyonly></input></td></tr>";
					echo "<input type='hidden' id='user_id' value='" .$user_id. "'></input>";
					$admin_yn = $row[8];
					echo "</table>";
					echo "<br><div id='div_button'><button id='btn_modify' value='Modify'>Modify</button></div>";
					echo "<div id='result'></div>";
					?>		
				</div>
				<div id='tabs-2'>
					<!--query for game information-->
					<?php $row = excute_select_query_for_one($conn, get_query_game_information($user_id)); ?>
					<table style='width:100%'>
						<caption> SCORE </caption>
						<tr class='th'><th> TOTAL </th><th class='th'> BEST </th><th class='th'> WORST </th><th class='th'> AVERAGE </th></tr>
					<?php echo "<tr class='tr_score'><td>" .$row[0]. "</td><td>" .$row[1]. "</td><td>" .$row[2]. "</td><td>" .$row[3]. "</td></tr>"; ?>
					</table> 
					
					<!--query for game history-->
					<?php $result = excute_select_query_for_multi($conn, get_query_game_history($user_id)); ?>
					<br><br>
					<table style='width:100%'>
						<caption> History </caption>
						<tr class='GameHistoryTR'>
						<th class='th'> INDEX </th>
						<th class='th'> SCORE </th>
						<th class='th'> STAGE_LEVEL </th>
						<th class='th'> PLAY_DATE </th>
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
		</td>
		<td style="width:30%"></td>
	</tr>
</table>

	<?php
		mysqli_close($conn);
	?>

	<footer>
	</footer>
	
	<?php
		else :
			include_once 'unauthorized.php';
		endif;
	?>
</body>
</html>