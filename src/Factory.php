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
namespace Lethia\Facebook;
use Lethia\Facebook\Auth;
use Lethia\Facebook\Graph;
use Exception;

/**
 * Factory Class
 *
 * PHP version 7+
 *
 * @category Factory
 * @author   Joussyd Calupig <joussydmcalupig@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
class Factory extends Base
{
    /* Constants
    -------------------------------*/
    const GRAPH = 'https://graph.facebook.com';

    /* Protected Properties
    -------------------------------*/
    protected $accessToken = NULL;
    protected $clientId    = NULL;
    protected $fields      = NULL;
    protected $redirectUri = NULL;
    protected $scope       = NULL;
    protected $state       = NULL;

    /* Public Methods 
    -------------------------------*/
    /**
    * Facebook Authentication
    *
    * @param  string $client_id      Client ID
    * @param  string $client_secret  Client Secret
    * @param  string $redirect_uri   Redirect URL
    * @param  string $scope          Scope
    * @param  string $state          State
    * @return Auth class
    */
    public function auth($clientId, $clientSecret, $redirectUri, $state, $scope)
    {
        return new Auth($clientId, $clientSecret, $redirectUri, $state, $scope);
    }

    /**
    * Facebook Graph
    *
    * @return Graph class
    */
    public function graph($accessToken, $fields)
    {
        return new Graph($accessToken, $fields);
    }

    /**
    * Send Curl Request
    *
    * @param  string $url   URL
    * @param  array  $post  Request's post data
    * @return json
    */
    protected function sendRequest($url, $post = array())
    {
        // initiate  request
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // check if post is set
        if(!empty($post)) {
            // add post data to the equest
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }

        // decode curl response to json
        $response = json_decode(curl_exec($curl), true);

        // get the request's return code
        $http_code = curl_getinfo($curl,CURLINFO_HTTP_CODE);

        // check if the return code is OK
        if($http_code != 200) {
            throw new Exception('Error: Failed to recieve response from ' . $url);
        }

        // close the connection
        curl_close($curl);

        // return response
        return $response;
    }
}