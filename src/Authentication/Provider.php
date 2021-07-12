<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Authentication;

use League\OAuth2\Client\Token\AccessTokenInterface;
use Wouterh\GroepsadminClient\Client;

class Provider
{
    /**
     * Constructor
     * @param Client $client
     */
    public function __construct(
        private Client $client
    ) {
    }

    /**
     * Returns a keycloak provider
     * @param array $options (optional) Any extra options you might want to provide.
     * @return Keycloak
     */
    protected function getKeycloakProvider(array $options = []): Keycloak
    {
        return new Keycloak(array_merge($options, [
            'realm' => $this->client->getRealm(),
            'authServerUrl' => $this->client->getAuthenticationUrl(),
            'clientId' => $this->client->getResource(),
            'redirectUri' => $this->client->getRedirectUri()
        ]));
    }

    /**
     * Returns a URL where you will be redirected to, in order to authenticate with the 'groepsadmin'.
     * @return AuthenticationObject
     */
    public function getAuthenticationData(): AuthenticationObject
    {
        $keycloak = $this->getKeycloakProvider();
        return new AuthenticationObject(
            $keycloak->getAuthorizationUrl(),
            $keycloak->getState()
        );
    }

    /**
     * After being redirected back to your own application, a 'code' query parameter
     * will be added to the url. Providing this query parameter to this function
     * will result in an access token that you can use to authenticate calls.
     * This will also store the token in your token storage if one was passed to the client.
     * @param string $code
     * @return AccessTokenInterface
     */
    public function getAccessToken(string $code): AccessTokenInterface
    {
        $keycloak = $this->getKeycloakProvider();
        $token = $keycloak->getAccessToken('authorization_code', [
            'code' => $code,
        ]);
        $this->storeAccessTokenInStorage($token);
        return $token;
    }

    /**
     * Refreshes the access token.
     * This will also store the token in your token storage if one was passed to the client.
     * @param AccessTokenInterface $accessToken
     * @return AccessTokenInterface
     */
    public function refreshAccessToken(AccessTokenInterface $accessToken): AccessTokenInterface
    {
        $keycloak = $this->getKeycloakProvider();
        $token = $keycloak->getAccessToken('refresh_token', [
            'refresh_token' => $accessToken->getRefreshToken()
        ]);
        $this->storeAccessTokenInStorage($token);
        return $token;
    }

    /**
     * Stores the provided access token in the token storage if it was set on the client.
     * @param AccessTokenInterface $token
     */
    protected function storeAccessTokenInStorage(AccessTokenInterface $token): void
    {
        if ($this->client->getTokenStorage() !== null) {
            $this->client->getTokenStorage()->store($token);
        }
    }
}  
