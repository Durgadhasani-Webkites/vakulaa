<center>
    <div class="offertext">
        <div class="brownbox">
            &nbsp;
        </div>
        <div CLASS="offersbox">
            <?php $home_heading_8 = (!empty($web_settings['home_heading_8']))?$web_settings['home_heading_8']:'Products By Brand';
            $home_heading_8_arr = explode(' ',$home_heading_8);
            $home_heading_8_text1 = strtoupper(array_shift(array_slice($home_heading_8_arr,0,1)));
            $home_heading_8_text2 = strtoupper(implode(' ' ,(array_slice($home_heading_8_arr,1))));
            ?>
            <center class="font24 oswald"><span ><?php echo $home_heading_8_text1; ?>  </span> <span ><?php echo $home_heading_8_text2; ?></span></center>
        </div>
    </div>
</center>
<div class="slider blog-slider">
    <?php
    if(!empty($blogs))
    {
        foreach($blogs as $k=>$v){
            ?>
            <a href="<?php echo $v['image_link']; ?>">
                <div class="blog_banner">
                    <div class="img_zoom_in">
                        <center>
                            <?php if(!empty($v['image'])){ ?>
                                <img src="<?php echo $this->config->item('upload'); ?>blogs/<?php echo $v['image']; ?>" class="img-responsive zm-img blog-img" alt="<?php echo $v['title']; ?>"  title="<?php echo $v['title']; ?>">
                                <div class="blog_title">
                                    <h4 class="blog_font"><?php echo $v['title'] ?></h4></div>
                                <?php }else{ ?>
                                    <span><?php echo $v['title'] ;?></span>
                                <?php } ?>
                            </center>
                        </div>
                    </div>
                </a>
            <?php }
        }
        ?>
    </div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>