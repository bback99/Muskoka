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
    $result = excute_select_query($conn, get_query_search_for_users_score_name($extra_query));
    //echo "<br> query : ".get_query_search_for_users_score_name($extra_query);
    
    echo "<div id='accordion'>";
    while($row = mysqli_fetch_array($result))
    {
        $isResult = true;
        $user_id = $row['UID'];

        echo "<h3>" .$row['USER_FNAME']. " " .$row['USER_LNAME']. "</h3>";
        echo "<div>";

        // query for user name and score
        echo "<table style='width:100%'>";
        echo "<caption> Score </caption>";
        echo "<tr><th> NAME </th><th> BEST SCORE </th><th> WORST SCORE </th></tr>";
        echo "<tr><td>" .$row['USER_FNAME']. " " .$row['USER_LNAME']. "</td><td>" .$row['BEST_SCORE']. "</td><td>" .$row['WORST_SCORE']. "</td></tr>";
        echo "</table>";

        // // query for game history
        $result_history = excute_select_query($conn, get_query_game_history($user_id));
        echo "<br><br>";
        echo "<table style='width:100%'>";
        echo "<caption> History </caption>";
        echo "<tr class='GameHistoryTR'><th> INDEX </th><th> SCORE </th><th> STAGE_LEVEL </th><th> PLAY_DATE </th></tr>";

        $cnt = 1;
        while($row_history = mysqli_fetch_array($result_history))
        {
            echo "	<tr class='GameHistoryTR'>
                    <td>" .$cnt++. "</td>
                    <td>" .$row_history['score']. "</td>
                    <td>" .$row_history['stage_level']. "</td>
                    <td>" .$row_history['play_date']. "</td></tr>";
        }
        echo "</table>";
        echo "</div><br>";
    }
    echo "</div>";

    if (!$isResult) {
        echo "<script>window.alert('Searching failed!!!');</script>";
    }

    mysqli_close($conn);
?>
