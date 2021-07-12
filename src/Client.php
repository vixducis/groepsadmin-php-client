<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient;

use Wouterh\GroepsadminClient\Authentication\Provider as AuthenticationProvider;
use Wouterh\GroepsadminClient\Token\TokenStorageInterface;

class Client
{
    protected ?AuthenticationProvider $authenticationProvider = null;

    /**
     * Constructor
     * The parameters required for the object will be provided by 'scouts en gidsen vlaanderen'.
     * The resource is required, the rest will be filled with default parameters.
     * @param string $resource
     * @param string $redirectUri The URL where you should be redirected to if the groepsadmin login flow was completed.
     * @param TokenStorageInterface|null $tokenStorage (optional) If you pass a token storage here, auto refreshing access tokens will be enabled.
     * @param string $realm (optional)
     * @param string $authenticationUrl (optional)
     */
    public function __construct(
        protected string $resource,
        protected string $redirectUri,
        protected ?TokenStorageInterface $tokenStorage = null,
        protected string $realm = 'scouts',
        protected string $authenticationUrl = 'https://login.scoutsengidsenvlaanderen.be/auth/'
    ) {
    }

    /**
     * Returns the authentication URL.
     * @return string
     */
    public function getAuthenticationUrl(): string
    {
        return $this->authenticationUrl;
    }

    /**
     * Returns the realm.
     * @return string
     */
    public function getRealm(): string
    {
        return $this->realm;
    }

    /**
     * Returns the resource.
     * @return string
     */
    public function getResource(): string
    {
        return $this->resource;
    }

    /**
     * Returns an authentication provider
     * @return AuthenticationProvider
     */
    public function getAuthenticationProvider(): AuthenticationProvider
    {
        if ($this->authenticationProvider === null) {
            $this->authenticationProvider = new AuthenticationProvider($this);
        }
        return $this->authenticationProvider;
    }

    /**
     * Returns (possibly) a token storage interface.
     * Will return null if none was set.
     * @return TokenStorageInterface|null
     */
    public function getTokenStorage(): ?TokenStorageInterface
    {
        return $this->tokenStorage;
    }

    /**
     * Returns the redirect URI.
     * @return string
     */
    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }
}
