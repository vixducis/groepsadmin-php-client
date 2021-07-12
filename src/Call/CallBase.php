<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Call;

use GuzzleHttp\Client;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Psr\Http\Message\ResponseInterface;
use Wouterh\GroepsadminClient\Client as GroepsadminClient;
use Wouterh\GroepsadminClient\Exception\InvalidTokenException;

class CallBase
{
    private const BASE_URI = 'https://groepsadmin.scoutsengidsenvlaanderen.be/groepsadmin/rest-ga/';
    public const METHOD_GET = 'GET';

    /**
     * Constructor
     * @param GroepsadminClient $client
     * @param Token|null $token A token can be provided in order to authenticate. This is only required when you're not using token storage. This will take priority over cookie storage you've set.
     */
    public function __construct(
        protected GroepsadminClient $client,
        protected ?AccessTokenInterface $token = null
    ) {
    }

    /**
     * Returns the headers that should be included in all calls towards the api.
     * @return array
     */
    protected function getHeaders(): array
    {
        return ['Authorization' => 'Bearer '.$this->token->getToken()];
    }

    /**
     * Performs a call towards the groepsadmin api.
     * @param string $endpoint
     * @param string $method (optional) Will default to GET.
     * @param string[] $queryParams (optional)
     * @param array $body (optional)
     * @throws InvalidTokenException
     */
    protected function performCall(
        string $endpoint,
        string $method = self::METHOD_GET,
        array $queryParams = [],
        ?array $body = null
    ): ResponseInterface {
        // retrieve token from storage of storage was set
        if ($this->client->getTokenStorage() !== null && $this->token === null) {
            $this->token = $this->client->getTokenStorage()->retrieve();

            // throw an exception if no token was found in storage
            if ($this->token === null) {
                throw new InvalidTokenException;
            }

            // if the token has expired, request a new one and store it
            if ($this->token->hasExpired()) {
                $this->token = $this->client->getAuthenticationProvider()->refreshAccessToken($this->token);
            }
        }

        // if the token has expired, throw an exception
        if ($this->token->hasExpired()) {
            throw new InvalidTokenException;
        }

        // create an http client and peform the call
        $client = new Client([
            'base_uri' => self::BASE_URI
        ]);
        return $client->request($method, $endpoint, [
            'query' => $queryParams,
            'json' => $body,
            'headers' => $this->getHeaders()
        ]);
    }
}
