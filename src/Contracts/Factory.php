<?php

namespace QweB\Facebook\Contracts;

use QweB\Facebook\MissingRedirectUrlException;

interface Factory
{
    /**
     * Create a new Facebook request with redirect session.
     *
     * @param  string  $method
     * @param  string  $path
     * @param  array   $parameters
     * @return \Facebook\FacebookResponse
     */
    public function createRequest($method, $path, array $parameters = []);

    /**
     * Stores CSRF state and returns a URL to which the user should be sent to
     * in order to continue the login process with Facebook.
     *
     * @param  array   $scopes
     * @return string
     */
    public function getLoginUrl(array $scopes = []);

    /**
     * Get the access token from redirect of current session.
     *
     * @return \Facebook\Entities\AccessToken
     */
    public function getAccessToken();

    /**
     * Get the redirect url.
     *
     * @return string
     *
     * @throws MissingRedirectUrlException
     */
    public function getRedirectUrl();

    /**
     * Set the redirect url for login helper instance.
     *
     * @param  string  $redirectUrl
     * @return self
     */
    public function setRedirectUrl($redirectUrl);
}
