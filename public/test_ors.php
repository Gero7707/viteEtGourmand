<?php
session_start();
require_once __DIR__ . '/../app/services/GeoService.php';

$ors = new GeoService();

try {
    // Test géocodage
    $adresse = '15 Rue de la Paix, 75002 Paris';
    $coords = $ors->geocode($adresse);
    echo "Coordonnées : lat=" . $coords['lat'] . " lng=" . $coords['lng'] . "<br>";

    // Test distance
    $distance = $ors->getDistanceKm($coords['lat'], $coords['lng']);
    echo "L'adresse : ". $adresse . " est à " . $distance . " km de  Vite & Gourmand : " ;

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}