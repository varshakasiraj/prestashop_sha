<?php
/* Smarty version 3.1.48, created on 2023-07-20 07:18:39
  from 'D:\xampp\htdocs\prestashop\shashop\modules\sp_banner\sp_banner_table.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.48',
  'unifunc' => 'content_64b89277dfa717_71995054',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '910467e7ac4535e211278929b1b37f846e6b4056' => 
    array (
      0 => 'D:\\xampp\\htdocs\\prestashop\\shashop\\modules\\sp_banner\\sp_banner_table.tpl',
      1 => 1689771594,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64b89277dfa717_71995054 (Smarty_Internal_Template $_smarty_tpl) {
?><link rel="stylesheet" 
href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
 crossorigin="anonymous">
 <style>
    .table{
        padding: 5px 0;
    }
 </style>
<div class="panel">
<table class="table">
    <thead >
        <th>ID</th>
        <th>Shop Id</th>
        <th>Lang Id</th>
        <th>Image Name</th>
        <th>Slider Name</th>
        <th>Link</th>
        <th>Status</th>
        <th>Postion</th>
    </thead>
    <tbody class="table-group-divider">
       <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['getslider']->value, 'slider');
$_smarty_tpl->tpl_vars['slider']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['slider']->value) {
$_smarty_tpl->tpl_vars['slider']->do_else = false;
?>
            <tr class="table-success" >
                <td><?php echo $_smarty_tpl->tpl_vars['slider']->value["id"];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['slider']->value["id_shop"];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['slider']->value["id_lang"];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['slider']->value["image_name"];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['slider']->value["slider_name"];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['slider']->value["path"];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['slider']->value["status"];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['slider']->value["positions"];?>
</td>
                <td>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminModules');?>
&configure=sp_banner&id=<?php echo $_smarty_tpl->tpl_vars['slider']->value['id'];?>
">
                    <button class="btn btn-info">Edit</button></a>
                </td>
                <td><a href="#?id = <?php echo $_smarty_tpl->tpl_vars['slider']->value["id"];?>
"><button class="btn btn-danger">Delete</button></a></td>
            </tr>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </tbody>
</table>
</div><?php }
}
