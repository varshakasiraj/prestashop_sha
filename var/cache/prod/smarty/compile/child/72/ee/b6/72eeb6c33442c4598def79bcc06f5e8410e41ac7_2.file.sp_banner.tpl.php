<?php
/* Smarty version 3.1.48, created on 2023-07-20 17:08:46
  from 'D:\xampp\htdocs\prestashop\shashop\modules\sp_banner\sp_banner.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.48',
  'unifunc' => 'content_64b91cc628fd42_60497636',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '72eeb6c33442c4598def79bcc06f5e8410e41ac7' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\shashop\\modules\\sp_banner\\sp_banner.tpl',
      1 => 1689851811,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64b91cc628fd42_60497636 (Smarty_Internal_Template $_smarty_tpl) {
?><section class="sp_banner_slider">
    <h2 class="sp_banner_title"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_name']->value, ENT_QUOTES, 'UTF-8');?>
</h2>
<div class="sp_container">
    <div class="sp_wrapper">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sliders']->value, 'slider');
$_smarty_tpl->tpl_vars['slider']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['slider']->value) {
$_smarty_tpl->tpl_vars['slider']->do_else = false;
?>
            <div class="sp_card one">
                    <div class="sp_image">
                        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slider']->value["path"], ENT_QUOTES, 'UTF-8');?>
"><img src="/prestashop/shashop/modules/sp_banner/image/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slider']->value["image_name"], ENT_QUOTES, 'UTF-8');?>
"/></a>
                    </div>
                    <div class="sp_description 1">
                        <h5><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slider']->value["slider_name"], ENT_QUOTES, 'UTF-8');?>
</h5>
                    </div>
            </div>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </div>
</div>
</section><?php }
}
