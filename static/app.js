
$(document).ready(function () {

    //Logs out a user
    function logout(){
        $("body").classList.add("setbackground");
        $(".loginBox").show();
        $(".homepage").hide();
    }

    //Loads a user's Mail Box
    function load_data() {

        //Delay displaying the Mail Box by 2 sec
        setTimeout(function () {

            //loads the mailBox data
            $.get("../home.php", function (data) {
                let newDoc = document.open("text/html", "replace");
                newDoc.write(data);
                newDoc.close();
                window.history.pushState(null, "home", window.location.protocol + "//" + window.location.host + "/home.php");

            });

            $(".homepage").hide();
        }, 2000);
    }

    //handles the user logging in to their account
    $("#login-form").submit(function (event) {
        event.preventDefault();

        //validates the user information
        $.post("../validate.php", $("#login-form").serialize(), function (data) {

            //if user validation has been successful then redirect the user to their dashboard
            if (data === 'success'){
                $(".loginBox").hide();
                $(".homepage").show();
                $("body").removeClass("setbackground");

                //load mail-box
                load_data();
            }else {
                //notify user of error message returned from server
                $("#error-notify").text(data);
            }
        });

    });

});