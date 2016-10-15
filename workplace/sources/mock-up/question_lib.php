<?php	
	session_start();
	
	// this is global variables to set the game environment.
	// -----------------------------------------------------
	$CHOICE_CHAR_NUM = 7;
	$EMPTY_SLOT_NUM = 2;
	$TOTAL_QUESTION_NUM = 5;
	$TIME_LIMIT = 30;
	// -----------------------------------------------------

	$question_list = array(0 => "BEAUTIFUL", 1 => "AUTOMATIC", 2 => "STAGNANT",
						3 => "COALITION", 4 => "VICINITY", 5 => "PLAUSIBLE", 
						6 => "CULPRIT", 7 => "ALLEGED", 8 => "OVERHAUL", 9 => "COMMITMENT");

	$hint_list = array(0 => "delighting the senses or exciting intellectual or emotional admiration.",
					1 => "working by itself with little or no direct human control.",
					2 => "(of a body of water or the atmosphere of a confined space) " .  
						"having no current or flow and often having an unpleasant smell as a consequence.",
					3 => "an alliance for combined action, especially a temporary " .
						"alliance of political parties forming a government or of states.",
					4 => "the area near or surrounding a particular place.",
					5 => "(of an argument or statement) seeming reasonable or probable.",
					6 => "a person who is responsible for a crime or other misdeed.",
					7 => "(of an incident or a person) said, without proof, to have " .
						"taken place or to have a specified illegal or undesirable quality.",
					8 => "take apart (a piece of machinery or equipment) in order to examine " .
						"it and repair it if necessary.",
					9 => "the state or quality of being dedicated to a cause, activity, etc."
				);
																
	function getAnswer($qid) {
		global $question_list;	
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
		global $question_list;
		global $hint_list;
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
		
		return array ($selected_id, $question_list[$selected_id], $hint_list[$selected_id]);	
	}
?>