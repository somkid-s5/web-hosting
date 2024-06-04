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

$listdata = json_decode($result, true);
curl_close($ch);

require_once "../../config/connectdb.php";
$user_id = 51;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- link bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Domain</th>
                <th scope="col">Due Date</th>
                <th scope="col">Status</th>
                <th scope="col">Used Quota</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $stmp2 = $conn->query("SELECT * FROM service_request  WHERE user_id = $user_id");
            $stmp2->execute();
            $users = $stmp2->fetchAll(PDO::FETCH_ASSOC);

            if (!$users) {
                echo "<p><td colspan='5' class='text-center'>คุณยังไม่มี Host ของคุณใช่ไหม Click </td></p>";
            } else {
                foreach ($users as $user) {
                    if (empty($user['due_date'])) {
                        $formattedDate = 'null';
                    } else {
                        $timestamp = strtotime($user['due_date']);
                        $formattedDate = date('d/m/Y', $timestamp);
                    }

                    // เช็คสถานะใน $listdata และหา $user_quota_used
                    $user_quota_used = null;
                    foreach ($listdata['data'] as $item) {
                        if ($item['name'] === $user['domain'] && $user['status'] === 'Approve') {
                            // หากเจอข้อมูลใน $listdata และสถานะเป็น 'approve'
                            // กำหนดค่า $user_quota_used จากข้อมูลใน $listdata
                            $user_quota_used = $item['values']['server_quota_used'][0];
                            break;
                        }
                    }
            ?>
                    <tr>
                        <td><?php echo $user['domain']; ?></td>
                        <td><?php echo $formattedDate; ?></td>
                        <td><?php echo $user['status']; ?></td>
                        <td><?php echo $user_quota_used === null ? 'Null' : 'Use Quota: ' . $user_quota_used; ?></td>
                        <td>
                            <button class="btn btn-warning" onclick="openRenewalModal('<?php echo $user['service_id']; ?>','<?php echo $user['domain']; ?>','<?php echo $formattedDate; ?>')">Renewal</button>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>

</body>

</html>
