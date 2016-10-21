<?php
    require "db_lib.php";
    require "getAllWords.php";

    $conn = connect_db();
	if($conn->connect_error) {
		die("Connection failed : " .$conn->connect_error);
	}

    $cnt = 0;
    $word_id = $_GET['index'];
    $level = $_GET['modify_level'];
    $word = $_GET['modify_word'];
    $query_param[$cnt++] = $level;
    $query_param[$cnt++] = $word;
    
    $result = excute_query($conn, get_query_update_quiz($word_id, $query_param));
    if ($result) {
        echo "<p class='result_msg'>Updating succeeded.</p>";
    }
    else {
        echo "<p class='result_msg'>Updating failed.</p>";
    }
    getAllWords($conn);

    mysqli_close($conn);
?>