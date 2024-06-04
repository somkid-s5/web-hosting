<?php

// datadomain array 
$age = array("user1.jeethost.com, user2.jeethost.com, user3.jeethost.com, user4.jeedhost.com, user5.jeedhost.com");

function getDomain($domain) {
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
        'domain' => $domain,
        'multiline' => '',
    ];

    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    return $ch;
}

// Create a multi-curl handle
$multiCurl = curl_multi_init();

// Initialize an array to store cURL handles for each request
$curlHandles = [];

foreach($age as $x => $x_value) {
    $ch = getDomain($x_value);
    $curlHandles[] = $ch;
    curl_multi_add_handle($multiCurl, $ch);
}

// Execute all cURL requests simultaneously
do {
    curl_multi_exec($multiCurl, $active);
} while ($active > 0);
?>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Domain</th>
            <th>Quota</th>
        </tr>
    </thead>
    <tbody>

        <?php
        // Process the results
        foreach($curlHandles as $ch) {
            $result = curl_multi_getcontent($ch);

            if ($result) {
                $data = json_decode($result, true);
                $domainData = $data['data'][0]['values'];
                echo '<tr>';
                echo '<td>' . $x . '</td>';
                echo '<td>' . $domainData['server_quota_used'][0] . '/' . $domainData['server_quota'][0] . '</td>';
                echo '</tr>';
            } else {
                // Handle errors if needed
            }

            curl_multi_remove_handle($multiCurl, $ch);
            curl_close($ch);
        }

        // Close the multi-curl handle
        curl_multi_close($multiCurl);

        ?>
    </tbody>

</table>
