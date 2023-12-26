<?php

namespace InpiRNEClient;

interface InpiRNEClientInterface
{
    public function authenticate($username, $password);
    public function getToken();
    public function searchCompany($siren);
    // Ajoutez d'autres méthodes publiques nécessaires pour interagir avec l'API
}