<div class="section-bg cart-bg">
	<div class="container">
		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">&nbsp;</div>
		<div style="width:100%;"><?php echo $this->session->flashdata('cart_message') ?></div>
		<div class="col-lg-12 nopadding cart-box">
			<center><h2>My Cart</h2></center>
			<div class="cart-section">


				<div class="cart-heading">
					<h2>Your Cart <span>( <?php echo (isset($cart_total))?$cart_total:0; ?> items )</span></h2>
				</div>
				<?php if(isset($cart_details) && !empty($cart_details)) { ?>
					<table  style="border:0; width:100%;">
						<tbody>
							<tr class="heading-row">
								<th scope="col" class="col-lg-7">Description</th>
								<th scope="col" class="col-lg-1 right-heading hidden-xs">Price</th>
								<th scope="col" class="col-lg-1 right-heading">Quantity</th>
								<th scope="col" class="col-lg-1 right-heading">Total</th>
							</tr>
							<?php
							$total_price=0;
							$total_cart_items=0;
							foreach ($cart_details as $cart_row) {
								$product_url = base_url().'product/'.$cart_row['slug'].'-'.$cart_row['product_id'];
								?>
								<tr class="td-rw" data-cid="<?php echo $cart_row['id']; ?>" data-proid="<?php echo $cart_row['product_id']; ?>" data-option_id="<?php echo $cart_row['option_id']; ?>">
									<td style="padding:10px 5px;">

										<div class="col-lg-1 col-md-2 col-sm-2 col-xs-4 nopadding cartthumb-xsl">
											<div class="thumb-box">
												<div class="cart-thumb">
													<?php
													if($cart_row['option_id']==0){
														$product_image = $this->config->item('upload') .'products/'.$cart_row['product_thumb_image'];
													}else{
														$product_image = $this->config->item('upload') .'product_option_images/'.$cart_row['option_image'];
														if(empty($cart_row['option_image'])){
															$product_image = $this->config->item('upload') .'products/'.$cart_row['product_thumb_image'];  
														}
													} ?>
													<a href="<?php echo $product_url; ?>"><img src="<?php echo $product_image; ?>" alt="<?php echo $cart_row['product_name']; ?>" title="<?php echo $cart_row['product_name']; ?>" class="img-responsive" /></a>

												</div>
											</div>	
										</div>
										<div class="col-lg-11 col-md-10 col-sm-10 col-xs-8 procart-col">
											<div class="product-details">
												<a href="<?php echo $product_url; ?>"><?php echo $cart_row['product_name']; ?></a>
												<?php if($cart_row['option_code']!="") { ?>
													<p>Option Code: <?php echo $cart_row['option_code']; ?></p>
												<?php }else{ ?>
													<p>Product Code : <?php echo (!empty($cart_row['product_code']))?$cart_row['product_code']:'NA'; ?></p>
												<?php } ?>
												<?php if($cart_row['option_name']!="") { ?>
													<p>Option: <?php echo $cart_row['option_name']; ?></p>
												<?php } ?>
												<?php if($cart_row['coupon_applied_id']!=0) {
													$coupon_code = $cart_row['coupon_code'];
													$coupon_applied_id= $cart_row['coupon_applied_id'];
													?>
													<p>Coupon applied: <?php echo $coupon_code; ?></p>
												<?php } ?>
												<?php if(!empty($cart_row['cart_offer_prod'])){
													foreach($cart_row['cart_offer_prod'] as $k1=>$v1){?>
														<p class="promo-sec">Promo applied: <?php echo $v1['offer_product_name'];  ?> <?php echo (!empty($v1['offer_option_name']))?'-'.$v1['offer_option_name']:'';  ?></p>
													<?php }  }?>   

												</div>
											</div>

										</td>
										<td class="td-details  hidden-xs">
											<?php
											$price=$cart_row['option_price'];
											if($cart_row['option_id']==0){
												$price=$cart_row['product_price'];
											}

											$quantity=$cart_row['quantity'];
											$subtotal_price=$quantity*$price;
											?>
											<i class="fas fa-rupee-sign"></i>&nbsp;<?php echo number_format($price, 2); ?>
											<?php if($cart_row['option_name']!="") { ?><p>&nbsp;</p><?php } ?>
											<?php if(!empty($cart_row['cart_offer_prod'])){
												foreach($cart_row['cart_offer_prod'] as $k1=>$v1){?>
													<p class="promo-sec"><?php echo 'Free'; ?></p>
												<?php } } ?>
											</td>
											<td class="commn-tbinfo">
												<div class="quantity">
													<button class="minus-btn" type="button" name="button">
														<i class="fa fa-angle-down"></i>
													</button>
													<input type="text" name="name" value="<?php echo $quantity; ?>">
													<button class="plus-btn" type="button" name="button">
														<i class="fa fa-angle-up"></i>
													</button>
													<?php if(!empty($cart_row['cart_offer_prod'])){
														foreach($cart_row['cart_offer_prod'] as $k1=>$v1){?>
															<p class="offer_qty promo-sec"><?php echo $v1['offer_product_qty']; ?></p>
														<?php } } ?>
													</div>

												</td>
												<td class="td-details">

													<?php if($cart_row['coupon_applied_id']!=0) { ?><del>
														<i class="fas fa-rupee-sign"></i>&nbsp;<?php echo number_format($subtotal_price, 2); ?></del>
														<br>
													<?php }  else {?>
														<i class="fas fa-rupee-sign"></i>&nbsp;<?php echo number_format($subtotal_price, 2); ?>
													<?php } ?>

													<?php if($cart_row['coupon_applied_id']!=0) {
														$subtotal_price =  $subtotal_price-$cart_row['coupon_discount'];
														?>
														<i class="fas fa-rupee-sign"></i>&nbsp;<?php echo number_format($subtotal_price,2); ?>
													<?php } ?>
													<?php if(!empty($cart_row['cart_offer_prod'])){
														foreach($cart_row['cart_offer_prod'] as $k1=>$v1){?>
															<p class="promo-sec"><?php echo 'Free'; ?></p>
														<?php } } ?>

														<span class="trash-cart"><a href="<?php echo base_url('cart/delete/'.$cart_row['id']); ?>" class="delete" title="Click to delete" ><i class="fa fa-trash-alt"></i></a></span>
													</td>
												</tr>

												<?php
												$total_price+=$subtotal_price;
												$total_cart_items++;
											} ?>
											<tr>
												<td colspan="2" class="bottm-valtb">
													<p><?php echo (isset($cart_total))?$cart_total:0; ?> products in your cart</p></td>
													<td class="hidden-xs">&nbsp;</td>

													<td colspan="5" class="tt-amt"><span>Net Amount:&nbsp;<i class="fas fa-rupee-sign"></i>&nbsp;<?php echo number_format($total_price, 2); ?></span></td></tr>
													<tr>

														<td colspan="5" >
															<div class="col-lg-12 text-right coupon-bttn">
																<?php if(isset($coupon_code) && isset($coupon_applied_id)) { ?>
																	<div class="coupon-cd">
																	<span class="label label-success" style="font-size:18px;"><?php echo $coupon_code; ?></span>
																	<a href="<?php echo base_url(); ?>cart/remove_coupon/<?php echo $coupon_applied_id; ?>"> remove</a>
																</div>

															<?php } else{ ?>
																Have an coupon?
																<input type="text" name="evoucher" class="evoucher" placeholder="Enter coupon code">
																<button type="button" class="btn-coupon" id="apply_coupon">APPLY</button>
															<?php } ?> 
														</div>
													</td>
												</tr>
											</tbody>
										</table>

										<div class="col-lg-6 cartbt-col">
											<div class="cartbtm-bttns">
												<a href="<?php echo base_url(); ?>"><i class="fa fa-chevron-left"></i>&nbsp; Continue Shopping</a>
												<a href="<?php echo base_url(); ?>user/signin" style="background-color:white;padding: 0"><button type="button" class="btn-back">Checkout&nbsp; <i class="fa fa-shopping-cart"></i></button></a>
											</div>
										</div>
									<?php } else { ?>
										<div class="col-lg-12 nopadding emptycart">
											<div class="col-lg-12" style="margin: 5px 15px;font-size: 17px;">Your cart is currently empty</div>
											<div class="cartbtm-bttns" style="float: left;margin: 20px;">
												<a href="<?php echo base_url(); ?>"><i class="fa fa-chevron-left"></i>&nbsp; Continue Shopping</a>
											</div>
										</div>
									<?php } ?>

								</div>
							</div>
						</div>
					</div>


<script type="text/javascript">
//quantity button//

$('.minus-btn').on('click', function(e) {
	e.preventDefault();
	var $this = $(this);
	var $input = $this.closest('div').find('input');
	var value = parseInt($input.val());
	var cid  = $this.closest('tr').attr('data-cid');
	var proid = $this.closest('tr').attr('data-proid');
	var option_id = $this.closest('tr').attr('data-option_id');

	if (value > 1) {
		value = value - 1;
	} else {
		value = 1;
	}
	update_cart($this,cid,proid,option_id,value);

});

$('.plus-btn').on('click', function(e) {
	e.preventDefault();
	var $this = $(this);
	var $input = $this.closest('div').find('input');
	var value = parseInt($input.val());
	var cid  = $this.closest('tr').attr('data-cid');
	var proid = $this.closest('tr').attr('data-proid');
	var option_id = $this.closest('tr').attr('data-option_id');

	if (value < 100) {
		value = value + 1;
	} else {
		value =100;
	}
	update_cart($this,cid,proid,option_id,value);
});

function update_cart($this,cid,proid,option_id,value){
	$.ajax({
		type: "POST",
		url: "<?php echo base_url(); ?>" + "cart/update",
		data: {'cartid': cid, 'cartqty': value, 'proid': proid,'option_id':option_id},
		dataType:'json',
		success: function(result) {
			if(result.error){
				$("body").overhang({
					type : "error",
					message: result.error
				});
			}
			if(result.success){
				window.location.reload();
			}
		}
	});
}

$(document).ready(function() {

	$('.delete').click(function(){
		var href = $(this).attr('href');
		$("body").overhang({
			type: "confirm",
			primary: "#40D47E",
			accent: "#27AE60",
			yesColor: "#3498DB",
			message: "Are you sure to delete?",
			overlay: true,
			callback: function (value) {
				var response = value ? "Yes" : "No";
				if(response=='Yes'){
					window.location = href;
				}
			}
		});
		return false;
	});

	$('#apply_coupon').click(function(){
		var evoucher = $('.evoucher').val();
		if(evoucher==''){
			$("body").overhang({
				type : "error",
				message: 'Coupon should not be empty!'
			});
		}else{
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "cart/apply_coupon",
				data: {'coupon': evoucher},
				dataType:'json',
				success: function(result) {
					if(result.coupon_error){
						$("body").overhang({
							type : "error",
							message: result.coupon_error
						});
					}
					if(result.coupon_success){
						window.location.reload();
					}
				}
			});
		}
	});

});

function checkForInvalid(obj) {
	obj.value = obj.value.replace(/[^0-9\-]|(-{2,})/gi, (RegExp.$1.indexOf("-") > -1) ? "-" : "");
}
</script>
<div class="clearfix visible-xs">&nbsp;</div>
<div class="clearfix visible-xs">&nbsp;</div>