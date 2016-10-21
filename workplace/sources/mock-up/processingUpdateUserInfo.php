<?php
	require "db_lib.php";
    
	$conn = connect_db();
	if($conn->connect_error) {
		die("Connection failed : " .$conn->connect_error);
	}
	
	$cnt = 0;
	$user_id = $_REQUEST['user_id'];
	$query_param[$cnt++] = $_REQUEST['fname'];
	$query_param[$cnt++] = $_REQUEST['lname'];
	$query_param[$cnt++] = $_REQUEST['password'];
	$query_param[$cnt++] = $_REQUEST['email'];
	$query_param[$cnt++] = $_REQUEST['phone_number'];
	$query_param[$cnt++] = $_REQUEST['address'];
	
	$query = get_query_update_user_information($user_id, $query_param);
	$result = excute_query($conn, $query);
	
	if ($result) {
		echo "<p class='result_msg'>Updating was succeeded.</p>";
	}
	else {
		echo "<p class='result_msg'>Updating was failed!!!</p>";
	}
	
	mysqli_close($conn);
?>