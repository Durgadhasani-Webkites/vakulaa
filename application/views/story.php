<section class="story story-sectionbg">
    <div class="container">
        <div class="clearfix">&nbsp;</div>
        <div class="clearfix">&nbsp;</div>
        <div class="clearfix">&nbsp;</div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 story-col">
           <div class="col-lg-12">
               <div class="story-page">
                   <p> <?php
                   if(!empty($contents)){
                    foreach($contents as $k=>$v){
                        if($v['slug']=='story'){
                            echo $v['page_content'];
                        }
                    }
                }
                ?>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<div class="story-bg" >
</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<!-- section-bg -->
</section>

