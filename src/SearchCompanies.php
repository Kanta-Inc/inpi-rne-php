<?php

namespace RNEClient;

use GuzzleHttp\Exception\GuzzleException;

/**
 * Class SearchCompanies
 *
 * @package RNEClient
 */
class SearchCompanies extends RNEClient implements SearchCompaniesInterface
{

    /**
     * Search a company by its siren number
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
        return $this->requestApi("get", "api/companies/{$siren}", ['headers' => $this->getAuthorizationHeaderArray()]);
    }

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
        return $this->requestApi('get', "api/companies?numnat={$nationalDepositNumber}", ['headers' => $this->getAuthorizationHeaderArray()]);
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
    public function searchOldStateBySiren(string $siren, string $date): array
    {
        $url = "api/companies/{$siren}";

        // error if the date is not valid
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            throw new \Exception('Invalid input date, please use YYYY-MM-DD format.');
        }

        $url .= "?date={$date}";

        return $this->requestApi('get', $url, ['headers' => $this->getAuthorizationHeaderArray()]);
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
    public function searchByMultipleSiren(array $sirens, int $pageSize = self::DEFAULT_PAGE_SIZE, int $page = 1): array
    {
        $url = "api/companies?";

        $url = $this->addPageToUrl($url, $page);
        $url = $this->addPageSizeToUrl($url, $pageSize);

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
    public function searchByName(string $name, int $pageSize = self::DEFAULT_PAGE_SIZE, int $page = 1): array
    {
        $url = "api/companies?";
        $url .= "companyName={$name}&";

        $url = $this->addPageToUrl($url, $page);
        $url = $this->addPageSizeToUrl($url, $pageSize);

        $data = $this->requestApi('get', $url, ['headers' => $this->getAuthorizationHeaderArray()]);

        // decorate the response to add results count
        $data = $this->decorateResponse($data);

        return $data;
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
    public function searchBySubmissionDate(string $submissionDateFrom, ?string $submissionDateTo, int $pageSize = self::DEFAULT_PAGE_SIZE, int $page = 1): array
    {
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

        $data = $this->requestApi('get', $url, ['headers' => $this->getAuthorizationHeaderArray()]);

        // decorate the response to add results count
        $data = $this->decorateResponse($data);

        return $data;
    }

    /**
     * Search companies by its activity sector
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
    public function searchByActivitySector(string $activitySector, int $pageSize = self::DEFAULT_PAGE_SIZE, int $page = 1): array
    {
        // return error if the activity sector is not valid
        if (!in_array($activitySector, self::VALID_ACTIVITY_SECTORS)) {
            throw new \Exception('Invalid input activity sector, please use one of the following values: ' . implode(', ', self::VALID_ACTIVITY_SECTORS) . '.');
        }

        $url = "api/companies?";
        $url .= "activitySectors={$activitySector}&";

        $url = $this->addPageToUrl($url, $page);
        $url = $this->addPageSizeToUrl($url, $pageSize);

        $data = $this->requestApi('get', $url, ['headers' => $this->getAuthorizationHeaderArray()]);

        // decorate the response to add results count
        $data = $this->decorateResponse($data);

        return $data;
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
    public function searchByCategoryCode(string $categoryCode, int $pageSize = self::DEFAULT_PAGE_SIZE, int $page = 1): array
    {
        $categoryCodes = CategoryCodes::getCategoryCodes();

        // error if the category code is not in the array
        if (!in_array($categoryCode, $categoryCodes)) {
            throw new \Exception('Invalid input category code, please use a valid category code.');
        }

        $url = "api/companies?";
        $url .= "codeCategory={$categoryCode}&";

        $url = $this->addPageToUrl($url, $page);
        $url = $this->addPageSizeToUrl($url, $pageSize);

        $data = $this->requestApi('get', $url, ['headers' => $this->getAuthorizationHeaderArray()]);

        // decorate the response to add results count
        $data = $this->decorateResponse($data);

        return $data;
    }

    /**
     * Search companies by its zip codes
     * INPI DOCUMENTATION AMBIGUITY WARNING - Seems to be a array of only one zip code (issue with the INPI API)
     * If multiple zip codes are provided to the API, results are not correct
     *
     * You can specify page size and page number
     * iterate over the pages to get all the results
     *
     * @param string $zipCode
     * @param int $pageSize
     * @param int $page
     *
     * @throws GuzzleException
     * @return array
     */
    public function searchByZipCode(string $zipCode, int $pageSize = self::DEFAULT_PAGE_SIZE, int $page = 1): array
    {
        // error if the zip codes are not valid
        if (!preg_match('/^\d{5}$/', $zipCode)) {
            throw new \Exception('Invalid input zip code, please use a 5 length number.');
        }

        $url = "api/companies?";

        $url = $this->addPageToUrl($url, $page);
        $url = $this->addPageSizeToUrl($url, $pageSize);

        $url .= "zipCodes[]={$zipCode}&";

        $data = $this->requestApi('get', $url, ['headers' => $this->getAuthorizationHeaderArray()]);

        // decorate the response to add results count
        // if page size is reached, we need to indicate there are more results
        // add url of the next request to get the next page

        $data = $this->decorateResponse($data);

        return $data;
    }
}
