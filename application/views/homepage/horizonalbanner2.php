


    <?php if(!empty($fixed_res['position2'])){
        $image = "{$this->config->item('upload')}fixed_banner/{$fixed_res['position2']['image']}";
        $image_name = $fixed_res['position2']['image_name'];
        ?>
    <div class="clearfix">&nbsp;</div>
    <div class="container">
        <a href="<?php echo $fixed_res['position2']['image_link']; ?>"><img src="<?php echo $image; ?>" class="img-responsive" title="<?php echo $image_name; ?>" alt="<?php echo $image_name; ?>"></a>
    </div>
    <?php } ?>
    <div class="clearfix">&nbsp;</div><div class="clearfix">&nbsp;</div>