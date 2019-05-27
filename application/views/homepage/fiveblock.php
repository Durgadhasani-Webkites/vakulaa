<div class="container">
        
   <div class="product-tile">
        <?php 
      // print_r($fiveblock);
        if(!empty($fiveblock)){
            foreach($fiveblock as $k=>$v){
                if($v['image_link']!='#'){
                    $v['image_link'] = prep_url($v['image_link']);
                }else{
                    $v['image_link'] = 'javascript:';
                }
                $fivesection[$v['sort_order']]=$v;
            }
        }
       // print_r($fivesection);
        ?>
        <div class="col-lg-12 nopadding">
               <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="col-lg-12 nopadding">
                        <div class="img_zoom_in">
                        <a href="<?php echo $fivesection['1']['image_link']; ?>">
                        <img src="<?php echo $this->config->item('upload')?>/banners/<?php echo $fivesection['1']['image'] ?>" alt="tile-img"   style="width:100%;" class="zm-img">
                        </a>
                    </div>
                    </div>
                </div>   

                <div class="col-lg-6 col-md-6 col-sm-6 nopadding rightsectblock">
                    <div class="row mainpartbannerbox">
                        <div class="col-lg-6  col-xs-6">
                            <div class="img_zoom_in">
                        <a href="<?php echo $fivesection['2']['image_link']; ?>">
                    <img src="<?php echo $this->config->item('upload')?>/banners/<?php echo $fivesection['2']['image'] ?>" alt="tile-img" class="img-responsive zm-img">
                    </a>
                    </div>
                        </div>   
                        <div class="col-lg-6 col-xs-6">
                            <div class="img_zoom_in">
                        <a href="<?php echo $fivesection['3']['image_link']; ?>">
                    <img src="<?php echo $this->config->item('upload')?>/banners/<?php echo $fivesection['3']['image'] ?>" alt="tile-img" class="img-responsive zm-img">
                    </a>
                    </div>
                        </div>  
                    </div>
                    
                    <div class="row mainpartbannerbox">
                        <div class="col-lg-6 col-xs-6">
                            <div class="img_zoom_in">
                        <a href="<?php echo $fivesection['4']['image_link']; ?>">
                    <img src="<?php echo $this->config->item('upload')?>/banners/<?php echo $fivesection['4']['image'] ?>" alt="tile-img" class="img-responsive zm-img">
                    </a>
                    </div>
                        </div>   
                        <div class="col-lg-6 col-xs-6">
                            <div class="img_zoom_in">
                        <a href="<?php echo $fivesection['5']['image_link']; ?>">
                    <img src="<?php echo $this->config->item('upload')?>/banners/<?php echo $fivesection['5']['image'] ?>" alt="tile-img" class="img-responsive zm-img">
                    </a>
                    </div>
                        </div>  
                    </div>           
                </div>   
        </div>


      

                
            </div>
        </div>

    </div>

<div class="clearfix">&nbsp;</div>
