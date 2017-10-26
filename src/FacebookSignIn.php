<?php namespace cmi\facebook-sso;

require('config/fb-config.php');


/**
 * FacebookSignIn class for Sign In on Facebook using cURL
 *
 * 
 */
class FacebookSignIn
{
	/**
     * Generate the Faceboook Login Url
     *
     *
     * @return string
     */
	function GetLoginUrl()
    {
		$loginUrl = FACEBOOK_OAUTH_URL
		. "client_id=" . FACEBOOK_CLIENT_ID
		. "&redirect_uri=" . FACEBOOK_REDIRECT_URI
		. "&state=" . FACEBOOK_STATE
		. "&response_type=code"
		. "&scope=public_profile,email"
		. "&include_granted_scopes=true";

		return $loginUrl;
    }

    /**
     *  Send curl request
     *
     *
     * @return json
     */
	function Curl($url, $post) 
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
     * Get User's access token
     *
     *
     * @return string
     */
	function GetAccessToken($facebook_code) 
	{
		$tokenUrl = FACEBOOK_TOKEN_URL;
        $post = array(
            "code" =>           $facebook_code,
            "client_id" =>      FACEBOOK_CLIENT_ID,
            "client_secret" =>  FACEBOOK_CLIENT_SECRET,
            "redirect_uri" =>   FACEBOOK_REDIRECT_URI,
            "grant_type" =>     "authorization_code"
        );

        $response = $this->Curl($tokenUrl, $post);

        if ($response) {
            $authObj = json_decode($response);

            return $authObj;
        } else {
            return null;
        }
	}

    /**
     * Get User's Basic info
     *
     *
     * @return string
     */
    function getUserInfo($accessToken)
    {
        $userInfoUrl = FACEBOOK_USER_INFO_URL . $accessToken;

        $ch = curl_init();      
        curl_setopt($ch, CURLOPT_URL, $userInfoUrl);        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        //send request then decode the returned json string
        $data = json_decode(curl_exec($ch), true);

        //get request's return code
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return $data; 
    }
}