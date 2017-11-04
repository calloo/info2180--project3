<?php
/**
 * Created by IntelliJ IDEA.
 * User: calloo
 * Date: 11/2/17
 * Time: 9:44 PM
 */

    class MailBox{

        public function __construct(){
        }

        public function getMailBox(String $username):String{
            return str_replace("{{username}}", $username, file_get_contents("templates/base.html"));
        }
    }

?>