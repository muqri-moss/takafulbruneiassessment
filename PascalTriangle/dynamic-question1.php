<!-- Muqri Moss Submission Question #1 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Pascal's Triangle</title>
</head>
<body>
    <h1>Pascal's Triangle Payload Generator</h1>
    <form method="POST">
        <label for="id">Enter ID:</label><br>
        <input type="text" id="id" name="id" required><br><br>

        <label for="numRows">Enter Number of Rows:</label><br>
        <input type="number" id="numRows" name="numRows" required><br><br>

        <button type="submit">Generate Payload</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get inputs from the form
        $id = htmlspecialchars($_POST['id']);
        $numRows = intval($_POST['numRows']);

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

        // Generate Pascal's Triangle
        $triangle = generatePascalsTriangle($numRows);

        // Prepare the payload
        $payload = [
            "id" => $id,
            "answer" => $triangle
        ];

        // Display the payload
        echo "<h2>Generated Payload</h2>";
        echo "<pre>" . json_encode($payload, JSON_PRETTY_PRINT) . "</pre>";

        // function to submit the answer
        
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

        $response = callAPI('POST', '/question/1', $payload);
        echo "<h2>API Response</h2>";
        echo "<pre>" . json_encode($response, JSON_PRETTY_PRINT) . "</pre>";

    }
    ?>
</body>
</html>
