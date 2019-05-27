<div class="section-bg shipping-bg">
  <div class="container">
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="shipping-steps hidden-sm hidden-xs">
      <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-custom">
        <ul class="shp-list">
          <li><span><i class="fas fa-shopping-basket"></i></span>&nbsp;Shopping Bag</li>
          <li><span><i class="fas fa-truck"></i></span>&nbsp;Shipping</li>
          <li><span><i class="fas fa-wallet "></i></span>&nbsp;Payment</li>
        </ul>
      </div>
    </div>
    <div class="clearfix">&nbsp;</div>
    <div class="shipping-outer">
     <div class="col-lg-11 col-md-12 col-sm-12 col-xs-12 col-custom">   
      <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 address-forms">
        <div class="form-box">
          <div class=" col-lg-12">
            <h3>Shipping Address</h3>
          </div>
          <form method="post" action="<?php echo base_url(); ?>checkout/process_shipping_addr" id="shipping_frm">
            <div class=" col-lg-6 ">
              <select name="title" class="form-control" id="title">
                <option value="">Title</option>
                <option value="home">Home</option>
                <option value="office">Office</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class=" col-lg-6  ">
              <input type="text" class="form-control" placeholder="Enter Your Name" name="contact_name">
            </div>
            <div class="col-lg-12 form">
              <textarea class="text-area w-input" maxlength="5000" name="address" placeholder="Address"></textarea>
            </div>
            <div class="form-group col-lg-12 ">          
              <input type="text" class="form-control" placeholder="Landmark (Optional)" name="landmark">
            </div>
            <div class=" col-lg-6 form-group">
              <input type="text" class="form-control" placeholder="Pincode" name="pincode">
            </div>
            <div class=" col-lg-6 form-group">
              <input type="text" class="form-control" placeholder="City" name="city">
            </div>
            <div class=" col-lg-6 form-group">
              <input type="text" class="form-control" placeholder="State" name="state">
            </div>
            <div class=" col-lg-6 form-group">
              <input type="text" class="form-control" placeholder="Country" name="country">
            </div>
            <div class=" col-lg-12 form-group">
              <input type="text" class="form-control" placeholder="Mobile Number" name="contact_number">
            </div>
            <div class="form-group col-lg-12 group">     
              <input type="text" class="form-control" placeholder="Enter Your Email Address" name="email_address">
            </div>
            <div class="form-check col-lg-12">
              <label class="form-check-label"><input name="make_default" type="checkbox" id="make_default" value="1"/>  Make this as default address</label>
            </div>
            <div class="col-lg-4 Continue">
              <button type="submit" class="btn-now">Continue</button>
            </div>
          </form>

        </div>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 order-now hidden-xs">
        <div class="order-bg">
          <h3>ORDER SUMMARY</h3>
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
          <div class="order-sum">
            <div class=" col-lg-4 col-md-5 col-sm-4 col-xs-4 no-padding">
              <div class="vakullaa">
               <img src="<?php echo $product_image; ?>" alt="<?php echo $cart_row['product_name']; ?>" class="img-responsive">
             </div>
           </div>
           <div class="col-lg-8 col-md-7 col-sm-8 col-xs-8">
            <div class="vakullaa-content">
             <p><?php echo $cart_row['product_name']; ?></p>
             <?php if($cart_row['option_name']!="") { ?>
              <p>Option: <?php echo $cart_row['option_name']; ?></p>
            <?php } 
            $price=$cart_row['option_price'];
            if($cart_row['option_id']==0){
              $price=$cart_row['product_price'];
            }

            $quantity=$cart_row['quantity'];
            $subtotal_price=$quantity*$price;
            $total_price+=$subtotal_price;
            ?>
            <h5><?php echo $quantity; ?> ⤫ <?php echo number_format($price, 0); ?></h5>
            <h5><i class="fas fa-rupee-sign"></i> <?php echo number_format($subtotal_price, 0); ?></h5>
          </div>
        </div>

      </div>
      <?php
    }
    ?>
<!--     <div class="total-amt">
      <table class="table-responsive">
        <tbody >
          <tr>
            <td>SUB TOTAL</td>
            <td class="price-rgt">Rs.<?php echo number_format($total_price, 0); ?></td>
          </tr>

        </tbody>
      </table>
    </div> -->

  </div>

</div>

</div>

</div>

</div>
</div>

<script type="text/javascript">
  $('#shipping_frm').validate({
    errorClass: "error-msg",
    ignore: [],
    errorElement:'div',
    rules: {
      title:{
        required:true
      },
      contact_name:{
        required:true
      },
      address:{
        required:true
      },
      pincode:{
        required: true,
        number:true,
        minlength:6,
        maxlength:6
      },
      city:{
        required: true,
      },
      state:{
        required: true,
      },
      country:{
        required: true,
      },
      email_address: {
        required: true,
        email:true
      },
      contact_number:{
        required:true,
        number:true,
        minlength:10,
        maxlength:10
      }
    }
  });
</script>