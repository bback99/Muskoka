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
			$message = "Great!!<br><br>You spent " . $current_spending_time . " seconds.<br><br>";
			$score++;
			$_SESSION["score"] = $score; 
		}
		else {
			$message = "Wrong answer!!<br><br>Please, be carefull.<br><br>";
		}
		
		$total_spending_time += $current_spending_time;
		$_SESSION["total_spending_time"] = $total_spending_time;
		$_SESSION["current_qnum"] = $question_num + 1;
	}
	
	$button = "<a href='#' class='next_btn'>Next</a>";
	
	// when the user solved the last question.
	if ($userid != -1 && $question_num == $TOTAL_QUESTION_NUM) {
		$total_limit_time = $TOTAL_QUESTION_NUM * $TIME_LIMIT;
		$total_remaining_time = $total_limit_time - $total_spending_time;
		$total_score = number_format($score * 10 * $total_remaining_time / $total_limit_time, 1, '.', '');
				
		$message = $message . "Game Over!!<br><br>".
				"Correct Answers: $score<br>".
				"Total Spending Time : $total_spending_time Sec<br>".
				"Total Score: $score * 10 * (Your remaining time / Total time)".
				" = $total_score<br>";
				
		$button = "<a href='#' class='next_btn'>Continue</a>&nbsp;&nbsp<a href='#' class='cbtn'>Close</a><br>";
				
		saveScore($total_score, $stage_level, $userid);
		saveEndGameTime($userid);
		session_destroy();
	}
	
	// invalid access
	if ($message == "") {
		$message = "Invalid access!!";
		$_SESSION["current_qnum"] = 1;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title> pop-up </title> 
		<link rel="stylesheet" href="css/popup.css"/>
 		<script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>  		
		<script type="text/javascript" src="js/popup.js"></script>
		<script>
			$(document).ready(function(){
				layer_open('layer2');
			});
		</script>
	</head>
	<body>
<div class="layer">
	<div class="bg"></div>
	<div id="layer2" class="pop-layer">
		<div class="pop-container">
			<div class="pop-conts">
				<!--content //-->
				<p class="ctxt mb20">
					<?=$message?>
				</p>

				<div class="btn-r">
					<?=$button?>
				</div>
				<!--// content-->
			</div>
		</div>
	</div>
</div>
	</body>
</html>