$(document).ready(function () {
    let read_mail = null;
    $(".mail-info").mouseenter(function () {
        this.style.background = 'lightgray';

    });
    $(".mail-info").mouseleave(function () {
        this.style.background = 'none';

    });
    $(".mail-info").click(function () {
        read_mail = this;

        $.get("../mail.php?message=" + $(this).find(".msg").text(), function (data) {

            if (data != 'error'){

                read_mail.classList.remove("read-mail");
                data = JSON.parse(data);
                $("#sender").val(data['sender']).attr("readonly", true);

                $("#receiver").val($("#navbar h4").text()).attr("readonly", true);
                $("#subject-input").val(data['subject']).attr("readonly", true);
                $("textarea").text(data['message']).attr("readonly", true);
                $("#submit-btn").hide();
                $("#send").hide();
                $("#send-mail span").hide();

                $("#mails").hide();
                $("#mail-banner").hide();
                $("#send-mail").show();
                $("#mail-composer").show();

            }else{
                $("#notification").text("Loading message failed");
            }
        });

    });

    $("#compose").mouseenter(function () {
        this.src = '../images/compose2.png';
    });

    $("#compose").mouseleave(function () {
        this.src = '../images/compose.png';
    });

    $("#compose").click(function () {
        $("#mails").hide();
        $("#mail-banner").hide();
        $("#send-mail").show();
        $("#mail-composer").show();

        $("#receiver").attr("readonly", false);
        $("#subject-input").attr("readonly", false);
        $("textarea").attr("readonly", false);

    });

    $("#close").mouseenter(function () {
        this.src = '../images/close2.png';
    });

    $("#close").mouseleave(function () {
        this.src = '../images/close.png';
    });

    $("#close").click(function () {
        if ($("#send").is(":visible")){
            $("#message")[0].reset();
            $("#mails").show();
            $("#mail-banner").show();
            $("#send-mail").hide();
            $("#mail-composer").hide();
        }else{
            $("#submit-btn").show();
            $("#send").show();
            $("#send-mail span").show();

            $("#mails").show();
            $("#mail-banner").show();
            $("#send-mail").hide();
            $("#mail-composer").hide();
        }
        document.getElementById("message").reset();
        $("#message textarea").text("");

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

    $("#logout").click(function () {
        $("#content-area").hide();
        $(".homepage").show();

        setTimeout(function () {
            "use strict";
            $.get("../logout.php", function (data) {

                let newDoc = document.open("text/html", "replace");
                newDoc.write(data);
                newDoc.close();
                window.history.pushState(null, "index", window.location.protocol + "//" + window.location.host + "/index.php");
            });
        }, 2000);
    });
    $("#settings").click(function(){
        "use strict";
        $("#content-area").hide();
        $(".homepage").show();

        setTimeout(function () {
            $.get("../add.php", function (data) {
                let newDoc = document.open("text/html", "replace");
                newDoc.write(data);
                newDoc.close();
                window.history.pushState(null, "add", window.location.protocol + "//" + window.location.host + "/add.php");
            });
        }, 2000);

    });

    $("#message").submit(function (event) {
        event.preventDefault();

        $.post("../mail.php", $("#message").serialize(), function (data) {
            if (data == 'success'){
                $("#notification").text("Email successfully sent");
            }else{
                $("#notification").text("Email submission failed");
            }
            $("#close").trigger("click");
        })
    });

});