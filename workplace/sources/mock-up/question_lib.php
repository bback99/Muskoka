<?php	
	session_start(); // this will be deleted when DB is used. 
	if (isset($_SESSION["used_qid_list"])) {
		$used_qid_list = $_SESSION["used_qid_list"];
	}
	else {
		$used_qid_list = array();
	}
	
	if (isset($_SESSION["score"])) {
		$score = $_SESSION["score"];
	}
	else {
		$score = 0;
	}
				
	function getAnswer($qid) {
		$question_list = array(0 => "BEAUTIFUL", 1 => "AUTOMATIC", 2 => "STAGNANT",
							3 => "COALITION", 4 => "VICINITY", 5 => "PLAUSIBLE", 
							6 => "CULPRIT", 7 => "ALLEGED", 8 => "OVERHAUL", 9 => "COMMITMENT");		
		return $question_list[$qid];
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
	
	function getQuestion($used_qid_list) {
		$question_list = array(0 => "BEAUTIFUL", 1 => "AUTOMATIC", 2 => "STAGNANT",
							3 => "COALITION", 4 => "VICINITY", 5 => "PLAUSIBLE", 
							6 => "CULPRIT", 7 => "ALLEGED", 8 => "OVERHAUL", 9 => "COMMITMENT");
									
		$undup_list = array();
		$undup_list_cnt = 0;
		
		foreach ($question_list as $key => $value) {
			if (in_array($key, $used_qid_list) == FALSE) {
				$undup_list[$undup_list_cnt++] = $key;
			}
		}
		
		if (count($undup_list) > 0) {
			$rand_idx = rand(0, count($undup_list) - 1);
			$selected_id = $undup_list[$rand_idx];
		}
		else {
			$selected_id = 0;
			session_destroy();			
		}
		
		return array ($selected_id, $question_list[$selected_id]);	
	}
	
	function getHint() {
		
	}
?>