<?php
class graph_GetToken
{
    public $grant_type = "client_credentials";
    public $client_secret;
    public $scope = "https://graph.microsoft.com/.default";
    public $client_id;
    public $tenant_id;

    public function fetch($format = "array") {
        $request = "grant_type=".$this->grant_type."&client_secret=".$this->client_secret."&scope=".$this->scope."&client_id=".$this->client_id;
        $uri = "https://login.microsoftonline.com/".$this->tenant_id."/oauth2/v2.0/token";

        $tokencurl = curl_init($uri);
        curl_setopt($tokencurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($tokencurl, CURLOPT_POST, true);
        curl_setopt($tokencurl, CURLOPT_POSTFIELDS, $request);

        $response['json'] = curl_exec($tokencurl);
        $response['array'] = json_decode($response['json'], true);

        if (curl_errno($tokencurl)) {
            return 'Error: '.curl_error($tokencurl);
        } else {
            if ($format == "json") {
                return $response['json'];
            } elseif ($format == "token") {
                return $response['array']['access_token'];
            } else {
                return $response['array'];
            }
        }
        curl_close($tokencurl);
    }
}
?>