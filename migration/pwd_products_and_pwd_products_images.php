<?php

header('Content-Type: text/html; charset=utf-8');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
$dbname_new = "pwd";

$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn_new = mysqli_connect($servername, $username, $password, $dbname_new);

echo "remove die() function";
die();
mysqli_set_charset($conn, "utf8");
mysqli_set_charset($conn_new, "utf8");


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
echo "Connected successfully old db";

if (!$conn_new) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully - new db" . '<br>';

$category = [];

$sql_category = "SELECT * FROM pwd_categories";
$result_category = $conn_new->query($sql_category);

if ($result_category->num_rows > 0) {

    while ($row_cat = $result_category->fetch_assoc()) {
        $category[$row_cat['code']] = $row_cat['id'];
    }

    $sql_pwd_data = "SELECT * FROM pwd_data";
    $result_pwd_data = $conn->query($sql_pwd_data);

    if ($result_pwd_data->num_rows > 0) {

        while ($row = $result_pwd_data->fetch_assoc()) {

             $category_ID = $category[$row['pwd_cls1']];
             $productKey = $row['pwd_key'];
             $catalog_no = $row['pwd_cat_no'];
             $model = $row['pwd_model'];
             $desc = $row['pwd_desc'];
             $serial_no_type = $row['pwd_sn_type'];
             $date = date('Y-m-d H:i:s');


            $sql_re = "INSERT INTO pwd_products (category_id,product_key,catalog_no,model,serial_no_type,description,status,created_at,created_by)
                            VALUES ('$category_ID','$productKey','$catalog_no','$model','$serial_no_type','$desc','1','$date','1')";

            if ($conn_new->query($sql_re) === TRUE) {

                $last_id = $conn_new->insert_id;
                echo "New Product created successfully" . $last_id;

                 for ($i = 1; $i <=5 ; $i++) {
                     //$code = isset($row[$language[$i]]) ? $row[$language[$i]] : '';
                     $img_l = !empty($row['pwd_img_l']) ? $row['pwd_img_l'] : '';
                     $img_n = !empty($row['pwd_img_n']) ? $row['pwd_img_n'] : '';
                     $img_s = !empty($row['pwd_img_s']) ? $row['pwd_img_s'] : '';
                     $img_p = !empty($row['pwd_img_p']) ? $row['pwd_img_p'] : '';
                     $img_sn = !empty($row['pwd_sn_img']) ? $row['pwd_sn_img'] : '';

                     switch ($i) {
                         case 1:
                             $sql_product_image = "INSERT INTO pwd_product_images (product_id, image, image_type,created_at,created_by)
                                                     VALUES ('$last_id','$img_l','large','$date','1')";
                             if ($conn_new->query($sql_product_image) === TRUE) {
                                 echo "code  insert";
                             } else {
                                 echo "product id " . $last_id . "Error: lng id" . $i . $sql_product_image . "-----" . $conn_new->error;
                             }
                             break;
                         case 2:
                             $sql_product_image = "INSERT INTO pwd_product_images (product_id, image, image_type,created_at,created_by)
                                                     VALUES ('$last_id','$img_n','normal','$date','1')";
                             if ($conn_new->query($sql_product_image) === TRUE) {
                                 echo "code  insert";
                             } else {
                                 echo "product id " . $last_id . "Error: lng id" . $i . $sql_product_image . "-----" . $conn_new->error;
                             }
                             break;

                         case 3:
                             $sql_product_image = "INSERT INTO pwd_product_images (product_id, image, image_type,created_at,created_by)
                                                     VALUES ('$last_id','$img_s','small','$date','1')";
                             if ($conn_new->query($sql_product_image) === TRUE) {
                                 echo "code  insert";
                             } else {
                                 echo "product id " . $last_id . "Error: lng id" . $i . $sql_product_image . "-----" . $conn_new->error;
                             }
                             break;
                         case 4:
                             $sql_product_image = "INSERT INTO pwd_product_images (product_id, image, image_type,created_at,created_by)
                                                     VALUES ('$last_id','$img_p','panel','$date','1')";
                             if ($conn_new->query($sql_product_image) === TRUE) {
                                 echo "code  insert";
                             } else {
                                 echo "product id " . $last_id . "Error: lng id" . $i . $sql_product_image . "-----" . $conn_new->error;
                             }
                             break;
                         case 5:
                             $sql_product_image = "INSERT INTO pwd_product_images (product_id, image, image_type,created_at,created_by)
                                                     VALUES ('$last_id','$img_sn','serial_no','$date','1')";
                             if ($conn_new->query($sql_product_image) === TRUE) {
                                 echo "code  insert";
                             } else {
                                 echo "product id " . $last_id . "Error: lng id" . $i . $sql_product_image . "-----" . $conn_new->error;
                             }
                             break;
                     }
                 }


            } else {
                echo "Error: Entry Product " . $sql_re . "<br>" . $conn_new->error;
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