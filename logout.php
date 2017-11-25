<?php
/**
 * Created by IntelliJ IDEA.
 * User: calloo
 * Date: 11/2/17
 * Time: 9:44 PM
 */

	session_start();
    $_SESSION = array();
	session_destroy();
    echo file_get_contents("templates/index.html");

?>