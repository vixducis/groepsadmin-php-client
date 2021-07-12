<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Authentication;

class AuthenticationObject
{
    /**
     * Constructor
     * @param string $authenticationUrl The URL you should redirect to in order to authenticate.
     * @param string $state The oauth state parameter, should be stored to check for CSRF.
     */
    public function __construct(
        private string $authenticationUrl,
        private string $state
    ) {
    }

    /**
     * Returns the URL you should redirect to in order to authenticate with the 'groepsadmin'.
     * @return string
     */
    public function getAuthenticationUrl(): string
    {
        return $this->authenticationUrl;
    }

    /**
     * Returns the oauth state. This parameter should be stored somewhere server-side.
     * After being redirected back to your own application (after authentication),
     * this state parameter will be included as a query parameter. If these two match,
     * the authentication flow can be safely resumed without any CSRF possibility. 
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }
}
