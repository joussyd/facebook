<?php

namespace Redscript\Facebook;

class User extends Base
{
	/**
     * Get User's Basic info
     *
     *
     * @return json
     */
    public function _getUserInfo($access_token)
    {
        // Check if access token is set
        if(isset($access_token)){

            // Create the URL for the request 
            $url = self::USER_INFO_URL . $access_token;
            $post = '';

            //return response from the request
            return Factory::sendRequest($url, $post);
        }else{
            die('Error: No Access Token provided');
        }
    }
}