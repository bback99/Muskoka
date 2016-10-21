<?php
    require "db_lib.php";
    $conn = connect_db();
	if($conn->connect_error) {
		die("Connection failed : " .$conn->connect_error);
	}

    $searching_word = $_GET['searching_word'];
    $searching_type = $_GET['searching_type'];

    $extra_query = "USER_ID = " .$searching_word;
    if ($searching_type == 'USER_FNAME' || $searching_type == 'USER_LNAME' || $searching_type == 'USER_EMAIL') {
        $extra_query = "$searching_type LIKE '%$searching_word%'";
    }
    
    $isResult = false;
    $result = excute_select_query_for_multi($conn, get_query_search_by_searching_word($extra_query));
    //echo "<br> query : ".excute_select_query_for_multi($extra_query);

    $cnt = 0;
    $array_answer = array(array());
    while($row = mysqli_fetch_array($result))
    {
        $isResult = true;
        $user_id = $row['UID'];
        $user_fname = $row['USER_FNAME'];
        $user_lname = $row['USER_LNAME'];
        $array_answer[$cnt++] = array("uid" => $user_id, "fname" => $user_fname, "lname" => $user_lname);
    }

    if ($isResult) {
        echo json_encode($array_answer);
    }
    mysqli_close($conn);
?>