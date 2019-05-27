<div class="container">

<div class="flex-container product-tilethumb">
<?php 
      //  print_r($fiveblock);
        if(!empty($fourblock)){
            foreach($fourblock as $k=>$v){
                if($v['image_link']!='#'){
                    $v['image_link'] = prep_url($v['image_link']);
                }else{
                    $v['image_link'] = 'javascript:';
                }
                $fourblock[$v['sort_order']]=$v;
                ?>
 <div class="imgtile-prp productinner-thumb">
 <a href="<?php echo $v['image_link']; ?>">

            <img src="<?php echo $this->config->item('upload')?>/banners/<?php echo $v['image']?>" alt="small-thumb"></a>
        </div>
                <?php

            }
        }
       
        ?>    
        
</div>

  <div class="clearfix visible-lg">&nbsp;</div>
