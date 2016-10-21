<?php
    function getAllWords($conn) 
    {
        //query to manage quiz
        $result = excute_select_query_for_multi($conn, get_query_words());
        // form for update and delete
        echo "<table style='width:100%'>";
        echo "<caption> Modify and Remove for Quiz Words</caption>";
        echo "<tr><th style='witdh:5%'>Index</th><th style='witdh:10%'>WORD_ID</th><th style='width:20%'>Level</th><th>WORD</th><th style='width:30%'></th></tr>";

        $cnt = 0;
        while($row = mysqli_fetch_row($result)) 
        {
            echo "	<tr class='GameHistoryTR'>
                    <td>" .++$cnt. "</td>
                    <td>" .$row[0]. "</td>
                    <td><input type='text' id='level_" .$row[0]. "' name='level[" .$row[0]. "]' value='" .$row[1]. "'></input></td>
                    <td><input type='text' id='word_" .$row[0]. "' name='word[" .$row[0]. "]' value='" .$row[2]. "'></input></td>";
            echo "<td style='width:30%' id='td_btn'><button class='btn2' type='button' name='btn_change' onclick=modifyWords(".$row[0].")>MODIFY</button>";
            echo "<button class='btn3' type='button' name='btn_remove' onclick=removeWords(".$row[0].")>REMOVE</button></td></tr>";
        }
        echo "</table>";
    }
?>