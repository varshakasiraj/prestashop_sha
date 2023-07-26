<?php
include_once('../../config/config.inc.php');
include_once('../../init.php');
if($_GET["q"] == true){
    $getname = $_GET["q"];
    $db = \Db::getInstance();
    $request = "SELECT ps_product.id_product as id ,ps_product.reference, ps_product_lang.name as text FROM ps_product LEFT JOIN ps_product_lang on ps_product.id_product =
     ps_product_lang.id_product WHERE id_lang = 1 and name LIKE'%$getname%'";
    $result = $db->executeS($request);
    if(!empty($result) && $result == true){
        $json = json_encode($result);
        echo $json;
    }
}
?>