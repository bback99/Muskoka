<?php
    require "db_lib.php";
    $conn = connect_db();
	if($conn->connect_error) {
		die("Connection failed : " .$conn->connect_error);
	}

    $user_id = $_GET['user_id'];
    $row = excute_select_query_for_one($conn, get_query_game_information($user_id));
    //echo "<br> query : ".get_query_game_information($user_id);
    
    $isResult = true;
    // query for user name and score
    echo "<table style='width:100%'>";
    echo "<caption> SCORE </caption>";
    echo "<tr class='tr'><th class='th'> TOTAL SCORE </th><th class='th'> BEST SCORE </th><th class='th'> WORST SCORE </th><th class='th'> AVERAGE SCORE </th></tr>";
    echo "<tr class='tr'><td>" .$row[0]. "</td><td> " .$row[1]. "</td><td>" .$row[2]. "</td><td>" .$row[3]. "</td></tr>";
    echo "</table>";

    // // query for game history
    $result_history = excute_select_query_for_multi($conn, get_query_game_history($user_id));
    echo "<br><br>";
    echo "<table style='width:100%'>";
    echo "<caption> HISTROY </caption>";
    echo "<tr class='GameHistoryTR'><th class='th'> INDEX </th><th class='th'> SCORE </th><th class='th'> STAGE_LEVEL </th><th class='th'> PLAY_DATE </th></tr>";

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
    echo "</div>";

    mysqli_close($conn);
?>
