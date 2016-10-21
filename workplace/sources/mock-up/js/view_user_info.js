$( function() {
    $( "#tabs" ).tabs();
} );

$(document).ready(function() {
    $('#btn_modify').click(function() {
        var user_id = document.getElementById("user_id");
        var fname = document.getElementById("fname");
        var lname = document.getElementById("lname");
        var password = document.getElementById("password");
        var email = document.getElementById("email");
        var phone_number = document.getElementById("phone_number");
        var address = document.getElementById("address");
        var dataString = "user_id="+user_id.value+"&fname="+fname.value+"&lname="+lname.value+"&password="+password.value+"&email="+email.value+"&phone_number="+phone_number.value+"&address="+address.value;
        $.ajax({
            url: 'processingUpdateUserInfo.php',
            data: dataString,
            type: 'GET',
            error: function() { $('#result').html('<p>An error has occurred</p>'); },
            success: function(result) {
                $('#result').html(result);
            },
        });
    });
});

$(document).ready(function() {
    $("#tabs").on("click", function() {
        $('#result').html("");
    });
});		