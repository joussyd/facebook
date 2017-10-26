<?php namespace cmi\facebooksso;

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
	function GetLoginUrl($fb_client_id, $fb_redirect_uri, $fb_state)
    {
		$loginUrl = 'https://www.facebook.com/v2.10/dialog/oauth?'
		. "client_id=" . $fb_client_id
		. "&redirect_uri=" . $fb_redirect_uri
		. "&state=" . $fb_state
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
	function GetAccessToken($fb_code,$fb_client_id, $fb_client_secret, $fb_client_redirect_uri) 
	{
		$tokenUrl = 'https://graph.facebook.com/v2.10/oauth/access_token?';
        $post = array(
            "code" =>           $fb_code,
            "client_id" =>      $fb_client_id,
            "client_secret" =>  $fb_client_secret,
            "redirect_uri" =>   $fb_client_redirect_uri,
            "grant_type" =>     "authorization_code"
        );

        $response = $this->Curl($tokenUrl, $post);

        if ($response) {
            $authObj = json_decode($response);

            return $authObj->access_token;
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
        $userInfoUrl = 'https://graph.facebook.com/me?fields=&fields=id,email,cover,name,first_name,last_name,age_range,link,gender,locale,picture,timezone,updated_time,verified&access_token=' . $accessToken;

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