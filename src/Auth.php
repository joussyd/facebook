<?php
/**
 * This file is part of the Compos Mentis Inc.
 * PHP version 7+ (c) 2017 CMI
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 *
 * @category Class
 * @package  Class
 * @author   Joussyd Calupig <joussydmcalupig@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://joussydmcalupig.com
 */
namespace Redscript\Facebook;

/**
 * Authentication Class
 *
 * PHP version 7+
 *
 * @category Class
 * @author   Joussyd Calupig <joussydmcalupig@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://joussydmcalupig.com
 */
class Auth extends Factory
{

    /* Constants
    -------------------------------*/
    const HOST          = 'https://www.facebook.com';
    const REQUEST_AUTH  = '/dialog/oauth';
    const REQUEST_TOKEN = '/oauth/access_token?';
    const VERSION       = 'v2.10';

    /* Public Methods
    -------------------------------*/
    /**
    * Authentication constructor
    *
    * @param  string $clientId      Client ID
    * @param  string $clientSecret  Client Secret
    * @param  string $redirectUri   Redirect URL
    * @param  string $state         State
    * @param  string $scope         Scope
    * @param  string $fields        Fields
    * @return Auth class
    */
    public function __construct($clientId, $clientSecret, $redirectUri, $state, $scope)
    {
        // Check if client id is not empty
        if (!empty($clientId)) {
            // assign client id as protected property
            $this->clientId = $clientId;
        }else{
            // if empty, return error
            die('Error: Client id cannot be empty');
        }
        // Check if the client secret is not empty
        if (!empty($clientSecret)) {
            // assign client secret as protected property
            $this->clientSecret = $clientSecret;
        }else{
            // if empty, return error
            die('Error: Client secret cannot be empty');
        }
        // Check if the redirect uri is not empty
        if (!empty($redirectUri)) {
            //assign redirect uri as protected property
            $this->redirectUri = $redirectUri;    
        }else{
            // if empty, return error
            die('Error: Redirect Uri cannot be empty');
        }
        // Check is the state is empty
        if (!empty($state)) {
            // assign state as protected property
            $this->state = $state;  
        }else{
            // if empty, return error
            die('Error: tate cannot be empty');
        }
        // Check if the scope is empty
        if (!empty($scope)) {
            // assign scope as protected property
            $this->scope = $scope;  
        }else{
            // if empty, return error
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
        // build login url
        $loginUrl = self::HOST . '/' . self::VERSION . self::REQUEST_AUTH
        . "?client_id=" . $this->clientId
        . "&redirect_uri=" . $this->redirectUri
        . "&state=" . $this->state
        . "&response_type=code"
        . "&scope=" . $this->scope
        . "&include_granted_scopes=true";

        // return login url
        return $loginUrl;
    }

    /**
     * Get Access token
     *
     * @param  string $code  Facebook Code
     * @return string
     */
    public function getAccessToken($code) 
    {
        // Check if code is set
        if(isset($code)){

            // Create post data array
            $post = array(
                "code"          =>  $code,
                "client_id"     =>  $this->clientId,
                "client_secret" =>  $this->clientSecret,
                "redirect_uri"  =>  $this->redirectUri,
                "grant_type"    =>  "authorization_code"
            );

            // Create URL
            $url = self::GRAPH . '/' . self::VERSION . self::REQUEST_TOKEN;

            // Send request for token
            $response = Factory::sendRequest($url, $post);

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
}