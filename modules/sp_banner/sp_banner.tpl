<section class="sp_banner_slider">
     <h1>Hi</h1>
     {$module_name}
    <h2 class="sp_banner_title">{$module_name}</h2>
<div class="sp_container">
    <div class="sp_wrapper">
        {foreach $sliders as $slider}
            <div class="sp_card one">
                    <div class="sp_image">
                        <a href="{$slider["path"]}"><img src="/prestashop/shashop/modules/sp_banner/image/{$slider["image_name"]}"/></a>
                    </div>
                    <div class="sp_description 1">
                        <h5>{$slider["slider_name"]}</h5>
                    </div>
            </div>
        {/foreach}
    </div>
</div>
</section>