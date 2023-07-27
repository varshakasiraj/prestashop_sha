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
                    
                    $category->name =["test"] ;
                    $category->link_rewrite = str_replace(' ', '-',$product_data[3]);
                    $category->add();
                }
            }  
        }
        return $this->display(__FILE__, 'sb_import_product.tpl');
    }

}
?>