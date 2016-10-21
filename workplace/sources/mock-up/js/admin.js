$( function() {
    $( "#tabs" ).tabs();
} );

$( function () {
    $( "#accordion" ).accordion({
        collapsible: true,
        active : false,
        heightStyle: "content",
        activate: function (e, ui) {
            $url = $(ui.newHeader[0]).children('a').attr('href');
            $.get($url, function (data) {
                $(ui.newHeader[0]).next().html(data);
            });
        }
    });
});

function resultInSearch() {
    var s_type = document.getElementById("select_search_option");
    var s_word = document.getElementById("searching_word");

    // check if User_ID is selected, it must be numeric
    if (s_type.value == "USER_ID") {
        if (isNaN(s_word.value)) {
            document.getElementById("resultInSearch").innerHTML = "<p class='result_msg'>Must input numbers.</p>";
            $("#accordion").empty();                // Clears the contents
            return;
        }
    }

    if (s_word.value == "") {
        document.getElementById("resultInSearch").innerHTML = "";
        $("#accordion").empty();                // Clears the contents
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) 
            {
                if (this.responseText.length <= 0)
                {
                    document.getElementById("resultInSearch").innerHTML = "<p class='result_msg'>Couldn't find.</p>";
                    $("#accordion").empty();                // Clears the contents
                }
                else {
                    document.getElementById("resultInSearch").innerHTML = "";
                    $("#accordion").empty();                // Clears the contents
                    var obj = JSON.parse(this.responseText);
                        
                    for(var i=0; i<obj.length; i++) {
                        var newDiv = "<h3><a href='processingGetUsersInfo.php?user_id=" + obj[i].uid + "'></a>" + obj[i].fname + " " + obj[i].lname + "</h3><div style=>Loading... Please wait...</div>";
                        $('#accordion').append(newDiv);
                        $('#accordion').accordion("refresh");
                    }
                }
            }
        };
        xmlhttp.open("GET", "processingSearchUsers.php?searching_word=" + s_word.value + "&searching_type=" + s_type.value, true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlhttp.send();
    }
}

// ajax in jQuery style  
$(document).ready(function() {
    $('.btn2').click(function() {
        var s_level = document.getElementById("txt_add_level");
        var s_word = document.getElementById("txt_add_word");
        if (s_level.value == "" || s_word.value == "") {
            $('#resultAddWords').html("<p class='result_msg'>Need Values</p>");
            return;
        }
        var dataString = "add_level="+s_level.value+"&add_word="+s_word.value;
        $.ajax({
            url: 'processingAddWords.php',
            data: dataString,
            type: 'GET',
            error: function() { $('#resultAddWords').html('<p>An error has occurred</p>'); },
            success: function(result) {
                $('#resultAddWords').html(result);
            },
        });
    });
});

// ajax in plain style
function modifyWords(index) {
    var s_level = document.getElementById("level_" + index);
    var s_word = document.getElementById("word_" + index);
    if (s_word.value == "" || s_level.value == "") {
        document.getElementById("resultAddWords").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("resultAddWords").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "processingUpdateWords.php?index=" + index + "&modify_level=" + s_level.value + "&modify_word=" + s_word.value, true);
        xmlhttp.send();
    }
}

//////////////////////////////////////////////////////////////////////
// ajax in jQuery style - using with name function
$(document).ready(function() {
    $('.btn3').click(function() {
        removeWords(index);
    });
});

// gave function name to call button that has specific ID
function removeWords(index) {
    alert(index);
    if (index < 0) {
        $('#resultAddWords').html("");
        return;
    }
    var dataString = "index="+index;
    $.ajax({
        url: 'processingRemoveWords.php',
        data: dataString,
        type: 'GET',
        error: function() { $('#resultAddWords').html('<p>An error has occurred</p>'); },
        success: function(result) {
            $('#resultAddWords').html(result);
        },
    });
}