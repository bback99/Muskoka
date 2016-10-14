<?php require("question_lib.php") ?>
<?php
	
	$question_num = $_GET["question_num"];
	$question_id = $_GET["question_id"];
	$user_response = $_GET["user_response"];
	$time = $_GET["time"];
	
	$answer = getAnswer($question_id);
	$message = "";
	
	if ($user_response == $answer) {
		$message = "You got the answer!!\\nYou spent " . (30 - $time) . " seconds.";
		$score++;
		$_SESSION["score"] = $score; 
	}
	else 
	{
		$message = "You are wrong!!";
	}
	
	if ($question_num == 5) {
		$message = $message . "\\n\\nGame Over!!\\n\\nTotal Score: " . " " . $score;
		$question_num = 0;
		$session_destroy;
	}
	
	$question_num += 1;
?>

<script>
	window.alert("<?=$message?>");
	document.location.href = "question.php?question_num=<?=$question_num?>";
</script>