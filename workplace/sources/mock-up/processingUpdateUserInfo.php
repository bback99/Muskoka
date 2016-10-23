<?php
	require "db_lib.php";
    
	$conn = connect_db();
	if($conn->connect_error) {
		die("Connection failed : " .$conn->connect_error);
	}
	
	$cnt = 0;
	$user_id = $_REQUEST['user_id'];
	$out_msg = '';
	if (!checkValidation($_REQUEST['fname'], 30, 1, "Check First Name's length.", $out_msg)) {
		echo $out_msg;
		return;
	}
	if (!checkValidation($_REQUEST['lname'], 30, 1, "Check Last Name's length.", $out_msg)) {
		echo $out_msg;
		return;
	}
	if (!checkValidation($_REQUEST['email'], 50, 1, "Check Email's length.", $out_msg)) {
		echo $out_msg;
		return;
	}
	if (!checkValidation($_REQUEST['phone_number'], 11, 0, "Check Phone Number's length.", $out_msg)) {
		echo $out_msg;
		return;
	}
	if (!checkValidation($_REQUEST['address'], 100, 0, "Check Address's length.", $out_msg)) {
		echo $out_msg;
		return;
	}

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

	function checkValidation($var, $max_size, $min_size, $msg, &$out_msg) {
		if (strlen($var) > $max_size || strlen($var) < $min_size) {
			$out_msg = "<p class='result_msg'>Error!! $msg</p>";
			return false;
		}
		return true;
	}
	
	mysqli_close($conn);
?>