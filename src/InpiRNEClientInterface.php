<?php

namespace InpiRNEClient;

interface InpiRNEClientInterface
{
    /**
     * authentication
     */
    public function authenticate(string $username, string $password): void;
    public function getToken(): string;
    /**
     * single company search
     */
    public function searchCompanyBySiren(string $siren): array;
    public function searchCompanyByNationalDepositNumber(string $nationalDepositNumber): array;
    public function searchCompanyOldStateBySiren(string $siren, string $date): array;
    /**
     * multiple companies search
     */
    public function searchCompaniesBySiren(array $sirens, int $pageSize = InpiRNEClient::DEFAULT_PAGE_SIZE, int $page = 1): array;
    public function searchCompaniesByName(string $name, int $pageSize = InpiRNEClient::DEFAULT_PAGE_SIZE, int $page = 1): array;
    public function searchCompaniesBySubmissionDate(string $submissionDateFrom, ?string $submissionDateTo, int $pageSize = InpiRNEClient::DEFAULT_PAGE_SIZE, int $page = 1): array;
    public function searchCompaniesByActivitySector(string $activitySector, int $pageSize = InpiRNEClient::DEFAULT_PAGE_SIZE, int $page = 1): array;
    public function searchCompaniesByCategoryCode(string $categoryCode, int $pageSize = InpiRNEClient::DEFAULT_PAGE_SIZE, int $page = 1): array;
    public function searchCompaniesByZipCode(string $zipCode, int $pageSize = InpiRNEClient::DEFAULT_PAGE_SIZE, int $page = 1): array;
}
