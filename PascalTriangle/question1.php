<!-- Muqri Moss Submission Question #1 -->

<?php

// API Key and Base URL definitions
define('API_KEY', 'e95a0ce7-cd1d-4057-a951-1ebea71315f9'); 
define('BASE_URL', 'https://assessment.takafulbrunei.com/v1');

// Function to generate Pascal's Triangle
function generatePascalsTriangle($rows)
{
    $triangle = [];
    for ($i = 0; $i < $rows; $i++) {
        $triangle[$i] = [1];
        for ($j = 1; $j < $i; $j++) {
            $triangle[$i][$j] = $triangle[$i - 1][$j - 1] + $triangle[$i - 1][$j];
        }
        if ($i > 0) $triangle[$i][] = 1;
    }
    return $triangle;
}

// Function to make API calls
function callAPI($method, $endpoint, $data = null)
{
    $curl = curl_init();
    $headers = [
        'x-api-key: ' . API_KEY,
        'Content-Type: application/json'
    ];

    curl_setopt($curl, CURLOPT_URL, BASE_URL . $endpoint);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    if ($method === 'POST' && $data) {
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

// Data from the response you provided
$id = "549be0ad-80ec-43c1-8319-c7eef3b77c51";
$numRows = 10;

// Step 1: Generate Pascal's Triangle
$triangle = generatePascalsTriangle($numRows);

// Step 2: Prepare payload for submission
$payload = [
    "id" => $id,
    "answer" => $triangle
];

// Step 3: Submit the answer
$response = callAPI('POST', '/question/1', $payload);

// Step 4: Output the response
echo "API Response: " . json_encode($response, JSON_PRETTY_PRINT);

?>