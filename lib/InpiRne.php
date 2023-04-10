<?php

namespace InpiRne;

/**
 * Class InpiRne
 */
class InpiRne
{
    /** @var string The INPI RNE API token to be used for requests. */
    public static $apiToken;

    /** @var string The base URL for the INPI RNE API. */
    public static $apiBase = 'https://registre-national-entreprises.inpi.fr/api';

    /**
     * @return string the API token used for requests
     */
    public static function getApiToken()
    {
        return self::$apiToken;
    }

    /**
     * Sets the API key to be used for requests.
     *
     * @param string $apiToken
     */
    public static function setApiToken($apiToken)
    {
        self::$apiToken = $apiToken;
    }
}
