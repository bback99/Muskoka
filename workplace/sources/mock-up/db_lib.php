<?php
	
	define("HOST", "localhost");
	define("USER_NAME", "u134268841_musko");
	define("PASSWORD", "cestar201");
	define("DB_NAME", "u134268841_musko");
	
    function connect_db() {
		$conn = mysqli_connect(HOST, USER_NAME, PASSWORD, DB_NAME);
		return $conn;
	}
	
	function get_db_error($conn, $query, $back_to_page) {
		echo "<br> Query failed.";
		echo "<br>" .$query;
		echo "<br>" .mysqli_error($conn);
		echo "<br><a href='" .$back_to_page. "'> back to previous page </a>";
	}
	
	
	// util functions
	function excute_select_query_for_one($conn, $query) {		// when returning only one row 
		$result_set = mysqli_query($conn, $query);
		return $row = mysqli_fetch_row($result_set);
	}
	
	// return data_set
	function excute_select_query_for_multi($conn, $query) {					// when returning multi rows
		return $result_set = mysqli_query($conn, $query);
	}
	
	// return true or false
	function excute_query($conn, $query) {							// when returning true or false
		return $result = mysqli_query($conn, $query);
	}
	
	
	// get query functions
	function get_query_user_select($user_id) {
		return "SELECT user_fname, user_lname, user_password, user_email, user_phone_number, user_address, user_registration_date, user_last_signin_date, user_admin_yn
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
	
	function get_query_search_by_searching_word($extra_query) {
		return "SELECT u.USER_ID as UID, u.USER_FNAME as USER_FNAME, u.USER_LNAME as USER_LNAME
			FROM GAME_HISTORY gh, USERS u
			WHERE gh.USER_ID = u.USER_ID AND u.USER_ID IN (SELECT USER_ID FROM USERS WHERE $extra_query)
			GROUP BY gh.USER_ID";
	}
	
	function get_query_statistics() {
		return "SELECT (SELECT COUNT( DISTINCT USER_ID ) FROM GAME_HISTORY) as TOTAL, (SELECT COUNT(*) FROM GAME_HISTORY WHERE SCORE >= 80) as PASSED_COUNT, AVG(SCORE) as AVERAGE,
			(SELECT count(*) FROM USERS WHERE user_start_game_time IS NOT NULL AND user_end_game_time IS NULL AND TIMESTAMPDIFF(SECOND, user_start_game_time, now()) <= 300) as CURRENT_USE
			FROM GAME_HISTORY";
	}
	
	function get_query_words() {
		return "SELECT WORD_ID, WORD_LEVEL, WORD 
			FROM GAME_WORD
			ORDER BY WORD_LEVEL, WORD";
	}
	
	function get_query_add_quiz($query_param) {
		return "INSERT INTO GAME_WORD(WORD_LEVEL, WORD) VALUES(" .$query_param[0]. ", '" .$query_param[1]. "')";
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
	
	function get_query_remove_quiz($word_id) {
		return "DELETE FROM GAME_WORD
			WHERE WORD_ID = '" .$word_id. "'";
	}
	
	function get_query_ranking() {
		return "SELECT u.user_fname, u.user_lname, s.TOT, s.MAX, rank FROM
			USERS u,
			(SELECT user_id, TOT, MAX,
			@curRank := IF(@prevRank = TOT, @curRank, @incRank) AS rank, 
			@incRank := @incRank + 1, 
			@prevRank := TOT
			FROM (SELECT user_id, sum(gh.score) as TOT, max(gh.score) as MAX FROM GAME_HISTORY gh GROUP BY user_id) p, (
				SELECT @curRank :=0, @prevRank := NULL, @incRank := 1
			) r 
			ORDER BY TOT DESC) s
			WHERE u.user_id = s.user_id
			ORDER BY rank";
	}
?>