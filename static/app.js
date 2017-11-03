
$(document).ready(function () {

    setTimeout(function () {
        $("#page-view").load("mail.php", function () {
            $(".mail-info").mouseenter(function () {
                this.style.background = 'lightgray';

            });
            $(".mail-info").mouseleave(function () {
                this.style.background = 'none';

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
                $("#mail-composer").style.display = 'block';

            });

            $("#close").mouseenter(function () {
                this.src = '../images/close2.png';
            });

            $("#close").mouseleave(function () {
                this.src = '../images/close.png';
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

        });

        $(".homepage").hide();
    }, 2000);

});