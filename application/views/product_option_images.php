<?php if(!empty($product_options)){
    if(isset($product_options[0])){
        foreach($product_options as $k=>$v){
            if($v['default_option']==1){
                $product_option_images_folder = $this->config->item('upload').'product_option_images/';
                if(!empty($v['product_option_images'])){
                    $product_option_images = $product_option_images_folder.$v['product_option_images'];
                    $product_option_images_arr = explode('__&&__',$product_option_images);
                    $product_image_zoom=$product_option_images_arr[0];
                }
                if(!empty($v['product_option_medium_images'])) {
                    $product_option_medium_images = $product_option_images_folder . $v['product_option_medium_images'];
                    $product_option_medium_images_arr = explode('__&&__', $product_option_medium_images);
                    $product_image_src = $product_option_medium_images_arr[0];
                }
            }
        }
    }else{
        $product_option_images_folder = $this->config->item('upload').'product_option_images/';
        if(!empty($product_options['product_option_images'])) {
            $product_option_images = $product_option_images_folder . $product_options['product_option_images'];
            $product_option_images_arr = explode('__&&__', $product_option_images);
            $product_image_zoom = $product_option_images_arr[0];
        }
        if(!empty($product_options['product_option_medium_images'])) {
            $product_option_medium_images = $product_option_images_folder . $product_options['product_option_medium_images'];
            $product_option_medium_images_arr = explode('__&&__', $product_option_medium_images);
            $product_image_src = $product_option_medium_images_arr[0];
        }
    }
}
if(!isset($product_image_src)){
    $product_folder = $this->config->item('upload').'products/';
    if(!empty($product_images)){
        $product_image_src = $product_folder.$product_images[0]['medium_image'];
    }else{
        $product_image_src=$product_folder.$product_detail['product_medium_image'];
    }
}
if(!isset($product_image_zoom)) {
    $product_folder = $this->config->item('upload').'products/';
    if(!empty($product_images)){
        $product_image_zoom = $product_folder.$product_images[0]['image'];
    }else{
        $product_image_zoom=$product_folder.$product_detail['product_image'];
    }
}
$image_name = pathinfo($product_image_src, PATHINFO_FILENAME);
?>
<div class="product_zoom" style="text-align: center;">
    <div style="position:relative;display: inline-block;">
    <img id="zoom_01" src='<?php echo $product_image_src; ?>' data-zoom-image="<?php echo $product_image_zoom; ?>" alt="<?php echo $image_name; ?>" class="img-responsive" title="<?php echo $image_name; ?>"/>
    </div>
</div>
<div id="gallery_1">
<?php if(!empty($product_options)){
    if(isset($product_options[0])){
        foreach($product_options as $k=>$v){
            if($v['default_option']==1){
                $product_option_images_folder = $this->config->item('upload').'product_option_images/';
                if(!empty($v['product_option_thumb_images'])){
                    $product_option_thumb_images = $v['product_option_thumb_images'];
                    $product_option_thumb_images_arr = explode('__&&__',$product_option_thumb_images);
                }

                if(!empty($v['product_option_medium_images'])) {
                    $product_option_medium_images = $v['product_option_medium_images'];
                    $product_option_medium_images_arr = explode('__&&__', $product_option_medium_images);
                }

                if(!empty($v['product_option_images'])) {
                    $product_option_images = $v['product_option_images'];
                    $product_option_images_arr = explode('__&&__', $product_option_images);
                }

            }
        }
    }else{
        $product_option_images_folder = $this->config->item('upload').'product_option_images/';
        if(!empty($product_options['product_option_thumb_images'])) {
            $product_option_thumb_images = $product_options['product_option_thumb_images'];
            $product_option_thumb_images_arr = explode('__&&__', $product_option_thumb_images);
        }
        if(!empty($product_options['product_option_medium_images'])) {
            $product_option_medium_images = $product_options['product_option_medium_images'];
            $product_option_medium_images_arr = explode('__&&__', $product_option_medium_images);
        }

        if(!empty($product_options['product_option_images'])) {
            $product_option_images = $product_options['product_option_images'];
            $product_option_images_arr = explode('__&&__', $product_option_images);
        }
    }

    if(!empty($product_option_thumb_images_arr) && !empty($product_option_medium_images_arr) && !empty($product_option_images_arr)) {

        foreach ($product_option_thumb_images_arr as $k1 => $v1) {
            ?>
            <a href="#" data-image="<?php echo $product_option_images_folder.$product_option_medium_images_arr[$k1]; ?>"
               data-zoom-image="<?php echo $product_option_images_folder.$product_option_images_arr[$k1]; ?>">
                <img id="zoom_01" src="<?php echo $product_option_images_folder.$v1; ?>" height="70"/>
            </a>
        <?php
        }
    }

} else{
if(!empty($product_images)){
    foreach($product_images as $k=>$v){
        $product_folder = $this->config->item('upload').'products/';
        ?>
        <a href="#" data-image="<?php echo $product_folder.$v['medium_image']; ?>"
           data-zoom-image="<?php echo $product_folder.$v['image']; ?>">
            <img id="zoom_01" src="<?php echo $product_folder.$v['thumb_image']; ?>" height="70"/>
        </a>
<?php
    }
}
}?>
</div>