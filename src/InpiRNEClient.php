<?php

namespace InpiRNEClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class InpiRNEClient
 * 
 * @package InpiRNEClient
 */
class InpiRNEClient implements InpiRNEClientInterface
{
    private Client $client;
    private ?string $token;

    private const DEFAULT_PAGE_SIZE = 20;
    private const BASE_URI = 'https://registre-national-entreprises.inpi.fr/';

    /**
     * InpiRNEClient constructor.
     * If a token is provided, it will be used for the requests
     * Otherwise, the user will have to authenticate first
     * 
     * @param string|null $token
     */
    public function __construct(?string $token = null)
    {
        $this->client = new Client(['base_uri' => self::BASE_URI]);
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
        try {
            // reset the token
            $this->token = null;
            // call the API to get the token
            $response = $this->client->post('api/sso/login', [
                'json' => [
                    'username' => $username,
                    'password' => $password
                ]
            ]);
            $data = json_decode($response->getBody(), true);
            $this->token = $data['token'];
        } catch (GuzzleException $e) {
            // if 401, the credentials are invalid
            if ($e->getCode() === 401) {
                throw new \Exception('Bad credentials');
            } else if ($e->getCode() === 403) {
                throw new \Exception('Forbidden');
            } else if ($e->getCode() === 429) {
                throw new \Exception('Too many requests');
            }
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
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
     * Search a company by its siren number
     * Exact search only
     * 
     * @param string $siren
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompanyBySiren(string $siren): array
    {
        try {
            // error if the siren is not 9 length number
            if (!preg_match('/^\d{9}$/', $siren)) {
                throw new \Exception('Invalid input siren, please use a 9 length number.');
            }
            $response = $this->client->get("api/companies/{$siren}", ['headers' => $this->getAuthorizationHeaderArray()]);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }

    /**
     * Search companies by multiple siren numbers
     * Exact search only
     * 
     * You can specify page size and page number
     * iterate over the pages to get all the results
     * 
     * @param array $sirens
     * @param int $pageSize
     * @param int $page
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompaniesBySiren(array $sirens, int $pageSize = self::DEFAULT_PAGE_SIZE, int $page = 1): array
    {
        // example : https://registre-national-entreprises.inpi.fr/api/companies?siren[0]=889924320&siren[1]=894419969
        try {
            $url = "api/companies?";

            $url = $this->addPageToUrl($url, $page);
            $url = $this->addPageSizeToUrl($url, $pageSize);

            foreach ($sirens as $siren) {
                $url .= "siren[]={$siren}&";
            }

            $response = $this->client->get($url, ['headers' => $this->getAuthorizationHeaderArray()]);
            $data = json_decode($response->getBody(), true);

            // decorate the response to add results count
            $data = $this->decorateResponse($data);

            return $data;
        } catch (\Throwable $e) {
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }

    /**
     * Search companies by their name
     * Contains type search (starts with, contains, ends with)
     * 
     * You can specify page size and page number
     * iterate over the pages to get all the results
     * 
     * @param string $name
     * @param int $pageSize
     * @param int $page
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompaniesByName(string $name, int $pageSize = self::DEFAULT_PAGE_SIZE, int $page = 1): array
    {
        try {
            // error if the name is empty
            if (empty($name)) {
                throw new \Exception('The name is required.');
            }

            $url = "api/companies?";
            $url .= "companyName={$name}&";

            $url = $this->addPageToUrl($url, $page);
            $url = $this->addPageSizeToUrl($url, $pageSize);

            $response = $this->client->get($url, ['headers' => $this->getAuthorizationHeaderArray()]);
            $data = json_decode($response->getBody(), true);

            // decorate the response to add results count
            $data = $this->decorateResponse($data);

            return $data;
        } catch (\Throwable $e) {
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }

    /**
     * Search a company by its submission dates
     * submissionDateFrom (included) and submissionDateTo (not included), at least from is required
     * 
     * You can specify page size and page number
     * iterate over the pages to get all the results
     * 
     * @param string $submissionDateFrom (YYYY-MM-DD format) - included
     * @param ?string $submissionDateTo (YYYY-MM-DD format) - not included
     * @param int $pageSize
     * @param int $page
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompaniesBySubmissionDate(string $submissionDateFrom, ?string $submissionDateTo, int $pageSize = self::DEFAULT_PAGE_SIZE, int $page = 1): array
    {
        try {
            // error if not at least one date is provided
            if (!$submissionDateFrom && !$submissionDateTo) {
                throw new \Exception('At least one date is required. (submissionDateFrom or submissionDateTo)');
            }
            // error if dates format is not valid (YYYY-MM-DD)
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $submissionDateFrom) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $submissionDateTo)) {
                throw new \Exception('Invalid input date format, please use YYYY-MM-DD format.');
            }

            $url = "api/companies?";

            $url = $this->addPageToUrl($url, $page);
            $url = $this->addPageSizeToUrl($url, $pageSize);

            if ($submissionDateFrom) {
                $url .= "submitDateFrom={$submissionDateFrom}&";
            }
            if ($submissionDateTo) {
                $url .= "submitDateTo={$submissionDateTo}&";
            }

            $response = $this->client->get($url, ['headers' => $this->getAuthorizationHeaderArray()]);
            $data = json_decode($response->getBody(), true);

            // decorate the response to add results count
            $data = $this->decorateResponse($data);

            return $data;
        } catch (\Throwable $e) {
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }


    /**
     * Search a single company by its national deposit number
     * 
     * @param string $nationalDepositNumber
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompanyByNationalDepositNumber(string $nationalDepositNumber): array
    {
        try {
            $response = $this->client->get("api/companies?numnat={$nationalDepositNumber}", ['headers' => $this->getAuthorizationHeaderArray()]);
            return json_decode($response->getBody(), true);
        } catch (\Throwable $e) {
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }

    /**
     * Search companies by its activity sector
     * 
     * AGENT_COMMERCIAL
     * AGRICOLE_NON_ACTIF
     * ACTIF_AGRICOLE
     * ARTISANALE
     * ARTISANALE_REGLEMENTEE
     * COMMERCIALE
     * LIBERALE_REGLEMENTEE
     * LIBERALE_NON_REGLEMENTEE
     * GESTION_DE_BIENS
     * SANS_ACTIVITE
     * 
     * You can specify page size and page number
     * iterate over the pages to get all the results
     * 
     * @param string $activitySector
     * @param int $pageSize
     * @param int $page
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompaniesByActivitySector(string $activitySector, int $pageSize = self::DEFAULT_PAGE_SIZE, int $page = 1): array
    {
        try {
            // return error if the activity sector is not valid
            $validActivitySectors = [
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
            if (!in_array($activitySector, $validActivitySectors)) {
                throw new \Exception('Invalid input activity sector, please use one of the following values: ' . implode(', ', $validActivitySectors) . '.');
            }

            $url = "api/companies?";
            $url .= "activitySectors={$activitySector}&";

            $url = $this->addPageToUrl($url, $page);
            $url = $this->addPageSizeToUrl($url, $pageSize);

            $response = $this->client->get($url, ['headers' => $this->getAuthorizationHeaderArray()]);
            $data = json_decode($response->getBody(), true);

            // decorate the response to add results count
            $data = $this->decorateResponse($data);

            return $data;
        } catch (\Throwable $e) {
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }

    /**
     * Search companies by its category code
     * 
     * You can specify page size and page number
     * iterate over the pages to get all the results
     * 
     * @param string $categoryCode
     * @param int $pageSize
     * @param int $page
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompaniesByCategoryCode(string $categoryCode, int $pageSize = self::DEFAULT_PAGE_SIZE, int $page = 1): array
    {
        try {
            // error if the category code is not 8 length number
            if (!preg_match('/^\d{8}$/', $categoryCode)) {
                throw new \Exception('Invalid input category code, please use a 8 length number.');
            }

            $url = "api/companies?";
            $url .= "codeCategory={$categoryCode}&";

            $url = $this->addPageToUrl($url, $page);
            $url = $this->addPageSizeToUrl($url, $pageSize);

            $response = $this->client->get($url, ['headers' => $this->getAuthorizationHeaderArray()]);
            $data = json_decode($response->getBody(), true);

            // decorate the response to add results count
            $data = $this->decorateResponse($data);

            return $data;
        } catch (\Throwable $e) {
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }

    /**
     * Search companies by its zip codes
     * INPI DOCUMENTATION AMBIGUITY WARNING - Seems to be a array of only one zip code (issue with the INPI API)
     * If multiple zip codes are provided to the API, results are not correct
     * 
     * You can specify page size and page number
     * iterate over the pages to get all the results
     * 
     * @param array $zipCodes
     * @param int $pageSize
     * @param int $page
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompaniesByZipCode(string $zipCode, int $pageSize = self::DEFAULT_PAGE_SIZE, int $page = 1): array
    {
        try {
            // error if the zip codes are not valid
            if (!preg_match('/^\d{5}$/', $zipCode)) {
                throw new \Exception('Invalid input zip code, please use a 5 length number.');
            }

            $url = "api/companies?";

            $url = $this->addPageToUrl($url, $page);
            $url = $this->addPageSizeToUrl($url, $pageSize);

            $url .= "zipCodes[]={$zipCode}&";

            $response = $this->client->get($url, ['headers' => $this->getAuthorizationHeaderArray()]);
            $data = json_decode($response->getBody(), true);

            // decorate the response to add results count
            // if page size is reached, we need to indicate there are more results
            // add url of the next request to get the next page

            $data = $this->decorateResponse($data);

            return $data;
        } catch (\Throwable $e) {
            // catch errors from the response
            // TODO: normalize the error message 
            throw $e;
        }
    }

    /**
     * Search a single company old state by its siren and date
     * 
     * @param string $siren
     * @param string $date (YYYY-MM-DD format)
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompanyOldStateBySiren(string $siren, string $date): array
    {
        try {
            $url = "api/companies/{$siren}";

            // error if the date is not valid
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                throw new \Exception('Invalid input date, please use YYYY-MM-DD format.');
            }

            $url .= "?date={$date}";

            $response = $this->client->get($url, ['headers' => $this->getAuthorizationHeaderArray()]);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            // catch errors from the response
            // TODO: normalize the error message 
            throw $e;
        }
    }

    /**
     * add a decoration to the response
     * resultsCount, hasMoreResults, nextPageUrl
     * 
     * @param array $data
     * @param string $url
     * @param int $pageSize
     * 
     * @throws GuzzleException
     * @return array
     */
    private function decorateResponse(array $data, int $pageSize = self::DEFAULT_PAGE_SIZE): array
    {
        // decorate the response to add results count
        // if page size is reached, we need to indicate there are more results
        $dataCount = count($data);
        $decoratedData['resultsCount'] = $dataCount;
        $decoratedData['hasMoreResults'] = false;
        if ($dataCount === $pageSize) $decoratedData['hasMoreResults'] = true;
        $decoratedData['results'] = $data;

        return $decoratedData;
    }

    /**
     * Get the authorization header array
     * 
     * @throws \Exception
     * @return array
     */
    private function getAuthorizationHeaderArray(): array
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
    private function addPageToUrl(string $url, int $page): string
    {
        if ($page < 1) {
            throw new \Exception('Invalid input page, please use a number greater than 0.');
        }
        // check if the url already contains a page parameter
        if (strpos($url, 'page=') !== false) {
            throw new \Exception('The url already contains a page parameter.');
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
    private function addPageSizeToUrl(string $url, int $pageSize): string
    {
        if ($pageSize < 1 || $pageSize > 100) {
            throw new \Exception('Invalid input page size, please use a number between 1 and 100.');
        }
        return $url . "pageSize={$pageSize}&";
    }
}
