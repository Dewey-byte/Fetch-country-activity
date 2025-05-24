<?php 
header('Content-Type: application/json');

if (!isset($_GET['country']) || empty(trim($_GET['country']))) {
    echo json_encode(['error' => 'No country specified.']);
    exit;
}

$country = urlencode($_GET['country']);
$url = "https://restcountries.com/v3.1/name/$country";

// Use cURL instead of file_get_contents
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['error' => 'Failed to fetch country data.']);
    curl_close($ch);
    exit;
}

curl_close($ch);
$data = json_decode($response, true);

// Check if valid data is returned
if (!$data || isset($data['status'])) {
    echo json_encode(['error' => 'Country not found.']);
    exit;
}

$countryData = $data[0];
echo json_encode([
    'name' => $countryData['name']['common'] ?? 'N/A',
    'capital' => $countryData['capital'][0] ?? 'N/A',
    'region' => $countryData['region'] ?? 'N/A',
    'flags' => $countryData['flags']['png'] ?? ''
]);
?>
