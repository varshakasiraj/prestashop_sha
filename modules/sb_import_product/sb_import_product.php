<?php
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
        return parent::install() &&
            $this->registerHook('displayHome') &&
            $this->registerHook('displayHeader');
    }
    public function uninstall(){
        return parent::uninstall();
    }
    public function hookDisplayHeader(){
       
    }
    public function hookDisplayHome(){
    }
    public function getContent(){
        if(!empty($_POST["submit"])){
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
            $products_data   = $spreadsheet->getActiveSheet()->toArray();
            $i=0;
            foreach($products_data as $product_data){
                if($i==0){
                    $i++;
                    continue;
                }
                $product=new Product();
                $db = \Db::getInstance();
                $request = "SELECT id_product FROM `ps_product` WHERE reference ='".$product_data[0]."'";
                $result = $db->executeS($request);
                $category_id ="SELECT id_category FROM `ps_category_lang` WHERE `name` ='".$product_data[7]."'";
                $category_result = $db->executeS($category_id);
                $stock_available_id = "SELECT id_stock_available FROM `ps_stock_available` WHERE `id_product`='".$result[0]["id_product"]."'";
                $stock_id_result = $db->executeS($stock_available_id);
                if(empty($result))
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
                    if(empty($category_result)){
                        $category->name =["$product_data[7]","$product_data[7]","$product_data[7]","$product_data[7]"] ;
                        $str= str_replace(' ', '-',"category");
                        $category->link_rewrite = Tools::str2url($str);
                        $category->id_parent = 2;
                        $category->add();
                    }
                    $stock = new StockAvailable($stock_id_result[0]["id_stock_available"]);
                    $stock->quantity= $product_data[8];
                    $stock->id_product =$result[0]["id_product"];
                    $stock->id_product_attribute=0;
                    $stock->id_shop=1;
                    //$stock->update();
                    //$image=$product_data[9];
                    //$url = $image->attributes()->url->__toString();
                    /*$product_id =$result[0]["id_product"];
                    $image = new Image();
                    
                    $image->id_product =$product_id;
                    $image->position = Image::getHighestPosition($product_id) + 1;
                    $image->cover = true;
                    $image->legend =$product_data[3];*/
                    $product_id =$result[0]["id_product"];
                    $image_url=$product_data[9];
                    self::copyImg($product_id, $image->id, $image_url, 'products', false);
                }
            }  
        }
        return $this->display(__FILE__, 'sb_import_product.tpl');
    }
    public static function copyImg($id_entity, $id_image, $sourcePath, $entity = 'products', $regenerate = true) {

        switch ($entity) {
            default:
            case 'products':
                $image_obj = new Image($id_image);
                $path = $image_obj->getPathForCreation();
                break;
            case 'categories':
                $path = _PS_CAT_IMG_DIR_ . (int) $id_entity;
                break;
            case 'manufacturers':
                $path = _PS_MANU_IMG_DIR_ . (int) $id_entity;
                break;
            case 'suppliers':
                $path = _PS_SUPP_IMG_DIR_ . (int) $id_entity;
                break;
        }

        ImageManager::resize($sourcePath, $path . '.jpg');
        $images_types = ImageType::getImagesTypes($entity);

  
        return true;
    }

}
?>