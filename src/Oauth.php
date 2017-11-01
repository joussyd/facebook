<?php

namespace Redscript\Facebook;
use Redscript\Facebook\User;

class Oauth extends Base
{
    /* Public Properties
    -------------------------------*/
    /* Protected Properties
    -------------------------------*/
    /* Private Properties
    -------------------------------*/
    /* Get
    -------------------------------*/
    /* Magic
    -------------------------------*/
    /* Public Methods
    -------------------------------*/
    public function __construct($client_id, $client_secret, $redirect_uri, $state, $scope)
    {

        if (!empty($client_id)) {
            $this->client_id = $client_id;
        }else{
            die('Error: Client id cannot be empty');
        }

        if (!empty($client_secret)) {
            $this->client_secret = $client_secret;
        }else{
            die('Error: Client secret cannot be empty');
        }

        if (!empty($redirect_uri)) {
            $this->redirect_uri = $redirect_uri;    
        }else{
            die('Error: Redirect Uri cannot be empty');
        }

        if (!empty($state)) {
            $this->state = $state;  
        }else{
            die('Error: tate cannot be empty');
        }

        if (!empty($scope)) {
            $this->scope = $scope;  
        }else{
            die('Error: Scope cannot be empty');
        }
    }

    /**
     * Generate the Faceboook Login Url
     *
     *
     * @return string
     */
    public function getLoginURL()
    {
        $loginUrl = self::FB_URL
        . "client_id=" . $this->client_id
        . "&redirect_uri=" . $this->redirect_uri
        . "&state=" . $this->state
        . "&response_type=code"
        . "&scope=" . $this->scope
        . "&include_granted_scopes=true";

        return $loginUrl;
    }

    /**
     * Get Access token
     *
     *
     * @return string
     */
    public function getAccessToken($code) 
    {
        // Check if code is set
        if(isset($code)){

            // Create post data array
            $post = array(
                "code" =>           $code,
                "client_id" =>      $this->client_id,
                "client_secret" =>  $this->client_secret,
                "redirect_uri" =>   $this->redirect_uri,
                "grant_type" =>     "authorization_code"
            );

            // Send request for token
            $response = Factory::sendRequest(self::TOKEN_URL, $post);

            // Check if there is a response
            if ($response) {
                // If response exist
                // return the access token
                return $response['access_token'];
            } else {
                // if there is no response, return null
                return null;
            }
        }else{
            // if not set, return null
            return null;
        }
    }

     /**
     * Get the User's Info
     *
     *
     * @return array
     */
    public function getUserInfo($access_token)
    {
        return User::_getUserInfo($access_token);
    }
}