var $ = function (id) {
    return document.getElementById(id);
};
	
window.onload = function() {
	var intervalId = setInterval(timerFunction, 1000);
};
	
var timerFunction = function timer() {
	var timer_obj = $("timer");
	var timer_area = $("timer_area");
	var current_time = timer_obj.firstChild.nodeValue;
	var char_zero = "";
		
	if (current_time <= 10) {
		char_zero = "0";
	}
	if (current_time == 5) {
		timer_area.style.color = "red";
	}
	if (current_time == 0) {
		clearInterval(intervalId);
	}
	var new_time = char_zero + (parseInt(current_time) - 1);
	timer_obj.firstChild.nodeValue = new_time;	
};
	
function allowDrop(ev) {
	ev.preventDefault();
}

function drag(ev) {
	ev.dataTransfer.setData("text", ev.target.id);
}
	
function drop(ev) {
	ev.preventDefault();
	var data = ev.dataTransfer.getData("text");
	ev.target.appendChild($(data));
	ev.target.id = "char_" + data;
	
	// check whether all slots are filled.
	var answer_td_list = document.getElementsByClassName("answer_td");
	var button_disabled = false;
	
	for (var i = 0; i < answer_td_list.length; i++) {
		if (answer_td_list[i].id == "") {
			button_disabled = true;
			break;
		}
	}
	
	$("next_button").disabled = button_disabled;
}
	
function showHint() {
	var obj1 = $("hint_img_area");
	obj1.style.display = 'none';
		
	var obj2 = $("hint_area");
	obj2.style.display = 'block';
}

function nextButtonClicked() {
	var answer_td_list = document.getElementsByClassName("answer_td");
	var answer = "";
	
	for (var i = 0; i < answer_td_list.length; i++) {
		answer += answer_td_list[i].id.substring(5);
	}
	
	var question_num = $("question_num").value;
	var question_id = $("question_id").value;
	var time = $("timer").firstChild.nodeValue;
	document.location.href = "question_process.php?question_num=" + question_num +
							"&question_id=" + question_id +
							"&user_response=" + answer +
							"&time=" + time;
}