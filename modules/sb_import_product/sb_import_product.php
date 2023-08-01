<?php
require_once 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Csv;
class Sb_Import_Product extends Module{
    public function __construct()
    {
        $this->name = 'sb_import_product';
        $this->version = '2.1.2';
        $this->author = 'PrestaShop';
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->trans('sb_import_product');
        $this->description = $this->trans('create new product');
        $this->ps_versions_compliancy = ['min' => '1.7.1.0', 'max' => _PS_VERSION_];
    }
    public function install()
    {
        return parent::install();
    }
    public function uninstall(){
        return parent::uninstall();
    }
    public function getContent(){
        if(!empty($_POST["submit"])){
            $reader = new Csv();
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
            $products_data   = $spreadsheet->getActiveSheet()->toArray();
            $i=0;
            foreach($products_data as $product_data){
                if($i==0){
                    $i++;
                    continue;
                }
                $product=new Product();
                $get_product_id_from_reference = $this->getProductId($product_data);
                $get_category_id = $this->getCategoryId($product_data);
                $get_stock_available_id = $this->getStockAvailableId($get_product_id_from_reference);
                if(empty($get_product_id_from_reference ))
                {
                    $product->reference= $product_data[0];
                    $product->ean13 = $product_data[2];
                    $product->name = $product_data[3];
                    $product->description_short=$product_data[4];
                    $product->description =$product_data[5];
                    $product->price = $product_data[6];
                    $product->category = $product_data[7];
                    $product->quantity = $product_data[8];
                    $product->weight = $product_data[12];
                    $product->state =$product_data[13];
                    $product->add();
                    $category = new Category();
                    $category->name = $product_data[7];
                    $category->link_rewrite = str_replace(' ', '-',$product_data[3]);
                    $category->add();
                    $image = new Image();
                    $image->id_product = $product->id;
                    $image->position = Image::getHighestPosition($product->id) + 1;
                    $image->cover = true;
                }
                else{
                    $category = new Category(null,1);
                    if(empty($get_category_id)){
                        $category->name =["$product_data[7]","$product_data[7]","$product_data[7]","$product_data[7]"] ;
                        $str= str_replace(' ', '-',"category");
                        $category->link_rewrite = Tools::str2url($str);
                        $category->id_parent = 2;
                        $category->add();
                    }
                    $stock = new StockAvailable($get_stock_available_id);
                    $stock->quantity= $product_data[8];
                    $stock->id_product =$get_product_id_from_reference["id_product"];
                    $stock->id_product_attribute=0;
                    $stock->id_shop=1;
                    $stock->update();
                    $product_id =$get_product_id_from_reference["id_product"];
                    $image_url=$product_data[9];
                    self::copyImg($product_id, $image->id, $image_url, false);
                }
            }  
        }
        return $this->display(__FILE__, 'sb_import_product.tpl');
    }
    public function getProductId($product_data){
        $db = \Db::getInstance();
        $get_row = $db->getRow("SELECT id_product FROM `ps_product` WHERE reference ='".$product_data[0]."'");
        return $get_row;
    }
    public function getCategoryId($product_data){
        $db = \Db::getInstance();
        $request ="SELECT id_category FROM `ps_category_lang` WHERE `name` ='".$product_data[7]."'";
        $result = $db->executeS($request);
        return $result;
    }
    public function getStockAvailableId($get_product_id_from_reference){
        $db = \Db::getInstance();
        $request= "SELECT id_stock_available FROM `ps_stock_available` WHERE `id_product`='".$get_product_id_from_reference["id_product"]."'";
        $get_row =$db->getRow($request);
        return $get_row;
    }
    public static function copyImg($id_entity, $id_image, $sourcePath, $regenerate = true) {
        $image_obj = new Image($id_image);
        $path = $image_obj->getPathForCreation();
        ImageManager::resize($sourcePath, $path . '.jpg');
        $images_types = ImageType::getImagesTypes($path);
        return true;
    }

}
?>