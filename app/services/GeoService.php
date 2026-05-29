<?php

class GeoService {

    private float $bordeauxLat;
    private float $bordeauxLng;

    public function __construct() {
        $this->bordeauxLat = (float) getenv('ORS_BORDEAUX_LAT');
        $this->bordeauxLng = (float) getenv('ORS_BORDEAUX_LNG');
    }

    public function geocode(string $adresse): array {
        $url = 'https://nominatim.openstreetmap.org/search'
        . '?q=' . urlencode($adresse)
        . '&format=json'
        . '&limit=1'
        . '&countrycodes=fr';

        $context = stream_context_create([
            'http' => ['timeout' => 10,
            'header' => 'User-Agent: ViteEtGourmand/1.0'
            ]
        ]);
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            throw new Exception("Erreur lors de l'appel à l'API de géocodage.");
        }

        $data = json_decode($response, true);

        if (empty($data)) {
            throw new Exception("Adresse introuvable : " . $adresse);
        }

        return [
            'lng' => (float) $data[0]['lon'],
            'lat' => (float) $data[0]['lat']
        ];
    }

    public function getDistanceKm(float $latDest, float $lngDest): float {
        $url = 'http://router.project-osrm.org/route/v1/driving/'
            . $this->bordeauxLng . ',' . $this->bordeauxLat
            . ';'
            . $lngDest . ',' . $latDest
            . '?overview=false';

        $context = stream_context_create([
            'http' => ['timeout' => 10]
        ]);

        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            throw new Exception("Erreur lors du calcul de distance.");
        }

        $data = json_decode($response, true);

        return (float) ($data['routes'][0]['distance'] / 1000);
    }
}