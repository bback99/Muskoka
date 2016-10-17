<?php
	/*
	define("HOST", "localhost");
	define("USER_NAME", "u134268841_musko");
	define("PASSWORD", "cestar201");
	define("DB_NAME", "u134268841_musko");
	*/
	
	define("HOST", "localhost");
	define("USER_NAME", "root");
	define("PASSWORD", "");
	define("DB_NAME", "muskoka");
		
    function connect_db() {
    	
		$conn = mysqli_connect(HOST, USER_NAME, PASSWORD, DB_NAME);
		return $conn;
	}
	
	function excute_select_query_by_user_id($conn, $query) {
		$result_set = mysqli_query($conn, $query);
		return $row = mysqli_fetch_row($result_set);
	}
	
	// return data_set
	function excute_select_query($conn, $query) {
		return $result_set = mysqli_query($conn, $query);
	}
	
	// return true or false
	function excute_update_query($conn, $query) {
		return $result = mysqli_query($conn, $query);
	}
	
	function get_query_user_select($user_id) {
		return "SELECT user_fname, user_lname, user_password, user_email, user_phone_number, user_address, user_admin_yn
			FROM USERS 
			WHERE user_id = $user_id";
	}
	
	function get_query_game_information($user_id) {
		return "SELECT SUM(SCORE) as TOTAL, MAX(SCORE) as BEST_SCORE, MIN(SCORE) as WORST_SCORE, AVG(SCORE) as AVERAGE 
			FROM GAME_HISTORY 
			WHERE USER_ID = $user_id";
	}
	
	function get_query_game_history($user_id) {
		return "SELECT score, stage_level, play_date
			FROM GAME_HISTORY 
			WHERE user_id = $user_id";
	}
	
	function get_query_search_for_user($user_id) {
		return "SELECT MAX(SCORE) as BEST_SCORE, MIN(SCORE) as WORST_SCORE, USER_FNAME, USER_LNAME
			FROM GAME_HISTORY gh, USERS u
			WHERE gh.USER_ID = $user_id AND u.USER_ID = $user_id";
	}
	
	function get_query_statistics() {
		return "SELECT (SELECT COUNT( DISTINCT USER_ID ) FROM GAME_HISTORY) as TOTAL, COUNT(*) as PASSED_COUNT, AVG(SCORE) as AVERAGE
			FROM GAME_HISTORY
			WHERE SCORE >= 80";
	}
	
	function get_query_words() {
		return "SELECT WORD_ID, WORD_LEVEL, WORD 
			FROM GAME_WORD";
	}
	
	function get_query_update_user_information($user_id, $query_param) {
		return "UPDATE USERS
			SET USER_FNAME = '" .$query_param[0]. "', USER_LNAME = '" .$query_param[1]."', USER_PASSWORD = '" .$query_param[2]. "',
			USER_EMAIL = '" .$query_param[3]. "', USER_PHONE_NUMBER = '" .$query_param[4]. "', USER_ADDRESS = '" .$query_param[5]. "'
			WHERE USER_ID = '" .$user_id. "'";
	}
	
	function get_query_update_quiz($word_id, $query_param) {
		return "UPDATE GAME_WORD
			SET WORD_LEVEL = '" .$query_param[0]. "', WORD = '" .$query_param[1]. "'
			WHERE WORD_ID = '" .$word_id. "'";
	}
?>