<?php
class Sp_Featured_Products extends Module{
    public $get_module_name,$get_products_id;
    public function __construct()
    {
        $this->name = 'sp_featured_products';
        $this->version = '2.1.2';
        $this->author = 'PrestaShop';
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->trans('sp_featured_products');
        $this->description = $this->trans('View Products With Select2 ');
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
        $this->context->controller->registerStylesheet('sp_featured_products_css', '/modules/sp_featured_products/css/select2.min.css', ['media' => 'all', 'priority' => 1000]);
        $this->context->controller->registerJavascript('select2_js', '/modules/sp_featured_products/js/select2.min.js', ['position' => 'bottom', 'priority' => 1000]);
        $this->context->controller->registerJavascript('sp_featured_products_js', '/modules/sp_banner/js/sp_featured_products.js', ['position' => 'bottom', 'priority' => 1000]);
    }
    public function hookDisplayHome(){
        $this->context->smarty->assign(
            [
                'products'=> Configuration::get("sp_featured_products_name"),
            ]);
        return  $this->display(__FILE__, 'sp_featured_products.tpl');
    }
    public function displaySelect2(){
        $this->context->smarty->assign(
            [
                'link'=> $this->context->link,
            ]);
        return  $this->display(__FILE__, 'sp_featured_form.tpl');
    }
    public function getContent(){
        $this->context->controller->addCSS(($this->_path).'css/select2.min.css', 'all');
        $this->context->controller->addJS(($this->_path). 'js/sp_featured_products.js');
        $this->context->controller->addJS(($this->_path). 'js/select2.sortable.min.js');
        $this->context->controller->addJS(($this->_path). 'js/select2.min.js');
        $this->context->controller->addJS(($this->_path). 'js/html5sortable.min.js');
        $module_name = (string) Tools::getValue("modules");
        Configuration::updateValue("sp_featured_products_name",$module_name);
        $productid =json_encode($_POST["products"]);
        Configuration::updateValue("sp_featured_products",$productid);
        return  $this->displaySelect2().$this->getProduct();

    }
    public function getProduct(){
        $decode_id =json_decode(Configuration::get("sp_featured_products"),TRUE);
        foreach ($decode_id as $product_id ){
            $product=new Product($decode_id);
        }
        return $product;
    }
}
?>