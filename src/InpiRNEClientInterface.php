<?php

namespace InpiRNEClient;

interface InpiRNEClientInterface
{
    public function authenticate($username, $password);
    public function getToken();
    public function searchCompanyBySiren(string $siren): array;
    public function searchCompaniesBySiren(array $sirens): array;
    public function searchCompanyByZipCode(string $zipCode): array;
}