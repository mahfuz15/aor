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
echo "remove die() function";
die();

$language[1] = 'pwd_dict_en';
$language[2] = 'pwd_dict_it';
$language[3] = 'pwd_dict_vi';
$language[4] = 'pwd_dict_tr';
$language[5] = 'pwd_dict_th';
$language[6] = 'pwd_dict_us';
$language[7] = 'pwd_dict_ue';
$language[8] = 'pwd_dict_pt';
$language[9] = 'pwd_dict_zh';
$language[10] = 'pwd_dict_zk';
$language[11] = 'pwd_dict_ar';
$language[12] = 'pwd_dict_ru';
$language[13] = 'pwd_dict_es';
$language[14] = 'pwd_dict_ja';
$language[15] = 'pwd_dict_fr';
$language[16] = 'pwd_dict_de';
$language[17] = 'pwd_dict_sj';
$language[18] = 'pwd_dict_cj';


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

if (!$conn_new) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully - new";

$sql = "SELECT * FROM pwd_m_dict";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $code = $row['pwd_dict_code'];

        $sql_dict = "INSERT INTO dictionaries (code,created_at,created_by)VALUES ('$code','$date','1')";
        if ($conn_new->query($sql_dict) === TRUE) {
            $last_id = $conn_new->insert_id; echo "New record created successfully".$last_id;
        } else {echo "Error: " . $sql_dict . "<br>" . $conn_new->error;}

        // second table
        for ($i = 1; $i <= 18; $i++) {

            $code_details =$row[$language[$i]];


            echo $code_details."<br>";
            $sql_dictionary_details = "INSERT INTO dictionary_details (dictionary_id, language_id, code_details,created_at,created_by)VALUES ('$last_id','$i', '$code_details','$date','1')";
            if ($conn_new->query($sql_dictionary_details) === TRUE) {
                echo "code  insert";
            } else {
                echo "dic id ".$last_id."Error: ln id" .$i. $sql_dictionary_details . "-----" . $conn_new->error;
            }
        }
    }
} else {
    echo "0 results";
}

$conn_new->close();
$conn->close();


?>