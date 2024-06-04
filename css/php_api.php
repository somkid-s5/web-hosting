<?php
function get_domain_list()
{
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
        'domain' => 'user1.jeedhost.com',
        'multiline' => '',
    ];
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    
    $result = curl_exec($ch);
    if (!$result) {
        die('Error: ' . curl_error($ch));
    }
    
    $data = json_decode($result, true);

    $used_quota =  $data['data'][0]['values']['server_quota_used'][0];
    $servere_quota = ['data'][0]['values']['server_quota'][0];
    
    curl_close($ch);
}
