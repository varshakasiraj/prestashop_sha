<?php
class Sp_Banner extends Module{
    public $get_module_name ;
    public function __construct()
    {
        $this->name = 'sp_banner';
        $this->version = '2.1.2';
        $this->author = 'PrestaShop';
        $this->need_instance = 0;
        $this->bootstrap = true;
        parent::__construct();
        
        $this->displayName = $this->trans('sp_Banner');
        $this->description = $this->trans('new arrival banner');

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
        $this->context->controller->registerStylesheet('sp_banner_css', '/modules/sp_banner/css/sp_banner.css', ['media' => 'all', 'priority' => 1000]);
        $this->context->controller->registerStylesheet('slick_css', '/modules/sp_banner/css/slick.css', ['media' => 'all', 'priority' => 1000]);
        $this->context->controller->registerJavascript('slick_js', '/modules/sp_banner/js/slick.min.js', ['position' => 'bottom', 'priority' => 1000]);
        $this->context->controller->registerJavascript('sp_banner_js', '/modules/sp_banner/js/custome.js', ['position' => 'bottom', 'priority' => 1000]);

    }
    public function hookDisplayHome(){
        $this->context->smarty->assign(
            [
                'sliders' => $this->selectSlider(),
                'module_name' => $this->get_module_name,
            ]
            );
        return  $this->display(__FILE__, 'sp_banner.tpl');
    }
    public function displaySpbannerTable(){
        $this->context->smarty->assign(
            [
                 'getslider'=> $this->getSlider(),
                 'link'=> $this->context->link,
            ]);
        return  $this->display(__FILE__, 'sp_banner_table.tpl');
    }
    public function getContent(){
        $output = '';
        $editid = $_GET["id"];
        $deleteid = $_GET["delete_id"];
        if($editid == true){
            $update =$this->processEditId($_GET["id"]);
        }
        if($deleteid == true){

           $this->processDelete($deleteid);
        }
        if(Tools::isSubmit('input_slider'.$this->name))

        {
             $module_name = (string) Tools::getValue("block_name");
             Configuration::updateValue("block_name",$module_name);
             $output = $this->displayConfirmation($this->l('Settings updated'));
             
        } elseif (Tools::isSubmit('insert_slider'.$this->name)) {
               $this->processInsertSlider();
        }
        elseif(Tools::isSubmit('update_slider'.$this->name)){
            $this->processUpdateSlider();
        }
        return $output.$this->displayForm().$update.$this->displaySpbannerTable().$this->displayInsertForm();
    }
    public function processInsertSlider(){ 
        $error = array();
        if(!empty(Tools::getValue("image_name"))){
            $image = (string) Tools::getValue("image_name");
            $image_name = $this->imageValidation($image);
        }
        else{
            $error[]= $this->displayConfirmation($this->l('image extension is worng '));
        }
        if(!empty(Tools::getValue("slider_name"))){

             $slider_name= (string) Tools::getValue("slider_name");
        }
        else{
            $error[]= $this->displayConfirmation($this->l(''));
        }
        if(!empty(Tools::getValue("link"))){

            $path = (string) Tools::getValue("link");
        }
        if(!empty( Tools::getValue("position"))){
            $positions = (int) Tools::getValue("position");
        }
        if(!empty(Tools::getValue("status"))){
            $status = (int) Tools::getValue("status");
        }
        $data =[
            'image_name'=>$image_name,
            'slider_name'=>$slider_name,
            'path'=>$path,
            'status'=>$status,
            'positions'=>$positions,
        ];
        $this->insertSlider($data);
    }
    public function processUpdateSlider(){
        $error = array();
        if(!empty(Tools::getValue("image_name"))){
            $image = (string) Tools::getValue("image_name");
            $image_name = $this->imageValidation($image);
        }
        else{
            $error[]= $this->displayConfirmation($this->l('image extension is worng '));
        }
        if(!empty(Tools::getValue("slider_name"))){

             $slider_name= (string) Tools::getValue("slider_name");
        }
        else{
            $error[]= $this->displayConfirmation($this->l(''));
        }
        if(!empty(Tools::getValue("link"))){

            $path = (string) Tools::getValue("link");
        }
        if(!empty( Tools::getValue("position"))){
            $positions = (int) Tools::getValue("position");
        }
        if(!empty(Tools::getValue("status"))){
            $status = (int) Tools::getValue("status");
        }
        $id = (int) Tools::getValue("id");
        $data =[
            'image_name'=>$image_name,
            'slider_name'=>$slider_name,
            'path'=>$path,
            'status'=>$status,
            'positions'=>$positions,
        ];
        $this->updataQuery($data,$id);
    }
    public function processDelete($deleteid){
        $db = \Db::getInstance();
         return $db->delete('sp_banner',"id = $deleteid");
    }
    public function insertSlider($data){
        $db = \Db::getInstance();
        $insert = $db->insert('sp_banner',$data,Db::INSERT);
        return $insert;
    }
    public function selectSlider(){
        $db = \Db::getInstance();
        $request = 'SELECT * FROM ps_sp_banner WHERE status = 1';
        $result = $db->executeS($request);
        return $result;
    }
    public function getSlider(){
        $db = \Db::getInstance();
        $request = 'SELECT * FROM ps_sp_banner';
        $result = $db->executeS($request);
        return $result;
    }
   
    
    public function processEditId($id){
       $result_from_id = $this->fetchRow($id);
       $result= $this->displayUpdateForm($result_from_id[0]["id"],$result_from_id[0]["image_name"],
       $result_from_id[0]["slider_name"],$result_from_id[0]["path"],$result_from_id[0]["status"],$result_from_id[0]["positions"]);
       return $result;
    }
    public function fetchRow($id){
        $db = \Db::getInstance();
        $request = 'SELECT * FROM ps_sp_banner WHERE id ='.$id;
        $result = $db->executeS($request);
        return $result;

    }
    public function updataQuery($data,$id){
        $db = \Db::getInstance();
        $result = $db->update('sp_banner',$data, $id);
        return $result;
    }
    public function imageValidation($image){
        $allowed_img_extension = ["jpg", "jpeg", "bmp", "gif", "png","jfif"];
        $basename =  basename($image);
        $extension = substr(strrchr($basename, '.'), 1);
        if (!empty($image)&& in_array($extension, $allowed_img_extension)) {
            $path = $_FILES['image_name']['tmp_name'];
            $image_path = dirname(__DIR__)."\sp_banner\image\\".$basename;
            if(move_uploaded_file($path, $image_path)){
                return $basename;
            }
        } 
        else {
            echo "Wheather image is empty or having wrong extension";
        }
    }
   
    public function displayInsertForm(){

        $form=[
            'form' =>[
                'input' =>array(
                    array(
                        'type' =>"file",
                        'name' => 'image_name',
                        'required' => true,
                        'label' =>'Slider Name'
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'slider_name',
                        'required' => true,
                        'label' =>'Slider Name'
                    ),
                    array(
                        'type'=>'text',
                        'name' => 'link',
                        'required' => true,
                        'label' =>'Link'
                    ),
                    array(
                        'type'=>'text',
                        'name' => 'position',
                        'required' => true,
                        'label' =>'Position'
                    ),
                    array(
                        'type'=>'radio',
                        'name' => 'status',
                        'required' => true,
                        'label' =>'Status',
                        'isbool' =>true,
                        'values' => array(
                            array(
                                'id' =>'enable',
                                'value' =>1,
                                'label' =>'Enabled',
                              ),
                            array(
                              'id' =>'disable',
                              'value' =>0,
                              'label' =>'Disabled',
                              
                            ),
                        )
                    ),

                ),
                'submit' =>[

                    'title' => 'insert',
                    'name' => 'Insert'
                ]
            ]
           
        ];
        $helperform = new HelperForm();
        $helperform->table = $this->table;
            $helperform->submit_action = 'insert_slider' . $this->name;
        return $helperform->generateForm([$form]);
    }
    public function displayUpdateForm($id,$image_name,$slider_name,$path,$status,$position){
        $form=[
            'form' =>[
                'input' =>array(
                    array(
                        'type' =>"file",
                        'name' => 'image_name',
                        'required' => true,
                        'label' =>'Slider Name'
                        ,'value'=>$image_name
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'slider_name',
                        'required' => true,
                        'label' =>'Slider Name','value'=>$slider_name
                    ),
                    array(
                        'type'=>'text',
                        'name' => 'link',
                        'required' => true,
                        'label' =>'Link','value'=>$path
                    ),
                    array(
                        'type'=>'text',
                        'name' => 'position',
                        'required' => true,
                        'label' =>'Position',
                        'value'=>$position
                    ),
                    array(
                        'type'=>'radio',
                        'name' => 'status',
                        'required' => true,
                        'label' =>'Status',
                        'isbool' =>true,
                        'values' => array(
                            array(
                                'id' =>'enable',
                                'value' =>1,
                                'label' =>'Enabled',
                              ),
                            array(
                              'id' =>'disable',
                              'value' =>0,
                              'label' =>'Disabled',
                              
                            ),
                        )
                    ),
                    array(
                        'type'=>'text',
                        'name'=>'id',
                        'value'=>$id,
                    )

                ),
                'submit' =>[

                    'title' => 'update',
                    'name' => 'update_slider'
                ]
            ]
           
        ];
        $helperform = new HelperForm();
        $helperform->table = $this->table;
            $helperform->fields_value['image_name'] = $image_name;
            $helperform->fields_value['slider_name'] = $slider_name;
            $helperform->fields_value['link'] = $path;
            $helperform->fields_value['position'] = $position;
            $helperform->fields_value['status'] = $status;
            $helperform->fields_value['id'] = $id;
            $helperform->submit_action = 'update_slider' . $this->name;
        return $helperform->generateForm([$form]);
    }

    public function displayForm(){
        $form=[
            'form' =>[
                'input' => [
                    array(
                        'type' => 'text',
                        'name' => 'block_name',
                        'required' => true,
                        'label' =>'Enter your Block Name'
                    ),
                ],
                'submit' =>[
                    'title' => 'submit',
                    'name' =>'input_slider',
                ]
            ]
           
        ];
        $helperform = new HelperForm();
        $helperform->table = $this->table;
        $helperform->submit_action = 'input_slider' . $this->name;
        $helperform->fields_value['block_name'] = Configuration::get("block_name");
        return $helperform->generateForm([$form]);
    }
    
} 
?>
