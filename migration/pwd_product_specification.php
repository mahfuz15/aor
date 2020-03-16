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

    $sql_pwd_s_spec = "SELECT * FROM pwd_s_spec";
    $result_pwd_s_spec = $conn->query($sql_pwd_s_spec);

    if ($result_pwd_s_spec->num_rows > 0) {
        while ($row_pwd_s_spec = $result_pwd_s_spec->fetch_assoc()) {
            if (!empty($product[$row_pwd_s_spec['pwd_key']]) && !empty($language[$row_pwd_s_spec['pwd_lang']])) {
                $id = $row_pwd_s_spec['pwd_spec_id'];
                $productID = $product[$row_pwd_s_spec['pwd_key']];
                $languageID = $language[$row_pwd_s_spec['pwd_lang']];
                $item_spec_id = !empty($row_pwd_s_spec['pwd_spec_item']) ? $row_pwd_s_spec['pwd_spec_item'] : '';
                $spec_item_value = !empty($row_pwd_s_spec['pwd_spec_value']) ? $row_pwd_s_spec['pwd_spec_value'] : '';

                $sql_re = "INSERT INTO pwd_product_specifications (id,product_id,language_id,item_spec_id,spec_item_value,created_at,created_by)
                            VALUES ('$id','$productID','$languageID','$item_spec_id','$spec_item_value','$date','1')";

                if ($conn_new->query($sql_re) === TRUE) {
                    $last_id = $conn_new->insert_id;
                    echo "New product specification created successfully" . $last_id;

                } else {
                    echo "Error: Entry Product specification " . $sql_re . "<br>" . $conn_new->error;
                }
            }else{
                echo 'product id or language id missing';
            }
        }

    }else {
        echo "0 results";
    }

} else {
    echo "0 category results";
}

$conn_new->close();
$conn->close();


?>