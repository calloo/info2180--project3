<?php
/**
 * Created by IntelliJ IDEA.
 * User: calloo
 * Date: 11/15/17
 * Time: 8:12 PM
 */

class Account
{
    private $firstname, $lastname, $username, $password, $db;

    function __construct($firstname, $lastname, $username, $password)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->username = $username;
        $this->password = hash("sha256", $password);
        $this->db = mysqli_connect("127.0.0.1", "root", "", "schema");
    }

    function register(){
        $result = $this->db->query("INSERT INTO Users (firstname, lastname, username, password)".
            "VALUES ('$this->firstname', '$this->lastname', '$this->username', '$this->password')");

        return $result;
    }

    function close(){
        $this->db->close();
    }
}