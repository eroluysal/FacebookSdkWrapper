<?php

namespace QweB\Facebook;

use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use QweB\Facebook\Contracts\Factory as FactoryContract;

class Factory implements FactoryContract
{
    /**
     * The default redirect url of application.
     *
     * @var string
     */
    protected $redirectUrl;

    /**
     * The registered scopes parameters.
     *
     * @var array
     */
    protected $scopes = [];

    /**
     * The session instance.
     *
     * @var \Facebook\FacebookSession
     */
    protected $session;

    /**
     * Create a new Factory instance.
     *
     * @param string $appId
     * @param string $secret
     * @param array  $scopes
     *
     * @return void
     */
    public function __construct($appId, $secret, array $scopes = [])
    {
        $this->startPhpSession();

        $this->startFacebookApplication($appId, $secret);

        $this->setScopes($scopes);
    }

    /**
     * Create a new Facebook request with redirect session.
     *
     * @param string $method
     * @param string $path
     * @param array  $parameters
     *
     * @return \Facebook\FacebookResponse
     */
    public function createRequest($method, $path, array $parameters = [])
    {
        $request = new FacebookRequest($this->getSession(), $method, $path, $parameters);

        return $request->execute();
    }

    /**
     * Stores CSRF state and returns a URL to which the user should be sent to
     * in order to continue the login process with Facebook.
     *
     * @param array $scopes
     *
     * @return string
     */
    public function getLoginUrl(array $scopes = [])
    {
        return $this->getRedirectHelper()->getLoginUrl($this->getScopes($scopes));
    }

    /**
     * Get the access token from redirect of current session.
     *
     * @return \Facebook\Entities\AccessToken
     */
    public function getAccessToken()
    {
        return $this->getSession()->getAccessToken();
    }

    /**
     * Get the session from redirect of current client.
     *
     * @return \Facebook\FacebookSession
     */
    public function getSession()
    {
        if (!$this->session) {
            $this->session = $this->getRedirectHelper()->getSessionFromRedirect();
        }

        return $this->session;
    }

    /**
     * Get the redirect url.
     *
     * @throws MissingRedirectUrlException
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        if (!$this->redirectUrl) {
            throw new MissingRedirectUrlException();
        }

        return $this->redirectUrl;
    }

    /**
     * Set the redirect url for login helper instance.
     *
     * @param string $redirectUrl
     *
     * @return self
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;

        return $this;
    }

    /**
     * Get the scopes with given parameters.
     *
     * @param array|string $scopes
     *
     * @return array
     */
    protected function getScopes($scopes = null)
    {
        return array_unique(array_merge((array) $this->scopes, (array) $scopes));
    }

    /**
     * Set the new scopes.
     *
     * @param array $scopes
     *
     * @return self
     */
    protected function setScopes(array $scopes)
    {
        $this->scopes = $scopes;

        return $this;
    }

    /**
     * Get the redirect login helper instance.
     *
     * @return \Facebook\FacebookRedirectLoginHelper
     */
    protected function getRedirectHelper()
    {
        return new FacebookRedirectLoginHelper($this->getRedirectUrl());
    }

    /**
     * Start PHP Session for need Facebook SDK.
     *
     * @throws SessionStartException
     *
     * @return bool
     */
    protected function startPhpSession()
    {
        if (!@session_start()) {
            throw new SessionStartException();
        }
    }

    /**
     * Start the Facebook application session.
     *
     * @param string $appId
     * @param string $secret
     *
     * @return void
     */
    protected function startFacebookApplication($appId, $secret)
    {
        FacebookSession::setDefaultApplication($appId, $secret);
    }
}
