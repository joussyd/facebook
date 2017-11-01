<?php

namespace Redscript\Facebook;
use Redscript\Facebook\Util;
use Redscript\Facebook\User;
use Redscript\Facebook\Oauth;

class Factory extends Base
{
     /**
     * Facebook Auth
     *
     *
     * @return Oauth class
     */
	public function auth($client_id, $client_secret, $redirect_uri, $state, $scope)
	{
		return new Oauth($client_id, $client_secret, $redirect_uri, $state, $scope);
	}

     /**
     * Send Curl Request
     *
     *
     * @return json
     */
	public function sendRequest($url, $post)
	{
        // initiate  request
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = json_decode(curl_exec($curl), true);

        // get the request's return code
        $http_code = curl_getinfo($curl,CURLINFO_HTTP_CODE);	

        // check if the return code is OK	
        if($http_code != 200) {
            die('Error : Failed to receieve response from: ' . $url);	
        }

        // close the connection
        curl_close($curl);

        return $response;
	}

}