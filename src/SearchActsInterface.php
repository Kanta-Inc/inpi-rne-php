<?php

namespace RNEClient;

interface SearchActsInterface
{
    public function searchBySiren(string $siren): array;
    public function getMetadataById(string $id): array;
    public function getFileById(string $id): string;
}
