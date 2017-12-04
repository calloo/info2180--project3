<?php
/**
 * Created by IntelliJ IDEA.
 * User: calloo
 * Date: 11/25/17
 * Time: 1:53 AM
 */

//starts a user session
session_start();
session_regenerate_id(true);

//checks if this is not a user who is already logged in
if (!isset($_SESSION['id']) && !isset($_SESSION['name'])){

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    $_SESSION = array();
    session_destroy();
}
elseif (!empty($_POST)){
    require_once "MailBox.php";

    $mailbox = new MailBox();
    $sender = htmlspecialchars($_POST['sender']);
    $receiver = htmlspecialchars($_POST['receiver']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $result = $mailbox->sendMail($receiver, $sender, $subject, $message);
    if ($result == true) {
        echo "success";
    }else{
        echo "error";
    }
}elseif (!empty($_GET)){
    require_once "MailBox.php";
    try{
        $mailbox = new MailBox();
        $message = htmlspecialchars($_GET['message']);
        echo $mailbox->getMessage($message, $_SESSION['name']);
    }catch(Exception $e){
        echo "error";
    }
}