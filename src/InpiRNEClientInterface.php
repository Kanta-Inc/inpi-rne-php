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
    public function searchCompaniesBySiren(array $sirens): array;
    public function searchCompaniesByName(string $name): array;
    public function searchCompaniesBySubmissionDate(string $submissionDateFrom, ?string $submissionDateTo): array;
    public function searchCompaniesByActivitySector(string $activitySector): array;
    public function searchCompaniesByCategoryCode(string $categoryCode): array;
    public function searchCompaniesByZipCode(string $zipCode): array;
}
