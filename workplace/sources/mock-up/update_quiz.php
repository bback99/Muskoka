<?php
	require "db_lib.php";
    
	$conn = connect_db();
	if($conn->connect_error) {
		die("Connection failed : " .$conn->connect_error);
	}
	
	$cnt = 0;
	$query_param = array();
	$query;
	if (isset($_POST['btn_add'])) {
		$add_level = $_POST['txt_add_level'];
		$add_word = $_POST['txt_add_word'];
		$query_param[$cnt++] = $add_level;
		$query_param[$cnt++] = $add_word;
		
		$query = get_query_add_quiz($query_param);
		$result = excute_query($conn, $query);
		if ($result) {
			echo "<script>window.confirm('Insert Succeeded!!!'); window.location.href = 'admin.php';</script>";			
		}
		else {
			echo "<script>window.confirm('Insert Failed!!!'); window.location.href = 'admin.php';</script>";
		}
	}
	else {
		$word_id = $_POST['btn_change'];
		$ary_level = $_POST['level'];
		$ary_word = $_POST['word'];
		
		$query_param[$cnt++] = $ary_level[$word_id];
		$query_param[$cnt++] = $ary_word[$word_id];
		
		if ($word_id != NULL) {		
			$result = excute_query($conn, get_query_update_quiz($word_id, $query_param));
			if ($result) {
				echo "<script>window.confirm('Update Succeeded!!!'); window.location.href = 'admin.php';</script>";
			}
			else {
				echo "<script>window.confirm('Update Failed!!!'); window.location.href = 'admin.php';</script>";
			}
		}
		else {
			$word_id = $_POST['btn_remove'];
			echo "remove word_id: ";
			var_dump($word_id);
		
			$result = excute_query($conn, get_query_remove_quiz($word_id, $query_param));
			if ($result) {
				echo "<script>window.confirm('Remove Succeeded!!!'); window.location.href = 'admin.php';</script>";
			}
			else {
				echo "<script>window.confirm('Remove Failed!!!'); window.location.href = 'admin.php';</script>";
			}
		}
	}
	mysqli_close($conn);
?>