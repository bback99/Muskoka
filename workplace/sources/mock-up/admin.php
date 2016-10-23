<?php
	include_once 'header.php';
	$conn = connect_db();
	if($conn->connect_error) {
		die("Connection failed : " .$conn->connect_error);} 

	if (login_check($mysqli) == true) :
		include_once 'menu.php';
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
	<table style="width:100%">
	<tr>
		<td style="width:30%"></td>
		<td>
			<div style=''>
				<div id='tabs' width='50%'>
				<ul><li><a href='#tabs-1'>Search For Users</a></li><li><a href='#tabs-2'>Statistics</a></li><li><a href='#tabs-3'>Manage Quiz</a></li></ul>
					<div id='tabs-1'>
						<table style='width:100%'>
							<caption> Search for Users </caption>
							<tr>
								<td style='text-align:right'>
									<select style='width:200px;' id='select_search_option' name='select_search_option'>
										<option value='USER_ID' selected>User ID</option>
										<option value='USER_FNAME'>First Name</option>
										<option value='USER_LNAME'>Last Name</option>
										<option value='USER_EMAIL'>Email</option>
									</select>
								</td>
								<td><input class='input_search' type='text' name='searching_word' id='searching_word' value=''></input></td>
								<td><div class='btn_bg'><input id='btn_search' type='submit' value='SEARCH' onclick=resultInSearch()></input></div></td></tr>
						</table><br><br>
						<div id='resultInSearch'></div>
						<div id='accordion'></div>	<!--place where here will show result of searching from processingSearchUsers.php-->
					</div>
					<div id='tabs-2'>
						<!--query for statistics-->
						<?php $row = excute_select_query_for_one($conn, get_query_statistics());
						echo "<table id='table_stat' style='width:100%'>";
						echo "<caption>STATISTICS</caption>";
						echo "<tr><td><label>Total Users</label></td><td><input class='input_stat' type='text' value='" .$row[0]. "' readonly></input></td></tr>";
						echo "<tr><td><label>Passed Users</label></td><td><input class='input_stat' type='text' value='" .$row[1]. "' readonly></input></td></tr>";
						echo "<tr><td><label>Failed Users</label></td><td><input class='input_stat' type='text' value='" .($row[0] - $row[1]). "' readonly></input></td></tr>";
						echo "<tr><td><label>Average Score</label></td><td><input class='input_stat' type='text' value='" .$row[2]. "' readonly></input></td></tr>";
						echo "<tr><td><label>Currently using users</label></td><td><input class='input_stat' type='text' value='" .$row[3]. "' readonly></input></td></tr>";
						echo "</table>"; ?>
					</div>
					<div id='tabs-3'>
						<!--form for adding quiz words-->
						<table style='width:100%'>
							<caption> Add Quiz Words </caption>
							<tr>
								<td>LEVEL</td><td><input class='input_quiz' type='text' id='txt_add_level' name='txt_add_level'></input></td>
								<td>WORD</td><td><input class='input_quiz' type='text' id='txt_add_word' name='txt_add_word'></input></td>
							<td style='width:30%'><input id='btn_add_words' name='btn_add' value='ADD'></input></td>
							</tr>
						</table><br><br>

						<div id='resultAddWords'>
							<?php 
							require "getAllWords.php";
							getAllWords($conn); ?>
						</div>
					</div>
				</div>	<!-- tabs -->
			</div>
			</td>
			<td style="width:30%"></td>
		</tr>
	</table>

	<?php mysqli_close($conn); ?>

	<footer>
	</footer>
	
	<?php
		else :
			include_once 'unauthorized.php';
		endif;
	?>
</body>
</html>