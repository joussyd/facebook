<?php

namespace Redscript\Facebook;

class Util
{

    /**
     * Send Curl Request
     *
     *
     * @return json
     */
	public function sendRequest($url, $post)
	{
		$curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $json_response = curl_exec($curl);

        curl_close($curl);

        return $json_response;
	}

    /**
     * Generate the Faceboook Login Url
     *
     *
     * @return string
     */
    public function generateLoginURL($url, $client_id, $redirect_uri, $state, $scope)
    {
        $loginUrl = $url
        . "client_id=" . $client_id
        . "&redirect_uri=" . $redirect_uri
        . "&state=" . $state
        . "&response_type=code"
        . "&scope=" . $scope
        . "&include_granted_scopes=true";

        return $loginUrl;
    }
}