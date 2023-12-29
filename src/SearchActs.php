<?php

namespace RNEClient;

use GuzzleHttp\Exception\GuzzleException;

/**
 * Class SearchActs
 *
 * @package RNEClient
 */
class SearchActs extends RNEClient implements SearchActsInterface
{
    /**
     * Search a company acts by its siren number
     * Exact search only
     *
     * @param string $siren
     *
     * @throws GuzzleException
     * @return array
     */
    public function searchBySiren(string $siren): array
    {
        // error if the siren is not 9 length number
        if (!preg_match('/^\d{9}$/', $siren)) {
            throw new \Exception('Invalid input siren, please use a 9 length number.');
        }
        return $this->requestApi("get", "api/companies/{$siren}/attachments", ['headers' => $this->getAuthorizationHeaderArray()]);
    }

    /**
     * Search a act metadata by its id
     * Exact search only
     *
     * @param string $siren
     *
     * @throws GuzzleException
     * @return array
     */
    public function getMetadataById(string $id): array
    {
        return $this->requestApi("get", "api/actes/{$id}", ['headers' => $this->getAuthorizationHeaderArray()]);
    }

    /**
     * Search a act file by its id
     * Exact search only
     *
     * @param string $siren
     *
     * @throws GuzzleException
     * @return resource
     */
    public function getFileById(string $id): string
    {
        return $this->requestFileApi("get", "api/actes/{$id}/download", ['headers' => $this->getAuthorizationHeaderArray()]);
    }
}
