
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
            $("#page-view").load("home.php", function () {
                $(".mail-info").mouseenter(function () {
                    this.style.background = 'lightgray';

                });
                $(".mail-info").mouseleave(function () {
                    this.style.background = 'none';

                });

                $("#compose").mouseenter(function () {
                    this.src = 'images/compose2.png';
                });

                $("#compose").mouseleave(function () {
                    this.src = 'images/compose.png';
                });

                $("#compose").click(function () {
                    $("#mails").hide();
                    $("#mail-banner").hide();
                    $("#send-mail").show();
                    $("#mail-composer").show();
                    $("#mail-composer").style.display = 'block';

                });

                $("#close").mouseenter(function () {
                    this.src = 'images/close2.png';
                });

                $("#close").mouseleave(function () {
                    this.src = 'images/close.png';
                });

                $("#close").click(function () {
                    $("#message")[0].reset();
                    $("#mails").show();
                    $("#mail-banner").show();
                    $("#send-mail").hide();
                    $("#mail-composer").hide();
                    $("#mail-composer").style.display = 'none';

                });

                $("#submit-btn").mouseenter(function () {
                    this.style.background = '#337DFF';
                });

                $("#submit-btn").mouseleave(function () {
                    this.style.background = 'lightgrey';
                });

                $("#send").mouseenter(function () {
                    this.style.background = '#337DFF';
                });

                $("#send").mouseleave(function () {
                    this.style.background = 'none';
                });

                $("#send").click(function () {
                    $("#submit-btn").trigger("click");
                });

                $("#home").click(function () {
                    $("#page-view").empty();
                    $(".homepage").show();

                    load_data();
                });

                $("#logout").click(function () {
                    $("#page-view").hide();
                    $(".homepage").show();

                    $.post("home.php", {'logout': true}, function () {
                        logout();
                        $("#page-view").empty();
                    });
                });

            });

            $(".homepage").hide();
        }, 2000);
    }

    //handles the user logging in to their account
    $("#login-form").submit(function (event) {
        event.preventDefault();

        //validates the user information
        $.post("validate.php", $("#login-form").serialize(), function (data) {

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