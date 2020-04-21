<?php
echo "remove die";
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
$re = [];

//product
$sql_pwd_product = "SELECT * FROM pwd_products";
$resutl_pwd_product = $conn_new->query($sql_pwd_product);


if ($resutl_pwd_product->num_rows > 0) {

    while ($row_product = $resutl_pwd_product->fetch_assoc()) {
        $product[$row_product['product_key']] = $row_product['id'];
    }
    // pwd_re
    $sql_pwd_re = "SELECT * FROM pwd_re";
    $result_pwd_re = $conn_new->query($sql_pwd_re);
    if ($result_pwd_re->num_rows > 0) {

        while ($row_re = $result_pwd_re->fetch_assoc()) {
            $re[$row_re['re_no']] = $row_re['id'];
        }

        $sql_pwd_s_part = "SELECT * FROM pwd_s_part";
        $result_pwd_s_part = $conn->query($sql_pwd_s_part);

        if ($result_pwd_s_part->num_rows > 0) {
            while ($row_pwd_s_part = $result_pwd_s_part->fetch_assoc()) {

                if (!empty($product[$row_pwd_s_part['pwd_key']]) && !empty($language[$row_pwd_s_part['pwd_lang']])) {
                    $id = $row_pwd_s_part['pwd_part_id'];
                    $productID = $product[$row_pwd_s_part['pwd_key']];
                    $languageID = $language[$row_pwd_s_part['pwd_lang']];
                    $position = !empty($row_pwd_s_part['pwd_part_order']) ? $row_pwd_s_part['pwd_part_order'] : '';
                    $reid = $re[$row_pwd_s_part['pwd_re_no']];

                    $sql_part = "INSERT INTO pwd_product_parts (id,product_id,language_id,position,re_id,created_at,created_by)
                                                VALUES ('$id','$productID','$languageID','$position','$reid','$date','1')";

                    if ($conn_new->query($sql_part) === TRUE) {
                        $last_id = $conn_new->insert_id;
                        echo "New product part created successfully" . $last_id;
                    } else {
                        echo "Error: Entry Product part " . $sql_part . "<br>" . $conn_new->error;
                    }
                }

            }

        } else {
            echo "0 results";
        }
    } else {
        echo "pwd_re 0 result";
    }

} else {
    echo "0 product results";
}

$conn_new->close();
$conn->close();


?>