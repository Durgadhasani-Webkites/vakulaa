<div class="container">
    <?php if(!empty($page_details)){ ?>
    <h1><?php echo $page_details['page_title']; ?></h1>
    <p style="font-family: Helvetica Neue LT Std !important;"><?php echo $page_details['page_content']; ?></p>
    <?php } else{ ?>
      <div class="clearfix">&nbsp;</div>
        <div class="text-center">
            <!-- <h1>Opps! Page Not Found</h1><br/> -->
            <center>
             <img src="<?php echo $this->config->item('images'); ?>user/page-404-icon.png" height="320"
             class="img-responsive" /> 
             </center>
        </div>
     <!--  <center><button class="btn-upper btn btn-primary"><a href="<?php echo base_url(); ?>">Go back to website</a></button></center> -->
        <div class="clearfix">&nbsp;</div>
   <?php }?>
</div>