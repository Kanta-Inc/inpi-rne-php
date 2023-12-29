<?php

namespace RNEClient;

interface SearchCompaniesInterface
{
    /**
     * single company search
     */
    public function searchBySiren(string $siren): array;
    public function searchByNationalDepositNumber(string $nationalDepositNumber): array;
    public function searchOldStateBySiren(string $siren, string $date): array;
    /**
     * multiple companies search
     */
    public function searchByMultipleSiren(array $sirens, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, int $page = 1): array;
    public function searchByName(string $name, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, int $page = 1): array;
    public function searchBySubmissionDate(string $submissionDateFrom, ?string $submissionDateTo, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, int $page = 1): array;
    public function searchByActivitySector(string $activitySector, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, int $page = 1): array;
    public function searchByCategoryCode(string $categoryCode, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, int $page = 1): array;
    public function searchByZipCode(string $zipCode, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, int $page = 1): array;
}
