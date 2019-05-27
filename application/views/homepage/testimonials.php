<center>
            <div class="offertext">
                <div class="brownbox">
                    &nbsp;
                </div>
                <div CLASS="offersbox">
                    <?php $home_heading_7 = (!empty($web_settings['home_heading_7']))?$web_settings['home_heading_7']:'Customer Testimonials';
                    $home_heading_7_arr = explode(' ',$home_heading_7);
                    $home_heading_7_text1 = strtoupper(array_shift(array_slice($home_heading_7_arr,0,1)));
                    $home_heading_7_text2 = strtoupper(implode(' ' ,(array_slice($home_heading_7_arr,1))));
                    ?>
                    <center class="font24 oswald"><span ><?php echo $home_heading_7_text1; ?>  </span> <span ><?php echo $home_heading_7_text2; ?></span></center>
                </div>
            </div>
        </center>

        <div class="testimonials slider">
            <?php
            if(!empty($testimonials))
            {
            foreach($testimonials as $k=>$v){
                ?>
                <div class="testimonialbox">
                      <div class="testicomment">
                          <?php echo $v['testimonial_content']; ?>
                       </div>
                    <div class="greenstrip">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="testiname">
                                <span class="tesipersonname"><?php echo $v['user_name']; ?></span> <br/>
                                <span class="testicityname"><?php echo $v['user_location']; ?></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                                <img src="<?php echo $this->config->item('upload'); ?>testimonial_images/<?php echo $v['testimonial_image']; ?>" alt="<?php echo $v['user_name']; ?>" title="<?php echo $v['user_name']; ?>" class="testinameimage">
                        </div>
                    </div>
                </div>
            <?php
            } }
            ?>
        </div>

    </div>
   
</div>
<div class="clearfix">&nbsp;</div>