<?php

namespace RNEClient;

interface SearchFinancialStatementsInterface 
{
    public function searchBySiren(string $siren): array;
    public function getDataById(string $id): array;
    public function getMetadataById(string $id): array;
    public function getFileById(string $id): string;
}