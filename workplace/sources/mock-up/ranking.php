<!DOCTYPE html>
<html>
<head>
	<style>
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
			padding: 5px;
			text-align: center;
		}
	</style>
</head>

<body>
<?php
    require "db_lib.php";
	
	$conn = connect_db();
	if($conn->connect_error) {
		die("Connection failed : " .$conn->connect_error);
	}
	
	$result = excute_select_query_for_multi($conn, get_query_ranking());

	echo "<table style='width:70%'>";
	echo "<tr>";
	echo "<th> Rank </th>";
	echo "<th> Name </th>";
	echo "<th> Total Score </th>";
	echo "<th> Best Score </th>";
	echo "</tr>";
	
	while($row = mysqli_fetch_row($result)) {
		echo "<tr>";
		echo "<td>" .$row[4]. "</td>";
		echo "<td>" .$row[0]. " " .$row[1]. "</td>";
		echo "<td>" .$row[2]. "</td>";
		echo "<td>" .$row[3]. "</td>";
		echo "</tr>";
	}
	echo "</tr>";
	echo "</table>";
	
	mysqli_close($conn);
?>
</body>
</html>