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

mysqli_set_charset($conn,"utf8");
mysqli_set_charset($conn_new,"utf8");
$date = date('Y-m-d H:i:s');
echo "remove die function";
die();

$language[1] = 're_name_en';
$language[2] = 're_name_it';
$language[3] = 're_name_vi';
$language[4] = 're_name_tr';
$language[5] = 're_name_th';
$language[6] = 're_name_us';
$language[7] = 're_name_ue';
$language[8] = 're_name_pt';
$language[9] = 're_name_zh';
$language[10] = 're_name_zk';
$language[11] = 're_name_ar';
$language[12] = 're_name_ru';
$language[13] = 're_name_es';
$language[14] = 're_name_ja';
$language[15] = 're_name_fr';
$language[16] = 're_name_de';
$language[17] = 're_name_sj';
$language[18] = 're_name_cj';

$language_link[1] = 're_link_en';
$language_link[2] = 're_link_it';
$language_link[3] = 're_link_vi';
$language_link[4] = 're_link_tr';
$language_link[5] = 're_link_th';
$language_link[6] = 're_link_us';
$language_link[7] = 're_link_ue';
$language_link[8] = 're_link_pt';
$language_link[9] = 're_link_zh';
$language_link[10] = 're_link_zk';
$language_link[11] = 're_link_ar';
$language_link[12] = 're_link_ru';
$language_link[13] = 're_link_es';
$language_link[14] = 're_link_ja';
$language_link[15] = 're_link_fr';
$language_link[16] = 're_link_de';
$language_link[17] = 're_link_sj';
$language_link[18] = 're_link_cj';


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

if (!$conn_new) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully - new";

$sql = "SELECT * FROM pwd_m_re";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "id: " . $row["re_no"] . " - Price: " . $row["re_price_ja"] . "<br>";
        $re_no = $row["re_no"];
        $price = $row["re_price_ja"];
        $image = 'images/re_options/' . $row["re_img"];
        $image = $row["re_img"];


        $sql_re = "INSERT INTO pwd_re (re_no, price, image,created_at,created_by)VALUES ('$re_no', '$price', '$image','$date','1')";
        if ($conn_new->query($sql_re) === TRUE) {
            $last_id = $conn_new->insert_id;
            echo "New pwd_re record created successfully id: " . $last_id;
        } else {
            echo "Error: " . $sql_re . "<br>" . $conn_new->error;
        }

        for ($i = 1; $i <= 18; $i++) {

            $name = !empty($row[$language[$i]]) ? $row[$language[$i]] : '';
            $link = !empty($row[$language_link[$i]]) ? $row[$language_link[$i]] : '';

            $sql_re_name = "INSERT INTO pwd_re_name (re_id, language_id, name,link,created_at,created_by)
                            VALUES ('$last_id','$i', '$name','$link','$date','1')";
            if ($conn_new->query($sql_re_name) === TRUE) {
                echo "re name insert";
            } else {
                echo "re id " . $last_id . "Error: ln id" . $i . $sql_re_name . "-----" . $conn_new->error;
            }

        }
    }
} else {
    echo "0 results";
}

$conn_new->close();
$conn->close();


?>