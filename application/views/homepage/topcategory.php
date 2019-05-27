    <div class="container">
        <center>
            <div class="offertext">
                <div class="brownbox">
                    &nbsp;
                </div>
                <div CLASS="offersbox">
                    <?php $home_heading_3 = (!empty($web_settings['home_heading_3']))?$web_settings['home_heading_3']:'Top Categories';
                    $home_heading_3_arr = explode(' ',$home_heading_3);
                    $home_heading_3_text1 = strtoupper(array_shift(array_slice($home_heading_3_arr,0,1)));
                    $home_heading_3_text2 = strtoupper(implode(' ' ,(array_slice($home_heading_3_arr,1))));
                    ?>
                    <center class="font24 oswald"><span ><?php echo $home_heading_3_text1; ?> </span> <span><?php echo $home_heading_3_text2; ?> </span></center>
                </div>
            </div>
        </center>
        <div class="col-md-12 nopadding ">
            <div class="col-md-6 col-sm-6">
                <div class="img_zoom_in">
                <?php if(!empty($fixed_res['position3'])){
                    $image = "{$this->config->item('upload')}fixed_banner/{$fixed_res['position3']['image']}";
                    $image_name = $fixed_res['position3']['image_name'];
                    ?>
                <a href="<?php echo $fixed_res['position3']['image_link']; ?>"><img src="<?php echo $image; ?>" class="img-responsive center-block zm-img" alt="<?php echo $image_name; ?>" title="<?php echo $image_name; ?>"></a>
                <?php } ?>
            </div>
            </div>
            <div class="clearfix visible-xs">&nbsp;</div>
            <div class="col-md-6 col-sm-6">
                <div class="img_zoom_in">
                <?php if(!empty($fixed_res['position4'])){
                    $image = "{$this->config->item('upload')}fixed_banner/{$fixed_res['position4']['image']}";
                    $image_name = $fixed_res['position4']['image_name'];
                    ?>
                <a href="<?php echo $fixed_res['position4']['image_link']; ?>"><img src="<?php echo $image; ?>" class="img-responsive center-block zm-img" title="<?php echo $image_name; ?>" alt="<?php echo $image_name; ?>"></a>
                <div class="clearfix">&nbsp;</div>
                <?php } ?>
                 </div>
                 <div class="img_zoom_in">
                <?php if(!empty($fixed_res['position5'])){
                    $image = "{$this->config->item('upload')}fixed_banner/{$fixed_res['position5']['image']}";
                    $image_name = $fixed_res['position5']['image_name'];
                    ?>
                <a href="<?php echo $fixed_res['position5']['image_link']; ?>"><img src="<?php echo $image; ?>"  class="img-responsive center-block zm-img" alt="<?php echo $image_name; ?>" title="<?php echo $image_name; ?>"></a>
                <?php } ?>
            </div>
            </div>
        </div>    
    </div>
    <div class="clearfix">&nbsp;</div>  <div class="clearfix">&nbsp;</div>