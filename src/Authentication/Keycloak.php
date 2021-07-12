<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Authentication;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Keycloak extends AbstractProvider
{
    /**
     * Keycloak URL
     * @var string
     */
    public $authServerUrl = null;

    /**
     * Realm name
     * @var string
     */
    public $realm = null;

    /**
     * Constructs an OAuth 2.0 service provider.
     * @param array $options An array of options to set on this provider.
     * @param array $collaborators An array of collaborators that may be used to
     */
    public function __construct(array $options = [], array $collaborators = [])
    {
        parent::__construct($options, $collaborators);
    }

    /**
     * Creates base url from provider configuration.
     * @return string
     */
    protected function getBaseUrlWithRealm(): string
    {
        return $this->authServerUrl
            . (substr($this->authServerUrl, -1) === '/' ? '' : '/')
            . 'realms/'
            . $this->realm;
    }

    /**
     * Get authorization url to begin OAuth flow
     * @return string
     */
    public function getBaseAuthorizationUrl(): string
    {
        return $this->getBaseUrlWithRealm().'/protocol/openid-connect/auth';
    }

    /**
     * Get access token url to retrieve token
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params): string
    {
        return $this->getBaseUrlWithRealm().'/protocol/openid-connect/token';
    }

    /**
     * Get provider url to fetch user details
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return $this->getBaseUrlWithRealm().'/protocol/openid-connect/userinfo';
    }

    /**
     * Get the default scopes used by this provider.
     * @return string[]
     */
    protected function getDefaultScopes(): array
    {
        return ['profile', 'email'];
    }

    /**
     * Checks a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  array|string $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if (!empty($data['error'])) {
            $error = $data['error'].': '.$data['error_description'];
            throw new IdentityProviderException($error, 0, $data);
        }
    }

    /**
     * Generate a user object from a successful user details request.
     * @param array $response
     * @param AccessToken $token
     * @return ResourceOwner
     */
    protected function createResourceOwner(array $response, AccessToken $token): ResourceOwnerInterface
    {
        return new ResourceOwner($response);
    }

    /**
     * Returns the string that should be used to separate scopes when building
     * the URL for requesting an access token.
     * @return string Scope separator, defaults to ','
     */
    protected function getScopeSeparator(): string
    {
        return ' ';
    }
}
