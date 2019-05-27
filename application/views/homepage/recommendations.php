<center>
                <div class="offertext ">
                    <div class="morewidht1">
                        &nbsp;
                    </div>
                    <div CLASS="offersbox">
                        <?php $home_heading_5 = (!empty($web_settings['home_heading_5']))?$web_settings['home_heading_5']:'Best Offers';
                        $home_heading_5_arr = explode(' ',$home_heading_5);
                        $home_heading_5_text1 = strtoupper(array_shift(array_slice($home_heading_5_arr,0,1)));
                        $home_heading_5_text2 = strtoupper(implode(' ' ,(array_slice($home_heading_5_arr,1))));
                        ?>
                        <center class="font24 oswald"><span><?php echo $home_heading_5_text1; ?>  </span> <span ><?php echo $home_heading_5_text2; ?> </span></center>
                    </div>
                </div>
            </center>
        <div class="clearfix">&nbsp;</div>

        <div class="col-md-12 nopadding">
            <div class="col-md-4 col-sm-4 col-xs-12 text-center">
                <div class="img_zoom_in">
                <?php if(!empty($fixed_res['position6'])){
                    $image = "{$this->config->item('upload')}fixed_banner/{$fixed_res['position6']['image']}";
                    $image_name = $fixed_res['position6']['image_name'];
                    ?>
                <a href="<?php echo $fixed_res['position6']['image_link']; ?>"><img src="<?php echo $image; ?>" class="img-responsive center-block zm-img" title="<?php echo $image_name; ?>" alt="<?php echo $image_name; ?>"></a>
                <?php } ?>
            </div>
            </div>
            <div class="clearfix visible-xs">&nbsp;</div>
            <div class="col-md-4 col-sm-4 col-xs-12 text-center">
                <div class="img_zoom_in">
                <?php if(!empty($fixed_res['position7'])){
                    $image = "{$this->config->item('upload')}fixed_banner/{$fixed_res['position7']['image']}";
                    $image_name = $fixed_res['position7']['image_name'];
                    ?>
                <a href="<?php echo $fixed_res['position7']['image_link']; ?>"><img src="<?php echo $image; ?>" class="img-responsive center-block zm-img" alt="<?php echo $image_name; ?>" title="<?php echo $image_name; ?>"></a>
                <?php } ?>
            </div>
            </div>
            <div class="clearfix visible-xs">&nbsp;</div>
            <div class="col-md-4 col-sm-4 col-xs-12 text-center">
                <div class="img_zoom_in">
                <?php if(!empty($fixed_res['position8'])){
                    $image = "{$this->config->item('upload')}fixed_banner/{$fixed_res['position8']['image']}";
                    $image_name = $fixed_res['position8']['image_name'];
                    ?>
                <a href="<?php echo $fixed_res['position8']['image_link']; ?>"><img src="<?php echo $image; ?>" class="img-responsive center-block zm-img" alt="<?php echo $image_name; ?>" title="<?php echo $image_name; ?>"></a>
                <?php } ?>
            </div>
            </div>

        </div>
        <div class="clearfix">&nbsp;</div> <div class="clearfix">&nbsp;</div>