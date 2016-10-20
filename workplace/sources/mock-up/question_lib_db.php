<?php require("db_lib.php") ?>
<?php	
	// this is global variables to set the game environment.
	// -----------------------------------------------------
	$CHOICE_CHAR_NUM = 7;
	$EMPTY_SLOT_NUM = 2;
	$TOTAL_QUESTION_NUM = 5;
	$TIME_LIMIT = 30;
	// -----------------------------------------------------
																
	function getAnswer($qid) {
		$conn = connect_db();
		if ($conn->connect_error) {
			die ("Connection failed : " . $conn->connect_error);
		}		
	
		$query = "SELECT WORD FROM GAME_WORD WHERE WORD_ID = $qid";
		$resultSet = mysqli_query($conn, $query);
		$row = mysqli_fetch_row($resultSet);
		
		mysqli_close($conn);
		
		return $row[0];
	}

	function getChoiceChars($question, $num, $empty_position_list) {
		$alphabet = getRandomAlphabets($num);
		$replace_cnt = 0;
		
		for ($i = 0; $i < count($empty_position_list); $i++) {
			$pos = $empty_position_list[$i];
			$alphabet[$replace_cnt++] = $question[$pos];
		}
		
		shuffle($alphabet);
		return $alphabet;
	}
	
	function getRandomAlphabets($num) {
		$alphabet = range("A", "Z");
		$rand_keys = array_rand($alphabet, $num);
		$new_array = array();
		
		for ($i = 0; $i < $num; $i++) {
			$new_array[$i] = $alphabet[$rand_keys[$i]]; 
		}
		
		return $new_array;
	}
	
	function getRandomEmptyPositions($question, $empty_num) {
		$str_len = strlen($question);
		$position_array = range(0, $str_len - 1);
		$rand_pos_list = array_rand($position_array, $empty_num);
		
		return $rand_pos_list;
	}
	
	function getQuestion($stage_level, $used_qid_list) {
		$undup_list = array();
		$undup_list_cnt = 0;
		
		$conn = connect_db();
		if ($conn->connect_error) {
			die ("Connection failed : " . $conn->connect_error);
		}		
	
		$query = "SELECT WORD_ID FROM GAME_WORD WHERE WORD_LEVEL = $stage_level";
		$resultSet = mysqli_query($conn, $query);
		
		while ($row = mysqli_fetch_row($resultSet)) {
			if (in_array($row[0], $used_qid_list) == FALSE) {
				$undup_list[$undup_list_cnt++] = $row[0];
			}	
		}
				
		if (count($undup_list) > 0) {
			$rand_idx = rand(0, count($undup_list) - 1);
			$selected_id = $undup_list[$rand_idx];
		}
		else {
			$selected_id = 0;
		}
		
		$query = "SELECT WORD FROM GAME_WORD WHERE WORD_ID = $selected_id";
		$resultSet = mysqli_query($conn, $query);
		$row = mysqli_fetch_row($resultSet);
		
		mysqli_close($conn);
		
		return array ($selected_id, $row[0]);
	}
	
	function saveScore($score, $stage_level, $userid) {
		$conn = connect_db();
		if ($conn->connect_error) {
			die ("Connection failed : " . $conn->connect_error);
		}		
	
		$current_date = date('Ymd');
		$query = "INSERT INTO GAME_HISTORY (SCORE, STAGE_LEVEL, PLAY_DATE, USER_ID)";
		$query = $query . " VALUES($score, $stage_level, $current_date, $userid)";
	
		$isInserted = mysqli_query($conn, $query);
	
		if ($isInserted == FALSE) {
			echo "<br> Error: " . $query . "<br>" . $conn->error . "<br>";
		}
		
		mysqli_close($conn);
	}
	
	function saveStartGameTime($userid) {
		$conn = connect_db();
		if ($conn->connect_error) {
			die ("Connection failed : " . $conn->connect_error);
		}
	
		$currentTime = date('Y-m-d H:i:s');
		$query = "UPDATE USERS SET user_start_game_time = '$currentTime', user_end_game_time = NULL where user_id = " . $userid;
		$isUpdated = mysqli_query($conn, $query);
	
		if ($isUpdated == FALSE) {
			echo "<br> Error: " . $query . "<br>" . $conn->error . "<br>";
		}
		
		mysqli_close($conn);
	}
	
	function saveEndGameTime($userid) {
		$conn = connect_db();
		if ($conn->connect_error) {
			die ("Connection failed : " . $conn->connect_error);
		}
	
		$currentTime = date('Y-m-d H:i:s');
		$query = "UPDATE USERS SET user_end_game_time = '$currentTime' where user_id = " . $userid;
		$isUpdated = mysqli_query($conn, $query);
	
		if ($isUpdated == FALSE) {
			echo "<br> Error: " . $query . "<br>" . $conn->error . "<br>";
		}
			
		mysqli_close($conn);	
	}
	
	function getGamingUsersNumber() {
		$conn = connect_db();
		if ($conn->connect_error) {
			die ("Connection failed : " . $conn->connect_error);
		}
				
		$query = "SELECT count(*) FROM users ".
				"WHERE user_start_game_time IS NOT NULL AND user_end_game_time IS NULL AND TIMESTAMPDIFF(SECOND, user_start_game_time, now()) <= 300";
	
		$resultSet = mysqli_query($conn, $query);
		
		if ($resultSet == FALSE) {
			echo "<br> Error: " . $query . "<br>" . $conn->error . "<br>";
		}
				
		$row = mysqli_fetch_row($resultSet);
		mysqli_close($conn);	
		
		return $row[0];
	}
	
?>