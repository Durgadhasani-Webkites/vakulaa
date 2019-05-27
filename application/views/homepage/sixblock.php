
<div class="flex-container flex-smallthumb">

<?php 
      //  print_r($fiveblock);
        if(!empty($sixblock)){
            foreach($sixblock as $k=>$v){
                if($v['image_link']!='#'){
                    $v['image_link'] = prep_url($v['image_link']);
                }else{
                    $v['image_link'] = 'javascript:';
                }
                $sixblock[$v['sort_order']]=$v;
                ?>

           <div class="imgtile-prp thumb-small">
           <a href="<?php echo $v['image_link']; ?>">

        <img src="<?php echo $this->config->item('upload')?>/banners/<?php echo $v['image']?>" alt="small-thumb"></a>
    </div>
                <?php

            }
        }
       
        ?>  

</div>
</div>