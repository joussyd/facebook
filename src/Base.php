<?php

namespace Redscript\Facebook;

class Base extends Oauth
{

	const FB_URL = 'https://www.facebook.com/v2.10/dialog/oauth?';

	protected $client_id;
	protected $redirect_uri;
	protected $state;
	protected $scope;

	public function __construct($client_id, $redirect_uri, $state, $scope)
	{
		if (isset($client_id)) {
			$this->client_id = $client_id;
		}else{
			throw new Exception('Client id cannot be empty');
		}

		if (isset($redirect_uri)) {
			$this->redirect_uri = $redirect_uri;	
		}else{
			throw new Exception('Redirect Uri cannot be empty');
		}

		if (isset($state)) {
			$this->state = $state;	
		}else{
			throw new Exception('State cannot be empty');
		}

		if (isset($scope)) {
			$this->scope = $scope;	
		}else{
			throw new Exception('Scope cannot be empty');
		}
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