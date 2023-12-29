<?php

namespace RNEClient;

interface RNEClientInterface
{
    /**
     * authentication
     */
    public function authenticate(string $username, string $password): void;
    public function getToken(): string;
}
