<?php

namespace RNEClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class RNEClient
 *
 * @package RNEClient
 */
class RNEClient implements RNEClientInterface
{
    private Client $client;
    private ?string $token;

    public const DEFAULT_PAGE_SIZE = 20;
    public const BASE_URI = 'https://registre-national-entreprises.inpi.fr/';

    public const VALID_ACTIVITY_SECTORS = [
        'AGENT_COMMERCIAL',
        'AGRICOLE_NON_ACTIF',
        'ACTIF_AGRICOLE',
        'ARTISANALE',
        'ARTISANALE_REGLEMENTEE',
        'COMMERCIALE',
        'LIBERALE_REGLEMENTEE',
        'LIBERALE_NON_REGLEMENTEE',
        'GESTION_DE_BIENS',
        'SANS_ACTIVITE'
    ];

    /**
     * RNEClient constructor.
     * If a token is provided, it will be used for the requests
     * Otherwise, the user will have to authenticate first
     *
     * @param string|null $token
     * @param Client|null $client
     */
    public function __construct(?string $token = null, ?Client $client = null)
    {
        // if no client is provided, create a new one
        // test purpose only
        $this->client = $client ?? new Client(['base_uri' => self::BASE_URI]);

        $this->token = $token;
    }

    /**
     * Authentify the user and store the token in the client
     *
     * @param string $username
     * @param string $password
     *
     * @throws GuzzleException
     * @return void
     */
    public function authenticate(string $username, string $password): void
    {
        // reset the token
        $this->token = null;
        // call the API to get the token
        $data = $this->requestApi('post', 'api/sso/login', [
            'json' => [
                'username' => $username,
                'password' => $password
            ]
        ]);
        $this->token = $data['token'];
    }

    /**
     * Get the token
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * add a decoration to the response
     * resultsCount, hasMoreResults, nextPageUrl
     *
     * @param array $data
     * @param int $pageSize
     *
     * @throws GuzzleException
     * @return array
     */
    protected function decorateResponse(array $data, int $pageSize = self::DEFAULT_PAGE_SIZE): array
    {
        // decorate the response to add results count
        // if page size is reached, we need to indicate there are more results
        $dataCount = count($data);
        $decoratedData['resultsCount'] = $dataCount;
        $decoratedData['hasMoreResults'] = false;
        if ($dataCount === $pageSize) {
            $decoratedData['hasMoreResults'] = true;
        }
        $decoratedData['results'] = $data;

        return $decoratedData;
    }

    /**
     * Get the authorization header array
     *
     * @throws \Exception
     * @return array
     */
    protected function getAuthorizationHeaderArray(): array
    {
        if ($this->token) {
            $headers['Authorization'] = 'Bearer ' . $this->token;
        } else {
            throw new \Exception('You need to authenticate first.');
        }
        return $headers;
    }

    /**
     * Add the page parameter to the url
     *
     * @param string $url
     * @param int $page
     *
     * @throws \Exception
     * @return string
     */
    protected function addPageToUrl(string $url, int $page): string
    {
        if ($page < 1) {
            throw new \Exception('Invalid input page, please use a number greater than 0.');
        }
        return $url . "page={$page}&";
    }

    /**
     * Add the page size parameter to the url
     *
     * @param string $url
     * @param int $pageSize
     *
     * @throws \Exception
     * @return string
     */
    protected function addPageSizeToUrl(string $url, int $pageSize): string
    {
        if ($pageSize < 1 || $pageSize > 100) {
            throw new \Exception('Invalid input page size, please use a number between 1 and 100.');
        }
        return $url . "pageSize={$pageSize}&";
    }

    /**
     * Request the API
     *
     * @param string $method
     * @param string $url
     * @param array $options
     *
     * @throws GuzzleException
     * @return array
     */
    protected function requestApi(string $method, string $url, array $options = []): array
    {
        $data = [];
        try {
            $response = $this->client->request($method, $url, $options);
            $data = json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            $this->catchResponseErrors($e);
        }
        return $data;
    }

    protected function requestFileApi(string $method, string $url, array $options = []): string
    {
        $data = [];
        try {
            $response = $this->client->request($method, $url, $options);
            $data = $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            $this->catchResponseErrors($e);
        }
        return $data;
    }

    /**
     * Catch the response errors
     *
     * @param GuzzleException $e
     *
     * @throws \Exception
     * @return void
     */
    protected function catchResponseErrors(GuzzleException $e): void
    {
        if ($e->getCode() === 400) {
            throw new \Exception('Bad request');
        } elseif ($e->getCode() === 401) {
            throw new \Exception('Bad credentials');
        } elseif ($e->getCode() === 403) {
            throw new \Exception('Forbidden');
        } elseif ($e->getCode() === 404) {
            throw new \Exception('Not found');
        } elseif ($e->getCode() === 429) {
            throw new \Exception('Too many requests');
        } elseif ($e->getCode() === 500) {
            throw new \Exception('Internal server error');
        } else {
            throw new \Exception('Unknown error', 0, $e);
        }
    }
}
