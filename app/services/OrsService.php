<?php

class OrsService {

    private string $apiKey;
    private float $bordeauxLat;
    private float $bordeauxLng;

    public function __construct() {
        $this->apiKey = getenv('ORS_API_KEY');
        $this->bordeauxLat = (float) getenv('ORS_BORDEAUX_LAT');
        $this->bordeauxLng = (float) getenv('ORS_BORDEAUX_LNG');
    }

    public function geocode(string $adresse): array {
        $url = 'https://api.openrouteservice.org/geocode/search'
        . '?api_key=' . $this->apiKey
        . '&text=' . urlencode($adresse)
        . '&boundary.country=FR'
        . '&size=1';

        $response = file_get_contents($url);

        if ($response === false) {
            throw new Exception("Erreur lors de l'appel à l'API de géocodage.");
        }

        $data = json_decode($response, true);

        if (empty($data['features'])) {
            throw new Exception("Adresse introuvable : " . $adresse);
        }

        $coords = $data['features'][0]['geometry']['coordinates'];

        return [
            'lng' => $coords[0],
            'lat' => $coords[1]
        ];
    }

    public function getDistanceKm(float $latDest, float $lngDest): float {
        $url = 'https://api.openrouteservice.org/v2/matrix/driving-car';

        $body = [
            'locations' => [
                [$this->bordeauxLng, $this->bordeauxLat],
                [$lngDest, $latDest]
            ],
            'metrics' => ['distance'],
            'units' => 'km'
        ];

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\nAuthorization: " . $this->apiKey,
                'content' => json_encode($body)
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            throw new Exception("Erreur lors du calcul de distance.");
        }

        $data = json_decode($response, true);

        return (float) $data['distances'][0][1];
    }
}