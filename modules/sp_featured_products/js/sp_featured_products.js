
$(document).ready(function(){
    var productDataUrl = '/prestashop/shashop/modules/sp_featured_products/ajaxcall.php?q=';
    $("#products").select2({
        multiple:true,
        ajax: {

            url: productDataUrl,

            dataType: 'json',
            
            processResults: function (response) {
                return {

                    results: response

                };

            }
        }
    });
    jQuery("#products").trigger('change'); 

    $("#submit").click(function(){
        
    });

});