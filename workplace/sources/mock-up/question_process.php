<?php require("include.php") ?>
<?php	
	session_start();

	if (isset($_SESSION["userid"])) {
		$userid = $_SESSION["userid"];
		$stage_level = $_SESSION["stage_level"];
	}
	else {
		$userid = -1;
	}
	
	if (isset($_SESSION["current_qnum"])) {
		$question_num = $_SESSION["current_qnum"];
	}
	else {
		$question_num = 0;
	}
	
	if (isset($_SESSION["score"])) {
		$score = $_SESSION["score"];
	}
	else {
		$score = 0;
	}
	
	if (isset($_SESSION["total_spending_time"])) {
		$total_spending_time = $_SESSION["total_spending_time"];
	}
	else {
		$total_spending_time = 0;
	}
	
	$messageType = "alert";
	$message = "";
	
	// The case that an user couldn't solve a question in time
	if (isset($_GET["timeout"])) {
		$message = "The time is up!!";
		$_SESSION["total_spending_time"] = $total_spending_time + $TIME_LIMIT;
		
		if ($question_num < $TOTAL_QUESTION_NUM) {
			$_SESSION["current_qnum"] = $question_num + 1;
		}
	}
	// check out whether an user's answer is right
	else if (isset($_GET["question_id"]) && isset($_GET["user_response"]) && isset($_GET["time"])){
		$question_id = $_GET["question_id"];
		$user_response = $_GET["user_response"];
		$current_spending_time = $TIME_LIMIT - $_GET["time"];
		$answer = getAnswer($question_id);
	
		if ($user_response == $answer) {
			$message = "You got the right answer!!\\nYou spent " . $current_spending_time . " seconds.";
			$score++;
			$_SESSION["score"] = $score; 
		}
		else {
			$message = "Your answer is wrong!!";
		}
		
		$total_spending_time += $current_spending_time;
		$_SESSION["total_spending_time"] = $total_spending_time;
		$_SESSION["current_qnum"] = $question_num + 1;
	}
	
	// when the user solved the last question.
	if ($userid != -1 && $question_num == $TOTAL_QUESTION_NUM) {
		$total_limit_time = $TOTAL_QUESTION_NUM * $TIME_LIMIT;
		$total_remaining_time = $total_limit_time - $total_spending_time;
		$total_score = number_format($score * 10 * $total_remaining_time / $total_limit_time, 1, '.', '');
				
		$message = $message . "\\n\\nGame Over!!\\n\\n".
				"Correct Answers: $score\\n".
				"Total Spending Time : $total_spending_time Sec\\n".
				"Total Score: $score * 10 * (Your remaining time / Total time)".
				" = $total_score\\n\\n".
				"Continue?";
				
		saveScore($total_score, $stage_level, $userid);
		session_destroy();
		
		$messageType = "confirm";
	}
	
	// invalid access
	if ($message == "") {
		$message = "Invalid access!!";
		$_SESSION["current_qnum"] = 1;
	}
?>

<script>
<?php
	if ($messageType == "alert") {
?>
		window.alert("<?=$message?>");
		document.location.href = "question.php";
<?php
	}
	else {
?>	
		var result = confirm("<?=$message?>");
		if (result == true) {
			document.location.href = "question.php";
		}
<?php
	}
?>
</script>