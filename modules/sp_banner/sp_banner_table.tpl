<link rel="stylesheet" 
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
       {foreach $getslider as $slider}
            <tr class="table-success" >
                <td>{$slider["id"]}</td>
                <td>{$slider["id_shop"]}</td>
                <td>{$slider["id_lang"]}</td>
                <td>{$slider["image_name"]}</td>
                <td>{$slider["slider_name"]}</td>
                <td>{$slider["path"]}</td>
                <td>{$slider["status"]}</td>
                <td>{$slider["positions"]}</td>
                <td>
                    <a href="{$link->getAdminLink('AdminModules')}&configure=sp_banner&id={$slider['id']}">
                    <button class="btn btn-info">Edit</button></a>
                </td>
                <td><a href="{$link->getAdminLink('AdminModules')}&configure=sp_banner&delete_id={$slider['id']}"><button class="btn btn-danger">Delete</button></a></td>
            </tr>
        {/foreach}
    </tbody>
</table>
</div>