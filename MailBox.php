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

            return str_replace("{{Mail}}", $this->getMails($id),
                str_replace("{{username}}", $username, file_get_contents("templates/base.html")));
        }

        private function getMails($id){
            $results = $this->db->query("SELECT sender_id, subject, date_sent, id FROM Messages WHERE  ".
                "recipient_id = $id");

            $mail_data = "";

            if ($results->num_rows == 0){
                return "<div class='mail-info'> You currently have no mails</div>";
            }

            foreach ($results as $result){
                var_dump($result);
                $user = $this->db->query("SELECT name FROM Users WHERE".
                    "id = $result[0]");

                $query_read = $this->db->query("SELECT message_id FROM Message_read where
 reader_id = '$result[0]'");

                $mail_data .= "<div class=\"mail-info\">
            <p class=\"sender\">$user[0]</p>
            <p class=\"date\">$result[2]</p>
            <p class=\"title\">$result[1]</p>
            <span style='display: none' class='msg'>$result[3]</span>
        </div><br/>";
            }

            return $mail_data;

        }

        private function getMessage($message_id){
            $results = $this->db->query("SELECT * FROM Messages WHERE id = $message_id");

            if ($results->num_rows > 0){
                $result = $results->fetch_row();
                $message = array('subject'=> $result['subject'], 'body'=> $result['body'], 'date'=> $result['date_sent']);

                echo json_encode($message);

            }
        }

        private function sendMail($recepient, $sender, $subject, $body){
            $stmt = $this->db->query("");
        }
    }

?>