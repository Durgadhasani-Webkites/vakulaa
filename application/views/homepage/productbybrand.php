     

        <center>
            <div class="offertext">
                <div class="brownbox">
                    &nbsp;
                </div>
                <div CLASS="offersbox">
                    <?php $home_heading_6 = (!empty($web_settings['home_heading_6']))?$web_settings['home_heading_6']:'Products By Brand';
                    $home_heading_6_arr = explode(' ',$home_heading_6);
                    $home_heading_6_text1 = strtoupper(array_shift(array_slice($home_heading_6_arr,0,1)));
                    $home_heading_6_text2 = strtoupper(implode(' ' ,(array_slice($home_heading_6_arr,1))));
                    ?>
                    <center class="font24 oswald"><span ><?php echo $home_heading_6_text1; ?>  </span> <span ><?php echo $home_heading_6_text2; ?></span></center>
                </div>
            </div>
        </center>
        <div class="slider brand-slider">
            <?php
            if(!empty($brands))
            {
                foreach($brands as $k=>$v){
                ?>
                <a href="<?php echo base_url().$v['slug']; ?>">
                    <div class="logobox">
                        <center>
                            <?php if(!empty($v['brand_image'])){ ?>
                                <img src="<?php echo $this->config->item('upload'); ?>brands/<?php echo $v['brand_image']; ?>" alt="<?php echo $v['brand_name']; ?>" title="<?php echo $v['brand_name']; ?>">
                            <?php }else{ ?>
                                <span><?php echo $v['brand_name'] ;?></span>
                            <?php } ?>
                        </center>
                    </div>
                </a>
            <?php }
            }
            ?>
        </div>
        <div class="clearfix">&nbsp;</div> <div class="clearfix">&nbsp;</div>