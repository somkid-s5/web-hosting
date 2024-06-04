<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    require_once '../../config/connectdb.php';

    $stmt_s_of = $conn->query("SELECT service_request.*, users.name FROM service_request INNER JOIN users ON service_request.user_id = users.user_id WHERE service_request.status = 'Pending'");
    $stmt_s_of->execute();
    $row_VSof = $stmt_s_of->fetchAll(PDO::FETCH_ASSOC);
//if error query
    if ($row_VSof === false) {
        die('Error');
        echo "$row_VSof";
    } else {
        echo "yes";
        foreach ($row_VSof as $row) {
            echo $row['password'];
        }

    }

    ?>
</body>

</html>