<?php
/**
 * Created by IntelliJ IDEA.
 * User: calloo
 * Date: 11/2/17
 * Time: 9:11 PM
 */

    if (!isset($_SESSION['id']) && !isset($_SESSION['name'])){
        echo str_replace("{{dashboard}}", "", file_get_contents("templates/index.html"));

    }
    else{

//        echo str_replace("{{dashboard}}", require_once "home.php", file_get_contents("templates/index2.html"));

        require_once "home.php";
    }
?>