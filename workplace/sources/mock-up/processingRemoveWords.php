<?php
    require "db_lib.php";
    require "getAllWords.php";

    $conn = connect_db();
	if($conn->connect_error) {
		die("Connection failed : " .$conn->connect_error);
	}

    $cnt = 0;
    $word_id = $_GET['index'];
    
    $result = excute_query($conn, get_query_remove_quiz($word_id));
    if ($result) {
        echo "<p class='result_msg'>Removing was succeeded.</p>";
    }
    else {
        echo "<p class='result_msg'>Removing was failed.</p>";
    }
    getAllWords($conn);

    mysqli_close($conn);
?>