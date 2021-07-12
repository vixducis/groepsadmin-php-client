<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Authentication;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class ResourceOwner implements ResourceOwnerInterface
{

    /**
     * Creates new resource owner.
     *
     * @param array  $response
     */
    public function __construct(protected array $response = [])
    {
    }
    
    /**
     * Get resource owner id
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->response['sub'] ?: null;
    }

    /**
     * Return all of the owner details available as an array.
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}
