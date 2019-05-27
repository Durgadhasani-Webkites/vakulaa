<div class="connect-to">
    <a href="https://wa.me/+917339022047" title="Whatsapp Enquiry" class="slide-fwd-center">
        <img src="<?php echo $this->config->item('user_images'); ?>whatsapp-icon.png" alt="icon" class="img-responsive">
    </a>
</div>

<footer class="footer-box">
    <div class="container">
        <div class="bottom-section">
            <div class="col-lg-10 col-md-10 col-sm-9 col-xs-8">
                <div class="bike">
                    <img src="<?php echo $this->config->item('user_images'); ?>bikefooter.png" alt="delivery" class="img-responsive">
                </div>
            </div>
        </div>   
    </div>

    <div class="footer-bg">
        <div class="container">

            <div class="clearfix">&nbsp;</div>
            <div class="clearfix">&nbsp;</div>
            
            <div class="connect-to">
                <a href="https://wa.me/+917339022047" title="Whatsapp Enquiry" target="_blank">
                    <img src="<?php echo $this->config->item('user_images'); ?>whatsapp-icon.png" alt="icon" class="img-responsive">
                </a>
            </div>

            <div class="footerlink-box">
                <div class="footerlink-inner">
                    <span><img src="<?php echo $this->config->item('user_images'); ?>footer-linkup.png" alt="line" class="img-responsive"></span>
                    <ul class="footer-links">
                        <li><a href="<?php echo base_url(); ?>terms-and-conditions">TERMS AND CONDITIONS</a></li>
                        <li><a href="<?php echo base_url(); ?>privacy-policy">PRIVACY POLICY</a></li>
                        <li><a href="<?php echo base_url(); ?>clients">Clients</a></li>
                        <li><a href="<?php echo base_url(); ?>career">Career</a></li>
                        <li><a href="<?php echo base_url(); ?>disclaimer">DISCLAIMER</a></li>
                    </ul>

                </div> 

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 bottom-col nopadding">
                    <div class="copyright">
                        <p><i class="fas fa-copyright"></i>&nbsp; 2019 All Rights Reservered by Vakulaa</p>
                    </div>

                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 bottom-col nopadding">
                    <div class="poweredby">
                        <p>Powered by <a href="www.webkites.in"></a>Webkites.in</p>
                    </div>
                </div>

            </div> 

        </div>

    </div>
</footer>


<script src="<?php echo $this->config->item('user_js'); ?>jquery.simple.thumbchanger.js"></script>
<script src="<?php echo $this->config->item('user_js'); ?>jquery-ui.js"></script>
<script src="<?php echo $this->config->item('user_js'); ?>slick.min.js"></script>
<script src="<?php echo $this->config->item('user_js'); ?>jquery.fancybox.js"></script>
<script src="<?php echo $this->config->item('user_js'); ?>bootstrap.min.js"></script>


<script>
    $(document).ready(function () {
     $('#myCarousel').find('.item').first().addClass('active');
     $('#myCarousel').find('.dots').first().addClass('active');
 });

    $('.image-area').thumbchanger({
      mainImageArea: '.main-image',
      subImageArea:  '.sub-image',
      trigger:       'click',
      easing:        'linear',
      animateTime:   300,
      fixHeight:     true,
      onload: true
  });

// $(document).ready(function(){
//   $('.nav-menu li a span').click(function(){
//     $('.nav-menu li a span').removeClass("active");
//     $(this).addClass("active");
// });
// });
jQuery(document).ready(function(){
    // This button will increment the value
    $('[data-quantity="plus"]').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('data-field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('input[name='+fieldName+']').val(currentVal + 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
    // This button will decrement the value till 0
    $('[data-quantity="minus"]').click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('data-field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 1) {
            // Decrement one
            $('input[name='+fieldName+']').val(currentVal - 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(1);
        }
    });
});


$('.dropdown-selmenu a').on('click', function(){    
    $('.dropdown-toggle').html($(this).html() + '<span class="caret"></span>');    
})

</script>
</body>
</html>