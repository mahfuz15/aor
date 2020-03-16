<?php

echo "remove die() function";
die();
header('Content-Type: text/html; charset=utf-8');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
$dbname_new = "pwd";

$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn_new = mysqli_connect($servername, $username, $password, $dbname_new);

mysqli_set_charset($conn, "utf8");
mysqli_set_charset($conn_new, "utf8");
$date = date('Y-m-d H:i:s');

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
echo "Connected successfully old db";

if (!$conn_new) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully - new db" . '<br>';


$product = [];
$sql_pwd_data = "SELECT * FROM pwd_products";
$result_pwd_data = $conn_new->query($sql_pwd_data);

if ($result_pwd_data->num_rows > 0) {

    while ($row_product = $result_pwd_data->fetch_assoc()) {
        $product[$row_product['product_key']] = $row_product['id'];
    }

    $sql_pwd_s_dl = "SELECT * FROM pwd_s_dl";
    $result_pwd_s_dl = $conn->query($sql_pwd_s_dl);

    if ($result_pwd_s_dl->num_rows > 0) {
        while ($row_pwd_s_dl = $result_pwd_s_dl->fetch_assoc()) {
            if (!empty($product[$row_pwd_s_dl['pwd_key']]) && !empty($language[$row_pwd_s_dl['pwd_lang']])) {
                $productID = $product[$row_pwd_s_dl['pwd_key']];
                $languageID = $language[$row_pwd_s_dl['pwd_lang']];
                $position = !empty($row_pwd_s_dl['pwd_dl_order']) ? $row_pwd_s_dl['pwd_dl_order'] : '';
                $type = !empty($row_pwd_s_dl['pwd_dl_type']) ? $row_pwd_s_dl['pwd_dl_type'] : '';
                $link = !empty($row_pwd_s_dl['pwd_dl_link']) ? $row_pwd_s_dl['pwd_dl_link'] : '';
                $text = !empty($row_pwd_s_dl['pwd_dl_text']) ? $row_pwd_s_dl['pwd_dl_text'] : '';
                $size = !empty($row_pwd_s_dl['pwd_dl_fsize']) ? $row_pwd_s_dl['pwd_dl_fsize'] : '';

                $sql_re = "INSERT INTO pwd_product_files (product_id,language_id,position,type,link,text,size,created_at,created_by)
                                VALUES ('$productID','$languageID','$position','$type','$link','$text','$size','$date','1')";

                if ($conn_new->query($sql_re) === TRUE) {
                    $last_id = $conn_new->insert_id;
                    echo "New product file created successfully" . $last_id;
                } else {
                    echo "Error: Entry Product file " . $sql_re . "<br>" . $conn_new->error;
                }
            }
        }

    } else {
        echo "0 results";
    }

} else {
    echo "0 category results";
}

$conn_new->close();
$conn->close();


?>