<?php
	require "db_lib.php";
    
	$conn = connect_db();
	if($conn->connect_error) {
		die("Connection failed : " .$conn->connect_error);
	}
	
	$cnt = 0;
	$user_id = $_POST['user_id'];
	$query_param[$cnt++] = $_POST['fname'];
	$query_param[$cnt++] = $_POST['lname'];
	$query_param[$cnt++] = $_POST['password'];
	$query_param[$cnt++] = $_POST['email'];
	$query_param[$cnt++] = $_POST['phone_number'];
	$query_param[$cnt++] = $_POST['address'];
	
	$query = get_query_update_user_information($user_id, $query_param);
	$result = excute_query($conn, $query);
	
	if ($result) {
		echo "<script>window.confirm('Update Succeeded!!!'); window.location.href = 'view_information.php';</script>";
	}
	else {
		echo "<script>window.confirm('Update Failed!!!'); window.location.href = 'view_information.php';</script>";
	}
	
	mysqli_close($conn);
?>