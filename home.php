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

        if (!empty($_POST) && $_POST['logout']){

            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            $_SESSION = array();
            session_destroy();
        }else{
            $mailbox = new MailBox();
            echo $mailbox->getMailBox($_SESSION['name'], $_SESSION['id']);
            print_r($_POST);
        }
    }

?>