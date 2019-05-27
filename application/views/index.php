<div class="story-sectionbg">
<div class="container">
    <section>
        <div class="col-lg-12">

           <div class="clearfix">&nbsp;</div>
           <div class="clearfix">&nbsp;</div>

           <div class="product-section">

            <div class="product-content">
                <p> Why us? <br>
                 <?php
                 if(!empty($contents)){
                    foreach($contents as $k=>$v){
                        if($v['slug']=='why-us'){
                            echo $v['page_content'];
                        }
                    }
                }
                ?>
            </p>
        </div>

        <div class="main-products">
            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 col-custom pro-col cupidly">
                <div class="product-img">
                    <?php
                    if (!empty($home_page_products['image1'])) {
                        ?>
                        <a href="<?php echo $home_page_products['link1'] ?>">
                            <img src="<?php echo $this->config->item('images');?>home_page_products/<?php echo $home_page_products['image1'] ?>" alt="products" class="img-responsive">
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </div>   

            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 col-custom pro-col">
                <div class="product-img">
                 <?php
                 if (!empty($home_page_products['image2'])) {
                    ?>
                    <a href="<?php echo $home_page_products['link2'] ?>">
                        <img src="<?php echo $this->config->item('images');?>home_page_products/<?php echo $home_page_products['image2'] ?>" alt="products" class="img-responsive">
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>   

        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 col-custom pro-col">
            <div class="product-img">
             <?php
             if (!empty($home_page_products['image3'])) {
                ?>
                <a href="<?php echo $home_page_products['link3'] ?>">
                    <img src="<?php echo $this->config->item('images');?>home_page_products/<?php echo $home_page_products['image3'] ?>" alt="products" class="img-responsive">
                </a>
                <?php
            }
            ?>
        </div>
    </div>   


    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 col-custom pro-col">
        <div class="product-img">
           <?php
           if (!empty($home_page_products['image4'])) {
            ?>
            <a href="<?php echo $home_page_products['link4'] ?>">
                <img src="<?php echo $this->config->item('images');?>home_page_products/<?php echo $home_page_products['image4'] ?>" alt="products" class="img-responsive">
            </a>
            <?php
        }
        ?>
    </div>
</div>  

<div class="line">
    <hr>
</div>

</div>


<div class="steps-section">

    <div class="col-lg-10 col-md-11 col-sm-12 col-xs-12 col-custom">

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 steps-col">
            <div class="steps-icon">
                <?php
                if (!empty($how_to_prepare['prepare_image1'])) {
                    ?>
                    <img src="<?php echo $this->config->item('images');?>how_to_prepare/<?php echo $how_to_prepare['prepare_image1'] ?>" alt="icon" class="img-responsive">
                    <div class="step-content">
                        <p><?php echo $how_to_prepare['title1'] ?>
                    </p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 steps-col">
        <div class="steps-icon">
           <?php
           if (!empty($how_to_prepare['prepare_image2'])) {
            ?>
            <img src="<?php echo $this->config->item('images');?>how_to_prepare/<?php echo $how_to_prepare['prepare_image2'] ?>" alt="icon" class="img-responsive">
            <div class="step-content">
                <p><?php echo $how_to_prepare['title2'] ?>
            </p>
        </div>
        <?php
    }
    ?>
</div>
</div>

<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 steps-col">
    <div class="steps-icon">
       <?php
       if (!empty($how_to_prepare['prepare_image3'])) {
        ?>
        <img src="<?php echo $this->config->item('images');?>how_to_prepare/<?php echo $how_to_prepare['prepare_image3'] ?>" alt="icon" class="img-responsive">
        <div class="step-content">
            <p><?php echo $how_to_prepare['title3'] ?>
        </p>
    </div>
    <?php
}
?>
</div>
</div>

<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 steps-col">
    <div class="steps-icon">
       <?php
       if (!empty($how_to_prepare['prepare_image4'])) {
        ?>
        <img src="<?php echo $this->config->item('images');?>how_to_prepare/<?php echo $how_to_prepare['prepare_image4'] ?>" alt="icon" class="img-responsive">
        <div class="step-content">
            <p><?php echo $how_to_prepare['title4'] ?>
        </p>
    </div>
    <?php
}
?>
</div>
</div>


</div>

</div>

<div class="clearfix hidden-xs">&nbsp;</div>


<div class="outer-table">
    <div class="inner-table"> 
        <div class="highlight-section">
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 col-custom">


                <div class="highlight-content">
                    <span class="greenline-top">
                        <img src="images/user/greenline-top.png" alt="greenline" class="img-responsive">
                    </span>  
                    <div class="hgt-content">     
                        <h2>Taste of south India:</h2>
                        <p>
                           <?php
                           if(!empty($contents)){
                            foreach($contents as $k=>$v){
                                if($v['slug']=='taste-of-south-india'){
                                    echo $v['page_content'];
                                }
                            }
                        }
                        ?>
                    </p>
                </div>          
                <span class="greenline-bottom">
                    <img src="images/user/greenline-bottom.png" alt="greenline" class="img-responsive">
                </span>  

            </div>

        </div>

    </div>
</div>


</div>

<div class="clearfix">&nbsp;</div>



<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 col-custom">
    <div class="info-content">
        <p> <?php
        if(!empty($contents)){
            foreach($contents as $k=>$v){
                if($v['slug']=='bottom-of-index-page'){
                    echo $v['page_content'];
                }
            }
        }
        ?></p>
    </div>
</div>

<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>

</div>
<!-- product section -->

</div>
<!-- col-lg-12 -->

</section>

</div>
</div>
