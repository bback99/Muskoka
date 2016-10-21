<?php
    require "db_lib.php";
    require "getAllWords.php";

    $conn = connect_db();
    if($conn->connect_error) {
        die("Connection failed : " .$conn->connect_error);
    }

    $cnt = 0;
    $add_level = $_GET['add_level'];
    $add_word = $_GET['add_word'];
    $query_param[$cnt++] = $add_level;
    $query_param[$cnt++] = $add_word;

    $query = get_query_add_quiz($query_param);
    $result = excute_query($conn, $query);
    if ($result) {
        echo "<p class='result_msg'>Inserting was succeeded.</p>";
    }
    else {
        echo "<p class='result_msg'>Inserting was failed.</p>";
    }
    getAllWords($conn);

    mysqli_close($conn);
?>
