<div class="clearfix">&nbsp;</div>
<div class="container">
	<div class="row">
	 <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
	 <div class="shipping-steps hidden-sm hidden-xs">
        <ul class="shp-list">
          <li><span><i class="fas fa-shopping-basket"></i></span>&nbsp;Shopping Bag</li>
          <li><span><i class="fas fa-truck"></i></span>&nbsp;Shipping</li>
          <li><span><i class="fas fa-wallet "></i></span>&nbsp;Payment</li>
        </ul>
      </div>
    </div>
	<div class="product-btn col-lg-4 col-md-3 col-sm-3 col-xs-12">
		<a href="javascript:" class="place_order"><button type="button" class=" btn-now proceed-to-pay-btn">
			Proceed to Payment
		</button></a>
		<br>
		<span>confirm your order and pay securely</span>
	</div>
	</div>
	<div class="clearfix">&nbsp;</div>

	<div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
		<center>
			<h3>SELECT YOUR SHIPPING ADDRESS</h3>
		</center>
		<div class="clearfix">&nbsp;</div>
		<form id="shipping_addr_select_frm" method="post">
			<?php if(!empty($all_shipping_address)){
				foreach($all_shipping_address as $k=>$v){ ?>
					<div class="addr-box col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="address-box">
							<div class="radio radio-info">
								<input type="radio" name="shipping_address"  id="shipping_address_<?php echo $k; ?>" value="<?php echo $v['id']; ?>" <?php echo ($v['make_default']==1)?'checked="checked"':''; ?>>&nbsp;
								<label for="shipping_address_<?php echo $k; ?>"><?php echo $v['title']; ?></label>
							</div>
							<div class="col-lg-9 col-md-10 col-sm-10 col-xs-12 nopadding">
								<div class="address-content">
									<p><?php echo $v['contact_name']; ?><br>
										<?php echo $v['address']; ?>,<br>
										<?php echo $v['city']; ?>-<?php echo $v['pincode'];?><br>
										<?php echo $v['state']; ?><br>
										<?php echo $v['country']; ?><br>
									</p>
									<span>Mobile Number: <?php echo $v['contact_number']; ?></span><br/>
									<span>Email address: <?php echo $v['email_address']; ?></span>
								</div>
							</div>
							<div class="clearfix">&nbsp;</div>
							<div class="clearfix">&nbsp;</div>
							<div class="options-btm">
								<a href="javacript:" class="edit_shipping_addr" data-id="<?php echo $v['id']; ?>"><i class="fa fa-edit"></i> Edit</a>
								<a href="<?php echo base_url().'checkout/delete_shipping_addr/'.$v['id']; ?>" data-id="" class="trash-btn"><i class="fa fa-trash"></i>&nbsp;  Remove</a>
							</div>
						</div>
					</div>
					<?php if(($k+1)%2==0){ ?>
						<div class='clearfix mb10'>&nbsp;</div>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		</form>

		<div class="addr-box col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<a href="javascript:" class="new_shipping_addr">
				<div class="address-box new-box">
					<div class="new-addr">
						<i class="fas fa-map-marker-alt"></i>&nbsp;Add new address
					</div>
				</div>
			</a>
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
   <!--  <div class="total-amt">
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
<!-- container -->
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div id="shipping_modal" class=" themeModal modal fade text-left">
	<div class="modal-dialog">
		<div class="modal-content facility-sr-content" >
			<div class="modal-header shipping-modal-header">
				<button style="color:white" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title">New Shipping Address</h4>
			</div>
			<div class="modal-body padding10" style="overflow:hidden;">
				<?php include_once('shipping_form.php'); ?>
			</div>
		</div>
	</div>
</div>

<script>
	$(function(){

		// $(".geo_map").geocomplete({
		// 	details: ".geo-details",
		// 	detailsAttribute: "data-geo",
		// 	types: ["geocode"]
		// });

		var $shipping_validate={
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
			},
			submitHandler:function(form){
				var $form = $(form);
				$form.append('<input type="hidden" name="redirect_page" value="<?php echo base_url(); ?>checkout" />');
				$form[0].submit();
			}
		};
		$('#shipping_frm').validate($shipping_validate);

		$('.new_shipping_addr').click(function(){
			$.ajax({
				url:'<?php echo base_url(); ?>checkout/new_shipping_addr',
				type:'post',
				dataType:'html',
				success:function(res){
					$('#shipping_modal').find('.modal-title').html('New Shipping Address');
					$('#shipping_modal').find('.modal-body').html(res);
					$('#shipping_frm').validate($shipping_validate);
					$('#shipping_modal').modal('show');
				}
			});
		});
		$('.place_order').click(function(){

			$.ajax({
				url:'<?php echo base_url(); ?>checkout/place_order',
				type:'post',
				data:$('#shipping_addr_select_frm').serialize(),
				dataType:'json',
				success:function(res){
					if(res.success){
						window.location='<?php echo base_url(); ?>payment';
					}
				}
			});
		});

		$('.edit_shipping_addr').click(function(){
			var data={};
			data.id=$(this).data('id');
			$.ajax({
				url:'<?php echo base_url(); ?>checkout/edit_shipping_addr',
				type:'post',
				data:data,
				dataType:'html',
				success:function(res){
					$('#shipping_modal').find('.modal-title').html('Edit Shipping Address');
					$('#shipping_modal').find('.modal-body').html(res);
					$('#shipping_frm').validate($shipping_validate);
					$('#shipping_modal').modal('show');
				}
			});
		});

	});
</script>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>