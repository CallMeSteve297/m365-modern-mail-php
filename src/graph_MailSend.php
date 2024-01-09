<?php
class graph_sendMail
{
    public $token;
    public $sender;
    public $subject;
    public $bodytype = "text";
    public $body;
    public $recipients;
    public $savetosent = true;

    public function construct() {
        # Construct Recipients
        $recipientlist = array();
        if (is_array($this->recipients)) {
            foreach ($this->recipients as $user) {
                $userarray = array(
                    "emailAddress" => array(
                        "address" => $user
                    )
                );
                array_push($recipientlist, $userarray);
            }
        } else {
            $userarray = array(
                "emailAddress" => array(
                    "address" => $this->recipients
                )
            );
            array_push($recipientlist, $userarray);
        }

        # Construct Message Payload
        $msg = array(
            "message" => array(
                "subject" => $this->subject,
                "body" => array(
                    "contentType" => $this->bodytype,
                    "content" => $this->body
                ),
                "toRecipients" => $recipientlist
            ),
            "saveToSentItems" => $this->savetosent
        );

        $msgjson = json_encode($msg);
        return $msgjson;
    }

    public function send() {
        $msgjson = $this->construct();
        $uri = "https://graph.microsoft.com/v1.0/users/".$this->sender."/sendMail";
        $headers = [
            'Authorization: Bearer '.$this->token,
            'Content-Type: application/json'
        ];
        $msgcurl = curl_init($uri);
        curl_setopt($msgcurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($msgcurl, CURLOPT_POST, true);
        curl_setopt($msgcurl, CURLOPT_POSTFIELDS, $msgjson);
        curl_setopt($msgcurl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($msgcurl);
        if (curl_errno($msgcurl)) {
            return 'Error: '.curl_error($msgcurl);
        } else {
            return $response;
        }
        curl_close($tokencurl);
    }
}
?>