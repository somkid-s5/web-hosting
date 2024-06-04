<?php
$virtualminUrl  = "http://192.168.111.100:443/virtual-server/remote.cgi";
$virtualminUser  = "admin123";
$virtualminPass  = "admin123";

// Set up cURL session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $virtualminUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$virtualminUser:$virtualminPass");

// Example: List all domains
$data = [
    'program' => 'list-domains',
    'json' => '1',
    'multiline' => '',
];

curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

$result = curl_exec($ch);
if (!$result) {
    die('Error: ' . curl_error($ch));
}

$data = json_decode($result, true);
curl_close($ch);

function displayData($data, $indent = 0)
{
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            echo str_repeat("  ", $indent) . "<strong>$key:</strong><br>";
            echo "<ul>";
            displayData($value, $indent + 1);
            echo "</ul>";
        } else {
            echo str_repeat("  ", $indent) . "<li><strong>$key:</strong> $value</li>";
        }
    }
}

echo "<ul>";
displayData($data);
echo "</ul>";

?>