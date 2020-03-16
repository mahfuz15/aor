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
$re = [];
$sql_pwd_data = "SELECT * FROM pwd_products";
$result_pwd_data = $conn_new->query($sql_pwd_data);


if ($result_pwd_data->num_rows > 0) {

    while ($row_product = $result_pwd_data->fetch_assoc()) {
        $product[$row_product['product_key']] = $row_product['id'];
    }
    // pwd_re
    $sql_pwd_re = "SELECT * FROM pwd_re";
    $result_pwd_re = $conn_new->query($sql_pwd_re);
    if ($result_pwd_re->num_rows > 0) {

        while ($row_re = $result_pwd_re->fetch_assoc()) {
            $re[$row_re['re_no']] = $row_re['id'];
        }

        $sql_pwd_s_opt = "SELECT * FROM pwd_s_opt";
        $result_pwd_s_opt = $conn->query($sql_pwd_s_opt);

        if ($result_pwd_s_opt->num_rows > 0) {
            while ($row_pwd_s_opt = $result_pwd_s_opt->fetch_assoc()) {
                if (!empty($product[$row_pwd_s_opt['pwd_key']]) && !empty($language[$row_pwd_s_opt['pwd_lang']])) {
                    $id = $row_pwd_s_opt['pwd_opt_id'];
                    $productID = $product[$row_pwd_s_opt['pwd_key']];
                    $languageID = $language[$row_pwd_s_opt['pwd_lang']];
                    $position = !empty($row_pwd_s_opt['pwd_opt_order']) ? $row_pwd_s_opt['pwd_opt_order'] : 999;
                    $reid = $re[$row_pwd_s_opt['pwd_re_no']];

                    $sql_opt = "INSERT INTO pwd_product_options (id,product_id,language_id,position,re_id,created_at,created_by)
                                                VALUES ('$id','$productID','$languageID','$position','$reid','$date','1')";

                    if ($conn_new->query($sql_opt) === TRUE) {
                        $last_id = $conn_new->insert_id;
                        echo "New product re created successfully" . $last_id;
                    } else {
                        echo "Error: Entry Product re " . $sql_opt . "<br>" . $conn_new->error;
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