<div class="section-bg">
<?php
if(!empty($products)){
    include_once('product_listing_ajax.php');
}else{ ?>
    <div class="clearfix">&nbsp;</div>
    <div class="col-lg-12 text-center">
     <h4><img src="<?php echo $this->config->item('user_images'); ?>nothing-found.png" height="30"/>  No Products Found</h4>
     <p>Sorry, nothing matched with your search terms. Please try again with some other keyword.</p>
 </div>
 <div style="height:100%;">&nbsp;</div>
<?php } ?>

<div>
    <input type="hidden" id="total_products" value="<?php echo (isset($total_products))?$total_products:0; ?>"/>
    <input type="hidden" id="start" />
</div>

<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
</div>
<script type="text/javascript">

    $(document).ready(function() {

        $('.optionsforfilter .filterlist li').each(function(){
            $(this).attr('data-search-term', $(this).find('label').text().toLowerCase());
        });

        $('.optionsforfilter .categorylist li').each(function(){
            $(this).attr('data-search-term', $(this).find('a').text().toLowerCase());
        });

        $('.optionsforfilter input').on('keyup', function(){
            var searchTerm = $(this).val().toLowerCase();
            $(this).closest('.optionsforfilter').find('.filterlist li').each(function(){
                if ($(this).filter('[data-search-term *= ' + searchTerm + ']').length > 0 || searchTerm.length < 1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            $(this).closest('.optionsforfilter').find('.categorylist li').each(function(){
                if ($(this).filter('[data-search-term *= ' + searchTerm + ']').length > 0 || searchTerm.length < 1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        if($('.filterbox').is(':hidden')){
            $('.filterbox').removeClass('filters-desktop')
        }

        var limit = 6;
        $('.filters-desktop .filteropt').change(function(){
            $('#start').val(limit);
            ajaxsubmit();
        });

        $('.applyfilter').click(function(){
            $('#start').val(limit);
            ajaxsubmit();
            $('.filterbox').hide();
        });

        $('#sortFilterRadio').click(function(){
            $('#start').val(limit);
            ajaxsubmit();
        });

        $('#sortFilterSelect').change(function(){
            $('#start').val(limit);
            ajaxsubmit();
        });

        $('#start').val(limit);
        window.processing=true;
        var totalProd=<?php echo (!empty($total_products))?$total_products:0; ?>;
        $(window).scroll(function(){
            if (!window.processing){
                return false;
            }
            if(!$('.filterbox').hasClass('filters-desktop') && $('.filterbox').is(':visible')){
                window.processing=false;
                return false;
            }
            if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.5){
                var filterData = $("#filter_frm").serialize();
                var $productListingBox=$('.productlisting_box');
                var start = parseInt($("#start").val());
                var $search_term='';
                if($('#search_term').length > 0 && ($('#search_term').val()!='')){
                    $search_term = $('#search_term').val()
                }
                var productlisting_box=$('#productlisting_box');
                var sort_by =$('#sortFilterSelect').find('option:selected').val();
                $productListingBox.find('.noproducts').remove();
                if(totalProd<=start){
                    $productListingBox.append('<div class="clearfix">&nbsp;</div><p class="noproducts" style="text-align: center">That\'s all Folks!</p>');
                    window.processing=false;
                    return false;
                }

                var loader_image='<?php echo base_url(); ?>images/user/dotted_loader.gif';
                // alert(loader_image);
                var loader_image='<img class="loader_image" src="'+loader_image+'" height="50" style="display:block;margin: 0 auto;" />';
                $productListingBox.find('.loader_image').remove();
                $productListingBox.append(loader_image);
                $.ajax({
                    url: '<?php  echo base_url(); ?>product/product_ajax',
                    type: 'post',
                    data: filterData+'&start='+start+'&sort_by='+sort_by+'&search_term='+$search_term,
                    dataType:'json',
                    beforeSend:function(){
                        window.processing=false;
                    },
                    success: function (response) {
                        $productListingBox.find('.loader_image').remove();
                        if(response.html!='') {
                            start=start+limit;
                            $('#start').val(start);

                            $productListingBox.append(response.html);
                            var $product_opt_select = $('.productlisting_box').find('.product_opt_select');
                            $product_opt_select.siblings('.nice-select').remove();
                            $product_opt_select.niceSelect();
                            window.processing=true;
                        }

                    }, complete: function(){
                        window.processing=true;
                    }
                })
            }
        });
    });


   function ajaxsubmit() {
    var $this=$(this),$productListingBox=$('.productlisting_box');
    if($('.soryparticularmobile').is(':visible')) {
        var sort_by =$('.mobilesort').filter(':checked').val();
        $('.gobacks').trigger('click');
    }else{
        var sort_by =$('#sortFilterSelect').find('option:selected').val();
    }
    var loader_image=base_url.replace('index.php/','')+'images/user/dotted_loader.gif';
    var loader_image='<img class="loader_image" src="'+loader_image+'" height="50" style="display:block;margin: 0 auto;"/>';
    var $search_term='';
    if($('#search_term').length > 0 && ($('#search_term').val()!='')){
        $search_term = $('#search_term').val()
    }
    $productListingBox.find('.loader_image').remove();
    $productListingBox.append(loader_image);
    $.ajax({
        url: '<?php echo base_url(); ?>product/product_ajax',
        type: 'post',
        data: $('#filter_frm').serialize()+'&sort_by='+sort_by+'&search_term='+$search_term,
        dataType:'json',
        success: function (response) {
            var $total_products=$('#total_products');
            $productListingBox.find('.loader_image').remove();
            if(response.html!=''){
                $productListingBox.html(response.html);
                var $product_opt_select = $('.productlisting_box').find('.product_opt_select');
                $product_opt_select.siblings('.nice-select').remove();
                $product_opt_select.niceSelect();
                if(response.hasOwnProperty('prod_count')){
                    window.processing=true;
                    $total_products.val(response.prod_count);
                    $('.productCount').html(response.prod_count);
                }

            }else{
                $productListingBox.html('<p>No products found</p>');
                $total_products.val(response.prod_count);
            }
        }
    });
}
</script>
<style>

.input-group .form-control:first-child {
    border-bottom-right-radius: 0;
    border-top-right-radius: 0;
}
.custom-search-form input {
    border-radius: 0;
    height: 25px;
    box-shadow: none;
}
.custom-search-form .btn{
    height:25px;
    padding:0 12px;
}
.optionsforfilter .filterlist{
    min-height: 30px;
    max-height: 150px;
    overflow-y: scroll;
    margin-top: 5px;
}
.optionsforfilter .categorylist{
    min-height: 30px;
    max-height: 500px;
    overflow-y: scroll;
    margin-top: 5px;
}
.nice-select.qty{
    line-height: 28px;
}

</style>

