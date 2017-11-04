<?php
/**
 * Created by IntelliJ IDEA.
 * User: calloo
 * Date: 11/2/17
 * Time: 9:11 PM
 */

    session_start();
    session_regenerate_id(true);


    if (!isset($_SESSION['id']) && !isset($_SESSION['name'])){
        echo str_replace("{{dashboard}}", "", file_get_contents("templates/index.html"));

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
    else{

//        echo str_replace("{{dashboard}}", require_once "home.php", file_get_contents("templates/index2.html"));

        require_once "home.php";
    }
?>