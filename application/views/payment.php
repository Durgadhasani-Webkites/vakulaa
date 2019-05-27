<div class="section-bg payment-bg">
    <div class="container">
        <div class="clearfix">&nbsp;</div>
        <div class="clearfix">&nbsp;</div>
        <div class="col-lg-8 col-xs-12 nopadding checkout-box body-content">
           <div class="panel-body payment-nopad">
            <div class="payment-box pt-col">
             <div class="col-md-11 col-xs-12 col-outer payment-nopad">
                <div class="amt-payment">
                    <table class="table-responsive" style="width:100%;">
                        <tr><td class="amt-title">Total Amount</td>
                            <td> <i class="fas fa-rupee-sign"></i>&nbsp; <?php echo number_format($net_total, 0); ?></td>
                        </tr>
                        <tr><td class="amt-title">Delivery Charges</td>
                           <?php
                        $grams = $total_grams;
                        $rate = $delivery_cost['rate'];
                        $grams_count = ceil($grams/500);
                        $delivery_rate = $grams_count * $rate;
                        ?>
                            <td class="green"> <i class="fas fa-rupee-sign"></i>&nbsp; <?php echo $delivery_rate ?></td>
                        </tr>
                        <?php
                        $net_total = $net_total + $delivery_rate;
                        ?>
                        <tr class="lstamt"><td class="amt-title"> <span>Amount Payable (incl. of all taxes)</span></td>
                            <td> <i class="fas fa-rupee-sign"></i>&nbsp; <?php echo number_format($net_total, 0); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="clearfix">&nbsp;</div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <center style="font-size:14px;">
                    <h2>Choose Payment Mode </h2> <br/>
                    <form  method="post" action="<?php echo base_url(); ?>payment">
                     <input type="radio" name="payment" value="1" checked="checked" id="onlinepay" style="position: unset;" /> <i class="fa fa-credit-card" aria-hidden="true"></i>
                     <label for="onlinepay" style="font-size: 17px;">Online Payment </label><br/>
                     <?php
                     if($codavailable!='0')
                     {

                       ?>
                       <div style="padding-top:20px;">
                        <input type="radio" name="payment" value="cod" id="cod" style="position: unset;"/> <i class="fa fa-money" aria-hidden="true"></i>
                        <label for="cod" style="font-size: 17px;">Cash on Delivery</label><br/>
                        <span style="font-size:14px;"> Note:Courier Provider will charge extra for COD service.<br/>You will be charged an extra fee of  Rs.60 <br/> </span>

                    </div>
                    <?php
                }
                ?>
                <br/>

                <b><span class="finaltotal" style="font-size: 15px;">TO PAY :  <?php echo number_format($net_total,0); ?></span></b>
                <br/>
        <div class="paybtn">
            <button type="submit" class="placeorder">PLACE ORDER</button>
        </div>
    </form>
    <img src="<?php echo $this->config->item('images'); ?>loader.gif" alt="logo" class="img-responsive" height="20" style="height:50px;display:none;" id="loadingimg"> 
</center>

<script type="text/javascript">
    $(document).ready(function(){
        $('#cod').click(function(){
            var final= <?php echo number_format($net_total,0);?>+60;
            $('.finaltotal').text('TO PAY :  '+final);
        });
        $('#onlinepay').click(function(){
            var final= <?php echo number_format($net_total,0);?>;
            $('.finaltotal').text('TO PAY :  '+final);
        });
    $('.placeorder').click(function(){
        $('#loadingimg').css("display", "block");
    });

});
</script>

<br/>
<br/>
</div>
</div>
</div>
</div>

<div class="col-lg-4 visible-lg">
    <div class="right-prolst pro-items">
        <div class="mycart">

            <div class="col-lg-9">
                <p>My Cart</p>
            </div>

            <div class="col-lg-3">
                <span><?php echo (isset($cart_total))?$cart_total:0; ?> items</span>
            </div>

        </div>
        <?php
        $total_price=0;
        $total_cart_items=0;
        foreach ($cart_details as $cart_row) {
         if($cart_row['option_id']==0){
            $product_image = $this->config->item('upload') .'products/'.$cart_row['product_thumb_image'];
        }else{
            $product_image = $this->config->item('upload') .'product_option_images/'.$cart_row['option_image'];
            if(empty($cart_row['option_image'])){
              $product_image = $this->config->item('upload') .'products/'.$cart_row['product_thumb_image'];  
          }
      } 
      ?>
      <div class="pro-box product-list ">

        <div class="col-lg-4">
           <img src="<?php echo $product_image; ?>" alt="<?php echo $cart_row['product_name']; ?>" class="img-responsive">
       </div>      
       <div class="col-lg-8">
        <h4><?php echo $cart_row['product_name']; ?></h4>
        <?php if($cart_row['option_name']!="") { ?>
            <p>Option: <?php echo $cart_row['option_name']; ?></p>
        <?php } 
        $price=$cart_row['option_price'];
        if($cart_row['option_id']==0){
            $price=$cart_row['product_price'];
        }

        $quantity=$cart_row['quantity'];
        $subtotal_price=$quantity*$price;
        ?>
        <div class="price-val">
          <h5><?php echo $quantity; ?> ⤫ <?php echo number_format($price, 0); ?></h5>
          <h5><i class="fas fa-rupee-sign"></i> <?php echo number_format($subtotal_price, 0); ?></h5>
          <!--  <span class="offr">20% OFF</span> -->
      </div>
  </div> 
</div>
<?php
}
?>
</div>
</div>
</div>
</div>
<div class="clearfix visible-xs">&nbsp;</div>
<div class="clearfix visible-xs">&nbsp;</div>
<div class="clearfix visible-xs">&nbsp;</div>
