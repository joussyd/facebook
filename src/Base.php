<?php

namespace Redscript\Facebook;
use Redscript\Facebook\Factory;

class Base 
{
	/* Constants
    -------------------------------*/
	const FB_GRAPH      = 'https://graph.facebook.com';
	const FB_URL        = self::HOST . '/v2.10/dialog/oauth?';
	const HOST          = 'https://www.facebook.com';
	const TOKEN_URL     = self::FB_GRAPH . '/' . self::VERSION .'/oauth/access_token?';
	const USER_INFO_URL = self::FB_GRAPH . '/me?fields=&fields=id,email,cover,name,first_name,last_name,age_range,link,gender,locale,picture,timezone,updated_time,verified&access_token=';
	const VERSION       = 'v2.10';

	/* Public Properties
    -------------------------------*/
    /* Protected Properties
    -------------------------------*/
	protected $client_id;
	protected $redirect_uri;
	protected $state;
	protected $scope;
	
    /* Private Properties
    -------------------------------*/
    /* Get
    -------------------------------*/
    /* Magic
    -------------------------------*/
    /* Public Methods
    -------------------------------*/
    /* Protected Methods
    -------------------------------*/
}