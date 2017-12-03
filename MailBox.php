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
            $results = $this->db->query("SELECT sender_id, subject, date_sent, id FROM Messages WHERE  ".
                "recipient_ids LIKE '%$username%'");

            $mail_data = "";

            if ($results->num_rows == 0){
                return "<div> You currently have no mails</div>";
            }

            foreach ($results->fetch_all() as $result){

                if ($count > 30){
                    break;
                }
                $read = $this->db->query("SELECT id FROM Messages_read WHERE reader_id LIKE '%$username%' ".
                    " AND message_id = $result[3]");

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
            $results = $this->db->query("SELECT sender_id, subject, body FROM Messages WHERE id = $message_id");

            if ($results->num_rows > 0){
                $result = $results->fetch_row();
                $read = $this->db->query("SELECT id FROM Messages_read WHERE reader_id LIKE '%$username%' ".
                    " AND message_id = $message_id");

                if ($read->num_rows == 0) {
                    $this->db->query("INSERT INTO Messages_read (message_id, reader_id) " .
                        " VALUES ($message_id, '$username')");
                }
                $message = array('subject'=> $result[1], 'message'=> $result[2], 'sender'=> $result[0]);

                return json_encode($message);

            }
        }

        public function sendMail($recipient, $sender, $subject, $body){

            $users = explode(",", $recipient);

            foreach ($users as $user){
                $user  = trim($user);

                if (count($this->db->query("SELECT id FROM Users WHERE username = '$user'")->fetch_all()) == 0){
                    return false;
                }
            }

            $stmt = $this->db->query("INSERT INTO Messages (recipient_ids, sender_id, subject, body)".
            " VALUES ('$recipient', '$sender', '$subject', '$body')");

            return $stmt;
        }
    }

?>