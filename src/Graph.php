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

/**
 * Graph Class
 *
 * PHP version 7+
 *
 * @category Class
 * @author   Joussyd Calupig <joussydmcalupig@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
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
        $this->accessToken = $accessToken;
        $this->fields      = $fields;
    }

    /**
     * Get User Profile
     *
     * @return json
     */
    public function getProfile()
    {
        // Check if access token is not set
        if(!isset($this->accessToken)){
            throw new Exception("Error: Access token not set");
        }

        $query = array(
            'fields'        => implode(',', $this->fields),
            'access_token'  => $this->accessToken);

        $url = self::GRAPH . '/me?' . http_build_query($query);
        
        //return response from the request
        return $this->sendRequest($url);
    }
}