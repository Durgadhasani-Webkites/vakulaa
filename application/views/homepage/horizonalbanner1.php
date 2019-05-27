
    <div class="container hidden-sm hidden-xs">
       
    	<?php 
        if(!empty($harizontal_banner)){
        	?>
        <a href="<?php echo $harizontal_banner[0]['image_link']; ?>">
        <img src="<?php echo $this->config->item('upload')?>/banners/<?php echo $harizontal_banner[0]['image']?>" alt="<?php echo $harizontal_banner[0]['image_name']; ?>" title="<?php echo $harizontal_banner[0]['image_name']; ?>" class="img-responsive">
       </a>
         <?php
         }
        ?> 
   
    </div>

        <div class="clearfix">&nbsp;</div>  <div class="clearfix">&nbsp;</div>
