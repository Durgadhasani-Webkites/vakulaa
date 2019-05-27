
<div class="container nopadding">
    <div class="col-lg-3 nopadding noslidebanner visible-lg">
        <?php if(!empty($fixed_banners)){
            foreach($fixed_banners as $k=>$v){
                if($v['image_link']!='#'){
                    $v['image_link'] = prep_url($v['image_link']);
                }else{
                    $v['image_link'] = 'javascript:';
                }
                $fixed_res[$v['banner_position']]=$v;
            }
        }
        ?>
        <div class="bannerslide">
            <?php if(!empty($blogs)){
                foreach($blogs as $k=>$v){
                    $image_link='javascript:';
                    if($v['image_link']!='#'){
                        $image_link = prep_url($v['image_link']);
                    }
                    $image = "{$this->config->item('upload')}blogs/{$v['image']}";
                    $title = $v['title'];
                    ?>
                    <div class="blog_banner">

                    <a href="<?php echo $image_link; ?>"><img src="<?php echo $image; ?>" title="<?php echo $title; ?>" class="img-responsive" alt="<?php echo $title; ?>"></a>
                    <div class="blog_title">
                    <h3 class="blog_font"><?php echo $title ?></h3></div>
                </div>

            <?php }  } ?>
        </div>
    </div>
    <div class="col-lg-9 col-md-12 nopadding">
        <div class="bannerslide">
            <?php if(!empty($banners)){
                foreach($banners as $k=>$v){
                    $image_link='javascript:';
                    if($v['image_link']!='#'){
                        $image_link = prep_url($v['image_link']);
                    }
                    $image = "{$this->config->item('upload')}banners/{$v['image']}";
                    $image_name = $v['image_name'];
                    ?>
                    <div>
                        <a href="<?php echo $image_link; ?>"><img src="<?php echo $image; ?>" title="<?php echo $image_name; ?>" alt="<?php echo $image_name; ?>"></a>
                    </div>
                <?php }  } ?>
            </div>

        </div>
        <div class="clearfix hidden-xs">&nbsp;</div>