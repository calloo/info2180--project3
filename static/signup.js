
$("document").ready(function(){
    "use strict";

    $("#sign").submit(function (event) {
        event.preventDefault();

        $.post("../add.php", $("#sign").serialize(), function (data) {
            if (data == 'success'){
                $("#error-notify").html("Account created successfully. Head <a href='../home.php'>home</a>").css("color", "green");
            }else{
                $("#error-notify").text(data).css("color", "white");
            }
        })
    });
});