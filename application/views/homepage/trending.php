<?php if(!empty($latest_products)){ ?>
    <div class="container">
        <center>
            <div class="offertext">
                <div class="brownbox">
                    &nbsp;
                </div>
                <div CLASS="offersbox">
                    <?php $home_heading_1 = (!empty($web_settings['home_heading_1']))?$web_settings['home_heading_1']:'Latest Offers';
                    $home_heading_1_arr = explode(' ',$home_heading_1);
                    $home_heading_1_text1 = strtoupper(array_shift(array_slice($home_heading_1_arr,0,1)));
                    $home_heading_1_text2 = strtoupper(implode(' ' ,(array_slice($home_heading_1_arr,1))));
                    ?>
                    <center class="font24 oswald"><span class=""><?php echo $home_heading_1_text1; ?> </span> <span class=""><?php echo $home_heading_1_text2; ?></span></center>
                </div>
            </div>
        </center>
        <div class="col-md-12 col-sm-12 col-xs-12 nopadding ">
            <br>
            <div class="responsive slider trending-product" style="background-color: #ffd154;">

                <div class="product_box smart">
                    <center>
                        <p class="title">INTRODUCING</p>
                        <img src="<?php echo base_url();?>/images/smart.png" class="img-responsive">
                        <br>
                            <p class="title">Start shopping at 
                            wholesale prices!</p>
                            <p class="btn btn-default become_club_member_btn">Become Club Member</p>
                    </center>
                </div>

                <?php
                $upload = $this->config->item('upload');
                foreach($latest_products as $k=>$v){
                    $product_image = $upload.'products/'.$v['product_thumb_image'];
                    ?>



                    <div class="product_box">

                        <div class="product_place col-sm-12 col-xs-12">
                            <?php
                    // print_r($v);
                            if(!empty($v['product_options'])){ 

                               foreach($v['product_options'] as $k1=>$v1){
                                   if($v1['default_option']=='1')
                                   {
                                    $selling_price = $v1['selling_price'];
                                    $actual_price = $v1['actual_price']; 
                                    if($actual_price!=0)
                                    {
                                        $precentageset="yes";
                                        $discountedprice=$actual_price-$selling_price;
                                   // echo $discountedprice;
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

                            $product_price = $v['product_price']; 
                            $actual_price =$v['actual_price_single']; 
                            if( $actual_price!=0)
                            {
                                $precentageset="yes";
                                $discountedprice=$actual_price-$product_price;
                                $finalpercentage= ($discountedprice/$actual_price)*100;
                           // echo $finalpercentage;
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
                            <div class="offerboxpercentage">
                                <?php  echo round($finalpercentage);?>% OFF 
                            </div>
                            <?php
                        }
                        ?>
                        <?php //include_once('priceoffer.php');?>

                        <a href="<?php echo base_url(); ?>product/<?php echo $v['slug'];?>-<?php echo $v['product_id'];?>">

                            <img src="<?php echo $product_image;?>" class="img-responsive" alt="<?php echo $v['product_name'];?>" title="<?php echo $v['product_name'];?>"/>
                        </a>
                    </div>
                    <div class="trending">
                    <div class="product_det col-sm-12 col-xs-12 nopadding">
                        <p class="title"> <a href="<?php echo base_url(); ?>product/<?php echo $v['slug'];?>-<?php echo $v['product_id'];?>"><?php echo $v['product_name'];?></a></p>
                        <?php if(!empty($v['product_options'])){ ?>
                            <select class="wide product_opt_select">
                                <?php  foreach($v['product_options'] as $k1=>$v1){
                                    $selling_price = $v1['selling_price'];
                                    $option_img = $upload.'product_option_images/'.$v1['product_option_thumb_images'];
                                    if(empty($v1['product_option_thumb_images'])){
                                        $option_img = $product_image;
                                    }
                                    ?>
                                    <option value="<?php echo $v1['option_id']; ?>" data-optimage="<?php echo $option_img; ?>" <?php echo ($v1['default_option']==1)?'selected="selected"':''; ?> ><?php echo $v1['option_value_name']; ?> - Rs <?php echo $selling_price; ?></option>
                                <?php } ?>
                            </select>
                        <?php  } else{
                            $product_price = $v['product_price'];
                            ?>
                            <div style='height:33px;' class="text-center">Rs. <?php echo $product_price; ?></div>
                        <?php  }?>
                        <div class="clearfix visible-xs">&nbsp;</div>
                        <div class="samedaydeli hidden-xs">
                            <i class="fa fa-truck center_icon" aria-hidden="true"></i> Same day delivery in Chennai
                        </div>

                        <div  class="col-md-12 nopadding">
                            <div  class="col-md-4 col-sm-4 col-xs-3 qtybox nopadding">
                                &nbsp; Qty
                                <input type="number" min="1" value="1" class="inputnumberingbox quntitytnumberbox"/>
                                        <!-- <select class="qty no-niceSelect">
                                            <?php for($j=1;$j<=12;$j++){ ?>
                                                <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
                                            <?php } ?>
                                        </select> -->
                                    </div>
                                    <div  class="col-md-8  col-sm-8 col-xs-7 nopadding pull-right">
                                        <a href="javascript:" data-pid="<?php echo $v['product_id'];?>" class="buy_btt pull-right"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> &nbsp; Add  <span class="hidden-xs">to cart</span></a>
                                    </div>
                                </div>
                               
                            </div>
                        </div>

                        </div>



                        <?php
                    }
                    ?>
                </div>


            </div>
        </div>
    <?php } ?>

    <div class="clearfix">&nbsp;</div>