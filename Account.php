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
        $stmt = mysqli_prepare($this->db, "INSERT INTO Users (firstname, lastname, username, password)".
            "VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $this->firstname, $this->lastname, $this->username, $this->password);
        mysqli_stmt_execute($stmt);

        return $stmt->affected_rows > 0;
    }

    function close(){
        $this->db->close();
    }
}