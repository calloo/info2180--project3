<?php
/**
 * Created by IntelliJ IDEA.
 * User: calloo
 * Date: 11/2/17
 * Time: 9:08 PM
 */
    session_start();

    require_once "MailBox.php";

    if (isset($_SESSION['id']) && isset($_SESSION['name'])){
        $mailbox = new MailBox();
        echo $mailbox->getMailBox($_SESSION['name'], $_SESSION['id']);
    }

?>