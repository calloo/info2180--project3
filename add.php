<?php
/**
 * Created by IntelliJ IDEA.
 * User: calloo
 * Date: 11/22/17
 * Time: 2:35 AM
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
    include "Account.php";
    try{
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        if (empty($firstname) || empty($lastname)) {
            echo "*name field required";
            exit(0);
        }
        if (empty($username)) {
            echo "*username field required";
            exit(0);
        }
        if (!preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/\d/", $password) || strlen($password) < 8) {
            echo "*invalid password";
            exit(0);
        }
        $account = new Account($firstname, $lastname, $username, $password);
        $result = $account->register();
        $account->close();
        echo $result == true?"success":"*username already exist";
    }catch (Exception $e){
        //error
        echo "*error in connecting to database";
    }
}
elseif ($_SESSION['name'] == 'admin'){
    echo file_get_contents("templates/signup.html");
}