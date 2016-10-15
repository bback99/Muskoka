<?php require("question_lib.php") ?>
<?php	
	if (isset($_SESSION["current_qnum"])) {
		$question_num = $_SESSION["current_qnum"];
		if ($question_num > $TOTAL_QUESTION_NUM) {
			header("Location: question_process.php");
		}
	}
	else {
		$question_num = 1;
		$_SESSION["current_qnum"] = 1;
	}

	if (isset($_SESSION["used_qid_list"])) {
		$used_qid_list = $_SESSION["used_qid_list"];
	}
	else {
		$used_qid_list = array();
	}

	// get a question and a hint
	list ($question_id, $question, $hint) = getQuestion($used_qid_list);
	// decide which positions will be blanks.
	$empty_positions = getRandomEmptyPositions($question, $EMPTY_SLOT_NUM);
	// get some characters for an user to choose
	$choices = getChoiceChars($question, $CHOICE_CHAR_NUM, $empty_positions);
	
	// save session
	$cnt_used_list = count($used_qid_list); 
	$used_qid_list[$cnt_used_list] = $question_id;
	
	// to avoid choosing the same question which was already used before.
	$_SESSION["used_qid_list"] = $used_qid_list;
?>

<!DOCTYPE HTML>
<html>
<head>
	<link rel="stylesheet" href="css/question.css"/>
	<script type="text/javascript" src="js/question.js"></script>
</head>
<body>
	<header>
		Question #<?=$question_num?>
		<div id="timer_area">
			<span>00:</span><span id="timer"><?=$TIME_LIMIT?></span><span> sec</span>
		</div>
	</header>

	<input type="hidden" id="question_id" value="<?=$question_id?>">
	
	<section>
		<div id="hint_img_area">
			<img id="hint_img" onclick="showHint()" src="img/hint.jpg" width="100" height="100">
		</div>
			
		<div id="hint_area">
		<fieldset>
			<legend id="hint_title">
				Hint
			</legend>
			<p id="hint"><?=$hint?></p>
		</fieldset>
		</div>
		
		<br><br>
		
		<table id="table_choice">
			<tr>
		<?php
			for ($i = 0; $i < count($choices); $i++) {
		?>
				<td class="choice" ondrop="drop(event)" ondragover="allowDrop(event)">
					<img id="<?=$choices[$i]?>" src="img/<?=$choices[$i]?>.gif" draggable="true" ondragstart="drag(event)" width="50" height="50">
			
				</td>
		<?php	
			}
		?>
			</tr>
		</table>
		
		<br><br><br>
		
		<table id="table_answer">
			<tr id="answer_row">
	<?php
		for ($i = 0; $i < strlen($question); $i++) {
			if (in_array($i, $empty_positions)) {
	?>				
				<td class="question_slot" ondrop="drop(event)" ondragover="allowDrop(event)" style="border: 2px solid red;padding-top: 10px;">
					<img id="drag<?=$i?>" ondragstart="drag(event)" />
				</td>
	<?php
			}
			else {
	?>		
				<td class="question_slot" id="char_<?=$question[$i]?>"><?=$question[$i]?></td>
	<?php
			}
		}
	?>
			</tr>
		</table>
		
	    <br><br>
	    <button class="button" id="next_button" onclick="nextButtonClicked()" disabled>
	    	Next
	    </button>
	
	</section>
	
    <footer>
		<p>&copy; Copyright 2016 MUSKOKA.</p>
    </footer>
</body>
</html>	