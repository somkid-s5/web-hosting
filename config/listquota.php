<?php
require_once 'connectdb.php';
$virtualminUrl  = "http://localhost:444/virtual-server/remote.cgi";
$virtualminUser  = "admin123";
$virtualminPass  = "admin123";

// Set up cURL session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $virtualminUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$virtualminUser:$virtualminPass");

// Example: List all domains
$data_option = [
    'program' => 'list-domains',
    'json' => '1',
    'multiline' => '',
];

curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_option));

$result = curl_exec($ch);
curl_close($ch);

$data_array = json_decode($result, true);
$data = $data_array;


$user_id = 64;
$stmp2 = $conn->query("SELECT * FROM service_request  WHERE user_id = $user_id");
$stmp2->execute();
$users = $stmp2->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">My Domain</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">Domain</th>
                            <th scope="col">Used Quota</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (!$users) {
                            echo "<p><td colspan='5' class='text-center'>คุณยังไม่มี Host ของคุณใช่ไหมกดที่ Add Host ได้เลย</td></p>";
                        } else {
                            foreach ($users as $user) {
                                // เช็คสถานะใน $listdata และหา $user_quota_used
                                $user_quota_used = null;
                                $user_server_quota = null;
                                foreach ($data['data'] as $item) {
                                    if ($item['name'] === $user['domain'] && $user['status'] === 'Approve') {
                                        // หากเจอข้อมูลใน $listdata และสถานะเป็น 'approve'
                                        // กำหนดค่า $user_quota_used จากข้อมูลใน $listdata
                                        $user_quota_used = $item['values']['server_quota_used'][0];
                                        $user_server_quota = $item['values']['server_quota'][0];
                                        break;
                                    }
                                }
                        ?>
                                <tr>
                                    <td><?php echo $user['domain']; ?></td>
                                    <td><?php echo $user_quota_used === null ? 'Null' : 'use quota: ' . $user_quota_used . '<br>' . 'disk quota: ' . $user_server_quota; ?></td>
                                </tr>

                        <?php }
                        } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>