<?php
/**
 * Created by IntelliJ IDEA.
 * User: calloo
 * Date: 11/2/17
 * Time: 9:08 PM
 */
    session_start();

    require_once "mail.php";

    if (isset($_SESSION['id']) && isset($_SESSION['name'])){

        if (!empty($_POST) && $_POST['logout'] == 'true'){
            session_unset();
            session_destroy();
        }else{
            $mailbox = new MailBox();
            echo $mailbox->getMailBox($_SESSION['name']);
        }
    }

?>