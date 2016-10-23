<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Ranking</title>
	<link rel="stylesheet" href="css/ranking.css"/>
</head>

<body>
    <?php 
		include_once 'header.php';

		if (login_check($mysqli) == true) :
			include_once 'menu.php';
	?>
	<table style="width:100%">
	<tr>
		<td style="width:25%"></td>
		<td>
<?php
	$conn = connect_db();
	if($conn->connect_error) {
		die("Connection failed : " .$conn->connect_error);
	}
	
	$result = excute_select_query_for_multi($conn, get_query_ranking());

	echo "<table class='r_table' style='width:100%'>";
	echo "<caption><h1>RANKING</h1></caption>";
	echo "<tr class='r_tr'>";
	echo "<th class='r_th'> RANK </th>";
	echo "<th class='r_th'> NAME </th>";
	echo "<th class='r_th'> TOTAL SCORE </th>";
	echo "<th class='r_th'> BEST SCORE </th>";
	echo "</tr>";
	
	while($row = mysqli_fetch_row($result)) {
		echo "<tr class='r_tr'>";
		echo "<td class='r_td'>" .$row[4]. "</td>";
		echo "<td class='r_td'>" .$row[0]. " " .$row[1]. "</td>";
		echo "<td class='r_td'>" .$row[2]. "</td>";
		echo "<td class='r_td'>" .$row[3]. "</td>";
		echo "</tr>";
	}
	echo "</tr>";
	echo "</table>";
	
	mysqli_close($conn);
?>
			</td>
			<td style="width:25%"></td>
		<tr>
	</table>

<?php
	echo "<footer>";
	echo "</footer>";
    else :
        include_once 'unauthorized.php';
    endif;
?>

</body>
</html>