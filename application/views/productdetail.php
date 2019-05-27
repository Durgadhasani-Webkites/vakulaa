<script type="text/javascript">
    $(document).ready(function() {
        if ($(window).innerWidth() > 767) {
            $("#zoom_01").elevateZoom({
                gallery: 'gallery_1',
                cursor: 'pointer',
                responsive: true,
                galleryActiveClass: 'active',
                imageCrossfade: true,
                loadingIcon: '<?php echo $this->config->item('user_images'); ?>spinner.gif'
            });
        }
    });
</script>
<section>
    <div class="section-bg detail-bg">
        <div class="container">

            <div class="clearfix">&nbsp;</div>
            <div class="clearfix">&nbsp;</div>
            <div class="clearfix">&nbsp;</div>
           <!--  <div class="product_option_img_cont">
                
           </div> -->
           <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_detail['id']; ?>" />
           
           <div class="productdt-outer">
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 productimg-box">
                <div class="image-area">
                    <div class="mainimg-box product_det">
                      <div class="product_option_img_cont">
                        <?php include_once('product_option_images.php'); ?>
                    </div>
                    <?php
                    if(!empty($product_options)){ 
                     foreach($product_options as $k1=>$v1){
                         if($v1['default_option']=='1')
                         {
                            $selling_price = $v1['selling_price'];
                            $actual_price = $v1['actual_price']; 
                            if($actual_price!=0)
                            {
                                $precentageset="yes";
                                $discountedprice=$actual_price-$selling_price;
                                $finalpercentage= ($discountedprice/$actual_price)*100;
                            }
                            else
                            {
                                $precentageset="no";
                            }
                            break;
                        }
                    }
                }
                else
                {
                    $product_price = $product_detail['price']; 
                    $actual_price =$product_detail['actual_price_single']; 

                    if( $actual_price!=0)
                    {
                        $precentageset="yes";
                        $discountedprice=$actual_price-$product_price;
                        $finalpercentage= ($discountedprice/$actual_price)*100;
                    }
                    else
                    {
                        $precentageset="no";
                    }
                }
                ?>
                <?php
                if($precentageset=='yes')
                {
                    ?>
                    <center>
                        <div class="offerboxpercentageinner">
                            <?php  echo 'OFFER - '.round($finalpercentage);?>% OFF 
                        </div>
                    </center>

                    <?php
                }
                ?>

                <div class="detail-imgcont">
                    <?php if(!empty($product_options)){ ?>
                        <div class="spec" id="product_option_id">
                            <?php
                            foreach($product_options as $k=>$v){
                                if ($v['default_option'] == 1) {
                                    $default_selling_price = $v['selling_price'];
                                    $default_actual_price = $v['actual_price'];
                                }
                                ?>
                                <input type="radio" class="spec product_option" name="spec" id="spec_<?php echo $v['option_id']; ?>" value="<?php echo $v['option_id']; ?>" <?php echo ($v['default_option']==1)?'checked="checked"':(($k==0)?'checked="checked"':''); ?>>  <label for="spec_<?php echo $v['option_id']; ?>"><?php echo $v['option_value_name']; ?></label> <br/>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <center>
                        <div class="pricesection">
                            <?php if(!empty($product_options)){
                                $default_selling_price = (!empty($default_selling_price))?$default_selling_price:$product_options[0]['selling_price'];
                                $default_actual_price = (!empty($default_actual_price))?$default_actual_price:$product_options[0]['actual_price'];
                                ?>
                                <br/>

                                <?php if($default_actual_price>0){ ?>
                                    <p class="strikeprice price-padding">
                                        <strike> 
                                            <span style="padding: 0;"><i class="fas fa-rupee-sign"></i> <?php echo $default_actual_price; ?></span>
                                        </strike>
                                    </p>
                                <?php } ?>
                                <p class="currentprice price-padding">
                                    <span style="padding: 0;"><i class="fas fa-rupee-sign"></i> <?php echo $default_selling_price; ?></span>
                                </p>
                            <?php }else{
                                $price = $product_detail['price'];
                                ?>
                                <p class="currentprice"> <i class="fas fa-rupee-sign"></i> <p><?php echo $price; ?></p></p>
                            <?php } ?>
                        </div>
                    </center>
                    <div class="quantity">
                        <div class="input-group plus-minus-input">
                            <div class="input-group-button">
                                <button type="button" class="button hollow circle" data-quantity="minus" data-field="quantity">
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </button>
                            </div>
                            <input class="input-group-field" type="number" name="quantity" id="quantity" value="1">
                            <div class="input-group-button">
                                <button type="button" class="button hollow circle" data-quantity="plus" data-field="quantity">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                   <!--  <div class="pincode">
                        <span>Check Delivery in Your Area</span>
                        <p id="pincodeCheck" style="font-size: 18px;"></p>
                        <div class="formgroup">
                            <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="6" placeholder="Enter Pincode" name="pincode" id="pincode" required="true" onChange="pincode_empty()">

                            <button class="submit-btn" type="submit" onClick="callAjaxFunction()">Check</button>
                            <br>
                            <center>

                                <span id="pincodeMsg"></span>
                            </center>

                        </div>
                    </div> -->


                    <div class="clearfix">&nbsp;</div>
                    <input type="hidden" name="pid" id="pid" value="<?php echo $product_detail['id']; ?>">
                    <a onclick="buy_now()" style="cursor: pointer;">
                        <span class="buynow-btn buynowyellow-img">
                            Buy Now
                        </span>
                    </a>
                        <a onclick="pincode()" style="cursor: pointer;">
                            <span class="buynow-btn buynowyellow-img">
                               Add to Cart
                           </span>
                       </a>

                   </div>
               </div>

           </div>

           <div class="clearfix">&nbsp;</div>

       </div>

       <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
          <div class="detail-content">
            <h4><?php echo $product_detail['product_name']; ?></h4>

                   <!--  <p>Space Idli Dry</p>
                    <p>Idli Wet </p> -->
                    <?php if(!empty($product_detail['what_is_it'])){ ?>
                        <div class="detail-description">
                            <h4><?php echo $product_detail['detailpage_heading1']; ?></h4>
                            <p><?php echo $product_detail['what_is_it']; ?></p>
                        </div>
                    <?php  } ?>
                    
                    <?php if(!empty($product_detail['what_is_contains'])){ ?>
                        <div class="ingredients">
                            <h4><?php echo $product_detail['detailpage_heading2']; ?></h4>
                            <p><?php echo $product_detail['what_is_contains']; ?></p>
                        </div>
                    <?php  } ?>
                    <?php if(!empty($specification)){ ?>
                        <div class="nutrition-table">
                            <h4>  Nutrition Information : </h4>
                            <table class="table-responsive">
                                <thead colspan="4">
                                    <th colspan="1"></th>
                                    <th>Avg Qty Per Serving</th>
                                    <th >Avg. Qty Per 100g</th>
                                </thead>
                                <tbody >
                                    <?php
                                    foreach($specification as $k=>$v){
                                        $nutrition_information = explode('-&-',$v);
                                        $nutrition_name = $nutrition_information[0];
                                        $nutrition_details = $nutrition_information[1];
                                        $nutrition_qty = explode('|',$nutrition_details);
                                        $avg_qty_per_serving = $nutrition_qty[0];
                                        $avg_qty_per_100g = $nutrition_qty[1];
                                        ?>
                                        <tr>
                                            <td><?php echo $nutrition_name ?></td>
                                            <td><?php echo $avg_qty_per_serving ?></td>
                                            <td><?php echo $avg_qty_per_100g ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php  } ?>
                    <?php if(!empty($product_detail['how_to_prepare'])){ ?>
                        <div class="prepare-food">
                           <h4><?php echo $product_detail['detailpage_heading3']; ?></h4>
                           <p><?php echo $product_detail['how_to_prepare']; ?></p>
                       </div>
                   <?php  } ?>
               </div>

           </div>

       </div>

   </div>
   <!-- container -->
</div>
<!-- section-bg -->
</section>

<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<script type="text/javascript">
    flag = true;
    function callAjaxFunction(){
        var pincode =  $('#pincode').val();
        if (pincode != '') {
            $.ajax({
                url:'<?php echo site_url('product/pincode_check'); ?>',
                data: {pincode: pincode},
                dataType: "json",
                type:'POST',
                success:function(data){
                    $('#pincodeCheck').html("");
                    $("#pincodeMsg").css("color", "green");
                    $('#pincodeMsg').html(data);
                    flag = false;
                },
                error: function() {
                    $("#pincodeMsg").css("color", "red");
                    $('#pincodeMsg').html("Sorry won't delivery to your area");
                }
            }); 
        }else{
            $("#pincode").focus();
            $("#pincodeMsg").css("color", "red");
            $('#pincodeMsg').html("Please enter your area pincode");
        }
    }

    function pincode(){
    //  if (flag) {
    //      $("#pincodeCheck").focus();
    //      $("#pincodeCheck").css("color", "red");
    //      $('#pincodeCheck').html("Please check your area pincode");

    // }else{
        var pid = $('#pid').val();
        var qty= $('#quantity').val();
        var selectedOpt = "";
        var selected = $("#product_option_id input[type='radio']:checked");
        if (selected.length > 0) {
            selectedOpt = selected.val();
        }
        $.ajax({
            url:'<?php echo site_url('cart/add_to_cart'); ?>',
            type:'post',
            data:'pid='+pid+'&qty='+qty+'&selectedOpt='+selectedOpt,
            dataType:'json',
            success:function(response){
                if(response.error){
                    $("body").overhang({
                        type : "error",
                        message: response.error
                    });
                }
                if(response.success){
                    $("body").overhang({
                        type : "success",
                        message: response.success
                    });
                    $('.cart_count,.cart_count_xs').html(response.cart_total);
                }
            }
        });
    // }
}


 function buy_now(){
    //  if (flag) {
    //     // callAjaxFunction();
    //      $("#pincodeCheck").focus();
    //      $("#pincodeCheck").css("color", "red");
    //      $('#pincodeCheck').html("Please check your area pincode");

    // }else{
        var pid = $('#pid').val();
        var qty= $('#quantity').val();
        var selectedOpt = "";
        var selected = $("#product_option_id input[type='radio']:checked");
        if (selected.length > 0) {
            selectedOpt = selected.val();
        }
        $.ajax({
            url:'<?php echo site_url('cart/add_to_cart'); ?>',
            type:'post',
            data:'pid='+pid+'&qty='+qty+'&selectedOpt='+selectedOpt,
            dataType:'json',
            success:function(response){
                if(response.error){
                    $("body").overhang({
                        type : "error",
                        message: response.error
                    });
                }
                if(response.success){
                     window.location.href = "<?php echo site_url('cart/view'); ?>";
                    $('.cart_count,.cart_count_xs').html(response.cart_total);
                }
            }
        });
    // }
}

function pincode_empty(){
    var pincode =  $('#pincode').val();
    if (pincode == '') {
        flag = true;
    }
}
function pincode_success(){
 if (!flag) {
    pincode();

}
}

$(document).ready(function() {

    $('.product_option').change(function(){
        var val = $('.product_option').filter(':checked').val();
        $.ajax({
            url:'<?php echo base_url(); ?>product/get_option_details',
            type:'post',
            data:'option_id='+val+'&product_id='+$('#product_id').val(),
            dataType:'json',
            success:function(response){
                $('.pricesection').find('.currentprice span').html('<i class="fas fa-rupee-sign"></i> '+response.selling_price);
                $('.pricesection').find('.strikeprice span').html('<i class="fas fa-rupee-sign"></i> '+response.actual_price);
                $('.product_option_img_cont').html(response.product_images);
                if(response.hasOwnProperty('offer_list')){
                    $('.product_offers').html(response.offer_list);
                }else{
                    $('.product_offers').html('');
                }
                $('.product_option_img_cont').find("#zoom_01").elevateZoom({
                    gallery:'gallery_1',
                    cursor: 'pointer',
                    galleryActiveClass: 'active',
                    imageCrossfade: true,
                    loadingIcon: '<?php echo $this->config->item('user_images'); ?>spinner.gif'
                });
            }
        });
    });
});
</script>