<?php

namespace RNEClient;

interface DifferentialSearchInterface
{
    /**
     * single company search
     */
    public function searchByNationalDepositNumber(string $nationalDepositNumber): array;
    /**
     * multiple companies search
     */
    public function searchByMultipleSiren(array $sirens, string $dateFrom, ?string $dateTo, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, ?string $searchAfter = null): array;
    public function searchByName(string $name, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, ?string $searchAfter): array;
    public function searchByDate(string $dateFrom, ?string $dateTo, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, ?string $searchAfter): array;
    public function searchByActivitySector(string $activitySector, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, ?string $searchAfter): array;
    public function searchByCategoryCode(string $categoryCode, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, ?string $searchAfter): array;
    public function searchByZipCode(string $zipCode, int $pageSize = RNEClient::DEFAULT_PAGE_SIZE, ?string $searchAfter): array;
}
