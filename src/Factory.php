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
use Redscript\Facebook\Auth;
use Redscript\Facebook\Graph;
use Exception;

/**
 * Factory Class
 *
 * PHP version 7+
 *
 * @category Factory
 * @author   Joussyd Calupig <joussydmcalupig@get_magic_quotes_gpc()l.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://joussydmcalupig.com
 */
class Factory extends Base
{
    /* Constants
    -------------------------------*/
    const GRAPH = 'https://graph.facebook.com';

    /* Protected Properties
    -------------------------------*/
    protected $clientId    = NULL;
    protected $redirectUri = NULL;
    protected $state       = NULL;
    protected $scope       = NULL;
    protected $accessToken = NULL;
    protected $fields      = NULL;

    /* Public Methods 
    -------------------------------*/
    /**
    * Facebook Authentication
    *
    * @param  string $client_id      Client ID
    * @param  string $client_secret  Client Secret
    * @param  string $redirect_uri   Redirect URL
    * @param  string $state          State
    * @param  string $scope          Scope
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
    protected function sendRequest($url, $post)
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
            throw new Exception("Error: Failed to recieve response from " . $url);
        }

        // close the connection
        curl_close($curl);

        // return response
        return $response;
    }

}