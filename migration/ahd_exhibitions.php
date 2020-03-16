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

die();
$language['en'] = 1;
$language['it'] = 2;
$language['vi'] = 3;
$language['tr'] = 4;
$language['th'] = 5;
$language['us'] = 6;
$language['ue'] = 7;
$language['pt'] = 8;
$language['zh'] = 9;
$language['zk'] = 10;
$language['ar'] = 11;
$language['ru'] = 12;
$language['es'] = 13;
$language['ja'] = 14;
$language['fr'] = 15;
$language['de'] = 16;
$language['sj'] = 17;
$language['cj'] = 18;

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

if (!$conn_new) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully - new";

$sql = "SELECT * FROM ahd_exhibition";
$result = $conn->query($sql);
$date = date('Y-m-d H:i:s');

if ($result->num_rows > 0) {

    $country = [];
    $sql_country_data = "SELECT * FROM ahd_countries";
    $result_country_data = $conn_new->query($sql_country_data);

    while ($row_country_data = $result_country_data->fetch_assoc()) {
         $country[$row_country_data['code']] = $row_country_data['id'];
    }

    while ($row = $result->fetch_assoc()) {
        if (!empty($language[$row['lang']])){
            $id = $row['exid'];
            $languageID = $language[$row['lang']];
            $country_id = $country[$row["country"]];
            $start_date = isset($row["date_o"])?$row["date_o"]:'';
            $end_date = isset($row["date_c"])?$row["date_c"]:'';
            $english_title = isset($row["title_e"])?$row["title_e"]:'';
            $intended_lang_title = isset($row["title_w"])?$row["title_w"]:'';
            $english_venue = isset($row["venue_e"])?$row["venue_e"]:'';
            $intended_lang_venue = isset($row["venue_w"])?$row["venue_w"]:'';
            $booth = isset($row["booth"])?$row["booth"]:'';
            $english_link = isset($row["link_e"])?$row["link_e"]:'';
            $intended_lang_link = isset($row["link_w"])?$row["link_w"]:'';
            $img_logo = isset($row["img_logo"])? $row["img_logo"]:'';
            $img_report = isset($row["img_repo"])? $row["img_repo"]:'';
            $english_desc = isset($row["text_e"])?$row["text_e"]:'';
            $intended_lang_desc = isset($row["text_w"])?$row["text_w"]:'';

            $sql_exhibition = "INSERT INTO ahd_exhibitions (id,language_id, country_id,start_date, end_date, english_title, intended_lang_title, english_venue, intended_lang_venue, booth, english_link, intended_lang_link,img_logo,img_report, english_desc, intended_lang_desc,  status,created_at, created_by) 
                    VALUES ('$id','$languageID','$country_id','$start_date','$end_date', '$english_title','$intended_lang_title','$english_venue','$intended_lang_venue','$booth','$english_link','$intended_lang_link','$img_logo','$img_report','$english_desc','$intended_lang_desc','1','$date', '1')";

            if ($conn_new->query($sql_exhibition) === TRUE) {
                $last_id = $conn_new->insert_id; echo "New record created successfully".$last_id;
            } else
            {
                echo "Error: " . $sql_exhibition . "<br>" . $conn_new->error;
            }
        }


    }
} else {
    echo "0 results";
}

$conn_new->close();
$conn->close();


?>