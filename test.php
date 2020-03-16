<?php

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
//die();
$product = [];
$re = [];
$sql_pwd_data = "SELECT * FROM pwd_products";
$result_pwd_data = $conn_new->query($sql_pwd_data);
//product
$sql_pwd_item_spec = "SELECT * FROM pwd_products";
$result_pwd_data = $conn_new->query($sql_pwd_data);


if ($result_pwd_data->num_rows > 0) {

    while ($row_product = $result_pwd_data->fetch_assoc()) {
        $product[$row_product['product_key']] = $row_product['id'];
    }

        $sql_pwd_s_name = "SELECT * FROM pwd_s_name";
        $result_pwd_s_name = $conn->query($sql_pwd_s_name);

        if ($result_pwd_s_name->num_rows > 0) {
            while ($row_pwd_s_name = $result_pwd_s_name->fetch_assoc()) {
                if (!empty($product[$row_pwd_s_name['pwd_key']]) && !empty($language[$row_pwd_s_name['pwd_lang']])) {

                    $productID = $product[$row_pwd_s_name['pwd_key']];
                    $languageID = $language[$row_pwd_s_name['pwd_lang']];

                    $name = isset($row_pwd_s_name['pwd_name'])?$row_pwd_s_name['pwd_name'] : '';
                    $sname = isset( $row_pwd_s_name['pwd_nmsub']) ? $row_pwd_s_name['pwd_nmsub'] : '';
                    $kit = isset($row_pwd_s_name['pwd_nmkit']) ? $row_pwd_s_name['pwd_nmkit'] : '';
                    $imgtop = isset($row_pwd_s_name['pwd_imgtop']) ? 'images/products/'.$productID.'/'.$row_pwd_s_name['pwd_imgtop'] : '';
                    $imgal = isset($row_pwd_s_name['pwd_imgatp']) ? $row_pwd_s_name['pwd_imgatp'] : '';
                    $imguse = isset($row_pwd_s_name['pwd_imguse']) ? $row_pwd_s_name['pwd_imguse'] : '';
                    $text = isset($row_pwd_s_name['pwd_text']) ? $row_pwd_s_name['pwd_text'] : '';

                    $lnkme = isset($row_pwd_s_name['pwd_lnkme']) ? $row_pwd_s_name['pwd_lnkme'] : '';
                    $ljme = isset($row_pwd_s_name['pwd_ljme']) ? $row_pwd_s_name['pwd_ljme'] : '';
                    $lnkqa = isset($row_pwd_s_name['pwd_lnkqa']) ? $row_pwd_s_name['pwd_lnkqa'] : '';
                    $ljqa = isset($row_pwd_s_name['pwd_ljqa']) ? $row_pwd_s_name['pwd_ljqa'] : '';
                    $lnkre = isset($row_pwd_s_name['pwd_lnkre']) ? $row_pwd_s_name['pwd_lnkre'] : '';
                    $ljre = isset($row_pwd_s_name['pwd_ljre']) ? $row_pwd_s_name['pwd_ljre'] : '';
                    $lnkfm = isset($row_pwd_s_name['pwd_lnkfm']) ? $row_pwd_s_name['pwd_lnkfm'] :'';
                    $ljfm = isset($row_pwd_s_name['pwd_ljfm']) ? $row_pwd_s_name['pwd_ljfm'] : '';

                    $shopflag = isset($row_pwd_s_name['pwd_ljfm']) ? $row_pwd_s_name['pwd_shopping_flag']: '';
                    $inq_url = isset($row_pwd_s_name['pwd_inquiry_url']) ? $row_pwd_s_name['pwd_inquiry_url'] : '';
                    $estimate_flag = isset($row_pwd_s_name['pwd_estimate_flag']) ? $row_pwd_s_name['pwd_estimate_flag']: '';
                    $voice_url = isset($row_pwd_s_name['pwd_customer_voice_url']) ? $row_pwd_s_name['pwd_customer_voice_url'] : '';
                    $manual_url = isset($row_pwd_s_name['pwd_installation_manual_url']) ? $row_pwd_s_name['pwd_installation_manual_url'] : '';

                    $link_open_1 = isset($row_pwd_s_name['pwd_lnkop1']) ? $row_pwd_s_name['pwd_lnkop1'] : '';
                    $opt_link_open_1 = isset($row_pwd_s_name['pwd_ljop1']) ? $row_pwd_s_name['pwd_ljop1'] : '';
                    $img_open_1 = isset($row_pwd_s_name['pwd_imgop1']) ? 'images/products/'.$productID.'/'.$row_pwd_s_name['pwd_imgop1'] : '';
                    $img_alt = isset($row_pwd_s_name['pwd_imgal1']) ? $row_pwd_s_name['pwd_imgal1']:'';
                    $link_open_2 = isset($row_pwd_s_name['pwd_lnkop2'])?$row_pwd_s_name['pwd_lnkop2']:'';
                    $opt_link_open_2 = isset($row_pwd_s_name['pwd_ljop2']) ? $row_pwd_s_name['pwd_ljop2'] : '';
                    $img_open_2 = isset($row_pwd_s_name['pwd_imgop2']) ? 'images/products/'.$productID.'/'.$row_pwd_s_name['pwd_imgop2'] : '';
                    $img_alt_2 = isset($row_pwd_s_name['option_alt_2']) ? $row_pwd_s_name['option_alt_2'] : '';

                    $left_img = isset($row_pwd_s_name['pwd_lftimg']) ? 'images/products/'.$productID.'/'.$row_pwd_s_name['pwd_lftimg'] : '';
                    $left_img_title = isset($row_pwd_s_name['pwd_lftalt']) ? $row_pwd_s_name['pwd_lftalt'] : '';
                    $left_text = isset($row_pwd_s_name['pwd_lfttxt']) ? $row_pwd_s_name['pwd_lfttxt'] : '';
                    $spec_caption = isset($row_pwd_s_name['pwd_spcapt']) ? $row_pwd_s_name['pwd_spcapt'] : '';
                    $part_cation = isset($row_pwd_s_name['pwd_ptcapt']) ? $row_pwd_s_name['pwd_ptcapt'] : '';
                    $option_cation = isset($row_pwd_s_name['pwd_opcapt']) ? $row_pwd_s_name['pwd_opcapt'] : '';


                    $patent = isset($row_pwd_s_name['pwd_patent']) ? $row_pwd_s_name['pwd_patent'] : '';
                    $is_publish = isset($row_pwd_s_name['pwd_pubchk']) ? $row_pwd_s_name['pwd_pubchk'] : '';
                    $publish_date = isset($row_pwd_s_name['pwd_pubdt']) ? $row_pwd_s_name['pwd_pubdt'] : '';
                    $is_end_sale = isset($row_pwd_s_name['pwd_eos']) ? $row_pwd_s_name['pwd_eos'] : '';
                    $end_sale = isset($row_pwd_s_name['pwd_eosdt']) ? $row_pwd_s_name['pwd_eosdt'] : '';



                    $sql_product_details = "INSERT INTO pwd_product_details (product_id,language_id,name,sub_name,name_kit,top_img,top_img_title,img_use,
description,shopping_cart,inquiry_url,estimate_flag,customer_voice_url,installation_manual_url,
left_img,left_img_title,left_img_text,specification_desc,option_caption,
option_link_1,option_link_open_1,option_img_1,option_alt_1,option_link_2,option_link_open_2,option_img_2,option_alt_2,
part_caption,patent,is_publish,publish_date,is_end_of_sale,end_of_sale_date,created_at,created_by)
                                                VALUES ('$productID','$languageID','$name','$sname','$kit','$imgtop','$imgal','$imguse',
                                                '$text','$shopflag','$inq_url','$estimate_flag','$voice_url','$manual_url',
                                                '$left_img','$left_img_title','$left_text','$spec_caption','$option_cation',
                                                '$link_open_1','$opt_link_open_1','$img_open_1','$img_alt','$link_open_2','$opt_link_open_2','$img_open_2','$img_alt_2',
                                                '$part_cation','$patent','$is_publish','$publish_date','$is_end_sale','$end_sale',
                                                '$date','1')";

                    if ($conn_new->query($sql_product_details) === TRUE) {
                        $last_id = $conn_new->insert_id;
                        echo "New product part created successfully" . $last_id;

                    } else {
                        echo "Error: Entry Product details " . $sql_product_details . "<br>" . $conn_new->error;
                    }
                }
            }

        } else {
            echo "0 results";
        }


} else {
    echo "0 product results";
}

$conn_new->close();
$conn->close();


?>