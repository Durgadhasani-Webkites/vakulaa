<section>
    <div>
        <div class="container">
            <div class="product-section">
               <div class="row">
                   <?php
                   if(!empty($products)){
                    $upload = $this->config->item('upload');
                    foreach($products as $k=>$v) {
                        $product_url = base_url().'product/'.$v['slug'].'-'.$v['product_id'];
                        $product_image = $upload.'products/'.$v['product_thumb_image'];

                        foreach($v['product_options'] as $k1=>$v1) {
                            $selling_price = $v1['selling_price'];
                            if (!empty($v1['product_option_thumb_images']) && ($v1['default_option']==1)) {
                                $product_option_thumb_images_arr = explode('__&&__',$v1['product_option_thumb_images']);
                                $product_image = $upload . 'product_option_images/' . $product_option_thumb_images_arr[0];
                            }
                        }
                        ?>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 productbox-col" style="margin-top: 50px;">
                          <?php
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
                                    $finalpercentage= ($discountedprice/$actual_price)*100;
                                }
                                else
                                {
                                    $precentageset="no";
                                }
                                    // break;

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
                       <!--  <div>
                            <?php  echo round($finalpercentage);?>% OFF 
                        </div> -->
                        <?php
                    }
                    ?>
                    <div class="product-box">
                        <div class="product-img">
                            <a href="<?php echo $product_url; ?>">
                                <img  src="<?php echo $product_image; ?>" class="img-responsive" alt="<?php echo $v['product_name'];?>" title="<?php echo $v['product_name'];?>"/>
                            </a>
                        </div>
                        <div class="productpage-content">
                            <h4><?php echo $v['product_name'];?></h4>
                            <?php if(!empty($v['product_options'])){ ?>
                                <center>
                                <select class="form-control" style="width: auto">
                                    <?php  foreach($v['product_options'] as $k1=>$v1){
                                        $selling_price = $v1['selling_price'];
                                        $product_option_thumb_images_arr = explode('__&&__',$v1['product_option_thumb_images']);
                                        $option_img = $upload.'product_option_images/'.$product_option_thumb_images_arr[0];
                                        if(empty($v1['product_option_thumb_images'])){
                                            $option_img = $product_image;
                                        }
                                        ?>
                                        <option value="<?php echo $v1['option_id']; ?>" data-optimage="<?php echo $option_img; ?>" <?php echo ($v1['default_option']==1)?'selected="selected"':''; ?>><?php echo $v1['option_value_name']; ?> - Rs <?php echo $selling_price; ?></option>
                                    <?php } ?>
                                </select>
                                </center>
                            <?php  }else{
                                $product_price = $v['product_price'];
                                ?>
                                <p><i class="fas fa-rupee-sign"></i> <?php echo $product_price; ?></p>
                            <?php } ?>     
                             <a href="<?php echo $product_url; ?>">
                                <span class="buynow-btn buynowyellow-img">
                                    View Details
                                </span>
                            </a>
                        </div>
                    </div>    
                </div>

                <?php
            }
        }
        ?>

    </div>   
</div>
</div>
</div>
</section>
<div class="clearfix visible-xs">&nbsp;</div>
<div class="clearfix visible-xs">&nbsp;</div>
<div class="clearfix visible-xs">&nbsp;</div>
