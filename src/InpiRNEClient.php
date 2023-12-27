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

    /**
     * InpiRNEClient constructor.
     * If a token is provided, it will be used for the requests
     * Otherwise, the user will have to authenticate first
     * 
     * @param string|null $token
     */
    public function __construct(?string $token = null)
    {
        $this->client = new Client(['base_uri' => 'https://registre-national-entreprises.inpi.fr/']);
        $this->token = $token;
    }

    /**
     * Authentify the user and store the token in the client
     * 
     * @param $username
     * @param $password
     * 
     * @throws GuzzleException
     * @return void
     */
    public function authenticate($username, $password): void
    {
        try {
            $this->token = null;
            $response = $this->client->post('api/sso/login', [
                'json' => [
                    'username' => $username,
                    'password' => $password
                ]
            ]);
            $data = json_decode($response->getBody(), true);
            $this->token = $data['token'];
        } catch (GuzzleException $e) {
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
            $response = $this->client->get("api/companies/{$siren}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token
                ]
            ]);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }

    /**
     * Search a company by multiple siren numbers
     * Exact search only
     * 
     * @param array $sirens
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompaniesBySiren(array $sirens): array
    {
        // example : https://registre-national-entreprises.inpi.fr/api/companies?siren[0]=889924320&siren[1]=894419969
        try {
            $url = "api/companies?";
            foreach ($sirens as $siren) {
                $url .= "siren[]={$siren}&";
            }

            $response = $this->client->get($url);
            return json_decode($response->getBody(), true);
        } catch (\Throwable $e) {
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }

    /**
     * Search a company by its name
     * Contains type search (starts with, contains, ends with)
     * 
     * @param string $name
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompanyByName(string $name): array
    {
        // example : https://registre-national-entreprises.inpi.fr/api/companies?companyName=Grinto
        try {
            // error if the name is empty
            if (empty($name)) {
                throw new \Exception('The name is required.');
            }

            $response = $this->client->get("api/companies?companyName={$name}");
            return json_decode($response->getBody(), true);
        } catch (\Throwable $e) {
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }

    /**
     * Search a company by its submission dates
     * submissionDateFrom (included) and submissionDateTo (not included), at least one is required
     * 
     * @param string $submissionDateFrom (YYYY-MM-DD format) - included
     * @param string $submissionDateTo (YYYY-MM-DD format) - not included
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompanyBySubmissionDate(string $submissionDateFrom, string $submissionDateTo): array
    {
        // example : https://registre-national-entreprises.inpi.fr/api/companies?submissionDateFrom=2021-01-01&submissionDateTo=2021-12-31
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
            if ($submissionDateFrom) {
                $url .= "submitDateFrom={$submissionDateFrom}&";
            }
            if ($submissionDateTo) {
                $url .= "submitDateTo={$submissionDateTo}&";
            }
            $response = $this->client->get($url);
            return json_decode($response->getBody(), true);
        } catch (\Throwable $e) {
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }


    /**
     * Search a company by its national deposit number
     * 
     * @param string $nationalDepositNumber
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompanyByNationalDepositNumber(string $nationalDepositNumber): array
    {
        try {
            $response = $this->client->get("api/companies?numnat={$nationalDepositNumber}");
            return json_decode($response->getBody(), true);
        } catch (\Throwable $e) {
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }

    /**
     * Search a company by its activity sector
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
     * @param string $activitySector
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompanyByActivitySector(string $activitySector): array
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

            $response = $this->client->get("api/companies?activitySectors={$activitySector}");
            return json_decode($response->getBody(), true);
        } catch (\Throwable $e) {
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }

    /**
     * Search a company by its category code
     * 
     * @param string $categoryCode
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompanyByCategoryCode(string $categoryCode): array
    {
        try {
            // error if the category code is not 8 length number
            if (!preg_match('/^\d{8}$/', $categoryCode)) {
                throw new \Exception('Invalid input category code, please use a 8 length number.');
            }

            $response = $this->client->get("api/companies?codeCategory={$categoryCode}");
            return json_decode($response->getBody(), true);
        } catch (\Throwable $e) {
            // catch errors from the response
            // TODO: normalize the error message
            throw $e;
        }
    }

    /**
     * Search a company by its zip codes
     * WARNING - Seems to be a array of only on zip code (issue with the INPI API)
     * 
     * @param array $zipCodes
     * 
     * @throws GuzzleException
     * @return array
     */
    public function searchCompanyByZipCode(string $zipCode): array
    {
        try {
            // error if the zip codes are not valid
            if (!preg_match('/^\d{5}$/', $zipCode)) {
                throw new \Exception('Invalid input zip code, please use a 5 length number.');
            }

            $url = "api/companies?";
            $url .= "zipCodes[]={$zipCode}&";

            $response = $this->client->get($url);

            $data = json_decode($response->getBody(), true);

            // decorate the response to add results count
            // if page size is reached, we need to indicate there are more results
            // add url of the next request to get the next page

            $data = $this->decorateResponse($data, $url);

            return $data;
        } catch (\Throwable $e) {
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
    private function decorateResponse(array $data, string $url, int $pageSize = self::DEFAULT_PAGE_SIZE): array
    {
        // decorate the response to add results count
        // if page size is reached, we need to indicate there are more results
        // add url of the next request to get the next page
        $dataCount = count($data);
        $decoratedData = [
            'resultsCount' => $dataCount,
            'results' => $data
        ];

        if ($dataCount === $pageSize) {
            $decoratedData['hasMoreResults'] = true;

            $query = parse_url($url, PHP_URL_QUERY);
            parse_str($query, $queryParams);
            // extract the page number from the url
            $pageNumber = $queryParams['page'] ?? null;

            if ($pageNumber) {
                $nextQueryParams['page'] = $pageNumber + 1;
            } else {
                $nextQueryParams['page'] = 2;
            }


            $decoratedData['nextPageUrl'] = $url . '?' . http_build_query($nextQueryParams);
        } else if ($dataCount < $pageSize) {
            $decoratedData['hasMoreResults'] = false;
        } else {
            throw new \Exception('WTF - The number of results is greater than the page size.');
        }

        return $decoratedData;
    }
}
