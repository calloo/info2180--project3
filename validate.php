<?php
/**
 * Created by IntelliJ IDEA.
 * User: calloo
 * Date: 11/3/17
 * Time: 12:51 PM
 */
    session_start();

/**
 *
 */
function login(){
        if (!empty($_POST) && !empty($_POST['user']) && !empty($_POST['password'])){

            // Create connection
            $conn = mysqli_connect("127.0.0.1", "root", "", "schema");
            $user = $_POST['user'];
            $pw = hash("sha256", $_POST['password']);

            $result = mysqli_query($conn, "SELECT id FROM Users WHERE username = '$user' AND password = '$pw'");
            $user_info = mysqli_fetch_row($result);

            if (count($user_info) == 1){
                $_SESSION['id'] = $user_info[0];
                $_SESSION['name'] = $user;

                echo 'success';

            }
            else if (!$conn) {
                echo "cannot connect";
                session_unset();
                session_destroy();
            }
            else{
                echo "*invalid username or password";
                session_unset();
                session_destroy();
            }

            $conn->close();



        }else{
            echo "*field values required";
        }
    }

    login();
?>