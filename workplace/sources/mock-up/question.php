<?php require("question_lib.php") ?>
<?php
	
	$question_num = 1;
	
	if (isset($_GET["question_num"])) {
		$question_num = $_GET["question_num"];
	}
	
	list ($question_id, $question) = getQuestion($used_qid_list);
	$empty_positions = getRandomEmptyPositions($question, 2);
	$choices = getChoiceChars($question, 7, $empty_positions);
	
	// session save
	$cnt_used_list = count($used_qid_list);
	$used_qid_list[$cnt_used_list] = $question_id;
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
			<span>00:</span><span id="timer">30</span><span> sec</span>
		</div>
	</header>
	
	<section>
		<input type="hidden" id="question_num" value="<?=$question_num?>">
		<input type="hidden" id="question_id" value="<?=$question_id?>">
		<div id="hint_img_area">
			<img id="hint_img" onclick="showHint()" src="img/hint.jpg" width="100" height="100">
		</div>
			
		<div id="hint_area">
		<fieldset>
			<legend id="hint_title">
				Hint
			</legend>
			<p id="question">A device used in television and moviemaking to project a speaker's script out of sight of the audience.</p>
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
				<td class="answer_td" ondrop="drop(event)" ondragover="allowDrop(event)" style="border: 2px solid red;padding-top: 10px;"></td>
	<?php
			}
			else {
	?>		
				<td class="answer_td" id="char_<?=$question[$i]?>"><?=$question[$i]?></td>
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