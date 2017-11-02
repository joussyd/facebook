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
 * Graph Class
 *
 * PHP version 7+
 *
 * @category Class
 * @author   Joussyd Calupig <joussydmcalupig@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://joussydmcalupig.com
 */
class Graph extends Factory
{
    /* Constants
    -------------------------------*/
    /* Public Methods
    -------------------------------*/
    /**
    * Graph constructor
    *
    * @param  string $access  Token Access Token
    * @param  array  $fields  Fields
    * @return Auth class
    */
    public function __construct($accessToken, $fields)
    {
        // Check if the fields is empty
        if (!empty($accessToken)) {     
            // assign access token as protected property
            $this->accessToken = $accessToken; 
        }else{
            // if empty, return error
            die('Error: Access Token cannot be empty');
        }

        // Check if the fields is empty
        if (!empty($fields)) {     
            // assign fields as protected property
            $this->fields = $fields; 
        }else{
            // if empty, return error
            die('Error: fields cannot be empty');
        }
    }

	/**
     * Get User Profile
     *
     * @param  string $accessToken Facebook Access Token
     * @return json
     */
    public function getProfile()
    {

        // Check if access token is set
        if(isset($this->accessToken)){
            // facebook graph url
            $url = self::GRAPH . '/me?fields=' . implode(',', $this->fields) .  '&access_token=' . $this->accessToken;
            $post = '';

            //return response from the request
            return Factory::sendRequest($url, $post);
        }else{
            // if not set, return error
            die('Error: No Access Token provided');
        }
    }
}