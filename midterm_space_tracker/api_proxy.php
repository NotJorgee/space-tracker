<?php
header('Content-Type: application/json');

$type = isset($_GET['type']) ? $_GET['type'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($type === 'station') {
    // N2YO API for Space Stations
    $apiKey = '47JGS3-JXUL2E-ZQD8K6-5PIJ'; // Make sure your key is still here!
    $lat = 11.0050; $lng = 124.6075; $alt = 0; // Ormoc City
    $apiUrl = "https://api.n2yo.com/rest/v1/satellite/visualpasses/{$id}/{$lat}/{$lng}/{$alt}/2/300/&apiKey={$apiKey}";
    
    $response = @file_get_contents($apiUrl);
    echo $response ? $response : json_encode(['error' => 'N2YO API failed. Please check your API key.']);
    
} elseif ($type === 'planet') {
    // The Solar System API requires strictly lowercase IDs without spaces
    $cleanId = urlencode(strtolower(trim($id)));
    $apiUrl = "https://api.le-systeme-solaire.net/rest/bodies/{$cleanId}";
    
    // Some APIs reject requests that don't have a User-Agent header. We add one here.
    $options = [
        'http' => [
            'method' => "GET",
            'header' => "User-Agent: PHP-SpaceTracker/1.0\r\n"
        ]
    ];
    $context = stream_context_create($options);
    
    $response = @file_get_contents($apiUrl, false, $context);
    
    echo $response ? $response : json_encode(['error' => 'Solar System API failed. Ensure the reference ID is a valid planet name (e.g., mars, jupiter).']);
} else {
    echo json_encode(['error' => 'Invalid object type specified.']);
}
?>