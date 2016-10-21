<body>
<?php
    require "db_lib.php";    
	$conn = connect_db();
	if($conn->connect_error) {
		die("Connection failed : " .$conn->connect_error);} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Page</title>
	<link rel="stylesheet" href="css/admin.css"/>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="js/admin.js"></script>
</head>

<body>
	<div id='tabs'ß><ul><li><a href='#tabs-1'>Search For Users</a></li><li><a href='#tabs-2'>Statistics</a></li><li><a href='#tabs-3'>Manage Quiz</a></li></ul>
		<div id='tabs-1'>
			<table style='width:100%'>
				<caption> Search for Users </caption>
				<tr>
					<td style='width:20%'>
						<select id='select_search_option' name='select_search_option'>
							<option value='USER_ID' selected>User ID</option>
							<option value='USER_FNAME'>First Name</option>
							<option value='USER_LNAME'>Last Name</option>
							<option value='USER_EMAIL'>Email</option>
						</select>
					</td>
					<td><input type='text' name='searching_word' id='searching_word' value=''></input></td>
					<td><input class='btn' type='submit' value='Search' onclick=resultInSearch()></input></td></tr>
			</table><br><br>
			<div id='resultInSearch'></div>
			<div id='accordion'></div>	<!--place where here will show result of searching from processingSearchUsers.php-->
		</div>
		<div id='tabs-2'>
			<!--query for statistics-->
			<?php $row = excute_select_query_for_one($conn, get_query_statistics());
			echo "<table style='width:100%'>";
			echo "<tr><th style='width:35%'> Field </th><th> Value </th></tr>";
			echo "<tr><td>Total Users</td><td><input type='text' value='" .$row[0]. "' readonly></input></td></tr>";
			echo "<tr><td>Passed Users</td><td><input type='text' value='" .$row[1]. "' readonly></input></td></tr>";
			echo "<tr><td>Failed Users</td><td><input type='text' value='" .($row[0] - $row[1]). "' readonly></input></td></tr>";
			echo "<tr><td>Average Score</td><td><input type='text' value='" .$row[2]. "' readonly></input></td></tr>";
			echo "<tr><td>Currently using users</td><td><input type='text' value='" .$row[3]. "' readonly></input></td></tr>";
			echo "</table>"; ?>
		</div>
		<div id='tabs-3'>
			<!--form for adding quiz words-->
			<table style='width:100%'>
				<caption> Add Quiz Words </caption>
				<tr>
					<th style='witdh:30%'> LEVEL </th><th style='width:50%'> WORD </th><th></th>
				</tr>
				<tr>
					<td><input type='text' id='txt_add_level' name='txt_add_level'></input></td>
					<td><input type='text' id='txt_add_word' name='txt_add_word'></input></td>
				<td style='width:30%'><button class='btn2' name='btn_add'>ADD</button></td>
				</tr>
			</table><br><br>

			<div id='resultAddWords'>
				<?php 
				require "getAllWords.php";
				getAllWords($conn); ?>
			</div>
		</div>
	</div>	

	<?php mysqli_close($conn); ?>
</body>
</html>