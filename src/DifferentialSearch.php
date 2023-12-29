<?php

namespace RNEClient;

use GuzzleHttp\Exception\GuzzleException;

/**
 * Class DifferentialSearch
 *
 * @package RNEClient
 */
class DifferentialSearch extends RNEClient implements DifferentialSearchInterface
{
    /**
     * Search a single company by its national deposit number
     *
     * @param string $nationalDepositNumber
     *
     * @throws GuzzleException
     * @return array
     */
    public function searchByNationalDepositNumber(string $nationalDepositNumber): array
    {
        return $this->requestApi('get', "api/companies/diff?numnat={$nationalDepositNumber}", ['headers' => $this->getAuthorizationHeaderArray()]);
    }

    /**
     * Search multiple companies by their siren numbers
     *
     * @param array $sirens
     * @param string $dateFrom
     * @param string|null $dateTo
     * @param int $pageSize
     * @param string|null $searchAfter
     *
     * @throws GuzzleException
     * @throws \Exception
     * @return array
     */
    public function searchByMultipleSiren(array $sirens, string $dateFrom, ?string $dateTo, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, ?string $searchAfter = null): array
    {
        // error if dates format is not valid (YYYY-MM-DD)
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFrom) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateTo)) {
            throw new \Exception('Invalid input date format, please use YYYY-MM-DD format.');
        }

        $url = "api/companies/diff?";

        $url = $this->addSearchAfterToUrl($url, $searchAfter);
        $url = $this->addPageSizeToUrl($url, $pageSize);
        $url .= "from={$dateFrom}&to={$dateTo}";

        foreach ($sirens as $siren) {
            // error if the siren is not 9 length number
            if (!preg_match('/^\d{9}$/', $siren)) {
                throw new \Exception('Invalid input siren, please use a 9 length number.');
            }
            $url .= "siren[]={$siren}&";
        }

        $data = $this->requestApi('get', $url, ['headers' => $this->getAuthorizationHeaderArray()]);

        // decorate the response to add results count
        $data = $this->decorateResponse($data);

        return $data;
    }

    /**
     * Search companies by their name
     *
     * @param string $name
     * @param int $pageSize
     * @param string|null $searchAfter
     *
     * @throws GuzzleException
     * @throws \Exception
     * @return array
     */
    public function searchByName(string $name, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, ?string $searchAfter): array
    {
        $url = "api/companies/diff?";

        $url = $this->addSearchAfterToUrl($url, $searchAfter);
        $url = $this->addPageSizeToUrl($url, $pageSize);

        $url .= "name={$name}";

        $data = $this->requestApi('get', $url, ['headers' => $this->getAuthorizationHeaderArray()]);

        // decorate the response to add results count
        $data = $this->decorateResponse($data);

        return $data;
    }

    public function searchByDate(string $dateFrom, ?string $dateTo, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, ?string $searchAfter): array
    {
        // error if dates format is not valid (YYYY-MM-DD)
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFrom) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateTo)) {
            throw new \Exception('Invalid input date format, please use YYYY-MM-DD format.');
        }

        $url = "api/companies/diff?";

        $url = $this->addSearchAfterToUrl($url, $searchAfter);
        $url = $this->addPageSizeToUrl($url, $pageSize);

        $url .= "from={$dateFrom}&to={$dateTo}";

        $data = $this->requestApi('get', $url, ['headers' => $this->getAuthorizationHeaderArray()]);

        // decorate the response to add results count
        $data = $this->decorateResponse($data);

        return $data;
    }

    public function searchByActivitySector(string $activitySector, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, ?string $searchAfter): array
    {
        // return error if the activity sector is not valid
        if (!in_array($activitySector, self::VALID_ACTIVITY_SECTORS)) {
            throw new \Exception('Invalid input activity sector, please use one of the following values: ' . implode(', ', self::VALID_ACTIVITY_SECTORS) . '.');
        }

        $url = "api/companies/diff?";

        $url = $this->addSearchAfterToUrl($url, $searchAfter);
        $url = $this->addPageSizeToUrl($url, $pageSize);

        $url .= "activitySector={$activitySector}";

        $data = $this->requestApi('get', $url, ['headers' => $this->getAuthorizationHeaderArray()]);

        // decorate the response to add results count
        $data = $this->decorateResponse($data);

        return $data;
    }

    public function searchByCategoryCode(string $categoryCode, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, ?string $searchAfter): array
    {
        // error if the category code is not 8 length number
        if (!preg_match('/^\d{8}$/', $categoryCode)) {
            throw new \Exception('Invalid input category code, please use a 8 length number.');
        }

        $url = "api/companies/diff?";

        $url = $this->addSearchAfterToUrl($url, $searchAfter);
        $url = $this->addPageSizeToUrl($url, $pageSize);

        $url .= "categoryCode={$categoryCode}";

        $data = $this->requestApi('get', $url, ['headers' => $this->getAuthorizationHeaderArray()]);

        // decorate the response to add results count
        $data = $this->decorateResponse($data);

        return $data;
    }

    /**
     * Search companies by their zip code
     *
     * @param string $zipCode
     * @param int $pageSize
     * @param string|null $searchAfter
     *
     * @throws GuzzleException
     * @throws \Exception
     * @return array
     */
    public function searchByZipCode(string $zipCode, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, ?string $searchAfter): array
    {
        // error if the zip codes are not valid
        if (!preg_match('/^\d{5}$/', $zipCode)) {
            throw new \Exception('Invalid input zip code, please use a 5 length number.');
        }

        $url = "api/companies/diff?";

        $url = $this->addSearchAfterToUrl($url, $searchAfter);
        $url = $this->addPageSizeToUrl($url, $pageSize);

        $url .= "zipCode={$zipCode}";

        $data = $this->requestApi('get', $url, ['headers' => $this->getAuthorizationHeaderArray()]);

        // decorate the response to add results count
        $data = $this->decorateResponse($data);

        return $data;
    }

    /**
     * Add the search after parameter to the url
     *
     * @param string $url
     * @param string|null $searchAfter
     *
     * @return string
     */
    protected function addSearchAfterToUrl(string $url, ?string $searchAfter): string
    {
        if ($searchAfter) {
            $url .= "searchAfter={$searchAfter}&";
        }
        return $url;
    }
}
