<?php

namespace Redscript\Facebook;

class User extends Util
{

	const USER_INFO_URL = 'https://graph.facebook.com/me?fields=&fields=id,email,cover,name,first_name,last_name,age_range,link,gender,locale,picture,timezone,updated_time,verified&access_token=';

	private $access_token;

	public function __construct($access_token)
	{
		$this->access_token = $access_token;
	}

	/**
     * Get User's Basic info
     *
     *
     * @return string
     */
    function GetUserInfo($accessToken)
    {
        $url = self::USER_INFO_URL . $this->accessToken;

        $ch = curl_init();      
        curl_setopt($ch, CURLOPT_URL, $url);        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        //send request then decode the returned json string
        $data = json_decode(curl_exec($ch), true);

        //get request's return code
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return $data; 
    }
}