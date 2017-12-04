<?php
/**
 * Created by IntelliJ IDEA.
 * User: calloo
 * Date: 11/2/17
 * Time: 9:44 PM
 */

    //Designs the user Mailbox
    class MailBox{
        private $username, $password, $db, $host;

        public function __construct(){
            $this->username = "root";
            $this->host = "127.0.0.1";
            $this->password = "";
            $this->db = mysqli_connect($this->host, $this->username, $this->password, "schema");
        }

        public function getMailBox($username, $id){

            if ($username == 'admin'){
                $add_user = "<img src=\"../images/add_user_icon.png\" id=\"settings\">";
                return str_replace("{{account_user}}", $username, str_replace("{{add_user}}", $add_user,
                    str_replace("{{Mail}}", $this->getMails($username), str_replace("{{username}}", $username,
                        file_get_contents("templates/dashboard.html")))));
            }else{
                return str_replace("{{account_user}}", $username, str_replace("{{add_user}}", "",
                    str_replace("{{Mail}}", $this->getMails($username), str_replace("{{username}}", $username,
                        file_get_contents("templates/dashboard.html")))));
            }
        }

        private function getMails($username){
            $count = 0;
            $usr = "%". $username ."%";
            $stmt = mysqli_prepare($this->db, "SELECT sender_id, subject, date_sent, id FROM Messages WHERE recipient_ids LIKE ?");
            mysqli_stmt_bind_param($stmt, "s", $usr);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            $mail_data = "";

            if ($results->num_rows == 0){
                return "<div> You currently have no mails</div>";
            }

            foreach ($results->fetch_all() as $result){

                if ($count > 30){
                    break;
                }
                $stmt2 = mysqli_prepare($this->db, "SELECT id FROM Messages_read WHERE reader_id LIKE ? ".
                    " AND message_id = ?");
                mysqli_stmt_bind_param($stmt2, "si", $usr, $result[3]);
                mysqli_stmt_execute($stmt2);
                $read = mysqli_stmt_get_result($stmt2);

                if ($read->num_rows != 0){
                    $mail_data .= "<div class=\"mail-info\">
            <p class=\"sender\">$result[0]</p>
            <p class=\"date\">$result[2]</p>
            <p class=\"title\">$result[1]</p>
            <span style='display: none' class='msg'>$result[3]</span>
        </div>";
                }else{
                    $mail_data .= "<div class=\"mail-info read-mail\">
            <p class=\"sender\">$result[0]</p>
            <p class=\"date\">$result[2]</p>
            <p class=\"title\">$result[1]</p>
            <span style='display: none' class='msg'>$result[3]</span>
        </div>";
                }
                $count++;
            }

            return $mail_data;

        }

        public function getMessage($message_id, $username){
            $stmt = mysqli_prepare($this->db, "SELECT sender_id, subject, body FROM Messages WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $message_id);
            mysqli_stmt_execute($stmt);
            $usr = "%". $username ."%";
            $results = mysqli_stmt_get_result($stmt);

            if ($results->num_rows > 0){
                $result = $results->fetch_row();

                $stmt2 = mysqli_prepare($this->db, "SELECT id FROM Messages_read WHERE reader_id LIKE ? ".
                    " AND message_id = ?");
                mysqli_stmt_bind_param($stmt2, "si", $usr, $message_id);
                mysqli_stmt_execute($stmt2);
                $read = mysqli_stmt_get_result($stmt2);

                if ($read->num_rows == 0) {
                    $stmt3 = mysqli_prepare($this->db, "INSERT INTO Messages_read (message_id, reader_id) " .
                        " VALUES (?, ?)");
                    mysqli_stmt_bind_param($stmt3, "is", $message_id, $usr);
                    mysqli_stmt_execute($stmt3);
                }
                $message = array('subject'=> $result[1], 'message'=> $result[2], 'sender'=> $result[0]);

                return json_encode($message);

            }
        }

        public function sendMail($recipient, $sender, $subject, $body){

            $users = explode(",", $recipient);

            foreach ($users as $user){
                $user  = trim($user);
                $stmt = mysqli_prepare($this->db, "SELECT id FROM Users WHERE username = ?");
                mysqli_stmt_bind_param($stmt, "s", $user);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($result->num_rows == 0){
                    return false;
                }
            }

            $stmt = mysqli_prepare($this->db, "INSERT INTO Messages (recipient_ids, sender_id, subject, body)".
                " VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssss", $recipient, $sender, $subject, $body);
            mysqli_stmt_execute($stmt);

            return $stmt->affected_rows > 0;
        }
    }

?>