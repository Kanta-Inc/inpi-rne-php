<?php

namespace RNEClient;

use GuzzleHttp\Exception\GuzzleException;

/**
 * Class SearchFinancialStatements
 *
 * @package RNEClient
 */
class SearchFinancialStatements extends RNEClient implements SearchFinancialStatementsInterface
{

    /**
     * Search a company financial statements by its siren number
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
     * Get balance sheet data by its id
     *
     * @param string $id
     *
     * @throws GuzzleException
     * @return array
     */
    public function getDataById(string $id): array
    {
        return $this->requestApi("get", "api/bilan-saisis/{$id}", ['headers' => $this->getAuthorizationHeaderArray()]);
    }

    /**
     * Get balance sheet metadata by its id
     *
     * @param string $id
     * 
     * @throws GuzzleException
     * @return array
     */
    public function getMetadataById(string $id): array
    {
        return $this->requestApi("get", "api/bilans/{$id}", ['headers' => $this->getAuthorizationHeaderArray()]);
    }

    /**
     * Get a balance sheet PDF file by its id
     * Exact search only
     *
     * @param string $id
     *
     * @throws GuzzleException
     * @return resource
     */
    public function getFileById(string $id): string
    {
        return $this->requestFileApi("get", "api/bilans/{$id}/download", ['headers' => $this->getAuthorizationHeaderArray()]);
    }
}