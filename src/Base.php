<?php

namespace Redscript\Facebook;

class Base extends Oauth
{

	const FB_URL = 'https://www.facebook.com/v2.10/dialog/oauth?';

	private $client_id;
	private $redirect_uri;
	private $state;
	private $scope;

	public function __construct($client_id, $redirect_uri, $state, $scope)
	{
		$this->client_id = $client_id;
		$this->redirect_uri = $redirect_uri;
		$this->state = $state;
		$this->scope = $scope;
	}


	/**
     * Generate the Faceboook Login Url
     *
     *
     * @return string
     */
	public function GetLoginUrl()
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
     * Get the User's Info
     *
     *
     * @return array
     */
    public function GetUserInfo($access_token)
    {
    	return User::GetUserInfo($access_token);
    }
}