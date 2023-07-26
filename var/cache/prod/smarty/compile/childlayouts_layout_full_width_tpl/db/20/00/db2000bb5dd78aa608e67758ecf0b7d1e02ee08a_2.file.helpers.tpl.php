<?php
/* Smarty version 3.1.48, created on 2023-07-20 17:08:46
  from 'D:\xampp\htdocs\prestashop\shashop\themes\classic\templates\_partials\helpers.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.48',
  'unifunc' => 'content_64b91cc6de3822_65200237',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'db2000bb5dd78aa608e67758ecf0b7d1e02ee08a' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\shashop\\themes\\classic\\templates\\_partials\\helpers.tpl',
      1 => 1689402525,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64b91cc6de3822_65200237 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->_tplFunction->registerTplFunctions($_smarty_tpl, array (
  'renderLogo' => 
  array (
    'compiled_filepath' => 'D:\\xampp\\htdocs\\prestashop\\shashop\\var\\cache\\prod\\smarty\\compile\\childlayouts_layout_full_width_tpl\\db\\20\\00\\db2000bb5dd78aa608e67758ecf0b7d1e02ee08a_2.file.helpers.tpl.php',
    'uid' => 'db2000bb5dd78aa608e67758ecf0b7d1e02ee08a',
    'call_name' => 'smarty_template_function_renderLogo_199856790764b91cc6ddd152_84248391',
  ),
));
?> 

<?php }
/* smarty_template_function_renderLogo_199856790764b91cc6ddd152_84248391 */
if (!function_exists('smarty_template_function_renderLogo_199856790764b91cc6ddd152_84248391')) {
function smarty_template_function_renderLogo_199856790764b91cc6ddd152_84248391(Smarty_Internal_Template $_smarty_tpl,$params) {
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}
?>

  <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['pages']['index'], ENT_QUOTES, 'UTF-8');?>
">
    <img
      class="logo img-fluid"
      src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo_details']['src'], ENT_QUOTES, 'UTF-8');?>
"
      alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['name'], ENT_QUOTES, 'UTF-8');?>
"
      width="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo_details']['width'], ENT_QUOTES, 'UTF-8');?>
"
      height="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo_details']['height'], ENT_QUOTES, 'UTF-8');?>
">
  </a>
<?php
}}
/*/ smarty_template_function_renderLogo_199856790764b91cc6ddd152_84248391 */
}
