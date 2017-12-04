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

            $handle = mysqli_connect("127.0.0.1", "root", "", "schema");
            $user = htmlspecialchars($_POST['user']);
            $pw = hash("sha256", htmlspecialchars($_POST['password']));

            $stmt = mysqli_prepare($handle, "SELECT id FROM Users WHERE username = ? AND password = ?");
            mysqli_stmt_bind_param($stmt, "ss", $user, $pw);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $result);
            $stmt->fetch();

            if ($result !== null){
                $_SESSION['id'] = $result;
                $_SESSION['name'] = $user;

                echo 'success';

            }
            else if (!$handle) {
                echo "cannot connect";

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
                echo "*invalid username or password";

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

            $handle->close();



        }else{
            echo "*field values required";
        }
    }

    login();
?>