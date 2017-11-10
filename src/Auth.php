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
 */
class Auth extends Factory
{

    /* Constants
    -------------------------------*/
    const GRANTED_SCOPE = true;
    const GRANT_TYPE    = 'authorization_code';
    const HOST          = 'https://www.facebook.com';
    const REQUEST_AUTH  = '/dialog/oauth';
    const REQUEST_TOKEN = '/oauth/access_token?';
    const RESPONSE_TYPE = 'code';
    const VERSION       = 'v2.10';

    /* Public Methods
    -------------------------------*/
    /**
    * Authentication constructor
    *
    * @param  string $clientId      Client ID
    * @param  string $clientSecret  Client Secret
    * @param  string $redirectUri   Redirect URL
    * @param  string $scope         Scope
    * @param  string $state         State
    * @return Auth class
    */
    public function __construct($clientId, $clientSecret, $redirectUri, $state, $scope)
    {
        $this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri  = $redirectUri;
        $this->state        = $state;
        $this->scope        = $scope; 
    }

    /**
     * Generate the Faceboook Login Url
     *
     *
     * @return string
     */
    public function getLoginURL()
    {
        // build url
        $url = self::HOST . '/' . self::VERSION . self::REQUEST_AUTH;

        // build query parameters
        $params = array(
            'client_id'              => $this->clientId,
            'redirect_uri'           => $this->redirectUri,
            'state'                  => $this->state,
            'response_type'          => self::RESPONSE_TYPE,
            'scope'                  => $this->scope,
            'include_granted_scopes' => self::GRANTED_SCOPE
        );

        // append query parameters in the url
        $loginUrl = $url . '?' . http_build_query($params);

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
        // Check if code is not set
        if(!isset($code)){
            // if true, let's throw some error
            throw new Exception('Error: Code not set');
        }

        //create post data array
        $post = array(
            'code'          =>  $code,
            'client_id'     =>  $this->clientId,
            'client_secret' =>  $this->clientSecret,
            'redirect_uri'  =>  $this->redirectUri,
            'grant_type'    =>  self::GRANT_TYPE
        );

        // Create URL
        $url = self::GRAPH . '/' . self::VERSION . self::REQUEST_TOKEN;
        
        // Send request for token
        $response = $this->sendRequest($url, $post);

        // Check if there is no response
        if(!$response) {
            throw new Exception('Error: Failed to retrieve access token');
        }

        // return the access token
        return $response['access_token'];
    }
}