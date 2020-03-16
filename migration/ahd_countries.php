<?php

header('Content-Type: text/html; charset=utf-8');


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
$dbname_new = "pwd";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn_new = mysqli_connect($servername, $username, $password, $dbname_new);
echo "remove die function";
die();
mysqli_set_charset($conn, "utf8");
mysqli_set_charset($conn_new, "utf8");


$language[1] = 'name_en';
$language[2] = 'name_it';
$language[3] = 'name_vi';
$language[4] = 'name_tr';
$language[5] = 'name_th';
$language[6] = 'name_us';
$language[7] = 'name_ue';
$language[8] = 'name_pt';
$language[9] = 'name_zh';
$language[10] = 'name_zk';
$language[11] = 'name_ar';
$language[12] = 'name_ru';
$language[13] = 'name_es';
$language[14] = 'name_ja';
$language[15] = 'name_fr';
$language[16] = 'name_de';
$language[17] = 'name_sj';
$language[18] = 'name_cj';


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

if (!$conn_new) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully - new";


$sql = "SELECT * FROM ahd_country";
$result = $conn->query($sql);
$date = date('Y-m-d H:i:s');


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $code = $row["code"];
        $area = $row["area"];
        $sql_re = "INSERT INTO ahd_countries (code, area, created_at, created_by) VALUES ('$code', '$area','$date', '1')";

        if ($conn_new->query($sql_re) === TRUE) {
            $last_id = $conn_new->insert_id;
            echo "New record created successfully" . $last_id;
        } else {
            echo "Error: " . $sql_re . "<br>" . $conn_new->error;
        }

        // second table
        for ($i = 1; $i <= 18; $i++) {
            if ($i == 14) {
                $code = $row['name_ja'];
            } else {
                $code = !empty($row[$language[$i]]) ? $row[$language[$i]] : '';
            }

            $sql_re_name = "INSERT INTO ahd_country_names (ahd_country_id, language_id, name , created_at, created_by)
                            VALUES ('$last_id','$i', '$code','$date', '1')";
            if ($conn_new->query($sql_re_name) === TRUE) {
                echo "country names insert";
            } else {
                echo "country id -> names " . $last_id . "Error: ln id" . $i . $sql_re_name . "-----" . $conn_new->error;
            }
        }
    }
} else {
    echo "0 results";
}

$conn_new->close();
$conn->close();


?>