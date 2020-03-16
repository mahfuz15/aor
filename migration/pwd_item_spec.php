<?php

header('Content-Type: text/html; charset=utf-8');


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
$dbname_new = "pwd";
echo "remove die function";
die();
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn_new = mysqli_connect($servername, $username, $password, $dbname_new);

mysqli_set_charset($conn, "utf8");
mysqli_set_charset($conn_new, "utf8");
$date = date('Y-m-d H:i:s');

$language[1] = 'pwd_spitem_en';
$language[2] = 'pwd_spitem_it';
$language[3] = 'pwd_spitem_vi';
$language[4] = 'pwd_spitem_tr';
$language[5] = 'pwd_spitem_th';
$language[6] = 'pwd_spitem_us';
$language[7] = 'pwd_spitem_ue';
$language[8] = 'pwd_spitem_pt';
$language[9] = 'pwd_spitem_zh';
$language[10] = 'pwd_spitem_zk';
$language[11] = 'pwd_spitem_ar';
$language[12] = 'pwd_spitem_ru';
$language[13] = 'pwd_spitem_es';
$language[14] = 'pwd_spitem_ja';
$language[15] = 'pwd_spitem_fr';
$language[16] = 'pwd_spitem_de';
$language[17] = 'pwd_spitem_sj';
$language[18] = 'pwd_spitem_cj';


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

if (!$conn_new) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully - new";
$date = date('Y-m-d H:i:s');
$sql = "SELECT * FROM pwd_m_spec_item";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $order = $row['pwd_spitem_order'];
        $id = $row['pwd_spitem_id'];

        $sql_spec = "INSERT INTO pwd_item_spec (id,position, status,created_at,created_by)
                        VALUES ('$id','$order', '1','$date','1')";
        if ($conn_new->query($sql_spec) === TRUE) {
            $last_id = $conn_new->insert_id;
            echo "New record created successfully" . $last_id;
        } else {
            echo "Error item_spec at insert: " . $sql_spec . "<br>" . $conn_new->error;
        }

        // second table
        for ($i = 1; $i <= 18; $i++) {
            $name = isset($row[$language[$i]]) ? $row[$language[$i]] : '';

            $sql_item_spec_name = "INSERT INTO pwd_item_spec_name (item_spec_id, language_id, title,created_at,created_by)
            VALUES ('$last_id','$i', '$name','$date','1')";
            if ($conn_new->query($sql_item_spec_name) === TRUE) {
                echo "spec name insert";
            } else {
                echo "spec id " . $last_id . "Error: ln id" . $i . $sql_item_spec_name . "-----" . $conn_new->error;
            }

        }

    }
} else {
    echo "0 results";
}

$conn_new->close();
$conn->close();


?>