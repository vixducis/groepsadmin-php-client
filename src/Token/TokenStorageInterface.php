<?php declare(strict_types=1);

namespace Wouterh\GroepsadminClient\Token;

use League\OAuth2\Client\Token\AccessTokenInterface;

/**
 * Token Storage Interface
 *
 * When auto-refreshing access tokens, tokens need be stored and retrieved.
 * You can provide your own storage for this (this could be done in cookies, a database, session,...
 * Your storage will need to adhere to this interface for this to work.
 * 
 * @package GroepsadminClient
 * @author Wouter Henderickx
 */
interface TokenStorageInterface
{
    /**
     * Store the given access token in the storage of your choosing.
     * @param AccessTokenInterface
     */
    public function store(AccessTokenInterface $accessToken): void;

    /**
     * Retrieve an access token from your storage.
     * If no access token was found in your storage, return null
     * @return AccessTokenInterface|null
     */
    public function retrieve(): ?AccessTokenInterface;
}